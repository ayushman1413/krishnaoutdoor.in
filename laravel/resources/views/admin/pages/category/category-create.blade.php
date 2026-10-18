@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.category.list') }}">Categories</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.category.create') }}">Add Category</a></li>
        </ul>
        <h1 class="panel-title">Add Category</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.category.create') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="input-group">
                        <label for="name" class="input-label">Name <em>*</em></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="input-box-md @error('name') input-invalid @enderror" placeholder="Enter Name"
                            minlength="1" maxlength="250" required>
                        @error('name')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Priority --}}
                    <div class="input-group">
                        <label for="priority" class="input-label">Priority <span>(Optional)</span></label>
                        <input type="number" name="priority" value="{{ old('priority') }}"
                            class="input-box-md @error('priority') input-invalid @enderror" placeholder="Enter Priority"
                            min="0" max="1000">
                        @error('slug')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div class="input-group">
                        <label for="slug" class="input-label">Slug <span>(Optional)</span></label>
                        <input type="text" name="slug" value="{{ old('slug') }}"
                            class="input-box-md @error('slug') input-invalid @enderror" placeholder="Enter Slug"
                            minlength="1" maxlength="250">
                        @error('slug')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Parent Category --}}
                    <div class="flex flex-col">
                        <label for="category_id" class="input-label">Parent Category (Optional)</label>
                        <select name="category_id" class="input-box-md @error('discount_type') input-invalid @enderror">
                            <option value="">Select Parent Category</option>
                            @foreach ($categories as $firstTierItem)
    @if ($firstTierItem->category_id === null)
        <option @selected(old('category_id', request('category_id')) == $firstTierItem->id) value="{{ $firstTierItem->id }}">{{ $firstTierItem->name }}</option>
        {{-- Second Tier Categories --}}
        @foreach ($categories as $secondTierItem)
            @if ($secondTierItem->category_id === $firstTierItem->id)
                <option @selected(old('category_id', request('category_id')) == $secondTierItem->id) value="{{ $secondTierItem->id }}">&nbsp;&nbsp;{{ $secondTierItem->name }}</option>
                {{-- Third Tier Categories --}}
                @foreach ($categories as $thirdTierItem)
                    @if ($thirdTierItem->category_id === $secondTierItem->id)
                        <option @selected(old('category_id', request('category_id')) == $thirdTierItem->id) value="{{ $thirdTierItem->id }}">&nbsp;&nbsp;&nbsp;&nbsp;{{ $thirdTierItem->name }}</option>
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif
@endforeach

                        </select>

                        @error('category_id')
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

                    {{-- Description --}}
                    <div class="input-group 2xl:col-span-5 lg:col-span-4 md:col-span-2 sm:col-span-1">
                        <label for="description" class="input-label">Description <span>(Optional)</span></label>
                        <div class="space-y-2">
                            <div class="flex space-x-2">
                                <button class="btn-primary-sm" type="button" onclick="format('bold')"><b>B</b></button>
                                <button class="btn-primary-sm" type="button" onclick="format('italic')"><i>I</i></button>
                                <button class="btn-primary-sm" type="button" onclick="format('insertunorderedlist')"><i
                                        data-feather="list" class="h-3 w-3"></i></button>
                            </div>
                            <div onkeyup="handleConvertHTML()"
                                class="input-box-md @error('description') input-invalid @enderror" contenteditable="true"
                                id="html-editor">
                                {!! old('description') !!}
                            </div>
                            <input type="text" name="description" id="description" value="{{ old('description') }}"
                                hidden>
                        </div>
                        <script>
                            function format(command, value) {
                                document.execCommand(command, false, value);
                            }
                            function handleConvertHTML() {
                                document.getElementById('description').value = document.getElementById('html-editor').innerHTML;
                            }
                        </script>
                        @error('description')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>


                    {{-- Thumbnail --}}
<div class="md:col-span-4 sm:col-span-1">
    <label for="thumbnail_image" class="input-label">Thumbnail <span>(Format: png, jpg, jpeg,
        webp, gif, mp4)</span> <span>(For Parent Category: 1000px × 800px)</span> <span>(For Child Category: 720px × 790px)</span><em>*</em></label>
    <div class="flex space-x-3 my-2">
        <div class="input-box-dragable">
            <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp, image/gif, video/mp4" onchange="handleThumbnailPreview(event)" name="thumbnail_image" required>
            <i data-feather="upload-cloud"></i>
            <span>Darg and Drop Image Files</span>
        </div>
        <div id="thumbnail_preview_container">
            <img src="{{ asset('admin/images/default-thumbnail.png') }}" id="thumbnail_image" alt="thumbnail_image" class="input-thumbnail-preview">
            <video id="thumbnail_video" controls style="display: none;" autoplay muted loop></video>
        </div>
    </div>
    @error('thumbnail_image')
        <span class="input-error">{{ $message }}</span>
    @enderror
</div>


                    {{-- Cover Image --}}
