@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.campaign.list') }}">Our Work</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="#">Edit Campaign</a></li>
        </ul>
        <h1 class="panel-title">Edit Campaign</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.campaign.update', ['id' => $campaign->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Edit Information</h1>
                    <p class="panel-card-description">Update the campaign details</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    <div class="input-group">
                        <label class="input-label">Campaign Name <em>*</em></label>
                        <input type="text" name="name" value="{{ old('name', $campaign->name) }}"
                            class="input-box-md @error('name') input-invalid @enderror" maxlength="250" required>
                        @error('name') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Tagline <span>(Optional)</span></label>
                        <input type="text" name="tagline" value="{{ old('tagline', $campaign->tagline) }}"
                            class="input-box-md @error('tagline') input-invalid @enderror" maxlength="250">
                        @error('tagline') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Media Type <em>*</em></label>
                        <select name="media_type" class="input-box-md @error('media_type') input-invalid @enderror" required>
                            <option value="outdoor" @selected(old('media_type', $campaign->media_type) == 'outdoor')>Outdoor Media</option>
                            <option value="transit" @selected(old('media_type', $campaign->media_type) == 'transit')>Transit Media</option>
                            <option value="integrated" @selected(old('media_type', $campaign->media_type) == 'integrated')>Integrated Media</option>
                            <option value="social" @selected(old('media_type', $campaign->media_type) == 'social')>Social Media</option>
                        </select>
                        @error('media_type') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">City <em>*</em></label>
                        <input type="text" name="city" value="{{ old('city', $campaign->city) }}"
                            class="input-box-md @error('city') input-invalid @enderror" maxlength="100" required>
                        @error('city') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Paragraph <span>(Optional)</span></label>
                        <textarea name="description" rows="4"
                            class="input-box-md @error('description') input-invalid @enderror"
                            maxlength="1000">{{ old('description', $campaign->description) }}</textarea>
                        @error('description') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Campaign Image <span>(Leave empty to keep current image)</span></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="handleImagePreview(event)" name="image">
                                <i data-feather="upload-cloud"></i>
                                <span>Drag and Drop Image Files</span>
                            </div>
                            <img src="{{ $campaign->image ? asset('storage/' . $campaign->image) : asset('admin/images/default-thumbnail.png') }}"
                                id="image_preview" alt="preview" class="input-thumbnail-preview">
                        </div>
                        @error('image') <span class="input-error">{{ $message }}</span> @enderror
                        <input type="text" name="image_alt" value="{{ old('image_alt', $campaign->image_alt) }}"
                            class="input-box-md mt-2 @error('image_alt') input-invalid @enderror"
                            placeholder="Alt text (for SEO/accessibility)" maxlength="255">
                        @error('image_alt') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Gallery photos <span>(Optional, up to 8; shown on the case-study page. File names are taken from the campaign name.)</span></label>
                        @if ($campaign->slug)
                            <p class="mt-1 mb-2"><a href="{{ route('view.project.show', ['slug' => $campaign->slug]) }}" target="_blank" rel="noopener">Case-study page: /projects/{{ $campaign->slug }}</a></p>
                        @endif
                        <div class="flex flex-wrap gap-3 my-2">
                            @foreach (($campaign->gallery ?? []) as $i => $item)
                                <label class="text-xs" style="width:110px">
                                    <img src="{{ asset('storage/' . $item['path']) }}" alt="{{ $item['alt'] ?? 'gallery photo' }}" class="input-thumbnail-preview">
                                    <input type="checkbox" name="remove_gallery[]" value="{{ $i }}"> Remove
                                </label>
                            @endforeach
                        </div>
                        <input type="file" name="gallery[]" multiple accept="image/jpeg, image/jpg, image/png, image/webp" class="input-box-md mt-2">
                        @error('gallery') <span class="input-error">{{ $message }}</span> @enderror
                        @error('gallery.*') <span class="input-error">{{ $message }}</span> @enderror
                        <input type="text" name="gallery_alt[]" class="input-box-md mt-2" maxlength="255" placeholder="Alt text for new photo 1 (format + place + brand)">
                        <input type="text" name="gallery_alt[]" class="input-box-md mt-2" maxlength="255" placeholder="Alt text for new photo 2">
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
        document.getElementById('campaign-tab').classList.add('active');

        const originalImage = "{{ $campaign->image ? asset('storage/' . $campaign->image) : asset('admin/images/default-thumbnail.png') }}";

        const handleImagePreview = (event) => {
            document.getElementById('image_preview').src = event.target.files.length == 0
                ? originalImage
                : URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsections