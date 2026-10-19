@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.seo.list') }}">SEO</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="#">Edit SEO Meta</a></li>
        </ul>
        <h1 class="panel-title">Edit SEO Meta</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.seo.update', ['id' => $meta->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Google-style search result preview --}}
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Search Result Preview</h1>
                    <p class="panel-card-description">How this page may appear in Google search results</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="p-4 border rounded-md bg-white" style="font-family: arial, sans-serif; max-width: 600px;">
                    <div id="serp_preview_url" style="color: #202124; font-size: 14px;">{{ $meta->canonical_url ?: url('/') }}</div>
                    <div id="serp_preview_title" style="color: #1a0dab; font-size: 20px; line-height: 1.3; margin: 2px 0;"></div>
                    <div id="serp_preview_description" style="color: #4d5156; font-size: 14px; line-height: 1.4;"></div>
                </div>
            </div>
        </figure>

        {{-- SEO checklist --}}
        @php
            $titleLen = mb_strlen((string) $meta->meta_title);
            $descLen = mb_strlen((string) $meta->meta_description);
            $schemaOk = !$meta->schema_json || json_decode($meta->schema_json) !== null;
            $hasOgImage = $meta->og_image || \App\Models\SeoSetting::query()->value('default_og_image');
            $checks = [
                ['Meta title is 30–60 characters', $titleLen >= 30 && $titleLen <= 60, $titleLen . ' characters'],
                ['Meta description is 70–160 characters', $descLen >= 70 && $descLen <= 160, $descLen . ' characters'],
                ['Focus keyword appears in the title', $meta->focus_keyword ? str_contains(mb_strtolower((string) $meta->meta_title), mb_strtolower($meta->focus_keyword)) : null, $meta->focus_keyword ?: 'no focus keyword set'],
                ['Page is indexable', (bool) $meta->robots_index, $meta->robots_index ? 'index' : 'noindex'],
                ['Included in sitemap.xml', !$meta->exclude_from_sitemap && $meta->robots_index, $meta->exclude_from_sitemap ? 'excluded' : ($meta->robots_index ? 'included' : 'excluded (noindex)')],
                ['Share image available (page or site default)', (bool) $hasOgImage, $meta->og_image ? 'page image' : ($hasOgImage ? 'site default' : 'none')],
                ['Custom schema JSON is valid', $schemaOk, $meta->schema_json ? ($schemaOk ? 'valid' : 'invalid JSON') : 'none (automatic schema only)'],
            ];
        @endphp
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">SEO Checklist</h1>
                    <p class="panel-card-description">Quick checks for the saved values of this page</p>
                </div>
            </div>
            <div class="panel-card-body">
                <ul style="list-style:none;margin:0;padding:0;display:grid;gap:8px;">
                    @foreach ($checks as [$label, $ok, $detail])
                        <li style="display:flex;gap:10px;align-items:baseline;">
                            <span aria-hidden="true" style="font-weight:700;color:{{ $ok === null ? '#64748b' : ($ok ? '#15803d' : '#b91c1c') }}">{{ $ok === null ? '–' : ($ok ? '✓' : '✗') }}</span>
                            <span>{{ $label }} <span class="text-xs text-slate-500">({{ $detail }})</span></span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </figure>

        {{-- Basic SEO --}}
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
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $meta->meta_title) }}"
                            class="input-box-md @error('meta_title') input-invalid @enderror" maxlength="70" oninput="updateCounter('meta_title', 60)">
                        <span id="meta_title_counter" class="text-xs text-slate-400"></span>
                        @error('meta_title') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Meta Description <span>(Optional, recommended ~160 characters)</span></label>
                        <textarea name="meta_description" id="meta_description" rows="3"
                            class="input-box-md @error('meta_description') input-invalid @enderror" maxlength="300"
                            oninput="updateCounter('meta_description', 160)">{{ old('meta_description', $meta->meta_description) }}</textarea>
                        <span id="meta_description_counter" class="text-xs text-slate-400"></span>
                        @error('meta_description') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Meta Keywords <span>(Optional)</span></label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $meta->meta_keywords) }}"
                            class="input-box-md @error('meta_keywords') input-invalid @enderror" maxlength="255">
                        @error('meta_keywords') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Focus Keyword <span>(Optional)</span></label>
                        <input type="text" name="focus_keyword" value="{{ old('focus_keyword', $meta->focus_keyword) }}"
                            class="input-box-md @error('focus_keyword') input-invalid @enderror" maxlength="100">
                        @error('focus_keyword') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Canonical URL <span>(Optional)</span></label>
                        <input type="text" name="canonical_url" value="{{ old('canonical_url', $meta->canonical_url) }}"
                            class="input-box-md @error('canonical_url') input-invalid @enderror" maxlength="500">
                        @error('canonical_url') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">H1 Override <span>(Optional)</span></label>
                        <input type="text" name="h1_override" value="{{ old('h1_override', $meta->h1_override) }}"
                            class="input-box-md @error('h1_override') input-invalid @enderror" maxlength="150">
                        @error('h1_override') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Page Copy <span>(Optional. Unique body text shown on /locations/&lt;city&gt; pages; such a page is only indexable once it has {{ \App\Services\LocationPageGate::MIN_WORDS }}+ words here and every site has a photo, area and size.)</span></label>
                        <textarea name="page_copy" rows="8" class="input-box-md @error('page_copy') input-invalid @enderror">{{ old('page_copy', $meta->page_copy) }}</textarea>
                        @error('page_copy') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Use Title As Written <span>(On: the meta title is used exactly as entered. Off: it is placed into the title template from SEO Settings, e.g. "Title | Krishna Outdoor".)</span></label>
                        <label class="toggler-switch">
                            <input type="checkbox" name="skip_title_template" value="1" @checked(old('skip_title_template', $meta->skip_title_template))>
                            <div class="slider"></div>
                        </label>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Robots Index</label>
                        <label class="toggler-switch">
                            <input type="checkbox" name="robots_index" value="1" @checked(old('robots_index', $meta->robots_index))>
                            <div class="slider"></div>
                        </label>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Robots Follow</label>
                        <label class="toggler-switch">
                            <input type="checkbox" name="robots_follow" value="1" @checked(old('robots_follow', $meta->robots_follow))>
                            <div class="slider"></div>
                        </label>
                    </div>

                </div>
            </div>
        </figure>

        {{-- Social Media --}}
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
                        <input type="text" name="og_title" value="{{ old('og_title', $meta->og_title) }}"
                            class="input-box-md @error('og_title') input-invalid @enderror">
                        @error('og_title') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">OG Type <span>(Optional)</span></label>
                        <select name="og_type" class="input-box-md @error('og_type') input-invalid @enderror">
                            <option value="">Select type</option>
                            <option value="website" @selected(old('og_type', $meta->og_type) == 'website')>Website</option>
                            <option value="article" @selected(old('og_type', $meta->og_type) == 'article')>Article</option>
                        </select>
                        @error('og_type') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">OG Description <span>(Optional)</span></label>
                        <textarea name="og_description" rows="3"
                            class="input-box-md @error('og_description') input-invalid @enderror">{{ old('og_description', $meta->og_description) }}</textarea>
                        @error('og_description') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">OG Image <span>(Optional, Format: png, jpg, jpeg, webp)</span></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="handleImagePreview(event, 'og_image_preview')" name="og_image">
                                <i data-feather="upload-cloud"></i>
                                <span>Drag and Drop Image Files</span>
                            </div>
                            <img src="{{ $meta->og_image ? asset('storage/' . $meta->og_image) : asset('admin/images/default-thumbnail.png') }}"
                                id="og_image_preview" alt="preview" class="input-thumbnail-preview">
                        </div>
                        @error('og_image') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Twitter Card <span>(Optional)</span></label>
                        <input type="text" name="twitter_card" value="{{ old('twitter_card', $meta->twitter_card) }}"
                            class="input-box-md @error('twitter_card') input-invalid @enderror" placeholder="e.g. summary_large_image">
                        @error('twitter_card') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label class="input-label">Twitter Title <span>(Optional)</span></label>
                        <input type="text" name="twitter_title" value="{{ old('twitter_title', $meta->twitter_title) }}"
                            class="input-box-md @error('twitter_title') input-invalid @enderror">
                        @error('twitter_title') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Twitter Description <span>(Optional)</span></label>
                        <textarea name="twitter_description" rows="3"
                            class="input-box-md @error('twitter_description') input-invalid @enderror">{{ old('twitter_description', $meta->twitter_description) }}</textarea>
                        @error('twitter_description') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lg:col-span-2 md:col-span-2 sm:col-span-1">
                        <label class="input-label">Twitter Image <span>(Optional, Format: png, jpg, jpeg, webp)</span></label>
                        <div class="flex space-x-3 my-2">
                            <div class="input-box-dragable">
                                <input type="file" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="handleImagePreview(event, 'twitter_image_preview')" name="twitter_image">
                                <i data-feather="upload-cloud"></i>
                                <span>Drag and Drop Image Files</span>
                            </div>
                            <img src="{{ $meta->twitter_image ? asset('storage/' . $meta->twitter_image) : asset('admin/images/default-thumbnail.png') }}"
                                id="twitter_image_preview" alt="preview" class="input-thumbnail-preview">
                        </div>
                        @error('twitter_image') <span class="input-error">{{ $message }}</span> @enderror
                    </div>

                </div>
            </div>
        </figure>

        {{-- Schema / Structured Data --}}
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
                            class="input-box-md @error('schema_json') input-invalid @enderror">{{ old('schema_json', $meta->schema_json) }}</textarea>
                        @error('schema_json') <span class="input-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </figure>

        {{-- Sitemap --}}
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Sitemap</h1>
                    <p class="panel-card-description">Control sitemap inclusion for this page/item. Pages set to noindex are always left out. sitemap.xml regenerates automatically on save.</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-5">
                    <div class="input-group">
                        <label class="input-label">Exclude from Sitemap</label>
                        <label class="toggler-switch">
                            <input type="checkbox" name="exclude_from_sitemap" value="1" @checked(old('exclude_from_sitemap', $meta->exclude_from_sitemap))>
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

    {{-- Revision History --}}
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Revision History</h1>
                <p class="panel-card-description">Previous versions of this page's SEO meta; restore any of them</p>
            </div>
        </div>
        <div class="panel-card-body">
            @if ($revisions->isEmpty())
                <p class="text-sm text-slate-400">No changes have been made yet.</p>
            @else
                <div class="panel-card-table">
                    <table class="data-table">
                        <thead>
                            <th>Saved At</th>
                            <th>Saved By</th>
                            <th>Meta Title</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($revisions as $revision)
                                <tr>
                                    <td>{{ $revision->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $revision->admin?->name ?? '-' }}</td>
                                    <td>{{ $revision->snapshot_json['meta_title'] ?? '-' }}</td>
                                    <td>
                                        @can(\App\Enums\Permission::EDIT_SEO->value)
                                            <form action="{{ route('admin.handle.seo.revision.restore', ['id' => $meta->id, 'revisionId' => $revision->id]) }}" method="POST"
                                                onsubmit="return confirm('Restore SEO meta to this revision? The current values will be saved as a new revision.');">
                                                @csrf
                                                <button type="submit" class="btn-secondary-sm">Restore</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </figure>
@endsection

@section('panel-script')
    <script>
        document.getElementById('seo-tab').classList.add('active');

        const originalOgImage = "{{ $meta->og_image ? asset('storage/' . $meta->og_image) : asset('admin/images/default-thumbnail.png') }}";
        const originalTwitterImage = "{{ $meta->twitter_image ? asset('storage/' . $meta->twitter_image) : asset('admin/images/default-thumbnail.png') }}";

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
            const title = document.getElementById('meta_title').value || "{{ addslashes($meta->meta_title ?: 'Untitled Page') }}";
            const description = document.getElementById('meta_description').value || "{{ addslashes($meta->meta_description ?: 'No meta description set.') }}";
            document.getElementById('serp_preview_title').textContent = title;
            document.getElementById('serp_preview_description').textContent = description;
        }

        updateCounter('meta_title', 60);
        updateCounter('meta_description', 160);
    </script>
@endsection
