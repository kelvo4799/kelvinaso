<header class="topbar">
      <div class="left">
        <button class="menu-btn" aria-label="Menu">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <h2>Dashboard</h2>
      </div>
      <div class="right" style="position: relative;">
        <div class="search" id="searchTrigger">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
          <input placeholder="Search projects, pages, users..." readonly style="cursor: pointer;" />
          <span class="search-shortcut">⌘K</span>
        </div>
        <div class="user-chip" id="userDropdownTrigger">
          @php
            $initials = strtoupper(substr(trim($fname ?? ''), 0, 1) . substr(trim($lname ?? ''), 0, 1));
            if (empty($initials)) {
                $initials = 'AD';
            }
          @endphp
          <div class="avatar">{{ $initials }}</div>
          <div style="font-size:13px;font-weight:500">{{ ucwords($fname ?: 'Admin') }}</div>
          
          <!-- Dropdown Menu -->
          <div class="dropdown-menu" id="userDropdown">
            <div style="padding: 8px 12px; margin-bottom: 4px;">
              <div style="font-weight: 600; font-size: 14px;">{{ ucwords(trim(($fname ?? '') . ' ' . ($lname ?? ''))) ?: 'Admin User' }}</div>
              <div class="muted" style="font-size: 12px;">{{ $email }}</div>
            </div>
            <div class="dropdown-divider"></div>
            <a href="{{ route('profile.admin') }}" class="dropdown-item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              My Profile
            </a>
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}" id="adminLogoutForm" style="display:none;">
              @csrf
            </form>
            <div class="dropdown-item danger" style="cursor:pointer;" onclick="document.getElementById('adminLogoutForm').submit();">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
              Log out
            </div>
          </div>
        </div>
      </div>
    </header>