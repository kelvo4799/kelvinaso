<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GrokService
{
    protected ?string $apiKey;
    protected string $model;
    protected string $endpoint = 'https://api.x.ai/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.grok.api_key');
        $this->model = config('services.grok.model', 'grok-2-latest');
    }

    /**
     * Check if Grok API Key is configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Generate content using xAI Grok API SDK service.
     */
    public function generateText(string $prompt, ?string $systemInstruction = null): ?string
    {
        if (!$this->isConfigured()) {
            return "Grok API key is not configured. Please set GROK_API_KEY in your .env file.";
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
            ])->timeout(30)->post($this->endpoint, $payload);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? null;
            }

            Log::error('Grok API Error Response: ' . $response->body());
            return 'Grok API Error: ' . ($response->json('error.message') ?? 'HTTP ' . $response->status());
        } catch (\Exception $e) {
            Log::error('Grok API Exception: ' . $e->getMessage());
            return 'Failed to connect to Grok API: ' . $e->getMessage();
        }
    }

    /**
     * Generate full blog post article from title & category using Grok.
     */
    public function generateBlogContent(string $title, string $category = 'Tech'): ?string
    {
        $systemInstruction = "You are Grok, an ultra-intelligent, witty, and highly articulate tech blog writer. Write engaging, high-quality technical blog articles in clear paragraphs without unnecessary markdown codeblocks.";
        $prompt = "Write an insightful, well-structured blog post titled '{$title}' in the category '{$category}'. Provide comprehensive explanations, practical examples, and engaging formatting.";

        return $this->generateText($prompt, $systemInstruction);
    }

    /**
     * Generate concise excerpt summary from blog content using Grok.
     */
    public function generateExcerpt(string $content): ?string
    {
        $systemInstruction = "You are an expert editor. Provide a concise 2-sentence summary excerpt suitable for portfolio cards.";
        $prompt = "Summarize the following article into a compelling 2-sentence excerpt:\n\n" . substr($content, 0, 3000);

        return $this->generateText($prompt, $systemInstruction);
    }

    /**
     * Generate project description using Grok.
     */
    public function generateProjectDescription(string $title, string $category = 'Web Development', string $tech = ''): ?string
    {
        $systemInstruction = "You are Grok, a master software architect and technical copywriter.";
        $prompt = "Write a compelling portfolio description for a project named '{$title}' under category '{$category}' built with tech stack '{$tech}'. Keep it around 2-3 well-written paragraphs.";

        return $this->generateText($prompt, $systemInstruction);
    }

    /**
     * Generate professional admin bio summary using Grok.
     */
    public function generateBioSummary(string $name, string $headline = ''): ?string
    {
        $systemInstruction = "You are Grok, writing a executive portfolio bio for a top software engineer.";
        $prompt = "Write a professional, impressive portfolio bio for '{$name}' whose headline is '{$headline}'. Highlight expertise in software engineering, system architecture, leadership, and problem-solving.";

        return $this->generateText($prompt, $systemInstruction);
    }
}
