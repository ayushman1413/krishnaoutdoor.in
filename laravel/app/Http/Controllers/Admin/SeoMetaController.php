<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\SeoMeta;
use App\Models\SeoMetaRevision;
use App\Services\ImageOptimizer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use League\Csv\Reader;
use League\Csv\Writer;

class SeoMetaController extends Controller
{
    private const REVISIONED_FIELDS = [
        'meta_title', 'meta_description', 'meta_keywords', 'focus_keyword',
        'skip_title_template', 'canonical_url', 'robots_index', 'robots_follow', 'h1_override',
        'og_title', 'og_description', 'og_type',
        'twitter_title', 'twitter_description',
        'schema_json', 'page_copy',
    ];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    private function deny(string $permission)
    {
        $admin = Admin::find(auth()->user()->id);
        if (!$admin->can($permission)) {
            return redirect()->back()->with('message', [
                'status' => 'warning',
                'title' => 'Unauthorized Access',
                'description' => 'You do not have access to this url'
            ]);
        }
        return null;
    }

    private function fail(Exception $e)
    {
        return redirect()->back()->with('message', [
            'status' => 'error',
            'title' => 'An error occcured',
            'description' => $e->getMessage()
        ]);
    }

    private function notFound()
    {
        return redirect()->back()->with('message', [
            'status' => 'warning',
            'title' => 'SEO Meta not found',
            'description' => 'SEO Meta not found with specified ID'
        ]);
    }

