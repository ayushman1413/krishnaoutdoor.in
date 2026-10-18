<?php $__env->startSection('panel-header'); ?>
    <div>
        <ul class="breadcrumb">
            <li><a href="<?php echo e(route('admin.view.dashboard')); ?>">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="<?php echo e(route('admin.view.seo.list')); ?>">SEO</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="#">Edit SEO Meta</a></li>
        </ul>
        <h1 class="panel-title">Edit SEO Meta</h1>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('panel-body'); ?>
    <form action="<?php echo e(route('admin.handle.seo.update', ['id' => $meta->id])); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Search Result Preview</h1>
                    <p class="panel-card-description">How this page may appear in Google search results</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="p-4 border rounded-md bg-white" style="font-family: arial, sans-serif; max-width: 600px;">
                    <div id="serp_preview_url" style="color: #202124; font-size: 14px;"><?php echo e($meta->canonical_url ?: url('/')); ?></div>
                    <div id="serp_preview_title" style="color: #1a0dab; font-size: 20px; line-height: 1.3; margin: 2px 0;"></div>
                    <div id="serp_preview_description" style="color: #4d5156; font-size: 14px; line-height: 1.4;"></div>
                </div>
            </div>
        </figure>

        
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Basic SEO</h1>
                    <p class="panel-card-description">Core meta information used by search engines</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    <div class="input-group lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Meta Title <span>(Optional, recommended ~60 characters)</span></label>
                        <input type="text" name="meta_title" id="meta_title" value="<?php echo e(old('meta_title', $meta->meta_title)); ?>"
                            class="input-box-md <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="70" oninput="updateCounter('meta_title', 60)">
                        <span id="meta_title_counter" class="text-xs text-slate-400"></span>
                        <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Meta Description <span>(Optional, recommended ~160 characters)</span></label>
                        <textarea name="meta_description" id="meta_description" rows="3"
                            class="input-box-md <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="300"
                            oninput="updateCounter('meta_description', 160)"><?php echo e(old('meta_description', $meta->meta_description)); ?></textarea>
                        <span id="meta_description_counter" class="text-xs text-slate-400"></span>
                        <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Meta Keywords <span>(Optional)</span></label>
                        <input type="text" name="meta_keywords" value="<?php echo e(old('meta_keywords', $meta->meta_keywords)); ?>"
                            class="input-box-md <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="255">
                        <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Focus Keyword <span>(Optional)</span></label>
                        <input type="text" name="focus_keyword" value="<?php echo e(old('focus_keyword', $meta->focus_keyword)); ?>"
                            class="input-box-md <?php $__errorArgs = ['focus_keyword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="100">
                        <?php $__errorArgs = ['focus_keyword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Canonical URL <span>(Optional)</span></label>
                        <input type="text" name="canonical_url" value="<?php echo e(old('canonical_url', $meta->canonical_url)); ?>"
                            class="input-box-md <?php $__errorArgs = ['canonical_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="500">
                        <?php $__errorArgs = ['canonical_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group">
                        <label class="input-label">H1 Override <span>(Optional)</span></label>
                        <input type="text" name="h1_override" value="<?php echo e(old('h1_override', $meta->h1_override)); ?>"
                            class="input-box-md <?php $__errorArgs = ['h1_override'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="150">
                        <?php $__errorArgs = ['h1_override'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Robots Index</label>
                        <label class="toggler-switch">
                            <input type="checkbox" name="robots_index" value="1" <?php if(old('robots_index', $meta->robots_index)): echo 'checked'; endif; ?>>
                            <div class="slider"></div>
                        </label>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Robots Follow</label>
                        <label class="toggler-switch">
                            <input type="checkbox" name="robots_follow" value="1" <?php if(old('robots_follow', $meta->robots_follow)): echo 'checked'; endif; ?>>
                            <div class="slider"></div>
                        </label>
                    </div>

                </div>
            </div>
        </figure>

        
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Social Media (Open Graph & Twitter)</h1>
                    <p class="panel-card-description">Controls how this page appears when shared on social platforms</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    <div class="input-group">
                        <label class="input-label">OG Title <span>(Optional)</span></label>
                        <input type="text" name="og_title" value="<?php echo e(old('og_title', $meta->og_title)); ?>"
                            class="input-box-md <?php $__errorArgs = ['og_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['og_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group">
                        <label class="input-label">OG Type <span>(Optional)</span></label>
                        <select name="og_type" class="input-box-md <?php $__errorArgs = ['og_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Select type</option>
                            <option value="website" <?php if(old('og_type', $meta->og_type) == 'website'): echo 'selected'; endif; ?>>Website</option>
                            <option value="article" <?php if(old('og_type', $meta->og_type) == 'article'): echo 'selected'; endif; ?>>Article</option>
                        </select>
                        <?php $__errorArgs = ['og_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">OG Description <span>(Optional)</span></label>
                        <textarea name="og_description" rows="3"
                            class="input-box-md <?php $__errorArgs = ['og_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('og_description', $meta->og_description)); ?></textarea>
                        <?php $__errorArgs = ['og_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">OG Image <span>(Optional, Format: png, jpg, jpeg, webp)</span></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="handleImagePreview(event, 'og_image_preview')" name="og_image">
                                <i data-feather="upload-cloud"></i>
                                <span>Drag and Drop Image Files</span>
                            </div>
                            <img src="<?php echo e($meta->og_image ? asset('storage/' . $meta->og_image) : asset('admin/images/default-thumbnail.png')); ?>"
                                id="og_image_preview" alt="preview" class="input-thumbnail-preview">
                        </div>
                        <?php $__errorArgs = ['og_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Twitter Card <span>(Optional)</span></label>
                        <input type="text" name="twitter_card" value="<?php echo e(old('twitter_card', $meta->twitter_card)); ?>"
                            class="input-box-md <?php $__errorArgs = ['twitter_card'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="e.g. summary_large_image">
                        <?php $__errorArgs = ['twitter_card'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Twitter Title <span>(Optional)</span></label>
                        <input type="text" name="twitter_title" value="<?php echo e(old('twitter_title', $meta->twitter_title)); ?>"
                            class="input-box-md <?php $__errorArgs = ['twitter_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['twitter_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Twitter Description <span>(Optional)</span></label>
                        <textarea name="twitter_description" rows="3"
                            class="input-box-md <?php $__errorArgs = ['twitter_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('twitter_description', $meta->twitter_description)); ?></textarea>
                        <?php $__errorArgs = ['twitter_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Twitter Image <span>(Optional, Format: png, jpg, jpeg, webp)</span></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="handleImagePreview(event, 'twitter_image_preview')" name="twitter_image">
                                <i data-feather="upload-cloud"></i>
                                <span>Drag and Drop Image Files</span>
                            </div>
                            <img src="<?php echo e($meta->twitter_image ? asset('storage/' . $meta->twitter_image) : asset('admin/images/default-thumbnail.png')); ?>"
                                id="twitter_image_preview" alt="preview" class="input-thumbnail-preview">
                        </div>
                        <?php $__errorArgs = ['twitter_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                </div>
            </div>
        </figure>

        
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Schema / Structured Data</h1>
                    <p class="panel-card-description">Raw JSON-LD schema markup for this page/item</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid lg:grid-cols-1 gap-5">
                    <div class="input-group">
                        <label class="input-label">Schema JSON <span>(Optional, must be valid JSON)</span></label>
                        <textarea name="schema_json" rows="8" style="font-family: monospace;"
                            class="input-box-md <?php $__errorArgs = ['schema_json'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('schema_json', $meta->schema_json)); ?></textarea>
                        <?php $__errorArgs = ['schema_json'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </figure>

        
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Sitemap</h1>
                    <p class="panel-card-description">Control sitemap inclusion for this page/item</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-5">
                    <div class="input-group">
                        <label class="input-label">Exclude from Sitemap</label>
                        <label class="toggler-switch">
                            <input type="checkbox" name="exclude_from_sitemap" value="1" <?php if(old('exclude_from_sitemap', $meta->exclude_from_sitemap)): echo 'checked'; endif; ?>>
                            <div class="slider"></div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="panel-card-footer">
                <button type="submit" class="btn-primary-md md:w-fit sm:w-full">Save Changes</button>
            </div>
        </figure>
    </form>

    
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Revision History</h1>
                <p class="panel-card-description">Previous versions of this page's SEO meta; restore any of them</p>
            </div>
        </div>
        <div class="panel-card-body">
            <?php if($revisions->isEmpty()): ?>
                <p class="text-sm text-slate-400">No changes have been made yet.</p>
            <?php else: ?>
                <div class="panel-card-table">
                    <table class="data-table">
                        <thead>
                            <th>Saved At</th>
                            <th>Saved By</th>
                            <th>Meta Title</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $revisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $revision): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($revision->created_at->format('d M Y, h:i A')); ?></td>
                                    <td><?php echo e($revision->admin?->name ?? '-'); ?></td>
                                    <td><?php echo e($revision->snapshot_json['meta_title'] ?? '-'); ?></td>
                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Enums\Permission::EDIT_SEO->value)): ?>
                                            <form action="<?php echo e(route('admin.handle.seo.revision.restore', ['id' => $meta->id, 'revisionId' => $revision->id])); ?>" method="POST"
                                                onsubmit="return confirm('Restore SEO meta to this revision? The current values will be saved as a new revision.');">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn-secondary-sm">Restore</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </figure>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('panel-script'); ?>
    <script>
        document.getElementById('seo-tab').classList.add('active');

        const originalOgImage = "<?php echo e($meta->og_image ? asset('storage/' . $meta->og_image) : asset('admin/images/default-thumbnail.png')); ?>";
        const originalTwitterImage = "<?php echo e($meta->twitter_image ? asset('storage/' . $meta->twitter_image) : asset('admin/images/default-thumbnail.png')); ?>";

        const handleImagePreview = (event, previewId) => {
            const original = previewId === 'og_image_preview' ? originalOgImage : originalTwitterImage;
            document.getElementById(previewId).src = event.target.files.length == 0
                ? original
                : URL.createObjectURL(event.target.files[0]);
        }

        const updateCounter = (fieldId, target) => {
            const field = document.getElementById(fieldId);
            const counter = document.getElementById(fieldId + '_counter');
            const length = field.value.length;
            counter.textContent = `${length}/${target}`;
            counter.classList.toggle('text-red-500', length > target);
            counter.classList.toggle('text-slate-400', length <= target);
            updateSerpPreview();
        }

        const updateSerpPreview = () => {
            const title = document.getElementById('meta_title').value || "<?php echo e(addslashes($meta->meta_title ?: 'Untitled Page')); ?>";
            const description = document.getElementById('meta_description').value || "<?php echo e(addslashes($meta->meta_description ?: 'No meta description set.')); ?>";
            document.getElementById('serp_preview_title').textContent = title;
            document.getElementById('serp_preview_description').textContent = description;
        }

        updateCounter('meta_title', 60);
        updateCounter('meta_description', 160);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/admin/pages/seo/seo-update.blade.php ENDPATH**/ ?>