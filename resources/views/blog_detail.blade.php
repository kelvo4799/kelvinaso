<x-main-layout :page="$page" :settings="$settings ?? ['site_name' => 'Portfolio']">

    <section class="hero" style="position: relative;">

        <!-- Sidebar Meta Column -->
        <aside class="hero-aside animate-up delay-1">
            <div class="card profile hero-card">
                <a href="{{ route('blog') }}" class="back" style="display:inline-flex; align-items:center; gap:0.5rem; margin-bottom:2rem; color:var(--muted); font-size: 0.875rem; text-decoration:none;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    All Articles
                </a>

                <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem;">Article Details</h3>

                <dl class="meta-row" style="display: flex; flex-direction: column; gap: 1.25rem; border: none; padding: 0; margin: 0;">
                    <div>
                        <dt>Category</dt>
                        <dd><span class="chip" style="margin: 0;">{{ $post->category }}</span></dd>
                    </div>

                    <div>
                        <dt>Published Date</dt>
                        <dd>{{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}</dd>
                    </div>

                    <div>
                        <dt>Reading Time</dt>
                        <dd>{{ $post->read_time ?: '5 min read' }}</dd>
                    </div>

                    <div>
                        <dt>Total Views</dt>
                        <dd>{{ number_format($post->views_count) }} views</dd>
                    </div>

                    @if (!empty($post->tags) && is_array($post->tags))
                        <div>
                            <dt>Tags</dt>
                            <dd>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.25rem; margin-top: 0.25rem;">
                                    @foreach ($post->tags as $t)
                                        <span style="font-size: 0.75rem; color: var(--muted); background: var(--bg-subtle); padding: 2px 8px; border-radius: 4px;">#{{ $t }}</span>
                                    @endforeach
                                </div>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </aside>

        <!-- Main Article Content Column -->
        <div style="position: relative; z-index: 1;">
            
            <!-- Article Header Card -->
            <div class="card hero-card animate-up delay-2">
                <p class="eyebrow">{{ $post->category }} · {{ $post->read_time ?: '5 min read' }}</p>
                <h1 style="margin-top: 1rem; font-size: 2.2rem; line-height: 1.3;">{{ $post->title }}</h1>
                @if ($post->excerpt)
                    <p class="summary" style="color:var(--muted); font-size:1.15rem; margin-top:1.5rem; line-height:1.6;">
                        {{ $post->excerpt }}
                    </p>
                @endif
            </div>

            <!-- Cover Image Card -->
            @if ($post->cover_image)
                <div class="card stack animate-up delay-3" style="margin-top: 1.5rem; padding: 0.75rem; overflow: hidden; border-radius: var(--radius-xl);">
                    <img src="{{ str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset($post->cover_image) }}" alt="{{ $post->title }}" style="width: 100%; max-height: 420px; object-fit: cover; border-radius: var(--radius-lg); display: block;" />
                </div>
            @endif

            <!-- Main Article Body Content Card -->
            <div class="card animate-up delay-4 hero-card" style="margin-top: 1.5rem; border-radius: var(--radius-xl); padding: 2.5rem;">
                <div style="font-size: 1.1rem; line-height: 1.8; color: var(--fg); white-space: pre-wrap; font-family: inherit;">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            <!-- Related Articles Section -->
            @if ($relatedPosts->count() > 0)
                <div style="margin-top: 3rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Related Articles</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.25rem;">
                        @foreach ($relatedPosts as $rPost)
                            <a href="{{ route('blog.show', $rPost->slug) }}" class="card work-card" style="display: block; text-decoration: none; padding: 1.25rem; border-radius: var(--radius-lg);">
                                <div style="font-size: 0.75rem; color: var(--muted); margin-bottom: 0.5rem;">{{ $rPost->category }}</div>
                                <h4 style="font-size: 1rem; font-weight: 700; color: var(--fg); margin-bottom: 0.5rem; line-height: 1.4;">{{ $rPost->title }}</h4>
                                <div style="font-size: 0.8rem; color: var(--accent); font-weight: 600;">Read More &rarr;</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </section>

</x-main-layout>
