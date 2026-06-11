<!DOCTYPE html>
<html lang="tr" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="Bursa yazılım şirketi olarak yapay zeka entegrasyonları, otonom sistemler ve ölçeklenebilir özel yazılım çözümleri sunuyoruz. SaaS fabrikası ve enterprise yazılım ajansı.">
        <meta name="keywords" content="bursa yazılım şirketi, bursa yazılım firması, bursa yazılım ajansı, bursa web yazılım, özel yazılım, yapay zeka entegrasyonu, otonom sistemler, saas, laravel, vue, ai asistan, web geliştirme, teknoloji ajansı">

        {{-- Critical above-the-fold styles (FCP/LCP before async Tailwind + Vue) --}}
        <style>
            html.dark, html.dark body {
                background-color: #020617;
                color: #e2e8f0;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            body {
                margin: 0;
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            }
            #app:not(:empty) ~ #static-welcome-shell { display: none; }
            #static-welcome-shell {
                background: #020617;
                color: #e2e8f0;
            }
            .sws-header {
                position: sticky;
                top: 0;
                z-index: 40;
                border-bottom: 1px solid #1e293b;
                background: rgba(2, 6, 23, 0.92);
                backdrop-filter: blur(12px);
            }
            .sws-nav {
                display: flex;
                align-items: center;
                justify-content: space-between;
                max-width: 80rem;
                margin: 0 auto;
                padding: 1rem;
            }
            .sws-logo {
                font-size: 0.875rem;
                font-weight: 600;
                letter-spacing: 0.025em;
                color: #fff;
            }
            .sws-cta {
                font-size: 0.875rem;
                font-weight: 600;
                color: #fff;
                background: #2563eb;
                border-radius: 0.375rem;
                padding: 0.5rem 1rem;
            }
            .sws-hero {
                display: flex;
                min-height: 80vh;
                align-items: center;
                padding: 0 1rem;
            }
            .sws-hero-inner {
                max-width: 48rem;
                margin: 0 auto;
                width: 100%;
            }
            .sws-eyebrow {
                margin: 0 0 1rem;
                font-size: 0.875rem;
                font-weight: 600;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: #93c5fd;
            }
            .sws-title {
                margin: 0;
                font-size: 2.25rem;
                font-weight: 700;
                line-height: 1.15;
                letter-spacing: -0.025em;
                color: #fff;
            }
            .sws-lead {
                margin: 1.5rem 0 0;
                font-size: 1.125rem;
                line-height: 1.625;
                color: #cbd5e1;
            }
            @media (min-width: 640px) {
                .sws-hero { padding: 0 1.5rem; }
                .sws-title { font-size: 3rem; }
                .sws-lead { font-size: 1.25rem; }
            }
        </style>

        @inertiaHead
    </head>
    <body class="font-sans antialiased bg-enterprise-bg text-slate-200">
        @inertia

        @if (($page['component'] ?? '') === 'Welcome')
            @include('partials.static-welcome-shell')
        @endif

        @php
            $pageComponent = $page['component'] ?? '';
            $needsFullRoutes = str_starts_with($pageComponent, 'Admin/')
                || str_starts_with($pageComponent, 'Client/')
                || str_starts_with($pageComponent, 'Auth/')
                || str_starts_with($pageComponent, 'Profile/');
        @endphp

        {{-- Defer route map + app bundles to the end of body (off the critical path) --}}
        @if ($needsFullRoutes)
            @routes
        @else
            @routes('public')
        @endif

        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    </body>
</html>
