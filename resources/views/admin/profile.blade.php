<x-admin-layout :page="$page" :profile="$profile" :settings="$settings ?? ['site_name' => 'Portfolio']">

    <div class="page-header">
        <div>
            <h1>Admin Profile & Account Settings</h1>
            <div class="sub">Manage your personal bio, portfolio details, social links, avatar, and account security.
            </div>
        </div>
    </div>

    @if (session('success'))
        <div
            style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div
            style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; font-weight: 500; font-size: 0.9rem;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">

        <!-- Left Column: Bio & Social Info Form -->
        <form action="{{ route('profile.update.admin') }}" method="POST" enctype="multipart/form-data"
            style="display: flex; flex-direction: column; gap: 24px;">
            @csrf
            @method('PATCH')

            <!-- Account & Personal Info Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Personal & Portfolio Details</h3>
                </div>
                <div class="card-body">
                    <div class="form-grid">

                        <div class="form-grid cols-2">
                            <div class="field">
                                <label for="first_name">First Name</label>
                                <input class="input" id="first_name" name="first_name"
                                    value="{{ old('first_name', $profile->first_name) }}" placeholder="e.g. John" />
                            </div>
                            <div class="field">
                                <label for="last_name">Last Name</label>
                                <input class="input" id="last_name" name="last_name"
                                    value="{{ old('last_name', $profile->last_name) }}" placeholder="e.g. Doe" />
                            </div>
                        </div>

                        <div class="form-grid cols-2">
                            <div class="field">
                                <label for="name">Account Name <span class="muted" style="font-weight:400">(Display
                                        Name)</span></label>
                                <input class="input" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" required />
                            </div>
                            <div class="field">
                                <label for="email">Account Email <span class="muted" style="font-weight:400">(Login
                                        Email)</span></label>
                                <input class="input" type="email" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" required />
                            </div>
                        </div>

                        <div class="field">
                            <label for="bio_title">Professional Headline / Title</label>
                            <input class="input" id="bio_title" name="bio_title"
                                value="{{ old('bio_title', $profile->bio_title) }}"
                                placeholder="e.g. Full-Stack Engineer & Software Architect" />
                        </div>

                        <div class="field">
                            <label for="bio_header">Bio Tagline / Header</label>
                            <input class="input" id="bio_header" name="bio_header"
                                value="{{ old('bio_header', $profile->bio_header) }}"
                                placeholder="e.g. Crafting High-Performance Web Systems & Mobile Applications" />
                        </div>

                        <div class="field">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                <label for="bio" style="margin:0;">Summary Bio</label>
                                <button type="button" class="btn primary-colored sm" id="btnAiBio"
                                    onclick="generateAiBio()" style="font-size: 0.75rem; padding: 2px 10px;">
                                    ✨ Auto-Generate Bio with AI
                                </button>
                            </div>
                            <textarea class="textarea" id="bio" name="bio" rows="4"
                                placeholder="Brief about me bio summary for portfolio profile cards...">{{ old('bio', $profile->bio) }}</textarea>
                        </div>

                        <div class="form-grid cols-3">
                            <div class="field">
                                <label for="location">Location</label>
                                <input class="input" id="location" name="location"
                                    value="{{ old('location', $profile->location) }}"
                                    placeholder="e.g. Lagos, Nigeria / Remote" />
                            </div>
                            <div class="field">
                                <label for="direct_email">Public Direct Email</label>
                                <input class="input" type="email" id="direct_email" name="direct_email"
                                    value="{{ old('direct_email', $profile->direct_email) }}"
                                    placeholder="contact@domain.com" />
                            </div>
                            <div class="field">
                                <label for="direct_phone">Public Direct Phone</label>
                                <input class="input" id="direct_phone" name="direct_phone"
                                    value="{{ old('direct_phone', $profile->direct_phone) }}"
                                    placeholder="+234 800 000 0000" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Social Links Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Social Media Links</h3>
                </div>
                <div class="card-body">
                    <div class="form-grid cols-2">
                        <div class="field">
                            <label for="github">GitHub Profile URL</label>
                            <input class="input" id="github" name="github"
                                value="{{ old('github', $socialLinks['github'] ?? '') }}"
                                placeholder="https://github.com/username" />
                        </div>

                        <div class="field">
                            <label for="linkedin">LinkedIn Profile URL</label>
                            <input class="input" id="linkedin" name="linkedin"
                                value="{{ old('linkedin', $socialLinks['linkedin'] ?? '') }}"
                                placeholder="https://linkedin.com/in/username" />
                        </div>

                        <div class="field">
                            <label for="twitter">Twitter / X Profile URL</label>
                            <input class="input" id="twitter" name="twitter"
                                value="{{ old('twitter', $socialLinks['twitter'] ?? '') }}"
                                placeholder="https://x.com/username" />
                        </div>

                        <div class="field">
                            <label for="instagram">Instagram Profile URL</label>
                            <input class="input" id="instagram" name="instagram"
                                value="{{ old('instagram', $socialLinks['instagram'] ?? '') }}"
                                placeholder="https://instagram.com/username" />
                        </div>
                    </div>
                </div>
                <div class="card-head"
                    style="border-top: 1px solid var(--c-border); border-bottom: none; padding: 20px 28px;">
                    <button type="submit" class="btn primary-colored">Save Profile Changes</button>
                </div>
            </div>

        </form>

        <!-- Right Column: Avatar & Password Update -->
        <div style="display: flex; flex-direction: column; gap: 24px;">

            <!-- Avatar Upload Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Profile Avatar</h3>
                </div>
                <div class="card-body" style="text-align: center;">
                    <div style="margin-bottom: 16px; display: inline-block; position: relative;">
                        @if ($profile->avatar)
                            <img id="avatarPreview"
                                src="{{ str_starts_with($profile->avatar, 'http') ? $profile->avatar : asset($profile->avatar) }}"
                                alt="Avatar"
                                style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--accent);" />
                        @else
                            <div id="avatarPreviewPlaceholder"
                                style="width: 100px; height: 100px; border-radius: 50%; background: var(--accent); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; margin: 0 auto; border: 3px solid var(--c-border);">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('profile.update.admin') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="name" value="{{ $user->name }}" />
                        <input type="hidden" name="email" value="{{ $user->email }}" />

                        <div class="image-upload-dropzone"
                            onclick="document.getElementById('avatar_file_input').click()"
                            style="border: 2px dashed var(--c-border); border-radius: var(--radius-sm); padding: 18px; text-align: center; background: var(--c-bg-subtle); cursor: pointer; transition: all 0.2s ease;">
                            <div style="font-size: 13px; color: var(--c-text); font-weight: 500;">Click to upload
                                avatar</div>
                            <div style="font-size: 11px; color: var(--c-text-muted); margin-top: 2px;">PNG, JPG, WEBP
                                or SVG</div>
                            <input type="file" id="avatar_file_input" name="avatar" accept="image/*"
                                style="display: none;" onchange="previewAvatar(this); this.form.submit();" />
                        </div>
                    </form>
                </div>
            </div>

            <!-- Curriculum Vitae (CV) Upload Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Curriculum Vitae (CV / Resume)</h3>
                </div>
                <div class="card-body">
                    @if ($profile->cv)
                        <div
                            style="margin-bottom: 14px; padding: 12px 14px; border-radius: var(--radius-sm); background: var(--c-bg-subtle); border: 1px solid var(--c-border); display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--accent)" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                                <span style="font-size: 0.85rem; font-weight: 600; color: var(--c-text);">CV
                                    Uploaded</span>
                            </div>
                            <a href="{{ str_starts_with($profile->cv, 'http') ? $profile->cv : asset($profile->cv) }}"
                                target="_blank" class="btn secondary sm" style="font-size: 0.75rem;">
                                Download / View
                            </a>
                        </div>
                    @endif

                    <form action="{{ route('profile.update.admin') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="name" value="{{ $user->name }}" />
                        <input type="hidden" name="email" value="{{ $user->email }}" />

                        <div class="image-upload-dropzone" onclick="document.getElementById('cv_file_input').click()"
                            style="border: 2px dashed var(--c-border); border-radius: var(--radius-sm); padding: 18px; text-align: center; background: var(--c-bg-subtle); cursor: pointer; transition: all 0.2s ease;">
                            <div style="margin-bottom: 6px;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--c-text-muted)" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                            </div>
                            <div style="font-size: 13px; color: var(--c-text); font-weight: 500;">Click to upload CV /
                                Resume</div>
                            <div style="font-size: 11px; color: var(--c-text-muted); margin-top: 2px;">PDF, DOC, or
                                DOCX (Max 20MB)</div>
                            <input type="file" id="cv_file_input" name="cv" accept=".pdf,.doc,.docx"
                                style="display: none;" onchange="this.form.submit();" />
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Update Card -->
            <div class="card">
                <div class="card-head">
                    <h3>Update Password</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password.admin') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <div class="field">
                                <label for="current_password">Current Password</label>
                                <input class="input" type="password" id="current_password" name="current_password"
                                    required />
                            </div>

                            <div class="field">
                                <label for="password">New Password</label>
                                <input class="input" type="password" id="password" name="password" required />
                            </div>

                            <div class="field">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input class="input" type="password" id="password_confirmation"
                                    name="password_confirmation" required />
                            </div>
                        </div>

                        <button type="submit" class="btn primary-colored"
                            style="margin-top: 16px; width: 100%; justify-content: center;">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>

    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const avatar = document.getElementById('avatarPreview');
                    if (avatar) avatar.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        async function generateAiBio() {
            const nameInput = document.getElementById('name');
            const headlineInput = document.getElementById('bio_title');
            const btn = document.getElementById('btnAiBio');

            const name = nameInput ? nameInput.value.trim() : '';
            const bio_title = headlineInput ? headlineInput.value.trim() : '';

            if (!name) {
                alert('Please enter your Account Name first.');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '✨ Generating with Groq AI...';

            try {
                const response = await fetch('{{ route('ai.generate-bio.admin') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name,
                        bio_title
                    })
                });

                const data = await response.json();
                if (data.success && data.bio) {
                    document.getElementById('bio').value = data.bio;
                } else {
                    alert(data.bio || 'Failed to generate bio.');
                }
            } catch (err) {
                alert('AI Generation request failed. Please check your GROQ_API_KEY in .env.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '✨ Auto-Generate Bio with AI';
            }
        }
    </script>

</x-admin-layout>
