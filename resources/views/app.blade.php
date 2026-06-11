<!DOCTYPE html>
<html lang="tr" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="Bursa yazılım şirketi olarak yapay zeka entegrasyonları, otonom sistemler ve ölçeklenebilir özel yazılım çözümleri sunuyoruz. SaaS fabrikası ve enterprise yazılım ajansı.">
        <meta name="keywords" content="bursa yazılım şirketi, bursa yazılım firması, bursa yazılım ajansı, bursa web yazılım, özel yazılım, yapay zeka entegrasyonu, otonom sistemler, saas, laravel, vue, ai asistan, web geliştirme, teknoloji ajansı">

        {{-- Critical above-the-fold styles (prevents FOUC while async CSS loads) --}}
        <style>
            html.dark, html.dark body {
                background-color: #020617;
                color: #e2e8f0;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            body { margin: 0; font-family: ui-sans-serif, system-ui, sans-serif; }
        </style>

        {{-- Fonts: non-blocking load --}}
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
        <noscript><link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"></noscript>

        @inertiaHead
    </head>
    <body class="font-sans antialiased bg-enterprise-bg text-slate-200">
        @inertia

        {{-- Defer route map + app bundles to the end of body (off the critical path) --}}
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    </body>
</html>
