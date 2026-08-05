@php
    $name = "Asonta Ikpu";
    $profileCard = $page->sections->where('section_name', 'profile_card')->first();
    $workWith = $page->sections->where('section_name', 'work_with_card')->first();
    
@endphp


<x-main-layout :page="$page" :settings="$settings ?? ['site_name' => 'Portfolio']">
    <section class="hero" style="position: relative;">

        <x-profile-card-component :profile="$profile" />

        <div style="position: relative; z-index: 1;">
            <div class="card hero-card animate-up delay-2">
                <p class="muted" style="font-size:0.875rem;">Hello there! <span style="color:var(--accent);">👋</span></p>
                <h1 style="margin-top:1.0rem;">{{ $profileCard->content['hero_title'] }} {{ $name }}, {{ $profileCard->content['hero_title_two'] }} <span
                        class="text-gradient">{{ $profileCard->content['hero_title_highlight'] }}</span> {{ $profileCard->content['hero_title_suffix'] }}</h1>
                <div class="hero-meta"><span class="dot-live"></span> {{ $profileCard->content['hero_meta'] }}</div>
                <div class="hero-actions">
                    <a href="#" class="btn btn-primary">Download CV's
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
                            <span class="chip"><img src="{{ $stack->image ? $stack->image : "https://cdn.simpleicons.org/$stack->name" }}" alt="{{ $stack->name }}"
                                    width="24" height="24" style="margin-bottom:0.25rem;">{{ $stack->name }}</span>
                        @endforeach

                    @elseif($stacks->isEmpty())
                        <p>No stacks found.</p>
                    @endif
                    
                    
                    
                </div>
            </div>


        </div>

    </section>

</x-main-layout>
