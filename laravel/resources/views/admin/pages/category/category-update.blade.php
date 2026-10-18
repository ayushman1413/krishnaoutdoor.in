@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.category.list') }}">Categories</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.category.update', ['id' => $category->id]) }}">Edit Category</a></li>
        </ul>
        <h1 class="panel-title">Edit Category</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.category.update', ['id' => $category->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Edit Information</h1>
                    <p class="panel-card-description">Please fill the required fields</p>
                </div>

                @can(\App\Enums\Permission::DELETE_CATEGORY->value)
                <div>
                    <button type="button" class="btn-danger-sm flex items-center justify-center" onclick="handleDelete()">
                        <span class="lg:block md:block sm:hidden mr-2">Delete</span>
                        <i data-feather="trash"></i>
                    </button>
                </div>
                @endcan

            </div>
            <div class="panel-card-body">
                <div class="grid 2xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    {{-- Name --}}
                    <div class="input-group">
                        <label for="name" class="input-label">Name <em>*</em></label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}"
                            class="input-box-md @error('name') input-invalid @enderror" placeholder="Enter Name"
                            minlength="1" maxlength="250" required>
                        @error('name')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Priority --}}
                    <div class="input-group">
                        <label for="priority" class="input-label">Priority <span>(Optional)</span></label>
                        <input type="number" name="priority" value="{{ old('priority', $category->priority) }}"
                            class="input-box-md @error('priority') input-invalid @enderror" placeholder="Enter Priority"
                            min="0" max="1000">
                        @error('slug')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div class="input-group">
                        <label for="slug" class="input-label">Slug <em>*</em></label>
                        <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                            class="input-box-md @error('slug') input-invalid @enderror" placeholder="Enter Slug"
                            minlength="1" maxlength="250" required>
                        @error('slug')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (!is_null($category->category_id))
                    {{-- Parent Category --}}
                    <div class="flex flex-col">
                        <label for="category_id" class="input-label">Parent Category (Optional)</label>
                        <select name="category_id" class="input-box-md @error('category_id') input-invalid @enderror">
    <option value="">Select Parent Category</option>
    @foreach ($categories as $item)
        @if ($item->category_id == null)
            <option value="{{ $item->id }}" @if (old('category_id', $category->category_id) == $item->id) selected @endif>{{ $item->name }}</option>
            @foreach ($categories as $subItem)
                @if ($subItem->category_id == $item->id)
                    <option value="{{ $subItem->id }}" @if (old('category_id', $category->category_id) == $subItem->id) selected @endif class="sub-category">&nbsp;&nbsp;{{ $subItem->name }}</option>
                    @foreach ($categories as $thirdLevelItem)
                        @if ($thirdLevelItem->category_id == $subItem->id)
                            <option value="{{ $thirdLevelItem->id }}" @if (old('category_id', $category->category_id) == $thirdLevelItem->id) selected @endif class="sub-sub-category">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $thirdLevelItem->name }}</option>
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
                    @endif


                    {{-- Summary --}}
                    <div class="input-group 2xl:col-span-5 lg:col-span-4 md:col-span-2">
                        <label for="summary" class="input-label">Summary <em>*</em></label>
                        <input type="text" name="summary" value="{{ old('summary', $category->summary) }}"
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
                                {!! old('description', $category->description) !!}
                            </div>
                            <input type="text" name="description" id="description" value="{{ old('description', $category->description) }}"
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
            webp, mp4, gif)</span> <span>(For Parent Category: 1000px × 800px)</span> <span>(For Child Category: 720px × 790px)</span> <span>(Optional)</span> </label>
    <div class="flex lg:flex-row md:flex-row sm:flex-col gap-3 my-2">
        <div class="input-box-dragable">
            <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp, image/gif, video/mp4" onchange="handleThumbnailPreview(event)" name="thumbnail_image">
            <i data-feather="upload-cloud"></i>
            <span>Darg and Drop Image/Video Files</span>
            <!-- Hidden input field to retain previous uploaded thumbnail information -->
            <input type="hidden" id="previous_thumbnail" name="previous_thumbnail" value="{{ $category->thumbnail_image }}">
        </div>
        <div id="thumbnail_preview_container">
            <!-- Thumbnail preview will be displayed here -->
            @if (strpos($category->thumbnail_image, '.jpg') !== false || strpos($category->thumbnail_image, '.png') !== false || strpos($category->thumbnail_image, '.jpeg') !== false || strpos($category->thumbnail_image, '.gif') !== false)
                <!-- If the previous thumbnail is an image -->
                <img src="{{ is_null($category->thumbnail_image) ? asset('admin/images/default-thumbnail.png') : asset('storage/' . $category->thumbnail_image) }}" id="previous_thumbnail_preview" alt="previous_thumbnail" class="input-thumbnail-preview">
            @elseif (strpos($category->thumbnail_image, '.mp4') !== false || strpos($category->thumbnail_image, '.webm') !== false || strpos($category->thumbnail_image, '.ogg') !== false)
                <!-- If the previous thumbnail is a video -->
                <video controls id="previous_thumbnail_preview" class="input-thumbnail-preview" autoplay muted loop>
                    <source src="{{ asset('storage/' . $category->thumbnail_image) }}" type="video/mp4">
                </video>
            @endif
        </div>
    </div>
    @error('thumbnail_image')
    <span class="input-error">{{ $message }}</span>
    @enderror
