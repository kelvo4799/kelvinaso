@php
  $enableBlog = \App\Models\Settings::where('key', 'enable_blog')->value('value') ?? '1';
  $enableExperiences = \App\Models\Settings::where('key', 'enable_experiences')->value('value') ?? '1';
  $enableSnippets = \App\Models\Settings::where('key', 'enable_snippets')->value('value') ?? '1';
  $enableAiChatbot = \App\Models\Settings::where('key', 'enable_ai_chatbot')->value('value') ?? '1';
  $unreadMessagesCount = \App\Models\Contact::where('status', 'unread')->count();
@endphp

<!-- Sidebar -->
  <aside class="sidebar">
    <div class="brand"><span class="dot"></span> Portfolio Admin</div>
    <div class="section-label">General</div>
    <nav>
      <a href="{{ route('dashboard.admin') }}" class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12l9-9 9 9"/><path d="M5 10v10h14V10"/></svg>
        Dashboard
      </a>
      <a href="{{ route('analytics.admin') }}" class="{{ request()->routeIs('analytics.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        Analytics
      </a>
      <a href="{{ route('pages.admin') }}" class="{{ request()->routeIs('pages.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        Pages
      </a>
      <a href="{{ route('projects.admin') }}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18"/></svg>
        Projects
      </a>

      @if ($enableBlog === '1')
      <a href="{{ route('blog.admin') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        Blog
      </a>
      @endif

      <a href="{{ route('messages.admin') }}" class="{{ request()->routeIs('messages.*') ? 'active' : '' }}" style="display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:10px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          Messages
        </div>
        @if ($unreadMessagesCount > 0)
          <span style="background:var(--accent);color:#fff;font-size:0.75rem;font-weight:700;padding:2px 8px;border-radius:10px;line-height:1;">{{ $unreadMessagesCount }}</span>
        @endif
      </a>
      <a href="{{ route('emails.admin') }}" class="{{ request()->routeIs('emails.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        Email Templates
      </a>

      @if ($enableExperiences === '1')
      <a href="{{ route('experiences.admin') }}" class="{{ request()->routeIs('experiences.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        Work Experience
      </a>
      @endif

      <a href="{{ route('stacks.admin') }}" class="{{ request()->routeIs('stacks.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
        Tech Stacks
      </a>

      @if ($enableSnippets === '1')
      <a href="{{ route('snippets.admin') }}" class="{{ request()->routeIs('snippets.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
        Code Snippets
      </a>
      @endif

      @if ($enableAiChatbot === '1')
      <a href="{{ route('ai-leads.admin') }}" class="{{ request()->routeIs('ai-leads.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        AI Sales Leads
      </a>
      @endif

      <a href="{{ route('affiliates.admin') }}" class="{{ request()->routeIs('affiliates.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
        Affiliates & Referrals
      </a>
    </nav>
    <div class="section-label">Account</div>
    <nav>
      <a href="{{ route('profile.admin') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
        Profile
      </a>
      <a href="{{ route('settings.admin') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
        Settings
      </a>
      <a href="/" target="_blank">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        View Site
      </a>
    </nav>
  </aside>