<?php

namespace App\Services;

use App\Models\Settings;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    protected const CACHE_KEY = 'app_settings';

    /**
     * Default values if a key does not exist in DB yet.
     */
    protected array $defaults = [
        'site_name'           => 'Keviloq Systems',
        'site_tagline'        => 'Building Scalable Web & Mobile Solutions',
        'site_description'    => 'Scalable web applications, enterprise software, and cloud architecture.',
        'site_keywords'       => 'Laravel, PHP, Web Development, Software Engineering',
        'contact_email'       => 'contact@keviloq.com',
        'footer_copyright'       => '© Keviloq Systems. All rights reserved.',
        'footer_cta_title'      => 'Are You Ready to kickstart your project with a touch of magic?',
        'footer_cta_description' => "Reach out and let's make it happen ✨. I'm also available for full-time or freelance opportunities to push the boundaries of data and deliver exceptional work.",
        'footer_cta_button_text' => "Let's Talk",
        'footer_cta_button_url'  => '/contact',
        'primary_color'       => '#f0563a',
        'accent_color'        => '#db391c',
        'secondary_color'     => '#6366f1',
        'site_logo'           => '',
        'site_favicon'        => '',
        'groq_api_key'        => '',
        'gemini_api_key'      => '',
        'grok_api_key'        => '',
        'google_analytics_id' => '',
        'custom_head_scripts' => '',
        'enable_experiences'  => '1',
        'enable_snippets'     => '1',
        'enable_scheduler'    => '1',
        'enable_blog'         => '1',
        'enable_ai_chatbot'   => '1',
        'enable_github_sync'  => '1',
        'calendly_url'        => 'https://calendly.com',
        'github_username'     => 'kelvinaso',
    ];

    /**
     * Fetch all settings (cached forever until updated).
     */
    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $dbSettings = Settings::pluck('value', 'key')->all();
            return array_merge($this->defaults, $dbSettings);
        });
    }

    /**
     * Get a specific setting value with an optional default override.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();

        return $settings[$key] ?? $default ?? ($this->defaults[$key] ?? null);
    }

    /**
     * Clear settings cache when updated from Admin.
     */
    public function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
