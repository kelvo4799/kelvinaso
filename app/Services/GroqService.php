<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    protected ?string $apiKey;
    protected string $model;
    protected string $endpoint = 'https://api.groq.com/openai/v1/chat/completions';

    public function __construct()
    {
        // Check database settings first, fallback to config/env
        $dbKey = setting('groq_api_key');
        $this->apiKey = !empty($dbKey) ? $dbKey : config('services.groq.api_key');
        $this->model = config('services.groq.model', 'llama-3.3-70b-versatile');
    }

    /**
     * Check if Groq API Key is configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Generate content using Groq Cloud API SDK service (e.g. Llama 3.3 70B).
     */
    public function generateText(string $prompt, ?string $systemInstruction = null): ?string
    {
        if (!$this->isConfigured()) {
            return null;
        }

        $messages = [];

        if (!empty($systemInstruction)) {
            $messages[] = [
                'role' => 'system',
                'content' => $systemInstruction,
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $prompt,
        ];

        $payload = [
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => 0.7,
            'stream' => false,
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])
            ->withOptions([
                'curl' => [
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    CURLOPT_SSL_VERIFYPEER => true,
                ],
            ])
            ->retry(3, 200, function ($exception) {
                // Retry on cURL connection resets or network timeouts
                return true;
            }, throw: false)
            ->timeout(30)
            ->post($this->endpoint, $payload);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? null;
            }

            Log::error('Groq API Error Response: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Groq API Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate blog post content using Groq (Llama 3.3).
     */
    public function generateBlogContent(string $title, string $category = 'Tech'): ?string
    {
        $systemInstruction = "You are a senior software engineer and tech blog writer powered by Llama 3.3. Write engaging, clean technical blog articles in clear paragraphs without unnecessary markdown codeblocks.";
        $prompt = "Write an insightful, well-structured blog post titled '{$title}' in the category '{$category}'. Provide comprehensive explanations, practical examples, and engaging formatting.";

        return $this->generateText($prompt, $systemInstruction);
    }

    /**
     * Generate concise excerpt summary from blog content using Groq.
     */
    public function generateExcerpt(string $content): ?string
    {
        $systemInstruction = "You are an expert editor. Provide a concise 2-sentence summary excerpt suitable for portfolio cards.";
        $prompt = "Summarize the following article into a compelling 2-sentence excerpt:\n\n" . substr($content, 0, 3000);

        return $this->generateText($prompt, $systemInstruction);
    }

    /**
     * Generate project description using Groq.
     */
    public function generateProjectDescription(string $title, string $category = 'Web Development', string $tech = ''): ?string
    {
        $systemInstruction = "You are a senior software architect and technical copywriter.";
        $prompt = "Write a compelling portfolio description for a project named '{$title}' under category '{$category}' built with tech stack '{$tech}'. Keep it around 2-3 well-written paragraphs.";

        return $this->generateText($prompt, $systemInstruction);
    }

    /**
     * Generate professional admin bio summary using Groq.
     */
    public function generateBioSummary(string $name, string $headline = ''): ?string
    {
        $systemInstruction = "You are an executive biographer for software engineers.";
        $prompt = "Write a professional, impressive portfolio bio for '{$name}' whose headline is '{$headline}'. Highlight expertise in software engineering, system architecture, leadership, and problem-solving.";

        return $this->generateText($prompt, $systemInstruction);
    }
}