<div class="md:col-span-4 sm:col-span-1">
    <label for="cover_image" class="input-label">Cover Image <span>(Format: png, jpg, jpeg, webp, gif, mp4)</span> <span>(Size: 1400px × 450px)</span> <em>*</em> </label>
    <div class="flex space-x-3 my-2">
        <div class="input-box-dragable">
            <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp, image/gif, video/mp4"
                onchange="handleCoverImagePreview(event)" name="cover_image">
            <i data-feather="upload-cloud"></i>
            <span>Drag and Drop Image/Video Files</span>
        </div>
        <div id="preview_container">
            <!-- Preview will be inserted here -->
            <img src="{{ asset('admin/images/default-thumbnail.png') }}" id="cover_image"
                                alt="cover_image" class="input-thumbnail-preview">

        </div>
    </div>
    @error('cover_image')
        <span class="input-error">{{ $message }}</span>
    @enderror
</div>

                    {{-- Category Meida --}}
                    <div class="md:col-span-4 sm:col-span-1">
                        <label for="category_media" class="input-label">Images (Format: png, jpg, jpeg, webp, mp4) <span>(Size: 800px × 1000px)</span></label>
                        <div class="input-group w-fit py-2">
                            <select name="project_category" class="input-box-md @error('project_category') input-invalid @enderror">
                                <option value="">Select Project Category</option>
                                @foreach ($project_category::cases() as $item)
                                <option value="{{$item->value}}">{{$item->label()}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2 my-2">
                            <div class="input-box-dragable">
                                <input type="file" multiple onchange="handleMediaPreview(event)"
                                    name="category_media[]">
                                <i data-feather="upload-cloud"></i>
                                <span>Darg and Drop Image Files</span>
                            </div>
                            <div class="grid md:grid-cols-4 sm:grid-cols-2 gap-5" id="media-preview-div">

                            </div>
                        </div>
                        @error('category_media')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="panel-card-footer">
                <button type="submit" class="btn-primary-md md:w-fit sm:w-full">Add Category</button>
            </div>
        </figure>
    </form>
@endsection

@section('panel-script')
    <script>
        document.getElementById('category-tab').classList.add('active');

        const handleThumbnailPreview = (event) => {
    const thumbnailImage = document.getElementById('thumbnail_image');
    const thumbnailVideo = document.getElementById('thumbnail_video');
    const thumbnailPreviewContainer = document.getElementById('thumbnail_preview_container');

    if (event.target.files.length === 0) {
        thumbnailImage.src = "{{ asset('admin/images/default-thumbnail.png') }}";
        thumbnailImage.style.display = 'block';
        thumbnailVideo.style.display = 'none';
    } else {
        const file = event.target.files[0];
        const fileType = file.type.split('/')[0];

        if (fileType === 'image') {
            thumbnailImage.src = URL.createObjectURL(file);
            thumbnailImage.style.display = 'block';
            thumbnailVideo.style.display = 'none';
        } else if (fileType === 'video') {
            thumbnailVideo.src = URL.createObjectURL(file);
            thumbnailImage.style.display = 'none';
            thumbnailVideo.style.display = 'block';

        }
    }
};

        function handleCoverImagePreview(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('preview_container');
    previewContainer.innerHTML = ''; // Clear previous previews

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const fileType = file.type.split('/')[0]; // Get the type of file (image or video)
            if (fileType === 'image') {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('input-thumbnail-preview');
                img.alt = 'cover_image';
                previewContainer.appendChild(img);
            } else if (fileType === 'video') {
                const video = document.createElement('video');
                video.src = e.target.result;
                video.classList.add('input-thumbnail-preview');
                video.alt = 'cover_video';
                video.controls = true; // Enable video controls
                previewContainer.appendChild(video);
                video.autoplay = true;
                video.muted = true;
                video.loop = true;
            }
        };
        reader.readAsDataURL(file);
    }
}
        const handleMediaPreview = (event) => {
            document.getElementById('media-preview-div').replaceChildren();
            Object.values(event.target.files).forEach(file => {

                let parentDiv = document.createElement('div');
                parentDiv.className =
                    "h-fit w-full flex flex-col items-center justify-center overflow-hidden border rounded-md p-2 gap-2";

                switch (file.type) {
                    case "image/jpeg":
                    case "image/jpg":
                    case "image/png":
                    case "image/webp":
                        var element = document.createElement('img');
                        element.className = "h-auto w-wull border rounded";
                        element.src = URL.createObjectURL(file);
                        parentDiv.appendChild(element);
                        break;

                    case "video/mp4":
                        var element = document.createElement('video');
                        element.className = "h-auto w-wull border rounded";
                        element.controls = true;
                        element.src = URL.createObjectURL(file);
                        parentDiv.appendChild(element);
                        break;

                    default:
                        var element = document.createElement('a');
                        element.className = "btn-secondary-md";
                        element.innerHTML = "Preview";
                        element.target = "_blank";
                        element.href = URL.createObjectURL(file);
                        parentDiv.appendChild(element);
                        break;
                }

                // var nameInput = document.createElement('input');
                // nameInput.type = "text";
                // nameInput.className = "input-box-sm w-full";
                // nameInput.name = "category_media[]";
                // nameInput.min = 0;
                // nameInput.max = 500;
                // nameInput.required = true;
                // nameInput.placeholder = "Enter Name";
                // parentDiv.appendChild(nameInput);

                document.getElementById('media-preview-div').appendChild(parentDiv);
            });
        }
    </script>
@endsection
