<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JDD 2026 - Jatim Developer Day</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/jdd-logo.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <meta name="description" content="JDD 2026 - Konferensi teknologi terbesar untuk developer Jawa Timur. 3 hari penuh insight, workshop, dan networking.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="JDD 2026 - Jatim Developer Day">
    <meta property="og:description" content="Konferensi teknologi terbesar untuk developer Jawa Timur. 7 November 2026 · ITB Yadika Pasuruan.">
    <meta property="og:image" content="{{ asset('images/og-cover.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="JDD 2026 - Jatim Developer Day">
    <meta name="twitter:description" content="Konferensi teknologi terbesar untuk developer Jawa Timur. 7 November 2026 · ITB Yadika Pasuruan.">
    <meta name="twitter:image" content="{{ asset('images/og-cover.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet"/>
    <script>
        window.APP_CONFIG = {
            apiBaseUrl: '{{ env('APP_URL', config('app.url')) }}',
            appType: '{{ env('VITE_APP_TYPE', 'landingpage') }}',
            useApiData: {
                speakers: true,
                event: false,
                materials: false,
                agenda: false,
                tickets: false,
                merchandises: false,
                partners: false,
                sections: false,
                sponsors: false,
                communityPartners: false,
                schedule: false,
            },
            eventDate: '{{ env('VITE_EVENT_DATE', '2026-11-07') }}',
            speakerFormUrl: '{{ env('VITE_SPEAKER_FORM_URL', '') }}',
            mediaPartnerFormUrl: '{{ env('VITE_MEDIA_PARTNER_FORM_URL', '') }}',
        }
    </script>
    @vite(['resources/js/landing-page/src/main.ts'])
</head>
<body>
    <div id="app"></div>
</body>
</html>
