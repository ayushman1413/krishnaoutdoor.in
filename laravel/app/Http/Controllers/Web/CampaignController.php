<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\SchemaBuilder;
use App\Services\SeoResolver;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Case-study page for one campaign (/projects/{slug}). Built only from
     * what is stored for the campaign in Admin > Our Work.
     */
    public function show(string $slug)
    {
        $campaign = Campaign::where('status', true)->where('slug', $slug)->first();
        abort_if(!$campaign, 404);

        $keywordRoute = $campaign->keywordRoute();
        $keywordPage = $keywordRoute ? config('seo_pages')[$keywordRoute] ?? null : null;

        $description = trim(strip_tags((string) $campaign->description));
        $seo = SeoResolver::forModel(
            $campaign,
            "{$campaign->name}: {$campaign->mediaLabel()} Campaign in {$campaign->city}",
            $description !== ''
                ? Str::limit($description, 155)
                : "{$campaign->mediaLabel()} campaign for {$campaign->name} in {$campaign->city} by Krishna Outdoor.",
            $campaign->image
        );

        SchemaBuilder::setBreadcrumbs([
            ['name' => 'Our Work', 'url' => route('view.projects')],
            ['name' => $campaign->name, 'url' => $seo->canonicalUrl],
        ]);

        $related = Campaign::where('status', true)->where('id', '!=', $campaign->id)
            ->orderByRaw('CASE WHEN media_type = ? THEN 0 ELSE 1 END', [$campaign->media_type])
            ->latest()->limit(3)->get();

        return view('web.pages.project-case', [
            'campaign' => $campaign,
            'seo' => $seo,
            'keywordRoute' => $keywordRoute,
            'keywordPage' => $keywordPage,
            'related' => $related,
        ]);
    }
}
