<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LegalSuite Online') }} - @yield('title')</title>

    <link rel="icon" type="image/png" href="/img/favicon.png">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
    <!-- <link href="{{ asset('css/datatables.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables-custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> -->

    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.4.0/gridstack.min.css" /> -->


    @yield('styles')

</head>

<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script>

<body>
    <div id="app">
        <example-component></example-component>
        <transfer-matters :gridstackflag="false"></transfer-matters>
    </div>
    <!-- <script src="{{ asset('js/program.js') }}"></script> -->
    <script src="{{ asset('js/app.js') }}"></script>


    <!-- <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.4.0/gridstack.jQueryUI.min.js'></script> -->


</body>

</html> 