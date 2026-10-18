<?php $__env->startSection('panel-header'); ?>
    <div>
        <ul class="breadcrumb">
            <li><a href="<?php echo e(route('admin.view.dashboard')); ?>">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="<?php echo e(route('admin.view.category.list')); ?>">Categories</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="<?php echo e(route('admin.view.category.update', ['id' => $category->id])); ?>">Edit Category</a></li>
        </ul>
        <h1 class="panel-title">Edit Category</h1>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('panel-body'); ?>
    <form action="<?php echo e(route('admin.handle.category.update', ['id' => $category->id])); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Edit Information</h1>
                    <p class="panel-card-description">Please fill the required fields</p>
                </div>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Enums\Permission::DELETE_CATEGORY->value)): ?>
                <div>
                    <button type="button" class="btn-danger-sm flex items-center justify-center" onclick="handleDelete()">
                        <span class="lg:block md:block sm:hidden mr-2">Delete</span>
                        <i data-feather="trash"></i>
                    </button>
                </div>
                <?php endif; ?>

            </div>
            <div class="panel-card-body">
                <div class="grid 2xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    
                    <div class="input-group">
                        <label for="name" class="input-label">Name <em>*</em></label>
                        <input type="text" name="name" value="<?php echo e(old('name', $category->name)); ?>"
                            class="input-box-md <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter Name"
                            minlength="1" maxlength="250" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="input-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="input-group">
                        <label for="priority" class="input-label">Priority <span>(Optional)</span></label>
                        <input type="number" name="priority" value="<?php echo e(old('priority', $category->priority)); ?>"
                            class="input-box-md <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter Priority"
                            min="0" max="1000">
                        <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="input-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="input-group">
                        <label for="slug" class="input-label">Slug <em>*</em></label>
                        <input type="text" name="slug" value="<?php echo e(old('slug', $category->slug)); ?>"
                            class="input-box-md <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter Slug"
                            minlength="1" maxlength="250" required>
                        <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="input-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <?php if(!is_null($category->category_id)): ?>
                    
                    <div class="flex flex-col">
                        <label for="category_id" class="input-label">Parent Category (Optional)</label>
                        <select name="category_id" class="input-box-md <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <option value="">Select Parent Category</option>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($item->category_id == null): ?>
            <option value="<?php echo e($item->id); ?>" <?php if(old('category_id', $category->category_id) == $item->id): ?> selected <?php endif; ?>><?php echo e($item->name); ?></option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($subItem->category_id == $item->id): ?>
                    <option value="<?php echo e($subItem->id); ?>" <?php if(old('category_id', $category->category_id) == $subItem->id): ?> selected <?php endif; ?> class="sub-category">&nbsp;&nbsp;<?php echo e($subItem->name); ?></option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thirdLevelItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($thirdLevelItem->category_id == $subItem->id): ?>
                            <option value="<?php echo e($thirdLevelItem->id); ?>" <?php if(old('category_id', $category->category_id) == $thirdLevelItem->id): ?> selected <?php endif; ?> class="sub-sub-category">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo e($thirdLevelItem->name); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>



                        <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="input-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <?php endif; ?>


                    
                    <div class="input-group 2xl:col-span-5 lg:col-span-4 md:col-span-2">
                        <label for="summary" class="input-label">Summary <em>*</em></label>
                        <input type="text" name="summary" value="<?php echo e(old('summary', $category->summary)); ?>"
                            class="input-box-md <?php $__errorArgs = ['summary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter Summary"
                            required minlength="1" maxlength="500">
                        <?php $__errorArgs = ['summary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="input-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
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
                                class="input-box-md <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" contenteditable="true"
                                id="html-editor">
                                <?php echo old('description', $category->description); ?>

                            </div>
                            <input type="text" name="description" id="description" value="<?php echo e(old('description', $category->description)); ?>"
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
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="input-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="md:col-span-4 sm:col-span-1">
    <label for="thumbnail_image" class="input-label">Thumbnail <span>(Format: png, jpg, jpeg,
            webp, mp4, gif)</span> <span>(For Parent Category: 1000px × 800px)</span> <span>(For Child Category: 720px × 790px)</span> <span>(Optional)</span> </label>
    <div class="flex lg:flex-row md:flex-row sm:flex-col gap-3 my-2">
        <div class="input-box-dragable">
            <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp, image/gif, video/mp4" onchange="handleThumbnailPreview(event)" name="thumbnail_image">
            <i data-feather="upload-cloud"></i>
            <span>Darg and Drop Image/Video Files</span>
            <!-- Hidden input field to retain previous uploaded thumbnail information -->
            <input type="hidden" id="previous_thumbnail" name="previous_thumbnail" value="<?php echo e($category->thumbnail_image); ?>">
        </div>
        <div id="thumbnail_preview_container">
            <!-- Thumbnail preview will be displayed here -->
            <?php if(strpos($category->thumbnail_image, '.jpg') !== false || strpos($category->thumbnail_image, '.png') !== false || strpos($category->thumbnail_image, '.jpeg') !== false || strpos($category->thumbnail_image, '.gif') !== false): ?>
                <!-- If the previous thumbnail is an image -->
                <img src="<?php echo e(is_null($category->thumbnail_image) ? asset('admin/images/default-thumbnail.png') : asset('storage/' . $category->thumbnail_image)); ?>" id="previous_thumbnail_preview" alt="previous_thumbnail" class="input-thumbnail-preview">
            <?php elseif(strpos($category->thumbnail_image, '.mp4') !== false || strpos($category->thumbnail_image, '.webm') !== false || strpos($category->thumbnail_image, '.ogg') !== false): ?>
                <!-- If the previous thumbnail is a video -->
                <video controls id="previous_thumbnail_preview" class="input-thumbnail-preview" autoplay muted loop>
                    <source src="<?php echo e(asset('storage/' . $category->thumbnail_image)); ?>" type="video/mp4">
                </video>
            <?php endif; ?>
        </div>
    </div>
    <?php $__errorArgs = ['thumbnail_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <span class="input-error"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

                    
                    <div class="md:col-span-4 sm:col-span-1">
                        <label for="cover_image" class="input-label">Cover Image <span>(Format: png, jpg, jpeg, webp, mp4, gif)</span> <span>(Size: 1400px × 450px)</span> <span>(Optional)</span> </label>
                        <div class="flex lg:flex-row md:flex-row sm:flex-col gap-3 my-2">
                        <div class="input-box-dragable">
                        <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp, image/gif, video/mp4" onchange="handleCoverImagePreview(event)" name="cover_image">
                        <i data-feather="upload-cloud"></i>
                        <span>Drag and Drop Image/Video Files</span>
                        </div>
                        <div id="cover_preview_container">

                        <?php if(strpos($category->cover_image, '.jpg') !== false || strpos($category->cover_image, '.png') !== false || strpos($category->cover_image, '.jpeg') !== false || strpos($category->cover_image, '.gif') !== false): ?>
    <!-- If the cover image is an image -->
    <img src="<?php echo e(is_null($category->cover_image) ? asset('admin/images/default-thumbnail.png') : asset('storage/' . $category->cover_image)); ?>" id="cover_image" alt="cover_image" class="input-thumbnail-preview">
<?php elseif(strpos($category->cover_image, '.mp4') !== false || strpos($category->cover_image, '.webm') !== false || strpos($category->cover_image, '.ogg') !== false): ?>
    <!-- If the cover image is a video -->
    <video controls id="cover_video" class="input-thumbnail-preview" autoplay muted loop>
        <source src="<?php echo e(asset('storage/' . $category->cover_image)); ?>" type="video/mp4">
        <!-- Include additional source elements for other video formats if needed -->
        Your browser does not support the video tag.
    </video>
<?php else: ?>
    <!-- If the cover image is neither an image nor a video, show a default thumbnail -->
    <img src="<?php echo e(asset('admin/images/default-thumbnail.png')); ?>" id="cover_image" alt="cover_image" class="input-thumbnail-preview">
<?php endif; ?>

                        </div>
                        <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="input-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>




                    
                    <div class="md:col-span-4 sm:col-span-1">
                        <label for="category_media" class="input-label">Images (Format: png, jpg, jpeg, webp, mp4) <span>(Size: 800px × 1000px)</span></label>
                        <div class="input-group w-fit py-2">
                            <select name="project_category" class="input-box-md <?php $__errorArgs = ['project_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" >
                                <option value="">Select Project Category</option>
                                <?php $__currentLoopData = $project_category::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->value); ?>"><?php echo e($item->label()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <?php $__currentLoopData = $category_media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="space-y-2 p-2 border rounded-md h-fit">
                                        <figure
                                            class="border rounded-md h-[200px] w-full flex items-center justify-center bg-slate-200 overflow-clip">
                                            <?php switch($media->type):
                                                case ('image/jpeg'): ?>
                                                <?php case ('image/png'): ?>
                                                <?php case ('image/webp'): ?>
                                                <?php case ('image/jpg'): ?>
                                                    <img src="<?php echo e(asset('storage/' . $media->path)); ?>" alt="<?php echo e($media->alt_text ?: 'gallery_image'); ?>"
                                                        title="<?php echo e($media->title_text); ?>" class="w-auto h-full">
                                                <?php break; ?>

                                                <?php case ('video/mp4'): ?>
                                                    <video src="<?php echo e(asset('storage/' . $media->path)); ?>" controls
                                                        class="h-full w-auto" autoplay muted loop></video>
                                                <?php break; ?>

                                                <?php default: ?>
                                                    <a target="_blank" href="<?php echo e(asset('storage/' . $media->path)); ?>"
                                                        class="btn-secondary-md">Preview Media</a>
                                            <?php endswitch; ?>
                                        </figure>
                                        <div>
                                            <p class="text-center text-xs font-medium leading-relaxed"><?php echo e(ucwords(str_replace('_',' ',strtolower($media->project_category)))); ?></p>
                                        </div>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Enums\Permission::EDIT_CATEGORY->value)): ?>
                                        <form action="<?php echo e(route('admin.handle.category.media.update', ['id' => $media->id])); ?>" method="POST" class="space-y-1">
                                            <?php echo csrf_field(); ?>
                                            <input type="text" name="alt_text" value="<?php echo e($media->alt_text); ?>" placeholder="Alt text"
                                                class="input-box-sm w-full" maxlength="255">
                                            <input type="text" name="title_text" value="<?php echo e($media->title_text); ?>" placeholder="Title text"
                                                class="input-box-sm w-full" maxlength="255">
                                            <button type="submit" class="btn-secondary-sm w-full">Save alt / title</button>
                                        </form>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Enums\Permission::DELETE_CATEGORY->value)): ?>
                                        <button type="button" class="btn-danger-sm flex items-center justify-center w-full" onclick="handleMediaDelete('<?php echo e($media->id); ?>')">
                                            <span class="lg:block md:block sm:hidden mr-2">Delete</span>
                                            <i data-feather="trash"></i>
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php $__errorArgs = ['category_media'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="input-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                </div>
            </div>
            <div class="panel-card-footer">
                <button type="submit" class="btn-primary-md md:w-fit sm:w-full">Save Changes</button>
            </div>
        </figure>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('panel-script'); ?>
    <script>
        document.getElementById('category-tab').classList.add('active');

        // const handleThumbnailPreview = (event) => {
        //     if (event.target.files.length == 0) {
        //         document.getElementById('thumbnail_image').src = "<?php echo e(is_null($category->thumbnail_image) ? asset('admin/images/default-thumbnail.png') : asset('storage/' . $category->thumbnail_image)); ?>";
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

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Enums\Permission::DELETE_CATEGORY->value)): ?>
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
                            "<?php echo e(route('admin.handle.category.delete', ['id' => $category->id])); ?>";
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
                        window.location = `<?php echo e(url('admin/category/media/delete')); ?>/${id}`;
                    }
                });
        }
        <?php endif; ?>

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/admin/pages/category/category-update.blade.php ENDPATH**/ ?>