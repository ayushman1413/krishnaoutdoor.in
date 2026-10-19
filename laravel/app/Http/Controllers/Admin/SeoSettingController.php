<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\SeoSetting;
use App\Services\ImageOptimizer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SeoSettingController extends Controller
{
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

    private function rules(): array
    {
        return [
            'site_name' => ['required', 'string', 'max:150'],
            'description_template' => ['nullable', 'string', 'max:300'],
            'title_template' => ['required', 'string', 'max:200', function ($attribute, $value, $fail) {
                if (!str_contains((string) $value, '{page_title}')) {
                    $fail('Title template must contain {page_title}');
                }
            }],
            'default_og_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
            'favicon' => ['nullable', 'file', 'mimes:ico,png'],
            'gsc_verification_code' => ['nullable', 'string', 'max:500'],
            'ga4_id' => ['nullable', 'string', 'max:50'],
            'gtm_id' => ['nullable', 'string', 'max:50'],
            'fb_pixel_code' => ['nullable', 'string', 'max:20000'],
            'head_custom_code' => ['nullable', 'string', 'max:20000'],
            'body_custom_code' => ['nullable', 'string', 'max:20000'],
            'organization_schema_json' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && $value !== '' && json_decode($value) === null) {
                        $fail('Schema JSON must be valid JSON');
                    }
                }
            ],
            'robots_txt' => ['nullable', 'string'],
            'whatsapp_number' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9 ()-]{8,20}$/'],
            'local_business_ahmedabad_json' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && $value !== '' && json_decode($value) === null) {
                        $fail('Schema JSON must be valid JSON');
                    }
                }
            ],
            'local_business_mumbai_json' => [
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

    private function fill(SeoSetting $setting, Request $request): void
    {
        $setting->site_name = $request->input('site_name');
        $setting->title_template = $request->input('title_template');
        $setting->description_template = $request->input('description_template');
        $setting->gsc_verification_code = $request->input('gsc_verification_code');
        $setting->ga4_id = $request->input('ga4_id');
        $setting->gtm_id = $request->input('gtm_id');
        $setting->fb_pixel_code = $request->input('fb_pixel_code');
        $setting->head_custom_code = $request->input('head_custom_code');
        $setting->body_custom_code = $request->input('body_custom_code');
        $setting->organization_schema_json = $request->input('organization_schema_json');
        $setting->robots_txt = $request->input('robots_txt');
        $setting->whatsapp_number = $request->input('whatsapp_number');
        $setting->local_business_ahmedabad_json = $request->input('local_business_ahmedabad_json');
        $setting->local_business_mumbai_json = $request->input('local_business_mumbai_json');

        if ($request->hasFile('default_og_image')) {
            if ($setting->default_og_image)
                Storage::delete($setting->default_og_image);
            $setting->default_og_image = ImageOptimizer::store($request->file('default_og_image'), 'seo-settings', 'default-og-' . Str::random(12));
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon)
                Storage::delete($setting->favicon);
            $setting->favicon = $request->file('favicon')->store('seo-settings');
        }
    }

    public function viewSeoSettings(): mixed
    {
        try {
            if ($r = $this->deny(Permission::EDIT_SEO->value)) return $r;

            $setting = SeoSetting::firstOrCreate([], ['site_name' => 'Krishna Outdoor']);

            return view('admin.pages.seo.seo-settings', ['setting' => $setting]);
        } catch (Exception $e) {
            return $this->fail($e);
        }
    }

    public function handleSeoSettingsUpdate(Request $request)
    {
        try {
            if ($r = $this->deny(Permission::EDIT_SEO->value)) return $r;

            $validation = Validator::make($request->all(), $this->rules());
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $setting = SeoSetting::firstOrCreate([], ['site_name' => 'Krishna Outdoor']);
            $this->fill($setting, $request);
            $setting->update();

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
