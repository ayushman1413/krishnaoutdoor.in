@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.seo.settings') }}">SEO Settings</a></li>
        </ul>
        <h1 class="panel-title">SEO Settings</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.seo.settings') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Global Defaults --}}
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Global Defaults</h1>
                    <p class="panel-card-description">Site-wide SEO defaults</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    <div class="input-group">
                        <label class="input-label">Site Name <em>*</em></label>
                        <input type="text" name="site_name" value="{{ old('site_name', $setting->site_name) }}"
                            class="input-box-md @error('site_name') input-invalid @enderror" maxlength="150" required>
                        @error('site_name') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Title Template <em>*</em> <span>(Must contain {page_title})</span></label>
                        <input type="text" name="title_template" value="{{ old('title_template', $setting->title_template) }}"
                            class="input-box-md @error('title_template') input-invalid @enderror" maxlength="200" placeholder="{page_title} | Krishna Outdoor" required>
                        @error('title_template') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Description Template <span>(Optional. Used only for pages with no meta description. Placeholders: {page_title}, {site_name})</span></label>
                        <input type="text" name="description_template" value="{{ old('description_template', $setting->description_template) }}"
                            class="input-box-md @error('description_template') input-invalid @enderror" maxlength="300" placeholder="{page_title} from {site_name}.">
                        @error('description_template') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Default OG Image <span>(Optional, Format: png, jpg, jpeg, webp)</span></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="handleImagePreview(event, 'default_og_image_preview')" name="default_og_image">
                                <i data-feather="upload-cloud"></i>
                                <span>Drag and Drop Image Files</span>
                            </div>
                            <img src="{{ $setting->default_og_image ? asset('storage/' . $setting->default_og_image) : asset('admin/images/default-thumbnail.png') }}"
                                id="default_og_image_preview" alt="preview" class="input-thumbnail-preview">
                        </div>
                        @error('default_og_image') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Favicon <span>(Optional, Format: ico, png)</span></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/x-icon, image/png" onchange="handleImagePreview(event, 'favicon_preview')" name="favicon">
                                <i data-feather="upload-cloud"></i>
                                <span>Drag and Drop Icon File</span>
                            </div>
                            <img src="{{ $setting->favicon ? asset('storage/' . $setting->favicon) : asset('admin/images/default-thumbnail.png') }}"
                                id="favicon_preview" alt="preview" class="input-thumbnail-preview">
                        </div>
                        @error('favicon') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                </div>
            </div>
        </figure>

        {{-- Tracking & Analytics --}}
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Tracking & Analytics</h1>
                    <p class="panel-card-description">Analytics and verification codes</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    <div class="input-group">
                        <label class="input-label">GSC Verification Code <span>(Optional)</span></label>
                        <input type="text" name="gsc_verification_code" value="{{ old('gsc_verification_code', $setting->gsc_verification_code) }}"
                            class="input-box-md @error('gsc_verification_code') input-invalid @enderror" maxlength="500">
                        @error('gsc_verification_code') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">GA4 ID <span>(Optional)</span></label>
                        <input type="text" name="ga4_id" value="{{ old('ga4_id', $setting->ga4_id) }}"
                            class="input-box-md @error('ga4_id') input-invalid @enderror" maxlength="50" placeholder="G-XXXXXXXXXX">
                        @error('ga4_id') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">GTM ID <span>(Optional)</span></label>
                        <input type="text" name="gtm_id" value="{{ old('gtm_id', $setting->gtm_id) }}"
                            class="input-box-md @error('gtm_id') input-invalid @enderror" maxlength="50" placeholder="GTM-XXXXXXX">
                        @error('gtm_id') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">WhatsApp Number <span>(Optional, with country code, e.g. +91 98765 43210. Shows the WhatsApp link in the header and on the free site list page.)</span></label>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}"
                            class="input-box-md @error('whatsapp_number') input-invalid @enderror" maxlength="20" placeholder="+91 ">
                        @error('whatsapp_number') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Facebook Pixel Code <span>(Optional)</span></label>
                        <textarea name="fb_pixel_code" rows="6" style="font-family: monospace;"
                            class="input-box-md @error('fb_pixel_code') input-invalid @enderror">{{ old('fb_pixel_code', $setting->fb_pixel_code) }}</textarea>
                        @error('fb_pixel_code') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                </div>
            </div>
        </figure>

        {{-- Custom Code --}}
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Custom Code</h1>
                    <p class="panel-card-description">Raw HTML/JS injected into the site head/body</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid lg:grid-cols-1 gap-5">

                    <div class="input-group">
                        <label class="input-label">Head Custom Code <span>(Optional)</span></label>
                        <textarea name="head_custom_code" rows="10" style="font-family: monospace;"
                            class="input-box-md @error('head_custom_code') input-invalid @enderror">{{ old('head_custom_code', $setting->head_custom_code) }}</textarea>
                        @error('head_custom_code') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Body Custom Code <span>(Optional)</span></label>
                        <textarea name="body_custom_code" rows="10" style="font-family: monospace;"
                            class="input-box-md @error('body_custom_code') input-invalid @enderror">{{ old('body_custom_code', $setting->body_custom_code) }}</textarea>
                        @error('body_custom_code') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Organization Schema JSON <span>(Optional, must be valid JSON. Leave empty to use the automatic Organization schema: name, logo, founding date 1985, social profiles.)</span></label>
                        <textarea name="organization_schema_json" rows="8" style="font-family: monospace;"
                            class="input-box-md @error('organization_schema_json') input-invalid @enderror">{{ old('organization_schema_json', $setting->organization_schema_json) }}</textarea>
                        @error('organization_schema_json') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    @foreach (['ahmedabad' => 'Ahmedabad Head Office', 'mumbai' => 'Mumbai Office'] as $officeKey => $officeLabel)
                        <div class="input-group">
                            <label class="input-label">LocalBusiness Schema JSON – {{ $officeLabel }} <span>(Optional. Leave empty to use the automatic version built from the office address, phone, map and opening hours.)</span></label>
                            <textarea name="local_business_{{ $officeKey }}_json" rows="8" style="font-family: monospace;"
                                class="input-box-md @error('local_business_' . $officeKey . '_json') input-invalid @enderror">{{ old('local_business_' . $officeKey . '_json', $setting->{'local_business_' . $officeKey . '_json'}) }}</textarea>
                            @error('local_business_' . $officeKey . '_json') <span class="input-error">{{ $message }}</span> @enderror
                        </div>
                    @endforeach

                </div>
            </div>
        </figure>

        {{-- Robots.txt --}}
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Robots.txt</h1>
                    <p class="panel-card-description">Content served at /robots.txt</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid lg:grid-cols-1 gap-5">
                    <div class="input-group">
                        <label class="input-label">Robots.txt Content <span>(Optional)</span></label>
                        <textarea name="robots_txt" rows="10" style="font-family: monospace;"
                            class="input-box-md @error('robots_txt') input-invalid @enderror">{{ old('robots_txt', $setting->robots_txt) }}</textarea>
                        @error('robots_txt') <span class="input-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="panel-card-footer">
                <button type="submit" class="btn-primary-md md:w-fit sm:w-full">Save Changes</button>
            </div>
        </figure>
    </form>
@endsection

@section('panel-script')
    <script>
        document.getElementById('seo-tab').classList.add('active');

        const originalImages = {
            default_og_image_preview: "{{ $setting->default_og_image ? asset('storage/' . $setting->default_og_image) : asset('admin/images/default-thumbnail.png') }}",
            favicon_preview: "{{ $setting->favicon ? asset('storage/' . $setting->favicon) : asset('admin/images/default-thumbnail.png') }}"
        };

        const handleImagePreview = (event, previewId) => {
            document.getElementById(previewId).src = event.target.files.length == 0
                ? originalImages[previewId]
                : URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
