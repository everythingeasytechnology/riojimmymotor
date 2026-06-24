<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- SEO Meta Tags -->
    <title>@yield('meta_title', $siteSettings->get('seo_meta_title', 'Used Auto Parts & Salvage OEM Parts | Rio Jimmy Motor'))</title>
    <meta name="description" content="@yield('meta_description', $siteSettings->get('seo_meta_description', 'Find high-quality used engines, transmissions, wheels, body parts, and more. Certified auto parts with nationwide shipping and warranty at the best prices.'))">
    <link rel="canonical" href="@yield('canonical_url', $siteSettings->get('seo_canonical_url', url()->current()))">
    <meta name="robots" content="@yield('robots_meta', $siteSettings->get('seo_robots_meta', 'index, follow'))">
    
    <!-- Local Business Schema -->
    @if(($localSchema = $siteSettings->get('seo_schema_local_business')) && $localSchema !== '{}')
        <script type="application/ld+json">
        {!! $localSchema !!}
        </script>
    @endif
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', $siteSettings->get('seo_meta_title', 'Used Auto Parts & Salvage OEM Parts | Rio Jimmy Motor'))">
    <meta property="og:description" content="@yield('og_description', $siteSettings->get('seo_meta_description', 'Find high-quality used engines, transmissions, wheels, body parts, and more. Certified auto parts with nationwide shipping and warranty.'))">
    <meta property="og:image" content="@yield('og_image', asset('frontend/images/og-default.jpg'))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:site_name" content="{{ $siteSettings->get('site_name', 'Rio Jimmy Motor') }}">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('twitter_title', $siteSettings->get('seo_meta_title', 'Used Auto Parts & Salvage OEM Parts | Rio Jimmy Motor'))">
    <meta name="twitter:description" content="@yield('twitter_description', $siteSettings->get('seo_meta_description', 'Find high-quality used engines, transmissions, wheels, body parts, and more. Certified auto parts with nationwide shipping and warranty.'))">
    <meta name="twitter:image" content="@yield('twitter_image', asset('frontend/images/og-default.jpg'))">

    <!-- Fonts preconnect and Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS (Bootstrap 5.3.2) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Custom Theme Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    
    <!-- Integration Tracking Scripts from Admin Panel -->
    @if($gaId = $siteSettings->get('google_analytics_id'))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '{{ $gaId }}');
        </script>
    @endif

    @if($clarityId = $siteSettings->get('clarity_project_id'))
        <!-- Microsoft Clarity Script -->
        <script type="text/javascript">
            (function(c,l,a,r,i,t,y){
                c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
            })(window,document,"clarity","script","{{ $clarityId }}");
        </script>
    @endif

    @if($pixelId = $siteSettings->get('facebook_pixel_id'))
        <!-- Facebook Pixel Code -->
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '{{ $pixelId }}');
          fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $pixelId }}&ev=PageView&noscript=1"/></noscript>
    @endif

    <!-- Custom Header Scripts from Admin Panel -->
    {!! $siteSettings->get('custom_header_scripts') !!}

    @stack('styles')
</head>
<body>

    <!-- Header section -->
    @include('frontend.layouts.header')

    <!-- Main Content Yield Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer section -->
    @include('frontend.layouts.footer')

    <!-- Bootstrap Bundle with Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <!-- Custom Javascript -->
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    
    <!-- Mobile Sticky Action Bar -->
    <div class="mobile-sticky-bar d-md-none">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <!-- Call Option -->
                <div class="col-6">
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings->get('contact_phone', '+18005550199')) }}" class="btn btn-secondary w-100 rounded-0 py-3 text-uppercase font-poppins d-flex align-items-center justify-content-center gap-2" style="font-size: 14px; background-color: var(--dark-black); border: none;">
                        <i class="fa fa-phone-volume text-danger"></i> Call Now
                    </a>
                </div>
                <!-- Order Now Option -->
                <div class="col-6">
                    <a href="{{ url('/contact?inquiry=1') }}" class="btn btn-primary w-100 rounded-0 py-3 text-uppercase font-poppins d-flex align-items-center justify-content-center gap-2" style="font-size: 14px; background-color: var(--primary-red); border: none;">
                        <i class="fa fa-cart-shopping"></i> Order Now
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Footer Scripts from Admin Panel -->
    {!! $siteSettings->get('custom_footer_scripts') !!}

    @stack('scripts')
</body>
</html>
