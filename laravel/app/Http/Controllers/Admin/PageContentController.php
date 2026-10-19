<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CmsElement;
use App\Models\SeoMeta;
use App\Models\SeoMetaRevision;
use App\Services\Cms\Cms;
use App\Services\Cms\HtmlSanitizer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Admin > Page Content: edit the headings (H1-H6), paragraphs, body text and
 * internal links of a public page. See App\Services\Cms\Cms.
 */
class PageContentController extends Controller
{
    private const MAX_RELATED_LINKS = 12;

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
        return redirect()->route('admin.view.content.list')->with('message', [
            'status' => 'warning',
            'title' => 'Page not found',
            'description' => 'No page content record with the specified ID'
        ]);
    }

    public function viewContentList(Request $request)
    {
        try {
            if ($r = $this->deny(Permission::VIEW_SEO->value)) return $r;

            $group = $request->query('group', 'pages');
            if (!in_array($group, ['categories', 'campaigns', 'locations'], true)) {
                $group = 'pages';
            }

            return view('admin.pages.content.content-list', [
                'metas' => SeoMeta::forGroup($group)->loadCount('cmsElements'),
                'group' => $group,
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function viewContentEdit($id)
    {
        try {
            if ($r = $this->deny(Permission::EDIT_SEO->value)) return $r;

            $meta = SeoMeta::find($id);
            if (!$meta) return $this->notFound();

            $scan = Cms::scan($meta);
            $overrides = $meta->cmsElements()->get()->keyBy('element_key');

            $rows = [];
            foreach ($scan ?? [] as $el) {
                $override = $overrides->get($el['key']);
                $rows[] = [
                    'key' => $el['key'],
                    'is_h1' => $el['key'] === 'h1',
                    'is_heading' => $el['tag'] !== 'p',
                    'tag' => $el['tag'],
                    'level' => $override?->tag ?: $el['tag'],
                    'default' => $el['inner'],
                    'content' => $el['key'] === 'h1' ? (string) $meta->h1_override : ($override?->content ?? $el['inner']),
                    'changed' => $el['key'] === 'h1' ? filled($meta->h1_override) : (bool) $override,
                ];
            }

            $presentKeys = collect($scan ?? [])->pluck('key')->all();

            return view('admin.pages.content.content-edit', [
                'meta' => $meta,
                'rows' => $rows,
                'scanFailed' => $scan === null,
                'unused' => $overrides->reject(fn (CmsElement $o) => in_array($o->element_key, $presentKeys, true))->values(),
                'linkTargets' => $this->linkTargets($meta),
                'related' => old('related', $meta->related_links ?? []),
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleContentUpdate(Request $request, $id)
    {
        try {
            if ($r = $this->deny(Permission::EDIT_SEO->value)) return $r;

            $meta = SeoMeta::find($id);
            if (!$meta) return $this->notFound();

            $validation = Validator::make($request->all(), [
                'h1_override' => ['nullable', 'string', 'max:150'],
                'page_copy' => ['nullable', 'string', 'max:20000'],
                'elements' => ['nullable', 'array'],
                'elements.*.key' => ['required', 'string', 'max:40'],
                'elements.*.level' => ['nullable', Rule::in(['h1', ...Cms::LEVELS])],
                'elements.*.content' => ['nullable', 'string', 'max:5000'],
                'related' => ['nullable', 'array', 'max:' . self::MAX_RELATED_LINKS],
                'related.*.label' => ['nullable', 'string', 'max:80'],
                'related.*.url' => ['nullable', 'string', 'max:300'],
                'unused' => ['nullable', 'array'],
                'unused.*' => ['string', 'max:40'],
            ]);

            $validation->passes();
            $errors = $validation->errors();

            $related = [];
            foreach ((array) $request->input('related', []) as $i => $link) {
                $label = trim((string) ($link['label'] ?? ''));
                $url = trim((string) ($link['url'] ?? ''));
                if ($label === '' && $url === '') {
                    continue;
                }
                if ($label === '' || HtmlSanitizer::safeHref($url) === null) {
                    $errors->add("related.$i.url", 'Each related link needs a label and an address starting with /, https://, mailto: or tel:.');
                    continue;
                }
                $related[] = ['label' => $label, 'url' => $url];
            }

            if ($errors->isNotEmpty()) {
                return redirect()->back()->withErrors($errors)->withInput();
            }

            $scan = Cms::scan($meta);
            if ($scan === null) {
                throw new Exception('This page could not be rendered, so its headings and paragraphs cannot be saved.');
            }
            $byKey = collect($scan)->keyBy('key');

            $before = $meta->only(SeoMeta::REVISIONED_FIELDS);

            DB::transaction(function () use ($request, $meta, $byKey, $related) {
                $meta->h1_override = SeoMeta::normalizeH1($request->input('h1_override'));
                $meta->page_copy = Cms::pageCopyHtml($request->input('page_copy')) ?: null;
                $meta->related_links = $related ?: null;
                $meta->update();

                foreach ((array) $request->input('elements', []) as $posted) {
                    $el = $byKey->get($posted['key'] ?? null);
                    if (!$el || $el['key'] === 'h1') {
                        continue;
                    }
                    $this->saveElement($meta, $el, (string) ($posted['level'] ?? ''), (string) ($posted['content'] ?? ''));
                }

                $unused = array_values(array_diff((array) $request->input('unused', []), $byKey->keys()->all()));
                if ($unused) {
                    CmsElement::where('seo_meta_id', $meta->id)->whereIn('element_key', $unused)->delete();
                }
            });

            if ($before !== $meta->only(SeoMeta::REVISIONED_FIELDS)) {
                SeoMetaRevision::create([
                    'seo_meta_id' => $meta->id,
                    'admin_id' => auth()->user()->id,
                    'snapshot_json' => $before,
                ]);
            }

            $message = ['status' => 'success', 'title' => 'Changes saved', 'description' => 'The page content is saved and live.'];
            if ($broken = $this->unknownLinks($meta)) {
                $message = [
                    'status' => 'warning',
                    'title' => 'Saved, but check these links',
                    'description' => 'No page of this site was found for: ' . implode(', ', $broken) . '.',
                ];
            }

            return redirect()->back()->with('message', $message);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    /** Back to the template wording: drops every heading/paragraph change of this page. */
    public function handleContentReset($id)
    {
        try {
            if ($r = $this->deny(Permission::EDIT_SEO->value)) return $r;

            $meta = SeoMeta::find($id);
            if (!$meta) return $this->notFound();

            $meta->cmsElements()->delete();

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Reset done',
                'description' => 'All headings and paragraphs of this page show the template wording again.'
            ]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    /**
     * Store (or drop) the override of one element. Only differences from the
     * template are stored; an empty text means "use the template text".
     */
    private function saveElement(SeoMeta $meta, array $el, string $level, string $content): void
    {
        $newTag = $el['tag'] !== 'p' && in_array($level, Cms::LEVELS, true) ? $level : $el['tag'];

        $newContent = null;
        if (trim($content) !== '' && !Cms::sameMarkup($content, $el['inner'])) {
            $clean = Cms::cleanInline($content);
            if (Cms::text($clean) !== '' && !Cms::sameMarkup($clean, $el['inner'])) {
                $newContent = $clean;
            }
        }

        $newTag = $newTag !== $el['tag'] ? $newTag : null;

        if ($newTag === null && $newContent === null) {
            CmsElement::where('seo_meta_id', $meta->id)->where('element_key', $el['key'])->delete();
            return;
        }

        CmsElement::updateOrCreate(
            ['seo_meta_id' => $meta->id, 'element_key' => $el['key']],
            ['tag' => $newTag, 'content' => $newContent, 'original' => $el['inner']]
        );
    }

    /** Pages an editor can link to: [label, url] for every page except this one. */
    private function linkTargets(SeoMeta $meta): array
    {
        return SeoMeta::with('seoable')->get()
            ->reject(fn (SeoMeta $other) => $other->id === $meta->id)
            ->map(fn (SeoMeta $other) => ['label' => $other->displayName(), 'url' => $other->publicPath()])
            ->filter(fn (array $target) => $target['url'] !== null && $target['label'] !== '-')
            ->sortBy('label', SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->all();
    }

    /** Site-relative links in the page text and related links that match no page of this site. */
    private function unknownLinks(SeoMeta $meta): array
    {
        $known = SeoMeta::with('seoable')->get()
            ->map(fn (SeoMeta $other) => $other->publicPath())
            ->filter()
            ->map(fn (string $path) => rtrim($path, '/') ?: '/')
            ->push('/blog', '/thank-you')
            ->all();

        $hrefs = collect($meta->related_links ?? [])->pluck('url')->all();
        if (preg_match_all('~<a\s[^>]*href="([^"]+)"~i', (string) $meta->page_copy, $m)) {
            $hrefs = array_merge($hrefs, $m[1]);
        }

        return collect($hrefs)
            ->filter(fn ($href) => str_starts_with($href, '/'))
            ->map(fn ($href) => rtrim(strtok($href, '?#'), '/') ?: '/')
            ->reject(fn ($path) => in_array($path, $known, true) || str_starts_with($path, '/storage/') || str_starts_with($path, '/blog/'))
            ->unique()
            ->values()
            ->all();
    }
}
