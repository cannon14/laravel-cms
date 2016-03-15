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
    <link href="/vendor/ng-table/dist/ng-table.min.css" rel="stylesheet" type="text/css">
    <link href="/vendor/angular-ui-tree/dist/angular-ui-tree.min.css" rel="stylesheet" type="text/css">
    <link href="/vendor/pnotify/src/pnotify.core.min.css" rel="stylesheet" type="text/css">
    <link href="/vendor/CodeMirror/lib/codemirror.css" rel="stylesheet" type="text/css">
    <link href="/vendor/CodeMirror/theme/blackboard.css" rel="stylesheet" type="text/css">

    <link href="/css/app/global.css" rel="stylesheet" type="text/css">
    @yield('styles')

</head>

<body>

<header>
    @if (Auth::check())
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('admin/dashboard') }}"><img src="/images/logo.png" alt="Creditcards.com" width="75%"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{ url('admin/dashboard') }}">Dashboard <span class="sr-only">(current)</span></a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Templates <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/templates') }}">View Templates</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Content Blocks <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/content-blocks') }}">View Content Blocks</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('admin/content-blocks/create') }}">Add Content Block</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pages <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/pages') }}">Dynamic Pages</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('admin/static/pages') }}">Static Pages</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/categories') }}">View Categories</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('admin/categories/create') }}">Add Category</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cards <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/cards') }}">View Cards</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Issuers <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/issuers') }}">View Issuers</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('admin/issuers/create') }}">Add Issuer</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reviews <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/reviews/products') }}">By Product</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('admin/reviews/issuers') }}">By Issuer</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('admin/reviews/maps') }}">Product ID Map</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('admin/reviews/parsers') }}">Parsers</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('admin/reviews/upload') }}">Upload Reviews</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Feeds <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/feeds') }}">View Feeds</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Media <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/media') }}">View Media</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('admin/media/upload') }}">Upload Media</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('http://cccomus.wp.davidc.in.creditcards.com/wp-admin/') }}"><img src="/images/wp-icon.png"> Wordpress</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/users') }}">View Users</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('admin/users/create') }}">Add User</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('admin/help') }}">Help</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if (Auth::check())
                                <li><a href="{{url('admin/logout')}}">Logout</a></li>
                            @else
                                <li><a href="{{url('admin/login')}}">Login</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    @endif
</header>

<div class="row">
    <div class="col-lg-12">
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

<script src="/vendor/jquery/dist/jquery.min.js" ></script>
<script src="/vendor/bootstrap/dist/js/bootstrap.min.js" ></script>
<script src="/vendor/angular/angular.min.js" ></script>
<script src="/vendor/angular-resource/angular-resource.min.js"></script>
<script src="/vendor/angular-route/angular-route.min.js"></script>
<script src="/vendor/ng-table/dist/ng-table.min.js" ></script>
<script src="/vendor/angular-sanitize/angular-sanitize.min.js"></script>
<script src="/vendor/angular-ui-tree/dist/angular-ui-tree.min.js"></script>
<script src="/vendor/pnotify/src/pnotify.core.min.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/styles.js"></script>
<script src="/vendor/CodeMirror/lib/codemirror.js"></script>
<script src="/vendor/CodeMirror/mode/php/php.js"></script>
<script src="/vendor/CodeMirror/mode/xml/xml.js"></script>
<script src="/vendor/CodeMirror/mode/css/css.js"></script>
<script src="/vendor/CodeMirror/mode/clike/clike.js"></script>
<script src="/vendor/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="/vendor/CodeMirror/mode/javascript/javascript.js"></script>

<script src="/js/app/app.js"></script>
<script src="/js/app/filters/filters.js"></script>
<script src="/js/app/services/utilities.js"></script>

@yield('scripts')

</body>
</html>