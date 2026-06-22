<!-- Footer Section -->
<footer class="footer">
    <div class="container">
        <div class="row g-4">
            
            <!-- Company Info Column -->
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <a href="{{ url('/') }}" class="text-decoration-none">
                    <span class="fs-3 fw-800 text-white font-poppins d-flex align-items-center mb-3">
                        <i class="fa fa-gears text-danger me-2"></i>
                        AUTO<span class="text-danger">PARTS</span>
                    </span>
                </a>
                <p class="mb-4">Auto Parts Marketplace is a premium source for high-quality certified OEM used auto parts. We specialize in finding tested engines, transmissions, headlights, wheels, and more to get your vehicle back on the road affordably.</p>
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
                    <li><a href="{{ url('/parts') }}">Find Parts</a></li>
                    <li><a href="{{ url('/blog') }}">Latest News</a></li>
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
                    <li class="mb-2"><i class="fa fa-map-marker-alt text-danger me-2"></i> 100 Industrial Pkwy, Suite 400, Detroit, MI 48201</li>
                    <li class="mb-2"><i class="fa fa-phone-alt text-danger me-2"></i> <a href="tel:+18005550199" class="text-white-50 text-decoration-none">+1 (800) 555-0199</a></li>
                    <li><i class="fa fa-envelope text-danger me-2"></i> <a href="mailto:support@autopartsmarket.com" class="text-white-50 text-decoration-none">support@autopartsmarket.com</a></li>
                </ul>
            </div>

        </div>

        <!-- Footer Bottom Copyright -->
        <div class="footer-bottom text-center">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start mb-3 mb-md-0">
                    <p class="m-0 text-white-50">&copy; {{ date('Y') }} Auto Parts Marketplace. All rights reserved.</p>
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
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Organization",
  "name": "Auto Parts Marketplace",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('frontend/images/logo.png') }}",
  "contactPoint": {
    "@@type": "ContactPoint",
    "telephone": "+1-800-555-0199",
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
