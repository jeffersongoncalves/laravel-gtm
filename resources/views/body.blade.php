@php
    $cookieConsent = function_exists('cookie_consent_script_attributes') ? cookie_consent_script_attributes('gtm') : '';
@endphp
@php
    $settings = gtm_settings();
@endphp
@if($settings->hasValidId())
    <!-- Google Tag Manager (noscript) -->
    @if($cookieConsent === '')
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ urlencode($settings->gtm_id) }}"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    <!-- End Google Tag Manager (noscript) -->
@endif
