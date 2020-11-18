<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        {{-- <title>{{ $page['title'] }}</title> --}}
        <title>Laravel Vue</title>
        <meta name="description" content="Ela user - HTML5 user Template">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="auth_id" content="{{ Auth::user()->id }}">

        <x-user.css />
    </head>

    <body>
        <div id="app">
            <x-user.left-navigation />

            <div id="right-panel" class="right-panel">
                <x-user.top-navigation />

                @yield('content')

                <div class="clearfix"></div>

                <x-user.footer />
            </div>
        </div>

        <x-user.script />

        @yield('script')

        {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
    </body>
</html>
