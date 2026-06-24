<!-- Footer Section -->
<footer class="footer">
    <div class="container">
        <div class="row g-4">
            
            <!-- Company Info Column -->
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <a href="{{ url('/') }}" class="text-decoration-none">
                    <img src="{{ $siteSettings->get('site_logo') ? asset($siteSettings->get('site_logo')) : asset('frontend/images/riojimmymotorLogo.webp') }}" alt="{{ $siteSettings->get('site_name', 'Rio Jimmy Motor') }} Logo" class="mb-3" style="height: 50px; object-fit: contain;">
                </a>
                <p class="mb-4"><strong>{{ $siteSettings->get('site_name', 'Rio Jimmy Motor') }}</strong> is a premium source for high-quality certified OEM used auto parts. We specialize in finding tested engines, transmissions, headlights, wheels, and more to get your vehicle back on the road affordably.</p>
                <div class="social-icons">
                    <a href="https://facebook.com" class="social-icon-btn" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com" class="social-icon-btn" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a>
                    <a href="https://instagram.com" class="social-icon-btn" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                    <a href="https://linkedin.com" class="social-icon-btn" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Quick Links Column -->
            <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                <h5>Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/about') }}">About Us</a></li>
                    <li><a href="{{ url('/parts') }}">Shop</a></li>
                    <li><a href="{{ url('/blog') }}">Blog</a></li>
                    <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                </ul>
            </div>

            <!-- Categories Column -->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5>Popular Categories</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/parts?category=engines') }}">Used Engines</a></li>
                    <li><a href="{{ url('/parts?category=transmissions') }}">Used Transmissions</a></li>
                    <li><a href="{{ url('/parts?category=wheels') }}">OEM Rims & Wheels</a></li>
                    <li><a href="{{ url('/parts?category=lights') }}">Headlights & Tail Lights</a></li>
                    <li><a href="{{ url('/parts?category=body-parts') }}">Bumpers & Grilles</a></li>
                </ul>
            </div>

            <!-- Contact Info / Newsletter Column -->
            <div class="col-lg-3 col-md-6">
                <h5>Newsletter</h5>
                <p class="mb-3 small">Subscribe to our newsletter for auto tips, inventory updates, and discounts.</p>
                
                <form class="mb-4" onsubmit="event.preventDefault(); alert('Subscribed successfully!');">
                    <div class="input-group">
                        <input type="email" class="form-control border-0 rounded-start px-3" placeholder="Enter your email" required style="padding: 10px;">
                        <button class="btn btn-primary px-3 rounded-end" type="submit">
                            <i class="fa fa-paper-plane"></i>
                        </button>
                    </div>
                </form>

                <h5 class="mt-4 pt-2">Contact Info</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2"><i class="fa fa-map-marker-alt text-danger me-2"></i> {{ $siteSettings->get('office_address', '100 Industrial Pkwy, Detroit, MI 48201') }}</li>
                    <li class="mb-2"><i class="fa fa-phone-alt text-danger me-2"></i> <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings->get('contact_phone', '+18005550199')) }}" class="text-white-50 text-decoration-none">{{ $siteSettings->get('contact_phone', '+1 (800) 555-0199') }}</a></li>
                    <li><i class="fa fa-envelope text-danger me-2"></i> <a href="mailto:{{ $siteSettings->get('contact_email', 'support@autopartsmarket.com') }}" class="text-white-50 text-decoration-none">{{ $siteSettings->get('contact_email', 'support@autopartsmarket.com') }}</a></li>
                </ul>
            </div>

        </div>

        <!-- Footer Bottom Copyright -->
        <div class="footer-bottom text-center">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start mb-3 mb-md-0">
                    <p class="m-0 text-white-50">&copy; {{ date('Y') }} {{ $siteSettings->get('site_name', 'Rio Jimmy Motor') }}. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <ul class="list-inline m-0 text-white-50">
                        <li class="list-inline-item"><a href="#" class="text-white-50 text-decoration-none me-3">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="#" class="text-white-50 text-decoration-none">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- SEO Organization Schema -->
@if(($orgSchema = $siteSettings->get('seo_schema_organization')) && $orgSchema !== '{}')
<script type="application/ld+json">
{!! $orgSchema !!}
</script>
@else
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Organization",
  "name": "{{ $siteSettings->get('site_name', 'Rio Jimmy Motor') }}",
  "url": "{{ url('/') }}",
  "logo": "{{ $siteSettings->get('site_logo') ? asset($siteSettings->get('site_logo')) : asset('frontend/images/riojimmymotorLogo.webp') }}",
  "contactPoint": {
    "@@type": "ContactPoint",
    "telephone": "{{ $siteSettings->get('contact_phone', '+1-800-555-0199') }}",
    "contactType": "customer service",
    "areaServed": "US",
    "availableLanguage": "en"
  },
  "sameAs": [
    "https://facebook.com",
    "https://twitter.com",
    "https://instagram.com",
    "https://linkedin.com"
  ]
}
</script>
@endif
