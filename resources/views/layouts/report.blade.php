<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/js/app.js'])

    <style>
        table {
            border-left: 0.01em solid #ccc;
            border-right: 0;
            border-top: 0.01em solid #ccc;
            border-bottom: 0;
            border-collapse: collapse;
        }
        table td,
        table th {
            border-left: 0;
            border-right: 0.01em solid #ccc;
            border-top: 0;
            border-bottom: 0.01em solid #ccc;
        }
    </style>
</head>
<body>
<div>
    <div style="display:inline-block; margin-right: 100px;">
        <img height="75" width="150" src="logo.png" />
    </div>
    <div style="display:inline-block; float:right;">
        <div style="font-size: 11px;">Disaster Cycle Services</div>
        <div style="font-size: 11px;">@yield('name')</div>
        <div style="font-size: 11px;">{{ now()->format('l, F d, Y h:i A') }}</div>
    </div>
</div>

@yield('content')
</body>
</html>
