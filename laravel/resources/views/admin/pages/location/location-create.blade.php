@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.location.list') }}">Locations / Media</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.location.create') }}">Add Location</a></li>
        </ul>
        <h1 class="panel-title">Add Location</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.location.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Add Information</h1>
                    <p class="panel-card-description">Please fill the required fields</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid 2xl:grid-cols-4 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    {{-- Name --}}
                    <div class="input-group">
                        <label for="name" class="input-label">Location / Place Name <em>*</em></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="input-box-md @error('name') input-invalid @enderror" placeholder="Enter Location Name"
                            minlength="1" maxlength="250" required>
                        @error('name')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Media Type --}}
                    <div class="input-group">
                        <label for="media_type" class="input-label">Media Type <em>*</em></label>
                        <select name="media_type" class="input-box-md @error('media_type') input-invalid @enderror" required>
                            <option value="">Select Media Type</option>
                            @foreach ($media_type::cases() as $item)
                                <option value="{{ $item->value }}" @if (old('media_type') == $item->value) selected @endif>{{ $item->label() }}</option>
                            @endforeach
                        </select>
                        @error('media_type')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- City --}}
                    <div class="input-group">
                        <label for="city" class="input-label">City <em>*</em></label>
                        <select name="city" class="input-box-md @error('city') input-invalid @enderror" required>
                            <option value="">Select City</option>
                            @foreach ($cities::cases() as $item)
                                <option value="{{ $item->value }}" @if (old('city') == $item->value) selected @endif>{{ $item->label() }}</option>
                            @endforeach
                        </select>
                        @error('city')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Area --}}
                    <div class="input-group">
                        <label for="area" class="input-label">Area <span>(Optional)</span></label>
                        <input type="text" name="area" value="{{ old('area') }}"
                            class="input-box-md @error('area') input-invalid @enderror" placeholder="Enter Area"
                            minlength="1" maxlength="250">
                        @error('area')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Availability --}}
                    <div class="input-group">
                        <label for="is_available" class="input-label">Media Availability</label>
                        <label class="toggler-switch mt-1">
                            <input type="checkbox" name="is_available" value="1" checked>
                            <div class="slider"></div>
                        </label>
                    </div>

                    {{-- Image --}}
                    <div class="md:col-span-4 sm:col-span-1">
                        <label for="image" class="input-label">Image <span>(Format: png, jpg, jpeg, webp)</span></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="handleImagePreview(event)" name="image">
                                <i data-feather="upload-cloud"></i>
                                <span>Darg and Drop Image Files</span>
                            </div>
                            <img src="{{ asset('admin/images/default-thumbnail.png') }}" id="image_preview"
                                alt="image_preview" class="input-thumbnail-preview">
                        </div>
                        @error('image')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                        <input type="text" name="image_alt" value="{{ old('image_alt') }}"
                            class="input-box-md mt-2 @error('image_alt') input-invalid @enderror"
                            placeholder="Alt text (for SEO/accessibility)" maxlength="255">
                        @error('image_alt')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="panel-card-footer">
                <button type="submit" class="btn-primary-md md:w-fit sm:w-full">Add Location</button>
            </div>
        </figure>
    </form>
@endsection

@section('panel-script')
    <script>
        document.getElementById('location-tab').classList.add('active');

        const handleImagePreview = (event) => {
            if (event.target.files.length == 0) {
                document.getElementById('image_preview').src = "{{ asset('admin/images/default-thumbnail.png') }}";
            } else {
                document.getElementById('image_preview').src = URL.createObjectURL(event.target.files[0])
            }
        }
    </script>
@endsection
