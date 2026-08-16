@php
    $profileCard = $page->sections->where('section_name', 'profile_card')->first();
    $workWith = $page->sections->where('section_name', 'work_with_card')->first();

@endphp


<x-main-layout :page="$page" :settings="$settings ?? ['site_name' => 'Portfolio']">
    <section class="hero" style="position: relative;">

        <x-profile-card-component :profile="$profile" />

        <div style="position: relative; z-index: 1;">
            <div class="card hero-card animate-up delay-2">
                <p class="muted" style="font-size:0.875rem;">Hello there! <span style="color:var(--accent);">👋</span></p>
                <h1 style="margin-top:1.0rem;">{{ $profileCard->content['hero_title'] }}
                    {{ ucwords($profile->first_name . ' ' . $profile->last_name) }},
                    {{ $profileCard->content['hero_title_two'] }} <span
                        class="text-gradient">{{ $profileCard->content['hero_title_highlight'] }}</span>
                    {{ $profileCard->content['hero_title_suffix'] }}</h1>
                <div class="hero-meta"><span class="dot-live"></span> {{ $profileCard->content['hero_meta'] }}</div>
                <div class="hero-actions">
                    <a href="{{ !empty($profile) && !empty($profile->cv) ? (str_starts_with($profile->cv, 'http') ? $profile->cv : asset($profile->cv)) : '#' }}"
                        target="_blank" class="btn btn-primary">Download CV
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                    </a>
                    <a href="/projects" class="btn">See Works</a>
                </div>
            </div>


            <div class="card stack animate-up delay-3">
                <p class="stack-title">{{ $workWith->content['title'] }}</p>
                <div class="chips">
                    @if ($stacks->isNotEmpty())
                        @foreach ($stacks as $stack)
                            <span class="chip"><img
                                    src="{{ $stack->image ? $stack->image : "https://cdn.simpleicons.org/$stack->name/9ca3af" }}"
                                    alt="{{ $stack->name }}" width="24" height="24"
                                    style="margin-bottom:0.25rem;">{{ $stack->name }}</span>
                        @endforeach
                    @elseif($stacks->isEmpty())
                        <p>No stacks found.</p>
                    @endif



                </div>
            </div>


            @php
                $enableExperiences = \App\Models\Settings::where('key', 'enable_experiences')->value('value') ?? '1';
                $experiencesList =
                    $enableExperiences === '1' ? \App\Models\Experience::where('is_active', true)->get() : collect();
            @endphp

            @if ($enableExperiences === '1' && $experiencesList->isNotEmpty())
                <section style="margin: 40px 0;">
                    <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 20px; color: var(--fg);">Work
                        Experience & Career</h2>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        @foreach ($experiencesList as $exp)
                            <div
                                style="background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                    <div>
                                        <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--fg);">
                                            {{ $exp->title }}</h3>
                                        <div style="font-size: 0.9rem; color: var(--accent); font-weight: 600;">
                                            {{ $exp->company }} <span style="color: var(--muted); font-weight: 400;">—
                                                {{ $exp->location ?: 'Remote' }}</span></div>
                                    </div>
                                    <span
                                        style="font-size: 0.8rem; font-weight: 700; padding: 4px 10px; border-radius: 12px; background: var(--accent-soft); color: var(--accent);">
                                        {{ $exp->start_year }} -
                                        {{ $exp->is_current ? 'Present' : ($exp->end_year ?: 'Present') }}
                                    </span>
                                </div>
                                @if ($exp->description)
                                    <p
                                        style="font-size: 0.9rem; color: var(--muted); line-height: 1.6; margin: 8px 0 0;">
                                        {{ $exp->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <x-github-card />

        </div>

    </section>

</x-main-layout>
