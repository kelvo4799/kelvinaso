@php
    $name = 'Asonta Ikpu';
    $profileCard = $page->sections->where('section_name', 'profile_card')->first();
    $workWith = $page->sections->where('section_name', 'work_with_card')->first();

@endphp


<x-main-layout :page="$page" :settings="$settings ?? ['site_name' => 'Portfolio']">

    <section class="hero" style="position: relative;">

        <x-profile-card-component :profile="$profile" />





        <div style="display:flex; flex-direction:column; gap:4rem;">
            <div class="card hero-card">
                <p class="eyebrow">Biography</p>
                <h1 style="margin-top:1.25rem;">{{ $profile->bio_header ?? '' }} <span class="text-gradient">read the data</span> </h1>
                <div
                    style="margin-top:2rem; color:var(--muted); font-size:1.1rem; line-height:1.7; max-width:60ch; display:flex; flex-direction:column; gap:1.25rem;">
                    <p>{{ $profile->bio }}</p>
                    <p>{{ $$profile->bio_extra ?? '' }}</p>
                </div>
            </div>
            




            
            <section>
                <h2 style="margin-bottom:2rem;">Skills</h2>
                <div class="skills-grid">

                        @foreach ($stacks as $stack => $values)
                            <div class="card skill-card">
                                <p class="eyebrow">{{ $stack }}</p>
                                <ul>
                                    @foreach ($values as $value)
                                        <li>{{ $value['name'] }} <span class="skill-level {{ strtolower($value['level'] ?? 'intermidiate') }}">{{ $value['level'] ?? 'intermidiate' }}</span></li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        @endforeach

                </div>
            </section>

            @php
                $ex = false;
            @endphp
            @if ($ex)
            <section>
                <h2 style="margin-bottom:2rem;">Experience</h2>
                <ul class="experience">
                    <li><span class="year">2023 — Now</span><span class="role">Independent</span><span
                            class="desc">Laravel engineering & data analysis for product teams.</span></li>
                    <li><span class="year">2020 — 2023</span><span class="role">Helio SaaS</span><span
                            class="desc">Senior backend engineer & analyst.</span></li>
                    <li><span class="year">2018 — 2020</span><span class="role">Atlas Fintech</span><span
                            class="desc">Laravel developer on the core ledger.</span></li>
                    <li><span class="year">2016 — 2018</span><span class="role">Folio Press</span><span
                            class="desc">Data analyst, BI and reporting.</span></li>
                </ul>
            </section>
            @endif
        </div>
    </section>


</x-main-layout>


