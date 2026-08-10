<?php

namespace App\Services;


use App\Models\EmailSetting;
use Illuminate\Support\Facades\Cache;

class EmailSettingService
{
    /**
     * Fetch a template by slug and replace {{placeholders}} with real data.
     *
     * @param string $slug
     * @param array $data 
     * @return array{subject: string, body: string}
     */
    public function render(string $slug, array $data): array
    {

        $template = Cache::remember("email_template_{$slug}", 3600, function () use ($slug) {
            return EmailTemplate::where('slug', $slug)->firstOrFail();
        });

        $templateSetting = Cache::remember("email_template_{$slug}", 3600, function () use ($slug) {
            return EmailSetting::where('slug', $slug)->firstOrFail();
        });

        

        return [
            'subject' => $this->replace($template->subject, $data),
            'body'    => $this->replace($template->body_html, $data),
        ];
    }

    protected function replace(string $content, array $data): string
    {
        foreach ($data as $key => $value) {
            $content = str_replace('{{' . $key . '}}', e($value), $content);
        }

        return $content;
    }
}