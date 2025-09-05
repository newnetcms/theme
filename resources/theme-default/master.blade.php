<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Newnet">
    <meta name="referrer" content="no-referrer-when-downgrade" />
    <title>@yield('meta_title', setting('seo_meta_title') ?: setting('site_title', config('app.name')))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if($favicon = get_setting_media_url('favicon'))
        <link rel="icon" href="{{ $favicon }}">
    @endif

    @yield('meta')
    @stack('metas')

    @includeIf('path.head')

    {!! Asset::styles() !!}

    @includeIf('path.style')

    @stack('styles')

    <script>
        const locale = '{{ app()->getLocale() }}';
    </script>

    {!! theme_setting('code_head') !!}
</head>
<body class="@yield('body-class')">
{!! theme_setting('code_body') !!}

@includeIf('path.header')

@section('main-content')
    <main class="main" id="app">
        @yield('content')
    </main>
@show

@includeIf('path.footer')
@includeIf('path.maintenance_alert')

{!! Asset::container('footer')->styles() !!}

{!! Asset::scripts() !!}

@includeIf('path.script')

@stack('scripts')

{!! theme_setting('code_footer') !!}

</body>
</html>
