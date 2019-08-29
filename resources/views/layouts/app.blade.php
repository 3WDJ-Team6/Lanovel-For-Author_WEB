<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ノベル述べる！</title>

    <!-- Scripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery/jquery.modal.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery/jquery.modal.min.1.js') }}" defer></script>
    <script src="{{ asset('js/jquery/jquery.form.js') }}" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/res.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.modal.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.modal.min.1.css') }}" rel="stylesheet">
    <link href="{{ asset('css/template.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components\jquery-ui\themes\base\jquery-ui.css') }}" rel="stylesheet">
</head>

<body>
    @yield('header')

    <main>
        @yield('content')
    </main>
</body>
@yield('footer')

</html>
