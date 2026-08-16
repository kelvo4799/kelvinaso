<x-admin-layout :page="$page" :profile="$profile">

    <div class="page-header">
        <div>
            <h1>Email Templates & Mail Configuration</h1>
            <div class="sub">Manage automated email templates, global branding headers & footers, and send test dispatches.</div>
        </div>
        <div>
            <a href="{{ route('emails.create.admin') }}" class="btn primary-colored">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Create Email Template
            </a>
        </div>
    </div>

    @if (session('success'))
    <div style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if (session('error'))
    <div style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">

        <!-- Left Column: Templates List & Placeholders -->
        <div style="display: flex; flex-direction: column; gap: 24px;">

            <!-- Email Templates Table Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Available Email Templates</h3>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem; text-align: left;">
                            <thead>
                                <tr style="border-bottom: 1px solid var(--c-border); background: var(--c-bg-subtle);">
                                    <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Template Key / Slug</th>
                                    <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Subject</th>
                                    <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase;">Status</th>
                                    <th style="padding: 14px 20px; color: var(--c-text-muted); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($templates as $template)
                                    <tr style="border-bottom: 1px solid var(--c-border);">
                                        <td style="padding: 16px 20px;">
                                            <code style="font-size: 0.85rem; padding: 2px 6px; border-radius: 4px; background: rgba(99, 102, 241, 0.1); color: var(--accent); font-weight: 600;">{{ $template->slug }}</code>
                                        </td>
                                        <td style="padding: 16px 20px; color: var(--c-text); font-weight: 500;">
                                            {{ $template->subject }}
                                        </td>
                                        <td style="padding: 16px 20px;">
                                            @if ($template->is_active)
                                                <span style="display: inline-block; padding: 2px 10px; border-radius: 10px; font-size: 0.75rem; font-weight: 700; background: rgba(16, 185, 129, 0.15); color: #10b981;">Active</span>
                                            @else
                                                <span style="display: inline-block; padding: 2px 10px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: var(--c-bg-subtle); color: var(--c-text-muted);">Disabled</span>
                                            @endif
                                        </td>
                                        <td style="padding: 16px 20px; text-align: right;">
                                            <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                                <a href="{{ route('emails.edit.admin', $template->id) }}" class="btn secondary sm" style="font-size: 0.75rem; padding: 4px 10px;">
                                                    Edit
                                                </a>
                                                <form action="{{ route('emails.destroy.admin', $template->id) }}" method="POST" onsubmit="return confirm('Delete this email template?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn ghost sm" style="font-size: 0.75rem; color: var(--c-danger); padding: 4px 10px;">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="padding: 32px; text-align: center; color: var(--c-text-muted);">
                                            No email templates created yet. Click "+ Create Email Template" to get started.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Placeholders Guide Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Dynamic Template Placeholders Guide</h3>
                </div>
                <div class="card-body">
                    <p style="font-size: 0.875rem; color: var(--c-text-muted); margin-bottom: 14px; line-height: 1.5;">
                        You can embed dynamic variables into your email subjects and HTML bodies using double curly braces: <code>&#123;&#123; variable_name &#125;&#125;</code>.
                    </p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; font-size: 0.85rem;">
                        <div style="padding: 10px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border);">
                            <code style="color: var(--accent); font-weight: 700;">&#123;&#123; name &#125;&#125;</code>
                            <div style="color: var(--c-text-muted); font-size: 0.75rem; margin-top: 2px;">Visitor / Recipient Full Name</div>
                        </div>
                        <div style="padding: 10px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border);">
                            <code style="color: var(--accent); font-weight: 700;">&#123;&#123; email &#125;&#125;</code>
                            <div style="color: var(--c-text-muted); font-size: 0.75rem; margin-top: 2px;">Recipient Email Address</div>
                        </div>
                        <div style="padding: 10px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border);">
                            <code style="color: var(--accent); font-weight: 700;">&#123;&#123; subject &#125;&#125;</code>
                            <div style="color: var(--c-text-muted); font-size: 0.75rem; margin-top: 2px;">Message Subject Line</div>
                        </div>
                        <div style="padding: 10px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border);">
                            <code style="color: var(--accent); font-weight: 700;">&#123;&#123; reply_message &#125;&#125;</code>
                            <div style="color: var(--c-text-muted); font-size: 0.75rem; margin-top: 2px;">Admin Reply Body Text</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Global Email Layout & Test Dispatch -->
        <div style="display: flex; flex-direction: column; gap: 24px;">

            <!-- Global Layout Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Global Email Layout & Branding</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('emails.global.admin') }}" method="POST">
                        @csrf

                        <div class="field" style="margin-bottom: 16px;">
                            <label for="header_html">Global Email Header HTML</label>
                            <textarea class="textarea" id="header_html" name="header_html" rows="5" style="font-family: monospace; font-size: 0.8rem;" placeholder="<div style='background:#0f1016...'>">{{ old('header_html', $emailSetting->header_html) }}</textarea>
                        </div>

                        <div class="field" style="margin-bottom: 16px;">
                            <label for="footer_html">Global Email Footer HTML</label>
                            <textarea class="textarea" id="footer_html" name="footer_html" rows="5" style="font-family: monospace; font-size: 0.8rem;" placeholder="<div style='background:#f8fafc...'>">{{ old('footer_html', $emailSetting->footer_html) }}</textarea>
                        </div>

                        <button type="submit" class="btn primary-colored" style="width: 100%; justify-content: center;">
                            Save Global Branding
                        </button>
                    </form>
                </div>
            </div>

            <!-- Test Email Dispatch Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Send Test Email</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('emails.test.admin') }}" method="POST">
                        @csrf

                        <div class="field" style="margin-bottom: 16px;">
                            <label for="test_email">Recipient Email Address</label>
                            <input class="input" type="email" id="test_email" name="test_email" value="{{ Auth::user()->email }}" required placeholder="admin@domain.com" />
                        </div>

                        <button type="submit" class="btn secondary" style="width: 100%; justify-content: center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                            Dispatch Test Email
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</x-admin-layout>
