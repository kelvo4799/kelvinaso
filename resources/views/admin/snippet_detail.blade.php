<x-admin-layout :page="$page" :profile="$profile">

    <div class="page-header">
        <div>
            <h1>{{ $isEdit ? 'Edit Snippet: ' . $snippet->title : 'Create Code Snippet' }}</h1>
            <div class="sub">Write reusable code blocks, language tags, and explanations.</div>
        </div>
        <div>
            <a href="{{ route('snippets.admin') }}" class="btn secondary">
                &larr; Back to Snippets
            </a>
        </div>
    </div>

    @if ($errors->any())
    <div style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; font-weight: 500; font-size: 0.9rem;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ $isEdit ? route('snippets.update.admin', $snippet->id) : route('snippets.store.admin') }}" method="POST">
        @csrf
        @if ($isEdit)
            @method('PATCH')
        @endif

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">

            <div style="display: flex; flex-direction: column; gap: 24px;">

                <div class="card">
                    <div class="card-head">
                        <h3>Snippet Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">

                            <div class="form-grid cols-2">
                                <div class="field">
                                    <label for="title">Snippet Title</label>
                                    <input class="input" id="title" name="title" value="{{ old('title', $snippet->title) }}" required placeholder="e.g. Groq AI Client Pattern in PHP" />
                                </div>
                                <div class="field">
                                    <label for="category">Category / Tag</label>
                                    <input class="input" id="category" name="category" value="{{ old('category', $snippet->category ?? 'Laravel') }}" placeholder="e.g. Laravel, React, SQL" />
                                </div>
                            </div>

                            <div class="form-grid cols-2">
                                <div class="field">
                                    <label for="language">Programming Language</label>
                                    <select class="input" id="language" name="language">
                                        <option value="php" {{ old('language', $snippet->language) === 'php' ? 'selected' : '' }}>PHP / Laravel</option>
                                        <option value="javascript" {{ old('language', $snippet->language) === 'javascript' ? 'selected' : '' }}>JavaScript / Vue / React</option>
                                        <option value="typescript" {{ old('language', $snippet->language) === 'typescript' ? 'selected' : '' }}>TypeScript</option>
                                        <option value="sql" {{ old('language', $snippet->language) === 'sql' ? 'selected' : '' }}>SQL / Database</option>
                                        <option value="css" {{ old('language', $snippet->language) === 'css' ? 'selected' : '' }}>CSS / Tailwind</option>
                                        <option value="bash" {{ old('language', $snippet->language) === 'bash' ? 'selected' : '' }}>Bash / Shell</option>
                                        <option value="json" {{ old('language', $snippet->language) === 'json' ? 'selected' : '' }}>JSON / Config</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label for="slug">URL Slug <span class="muted" style="font-weight:400">(Auto-generated if empty)</span></label>
                                    <input class="input" id="slug" name="slug" value="{{ old('slug', $snippet->slug) }}" placeholder="groq-ai-client-pattern" />
                                </div>
                            </div>

                            <div class="field">
                                <label for="description">Short Description / Explanation</label>
                                <textarea class="textarea" id="description" name="description" rows="3" placeholder="Brief context explaining what this code snippet accomplishes...">{{ old('description', $snippet->description) }}</textarea>
                            </div>

                            <div class="field">
                                <label for="code_content">Code Content</label>
                                <textarea class="textarea" id="code_content" name="code_content" rows="12" style="font-family: monospace; font-size: 0.9rem; line-height: 1.5; background: #0f1016; color: #38bdf8;" required placeholder="// Paste your code here...">{{ old('code_content', $snippet->code_content) }}</textarea>
                            </div>

                        </div>
                    </div>
                    <div class="card-head" style="border-top: 1px solid var(--c-border); border-bottom: none; padding: 20px 28px;">
                        <button type="submit" class="btn primary-colored">
                            {{ $isEdit ? 'Save Snippet Changes' : 'Create Code Snippet' }}
                        </button>
                    </div>
                </div>

            </div>

            <div style="display: flex; flex-direction: column; gap: 24px;">

                <div class="card">
                    <div class="card-head">
                        <h3>Status Options</h3>
                    </div>
                    <div class="card-body">
                        <div class="field" style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $snippet->is_active ?? true) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                            <label for="is_active" style="margin: 0; cursor: pointer; font-size: 0.9rem; font-weight: 600;">Publish Snippet to Portfolio</label>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </form>

</x-admin-layout>
