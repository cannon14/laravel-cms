<!DOCTYPE html>
<html>
<head>
    <title>Creditcards.com User Reviews Manager</title>
    <meta charset="UTF-8">
    <meta name="application-name" content="Widget Factory">
    <meta name="description" content="Application for making and deploying custom widgets">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="author" content="CreditCards.com">
    <meta name="copyright" content="Copyright <?= date("Y"); ?> CreditCards.com">

<!-- CSS Style -->
    <link href="{!! asset('/css/application.css') !!}" rel="stylesheet">

</head>

<body>
<div class="container">
<div class="row">
<div class="col-lg-2 logo">
<a href='/'><img src='{!! URL::to('images/cccom_logo.gif') !!}' alt='Creditcards.com'></a>
</div>
<div class="col-lg-8 text-center">
<h1>Review Manager</h1>
</div>
</div>

<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="nav navbar-nav">
                <li>{!! link_to('/', 'Upload Reviews') !!}</li>
                <li>{!! link_to('issuers', 'Issuers') !!}</li>
                <li>{!! link_to('products', 'Products') !!}</li>
                <li>{!! link_to('users', 'Users') !!}</li>
                <li>{!! link_to('help', 'Help') !!}</li>
                <li>{!! link_to('admin', 'Administration') !!}</li>
                <li>{!! link_to('logout', 'Logout') !!}</li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->

</nav>

@if (Session::has('success'))
    <div class="alert alert-success text-center">{!!Session::get('success')!!}</div>
@elseif(Session::has('error'))
    <div class="alert alert-danger text-center">{!!Session::get('error')!!}</div>
@endif

@if(Session::has('errors'))
    <div class="alert alert-danger text-center">
        @foreach ($errors->all('<li>:message</li>') as $message)
            {!!$message!!}
        @endforeach
    </div>
@endif

@yield('content')

<footer>
<div class="row">
    <div class="col-lg-12 text-center">
        <p>Copyright&copy {!! link_to('http://www.creditcards.com', 'Creditcards.com') !!} 2014</p>
    </div>
</div>
</footer>
</div><!--container-->

<!-- Scripts -->
<script src="{!! url('/assets/js/vendor/jquery/jquery.min.js') !!}"></script>
<script src="{!! url('/assets/js/vendor/jquery-ui/jquery-ui.js') !!}"></script>
<script src="{!! url('/assets/js/vendor/bootstrap/bootstrap.min.js') !!}"></script>
<script src="{!! url('/assets/js/vendor/highcharts/highcharts.js') !!}"></script>
<script src="{!! url('/assets/js/vendor/datatables/jquery.dataTables.min.js') !!}"></script>
<script src="{!! url('/assets/js/vendor/tinymce/tinymce.jquery.min.js') !!}"></script>
<script src="{!! url('/assets/js/vendor/tinymce/theme.min.js') !!}"></script>
<script src="{!! url('/assets/js/app/app.js') !!}"></script>


@yield('scripts');

</body>
</html>
