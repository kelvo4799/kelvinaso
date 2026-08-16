<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GroqService;
use Illuminate\Http\Request;

class AdminAiController extends Controller
{
    public function __construct(
        protected GroqService $groqService
    ) {}

    public function generateBlog(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        $content = $this->groqService->generateBlogContent(
            $validated['title'],
            $validated['category'] ?? 'Tech'
        );

        return response()->json([
            'success' => true,
            'content' => $content,
        ]);
    }

    public function generateExcerpt(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $excerpt = $this->groqService->generateExcerpt($validated['content']);

        return response()->json([
            'success' => true,
            'excerpt' => $excerpt,
        ]);
    }

    public function generateProject(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'tech' => 'nullable|string|max:255',
        ]);

        $description = $this->groqService->generateProjectDescription(
            $validated['title'],
            $validated['category'] ?? 'Web Development',
            $validated['tech'] ?? ''
        );

        return response()->json([
            'success' => true,
            'description' => $description,
        ]);
    }

    public function generateBio(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio_title' => 'nullable|string|max:255',
        ]);

        $bio = $this->groqService->generateBioSummary(
            $validated['name'],
            $validated['bio_title'] ?? ''
        );

        return response()->json([
            'success' => true,
            'bio' => $bio,
        ]);
    }
}
