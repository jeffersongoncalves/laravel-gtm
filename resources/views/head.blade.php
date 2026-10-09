@php
    $settings = gtm_settings();
    // CSP nonce (Laravel's Vite nonce, set by e.g. laravel-security-headers); null when the app uses none.
    $nonce = \Illuminate\Support\Facades\Vite::cspNonce();
@endphp
@if($settings->hasValidId())
    <!-- Google Tag Manager -->
    <script @if($nonce) nonce="{{ $nonce }}" @endif>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;var n=d.querySelector('[nonce]');
            n&&j.setAttribute('nonce',n.nonce||n.getAttribute('nonce'));f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer',{{ \Illuminate\Support\Js::from($settings->gtm_id) }});</script>
    <!-- End Google Tag Manager -->
@endif
