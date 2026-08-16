<x-admin-layout :page="$page" :profile="$profile" :settings="$settings ?? ['site_name' => 'Portfolio']">

    <div class="page-header">
        <div>
            <h1>Blog Posts</h1>
            <div class="sub">Write, publish, and manage blog articles for your portfolio site.</div>
        </div>
        <a href="{{ route('blog.create.admin') }}" class="btn primary-colored sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Create New Article
        </a>
    </div>

    @if (session('success'))
    <div style="margin-bottom: 24px; padding: 14px 18px; border-radius: var(--radius-sm); background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Metric Stat Cards -->
    <div class="metrics-grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 20px;">
            <div class="muted" style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Total Articles</div>
            <div style="font-size: 1.8rem; font-weight: 700; color: var(--c-text);">{{ $stats['countAll'] }}</div>
        </div>
        <div class="card" style="padding: 20px;">
            <div class="muted" style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Published</div>
            <div style="font-size: 1.8rem; font-weight: 700; color: #10b981;">{{ $stats['countPublished'] }}</div>
        </div>
        <div class="card" style="padding: 20px;">
            <div class="muted" style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Drafts</div>
            <div style="font-size: 1.8rem; font-weight: 700; color: #f59e0b;">{{ $stats['countDraft'] }}</div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="card" style="margin-bottom: 24px; padding: 16px 20px;">
        <form method="GET" action="{{ route('blog.admin') }}" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: center; justify-content: space-between;">
            
            <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                <a href="{{ route('blog.admin', array_filter(['search' => request('search')])) }}" class="btn sm {{ !request('status') ? 'primary-colored' : 'secondary' }}">
                    All ({{ $stats['countAll'] }})
                </a>
                <a href="{{ route('blog.admin', array_filter(['status' => 'published', 'search' => request('search')])) }}" class="btn sm {{ request('status') === 'published' ? 'primary-colored' : 'secondary' }}">
                    Published ({{ $stats['countPublished'] }})
                </a>
                <a href="{{ route('blog.admin', array_filter(['status' => 'draft', 'search' => request('search')])) }}" class="btn sm {{ request('status') === 'draft' ? 'primary-colored' : 'secondary' }}">
                    Drafts ({{ $stats['countDraft'] }})
                </a>
            </div>

            <div style="display: flex; gap: 8px; flex: 1; max-width: 360px;">
                <input class="input" type="text" name="search" value="{{ request('search') }}" placeholder="Search title, category..." style="height: 36px; font-size: 0.85rem;" />
                @if (request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}" />
                @endif
                <button type="submit" class="btn secondary sm" style="height: 36px;">Search</button>
            </div>

        </form>
    </div>

    <!-- Posts Table Card -->
    <div class="card">
        @if ($posts->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--c-border); text-align: left;">
                            <th style="padding: 14px 20px; width: 60px;">Cover</th>
                            <th style="padding: 14px 20px;">Article Title</th>
                            <th style="padding: 14px 20px;">Category</th>
                            <th style="padding: 14px 20px;">Status</th>
                            <th style="padding: 14px 20px;">Views</th>
                            <th style="padding: 14px 20px;">Date</th>
                            <th style="padding: 14px 20px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr style="border-bottom: 1px solid var(--c-border);">
                                <td style="padding: 14px 20px;">
                                    @if ($post->cover_image)
                                        <img src="{{ str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset($post->cover_image) }}" alt="" style="width: 44px; height: 32px; object-fit: cover; border-radius: 4px;" />
                                    @else
                                        <div style="width: 44px; height: 32px; background: var(--c-bg-subtle); border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: var(--c-text-muted);">No Img</div>
                                    @endif
                                </td>
                                <td style="padding: 14px 20px;">
                                    <a href="{{ route('blog.show.admin', $post->slug) }}" style="font-weight: 600; text-decoration: none; color: var(--c-text); font-size: 0.9rem;">
                                        {{ $post->title }}
                                    </a>
                                </td>
                                <td style="padding: 14px 20px; white-space: nowrap;">
                                    <span style="font-size: 0.8rem; background: var(--c-bg-subtle); padding: 4px 10px; border-radius: 12px; border: 1px solid var(--c-border);">{{ $post->category }}</span>
                                </td>
                                <td style="padding: 14px 20px; white-space: nowrap;">
                                    @if ($post->is_published)
                                        <span style="display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(16, 185, 129, 0.15); color: #10b981;">Published</span>
                                    @else
                                        <span style="display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: rgba(245, 158, 11, 0.15); color: #f59e0b;">Draft</span>
                                    @endif
                                </td>
                                <td style="padding: 14px 20px; font-size: 0.85rem;" class="muted">
                                    {{ number_format($post->views_count) }}
                                </td>
                                <td style="padding: 14px 20px; white-space: nowrap; font-size: 0.825rem;" class="muted">
                                    {{ $post->created_at ? $post->created_at->format('M d, Y') : '' }}
                                </td>
                                <td style="padding: 14px 20px; text-align: right; white-space: nowrap;">
                                    <div style="display: flex; gap: 6px; justify-content: flex-end; align-items: center;">
                                        <a href="{{ route('blog.show.admin', $post->slug) }}" class="btn secondary sm" title="Edit Article">
                                            Edit
                                        </a>
                                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn secondary sm" title="View Public Page">
                                            View
                                        </a>
                                        <form action="{{ route('blog.destroy.admin', $post->slug) }}" method="POST" onsubmit="return confirm('Delete this article?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="icon-btn danger sm" title="Delete article" style="height: 32px; width: 32px;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="12"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding: 18px 24px; border-top: 1px solid var(--c-border); display: flex; justify-content: space-between; align-items: center;">
                {{ $posts->links() }}
            </div>
        @else
            <div style="padding: 60px 20px; text-align: center; color: var(--c-text-muted);">
                <div style="font-size: 1.1rem; font-weight: 600; color: var(--c-text);">No blog articles found</div>
                <div style="font-size: 0.875rem; margin-top: 4px;">Click "Create New Article" to write your first post.</div>
            </div>
        @endif
    </div>

</x-admin-layout>
