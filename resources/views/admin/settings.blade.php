<x-admin-layout :page="$page" :profile="$profile" :settings="$settings">

    <div class="page-header">
        <div>
            <h1>Site Settings & Configuration</h1>
            <div class="sub">Manage general site identity, SEO metadata, branding logos, API keys, and global options.</div>
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

    <form action="{{ route('settings.update.admin') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">

            <!-- Left Column: Main Settings Forms -->
            <div style="display: flex; flex-direction: column; gap: 24px;">

                <!-- General Identity & SEO Card -->
                <div class="card">
                    <div class="card-head">
                        <h3>Site Identity & SEO</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">

                            <div class="form-grid cols-2">
                                <div class="field">
                                    <label for="site_name">Site Name / Brand</label>
                                    <input class="input" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}" required placeholder="e.g. Keviloq Systems" />
                                </div>
                                <div class="field">
                                    <label for="site_tagline">Site Tagline</label>
                                    <input class="input" id="site_tagline" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}" placeholder="e.g. Building Scalable Web & Mobile Solutions" />
                                </div>
                            </div>

                            <div class="field">
                                <label for="site_description">Meta Description <span class="muted" style="font-weight:400">(SEO search snippet)</span></label>
                                <textarea class="textarea" id="site_description" name="site_description" rows="3" placeholder="Brief site description for search engines...">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                            </div>

                            <div class="field">
                                <label for="site_keywords">Meta Keywords <span class="muted" style="font-weight:400">(Comma separated)</span></label>
                                <input class="input" id="site_keywords" name="site_keywords" value="{{ old('site_keywords', $settings['site_keywords'] ?? '') }}" placeholder="Laravel, Software Engineer, Web Development" />
                            </div>

                            <div class="form-grid cols-2">
                                <div class="field">
                                    <label for="contact_email">Admin Contact Email</label>
                                    <input class="input" type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" placeholder="contact@domain.com" />
                                </div>
                                <div class="field">
                                    <label for="footer_copyright">Footer Copyright Text</label>
                                    <input class="input" id="footer_copyright" name="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '') }}" placeholder="© 2026 Keviloq Systems" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Footer & Call to Action (CTA) Card -->
                <div class="card">
                    <div class="card-head">
                        <h3>Footer Banner & Call to Action (CTA)</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">

                            <div class="field">
                                <label for="footer_cta_title">CTA Banner Heading</label>
                                <input class="input" id="footer_cta_title" name="footer_cta_title" value="{{ old('footer_cta_title', $settings['footer_cta_title'] ?? '') }}" placeholder="Are You Ready to kickstart your project..." />
                            </div>

                            <div class="field">
                                <label for="footer_cta_description">CTA Banner Description</label>
                                <textarea class="textarea" id="footer_cta_description" name="footer_cta_description" rows="3" placeholder="Reach out and let's make it happen...">{{ old('footer_cta_description', $settings['footer_cta_description'] ?? '') }}</textarea>
                            </div>

                            <div class="form-grid cols-2">
                                <div class="field">
                                    <label for="footer_cta_button_text">CTA Button Text</label>
                                    <input class="input" id="footer_cta_button_text" name="footer_cta_button_text" value="{{ old('footer_cta_button_text', $settings['footer_cta_button_text'] ?? '') }}" placeholder="Let's Talk" />
                                </div>
                                <div class="field">
                                    <label for="footer_cta_button_url">CTA Button Link / URL</label>
                                    <input class="input" id="footer_cta_button_url" name="footer_cta_button_url" value="{{ old('footer_cta_button_url', $settings['footer_cta_button_url'] ?? '') }}" placeholder="/contact" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Feature Modules ON/OFF Control Center -->
                <div class="card">
                    <div class="card-head">
                        <h3>Portfolio Modules & Feature Switches</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">

                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                                <div style="display: flex; align-items: center; gap: 10px; padding: 12px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border);">
                                    <input type="checkbox" id="enable_blog" name="enable_blog" value="1" {{ ($settings['enable_blog'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                                    <label for="enable_blog" style="margin: 0; cursor: pointer; font-size: 0.9rem; font-weight: 600;">Enable Blog Module</label>
                                </div>

                                <div style="display: flex; align-items: center; gap: 10px; padding: 12px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border);">
                                    <input type="checkbox" id="enable_experiences" name="enable_experiences" value="1" {{ ($settings['enable_experiences'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                                    <label for="enable_experiences" style="margin: 0; cursor: pointer; font-size: 0.9rem; font-weight: 600;">Enable Work Experience</label>
                                </div>

                                <div style="display: flex; align-items: center; gap: 10px; padding: 12px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border);">
                                    <input type="checkbox" id="enable_snippets" name="enable_snippets" value="1" {{ ($settings['enable_snippets'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                                    <label for="enable_snippets" style="margin: 0; cursor: pointer; font-size: 0.9rem; font-weight: 600;">Enable Code Snippets</label>
                                </div>

                                <div style="display: flex; align-items: center; gap: 10px; padding: 12px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border);">
                                    <input type="checkbox" id="enable_scheduler" name="enable_scheduler" value="1" {{ ($settings['enable_scheduler'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                                    <label for="enable_scheduler" style="margin: 0; cursor: pointer; font-size: 0.9rem; font-weight: 600;">Enable Discovery Call Scheduler</label>
                                </div>

                                <div style="display: flex; align-items: center; gap: 10px; padding: 12px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border);">
                                    <input type="checkbox" id="enable_ai_chatbot" name="enable_ai_chatbot" value="1" {{ ($settings['enable_ai_chatbot'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                                    <label for="enable_ai_chatbot" style="margin: 0; cursor: pointer; font-size: 0.9rem; font-weight: 600;">Enable Visitor AI Chatbot</label>
                                </div>

                                <div style="display: flex; align-items: center; gap: 10px; padding: 12px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border);">
                                    <input type="checkbox" id="enable_github_sync" name="enable_github_sync" value="1" {{ ($settings['enable_github_sync'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                                    <label for="enable_github_sync" style="margin: 0; cursor: pointer; font-size: 0.9rem; font-weight: 600;">Enable Live GitHub Sync</label>
                                </div>
                            </div>

                            <div class="form-grid cols-2" style="margin-top: 12px;">
                                <div class="field">
                                    <label for="calendly_url">Discovery Booking URL / Calendly Link</label>
                                    <input class="input" id="calendly_url" name="calendly_url" value="{{ old('calendly_url', $settings['calendly_url'] ?? 'https://calendly.com') }}" placeholder="https://calendly.com/your-username" />
                                </div>
                                <div class="field">
                                    <label for="github_username">GitHub Username (for Live Sync)</label>
                                    <input class="input" id="github_username" name="github_username" value="{{ old('github_username', $settings['github_username'] ?? 'kelvinaso') }}" placeholder="username" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- API Keys Card -->
                <div class="card">
                    <div class="card-head">
                        <h3>AI & Third-Party API Keys</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">

                            <div class="field">
                                <label for="groq_api_key">Groq Cloud API Key <span class="muted" style="font-weight:400">(Powers Llama 3.3 Free AI)</span></label>
                                <input class="input" type="password" id="groq_api_key" name="groq_api_key" value="{{ old('groq_api_key', $settings['groq_api_key'] ?? '') }}" placeholder="gsk_..." />
                            </div>

                            <div class="field">
                                <label for="gemini_api_key">Google Gemini API Key</label>
                                <input class="input" type="password" id="gemini_api_key" name="gemini_api_key" value="{{ old('gemini_api_key', $settings['gemini_api_key'] ?? '') }}" placeholder="AIzaSy..." />
                            </div>

                            <div class="field">
                                <label for="grok_api_key">xAI Grok API Key</label>
                                <input class="input" type="password" id="grok_api_key" name="grok_api_key" value="{{ old('grok_api_key', $settings['grok_api_key'] ?? '') }}" placeholder="xai-..." />
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Analytics & Scripts Card -->
                <div class="card">
                    <div class="card-head">
                        <h3>Analytics & Custom Scripts</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">

                            <div class="field">
                                <label for="google_analytics_id">Google Analytics Tracking ID</label>
                                <input class="input" id="google_analytics_id" name="google_analytics_id" value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}" placeholder="G-XXXXXXXXXX" />
                            </div>

                            <div class="field">
                                <label for="custom_head_scripts">Custom Head HTML Scripts <span class="muted" style="font-weight:400">(Injected before &lt;/head&gt;)</span></label>
                                <textarea class="textarea" id="custom_head_scripts" name="custom_head_scripts" rows="4" placeholder="&lt;script&gt;...&lt;/script&gt;">{{ old('custom_head_scripts', $settings['custom_head_scripts'] ?? '') }}</textarea>
                            </div>

                        </div>
                    </div>
                    <div class="card-head" style="border-top: 1px solid var(--c-border); border-bottom: none; padding: 20px 28px;">
                        <button type="submit" class="btn primary-colored">Save All Settings</button>
                    </div>
                </div>

            </div>

            <!-- Right Column: Color Theme & Logo Uploads -->
            <div style="display: flex; flex-direction: column; gap: 24px;">

                <!-- Theme Colors Customizer Card -->
                <div class="card">
                    <div class="card-head">
                        <h3>Theme Colors & Brand Accent</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">

                            <div class="field">
                                <label for="primary_color">Primary Accent Color</label>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <input type="color" id="primary_color_picker" value="{{ old('primary_color', $settings['primary_color'] ?? '#f0563a') }}" onchange="document.getElementById('primary_color').value = this.value" style="width: 44px; height: 38px; padding: 2px; border-radius: var(--radius-sm); border: 1px solid var(--c-border); cursor: pointer; background: transparent;" />
                                    <input class="input" id="primary_color" name="primary_color" value="{{ old('primary_color', $settings['primary_color'] ?? '#f0563a') }}" onchange="document.getElementById('primary_color_picker').value = this.value" placeholder="#f0563a" style="flex: 1;" />
                                </div>
                            </div>

                            <div class="field">
                                <label for="accent_color">Gradient Accent Color</label>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <input type="color" id="accent_color_picker" value="{{ old('accent_color', $settings['accent_color'] ?? '#db391c') }}" onchange="document.getElementById('accent_color').value = this.value" style="width: 44px; height: 38px; padding: 2px; border-radius: var(--radius-sm); border: 1px solid var(--c-border); cursor: pointer; background: transparent;" />
                                    <input class="input" id="accent_color" name="accent_color" value="{{ old('accent_color', $settings['accent_color'] ?? '#db391c') }}" onchange="document.getElementById('accent_color_picker').value = this.value" placeholder="#db391c" style="flex: 1;" />
                                </div>
                            </div>

                            <div class="field">
                                <label for="secondary_color">Secondary Brand Color</label>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <input type="color" id="secondary_color_picker" value="{{ old('secondary_color', $settings['secondary_color'] ?? '#6366f1') }}" onchange="document.getElementById('secondary_color').value = this.value" style="width: 44px; height: 38px; padding: 2px; border-radius: var(--radius-sm); border: 1px solid var(--c-border); cursor: pointer; background: transparent;" />
                                    <input class="input" id="secondary_color" name="secondary_color" value="{{ old('secondary_color', $settings['secondary_color'] ?? '#6366f1') }}" onchange="document.getElementById('secondary_color_picker').value = this.value" placeholder="#6366f1" style="flex: 1;" />
                                </div>
                            </div>

                            <div class="field">
                                <label style="margin-bottom: 8px;">Quick Color Palette Presets</label>
                                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                                    <button type="button" onclick="setPresetColor('#f0563a', '#db391c')" style="display: flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 6px; border: 1px solid var(--c-border); background: var(--c-bg-subtle); color: var(--c-text); cursor: pointer; font-size: 0.75rem;">
                                        <span style="width: 14px; height: 14px; border-radius: 50%; background: linear-gradient(135deg, #f0563a, #db391c); display: inline-block;"></span>
                                        Orange
                                    </button>
                                    <button type="button" onclick="setPresetColor('#10b981', '#059669')" style="display: flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 6px; border: 1px solid var(--c-border); background: var(--c-bg-subtle); color: var(--c-text); cursor: pointer; font-size: 0.75rem;">
                                        <span style="width: 14px; height: 14px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #059669); display: inline-block;"></span>
                                        Emerald
                                    </button>
                                    <button type="button" onclick="setPresetColor('#6366f1', '#4f46e5')" style="display: flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 6px; border: 1px solid var(--c-border); background: var(--c-bg-subtle); color: var(--c-text); cursor: pointer; font-size: 0.75rem;">
                                        <span style="width: 14px; height: 14px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #4f46e5); display: inline-block;"></span>
                                        Indigo
                                    </button>
                                    <button type="button" onclick="setPresetColor('#a855f7', '#7e22ce')" style="display: flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 6px; border: 1px solid var(--c-border); background: var(--c-bg-subtle); color: var(--c-text); cursor: pointer; font-size: 0.75rem;">
                                        <span style="width: 14px; height: 14px; border-radius: 50%; background: linear-gradient(135deg, #a855f7, #7e22ce); display: inline-block;"></span>
                                        Purple
                                    </button>
                                    <button type="button" onclick="setPresetColor('#ef4444', '#dc2626')" style="display: flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 6px; border: 1px solid var(--c-border); background: var(--c-bg-subtle); color: var(--c-text); cursor: pointer; font-size: 0.75rem;">
                                        <span style="width: 14px; height: 14px; border-radius: 50%; background: linear-gradient(135deg, #ef4444, #dc2626); display: inline-block;"></span>
                                        Crimson
                                    </button>
                                    <button type="button" onclick="setPresetColor('#06b6d4', '#0891b2')" style="display: flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 6px; border: 1px solid var(--c-border); background: var(--c-bg-subtle); color: var(--c-text); cursor: pointer; font-size: 0.75rem;">
                                        <span style="width: 14px; height: 14px; border-radius: 50%; background: linear-gradient(135deg, #06b6d4, #0891b2); display: inline-block;"></span>
                                        Cyan
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Site Logo Card -->
                <div class="card">
                    <div class="card-head">
                        <h3>Site Logo</h3>
                    </div>
                    <div class="card-body">
                        @if (!empty($settings['site_logo']))
                            <div style="margin-bottom: 16px; padding: 12px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border); text-align: center;">
                                <img src="{{ str_starts_with($settings['site_logo'], 'http') ? $settings['site_logo'] : asset($settings['site_logo']) }}" alt="Logo Preview" style="max-width: 100%; max-height: 60px; object-fit: contain;" />
                            </div>
                        @endif

                        <div class="image-upload-dropzone" onclick="document.getElementById('site_logo_input').click()" style="border: 2px dashed var(--c-border); border-radius: var(--radius-sm); padding: 20px; text-align: center; background: var(--c-bg-subtle); cursor: pointer; transition: all 0.2s ease;">
                            <div style="margin-bottom: 6px;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                            <div style="font-size: 13px; color: var(--c-text); font-weight: 500;">Upload Site Logo</div>
                            <div style="font-size: 11px; color: var(--c-text-muted); margin-top: 2px;">PNG, SVG, WEBP or JPG</div>
                            <input type="file" id="site_logo_input" name="site_logo" accept="image/*" style="display: none;" onchange="this.form.submit();" />
                        </div>
                    </div>
                </div>

                <!-- Site Favicon Card -->
                <div class="card">
                    <div class="card-head">
                        <h3>Browser Favicon</h3>
                    </div>
                    <div class="card-body">
                        @if (!empty($settings['site_favicon']))
                            <div style="margin-bottom: 16px; padding: 12px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border); text-align: center;">
                                <img src="{{ str_starts_with($settings['site_favicon'], 'http') ? $settings['site_favicon'] : asset($settings['site_favicon']) }}" alt="Favicon Preview" style="width: 32px; height: 32px; object-fit: contain;" />
                            </div>
                        @endif

                        <div class="image-upload-dropzone" onclick="document.getElementById('site_favicon_input').click()" style="border: 2px dashed var(--c-border); border-radius: var(--radius-sm); padding: 20px; text-align: center; background: var(--c-bg-subtle); cursor: pointer; transition: all 0.2s ease;">
                            <div style="margin-bottom: 6px;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            </div>
                            <div style="font-size: 13px; color: var(--c-text); font-weight: 500;">Upload Favicon</div>
                            <div style="font-size: 11px; color: var(--c-text-muted); margin-top: 2px;">ICO, PNG, or SVG (32x32)</div>
                            <input type="file" id="site_favicon_input" name="site_favicon" accept="image/x-icon,image/png,image/svg+xml" style="display: none;" onchange="this.form.submit();" />
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </form>

    <script>
        function setPresetColor(primary, accent, secondary = '#6366f1') {
            document.getElementById('primary_color').value = primary;
            document.getElementById('primary_color_picker').value = primary;
            document.getElementById('accent_color').value = accent;
            document.getElementById('accent_color_picker').value = accent;
            if (document.getElementById('secondary_color')) {
                document.getElementById('secondary_color').value = secondary;
                document.getElementById('secondary_color_picker').value = secondary;
            }
        }
    </script>

</x-admin-layout>