    private function rules(): array
    {
        return [
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'focus_keyword' => ['nullable', 'string', 'max:100'],
            'canonical_url' => ['nullable', 'string', 'max:500'],
            'h1_override' => ['nullable', 'string', 'max:150'],
            'page_copy' => ['nullable', 'string', 'max:20000'],
            'og_title' => ['nullable', 'string'],
            'og_description' => ['nullable', 'string'],
            'og_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
            'og_type' => ['nullable', 'in:website,article'],
            'twitter_card' => ['nullable', 'string'],
            'twitter_title' => ['nullable', 'string'],
            'twitter_description' => ['nullable', 'string'],
            'twitter_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
            'schema_json' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && $value !== '' && json_decode($value) === null) {
                        $fail('Schema JSON must be valid JSON');
                    }
                }
            ],
        ];
    }

    private function fill(SeoMeta $meta, Request $request): void
    {
        $meta->meta_title = $request->input('meta_title');
        $meta->skip_title_template = $request->boolean('skip_title_template');
        $meta->meta_description = $request->input('meta_description');
        $meta->meta_keywords = $request->input('meta_keywords');
        $meta->focus_keyword = $request->input('focus_keyword');
        $meta->canonical_url = $request->input('canonical_url');
        $meta->robots_index = $request->boolean('robots_index');
        $meta->robots_follow = $request->boolean('robots_follow');
        // Headings carry no stray emphasis markers or trailing full stop.
        $h1 = rtrim(trim(str_replace('*', '', (string) $request->input('h1_override'))), ". \t");
        $meta->h1_override = $h1 !== '' ? $h1 : null;
        $meta->page_copy = $request->input('page_copy') ?: null;
        $meta->og_title = $request->input('og_title');
        $meta->og_description = $request->input('og_description');
        $meta->og_type = $request->input('og_type') ?: 'website';
        $meta->twitter_card = $request->input('twitter_card') ?: 'summary_large_image';
        $meta->twitter_title = $request->input('twitter_title');
        $meta->twitter_description = $request->input('twitter_description');
        $meta->schema_json = $request->input('schema_json');
        $meta->exclude_from_sitemap = $request->boolean('exclude_from_sitemap');

        if ($request->hasFile('og_image')) {
            if ($meta->og_image)
                Storage::delete($meta->og_image);
            $meta->og_image = ImageOptimizer::store($request->file('og_image'), 'seo', 'og-' . Str::random(12));
        }

        if ($request->hasFile('twitter_image')) {
            if ($meta->twitter_image)
                Storage::delete($meta->twitter_image);
            $meta->twitter_image = ImageOptimizer::store($request->file('twitter_image'), 'seo', 'twitter-' . Str::random(12));
        }
    }

    public function viewSeoList(Request $request): mixed
    {
        try {
            if ($r = $this->deny(Permission::VIEW_SEO->value)) return $r;

            $group = $request->query('group', 'pages');

            if ($group === 'categories') {
                $metas = SeoMeta::where('seoable_type', Category::class)->with('seoable')->get();
            } elseif ($group === 'campaigns') {
                $metas = SeoMeta::where('seoable_type', \App\Models\Campaign::class)->with('seoable')->get();
            } elseif ($group === 'locations') {
                // Locations have no individual detail page — only /locations/{city} —
                // so SEO is keyed per city (SeoResolver::routeNameForCity), not per
                // Location model.
                $metas = SeoMeta::where('route_name', 'like', 'view.locations.city.%')
                    ->orderBy('route_name')
                    ->get();
            } else {
                $group = 'pages';
                $metas = SeoMeta::whereNotNull('route_name')
                    ->where('route_name', 'not like', 'view.locations.city.%')
                    ->orderBy('route_name')
                    ->get();
            }

            return view('admin.pages.seo.seo-list', [
                'metas' => $metas,
                'group' => $group
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function viewSeoUpdate($id): mixed
    {
        try {
            if ($r = $this->deny(Permission::EDIT_SEO->value)) return $r;

            $meta = SeoMeta::find($id);
            if (!$meta) return $this->notFound();

            $revisions = SeoMetaRevision::where('seo_meta_id', $meta->id)
                ->with('admin')
                ->latest()
                ->get();

            return view('admin.pages.seo.seo-update', ['meta' => $meta, 'revisions' => $revisions]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    /**
     * Best-effort public URL for a SeoMeta row, used by export/import to
     * match rows back up by URL (per the PDF §9 import template).
     */
    private function resolveUrl(SeoMeta $meta): string
    {
        if ($meta->route_name && str_starts_with($meta->route_name, 'view.locations.city.')) {
            $citySlug = substr($meta->route_name, strlen('view.locations.city.'));
            return url('/locations/' . $citySlug);
        }

        if ($meta->route_name && \Illuminate\Support\Facades\Route::has($meta->route_name)) {
            return route($meta->route_name, [], true) ?: url('/');
        }

        if ($meta->seoable_type === Category::class && $meta->seoable) {
            return url('/' . $meta->seoable->slug);
        }

        if ($meta->seoable_type === \App\Models\Campaign::class && $meta->seoable) {
            return url('/projects/' . $meta->seoable->slug);
        }

        return url('/');
    }

    public function handleSeoExport()
    {
        try {
            if ($r = $this->deny(Permission::VIEW_SEO->value)) return $r;

            $csv = Writer::createFromString('');
            $csv->insertOne(['URL', 'Current title', 'New title', 'New description', 'H1', 'Canonical', 'Schema type']);

            SeoMeta::with('seoable')->get()->each(function (SeoMeta $meta) use ($csv) {
                $csv->insertOne([
                    $this->resolveUrl($meta),
                    $meta->meta_title,
                    '',
                    '',
                    $meta->h1_override,
                    $meta->canonical_url,
                    $meta->og_type,
                ]);
            });

            return response($csv->toString(), 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="seo-export-' . now()->format('Y-m-d') . '.csv"',
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleSeoImport(Request $request)
    {
        try {
            if ($r = $this->deny(Permission::EDIT_SEO->value)) return $r;

            $validation = Validator::make($request->all(), [
                'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $csv = Reader::createFromPath($request->file('csv_file')->getRealPath());
            $csv->setHeaderOffset(0);

            $allMeta = SeoMeta::with('seoable')->get();
            $byUrl = $allMeta->keyBy(fn (SeoMeta $meta) => $this->resolveUrl($meta));

            $imported = 0;
            $skipped = 0;

            foreach ($csv->getRecords() as $record) {
                $url = trim($record['URL'] ?? '');
                $meta = $url !== '' ? $byUrl->get($url) : null;

                if (!$meta) {
                    $skipped++;
                    continue;
                }

                $newTitle = trim($record['New title'] ?? '');
                $newDescription = trim($record['New description'] ?? '');
                $h1 = trim($record['H1'] ?? '');
                $canonical = trim($record['Canonical'] ?? '');

                $before = $meta->only(self::REVISIONED_FIELDS);

                if ($newTitle !== '') $meta->meta_title = $newTitle;
                if ($newDescription !== '') $meta->meta_description = $newDescription;
                if ($h1 !== '') $meta->h1_override = rtrim(str_replace('*', '', $h1), '. ');
                if ($canonical !== '') $meta->canonical_url = $canonical;
                $meta->update();

                if ($before !== $meta->only(self::REVISIONED_FIELDS)) {
                    SeoMetaRevision::create([
                        'seo_meta_id' => $meta->id,
                        'admin_id' => auth()->user()->id,
                        'snapshot_json' => $before,
                    ]);
                }

                $imported++;
            }

            return redirect()->route('admin.view.seo.list')->with('message', [
                'status' => 'success',
                'title' => 'Import complete',
                'description' => "{$imported} SEO entries updated, {$skipped} rows skipped."
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleSeoRevisionRestore($id, $revisionId)
    {
        try {
            if ($r = $this->deny(Permission::EDIT_SEO->value)) return $r;

            $meta = SeoMeta::find($id);
            if (!$meta) return $this->notFound();

            $revision = SeoMetaRevision::where('seo_meta_id', $meta->id)->find($revisionId);
            if (!$revision) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Revision not found',
                    'description' => 'Revision not found with specified ID'
                ]);
            }

            $before = $meta->only(self::REVISIONED_FIELDS);

            $meta->fill($revision->snapshot_json);
            $meta->update();

            SeoMetaRevision::create([
                'seo_meta_id' => $meta->id,
                'admin_id' => auth()->user()->id,
                'snapshot_json' => $before,
            ]);

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Revision restored',
                'description' => 'The SEO meta has been restored to the selected revision.'
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleSeoUpdate(Request $request, $id)
    {
        try {
            if ($r = $this->deny(Permission::EDIT_SEO->value)) return $r;

            $meta = SeoMeta::find($id);
            if (!$meta) return $this->notFound();

            $validation = Validator::make($request->all(), $this->rules());
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $before = $meta->only(self::REVISIONED_FIELDS);

            $this->fill($meta, $request);
            $meta->update();

            $after = $meta->only(self::REVISIONED_FIELDS);
            if ($before !== $after) {
                SeoMetaRevision::create([
                    'seo_meta_id' => $meta->id,
                    'admin_id' => auth()->user()->id,
                    'snapshot_json' => $before,
                ]);
            }

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Changes saved',
                'description' => 'The changes are successfully saved.'
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }
}
