<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Convert your purse to lightest weight or optimal gold for all editions">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=roboto:300,400,500,700,900" rel="stylesheet"/>

    {{--    Facebook Meta Tags--}}
    <meta property="og:description" content="Convert your purse to lightest weight or optimal gold for all editions">
    <meta property="og:image" content="{{ Vite::asset('resources/images/scale2.webp') }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:site_name" content="D&D Money Calculator for all editions">
    <meta property="og:title" content="D&D Money Calculator for all editions">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://dndmoney.bluedreamer.com">

    {{--    Twitter Meta Tags--}}
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="dndmoney.bluedreamer.com">
    <meta property="twitter:url" content="https://dndmoney.bluedreamer.com">
    <meta name="twitter:title" content="D&D Money Calculator for all editions">
    <meta name="twitter:description" content="Convert your purse to lightest weight or optimal gold for all editions">

    <meta name="twitter:image" content="{{ Vite::asset('resources/images/scale.webp') }}">
    <title>{{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css')
    @fluxStyles
    @if(App::environment('production'))
        <script>
            var _mtm = window._mtm = window._mtm || [];
            _mtm.push({'mtm.startTime': (new Date().getTime()), 'event': 'mtm.Start'});
            (function () {
                var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
                g.async = true;
                g.src = 'https://ma.bluedreamer.com/js/container_AjxObE77.js';
                s.parentNode.insertBefore(g, s);
            })();
        </script>
    @endif
</head>
<body class="bg-emerald-700/15 dark:bg-emerald-700">

<main container class="bg-zinc-50 dark:bg-zinc-900 max-w-7xl rounded-2xl mx-1 xl:mx-auto p-2 m-4 overflow-scroll">
    <div class="flex justify-end">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">Light</flux:radio>
            <flux:radio value="dark" icon="moon">Dark</flux:radio>
            <flux:radio value="system" icon="computer-desktop">System</flux:radio>
        </flux:radio.group>
    </div>
    <div class="m-8">
        {{ $slot }}
    </div>
</main>
<footer>
    <div class="flex justify-end m-6">
        <a class="text-sm" href="https://github.com/bluedreamer/dnd_money" target="_blank">View on Github</a>
    </div>
</footer>
@fluxScripts
</body>
</html>
