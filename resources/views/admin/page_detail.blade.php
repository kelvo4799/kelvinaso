<x-admin-layout :page="$page" :profile="$profile" :settings="$settings ?? ['site_name' => 'Portfolio']">


    <div class="page-header">
        <div>
            <h1>Edit Page</h1>
            <div class="sub">Update content for "{{ $page->title }} Page".</div>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="{{ url($page->slug == 'home' ? '/' : '/' . $page->slug) }}" target="_blank" class="btn secondary">View live</a>
        </div>
    </div>

    <div class="profile-grid">
        <form class="card" action="{{ route('pages.update', $page->slug) }}" method="POST">

            <div style="display:flex;flex-direction:column;gap:18px;flex:2;">
                @csrf
                @method('PATCH')

                <div class="card-head">
                    <h3>Page Settings</h3>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-grid cols-2">
                            <div class="field">
                                <label>Title</label>
                                <input class="input" name="title" value="{{ $page->title }}" readonly />
                            </div>
                            <div class="field">
                                <label>URL Path</label>
                                <input class="input" type="text" name="slug" value="{{ $page->slug }}"
                                    readonly />
                            </div>
                        </div>

                        <div class="field">
                            <label>SEO Meta Description</label>
                            <textarea class="textarea" name="meta_description" rows="3">{{ $page->content['meta_description'] ?? '' }}</textarea>
                        </div>

                        <div class="field">
                            <label>Meta Keywords</label>
                            <textarea class="textarea" name="meta_keywords" rows="3">{{ $page->content['meta_keywords'] ?? '' }}</textarea>
                        </div>

                        <div class="form-grid cols-2">
                            <div class="field">
                                <label>Robots</label>
                                <input class="input" name="robots"
                                    value="{{ $page->content['robots'] ?? 'index, follow' }}" />
                            </div>
                            <div class="field">
                                <label>Template</label>
                                <select class="input" name="template">
                                    <option value="default">Default Template</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                @if ($page->sections)
                <div class="card">
                    <div class="card-head">
                        <div>
                            <h3>Page Sections</h3>
                            <div class="muted" style="font-size:0.85rem;margin-top:2px;">Edit the sections on this
                                page.</div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="sections-container">

                           @foreach ($page->sections as $s_index => $section)

                            <div class="section-item" data-section-id="{{ $section->id }}">
                                <input type="" name="sections[{{ $s_index }}][id]" value="{{ $section->id }}" />
                                <input type="" name="sections[{{ $s_index }}][order]" value="{{ $s_index }}" />
                                <div class="section-item-header">
                                    <div class="section-header-left">
                                        <input class="input" name="sections[{{ $s_index }}][section_name]" value="{{ $section->section_name }}" readonly/>
                                    </div>

                                </div>
                                <div class="section-item-body">
                                    <div class="form-grid">
                                        @if(is_array($section->content) || is_object($section->content))
                                            @foreach ($section->content as $key => $value)
                                            @if (!is_array($value))
                                            <div class="field">
                                                <label>{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                <input class="input" name="sections[{{ $s_index }}][content][{{ $key }}]"
                                                    value="{{ $value }}" />
                                            </div>
                                            @elseif(is_array($value))
                                            @foreach ($value as $k => $v)
                                            <div class="field">
                                                <label>{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                <input class="input" name="sections[{{ $s_index }}][content][{{ $key }}][{{ $k }}]"
                                                    value="{{ $v }}" />
                                            </div>
                                            @endforeach
                                            @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                @endif

            </div>

            <br>

            <div style="display:flex;flex-direction:column;gap:18px;flex:1;">
                <div class="card">
                    <div class="card-head">
                        <h3>Publishing</h3>
                    </div>
                    <div class="card-body">
                        <div class="field">
                            <label>Status</label>
                            <select class="input" name="status">
                                <option value="1" {{ $page->is_active ? 'selected' : '' }}>Published</option>
                                <option value="0" {{ !$page->is_active ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-head"
                        style="border-top:1px solid var(--c-border);border-bottom:none;display:flex;flex-direction:column;gap:10px;">
                        <button class="btn" type="submit" style="width:100%;justify-content:center;">Save
                            changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


</x-admin-layout>
