@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.campaign.list') }}">Our Work</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.campaign.create') }}">Add Campaign</a></li>
        </ul>
        <h1 class="panel-title">Add Campaign</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.campaign.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Add Information</h1>
                    <p class="panel-card-description">Please fill the required fields</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    <div class="input-group">
                        <label class="input-label">Campaign Name <em>*</em></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="input-box-md @error('name') input-invalid @enderror" placeholder="e.g. Jio" maxlength="250" required>
                        @error('name') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Tagline <span>(Optional)</span></label>
                        <input type="text" name="tagline" value="{{ old('tagline') }}"
                            class="input-box-md @error('tagline') input-invalid @enderror" placeholder="e.g. Expanding Market Presence" maxlength="250">
                        @error('tagline') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Media Type <em>*</em></label>
                        <select name="media_type" class="input-box-md @error('media_type') input-invalid @enderror" required>
                            <option value="">Select media type</option>
                            <option value="outdoor" @selected(old('media_type') == 'outdoor')>Outdoor Media</option>
                            <option value="transit" @selected(old('media_type') == 'transit')>Transit Media</option>
                            <option value="integrated" @selected(old('media_type') == 'integrated')>Integrated Media</option>
                            <option value="social" @selected(old('media_type') == 'social')>Social Media</option>
                        </select>
                        @error('media_type') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">City <em>*</em></label>
                        <input type="text" name="city" value="{{ old('city') }}"
                            class="input-box-md @error('city') input-invalid @enderror" placeholder="e.g. Ahmedabad" maxlength="100" required>
                        @error('city') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Paragraph <span>(Optional)</span></label>
                        <textarea name="description" rows="4"
                            class="input-box-md @error('description') input-invalid @enderror" placeholder="Short description of the campaign"
                            maxlength="1000">{{ old('description') }}</textarea>
                        @error('description') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Campaign Image <em>*</em> <span>(Format: png, jpg, jpeg, webp)</span></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="handleImagePreview(event)" name="image" required>
                                <i data-feather="upload-cloud"></i>
                                <span>Drag and Drop Image Files</span>
                            </div>
                            <img src="{{ asset('admin/images/default-thumbnail.png') }}" id="image_preview" alt="preview" class="input-thumbnail-preview">
                        </div>
                        @error('image') <span class="input-error">{{ $message }}</span> @enderror
                        <input type="text" name="image_alt" value="{{ old('image_alt') }}"
                            class="input-box-md mt-2 @error('image_alt') input-invalid @enderror"
                            placeholder="Alt text (for SEO/accessibility)" maxlength="255">
                        @error('image_alt') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Gallery photos <span>(Optional, up to 8; shown on the case-study page. File names are taken from the campaign name.)</span></label>
                        <input type="file" name="gallery[]" multiple accept="image/jpeg, image/jpg, image/png, image/webp" class="input-box-md mt-2">
                        @error('gallery') <span class="input-error">{{ $message }}</span> @enderror
                        @error('gallery.*') <span class="input-error">{{ $message }}</span> @enderror
                        <input type="text" name="gallery_alt[]" class="input-box-md mt-2" maxlength="255" placeholder="Alt text for gallery photo 1 (format + place + brand)">
                        <input type="text" name="gallery_alt[]" class="input-box-md mt-2" maxlength="255" placeholder="Alt text for gallery photo 2">
                    </div>
                </div>
            </div>
            <div class="panel-card-footer">
                <button type="submit" class="btn-primary-md md:w-fit sm:w-full">Add Campaign</button>
            </div>
        </figure>
    </form>
@endsection

@section('panel-script')
    <script>
        document.getElementById('campaign-tab').classList.add('active');

        const handleImagePreview = (event) => {
            document.getElementById('image_preview').src = event.target.files.length == 0
                ? "{{ asset('admin/images/default-thumbnail.png') }}"
                : URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection