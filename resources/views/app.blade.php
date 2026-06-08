<!DOCTYPE html>
<html lang="tr" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="Yapay zeka entegrasyonları, otonom sistemler ve ölçeklenebilir özel yazılım çözümleri sunan SaaS fabrikası ve enterprise yazılım ajansı.">
        <meta name="keywords" content="özel yazılım, yapay zeka entegrasyonu, otonom sistemler, saas, laravel, vue, ai asistan, web geliştirme, teknoloji ajansı">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased bg-enterprise-bg text-slate-200">
        @inertia
    </body>
</html>
