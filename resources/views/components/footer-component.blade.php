<footer class="footer">
    <div class="container">

        <div class="footer-cta-card">
            <h2>{{ setting('footer_cta_title', 'Are You Ready to kickstart your project with a touch of magic?') }}</h2>
            <p>{{ setting('footer_cta_description', "Reach out and let's make it happen ✨. I'm also available for full-time or freelance opportunities to push the boundaries of data and deliver exceptional work.") }}</p>
            <a href="{{ setting('footer_cta_button_url', route('contact')) }}" class="btn-cta">
                {{ setting('footer_cta_button_text', "Let's Talk") }}
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <polyline points="19 12 12 19 5 12"></polyline>
                </svg>
            </a>
        </div>

        <div class="footer-bottom-text">
            <p>{{ setting('footer_copyright', 'Copyright © ' . date('Y') . ', ' . setting('site_name') . ' All Rights Reserved.') }}</p>
            <x-social-links />
        </div>
    </div>
</footer>
