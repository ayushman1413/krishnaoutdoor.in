@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.project.list') }}">Admin Project</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.project.create') }}">Add Project</a></li>
        </ul>
        <h1 class="panel-title">Add Project</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.project.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Add Information</h1>
                    <p class="panel-card-description">Please fill the required fields</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid 2xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    {{-- Name --}}
                    <div class="input-group 2xl:col-span-5 lg:col-span-4 md:col-span-2">
                        <label for="name" class="input-label">Name <em>*</em></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="input-box-md @error('name') input-invalid @enderror" placeholder="Enter Name"
                            minlength="1" maxlength="250" required>
                        @error('name')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Summary --}}
                    <div class="input-group 2xl:col-span-5 lg:col-span-4 md:col-span-2">
                        <label for="summary" class="input-label">Summary <em>*</em></label>
                        <input type="text" name="summary" value="{{ old('summary') }}"
                            class="input-box-md @error('summary') input-invalid @enderror" placeholder="Enter Summary"
                            required minlength="1" maxlength="500">
                        @error('summary')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Thumbnail --}}
                    <div class="md:col-span-4 sm:col-span-1">
                        <label for="thumbnail_image" class="input-label">Thumbnail <span>(Format: png, jpg, jpeg,
                            webp)</span> <span>(Size: 900px × 1600px)</span> <em>*</em></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="handleThumbnailPreview(event)" name="thumbnail_image" required>
                                <i data-feather="upload-cloud"></i>
                                <span>Drag and Drop Image Files</span>
                            </div>
                            <img src="{{ asset('admin/images/default-thumbnail.png') }}" id="thumbnail_image"
                                alt="thumbnail_image" class="input-thumbnail-preview">
                        </div>
                        @error('thumbnail_image')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                        <input type="text" name="thumbnail_image_alt" value="{{ old('thumbnail_image_alt') }}"
                            class="input-box-md mt-2 @error('thumbnail_image_alt') input-invalid @enderror"
                            placeholder="Alt text (for SEO/accessibility)" maxlength="255">
                        @error('thumbnail_image_alt')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Cover Image --}}
                    <div class="md:col-span-4 sm:col-span-1">
                        <label for="cover_image" class="input-label">Cover Image <span>(Format: png, jpg, jpeg, webp)</span> <span>(Optional)</span></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="handleCoverPreview(event)" name="cover_image">
                                <i data-feather="upload-cloud"></i>
                                <span>Drag and Drop Image Files</span>
                            </div>
                            <img src="{{ asset('admin/images/default-thumbnail.png') }}" id="cover_image_preview"
                                alt="cover_image" class="input-thumbnail-preview">
                        </div>
                        @error('cover_image')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                        <input type="text" name="cover_image_alt" value="{{ old('cover_image_alt') }}"
                            class="input-box-md mt-2 @error('cover_image_alt') input-invalid @enderror"
                            placeholder="Cover image alt text (for SEO/accessibility)" maxlength="255">
                        @error('cover_image_alt')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="panel-card-footer">
                <button type="submit" class="btn-primary-md md:w-fit sm:w-full">Add Project</button>
            </div>
        </figure>
    </form>
@endsection

@section('panel-script')
    <script>
        document.getElementById('project-tab').classList.add('active');

        const handleThumbnailPreview = (event) => {
            if (event.target.files.length == 0) {
                document.getElementById('thumbnail_image').src = "{{ asset('admin/images/default-thumbnail.png') }}";
            } else {
                document.getElementById('thumbnail_image').src = URL.createObjectURL(event.target.files[0])
            }
        }
        const handleCoverPreview = (event) => {
            if (event.target.files.length == 0) {
                document.getElementById('cover_image_preview').src = "{{ asset('admin/images/default-thumbnail.png') }}";
            } else {
                document.getElementById('cover_image_preview').src = URL.createObjectURL(event.target.files[0])
            }
        }
    </script>
@endsection
