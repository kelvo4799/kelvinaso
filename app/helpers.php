<?php

use App\Services\SettingService;

if (!function_exists('setting')) {
    /**
     * Get a setting value, or all settings if no key is passed.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function setting(?string $key = null, mixed $default = null): mixed
    {
        /** @var SettingService $service */
        $service = app(SettingService::class);

        if (is_null($key)) {
            return $service->all();
        }

        return $service->get($key, $default);
    }
}

if (!function_exists('hex_to_rgb')) {
    /**
     * Convert HEX color string to comma-separated RGB values string (e.g., "240, 86, 58").
     *
     * @param string|null $hex
     * @param string $default
     * @return string
     */
    function hex_to_rgb(?string $hex, string $default = '240, 86, 58'): string
    {
        if (!$hex) {
            return $default;
        }

        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } elseif (strlen($hex) === 6) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        } else {
            return $default;
        }

        return "{$r}, {$g}, {$b}";
    }
}
