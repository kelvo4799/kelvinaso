<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script>
        (function () {
            try {
                const root = document.documentElement;
                const savedTheme = localStorage.getItem('theme');
                const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const theme = savedTheme || (systemDark ? 'dark' : 'light');

                if (theme === 'dark') {
                    root.setAttribute('data-theme', 'dark');
                } else {
                    root.removeAttribute('data-theme');
                }

                root.style.colorScheme = theme;
            } catch (e) {
                // Ignore storage access issues and keep the default theme.
            }
        })();
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Instrument+Serif:ital@0;1&display=swap" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/admin.css', 'resources/css/notify.css', 'resources/js/theme.js', 'resources/js/admin.js', 'resources/js/notify.js'])

    @php
        $primaryColor = \App\Models\Settings::where('key', 'primary_color')->value('value') ?? '#f0563a';
        $accentColor = \App\Models\Settings::where('key', 'accent_color')->value('value') ?? '#db391c';
    @endphp
    @if ($primaryColor)
        <style>
            :root, [data-theme="dark"] {
                --accent: {{ $primaryColor }} !important;
                --accent-2: {{ $accentColor }} !important;
                --c-accent: {{ $primaryColor }} !important;
                --border-glow: {{ $primaryColor }}33 !important;
                --gradient: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $accentColor }} 100%) !important;
                --glow: 0 0 60px -15px {{ $primaryColor }}40 !important;
            }
        </style>
    @endif
</head>

<body>

 
 
<div class="app">

  <x-admin-side-bar-component />

  <div class="main">
    <!-- Topbar -->
    <x-admin-top-bar-component :fname="$profile->first_name" :lname="$profile->last_name" :email="$profile->direct_email"/>

    <!-- Content -->
    <main class="content animate-fade-in">

      {{ $slot }}
      
    </main>
  </div>
</div>
       
</body>

<x-notify-component />

</html>

<!-- Project Modal -->
<div class="modal-backdrop" id="projectModal">
  <div class="modal" role="dialog" aria-modal="true">
    <div class="modal-header">
      <h2>Create New Project</h2>
      <button class="modal-close" aria-label="Close" data-modal-close>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
      </button>
    </div>
    <form id="projectForm" action="{{ route('projects.store.admin') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-grid">
          <div class="field">
            <label for="p_name">Project Title</label>
            <input type="text" id="p_name" name="title" class="input" placeholder="e.g. Revenue Analytics Dashboard" required>
          </div>
          <div class="form-grid cols-2">
            <div class="field">
              <label for="p_category">Category</label>
              <select id="p_category" name="category" class="input">
                <option value="web">Web Development</option>
                <option value="mobile">Mobile App</option>
                <option value="desktop">Desktop App</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="field">
              <label for="p_year">Year</label>
              <input type="number" id="p_year" name="year" class="input" value="{{ date('Y') }}" required>
            </div>
          </div>
          <div class="field">
            <label for="p_tech">Tech Stack (comma separated)</label>
            <input type="text" id="p_tech" name="tech" class="input" placeholder="Laravel, Vue, Tailwind CSS">
          </div>
          <div class="field">
            <label for="p_desc">Short Description</label>
            <textarea id="p_desc" name="description" class="textarea" placeholder="Brief summary of the project..."></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn secondary" data-modal-close>Cancel</button>
        <button type="submit" class="btn primary-colored">Create Project</button>
      </div>
    </form>
  </div>
</div>

