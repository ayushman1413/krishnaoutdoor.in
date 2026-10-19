<?php

use App\Http\Controllers\Admin\ProjectController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminAccessController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\SeoMetaController;
use App\Http\Controllers\Admin\SeoSettingController;
use App\Http\Controllers\Admin\SeoRedirectController;
use App\Http\Controllers\Admin\Seo404LogController;


Route::get('/', function () {
    return redirect()->route('admin.view.dashboard');
});


Route::middleware(['guest:admin'])->group(function () {

    Route::get('login', [AuthController::class, 'viewLogin'])
        ->name('admin.view.login');
    Route::post('login', [AuthController::class, 'handleLogin'])
        ->name('admin.handle.login');

    Route::get('/forgot-password', [AuthController::class, 'viewForgotPassword'])
        ->name('admin.view.forgot.password');
    Route::post('/forgot-password', [AuthController::class, 'handleForgotPassword'])
        ->name('admin.handle.forgot.password');

    Route::get('/reset-password/{token}', [AuthController::class, 'viewResetPassword'])
        ->name('admin.view.reset.password');
    Route::post('/reset-password/{token}', [AuthController::class, 'handleResetPassword'])
        ->name('admin.handle.reset.password');
});


Route::middleware(['auth:admin'])->group(function () {

    Route::post('logout', function () {
        Auth::logout();
        return redirect()->route('admin.view.login');
    })->name('admin.handle.logout');

    Route::get('dashboard', [DashboardController::class, 'viewDashboard'])
        ->name('admin.view.dashboard');

    Route::prefix('admin-access')->controller(AdminAccessController::class)->group(function () {
        Route::get('/', 'viewAdminAccessList')->name('admin.view.admin.access.list');
        Route::get('/create', 'viewAdminAccessCreate')->name('admin.view.admin.access.create');
        Route::get('/update/{id}', 'viewAdminAccessUpdate')->name('admin.view.admin.access.update');
        Route::post('/create', 'handleAdminAccessCreate')->name('admin.handle.admin.access.create');
        Route::post('/update/{id}', 'handleAdminAccessUpdate')->name('admin.handle.admin.access.update');
        Route::put('/status', 'handleToggleAdminAccessStatus')->name('admin.handle.admin.access.status');
        Route::get('/delete/{id}', 'handleAdminAccessDelete')->name('admin.handle.admin.access.delete');
    });

    Route::prefix('project')->controller(ProjectController::class)->group(function () {
        Route::get('/', 'viewProjectList')->name('admin.view.project.list');
        Route::get('/create', 'viewProjectCreate')->name('admin.view.project.create');
        Route::get('/update/{id}', 'viewProjectUpdate')->name('admin.view.project.update');
        Route::post('/create', 'handleProjectCreate')->name('admin.handle.project.create');
        Route::post('/update/{id}', 'handleProjectUpdate')->name('admin.handle.project.update');
        Route::put('/status', 'handleToggleProjectStatus')->name('admin.handle.project.status');
        Route::get('/delete/{id}', 'handleProjectDelete')->name('admin.handle.project.delete');
    });

    Route::prefix('category')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'viewCategoryList')->name('admin.view.category.list');
        Route::get('/create', 'viewCategoryCreate')->name('admin.view.category.create');
        Route::get('/update/{id}', 'viewCategoryUpdate')->name('admin.view.category.update');
        Route::post('/create', 'handleCategoryCreate')->name('admin.handle.category.create');
        Route::post('/update/{id}', 'handleCategoryUpdate')->name('admin.handle.category.update');
        Route::put('/status', 'handleToggleCategoryStatus')->name('admin.handle.category.status');
        Route::get('/delete/{id}', 'handleCategoryDelete')->name('admin.handle.category.delete');
        Route::get('/media/delete/{id}', 'handleCategoryMediaDelete')->name('admin.handle.category.media.delete');
        Route::post('/media/update/{id}', 'handleCategoryMediaUpdate')->name('admin.handle.category.media.update');
    });

    Route::prefix('location')->controller(LocationController::class)->group(function () {
        Route::get('/', 'viewLocationList')->name('admin.view.location.list');
        Route::get('/create', 'viewLocationCreate')->name('admin.view.location.create');
        Route::get('/update/{id}', 'viewLocationUpdate')->name('admin.view.location.update');
        Route::post('/create', 'handleLocationCreate')->name('admin.handle.location.create');
        Route::post('/update/{id}', 'handleLocationUpdate')->name('admin.handle.location.update');
        Route::put('/status', 'handleToggleLocationStatus')->name('admin.handle.location.status');
        Route::put('/availability', 'handleToggleLocationAvailability')->name('admin.handle.location.availability');
        Route::get('/delete/{id}', 'handleLocationDelete')->name('admin.handle.location.delete');
    });

    Route::prefix('testimonial')->controller(TestimonialController::class)->group(function () {
        Route::get('/', 'viewTestimonialList')->name('admin.view.testimonial.list');
        Route::get('/create', 'viewTestimonialCreate')->name('admin.view.testimonial.create');
        Route::get('/update/{id}', 'viewTestimonialUpdate')->name('admin.view.testimonial.update');
        Route::post('/create', 'handleTestimonialCreate')->name('admin.handle.testimonial.create');
        Route::post('/update/{id}', 'handleTestimonialUpdate')->name('admin.handle.testimonial.update');
        Route::put('/status', 'handleToggleTestimonialStatus')->name('admin.handle.testimonial.status');
        Route::get('/delete/{id}', 'handleTestimonialDelete')->name('admin.handle.testimonial.delete');
    });
            Route::prefix('campaign')->controller(CampaignController::class)->group(function () {
        Route::get('/', 'viewCampaignList')->name('admin.view.campaign.list');
        Route::get('/create', 'viewCampaignCreate')->name('admin.view.campaign.create');
        Route::get('/update/{id}', 'viewCampaignUpdate')->name('admin.view.campaign.update');
        Route::post('/create', 'handleCampaignCreate')->name('admin.handle.campaign.create');
        Route::post('/update/{id}', 'handleCampaignUpdate')->name('admin.handle.campaign.update');
        Route::put('/status', 'handleToggleCampaignStatus')->name('admin.handle.campaign.status');
        Route::get('/delete/{id}', 'handleCampaignDelete')->name('admin.handle.campaign.delete');
    });      

    Route::prefix('enquiry')->controller(EnquiryController::class)->group(function () {
        Route::get('/', 'viewEnquiryList')->name('admin.view.enquiry.list');
        Route::get('/delete/{id}', 'handleEnquiryDelete')->name('admin.handle.enquiry.delete');
    });

    Route::prefix('career')->controller(CareerController::class)->group(function () {
        Route::get('/', 'viewCareerList')->name('admin.view.career.list');
        Route::get('/delete/{id}', 'handleCareerDelete')->name('admin.handle.career.delete');
    });

    Route::get('chats', [\App\Http\Controllers\Admin\ChatLogController::class, 'index'])->name('admin.view.chat.list');
    Route::get('chats/{id}', [\App\Http\Controllers\Admin\ChatLogController::class, 'show'])->name('admin.view.chat.show');

    Route::prefix('seo')->controller(SeoMetaController::class)->group(function () {
        Route::get('/', 'viewSeoList')->name('admin.view.seo.list');
        Route::get('/update/{id}', 'viewSeoUpdate')->name('admin.view.seo.update');
        Route::post('/update/{id}', 'handleSeoUpdate')->name('admin.handle.seo.update');
        Route::post('/update/{id}/revision/{revisionId}/restore', 'handleSeoRevisionRestore')->name('admin.handle.seo.revision.restore');
        Route::get('/export', 'handleSeoExport')->name('admin.handle.seo.export');
        Route::post('/import', 'handleSeoImport')->name('admin.handle.seo.import');
    });

    Route::get('seo-todos', [\App\Http\Controllers\Admin\SeoTodoController::class, 'index'])->name('admin.view.seo.todos');

    Route::prefix('seo-settings')->controller(SeoSettingController::class)->group(function () {
        Route::get('/', 'viewSeoSettings')->name('admin.view.seo.settings');
        Route::post('/', 'handleSeoSettingsUpdate')->name('admin.handle.seo.settings');
    });

    Route::prefix('redirect')->controller(SeoRedirectController::class)->group(function () {
        Route::get('/', 'viewRedirectList')->name('admin.view.redirect.list');
        Route::get('/create', 'viewRedirectCreate')->name('admin.view.redirect.create');
        Route::get('/update/{id}', 'viewRedirectUpdate')->name('admin.view.redirect.update');
        Route::post('/create', 'handleRedirectCreate')->name('admin.handle.redirect.create');
        Route::post('/update/{id}', 'handleRedirectUpdate')->name('admin.handle.redirect.update');
        Route::put('/status', 'handleToggleRedirectStatus')->name('admin.handle.redirect.status');
        Route::get('/delete/{id}', 'handleRedirectDelete')->name('admin.handle.redirect.delete');
        Route::post('/import', 'handleImportCsv')->name('admin.handle.redirect.import');
    });

    Route::prefix('404-log')->controller(Seo404LogController::class)->group(function () {
        Route::get('/', 'viewLogList')->name('admin.view.404log.list');
        Route::get('/delete/{id}', 'handleLogDelete')->name('admin.handle.404log.delete');
    });

    Route::prefix('setting')->controller(SettingController::class)->group(function () {
        Route::get('/', 'viewSetting')->name('admin.view.setting');
        Route::get('/account-information', 'viewAccountSetting')->name('admin.view.setting.account');
        Route::post('/account-information', 'handleAccountSetting')->name('admin.handle.setting.account');
        Route::get('/update-password', 'viewPasswordSetting')->name('admin.view.setting.password');
        Route::post('/update-password', 'handlePasswordSetting')->name('admin.handle.setting.password');

        Route::get('/roles-permissions', 'viewRolePermission')->name('admin.view.setting.role.permission');
        Route::get('/role/create', 'viewRoleCreate')->name('admin.view.setting.role.create');
        Route::post('/role/create', 'handleRoleCreate')->name('admin.handle.setting.role.create');
        Route::get('/role/update/{id}', 'viewRoleUpdate')->name('admin.view.setting.role.update');
        Route::post('/role/update/{id}', 'handleRoleUpdate')->name('admin.handle.setting.role.update');
        Route::get('/role/remove/permission/{role_id}/{permission_id}', 'handleRemovePermission')->name('admin.view.setting.role.remove.permission');
    });
});
