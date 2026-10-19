@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.content.list') }}">Page Content</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="#">{{ $meta->displayName() }}</a></li>
        </ul>
        <h1 class="panel-title">Edit Page Content: {{ $meta->displayName() }}</h1>
    </div>
@endsection

@section('panel-body')
    <style>#panel-section { min-width: 0; } .content-edit .panel-card-header { flex-wrap: wrap; gap: 12px; }</style>
    <form class="content-edit" action="{{ route('admin.handle.content.update', ['id' => $meta->id]) }}" method="POST" id="content-form">
        @csrf

        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Heading structure</h1>
                    <p class="panel-card-description">
                        Live outline of this page's headings. A page needs exactly one H1, and levels should not skip (H2 → H4).
                        @if ($meta->publicPath()) <a href="{{ url($meta->publicPath()) }}" target="_blank" rel="noopener" class="underline">View page</a> @endif
                    </p>
                </div>
            </div>
            <div class="panel-card-body">
                <ul id="outline" style="list-style:none;margin:0;padding:0;display:grid;gap:4px;font-size:13px;"></ul>
                <p id="outline-warnings" class="input-error" style="margin-top:10px;"></p>
            </div>
        </figure>

        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Headings &amp; paragraphs on the page</h1>
                    <p class="panel-card-description">
                        Change the text or heading level (H2–H6) of anything below. Leave a box unchanged, or empty, to keep the original wording.
                        In headings, <code>&lt;em&gt;…&lt;/em&gt;</code> makes the highlighted (red) part and <code>&lt;br&gt;</code> a line break.
                        Page FAQ answers and lists built from the database (campaigns, categories, locations, testimonials) are edited in their own sections.
                    </p>
                </div>
                <div class="flex items-center flex-wrap gap-2">
                    <button type="button" class="btn-secondary-md" data-filter="all">All</button>
                    <button type="button" class="btn-secondary-md" data-filter="heading">Headings</button>
                    <button type="button" class="btn-secondary-md" data-filter="p">Paragraphs</button>
                </div>
            </div>
            <div class="panel-card-body">
                @if ($scanFailed)
                    <p class="input-error">This page could not be rendered here, so its headings and paragraphs are not listed. Body text and links below still work.</p>
                @elseif (empty($rows))
                    <p class="text-sm text-slate-400">This page has no editable headings or paragraphs in its template.</p>
                @endif

                <div style="display:grid;gap:14px;">
                    @foreach ($rows as $i => $row)
                        <div class="cms-row" data-kind="{{ $row['is_heading'] ? 'heading' : 'p' }}" data-default-level="{{ $row['tag'] }}"
                            style="border:1px solid #e2e8f0;border-radius:8px;padding:12px;display:grid;gap:8px;">
                            <input type="hidden" name="elements[{{ $i }}][key]" value="{{ $row['key'] }}">
                            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                                @if ($row['is_h1'])
                                    <span class="text-xs" style="font-weight:700;background:#fee2e2;color:#991b1b;border-radius:4px;padding:2px 8px;" data-level-badge data-level="h1">H1</span>
                                    <span class="text-xs text-slate-400">Main page heading (one per page, always H1). Also editable under SEO › H1 Override.</span>
                                @elseif ($row['is_heading'])
                                    <select name="elements[{{ $i }}][level]" class="input-box-md" style="width:auto;min-width:84px;" data-level-select aria-label="Heading level">
                                        @foreach (array_values(array_unique(array_merge($row['tag'] === 'h1' ? ['h1'] : [], \App\Services\Cms\Cms::LEVELS))) as $level)
                                            <option value="{{ $level }}" @selected($row['level'] === $level)>{{ strtoupper($level) }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="text-xs" style="font-weight:700;background:#e2e8f0;color:#334155;border-radius:4px;padding:2px 8px;">Paragraph</span>
                                @endif
                                @if ($row['changed'])<span class="text-xs" style="color:#b45309;">changed</span>@endif
                                @unless ($row['is_h1'])
                                    <button type="button" class="btn-secondary-sm" data-reset>Reset to original</button>
                                @endunless
                            </div>
                            @if ($row['is_h1'])
                                <input type="text" name="h1_override" value="{{ old('h1_override', $meta->h1_override) }}" maxlength="150"
                                    class="input-box-md" placeholder="{{ \App\Services\Cms\Cms::text($row['default']) }}" aria-label="H1 text">
                                @error('h1_override') <span class="input-error">{{ $message }}</span> @enderror
                            @else
                                <textarea name="elements[{{ $i }}][content]" rows="{{ $row['is_heading'] ? 2 : 4 }}" class="input-box-md"
                                    data-original="{{ \App\Services\Cms\Cms::forEditing($row['default']) }}" aria-label="Text">{{ old("elements.$i.content", \App\Services\Cms\Cms::forEditing($row['content'])) }}</textarea>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if ($unused->isNotEmpty())
                    <div style="margin-top:18px;">
                        <p class="input-label">Unused changes <span>(the template text these belonged to no longer exists; tick to delete)</span></p>
                        @foreach ($unused as $item)
                            <label style="display:flex;gap:8px;align-items:baseline;font-size:13px;margin-top:6px;">
                                <input type="checkbox" name="unused[]" value="{{ $item->element_key }}">
                                <span>{{ \Illuminate\Support\Str::limit(\App\Services\Cms\Cms::text((string) ($item->content ?? $item->original)), 120) }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>
        </figure>

        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Page text block</h1>
                    <p class="panel-card-description">
                        1–2 paragraphs shown at the bottom of the page, above the footer. Plain text works (blank line = new paragraph);
                        use the buttons for H2–H6 headings, bold, lists and internal links.
                        @if ($meta->route_name && str_starts_with($meta->route_name, 'view.locations.city.'))
                            A location page is only indexable once this text has {{ \App\Services\LocationPageGate::MIN_WORDS }}+ words and every site has a photo, area and size.
                        @endif
                    </p>
                </div>
            </div>
            <div class="panel-card-body">
                <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:8px;align-items:center;" id="copy-toolbar">
                    <button type="button" class="btn-secondary-sm" data-wrap="p">¶ Paragraph</button>
                    <button type="button" class="btn-secondary-sm" data-wrap="h2">H2</button>
                    <button type="button" class="btn-secondary-sm" data-wrap="h3">H3</button>
                    <button type="button" class="btn-secondary-sm" data-wrap="h4">H4</button>
                    <button type="button" class="btn-secondary-sm" data-wrap="strong"><b>B</b></button>
                    <button type="button" class="btn-secondary-sm" data-wrap="em"><i>I</i></button>
                    <button type="button" class="btn-secondary-sm" data-wrap="ul">• List</button>
                    <select id="copy-link-target" class="input-box-md" style="width:auto;max-width:320px;" aria-label="Insert internal link to a page">
                        <option value="">Insert internal link to…</option>
                        @foreach ($linkTargets as $target)
                            <option value="{{ $target['url'] }}">{{ $target['label'] }} ({{ $target['url'] }})</option>
                        @endforeach
                    </select>
                </div>
                <textarea name="page_copy" id="page_copy" rows="10" style="width:100%;" class="input-box-md @error('page_copy') input-invalid @enderror">{{ old('page_copy', $meta->page_copy) }}</textarea>
                @error('page_copy') <span class="input-error">{{ $message }}</span> @enderror
                <span id="page_copy_counter" class="text-xs text-slate-400"></span>
            </div>
        </figure>

        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Related pages (internal links)</h1>
                    <p class="panel-card-description">Link buttons shown under the text block. Up to 12. Pick a page to fill label and address, or type your own.</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div id="related-rows" style="display:grid;gap:8px;">
                    @foreach ($related as $i => $link)
                        <div class="related-row" style="display:flex;gap:8px;flex-wrap:wrap;">
                            <input type="text" name="related[{{ $i }}][label]" value="{{ $link['label'] ?? '' }}" class="input-box-md" style="flex:1 1 200px;" placeholder="Link text" maxlength="80" aria-label="Link text">
                            <input type="text" name="related[{{ $i }}][url]" value="{{ $link['url'] ?? '' }}" class="input-box-md" style="flex:1 1 240px;" placeholder="/page-address" maxlength="300" aria-label="Link address">
                            <button type="button" class="btn-secondary-sm" data-remove-related>Remove</button>
                        </div>
                    @endforeach
                </div>
                @error('related') <span class="input-error">{{ $message }}</span> @enderror
                @foreach ($errors->get('related.*') as $messages) @foreach ($messages as $message)<span class="input-error">{{ $message }}</span><br>@endforeach @endforeach
                <div style="display:flex;gap:8px;margin-top:12px;flex-wrap:wrap;">
                    <select id="related-pick" class="input-box-md" style="width:auto;max-width:360px;" aria-label="Add a related link to a page">
                        <option value="">Add a link to a page…</option>
                        @foreach ($linkTargets as $target)
                            <option value="{{ $target['url'] }}" data-label="{{ $target['label'] }}">{{ $target['label'] }} ({{ $target['url'] }})</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn-secondary-md" id="related-add">Add empty link</button>
                </div>
            </div>
        </figure>

        <div class="flex items-center space-x-3" style="margin-bottom:24px;">
            <button type="submit" class="btn-primary-md">Save changes</button>
            <a href="{{ route('admin.view.content.list') }}" class="btn-secondary-md">Back</a>
        </div>
    </form>

    @if ($meta->cmsElements()->exists())
        <form action="{{ route('admin.handle.content.reset', ['id' => $meta->id]) }}" method="POST"
            onsubmit="return confirm('Remove every heading and paragraph change on this page and show the template wording again?');">
            @csrf
            <button type="submit" class="btn-secondary-md">Reset all headings &amp; paragraphs to original</button>
        </form>
    @endif
@endsection

@section('panel-script')
    <script>
        document.getElementById('content-tab').classList.add('active');

        // ---- Heading outline (live) ----
        const outline = () => {
            const list = document.getElementById('outline');
            const warnings = [];
            const levels = [];
            list.innerHTML = '';
            document.querySelectorAll('.cms-row[data-kind="heading"]').forEach((row) => {
                const select = row.querySelector('[data-level-select]');
                const level = select ? select.value : 'h1';
                const field = row.querySelector('textarea, input[type=text]');
                const text = (field.value || field.placeholder || '').replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim();
                levels.push(parseInt(level.slice(1), 10));
                const li = document.createElement('li');
                li.style.paddingLeft = ((levels[levels.length - 1] - 1) * 18) + 'px';
                const tag = document.createElement('b');
                tag.textContent = level.toUpperCase() + ' ';
                li.appendChild(tag);
                li.appendChild(document.createTextNode(text.length > 90 ? text.slice(0, 90) + '…' : text));
                list.appendChild(li);
            });
            const h1s = levels.filter((l) => l === 1).length;
            if (h1s === 0) warnings.push('No H1 on this page.');
            if (h1s > 1) warnings.push('More than one H1 on this page.');
            levels.forEach((l, i) => { if (i > 0 && l > levels[i - 1] + 1) warnings.push('Level jumps from H' + levels[i - 1] + ' to H' + l + ' (heading ' + (i + 1) + ').'); });
            document.getElementById('outline-warnings').textContent = warnings.join(' ');
        };
        document.addEventListener('input', (e) => { if (e.target.closest('.cms-row')) outline(); });
        document.addEventListener('change', (e) => { if (e.target.matches('[data-level-select]')) outline(); });
        outline();

        // ---- Row actions: reset, filter ----
        document.querySelectorAll('.cms-row [data-reset]').forEach((button) => button.addEventListener('click', () => {
            const row = button.closest('.cms-row');
            const area = row.querySelector('textarea');
            const select = row.querySelector('[data-level-select]');
            if (area) area.value = area.dataset.original;
            if (select) select.value = row.dataset.defaultLevel;
            outline();
        }));
        document.querySelectorAll('[data-filter]').forEach((button) => button.addEventListener('click', () => {
            document.querySelectorAll('.cms-row').forEach((row) => {
                row.style.display = (button.dataset.filter === 'all' || row.dataset.kind === button.dataset.filter) ? '' : 'none';
            });
        }));

        // ---- Page text block toolbar ----
        const copy = document.getElementById('page_copy');
        const replaceSelection = (before, after, fallback) => {
            const start = copy.selectionStart, end = copy.selectionEnd;
            const selected = copy.value.slice(start, end) || fallback;
            copy.setRangeText(before + selected + after, start, end, 'end');
            copy.focus();
            updateCopyCounter();
        };
        document.querySelectorAll('#copy-toolbar [data-wrap]').forEach((button) => button.addEventListener('click', () => {
            const tag = button.dataset.wrap;
            if (tag === 'ul') return replaceSelection('<ul>\n<li>', '</li>\n</ul>', 'List item');
            const block = ['p', 'h2', 'h3', 'h4'].includes(tag);
            replaceSelection('<' + tag + '>', '</' + tag + '>' + (block ? '\n' : ''), 'text');
        }));
        document.getElementById('copy-link-target').addEventListener('change', (e) => {
            if (!e.target.value) return;
            const label = e.target.selectedOptions[0].textContent.replace(/\s*\(.*\)$/, '');
            replaceSelection('<a href="' + e.target.value + '">', '</a>', label);
            e.target.value = '';
        });
        const updateCopyCounter = () => {
            const words = copy.value.replace(/<[^>]+>/g, ' ').trim().split(/\s+/).filter(Boolean).length;
            document.getElementById('page_copy_counter').textContent = words + ' words';
        };
        copy.addEventListener('input', updateCopyCounter);
        updateCopyCounter();

        // ---- Related links ----
        const rows = document.getElementById('related-rows');
        const addRelated = (label, url) => {
            if (rows.children.length >= 12) return;
            const index = Date.now() + Math.floor(Math.random() * 1000);
            const row = document.createElement('div');
            row.className = 'related-row';
            row.style.cssText = 'display:flex;gap:8px;flex-wrap:wrap;';
            row.innerHTML = '<input type="text" class="input-box-md" style="flex:1 1 200px;" placeholder="Link text" maxlength="80" aria-label="Link text">'
                + '<input type="text" class="input-box-md" style="flex:1 1 240px;" placeholder="/page-address" maxlength="300" aria-label="Link address">'
                + '<button type="button" class="btn-secondary-sm" data-remove-related>Remove</button>';
            const [labelInput, urlInput] = row.querySelectorAll('input');
            labelInput.name = 'related[' + index + '][label]';
            urlInput.name = 'related[' + index + '][url]';
            labelInput.value = label || '';
            urlInput.value = url || '';
            rows.appendChild(row);
        };
        document.getElementById('related-add').addEventListener('click', () => addRelated('', ''));
        document.getElementById('related-pick').addEventListener('change', (e) => {
            if (!e.target.value) return;
            addRelated(e.target.selectedOptions[0].dataset.label, e.target.value);
            e.target.value = '';
        });
        rows.addEventListener('click', (e) => { if (e.target.matches('[data-remove-related]')) e.target.closest('.related-row').remove(); });
    </script>
@endsection
