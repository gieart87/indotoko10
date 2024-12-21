<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title ?? 'Page Title' }}</title>
    <!-- CSS files -->
    @vite([
        'resources/views/livewire/admin/assets/css/tabler.min.css?1692870487',
        'resources/views/livewire/admin/assets/css/tabler-flags.min.css?1692870487',
        'resources/views/livewire/admin/assets/css/tabler-payments.min.css?1692870487',
        'resources/views/livewire/admin/assets/css/tabler-vendors.min.css?1692870487',
    ])
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- Sidebar -->
        <livewire:admin.sidebar/>
        <!-- Navbar -->
        <livewire:admin.header/>
        <div class="page-wrapper">
            <!-- Page header -->
            {{ $slot }}
            <livewire:admin.footer/>
        </div>
    </div>
    <!-- Libs JS -->
    @vite([
        'resources/views/livewire/admin/assets/js/demo-theme.min.js?1692870487',
        'resources/views/livewire/admin/assets/libs/apexcharts/dist/apexcharts.min.js',
        'resources/views/livewire/admin/assets/libs/jsvectormap/dist/js/jsvectormap.min.js',
        'resources/views/livewire/admin/assets/libs/jsvectormap/dist/maps/world.js',
        'resources/views/livewire/admin/assets/libs/jsvectormap/dist/maps/world-merc.js',
        'resources/views/livewire/admin/assets/js/tabler.min.js',    
    ])
</body>

</html>