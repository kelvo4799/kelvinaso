<x-admin-layout :page="$page" :profile="$profile" :settings="$settings ?? ['site_name' => 'Portfolio']">


    <div class="page-header">
        <div>
          <h1>Edit Project</h1>
          <div class="sub">Update details for "{{ $project->title }}".</div>
        </div>
        <div style="display:flex;gap:10px;">
          <button class="btn secondary">View live</button>
        </div>
      </div>

      <div class="profile-grid">
        <form action="{{ route('projects.update.admin', $project->slug) }}" method="POST" class="card" >
            @csrf
            @method('PATCH')
        <div style="display:flex;flex-direction:column;gap:18px;flex:2;">
          

            <div class="card-head"><h3>Basic details</h3></div>
            <div class="card-body">
              <div class="form-grid">
                <div class="field">
                  <label>Title</label>
                  <input class="input" name="title" value="{{ $project->title }}" required />
                </div>
                <div class="form-grid cols-2">
                  <div class="field">
                    <label>Category</label>
                    <select class="input" name="category">
                      <option value="web" {{ $project->project_type == 'wordpress' ? 'selected' : ''}}>Web Development</option>
                      <option value="wordpress" {{ $project->project_type == 'wordpress' ? 'selected' : ''}}>Wordpress</option>
                      <option value="spotify" {{ $project->project_type == 'spotify' ? 'selected' : ''}}>Spotify</option>
                      <option value="mobile" {{ $project->project_type == 'mobile' ? 'selected' : ''}}>Mobile App</option>
                    </select>
                  </div>
                  <div class="field">
                    <label>Year</label>
                    <input class="input" type="number" name="year" value="{{ $project->year }}" required />
                  </div>
                </div>
                <div class="field">
                  <label>Short summary</label>
                  <textarea class="textarea" name="description" rows="2">{{ $project->description }}</textarea>
              
                </div>
                <div class="field">
                  <label>Tech stack <span class="hint" style="font-weight:400">(comma-separated)</span></label>
                  <input class="input" name="tech" value="{{ $project->tech_stack }}" />
                </div>

                <div class="form-grid cols-2">
                  <div class="field">
                    <label>Role</label>
                    <input class="input" type="text" name="role" value="{{ $project->role }}" required />                   
                  </div>
                  <div class="field">
                    <label>Industry</label>
                    <input class="input" type="text" name="industry" value="{{ $project->industry }}" required />
                  </div>
                </div>
              </div>

            </div>

            


            <div class="card-head"><h3>Client details</h3></div>
            <div class="card-body">
              <div class="form-grid">
                <div class="field">
                  <label>Client Name / Self Project</label>
                  <input class="input" name="client" value="{{ $project->client }}" />
                </div>
                <div class="field">
                  <label>Client Url (Leave blank if self project / No link)</label>
                  <input class="input" name="client_url" value="{{ $project->client_url }}" />
                </div>

                <div class="section-item" data-section-id="client_comment">
                  <div class="section-item-header" onclick="toggleSectionBody(this)">
                    <div class="section-header-left">
                      <div class="drag-handle" title="Drag to reorder">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="5" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="19" r="1"/><circle cx="15" cy="5" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="19" r="1"/></svg>
                      </div>
                      <span class="section-item-title">Client Comment (Leave blank if self project / No comment)</span>
                    </div>
                    
                  </div>
                  <div class="section-item-body">
                    <div class="form-grid">
                      <div class="field">
                        <label>Name</label>
                        <input class="input" name="comment_name" value="{{ $project->client_comment['name'] ?? ''}}" />
                      </div>
                      <div class="field">
                        <label>Position</label>
                        <input class="input" name="comment_position" value="{{ $project->client_comment['position'] ?? '' }}" />
                      </div>
                      <div class="field">
                        <label>Comment</label>
                        <textarea class="textarea" name="comment_text" rows="6" style="border-radius:0 0 6px 6px;">{{ $project->client_comment['comment'] ?? '' }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>
                
                
                
              </div>

            </div>


           
     

            <div class="card-head" style="border-top:1px solid var(--c-border);border-bottom:none;">
              <h3>Case study content</h3>
            </div>
            <div class="card">
            <div class="card-head">
              <div>
                <h3>Project Content</h3>
                <div class="muted" style="font-size:0.85rem;margin-top:2px;">Project dynamic sections on this page.</div>
              </div>
              <button type="button" class="btn primary-colored sm" onclick="createNewSection('text')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Section
              </button>
            </div>

            @if ($project->other_details)
            <div class="card-body">
              
              <div class="sections-container" id="sectionsContainer">
                @foreach(($project->other_details ?? []) as $s_index => $section)
                <div class="section-item" data-section-id="{{ $s_index }}">
                  <input type="hidden" class="section-type-input" name="sections[{{ $s_index }}][type]" value="{{ $section['type'] ?? 'text' }}" />
                  <input type="hidden" class="section-order-input" name="sections[{{ $s_index }}][order]" value="{{ $section['order'] ?? ($s_index + 1) }}" />
                  <div class="section-item-header" onclick="toggleSectionBody(this)">
                    <div class="section-header-left">
                      <div class="drag-handle" title="Drag to reorder">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="5" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="19" r="1"/><circle cx="15" cy="5" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="19" r="1"/></svg>
                      </div>
                      <span class="section-item-title">{{ $section['content']['title'] ?? 'Project Other Content' }}</span>
                    </div>
                    <div class="section-actions" onclick="event.stopPropagation()">
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
                              <div class="field"><label>Section Heading</label><input class="input" name="sections[{{ $s_index }}][title]" placeholder="Block Heading" value="{{ $section['content']['title'] ?? '' }}" /></div>
        <div class="field"><label>Body Content</label><textarea class="textarea" name="sections[{{ $s_index }}][body]" rows="4" placeholder="Enter paragraph content...">{{ $section['content']['body'] ?? '' }}</textarea></div>

                    </div>
                  </div>
                </div>
                @endforeach

              </div>
            </div>

            @endif

            
          </div>
          
        </div>

        <div style="display:flex;flex-direction:column;gap:18px;flex:1;">
          <div class="card">
            <div class="card-head"><h3>Status & Publishing</h3></div>
            <div class="card-body">
              <div class="field">
                <label>Status</label>
                <select class="input" name="status">
                  <option value="published" selected>Published</option>
                  <option value="draft">Draft</option>
                  <option value="archived">Archived</option>
                </select>
              </div>
              <div class="field" style="margin-top:14px;">
                <label>URL Slug</label>
                <input class="input" name="slug" value="revenue-pulse" />
              </div>
              <div class="field" style="margin-top:14px;">
                <label>Live Link</label>
                <input class="input" name="url" value="https://example.com/pulse" placeholder="https://" />
              </div>
            </div>
            <div class="card-head" style="border-top:1px solid var(--c-border);border-bottom:none;display:flex;flex-direction:column;gap:10px;">
              <button class="btn" style="width:100%;justify-content:center;">Save changes</button>
              <button class="btn secondary text-red" style="width:100%;justify-content:center;color:var(--c-danger);">Delete project</button>
            </div>
          </div>

          <div class="card">
            <div class="card-head"><h3>Media</h3></div>
            <div class="card-body">
              <div class="field">
                <label>Cover image</label>
                <div style="border:2px dashed var(--c-border);border-radius:6px;padding:24px;text-align:center;background:var(--c-bg-subtle);">
                  <div style="margin-bottom:8px;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--c-muted)" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                  <div style="font-size:13px;color:var(--c-text);">Drag and drop image here</div>
                  <div style="font-size:12px;color:var(--c-muted);margin-top:4px;">or <label style="color:var(--accent);cursor:pointer;">browse files<input type="file" style="display:none;"/></label></div>
                </div>
                <div style="margin-top:12px;border-radius:6px;overflow:hidden;border:1px solid var(--c-border);">
                  <img src="assets/work-1.jpg" style="width:100%;display:block;height:120px;object-fit:cover;" />
                </div>
              </div>
            </div>
          </div>
        </div>

        </form>
      </div>

















  


<script>
  // Page Section Builder Interactive Logic

  function reindexSections() {
    const items = document.querySelectorAll('#sectionsContainer .section-item');
    items.forEach((item, index) => {
      // Re-index all form input names to sections[index][fieldname]
      const inputs = item.querySelectorAll('input, select, textarea');
      inputs.forEach(input => {
        if (input.name) {
          input.name = input.name.replace(/^sections\[\d+\]/, `sections[${index}]`);
        }
      });
      // Update order hidden field
      const orderInput = item.querySelector('.section-order-input');
      if (orderInput) orderInput.value = index + 1;
    });

    // Update section count badge
    const badge = document.getElementById('sectionCountBadge');
    if (badge) {
      badge.textContent = `${items.length} Active Section${items.length === 1 ? '' : 's'}`;
    }
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
      flash('Section reordered', 'info');
    }
  }

  function moveSectionDown(btn) {
    const item = btn.closest('.section-item');
    const next = item.nextElementSibling;
    if (next) {
      item.parentNode.insertBefore(next, item);
      reindexSections();
      flash('Section reordered', 'info');
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
        flash(`Removed "${title}"`, 'info');
      }, 200);
    }
  }

  let newSectionIdCounter = 10;

  function createNewSection(type) {
    newSectionIdCounter++;
    const container = document.getElementById('sectionsContainer');
    const id = `sec_${newSectionIdCounter}`;
    const nextIndex = container.children.length;
    
    let badgeClass = 'badge-blue';
    let badgeLabel = 'Custom';
    let title = 'New Section';
    let bodyFields = '';

    if (type === 'text') {
      badgeClass = 'badge-blue';
      badgeLabel = 'Text Block';
      title = 'Custom Text & Story Block';
      bodyFields = `
        <div class="field"><label>Section Heading</label><input class="input" name="sections[${nextIndex}][title]" placeholder="Block Heading" /></div>
        <div class="field"><label>Body Content</label><textarea class="textarea" name="sections[${nextIndex}][body]" rows="4" placeholder="Enter paragraph content..."></textarea></div>
      `;
    }

    const sectionEl = document.createElement('div');
    sectionEl.className = 'section-item';
    sectionEl.dataset.sectionId = id;
    sectionEl.innerHTML = `
      <input type="hidden" class="section-type-input" name="sections[${nextIndex}][type]" value="${type}" />
      <input type="hidden" class="section-order-input" name="sections[${nextIndex}][order]" value="${nextIndex + 1}" />
      <div class="section-item-header" onclick="toggleSectionBody(this)">
        <div class="section-header-left">
          <div class="drag-handle" title="Drag to reorder">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="5" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="19" r="1"/><circle cx="15" cy="5" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="19" r="1"/></svg>
          </div>
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
    
    // Close modal
    closeModal(document.getElementById('addSectionModal'));
    
    // Flash message
    flash(`Added new "${title}" section`, 'success');
  }
</script>
</x-admin-layout>