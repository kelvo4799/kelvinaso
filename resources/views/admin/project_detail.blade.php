<x-admin-layout :page="$page" :profile="$profile" :settings="$settings ?? ['site_name' => 'Portfolio']">

    <div class="page-header">
        <div>
            <h1>Edit Project</h1>
            <div class="sub">Update details for "{{ $project->title }}".</div>
        </div>
        <div style="display:flex;gap:10px;align-items:center;">
            <a href="{{ route('projects.admin') }}" class="btn secondary sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back to Projects
            </a>
            @if ($project->slug)
            <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="btn secondary sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                View Live
            </a>
            @endif
        </div>
    </div>

    @if (session('success'))
    <div style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; font-weight: 500; font-size: 0.9rem;">
        <div style="font-weight: 600; margin-bottom: 4px;">Please correct the errors below:</div>
        <ul style="margin-left: 20px; font-size: 0.85rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('projects.update.admin', $project->slug) }}" method="POST" enctype="multipart/form-data" class="grid-cols-2">
        @csrf
        @method('PATCH')

        <!-- Left Column: Main Form Sections -->
        <div style="display:flex; flex-direction:column; gap:24px;">

            <!-- Basic Details Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Basic details</h3>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="field">
                            <label for="title">Title</label>
                            <input class="input" id="title" name="title" value="{{ old('title', $project->title) }}" required />
                        </div>
                        <div class="form-grid cols-2">
                            <div class="field">
                                <label for="category">Category</label>
                                <select class="input" id="category" name="category">
                                    <option value="web" {{ old('category', $project->project_type ?? 'web') == 'web' ? 'selected' : '' }}>Web Development</option>
                                    <option value="mobile" {{ old('category', $project->project_type ?? '') == 'mobile' ? 'selected' : '' }}>Mobile App</option>
                                    <option value="desktop" {{ old('category', $project->project_type ?? '') == 'desktop' ? 'selected' : '' }}>Desktop App</option>
                                    <option value="other" {{ old('category', $project->project_type ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="field">
                                <label for="year">Year</label>
                                <input class="input" type="number" id="year" name="year" value="{{ old('year', $project->year) }}" required />
                            </div>
                        </div>
                        <div class="field">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                <label for="description" style="margin:0;">Short summary</label>
                                <button type="button" class="btn primary-colored sm" id="btnAiProject" onclick="generateAiProjectDescription()" style="font-size: 0.75rem; padding: 2px 10px;">
                                    ✨ Generate Description with AI
                                </button>
                            </div>
                            <textarea class="textarea" id="description" name="description" rows="3">{{ old('description', $project->description) }}</textarea>
                        </div>
                        <div class="field">
                            <label for="tech">Tech stack <span class="muted" style="font-weight:400">(comma-separated)</span></label>
                            <input class="input" id="tech" name="tech" value="{{ old('tech', $project->formatted_tech_stack ?? (is_array($project->tech_stack) ? implode(', ', $project->tech_stack) : ($project->tech_stack ?? ''))) }}" placeholder="e.g. PHP, Laravel, Tailwind CSS, Vue" />
                        </div>
                        <div class="form-grid cols-2">
                            <div class="field">
                                <label for="role">Role</label>
                                <input class="input" type="text" id="role" name="role" value="{{ old('role', $project->role) }}" placeholder="e.g. Lead Developer" />
                            </div>
                            <div class="field">
                                <label for="industry">Industry</label>
                                <input class="input" type="text" id="industry" name="industry" value="{{ old('industry', $project->industry) }}" placeholder="e.g. FinTech, E-Commerce" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Details Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Client details</h3>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="field">
                            <label for="client">Client Name / Self Project</label>
                            <input class="input" id="client" name="client" value="{{ old('client', $project->client) }}" placeholder="Client or Organization Name" />
                        </div>
                        <div class="field">
                            <label for="client_url">Client URL <span class="muted" style="font-weight:400">(Leave blank if self project)</span></label>
                            <input class="input" id="client_url" name="client_url" value="{{ old('client_url', $project->client_url) }}" placeholder="https://clientwebsite.com" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Case Study Builder Card -->
            <div class="card">
                <div class="card-head">
                    <div>
                        <h3>Case Study Content</h3>
                        <div class="muted" style="font-size:0.85rem;margin-top:2px;">Dynamic content sections for this project page.</div>
                    </div>
                    <button type="button" class="btn primary-colored sm" data-modal="addSectionModal">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Add Section
                    </button>
                </div>

                <div class="card-body">
                    <div class="sections-container" id="sectionsContainer">
                        @if (!empty($project->other_details) && is_array($project->other_details))
                            @foreach ($project->other_details as $s_index => $sec)
                                @php
                                    $sType = $sec['type'] ?? 'text';
                                    $sContent = $sec['content'] ?? $sec;
                                    $sVisible = isset($sec['is_visible']) ? (bool)$sec['is_visible'] : true;
                                    
                                    $badgeMap = [
                                        'hero' => ['class' => 'badge-purple', 'label' => 'Hero'],
                                        'text' => ['class' => 'badge-blue', 'label' => 'Text Block'],
                                        'timeline' => ['class' => 'badge-teal', 'label' => 'Timeline'],
                                        'skills' => ['class' => 'badge-amber', 'label' => 'Skills'],
                                        'cta' => ['class' => 'badge-rose', 'label' => 'CTA Banner'],
                                        'stats' => ['class' => 'badge-teal', 'label' => 'Metrics'],
                                        'testimonial' => ['class' => 'badge-teal', 'label' => 'Testimonial'],
                                        'code' => ['class' => 'badge-purple', 'label' => 'Code']
                                    ];
                                    $badgeInfo = $badgeMap[$sType] ?? ['class' => 'badge-blue', 'label' => ucfirst($sType)];
                                @endphp
                                <div class="section-item" data-section-id="sec_{{ $s_index }}">
                                    <input type="hidden" class="section-type-input" name="sections[{{ $s_index }}][type]" value="{{ $sType }}" />
                                    <input type="hidden" class="section-order-input" name="sections[{{ $s_index }}][order]" value="{{ $sec['order'] ?? ($s_index + 1) }}" />
                                    
                                    <div class="section-item-header" onclick="toggleSectionBody(this)">
                                        <div class="section-header-left">
                                            <div class="drag-handle" title="Drag to reorder">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="5" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="19" r="1"/><circle cx="15" cy="5" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="19" r="1"/></svg>
                                            </div>
                                            <span class="section-badge {{ $badgeInfo['class'] }}">{{ $badgeInfo['label'] }}</span>
                                            <span class="section-item-title">{{ $sContent['header'] ?? ($sContent['title'] ?? 'Section Block') }}</span>
                                        </div>
                                        <div class="section-actions" onclick="event.stopPropagation()">
                                            <label class="section-status-toggle" title="Toggle visibility">
                                                <input type="checkbox" name="sections[{{ $s_index }}][is_visible]" value="1" {{ $sVisible ? 'checked' : '' }} onchange="updateSectionStatus(this)">
                                                <span>{{ $sVisible ? 'Visible' : 'Hidden' }}</span>
                                            </label>
                                            <button type="button" class="icon-btn" onclick="moveSectionUp(this)" title="Move up">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg>
                                            </button>
                                            <button type="button" class="icon-btn" onclick="moveSectionDown(this)" title="Move down">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                                            </button>
                                            <button type="button" class="icon-btn danger" onclick="deleteSection(this)" title="Delete section">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            </button>
                                            <button type="button" class="icon-btn chevron-icon" onclick="toggleSectionBody(this.closest('.section-item-header'))" title="Expand/Collapse">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="section-item-body">
                                        <div class="form-grid">
                                            @if ($sType === 'hero')
                                                <div class="field">
                                                    <label>Section Title</label>
                                                    <input class="input" name="sections[{{ $s_index }}][title]" value="{{ $sContent['title'] ?? '' }}" placeholder="Hero Section Title" />
                                                </div>
                                                <div class="form-grid cols-2">
                                                    <div class="field">
                                                        <label>Headline</label>
                                                        <input class="input" name="sections[{{ $s_index }}][headline]" value="{{ $sContent['headline'] ?? '' }}" placeholder="Welcome Headline" />
                                                    </div>
                                                    <div class="field">
                                                        <label>Subheadline</label>
                                                        <input class="input" name="sections[{{ $s_index }}][subheadline]" value="{{ $sContent['subheadline'] ?? '' }}" placeholder="Subheadline tagline..." />
                                                    </div>
                                                </div>
                                            @elseif ($sType === 'testimonial')
                                                <div class="field">
                                                    <label>Section Title</label>
                                                    <input class="input" name="sections[{{ $s_index }}][title]" value="{{ $sContent['title'] ?? 'Client Testimonial' }}" placeholder="Testimonial Section Title" />
                                                </div>
                                                <div class="form-grid cols-2">
                                                    <div class="field">
                                                        <label>Client Contact Name</label>
                                                        <input class="input" name="sections[{{ $s_index }}][name]" value="{{ $sContent['name'] ?? ($sContent['name'] ?? '') }}" placeholder="e.g. John Smith" />
                                                    </div>
                                                    <div class="field">
                                                        <label>Position / Title</label>
                                                        <input class="input" name="sections[{{ $s_index }}][position]" value="{{ $sContent['position'] ?? ($sContent['position'] ?? '') }}" placeholder="e.g. CTO, Acme Corp" />
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label>Testimonial Comment</label>
                                                    <textarea class="textarea" name="sections[{{ $s_index }}][comment]" rows="4" placeholder="Client feedback or quote...">{{ $sContent['comment_text'] ?? ($sContent['comment'] ?? '') }}</textarea>
                                                </div>
                                            @elseif ($sType === 'timeline')
                                                <div class="field">
                                                    <label>Section Title</label>
                                                    <input class="input" name="sections[{{ $s_index }}][title]" value="{{ $sContent['title'] ?? '' }}" placeholder="Timeline Heading" />
                                                </div>
                                                <div class="field">
                                                    <label>Entries & Milestones</label>
                                                    <input class="input" name="sections[{{ $s_index }}][roles]" value="{{ $sContent['roles'] ?? '' }}" placeholder="Company A (2023), Company B (2021)..." />
                                                </div>
                                            @elseif ($sType === 'skills')
                                                <div class="field">
                                                    <label>Section Heading</label>
                                                    <input class="input" name="sections[{{ $s_index }}][title]" value="{{ $sContent['title'] ?? '' }}" placeholder="Skills Heading" />
                                                </div>
                                                <div class="field">
                                                    <label>Skill Tags (comma-separated)</label>
                                                    <input class="input" name="sections[{{ $s_index }}][tags]" value="{{ $sContent['tags'] ?? '' }}" placeholder="e.g. PHP, Laravel, Tailwind, React" />
                                                </div>
                                            @elseif ($sType === 'cta')
                                                <div class="field">
                                                    <label>Headline</label>
                                                    <input class="input" name="sections[{{ $s_index }}][title]" value="{{ $sContent['title'] ?? '' }}" placeholder="CTA Banner Headline" />
                                                </div>
                                                <div class="form-grid cols-2">
                                                    <div class="field">
                                                        <label>Button Label</label>
                                                        <input class="input" name="sections[{{ $s_index }}][btn_text]" value="{{ $sContent['btn_text'] ?? 'Contact Me' }}" placeholder="Button Label" />
                                                    </div>
                                                    <div class="field">
                                                        <label>Button URL</label>
                                                        <input class="input" name="sections[{{ $s_index }}][btn_url]" value="{{ $sContent['btn_url'] ?? '' }}" placeholder="/contact" />
                                                    </div>
                                                </div>
                                            @elseif ($sType === 'stats')
                                                <div class="field">
                                                    <label>Section Title</label>
                                                    <input class="input" name="sections[{{ $s_index }}][title]" value="{{ $sContent['title'] ?? '' }}" placeholder="Performance Metrics Title" />
                                                </div>
                                                <div class="field">
                                                    <label>Key-Value Metrics</label>
                                                    <div class="metrics-list" style="display:flex;flex-direction:column;gap:10px;">
                                                        @php
                                                            $metrics = $sContent['metrics'] ?? [];
                                                        @endphp
                                                        @if (!empty($metrics) && is_array($metrics))
                                                            @foreach ($metrics as $mIdx => $metric)
                                                                <div class="form-grid cols-2 metric-row" style="align-items:center;">
                                                                    <div class="field" style="margin:0;">
                                                                        <label style="font-size:0.75rem;">Metric Name</label>
                                                                        <input class="input" name="sections[{{ $s_index }}][metrics][{{ $mIdx }}][key]" value="{{ $metric['key'] ?? '' }}" placeholder="Metric Name" />
                                                                    </div>
                                                                    <div class="field" style="margin:0;display:flex;gap:8px;align-items:flex-end;">
                                                                        <div style="flex:1;">
                                                                            <label style="font-size:0.75rem;">Value</label>
                                                                            <input class="input" name="sections[{{ $s_index }}][metrics][{{ $mIdx }}][value]" value="{{ $metric['value'] ?? '' }}" placeholder="Value" />
                                                                        </div>
                                                                        <button type="button" class="icon-btn danger" onclick="removeMetricRow(this)" title="Remove metric" style="height:38px;width:38px;flex-shrink:0;">
                                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="12"/></svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <button type="button" class="btn secondary sm" onclick="addMetricRow(this)" style="margin-top:12px;gap:6px;">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                                        Add Metric Item
                                                    </button>
                                                </div>
                                            @elseif ($sType === 'code')
                                                <div class="field">
                                                    <label>Section Title</label>
                                                    <input class="input" name="sections[{{ $s_index }}][title]" value="{{ $sContent['title'] ?? '' }}" placeholder="Code Block Title" />
                                                </div>
                                                <div class="field">
                                                    <label>Embed Code / HTML</label>
                                                    <textarea class="textarea" name="sections[{{ $s_index }}][code]" rows="5" style="font-family:monospace;" placeholder="<div>Custom HTML embed...</div>">{{ $sContent['code'] ?? '' }}</textarea>
                                                </div>
                                            @else
                                                <div class="field">
                                                    <label>Section Heading</label>
                                                    <input class="input" name="sections[{{ $s_index }}][title]" value="{{ $sContent['title'] ?? ($sContent['header'] ?? '') }}" placeholder="Block Heading" />
                                                </div>
                                                <div class="field">
                                                    <label>Body Content</label>
                                                    <textarea class="textarea" name="sections[{{ $s_index }}][body]" rows="4" placeholder="Enter paragraph content...">{{ $sContent['body'] ?? ($sContent['paragraph'] ?? '') }}</textarea>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Settings & Media Sidebar -->
        <div style="display:flex; flex-direction:column; gap:24px;">

            <!-- Status & Publishing Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Status & Display Settings</h3>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="field">
                            <label for="status">Publishing Status</label>
                            <select class="input" id="status" name="status">
                                <option value="1" {{ old('status', $project->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Published</option>
                                <option value="0" {{ old('status', $project->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        
                        <div class="field">
                            <label for="view_type">Display Option</label>
                            <select class="input" id="view_type" name="view_type" onchange="toggleViewTypeDisplay(this.value)">
                                <option value="preview" {{ old('view_type', $project->view_type ?? 'preview') == 'preview' ? 'selected' : '' }}>Preview Image Showcase</option>
                                <option value="live" {{ old('view_type', $project->view_type ?? 'preview') == 'live' ? 'selected' : '' }}>Live Project Link</option>
                            </select>
                        </div>

                        <div class="field" id="live_url_field" style="{{ old('view_type', $project->view_type ?? 'preview') == 'live' ? '' : 'display:none;' }}">
                            <label for="live_url">Live Project URL <span class="muted" style="font-weight:400">(External Link)</span></label>
                            <input class="input" id="live_url" name="live_url" value="{{ old('live_url', $project->live_url) }}" placeholder="https://myproject.com" />
                        </div>

                        <div class="field" style="margin-top:4px;">
                            <label class="section-status-toggle" style="cursor:pointer;user-select:none;">
                                <input type="checkbox" name="featured" value="1" {{ old('featured', $project->featured) ? 'checked' : '' }}>
                                <span style="font-weight:600;color:var(--c-text);">Feature on Home Page</span>
                            </label>
                        </div>

                        <div class="field">
                            <label for="slug">URL Slug</label>
                            <input class="input" id="slug" name="slug" value="{{ old('slug', $project->slug) }}" required />
                        </div>
                        
                        <div class="field">
                            <label for="github_url">GitHub Repository URL</label>
                            <input class="input" id="github_url" name="github_url" value="{{ old('github_url', $project->github_url) }}" placeholder="https://github.com/username/repo" />
                        </div>
                    </div>
                </div>
                <div class="card-head" style="border-top:1px solid var(--c-border);border-bottom:none;display:flex;flex-direction:column;gap:12px;padding:20px 28px;">
                    <button type="submit" class="btn primary-colored" style="width:100%;justify-content:center;">Save changes</button>
                    <button type="button" class="btn secondary" style="width:100%;justify-content:center;color:var(--c-danger);" onclick="confirmDeleteProject()">Delete project</button>
                </div>
            </div>

            <!-- Media & Assets Card -->
            <div class="card" id="media_card">
                <div class="card-head">
                    <h3>Project Media & Assets</h3>
                </div>
                <div class="card-body">
                    <!-- Project Icon / Logo Field -->
                    <div class="field" style="margin-bottom: 24px;">
                        <label>Project Icon / Logo</label>
                        <div class="image-upload-dropzone" id="iconDropzone" onclick="document.getElementById('icon_image_input').click()" style="border:2px dashed var(--c-border);border-radius:var(--radius-sm);padding:20px;text-align:center;background:var(--c-bg-subtle);cursor:pointer;transition:all 0.2s ease;">
                            <div style="margin-bottom:6px;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="12" cy="12" r="3"/></svg></div>
                            <div style="font-size:13px;color:var(--c-text);font-weight:500;">Click or drag project icon here</div>
                            <div style="font-size:12px;color:var(--c-text-muted);margin-top:2px;">PNG, SVG, WEBP or JPG (Max 10MB)</div>
                            <input type="file" id="icon_image_input" name="icon" accept="image/*" style="display:none;" onchange="previewIconImage(this)" />
                        </div>

                        <div id="iconPreviewContainer" style="margin-top:12px; {{ $project->icon ? '' : 'display:none;' }}">
                            <div style="font-size:0.75rem;font-weight:600;color:var(--c-text-muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Current Icon</div>
                            <div style="position:relative;border-radius:var(--radius-sm);overflow:hidden;border:1px solid var(--c-border);background:var(--c-bg-subtle);display:inline-block;padding:8px;">
                                <img id="icon_image_preview" src="{{ $project->icon ? (str_starts_with($project->icon, 'http') ? $project->icon : asset($project->icon)) : '' }}" style="width:64px;height:64px;display:block;object-fit:contain;" />
                            </div>
                        </div>
                    </div>

                    <!-- Cover / Preview Showcase Image Field -->
                    <div class="field" id="preview_image_container" style="{{ old('view_type', $project->view_type ?? 'preview') == 'preview' ? '' : 'display:none;' }}">
                        <label>Preview Showcase Image</label>
                        <div class="image-upload-dropzone" id="coverDropzone" onclick="document.getElementById('cover_image_input').click()" style="border:2px dashed var(--c-border);border-radius:var(--radius-sm);padding:24px;text-align:center;background:var(--c-bg-subtle);cursor:pointer;transition:all 0.2s ease;">
                            <div style="margin-bottom:8px;"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                            <div style="font-size:13px;color:var(--c-text);font-weight:500;">Click or drag preview image here to upload</div>
                            <div style="font-size:12px;color:var(--c-text-muted);margin-top:4px;">JPG, PNG, WEBP, GIF or HEIC (Max 35MB)</div>
                            <input type="file" id="cover_image_input" name="image" accept="image/*" style="display:none;" onchange="previewCoverImage(this)" />
                        </div>

                        <div id="imagePreviewContainer" style="margin-top:14px; {{ $project->image ? '' : 'display:none;' }}">
                            <div style="font-size:0.75rem;font-weight:600;color:var(--c-text-muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Current Preview Image</div>
                            <div style="position:relative;border-radius:var(--radius-sm);overflow:hidden;border:1px solid var(--c-border);background:var(--c-bg-subtle);">
                                <img id="cover_image_preview" src="{{ $project->image ? (str_starts_with($project->image, 'http') ? $project->image : asset($project->image)) : '' }}" style="width:100%;display:block;max-height:180px;object-fit:cover;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>

    <!-- Hidden Delete Form -->
    <form id="deleteProjectForm" action="{{ route('projects.destroy.admin', $project->slug) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Add Section Modal -->
    <div class="modal-backdrop" id="addSectionModal">
        <div class="modal" style="max-width:560px;">
            <div class="modal-header">
                <h2>Add New Page Section</h2>
                <button class="modal-close" data-modal-close aria-label="Close">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="12"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <p style="font-size:0.875rem;color:var(--c-text-muted);margin-bottom:16px;">
                    Choose a section block type to insert into your case study page layout:
                </p>

                <div class="section-preset-grid">
                    <div class="preset-card" onclick="createNewSection('hero')">
                        <div class="icon">🚀</div>
                        <h4>Hero Banner</h4>
                        <p>Headline, tagline & primary section intro.</p>
                    </div>
                    <div class="preset-card" onclick="createNewSection('text')">
                        <div class="icon">📝</div>
                        <h4>Rich Text / Story</h4>
                        <p>Formatted body paragraphs, headings & details.</p>
                    </div>
                    <div class="preset-card" onclick="createNewSection('testimonial')">
                        <div class="icon">💬</div>
                        <h4>Client Testimonial</h4>
                        <p>Client quote, contact name & position.</p>
                    </div>
                    <div class="preset-card" onclick="createNewSection('timeline')">
                        <div class="icon">💼</div>
                        <h4>Experience Timeline</h4>
                        <p>List of job roles, milestones & project phases.</p>
                    </div>
                    <div class="preset-card" onclick="createNewSection('skills')">
                        <div class="icon">⚡</div>
                        <h4>Skills & Tech Grid</h4>
                        <p>Category pills and technical stack badges.</p>
                    </div>
                    <div class="preset-card" onclick="createNewSection('cta')">
                        <div class="icon">✉️</div>
                        <h4>Call To Action</h4>
                        <p>High-impact banner with action link.</p>
                    </div>
                    <div class="preset-card" onclick="createNewSection('stats')">
                        <div class="icon">📊</div>
                        <h4>Performance Metrics</h4>
                        <p>Key-value metrics like throughput & coverage.</p>
                    </div>
                    <div class="preset-card" onclick="createNewSection('code')">
                        <div class="icon">🔌</div>
                        <h4>Custom Code Block</h4>
                        <p>Embed raw HTML, scripts, or iframe widgets.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn secondary" data-modal-close>Cancel</button>
            </div>
        </div>
    </div>

    <!-- Script Block for Interactive Builder -->
    <script>
        function reindexSections() {
            const items = document.querySelectorAll('#sectionsContainer .section-item');
            items.forEach((item, index) => {
                const inputs = item.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/^sections\[\d+\]/, `sections[${index}]`);
                    }
                });
                const orderInput = item.querySelector('.section-order-input');
                if (orderInput) orderInput.value = index + 1;
            });
        }

        function toggleSectionBody(headerEl) {
            const item = headerEl.closest('.section-item');
            if (item) {
                item.classList.toggle('collapsed');
            }
        }

        function updateSectionStatus(checkbox) {
            const statusText = checkbox.nextElementSibling;
            if (checkbox.checked) {
                statusText.textContent = 'Visible';
                statusText.style.color = 'var(--c-text)';
            } else {
                statusText.textContent = 'Hidden';
                statusText.style.color = 'var(--c-text-muted)';
            }
        }

        function moveSectionUp(btn) {
            const item = btn.closest('.section-item');
            const prev = item.previousElementSibling;
            if (prev) {
                item.parentNode.insertBefore(item, prev);
                reindexSections();
            }
        }

        function moveSectionDown(btn) {
            const item = btn.closest('.section-item');
            const next = item.nextElementSibling;
            if (next) {
                item.parentNode.insertBefore(next, item);
                reindexSections();
            }
        }

        function deleteSection(btn) {
            const item = btn.closest('.section-item');
            const title = item.querySelector('.section-item-title')?.textContent || 'Section';
            if (confirm(`Are you sure you want to remove "${title}"?`)) {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    item.remove();
                    reindexSections();
                }, 200);
            }
        }

        let newSectionCounter = Date.now();

        function createNewSection(type) {
            newSectionCounter++;
            const container = document.getElementById('sectionsContainer');
            const nextIndex = container.children.length;
            
            let badgeClass = 'badge-blue';
            let badgeLabel = 'Custom';
            let title = 'New Section';
            let bodyFields = '';

            if (type === 'hero') {
                badgeClass = 'badge-purple';
                badgeLabel = 'Hero';
                title = 'Hero Banner Header';
                bodyFields = `
                    <div class="field"><label>Section Title</label><input class="input" name="sections[${nextIndex}][title]" value="${title}" /></div>
                    <div class="form-grid cols-2">
                        <div class="field"><label>Headline</label><input class="input" name="sections[${nextIndex}][headline]" placeholder="Welcome Headline" /></div>
                        <div class="field"><label>Subheadline</label><input class="input" name="sections[${nextIndex}][subheadline]" placeholder="Subheadline tagline..." /></div>
                    </div>
                `;
            } else if (type === 'text') {
                badgeClass = 'badge-blue';
                badgeLabel = 'Text Block';
                title = 'Custom Text Block';
                bodyFields = `
                    <div class="field"><label>Section Heading</label><input class="input" name="sections[${nextIndex}][title]" placeholder="Block Title" /></div>
                    <div class="field"><label>Body Content</label><textarea class="textarea" name="sections[${nextIndex}][body]" rows="4" placeholder="Enter paragraph content..."></textarea></div>
                `;
            } else if (type === 'testimonial') {
                badgeClass = 'badge-teal';
                badgeLabel = 'Testimonial';
                title = 'Client Testimonial & Quote';
                bodyFields = `
                    <div class="field"><label>Section Title</label><input class="input" name="sections[${nextIndex}][title]" value="Client Testimonial" /></div>
                    <div class="form-grid cols-2">
                        <div class="field"><label>Client Contact Name</label><input class="input" name="sections[${nextIndex}][name]" placeholder="e.g. John Smith" /></div>
                        <div class="field"><label>Position / Title</label><input class="input" name="sections[${nextIndex}][position]" placeholder="e.g. CTO, Acme Corp" /></div>
                    </div>
                    <div class="field"><label>Testimonial Comment</label><textarea class="textarea" name="sections[${nextIndex}][comment]" rows="4" placeholder="Client feedback or quote..."></textarea></div>
                `;
            } else if (type === 'timeline') {
                badgeClass = 'badge-teal';
                badgeLabel = 'Timeline';
                title = 'Experience & Milestones';
                bodyFields = `
                    <div class="field"><label>Section Title</label><input class="input" name="sections[${nextIndex}][title]" value="Milestones & Timeline" /></div>
                    <div class="field"><label>Entries</label><input class="input" name="sections[${nextIndex}][roles]" placeholder="Company A (2023), Company B (2021)..." /></div>
                `;
            } else if (type === 'skills') {
                badgeClass = 'badge-amber';
                badgeLabel = 'Skills';
                title = 'Featured Skills & Badges';
                bodyFields = `
                    <div class="field"><label>Section Heading</label><input class="input" name="sections[${nextIndex}][title]" value="Tech Stack" /></div>
                    <div class="field"><label>Skill Tags (comma separated)</label><input class="input" name="sections[${nextIndex}][tags]" placeholder="e.g. PHP, Laravel, Tailwind, React" /></div>
                `;
            } else if (type === 'cta') {
                badgeClass = 'badge-rose';
                badgeLabel = 'CTA Banner';
                title = 'Call to Action Banner';
                bodyFields = `
                    <div class="field"><label>Headline</label><input class="input" name="sections[${nextIndex}][title]" placeholder="Ready to work together?" /></div>
                    <div class="form-grid cols-2">
                        <div class="field"><label>Button Label</label><input class="input" name="sections[${nextIndex}][btn_text]" value="Contact Me" /></div>
                        <div class="field"><label>Button URL</label><input class="input" name="sections[${nextIndex}][btn_url]" value="/contact" /></div>
                    </div>
                `;
            } else if (type === 'stats') {
                badgeClass = 'badge-teal';
                badgeLabel = 'Metrics';
                title = 'Performance Metrics';
                bodyFields = `
                    <div class="field"><label>Section Title</label><input class="input" name="sections[${nextIndex}][title]" value="Performance Metrics" /></div>
                    <div class="field">
                        <label>Key-Value Metrics</label>
                        <div class="metrics-list" style="display:flex;flex-direction:column;gap:10px;">
                            <div class="form-grid cols-2 metric-row" style="align-items:center;">
                                <div class="field" style="margin:0;"><label style="font-size:0.75rem;">Metric Name</label><input class="input" name="sections[${nextIndex}][metrics][0][key]" placeholder="e.g. Avg Response" /></div>
                                <div class="field" style="margin:0;display:flex;gap:8px;align-items:flex-end;">
                                    <div style="flex:1;"><label style="font-size:0.75rem;">Value</label><input class="input" name="sections[${nextIndex}][metrics][0][value]" placeholder="e.g. 42ms" /></div>
                                    <button type="button" class="icon-btn danger" onclick="removeMetricRow(this)" title="Remove metric" style="height:38px;width:38px;flex-shrink:0;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="12"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn secondary sm" onclick="addMetricRow(this)" style="margin-top:12px;gap:6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Add Metric Item
                        </button>
                    </div>
                `;
            } else {
                badgeClass = 'badge-purple';
                badgeLabel = 'Code';
                title = 'Custom Code / HTML Embed';
                bodyFields = `
                    <div class="field"><label>Section Title</label><input class="input" name="sections[${nextIndex}][title]" value="${title}" /></div>
                    <div class="field"><label>Embed Code / HTML</label><textarea class="textarea" name="sections[${nextIndex}][code]" rows="5" style="font-family:monospace;" placeholder="<div>Custom HTML embed...</div>"></textarea></div>
                `;
            }

            const sectionEl = document.createElement('div');
            sectionEl.className = 'section-item';
            sectionEl.dataset.sectionId = `sec_${newSectionCounter}`;
            sectionEl.innerHTML = `
                <input type="hidden" class="section-type-input" name="sections[${nextIndex}][type]" value="${type}" />
                <input type="hidden" class="section-order-input" name="sections[${nextIndex}][order]" value="${nextIndex + 1}" />
                <div class="section-item-header" onclick="toggleSectionBody(this)">
                    <div class="section-header-left">
                        <div class="drag-handle" title="Drag to reorder">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="5" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="19" r="1"/><circle cx="15" cy="5" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="19" r="1"/></svg>
                        </div>
                        <span class="section-badge ${badgeClass}">${badgeLabel}</span>
                        <span class="section-item-title">${title}</span>
                    </div>
                    <div class="section-actions" onclick="event.stopPropagation()">
                        <label class="section-status-toggle" title="Toggle visibility">
                            <input type="checkbox" name="sections[${nextIndex}][is_visible]" value="1" checked onchange="updateSectionStatus(this)">
                            <span>Visible</span>
                        </label>
                        <button type="button" class="icon-btn" onclick="moveSectionUp(this)" title="Move up">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg>
                        </button>
                        <button type="button" class="icon-btn" onclick="moveSectionDown(this)" title="Move down">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <button type="button" class="icon-btn danger" onclick="deleteSection(this)" title="Delete section">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </button>
                        <button type="button" class="icon-btn chevron-icon" onclick="toggleSectionBody(this.closest('.section-item-header'))" title="Expand/Collapse">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                    </div>
                </div>
                <div class="section-item-body">
                    <div class="form-grid">
                        ${bodyFields}
                    </div>
                </div>
            `;

            container.appendChild(sectionEl);
            reindexSections();

            const modal = document.getElementById('addSectionModal');
            if (modal) modal.classList.remove('open');
        }

        function addMetricRow(btn) {
            const list = btn.previousElementSibling;
            const count = list.querySelectorAll('.metric-row').length;
            const item = btn.closest('.section-item');
            const items = document.querySelectorAll('#sectionsContainer .section-item');
            const sectionIndex = Array.from(items).indexOf(item);
            const idx = sectionIndex >= 0 ? sectionIndex : 0;
            
            const row = document.createElement('div');
            row.className = 'form-grid cols-2 metric-row';
            row.style.alignItems = 'center';
            row.innerHTML = `
                <div class="field" style="margin:0;">
                    <label style="font-size:0.75rem;">Metric Name</label>
                    <input class="input" name="sections[${idx}][metrics][${count}][key]" placeholder="Metric Name (e.g. Uptime)" />
                </div>
                <div class="field" style="margin:0;display:flex;gap:8px;align-items:flex-end;">
                    <div style="flex:1;">
                        <label style="font-size:0.75rem;">Value</label>
                        <input class="input" name="sections[${idx}][metrics][${count}][value]" placeholder="Value (e.g. 99.9%)" />
                    </div>
                    <button type="button" class="icon-btn danger" onclick="removeMetricRow(this)" title="Remove metric" style="height:38px;width:38px;flex-shrink:0;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="12"/></svg>
                    </button>
                </div>
            `;
            list.appendChild(row);
        }

        function removeMetricRow(btn) {
            const row = btn.closest('.metric-row');
            if (row) {
                row.remove();
            }
        }

        function previewCoverImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImg = document.getElementById('cover_image_preview');
                    const previewContainer = document.getElementById('imagePreviewContainer');
                    if (previewImg && previewContainer) {
                        previewImg.src = e.target.result;
                        previewContainer.style.display = 'block';
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function confirmDeleteProject() {
            if (confirm('Are you sure you want to delete this project? This action cannot be undone.')) {
                document.getElementById('deleteProjectForm').submit();
            }
        }

        function previewIconImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImg = document.getElementById('icon_image_preview');
                    const previewContainer = document.getElementById('iconPreviewContainer');
                    if (previewImg && previewContainer) {
                        previewImg.src = e.target.result;
                        previewContainer.style.display = 'block';
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function toggleViewTypeDisplay(val) {
            const liveField = document.getElementById('live_url_field');
            const previewContainer = document.getElementById('preview_image_container');
            if (liveField) {
                liveField.style.display = (val === 'live') ? 'block' : 'none';
            }
            if (previewContainer) {
                previewContainer.style.display = (val === 'preview') ? 'block' : 'none';
            }
        }

        // Drag & drop highlight on cover dropzone
        const dropzone = document.getElementById('coverDropzone');
        if (dropzone) {
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.style.borderColor = 'var(--accent)';
                    dropzone.style.background = 'rgba(99, 102, 241, 0.08)';
                }, false);
            });
            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.style.borderColor = 'var(--c-border)';
                    dropzone.style.background = 'var(--c-bg-subtle)';
                }, false);
            });
            dropzone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                const fileInput = document.getElementById('cover_image_input');
                if (fileInput && files.length) {
                    fileInput.files = files;
                    previewCoverImage(fileInput);
                }
            }, false);
        }

        async function generateAiProjectDescription() {
            const titleInput = document.getElementById('title');
            const categoryInput = document.getElementById('category');
            const techInput = document.getElementById('tech');
            const btn = document.getElementById('btnAiProject');

            const title = titleInput ? titleInput.value.trim() : '';
            const category = categoryInput ? categoryInput.value : 'Web Development';
            const tech = techInput ? techInput.value.trim() : '';

            if (!title) {
                alert('Please enter a Project Title first so the AI knows what project to describe.');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '✨ Generating with Groq AI...';

            try {
                const response = await fetch('{{ route("ai.generate-project.admin") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ title, category, tech })
                });

                const data = await response.json();
                if (data.success && data.description) {
                    document.getElementById('description').value = data.description;
                } else {
                    alert(data.description || 'Failed to generate project description.');
                }
            } catch (err) {
                alert('AI Generation request failed. Please check your GROQ_API_KEY in .env.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '✨ Generate Description with AI';
            }
        }
    </script>

</x-admin-layout>