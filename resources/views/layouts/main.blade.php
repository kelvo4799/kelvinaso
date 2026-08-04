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
            <div class="footer-bottom-text">
                <p>Copyright @2026, <span class="brand-highlight">Asonta Kelvin</span> All Rights Reserved.</p>
                <p>Crafted with ❤️ in Lisbon</p>
            </div>
        </div>
    </footer>
</body>




</html>