</div>

                    {{-- Cover Image --}}
                    <div class="md:col-span-4 sm:col-span-1">
                        <label for="cover_image" class="input-label">Cover Image <span>(Format: png, jpg, jpeg, webp, mp4, gif)</span> <span>(Size: 1400px × 450px)</span> <span>(Optional)</span> </label>
                        <div class="flex lg:flex-row md:flex-row sm:flex-col gap-3 my-2">
                        <div class="input-box-dragable">
                        <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp, image/gif, video/mp4" onchange="handleCoverImagePreview(event)" name="cover_image">
                        <i data-feather="upload-cloud"></i>
                        <span>Drag and Drop Image/Video Files</span>
                        </div>
                        <div id="cover_preview_container">

                        @if (strpos($category->cover_image, '.jpg') !== false || strpos($category->cover_image, '.png') !== false || strpos($category->cover_image, '.jpeg') !== false || strpos($category->cover_image, '.gif') !== false)
    <!-- If the cover image is an image -->
    <img src="{{ is_null($category->cover_image) ? asset('admin/images/default-thumbnail.png') : asset('storage/' . $category->cover_image) }}" id="cover_image" alt="cover_image" class="input-thumbnail-preview">
@elseif (strpos($category->cover_image, '.mp4') !== false || strpos($category->cover_image, '.webm') !== false || strpos($category->cover_image, '.ogg') !== false)
    <!-- If the cover image is a video -->
    <video controls id="cover_video" class="input-thumbnail-preview" autoplay muted loop>
        <source src="{{ asset('storage/' . $category->cover_image) }}" type="video/mp4">
        <!-- Include additional source elements for other video formats if needed -->
        Your browser does not support the video tag.
    </video>
@else
    <!-- If the cover image is neither an image nor a video, show a default thumbnail -->
    <img src="{{ asset('admin/images/default-thumbnail.png') }}" id="cover_image" alt="cover_image" class="input-thumbnail-preview">
