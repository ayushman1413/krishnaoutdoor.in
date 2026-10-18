<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use App\Services\SeoResolver;
use App\Services\SitemapService;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Dynamic sitemap.xml; see SitemapService for what is included.
     */
    public function sitemap(): Response
    {
        $xml = view('web.common.sitemap-xml', ['urls' => SitemapService::urls()])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * Dynamic robots.txt, editable from the SEO admin panel.
     */
    public function robots(): Response
    {
        $settings = SeoSetting::query()->first();

        $content = $settings?->robots_txt ?: (
            "User-agent: *\n" .
            "Disallow: /cgi-bin/\n" .
            "Sitemap: " . SeoResolver::canonicalFor('sitemap.xml') . "\n"
        );

        return response($content, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