<!-- Command Palette Modal -->
<div class="modal-backdrop" id="cmdModal">
  <div class="modal command-palette" role="dialog" aria-modal="true">
    <div class="modal-body">
      <div style="display: flex; align-items: center; position: relative;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position: absolute; left: 24px; color: var(--c-text-muted);"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <input type="text" class="cmd-input" id="cmdInput" placeholder="What do you want to do?" autocomplete="off" style="padding-left: 56px;">
      </div>
      <div class="cmd-list" id="cmdList">
        <div class="section-label" style="margin: 12px 0 8px 8px;">Actions</div>
        <div class="cmd-item" data-action="modal:projectModal">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
          Create New Project
        </div>
        <div class="cmd-item" data-action="slideover:messages">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          View Messages
        </div>
        <div class="section-label" style="margin: 20px 0 8px 8px;">Navigation</div>
        <div class="cmd-item" data-action="link:analytics.html">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>
          Analytics Dashboard
        </div>
        <div class="cmd-item" data-action="link:settings.html">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.5"/></svg>
          Settings
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Messages Slide-over -->
<div class="modal-backdrop" id="messagesSlideover">
  <div class="slide-over" role="dialog" aria-modal="true">
    <div class="modal-header">
      <h2>Messages</h2>
      <div style="display: flex; gap: 12px; align-items: center;">
        <button class="btn primary-colored sm" data-modal="mailModal">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
          Compose
        </button>
        <button class="modal-close" aria-label="Close" data-modal-close>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
      </div>
    </div>
    <div class="slide-content">
      <div class="message-item">
        <div class="flex gap-12" style="margin-bottom: 8px;">
          <div class="avatar sm">JD</div>
          <div>
            <div style="font-weight:600; color: #fff;">Jane Doe</div>
            <div class="muted" style="font-size:12px">2 hours ago</div>
          </div>
        </div>
        <div style="font-size: 14px; color: var(--c-text-muted); line-height: 1.6;">
          "Loved your latest case study on the SaaS dashboard. Would you be open to discussing a freelance opportunity with our team?"
        </div>
        <div style="margin-top: 12px; display: flex; gap: 8px;">
          <button class="btn secondary sm" onclick="flash('Reply opened (mock)', 'info')">Reply</button>
          <button class="btn ghost sm" onclick="flash('Message archived (mock)')">Archive</button>
        </div>
      </div>
      
      <div class="message-item">
        <div class="flex gap-12" style="margin-bottom: 8px;">
          <div class="avatar sm" style="background:linear-gradient(135deg,#d97706,#dc2626)">MR</div>
          <div>
            <div style="font-weight:600; color: #fff;">Marc R.</div>
            <div class="muted" style="font-size:12px">Yesterday</div>
          </div>
        </div>
        <div style="font-size: 14px; color: var(--c-text-muted); line-height: 1.6;">
          "Hi Alex! We have a contract role for a Lead Frontend Engineer that might interest you. Let me know if you have time for a quick chat."
        </div>
        <div style="margin-top: 12px; display: flex; gap: 8px;">
          <button class="btn secondary sm" onclick="flash('Reply opened (mock)', 'info')">Reply</button>
          <button class="btn ghost sm" onclick="flash('Message archived (mock)')">Archive</button>
        </div>
      </div>

      <div class="message-item">
        <div class="flex gap-12" style="margin-bottom: 8px;">
          <div class="avatar sm" style="background:linear-gradient(135deg,#0d9488,#16a34a)">SV</div>
          <div>
            <div style="font-weight:600; color: #fff;">Sara V.</div>
            <div class="muted" style="font-size:12px">3 days ago</div>
          </div>
        </div>
        <div style="font-size: 14px; color: var(--c-text-muted); line-height: 1.6;">
          "Quick question about your design system: did you build the components from scratch or did you use a base library like Radix?"
        </div>
        <div style="margin-top: 12px; display: flex; gap: 8px;">
          <button class="btn secondary sm" onclick="flash('Reply opened (mock)', 'info')">Reply</button>
          <button class="btn ghost sm" onclick="flash('Message archived (mock)')">Archive</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Send Mail Modal -->
<div class="modal-backdrop" id="mailModal">
  <div class="modal" role="dialog" aria-modal="true" style="max-width: 700px;">
    <div class="modal-header">
      <h2>Compose Message</h2>
      <button class="modal-close" aria-label="Close" data-modal-close>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
      </button>
    </div>
    <form id="mailForm" data-mock-save="Message sent successfully!">
      <div class="modal-body">
        <div class="form-grid">
          <div class="field">
            <label for="m_to">To</label>
            <input type="text" id="m_to" class="input" placeholder="recipient@example.com" required>
          </div>
          <div class="field">
            <label for="m_subject">Subject</label>
            <input type="text" id="m_subject" class="input" placeholder="Enter subject..." required>
          </div>
          <div class="field">
            <label>Message</label>
            <div id="quillEditor" style="height: 240px; background: rgba(0,0,0,0.2); border-radius: 0 0 var(--radius-sm) var(--radius-sm);"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn secondary" data-modal-close>Cancel</button>
        <button type="submit" class="btn primary-colored">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
          Send Message
        </button>
      </div>
    </form>
  </div>
</div>