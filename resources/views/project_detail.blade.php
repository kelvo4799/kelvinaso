<x-main-layout :page="$page" :settings="$settings ?? ['site_name' => 'Portfolio']">


    <section class="hero" style="position: relative;">



        <aside class="hero-aside animate-up delay-1">
            <div class="card profile hero-card">
                <a href="{{ route('projects') }}" class="back"
                    style="display:inline-flex; align-items:center; gap:0.5rem; margin-bottom:2rem; color:var(--muted); font-size: 0.875rem; text-decoration:none; transition: color 0.2s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    All Work
                </a>

                <h3 style="margin-bottom: 1.5rem;">{{ $project->title }}</h3>

                <dl class="meta-row"
                    style="display: flex; flex-direction: column; gap: 1.25rem; border: none; padding: 0; margin: 0;">

                    @if (!empty($project->client_url))
                        <div>
                            <dt>Organization</dt>
                            <dd>
                                <a href="{{ $project->client_url }}" target="_blank" rel="noopener noreferrer">
                                    {{ $project->client }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        style="vertical-align: middle; margin-left: 4px;">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                                        <polyline points="15 3 21 3 21 9" />
                                        <line x1="10" y1="14" x2="21" y2="3" />
                                    </svg>
                                </a>
                            </dd>
                        </div>
                    @else
                        <div>
                            <dt>Organization</dt>
                            <dd>{{ $project->client }}</dd>
                        </div>
                    @endif


                    <div>
                        <dt>Role</dt>
                        <dd>{{ $project->role }}</dd>
                    </div>

                    <div>
                        <dt>Industry</dt>
                        <dd>{{ $project->industry }}</dd>
                    </div>
                    <div>
                        <dt>Year</dt>
                        <dd>{{ $project->year }}</dd>
                    </div>
                </dl>

                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border);">
                    <p class="stack-title" style="margin-bottom: 1rem;">Technologies</p>
                    <div class="chips" style="display: flex; flex-wrap: wrap; gap: 0.5rem;">

                        @foreach ($project->tech_stack as $tech)
                            <span class="chip"
                                style="flex: 1 1 auto; max-width: max-content; padding: 0.5rem 1rem;">{{ $tech }}</span>
                        @endforeach

                    </div>
                </div>



                @if ( $project->view_type === 'live')
                    <a href="{{ $project->live_url }}" target="_blank" class="btn btn-primary"
                        style="margin-top: 2rem; width: 100%;">
                        View Live
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                            <polyline points="15 3 21 3 21 9" />
                            <line x1="10" y1="14" x2="21" y2="3" />
                        </svg>
                    </a>
                @elseif ($project->view_type === 'preview')
                    <button data-preview="{{ $project->live_url }}" class="btn"
                        style="margin-top: 0.75rem; width: 100%;">
                        Live Preview
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                @endif

            </div>
        </aside>

        <div style="position: relative; z-index: 1;">
            <div class="card hero-card animate-up delay-2">
                <p class="eyebrow">{{ $project->title }} · {{ $project->year }}</p>
                <h1 style="margin-top: 1rem;">{{ $project->title }}</h1>
                <p class="summary" style="color:var(--muted); font-size:1.15rem; margin-top:1.5rem; line-height:1.6;">
                    {{ $project->description }}
                </p>
            </div>

            <div class="card stack animate-up delay-3" style="margin-top: 1.5rem; padding: 1rem;">

                <div class="profile-img-wrap">
                    <div class="profile-img"><img src="{{ $project->image }}" alt="Abstract data visualization" />
                    </div>

                </div>
            </div>

            @if (!empty($project->metrics))

                <div class="card metrics animate-up delay-4 hero-card"
                    style="margin-top: 1.5rem; border-radius: var(--radius-xl);">
                    @foreach ($project->metrics as $metric => $value)
                        <div>
                            <p class="value">{{ $value }}</p>
                            <p class="label">{{ $metric }}</p>
                        </div>
                    @endforeach

                </div>

            @endif

            @if (is_array($project->other_details) && !empty($project->other_details))
            <div class="card animate-up delay-4 hero-card" style="margin-top: 1.5rem; border-radius: var(--radius-xl);">
                <div style="display: flex; flex-direction: column; gap: 3rem;">
                  @foreach ( $project->other_details as $content)
                    @if ($content['is_active'])
                      <div>
                          <h2 style="font-size: 1.75rem;">{{ $content['header'] }}</h2>
                          <p style="color:var(--muted); font-size:1.1rem; line-height:1.7; margin-top:1rem;">
                              {{ $content['paragrah'] }}
                          </p>
                      </div>
                    @endif
                  @endforeach

                    <div>

                        @if ($project->client_comment)
                        <div class="card"
                            style="margin-top: 2.5rem; padding: 2rem; border-left: 4px solid var(--accent); background: rgba(240, 86, 58, 0.03);">
                            <p style="font-size: 1.1rem; font-style: italic; line-height: 1.6; color: var(--fg);">"{{ $project->client_comment['comment'] }}"
                            </p>
                            <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1.5rem;">
                                <div
                                    style="width: 40px; height: 40px; border-radius: 50%; background: var(--border-strong); display: flex; align-items: center; justify-content: center; font-weight: 600; color: var(--muted); font-size: 0.8rem;">
                                    DC</div>
                                <div>
                                    <p style="font-weight: 600; font-size: 0.9rem; margin: 0;">{{ $project->client_comment['name'] }}</p>
                                    <p style="color: var(--muted); font-size: 0.8rem; margin: 0;">{{ $project->client_comment['poition'] }}, {{ $project->client }}
                                    </p>
                                </div>
                            </div>
                          </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif



            <div class="animate-up delay-4" style="margin-top:4rem;">
                <div class="card hero-card"
                    style="display:flex; flex-direction:column; align-items:center; text-align:center; margin-bottom: 0; border-radius: var(--radius-xl);">
                    <p class="eyebrow" style="color:var(--muted); margin-bottom: 0.75rem;">Up Next</p>
                    <h2 style="font-size: 2rem; margin-bottom: 0.75rem;">{{ $nextProject['title'] }}</h2>
                    <p style="color:var(--muted); font-size:1.05rem; margin-bottom: 1.5rem; max-width: 400px;">{{ $nextProject['short_description'] }}</p>
                    <a href="{{ Route('projects.show', $nextProject['slug']) }}" class="btn btn-primary">
                        Read Case Study
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="margin-left: 0.25rem;">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
            </div>


        </div>
    </section>

</x-main-layout>
