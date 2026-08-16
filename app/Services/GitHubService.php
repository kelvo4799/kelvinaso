<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GitHubService
{
    public function getUserRepositories(string $username): array
    {
        return Cache::remember('github_repos_' . $username, 3600, function () use ($username) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Keviloq-Portfolio-App',
                ])->timeout(10)->get("https://api.github.com/users/{$username}/repos?sort=updated&per_page=6");

                if ($response->successful()) {
                    return $response->json();
                }
                return [];
            } catch (\Exception $e) {
                return [];
            }
        });
    }
}
