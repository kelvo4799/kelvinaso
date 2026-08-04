        <aside class="hero-aside animate-up delay-1">
            <div class="card profile">
            <div class="profile-img-wrap">
                <div class="profile-img"><img src="{{ $profile->cover_image }}" alt="Abstract data visualization" /></div>
                <div class="profile-pill"><span class="dot-live"></span><span>Open to work</span></div>
            </div>
            <div>
                <p class="profile-name">{{ ucwords($profile->first_name) }} {{ ucwords($profile->last_name) }}</p>
                <p class="profile-bio">{{ $profile->bio_title }}
                </p>
            </div>
            <div class="profile-socials">
                @foreach ($profile->social_links as $social => $url)
                    <a href="{{ $url }}" aria-label="{{ $social }}"><img class="profile-name" src="https://cdn.simpleicons.org/{{ $social }}/000fff" alt="{{ $social }}" width="20" height="20"></a>
                @endforeach

            </div>
            </div>
        </aside>