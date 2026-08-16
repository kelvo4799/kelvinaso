<x-admin-layout :page="$page" :profile="$profile" :settings="$settings ?? ['site_name' => 'Portfolio']">

    <div class="page-header">
        <div>
            <h1>{{ $post->exists ? 'Edit Article' : 'Create New Article' }}</h1>
            <div class="sub">{{ $post->exists ? 'Update details for "' . $post->title . '".' : 'Draft and publish a new blog post.' }}</div>
        </div>
        <div style="display:flex;gap:10px;align-items:center;">
            <a href="{{ route('blog.admin') }}" class="btn secondary sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back to Blog
            </a>
            @if ($post->exists && $post->slug)
                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn secondary sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    View Public Page
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
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ $post->exists ? route('blog.update.admin', $post->slug) : route('blog.store.admin') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($post->exists)
            @method('PATCH')
        @endif

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">

            <!-- Left Column: Main Editor -->
            <div style="display: flex; flex-direction: column; gap: 24px;">

                <div class="card">
                    <div class="card-head">
                        <h3>Article Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">

                            <div class="field">
                                <label for="title">Article Title</label>
                                <input class="input" id="title" name="title" value="{{ old('title', $post->title) }}" placeholder="e.g. Building Scalable Applications with Laravel" required />
                            </div>

                            <div class="field">
                                <label for="slug">URL Slug <span class="muted" style="font-weight:400">(Auto-generated if left blank)</span></label>
                                <input class="input" id="slug" name="slug" value="{{ old('slug', $post->slug) }}" placeholder="building-scalable-applications-with-laravel" />
                            </div>

                            <div class="field">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                    <label for="excerpt" style="margin:0;">Excerpt / Summary <span class="muted" style="font-weight:400">(Brief overview for cards)</span></label>
                                    <button type="button" class="btn secondary sm" id="btnAiExcerpt" onclick="generateAiExcerpt()" style="font-size: 0.75rem; padding: 2px 10px;">
                                        ✨ Auto-Summarize Excerpt
                                    </button>
                                </div>
                                <textarea class="textarea" id="excerpt" name="excerpt" rows="3" placeholder="Brief summary of the article...">{{ old('excerpt', $post->excerpt) }}</textarea>
                            </div>

                            <div class="field">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                    <label for="content" style="margin:0;">Full Article Content</label>
                                    <button type="button" class="btn primary-colored sm" id="btnAiContent" onclick="generateAiContent()" style="font-size: 0.75rem; padding: 2px 10px;">
                                        ✨ Generate Article with AI
                                    </button>
                                </div>
                                <textarea class="textarea" id="content" name="content" rows="18" placeholder="Write your full blog post content here..." required style="font-size: 0.95rem; line-height: 1.6;">{{ old('content', $post->content) }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Settings & Media Sidebar -->
            <div style="display: flex; flex-direction: column; gap: 24px;">

                <!-- Status & Publishing Card -->
                <div class="card">
                    <div class="card-head">
                        <h3>Publishing Options</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">

                            <div class="field">
                                <label for="status">Publishing Status</label>
                                <select class="input" id="status" name="status">
                                    <option value="published" {{ old('status', $post->is_published ? 'published' : 'draft') == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="draft" {{ old('status', $post->is_published ? 'published' : 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>

                            <div class="field">
                                <label for="category">Category</label>
                                <input class="input" id="category" name="category" value="{{ old('category', $post->category ?: 'Tech') }}" placeholder="e.g. Tech, Engineering, Design" />
                            </div>

                            <div class="field">
                                <label for="read_time">Estimated Reading Time</label>
                                <input class="input" id="read_time" name="read_time" value="{{ old('read_time', $post->read_time ?: '5 min read') }}" placeholder="e.g. 5 min read" />
                            </div>

                            <div class="field">
                                <label for="tags">Tags <span class="muted" style="font-weight:400">(Comma separated)</span></label>
                                <input class="input" id="tags" name="tags" value="{{ old('tags', $post->formatted_tags ?? (is_array($post->tags) ? implode(', ', $post->tags) : '')) }}" placeholder="PHP, Laravel, Architecture" />
                            </div>

                        </div>
                    </div>
                    <div class="card-head" style="border-top: 1px solid var(--c-border); border-bottom: none; display: flex; flex-direction: column; gap: 12px; padding: 20px 28px;">
                        <button type="submit" class="btn primary-colored" style="width: 100%; justify-content: center;">
                            {{ $post->exists ? 'Save Changes' : 'Publish Article' }}
                        </button>
                        @if ($post->exists)
                            <button type="button" class="btn secondary" style="width: 100%; justify-content: center; color: var(--c-danger);" onclick="confirmDeleteArticle()">
                                Delete Article
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Cover Image Card -->
                <div class="card">
                    <div class="card-head">
                        <h3>Cover Image</h3>
                    </div>
                    <div class="card-body">
                        <div class="field">
                            <label>Article Cover Image</label>
                            <div class="image-upload-dropzone" id="coverDropzone" onclick="document.getElementById('cover_image_input').click()" style="border: 2px dashed var(--c-border); border-radius: var(--radius-sm); padding: 24px; text-align: center; background: var(--c-bg-subtle); cursor: pointer; transition: all 0.2s ease;">
                                <div style="margin-bottom: 8px;">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                                <div style="font-size: 13px; color: var(--c-text); font-weight: 500;">Click or drag cover image here</div>
                                <div style="font-size: 12px; color: var(--c-text-muted); margin-top: 4px;">JPG, PNG, WEBP, GIF or HEIC</div>
                                <input type="file" id="cover_image_input" name="cover_image" accept="image/*" style="display: none;" onchange="previewCoverImage(this)" />
                            </div>

                            <div id="imagePreviewContainer" style="margin-top: 14px; {{ $post->cover_image ? '' : 'display: none;' }}">
                                <div style="font-size: 0.75rem; font-weight: 600; color: var(--c-text-muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em;">Current Cover Preview</div>
                                <div style="position: relative; border-radius: var(--radius-sm); overflow: hidden; border: 1px solid var(--c-border); background: var(--c-bg-subtle);">
                                    <img id="cover_image_preview" src="{{ $post->cover_image ? (str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset($post->cover_image)) : '' }}" style="width: 100%; display: block; max-height: 180px; object-fit: cover;" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>

    @if ($post->exists)
        <form id="deleteArticleForm" action="{{ route('blog.destroy.admin', $post->slug) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endif

    <script>
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

        function confirmDeleteArticle() {
            if (confirm('Are you sure you want to delete this article? This action cannot be undone.')) {
                document.getElementById('deleteArticleForm').submit();
            }
        }

        async function generateAiContent() {
            const titleInput = document.getElementById('title');
            const categoryInput = document.getElementById('category');
            const btn = document.getElementById('btnAiContent');

            const title = titleInput ? titleInput.value.trim() : '';
            const category = categoryInput ? categoryInput.value.trim() : 'Tech';

            if (!title) {
                alert('Please enter an Article Title first so the AI knows what topic to write about.');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '✨ Generating with Groq AI...';

            try {
                const response = await fetch('{{ route("ai.generate-blog.admin") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ title, category })
                });

                const data = await response.json();
                if (data.success && data.content) {
                    document.getElementById('content').value = data.content;
                } else {
                    alert(data.content || 'Failed to generate article.');
                }
            } catch (err) {
                alert('AI Generation request failed. Please check your GROQ_API_KEY configuration in .env.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '✨ Generate Article with AI';
            }
        }

        async function generateAiExcerpt() {
            const contentInput = document.getElementById('content');
            const btn = document.getElementById('btnAiExcerpt');

            const content = contentInput ? contentInput.value.trim() : '';

            if (!content) {
                alert('Please provide Article Content first to generate a summary excerpt.');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '✨ Summarizing...';

            try {
                const response = await fetch('{{ route("ai.generate-excerpt.admin") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ content })
                });

                const data = await response.json();
                if (data.success && data.excerpt) {
                    document.getElementById('excerpt').value = data.excerpt;
                } else {
                    alert(data.excerpt || 'Failed to generate excerpt.');
                }
            } catch (err) {
                alert('AI Excerpt request failed.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '✨ Auto-Summarize Excerpt';
            }
        }
    </script>

</x-admin-layout>
