<x-admin-layout :page="$page" :profile="$profile">

    <div class="page-header">
        <div>
            <h1>{{ $isEdit ? 'Edit Email Template: ' . $template->slug : 'Create New Email Template' }}</h1>
            <div class="sub">Configure automated email subjects, HTML layout, and status.</div>
        </div>
        <div>
            <a href="{{ route('emails.admin') }}" class="btn secondary">
                &larr; Back to Email Templates
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

    <form action="{{ $isEdit ? route('emails.update.admin', $template->id) : route('emails.store.admin') }}" method="POST">
        @csrf
        @if ($isEdit)
            @method('PATCH')
        @endif

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">

            <!-- Left Column: Form Fields & Body HTML Editor -->
            <div style="display: flex; flex-direction: column; gap: 24px;">

                <div class="card">
                    <div class="card-head">
                        <h3>Template Details & Subject</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">

                            <div class="form-grid cols-2">
                                <div class="field">
                                    <label for="slug">Template Slug / Identifier <span class="muted" style="font-weight:400">(Unique key)</span></label>
                                    <input class="input" id="slug" name="slug" value="{{ old('slug', $template->slug) }}" required placeholder="e.g. contact_reply" />
                                </div>
                                <div class="field">
                                    <label for="subject">Email Subject Line</label>
                                    <input class="input" id="subject" name="subject" value="{{ old('subject', $template->subject) }}" required placeholder="e.g. Re: @{{ subject }} - Reply from Keviloq" />
                                </div>
                            </div>

                            <div class="field">
                                <label for="body_html">HTML Body Content</label>
                                <textarea class="textarea" id="body_html" name="body_html" rows="14" style="font-family: monospace; font-size: 0.9rem; line-height: 1.5;" required placeholder="<p>Hi @{{ name }},</p>...">{{ old('body_html', $template->body_html) }}</textarea>
                            </div>

                        </div>
                    </div>
                    <div class="card-head" style="border-top: 1px solid var(--c-border); border-bottom: none; padding: 20px 28px;">
                        <button type="submit" class="btn primary-colored">
                            {{ $isEdit ? 'Save Template Changes' : 'Create Email Template' }}
                        </button>
                    </div>
                </div>

            </div>

            <!-- Right Column: Settings & Live Preview -->
            <div style="display: flex; flex-direction: column; gap: 24px;">

                <!-- Status & Options Card -->
                <div class="card">
                    <div class="card-head">
                        <h3>Template Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="field" style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $template->is_active ?? true) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                            <label for="is_active" style="margin: 0; cursor: pointer; font-size: 0.9rem; font-weight: 600;">Enable this Email Template</label>
                        </div>
                    </div>
                </div>

                <!-- HTML Live Code Preview Card -->
                <div class="card">
                    <div class="card-head">
                        <h3>Live HTML Preview</h3>
                    </div>
                    <div class="card-body">
                        <div id="htmlPreview" style="background: #fff; color: #000; padding: 16px; border-radius: var(--radius-sm); border: 1px solid var(--c-border); min-height: 200px; font-size: 0.85rem; line-height: 1.6; overflow-y: auto; max-height: 350px;">
                            {!! old('body_html', $template->body_html) !!}
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </form>

    <script>
        const bodyInput = document.getElementById('body_html');
        const previewDiv = document.getElementById('htmlPreview');

        if (bodyInput && previewDiv) {
            bodyInput.addEventListener('input', function() {
                previewDiv.innerHTML = bodyInput.value;
            });
        }
    </script>

</x-admin-layout>
