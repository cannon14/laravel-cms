<!DOCTYPE html>

<html ng-app="cccomus">
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

    <link href="/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">

</head>

<body>

<header style="padding:10px">
    <img src="/images/logo.png" alt="Creditcards.com">
</header>

<div class="row">
    <div class="col-lg-24">
        @yield('content')
    </div>
</div>

<footer>
    <div class="row">
        <div class="col-lg-12 text-center">
            Creditcards.com&copy; {{ date('Y') }}
        </div>
    </div>
</footer>

</body>
</html>