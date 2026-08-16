<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script>
        (function() {
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
    @vite(['resources/js/theme.js', 'resources/css/style.css', 'resources/css/notify.css', 'resources/js/script.js'])

    @php
        $primaryColor   = setting('primary_color', '#f0563a');
        $accentColor    = setting('accent_color', '#db391c');
        $secondaryColor = setting('secondary_color', '#6366f1');

        $primaryRgb   = hex_to_rgb($primaryColor, '240, 86, 58');
        $accentRgb    = hex_to_rgb($accentColor, '219, 57, 28');
        $secondaryRgb = hex_to_rgb($secondaryColor, '99, 102, 241');
    @endphp
    @if ($primaryColor)
        <style>
            :root,
            [data-theme="dark"] {
                --accent: {{ $primaryColor }} !important;
                --accent-rgb: {{ $primaryRgb }} !important;

                --accent-2: {{ $accentColor }} !important;
                --accent-2-rgb: {{ $accentRgb }} !important;

                --secondary: {{ $secondaryColor }} !important;
                --secondary-rgb: {{ $secondaryRgb }} !important;

                --border-glow: rgba({{ $primaryRgb }}, 0.2) !important;
                --gradient: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $accentColor }} 100%) !important;
                --glow: 0 0 60px -15px rgba({{ $primaryRgb }}, 0.45) !important;
            }
        </style>
    @endif
</head>

<body>
    <main class="container">
        <x-nav-component />
        {{ $slot }}
    </main>

    <x-footer-component />

    <x-ai-chatbot />
</body>




</html>
