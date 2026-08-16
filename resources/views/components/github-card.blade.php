@php
    $enabled = \App\Models\Settings::where('key', 'enable_github_sync')->value('value') ?? '1';
    $username = \App\Models\Settings::where('key', 'github_username')->value('value') ?? 'kelvinaso';
    $gitHubService = app(\App\Services\GitHubService::class);
    $repos = $enabled === '1' ? $gitHubService->getUserRepositories($username) : [];
@endphp

@if ($enabled === '1' && !empty($repos))
    <section style="margin: 60px 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h2 style="font-size: 1.75rem; font-weight: 800; margin: 0; color: var(--fg);">Live GitHub Repositories</h2>
                <div style="color: var(--muted); font-size: 0.9rem; margin-top: 4px;">Real-time open source updates for @{{ $username }}</div>
            </div>
            <a href="https://github.com/{{ $username }}" target="_blank" style="color: var(--accent); font-weight: 600; text-decoration: none; font-size: 0.9rem;">
                View GitHub Profile &rarr;
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 18px;">
            @foreach ($repos as $repo)
                <div style="background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <a href="{{ $repo['html_url'] ?? '#' }}" target="_blank" style="font-weight: 700; color: var(--accent); text-decoration: none; font-size: 1rem;">
                                {{ $repo['name'] ?? 'Repository' }}
                            </a>
                            <span style="font-size: 0.75rem; color: var(--muted); display: flex; align-items: center; gap: 4px;">
                                ⭐ {{ $repo['stargazers_count'] ?? 0 }}
                            </span>
                        </div>
                        <p style="font-size: 0.825rem; color: var(--muted); line-height: 1.5; margin: 0 0 14px;">
                            {{ Str::limit($repo['description'] ?? 'Public open source repository.', 80) }}
                        </p>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: var(--muted);">
                        <span>● {{ $repo['language'] ?: 'Code' }}</span>
                        <span>Updated {{ \Carbon\Carbon::parse($repo['updated_at'] ?? now())->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
