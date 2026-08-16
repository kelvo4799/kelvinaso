        <aside class="hero-aside animate-up delay-1">
            <div class="card profile">
                <div class="profile-img-wrap">
                    <div class="profile-img"><img src="{{ asset($profile->avatar) }}" alt="Abstract data visualization" />
                    </div>
                    <div class="profile-pill"><span class="dot-live"></span><span>Open to work</span></div>
                </div>
                <div>
                    <p class="profile-name">{{ ucwords($profile->first_name) }} {{ ucwords($profile->last_name) }}</p>
                    <p class="profile-bio">{{ $profile->bio_title }}
                    </p>
                </div>
                <div class="profile-socials" style="display: flex; justify-content: center; width: 100%;">
                    <x-social-links :links="$profile->social_links" :size="20" :center="true" />
                </div>
            </div>
        </aside>
