<?php

// app/Services/MailerService.php
namespace App\Services;

use App\Mail\GenericMail;
use Illuminate\Support\Facades\Mail;

class MailerService
{
    public function __construct(
        protected EmailTemplateService $templateService
    ) {}

    /**
     * Render a template by slug and send it to any recipient.
     *
     * @param string $to
     * @param string $slug
     * @param array $data
     * @param string|null $replyToEmail
     * @param string|null $replyToName
     */
    public function send(
        string $to,
        string $slug,
        array $data,
        ?string $replyToEmail = null,
        ?string $replyToName = null
    ): bool {
        $rendered = $this->templateService->render($slug, $data);

        $fullBody = $this->wrapLayout($rendered);

        try {
            Mail::to($to)->send(new GenericMail(
                $rendered['subject'],
                $fullBody,
                $replyToEmail,
                $replyToName
            ));

            return true;
        } catch (\Exception $e) {
            logger()->error("MailerService failed sending '{$slug}' to {$to}: " . $e->getMessage());
            return false;
        }
    }

    protected function wrapLayout(array $rendered): string
    {
        return <<<HTML
            {$rendered['header']}
            {$rendered['body']}
            {$rendered['footer']}             
        HTML;
    }
}