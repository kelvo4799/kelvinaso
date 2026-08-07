<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <x-seo-component :page="$page" :settings="$settings ?? ['site_name' => 'Portfolio']" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Instrument+Serif:ital@0;1&display=swap" />

    <!-- Scripts -->
    @vite(['resources/css/style.css', 'resources/js/script.js'])


</head>

<body>
    <main class="container">
        <x-nav-component />
        {{ $slot }}
    </main>

    <footer class="footer">
        <div class="container">

            <div class="footer-cta-card">
        <h2>Are You Ready to kickstart your project with a touch of magic?</h2>
        <p>Reach out and let's make it happen ✨. I'm also available for full-time or freelance opportunities to push the
          boundaries of data and deliver exceptional work.</p>
        <a href="contact.html" class="btn-cta">
          Let's Talk
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <polyline points="19 12 12 19 5 12"></polyline>
          </svg>
        </a>
      </div>


            <div class="footer-bottom-text">
                <p>Copyright @2026, <span class="brand-highlight">Asonta Kelvin</span> All Rights Reserved.</p>
                <p>Crafted with ❤️ in Lisbon</p>
            </div>
        </div>
    </footer>
</body>




</html>
