<?php

use App\Http\Controllers\Web\CampaignController;
use App\Http\Controllers\Web\FormController;
use App\Http\Controllers\Web\LocationController;
use App\Http\Controllers\Web\SeoController;
use App\Models\Category;
use App\Models\CategoryMedia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/


/*
|--------------------------------------------------------------------------
| Utility Routes
|--------------------------------------------------------------------------
*/

// Forms load their CSRF token from here when first used (see kr-laravel.js),
// so no per-request token has to be baked into cacheable page HTML.
Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()])
        ->header('Cache-Control', 'no-store, private');
})->name('csrf.token');

Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    dd('Application optimized');
});

Route::get('/storage/link', function () {
    Artisan::call('storage:link');
    dd('Storage Linked');
});


/*
|--------------------------------------------------------------------------
| Main Pages
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $testimonials = \App\Models\Testimonial::where('status', true)->get();
    $seo = \App\Services\SeoResolver::forRoute('view.home');

    return view('web.pages.home', compact('testimonials', 'seo'));
})->name('view.home');


Route::get('/about', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.about');
    return view('web.pages.about', compact('seo'));
})->name('view.about');


Route::get('/contact', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.contact');
    return view('web.pages.contact', compact('seo'));
})->name('view.contact');


Route::get('/careers', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.careers');
    return view('web.pages.careers', compact('seo'));
})->name('view.careers');


Route::get('/services', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.services');
    return view('web.pages.services', compact('seo'));
})->name('view.services');


Route::get('/projects', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.projects');
    return view('web.pages.projects', compact('seo'));
})->name('view.projects');


Route::get('/projects/{slug}', [CampaignController::class, 'show'])
    ->name('view.project.show');


Route::get('/our-network', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.network');
    return view('web.pages.network', compact('seo'));
})->name('view.network');


/*
|--------------------------------------------------------------------------
| Media Pages
|--------------------------------------------------------------------------
*/

Route::get('/media/ooh', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.ooh.media');
    return view('web.pages.ooh-media', compact('seo'));
})->name('view.ooh.media');


Route::get('/media/transit', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.transit.media');
    return view('web.pages.transit-media', compact('seo'));
})->name('view.transit.media');


Route::get('/media/digital', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.digital.media');
    return view('web.pages.digital-media', compact('seo'));
})->name('view.digital.media');


/*
|--------------------------------------------------------------------------
| Keyword Landing Pages (SEO)
|--------------------------------------------------------------------------
|
| One dedicated page per client target keyword. Must stay before the
| generic /{slug} catch-all route at the end of this file.
*/

Route::get('/hoarding-advertising-ahmedabad', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.keyword.hoarding.ahmedabad');
    return view('web.pages.keywords.hoarding-advertising-ahmedabad', compact('seo'));
})->name('view.keyword.hoarding.ahmedabad');

Route::get('/amts-bus-advertising-ahmedabad', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.keyword.amts.ahmedabad');
    return view('web.pages.keywords.amts-bus-advertising-ahmedabad', compact('seo'));
})->name('view.keyword.amts.ahmedabad');

Route::get('/bus-shelter-advertising-ahmedabad', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.keyword.bus.shelter.ahmedabad');
    return view('web.pages.keywords.bus-shelter-advertising-ahmedabad', compact('seo'));
})->name('view.keyword.bus.shelter.ahmedabad');

Route::get('/gsrtc-bus-advertising', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.keyword.gsrtc');
    return view('web.pages.keywords.gsrtc-bus-advertising', compact('seo'));
})->name('view.keyword.gsrtc');

Route::get('/outdoor-advertising-agency-mumbai', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.keyword.agency.mumbai');
    return view('web.pages.keywords.outdoor-advertising-agency-mumbai', compact('seo'));
})->name('view.keyword.agency.mumbai');

Route::get('/mumbai-local-train-advertising', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.keyword.local.train.mumbai');
    return view('web.pages.keywords.mumbai-local-train-advertising', compact('seo'));
})->name('view.keyword.local.train.mumbai');

Route::get('/best-bus-advertising-mumbai', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.keyword.best.mumbai');
    return view('web.pages.keywords.best-bus-advertising-mumbai', compact('seo'));
})->name('view.keyword.best.mumbai');

Route::get('/tmt-bus-advertising-thane', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.keyword.tmt.thane');
    return view('web.pages.keywords.tmt-bus-advertising-thane', compact('seo'));
})->name('view.keyword.tmt.thane');

Route::get('/social-media-marketing-ahmedabad', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.keyword.social.ahmedabad');
    return view('web.pages.keywords.social-media-marketing-ahmedabad', compact('seo'));
})->name('view.keyword.social.ahmedabad');

Route::get('/social-media-marketing-mumbai', function () {
    $seo = \App\Services\SeoResolver::forRoute('view.keyword.social.mumbai');
    return view('web.pages.keywords.social-media-marketing-mumbai', compact('seo'));
})->name('view.keyword.social.mumbai');


/*
|--------------------------------------------------------------------------
| Old / SEO Redirect Routes
|--------------------------------------------------------------------------
*/

