<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\EmailSetting;
use Illuminate\Support\Facades\Cache;

class EmailTemplateService
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

        $templateContent = Cache::remember("email_template_{$slug}", 3600, function () use ($slug) {
            $template = EmailTemplate::where('slug', $slug)->first();

            return [
                'subject' => $template->subject,
                'body'    => $template->body_html
            ];
        });

        $templateSetting = Cache::remember("email_template_setting", 3600, function (){
            $setting = EmailSetting::first();

            return [
                'header_html' => $setting->header_html ?? config('email_defaults.header'),
                'footer_html' => $setting->footer_html ?? config('email_defaults.footer'),
            ];
        });

        return [
            'header'  => $this->replace($templateSetting['header_html'], $data),
            'subject' => $this->replace($templateContent['subject'], $data),
            'body'    => $this->replace($templateContent['body'], $data),
            'footer'  => $this->replace($templateSetting['footer_html'], $data)
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