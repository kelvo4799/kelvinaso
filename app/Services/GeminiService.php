<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected ?string $apiKey;
    protected string $model;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model = config('services.gemini.model', 'gemini-1.5-flash');
    }

    /**
     * Check if Gemini API Key is configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Generate content from prompt using Google Gemini API SDK service.
     */
    public function generateText(string $prompt, ?string $systemInstruction = null): ?string
    {
        if (!$this->isConfigured()) {
            return "Gemini API key is not configured. Please set GEMINI_API_KEY in your .env file.";
        }

        $endpoint = "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}";

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        if (!empty($systemInstruction)) {
            $payload['systemInstruction'] = [
                'parts' => [
                    ['text' => $systemInstruction]
                ]
            ];
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($endpoint, $payload);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            }

            Log::error('Gemini API Error Response: ' . $response->body());
            return 'Gemini API Error: ' . ($response->json('error.message') ?? 'HTTP ' . $response->status());
        } catch (\Exception $e) {
            Log::error('Gemini API Exception: ' . $e->getMessage());
            return 'Failed to connect to Gemini API: ' . $e->getMessage();
        }
    }

    /**
     * Generate full blog post article from title & category.
     */
    public function generateBlogContent(string $title, string $category = 'Tech'): ?string
    {
        $systemInstruction = "You are a professional software engineer and tech blog writer. Write engaging, clean, technical blog articles in clear paragraphs without unnecessary markdown codeblocks.";
        $prompt = "Write an insightful, well-structured blog post titled '{$title}' in the category '{$category}'. Provide comprehensive explanations, practical examples, and engaging formatting.";

        return $this->generateText($prompt, $systemInstruction);
    }

    /**
     * Generate concise excerpt summary from blog content.
     */
    public function generateExcerpt(string $content): ?string
    {
        $systemInstruction = "You are an expert editor. Provide a concise 2-sentence summary excerpt suitable for portfolio cards.";
        $prompt = "Summarize the following text into a compelling 2-sentence excerpt:\n\n" . substr($content, 0, 3000);

        return $this->generateText($prompt, $systemInstruction);
    }

    /**
     * Generate project summary / case study description.
     */
    public function generateProjectDescription(string $title, string $category = 'Web Development', string $tech = ''): ?string
    {
        $systemInstruction = "You are a senior portfolio copywriter. Write crisp, high-converting project descriptions highlighting technical challenges solved, architecture, and impact.";
        $prompt = "Write a compelling portfolio description for a project named '{$title}' under category '{$category}' built with tech stack '{$tech}'. Keep it around 2-3 well-written paragraphs.";

        return $this->generateText($prompt, $systemInstruction);
    }

    /**
     * Generate professional admin bio summary.
     */
    public function generateBioSummary(string $name, string $headline = ''): ?string
    {
        $systemInstruction = "You are an executive biographer for software engineers.";
        $prompt = "Write a professional, impressive portfolio bio for '{$name}' whose title/headline is '{$headline}'. Highlight expertise in software engineering, system architecture, leadership, and problem-solving.";

        return $this->generateText($prompt, $systemInstruction);
    }
}