Route::get('/bus-advertisement', function () {
    return redirect()->route('view.transit.media', [], 301);
})->name('view.bus.advertisement');


Route::get('/outdoor-advertisement', function () {
    return redirect()->route('view.ooh.media', [], 301);
})->name('view.outdoor.advertisement');


Route::get('/train-advertisement', function () {
    return redirect()->route('view.transit.media', [], 301);
})->name('view.train.advertisement');


/*
|--------------------------------------------------------------------------
| SEO: dynamic sitemap.xml / robots.txt
|--------------------------------------------------------------------------
|
| Must stay before the generic /{slug} catch-all route at the end of
| this file. These supersede the static files of the same name in
| public/ once registered.
*/

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])
    ->name('view.seo.sitemap');

Route::get('/robots.txt', [SeoController::class, 'robots'])
    ->name('view.seo.robots');


/*
|--------------------------------------------------------------------------
| Location Pages
|--------------------------------------------------------------------------
*/

Route::get('/locations/{city}', [LocationController::class, 'viewByCity'])
    ->name('view.locations.city');


/*
|--------------------------------------------------------------------------
| Thank You Page
|--------------------------------------------------------------------------
|
| IMPORTANT:
| This route MUST come before /{slug}
| otherwise Laravel will treat "thank-you" as a category slug.
|
*/

Route::get('/free-site-list', [FormController::class, 'viewFreeSiteList'])
    ->name('view.free.site.list');

Route::post('/free-site-list', [FormController::class, 'handleFreeSiteListSubmit'])
    ->middleware('throttle:10,1')
    ->name('handle.free.site.list');

Route::get('/thank-you', function () {
    return view('web.layouts.Thank you');
})->name('view.thankyou');


/*
|--------------------------------------------------------------------------
| Contact / Career / Enquiry Form Submit
|--------------------------------------------------------------------------
*/

Route::post('/contact-enquiry', [FormController::class, 'handleContactFormSubmit'])
    ->name('handle.contact.enquiry');


Route::post('/career-enquiry', [FormController::class, 'handleCareerFormSubmit'])
    ->name('handle.career.enquiry');


Route::post('/plan-campaign-enquiry', [FormController::class, 'handlePlanCampaignFormSubmit'])
    ->name('handle.plan.campaign.enquiry');


/*
|--------------------------------------------------------------------------
| Enquiry Popup Submit
|--------------------------------------------------------------------------
*/

Route::post('/popup-enquiry', [FormController::class, 'handlePopupEnquirySubmit'])
    ->name('handle.popup.enquiry');


/*
|--------------------------------------------------------------------------
| Child Category Pages
|--------------------------------------------------------------------------
|
| Keep this before the generic /{slug} route.
|
*/

Route::get('/category/{slug}', function ($slug) {

    $category = Category::where('slug', $slug)->first();

    if (!$category) {
        abort(404);
    }

    $category_media = CategoryMedia::where(
        'category_id',
        $category->id
    )->get();

    // Fallback title goes through the "{page_title} | {site_name}" template,
    // so it must not already carry the site name.
    $featuredImage = pathinfo((string) $category->cover_image, PATHINFO_EXTENSION) === 'mp4' ? $category->thumbnail_image : $category->cover_image;
    $seo = \App\Services\SeoResolver::forModel($category, $category->name, strip_tags((string) $category->summary), $featuredImage);
    \App\Services\SchemaBuilder::setBreadcrumbs(array_values(array_filter([
        ['name' => 'Media Solutions', 'url' => route('view.services')],
        $category->parent_category ? ['name' => $category->parent_category->name, 'url' => url('/' . $category->parent_category->slug)] : null,
        ['name' => $category->name, 'url' => $seo->canonicalUrl],
    ])));

    return view('web.pages.child-category', [
        'category' => $category,
        'category_media' => $category_media,
        'seo' => $seo,
    ]);

})->name('view.child.category');


/*
|--------------------------------------------------------------------------
| Parent Category Pages
|--------------------------------------------------------------------------
|
| IMPORTANT:
| This generic route MUST stay at the END.
|
*/

Route::get('/{slug}', function ($slug) {

    $category = Category::where('slug', $slug)->first();

    if (!$category) {
        abort(404);
    }

    $category_media = CategoryMedia::where(
        'category_id',
        $category->id
    )->get();

    // Fallback title goes through the "{page_title} | {site_name}" template,
    // so it must not already carry the site name.
    $featuredImage = pathinfo((string) $category->cover_image, PATHINFO_EXTENSION) === 'mp4' ? $category->thumbnail_image : $category->cover_image;
    $seo = \App\Services\SeoResolver::forModel($category, $category->name, strip_tags((string) $category->summary), $featuredImage);
    \App\Services\SchemaBuilder::setBreadcrumbs([
        ['name' => 'Media Solutions', 'url' => route('view.services')],
        ['name' => $category->name, 'url' => $seo->canonicalUrl],
    ]);

    return view('web.pages.parent-category', [
        'category' => $category,
        'category_media' => $category_media,
        'seo' => $seo,
    ]);

})->name('view.parent.category');