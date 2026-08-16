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

    <x-seo-component :page="$page" :settings="$settings ?? ['site_name' => 'Portfolio']" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Instrument+Serif:ital@0;1&display=swap" />

    <!-- Scripts -->
    @vite(['resources/css/style.css', 'resources/css/notify.css', 'resources/js/theme.js'])


</head>

<body>
  <div class="bg-glow"></div>
  <div class="bg-glow-2"></div>
  <div class="auth-wrapper">
    <header class="nav">
      <div class="nav-inner">
        <a href="index.html" class="brand">
          <span class="brand-dot"></span>
          <span class="brand-name">Asonta Kelvin</span>
        </a>
        <div class="nav-actions">
          <button class="theme-toggle" data-theme-toggle aria-label="Toggle Theme">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
          </button>
          <a href="index.html" class="btn" style="padding: 0.5rem 1rem;">Back to Home</a>
        </div>
      </div>
    </header>

    

    <main class="auth-main animate-up">

        {{ $slot }}
    
    </main>
</body>




</html>
