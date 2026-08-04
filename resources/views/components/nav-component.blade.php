<header class="nav">
    <div class="nav-inner">
        <a href="/" class="brand">
            <span class="brand-dot"></span>
            <span class="brand-name">Asonta Kelvin</span>
        </a>
        <nav class="nav-links">
            <x-nav-links-component />
        </nav>
        <div class="nav-actions">
            <button class="theme-toggle" data-theme-toggle aria-label="Toggle Theme">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
            </button>
            <button class="nav-toggle" data-nav-toggle aria-label="Menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M3 6h18M3 12h18M3 18h18" />
                </svg>
            </button>
        </div>
    </div>
    <div class="container mobile-menu" id="mobile-menu">
        <x-nav-links-component />
    </div>
</header>
