<?php
/**
 * Name: Master Layout
 * Type: layouts
 * Description: Master Layout Template
 * Version: 1.0.0
 * Date: 2015-11-20
 */
?>
<!DOCTYPE html>

<html>
<head>

    <title>Creditcards.com - @yield('title')</title>

    <meta charset="UTF-8">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="CreditCards.com">
    <meta http-equiv="Pragma" content="no-cache">
    <meta name="Robots" content="ALL">
    <meta name="revisit-after" content="10 days">
    <meta name="resource-type" content="document">
    <meta name="distribution" content="global">
    <meta name="author" content="CreditCards.com">
    <meta name="copyright" content="Copyright <?= date("Y"); ?> CreditCards.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="/css/css.css" rel="stylesheet" type="text/css">
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="/css/cc-override.css" rel="stylesheet" type="text/css">
    <link href="/css/cc-global.css" rel="stylesheet" type="text/css">
    <link href="/css/cc-card-category.css" rel="stylesheet" type="text/css">
    <link href="/css/search.css" rel="stylesheet" type="text/css">
    <link href="https://plus.google.com/110595907088556510376" rel="publisher">
    <link href="/css/cc-home.css" rel="stylesheet">
    <link href="/css/cc-misc.css" rel="stylesheet" type="text/css">
    @yield('styles')

    <script src="/vendor/jquery/dist/jquery.min.js" ></script>
    <script src="/vendor/bootstrap/dist/js/bootstrap.min.js" ></script>
    <script src="/vendor/jquery-ui/jquery-ui.js"></script>
    <script src="/js/application_scripts.js"></script>
    <script src="/vendor/jquery.sticky.js" ></script>

    @yield('scripts')

</head>

<body>


    @include('cccomus.templates.partials.includes.header')

    @yield('content')

    @include('cccomus.templates.partials.includes.footer')


</body>
</html>