@endif

                        </div>
                        @error('cover_image')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>




                    {{-- Category Meida --}}
                    <div class="md:col-span-4 sm:col-span-1">
                        <label for="category_media" class="input-label">Images (Format: png, jpg, jpeg, webp, mp4) <span>(Size: 800px × 1000px)</span></label>
                        <div class="input-group w-fit py-2">
                            <select name="project_category" class="input-box-md @error('project_category') input-invalid @enderror" >
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
                            <div class="grid md:grid-cols-4 sm:grid-cols-2 gap-5">
                                @foreach ($category_media as $media)
                                    <div class="space-y-2 p-2 border rounded-md h-fit">
                                        <figure
                                            class="border rounded-md h-[200px] w-full flex items-center justify-center bg-slate-200 overflow-clip">
                                            @switch($media->type)
                                                @case('image/jpeg')
                                                @case('image/png')
                                                @case('image/webp')
                                                @case('image/jpg')
                                                    <img src="{{ asset('storage/' . $media->path) }}" alt="{{ $media->alt_text ?: 'gallery_image' }}"
                                                        title="{{ $media->title_text }}" class="w-auto h-full">
                                                @break

                                                @case('video/mp4')
                                                    <video src="{{ asset('storage/' . $media->path) }}" controls
                                                        class="h-full w-auto" autoplay muted loop></video>
                                                @break

                                                @default
                                                    <a target="_blank" href="{{ asset('storage/' . $media->path) }}"
                                                        class="btn-secondary-md">Preview Media</a>
                                            @endswitch
                                        </figure>
                                        <div>
                                            <p class="text-center text-xs font-medium leading-relaxed">{{ucwords(str_replace('_',' ',strtolower($media->project_category)))}}</p>
                                        </div>
                                        @can(\App\Enums\Permission::EDIT_CATEGORY->value)
                                        <form action="{{ route('admin.handle.category.media.update', ['id' => $media->id]) }}" method="POST" class="space-y-1">
                                            @csrf
                                            <input type="text" name="alt_text" value="{{ $media->alt_text }}" placeholder="Alt text"
                                                class="input-box-sm w-full" maxlength="255">
                                            <input type="text" name="title_text" value="{{ $media->title_text }}" placeholder="Title text"
                                                class="input-box-sm w-full" maxlength="255">
                                            <button type="submit" class="btn-secondary-sm w-full">Save alt / title</button>
                                        </form>
                                        @endcan
                                        @can(\App\Enums\Permission::DELETE_CATEGORY->value)
                                        <button type="button" class="btn-danger-sm flex items-center justify-center w-full" onclick="handleMediaDelete('{{ $media->id }}')">
                                            <span class="lg:block md:block sm:hidden mr-2">Delete</span>
                                            <i data-feather="trash"></i>
                                        </button>
                                        @endcan
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @error('category_media')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
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
        document.getElementById('category-tab').classList.add('active');

        // const handleThumbnailPreview = (event) => {
        //     if (event.target.files.length == 0) {
        //         document.getElementById('thumbnail_image').src = "{{ is_null($category->thumbnail_image) ? asset('admin/images/default-thumbnail.png') : asset('storage/' . $category->thumbnail_image) }}";
        //     } else {
        //         document.getElementById('thumbnail_image').src = URL.createObjectURL(event.target.files[0])
        //     }
        // }
        // Update handleThumbnailPreview function to handle both thumbnail and cover image previews
        function handleThumbnailPreview(event) {
        const thumbnailContainer = document.getElementById('thumbnail_preview_container');
        thumbnailContainer.innerHTML = ''; // Clear previous content

        const file = event.target.files[0];
        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (fileExtension.match(/(jpg|jpeg|png|gif|webp)$/)) {
            const image = document.createElement('img');
            image.setAttribute('src', URL.createObjectURL(file));
            image.setAttribute('alt', 'thumbnail_image');
            image.setAttribute('class', 'input-thumbnail-preview');
            thumbnailContainer.appendChild(image);
        } else if (fileExtension === 'mp4' || file.type.includes('video')) {
            const video = document.createElement('video');
            video.setAttribute('controls', '');
            video.setAttribute('class', 'input-thumbnail-preview');
            video.setAttribute('autoplay', '');
            video.setAttribute('muted', '');
            video.setAttribute('loop', '');

            const source = document.createElement('source');
            source.setAttribute('src', URL.createObjectURL(file));
            source.setAttribute('type', 'video/mp4');

            video.appendChild(source);
            thumbnailContainer.appendChild(video);
        }
    }



// Call handleThumbnailPreview when the user selects a thumbnail image
document.querySelector('input[name="thumbnail_image"]').addEventListener('change', handleThumbnailPreview);

    const handleCoverImagePreview = (event) => {
    const container = document.getElementById('cover_preview_container');
    container.innerHTML = ''; // Clear previous preview

    const file = event.target.files[0];

    if (file.type.includes('image')) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = 'input-thumbnail-preview';
        container.appendChild(img);
    } else if (file.type.includes('video')) {
        const video = document.createElement('video');
        video.src = URL.createObjectURL(file);
        video.controls = true;
        video.className = 'input-thumbnail-preview';
        container.appendChild(video);
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
                    case "image/mp4":
                    case "image/gif":
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

        @can(\App\Enums\Permission::DELETE_CATEGORY->value)
        const handleDelete = () => {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this category!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location =
                            "{{ route('admin.handle.category.delete', ['id' => $category->id]) }}";
                    }
                });
        }

        const handleMediaDelete = (id) => {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this image!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = `{{ url('admin/category/media/delete') }}/${id}`;
                    }
                });
        }
        @endcan

    </script>
@endsection
