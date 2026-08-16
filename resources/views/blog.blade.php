<x-main-layout :page="$page" :settings="$settings ?? ['site_name' => 'Portfolio']">

    <section class="hero" style="position: relative;">

        <div style="position: relative; z-index: 1;">
            
            <!-- Page Header Card -->
            <div class="card hero-card animate-up delay-1">
                <p class="eyebrow">Writing & Thought Leadership</p>
                <h1 style="margin-top: 1rem;">Blog & Articles</h1>
                <p class="summary" style="color:var(--muted); font-size:1.15rem; margin-top:1.5rem; line-height:1.6;">
                    Deep dives into modern web engineering, architecture design, Laravel development, and personal lessons learned.
                </p>
            </div>

            <!-- Filter & Search Toolbar Card -->
            <div class="card animate-up delay-2" style="margin-top: 1.5rem; padding: 1.25rem;">
                <form method="GET" action="{{ route('blog') }}" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; justify-content: space-between;">
                    
                    <!-- Category Tabs -->
                    <div class="chips" style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <a href="{{ route('blog', array_filter(['search' => request('search')])) }}" class="chip" style="text-decoration: none; padding: 0.5rem 1rem; {{ !request('category') || request('category') === 'All' ? 'background: var(--accent); color: #fff;' : '' }}">
                            All
                        </a>
                        @if (!empty($categories))
                            @foreach ($categories as $cat)
                                <a href="{{ route('blog', array_filter(['category' => $cat, 'search' => request('search')])) }}" class="chip" style="text-decoration: none; padding: 0.5rem 1rem; {{ request('category') === $cat ? 'background: var(--accent); color: #fff;' : '' }}">
                                    {{ $cat }}
                                </a>
                            @endforeach
                        @endif
                    </div>

                    <!-- Search Input -->
                    <div style="display: flex; gap: 0.5rem; flex: 1; max-width: 320px;">
                        <input class="input" type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..." style="height: 38px; font-size: 0.875rem;" />
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}" />
                        @endif
                        <button type="submit" class="btn" style="height: 38px; padding: 0 1rem; font-size: 0.875rem;">Search</button>
                    </div>

                </form>
            </div>

            <!-- Blog Post Grid -->
            @if ($posts->count() > 0)
                <div class="grid-bento animate-up delay-3" style="margin-top: 1.5rem; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                    @foreach ($posts as $post)
                        <a href="{{ route('blog.show', $post->slug) }}" class="card work-card" style="display: flex; flex-direction: column; text-decoration: none; height: 100%; border-radius: var(--radius-xl); overflow: hidden; padding: 0;">
                            @if ($post->cover_image)
                                <div style="width: 100%; height: 180px; overflow: hidden; background: var(--bg-subtle);">
                                    <img src="{{ str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset($post->cover_image) }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;" />
                                </div>
                            @endif

                            <div style="padding: 1.5rem; display: flex; flex-direction: column; flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; font-size: 0.75rem;">
                                    <span class="chip" style="font-size: 0.75rem; padding: 0.25rem 0.6rem; margin: 0;">{{ $post->category }}</span>
                                    <span style="color: var(--muted);">{{ $post->read_time ?: '5 min read' }}</span>
                                </div>

                                <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--fg); line-height: 1.4;">
                                    {{ $post->title }}
                                </h3>

                                <p style="color: var(--muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.25rem; flex: 1;">
                                    {{ Str::limit($post->excerpt ?: strip_tags($post->content), 110) }}
                                </p>

                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; color: var(--muted); border-top: 1px solid var(--border); padding-top: 0.75rem; margin-top: auto;">
                                    <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                    <span style="color: var(--accent); font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                        Read Article
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div style="margin-top: 2rem;">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="card animate-up delay-3" style="margin-top: 1.5rem; text-align: center; padding: 4rem 2rem;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">No articles found</h3>
                    <p style="color: var(--muted); font-size: 0.95rem;">There are no published articles matching your criteria yet.</p>
                </div>
            @endif

        </div>

    </section>

</x-main-layout>
