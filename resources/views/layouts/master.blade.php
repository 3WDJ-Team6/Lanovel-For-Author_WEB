<!DOCTYPE html>
<html>

<head>

    <title> </title>
    <!-- Latest compiled and minified CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    @yield('head')

    <title>lanoveProject</title>


    <!-- Custom fonts for this template -->
    <link href="{{asset('fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="{{asset('css/clean-blog.min.css')}}" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{asset('js/clean-blog.min.js')}}"></script>

    


</head>

<body>
    <header>
        @include('layouts.header')
    </header>

    <section>
        @yield('content')
    </section>

    <footer>
        @include('layouts.footer')
    </footer>

</body>

</html>
