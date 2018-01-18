<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('lumino/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lumino/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lumino/css/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('lumino/css/styles.css') }}" rel="stylesheet">

    @stack('css')

    <!--Custom Font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!--[if lt IE 9]>
	<script src="{{ asset('lumino/js/html5shiv.js') }}"></script>
	<script src="{{ asset('lumino/js/respond.min.js') }}"></script>
	<![endif]-->
</head>

<body>
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/" target="_blank">
                    <span>{{ config('app.name') }}</span>
                </a>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <em class="fa fa-envelope"></em>
                            <span class="label label-danger">15</span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="http://placehold.it/40/30a5ff/fff">
                                    </a>
                                    <div class="message-body">
                                        <small class="pull-right">3 mins ago</small>
                                        <a href="#">
                                            <strong>John Doe</strong> commented on
                                            <strong>your photo</strong>.</a>
                                        <br />
                                        <small class="text-muted">1:24 pm - 25/03/2015</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="http://placehold.it/40/30a5ff/fff">
                                    </a>
                                    <div class="message-body">
                                        <small class="pull-right">1 hour ago</small>
                                        <a href="#">New message from
                                            <strong>Jane Doe</strong>.</a>
                                        <br />
                                        <small class="text-muted">12:27 pm - 25/03/2015</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="all-button">
                                    <a href="#">
                                        <em class="fa fa-inbox"></em>
                                        <strong>All Messages</strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <em class="fa fa-bell"></em>
                            <span class="label label-info">5</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="#">
                                    <div>
                                        <em class="fa fa-envelope"></em> 1 New Message
                                        <span class="pull-right text-muted small">3 mins ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <em class="fa fa-heart"></em> 12 New Likes
                                        <span class="pull-right text-muted small">4 mins ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <em class="fa fa-user"></em> 5 New Followers
                                        <span class="pull-right text-muted small">4 mins ago</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.container-fluid -->
    </nav>
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <div class="profile-sidebar">

            <div class="profile-usertitle">
                <div class="profile-usertitle-name">
                    <a href="#">Profile</a>
                </div>
                <div class="profile-usertitle-status">
                    <span class="indicator label-success"></span>{{ auth()->user()->name }}
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>
        <form role="search" action="{{ url()->current() }}">
            <div class="form-group">
                <input value="{{ request('keyword') }}" name="keyword" type="text" class="form-control" placeholder="Search">
            </div>
        </form>
        <ul class="nav menu">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : ''  }}">
                <a href="{{ route('admin.dashboard') }}">
                    <em class="fa fa-dashboard">&nbsp;</em> Dashboard</a>
            </li>
            <li class="{{ request()->routeIs('admin.banner.*') ? 'active' : '' }}">
                <a href="{{ route('admin.banner.index') }}">
                    <em class="fa fa-picture-o">&nbsp;</em> Banner</a>
            </li>
            <li class="{{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
                <a href="{{ route('admin.category.index') }}">
                    <em class="fa fa-th">&nbsp;</em> Category</a>
            </li>
            <li class="{{ request()->routeIs('admin.author.*') ? 'active' : '' }}">
                <a href="{{ route('admin.author.index') }}">
                    <em class="fa fa-users">&nbsp;</em> Author
                </a>
            </li>
            <li class="parent {{ request()->routeIs('admin.quote.*') ? 'active' : '' }}">
                <a data-toggle="collapse" href="#sub-item-1">
                    <em class="fa fa-quote-right">&nbsp;</em> Quotes
                    <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right">
                        <em class="fa fa-plus"></em>
                    </span>
                </a>
                <ul class="children collapse" id="sub-item-1">
                    <li>
                        <a href="{{ route('admin.quote.index') }}">
                            <span class="fa fa-arrow-right">&nbsp;</span> All
                        </a>
                    </li>
                </ul>
            </li>
            <li class="parent">
                <a data-toggle="collapse" href="#misc">
                    <em class="fa fa-snowflake-o">&nbsp;</em> Miscellaneous
                    <span data-toggle="collapse" href="#misc" class="icon pull-right">
                        <em class="fa fa-plus"></em>
                    </span>
                </a>
                <ul class="children collapse" id="misc">
                    <li>
                        <a href="{{ route('admin.user.index') }}">
                            <span class="fa fa-users">&nbsp;</span> Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.country.index') }}">
                            <span class="fa fa-globe">&nbsp;</span> Country
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.language.index') }}">
                            <span class="fa fa-language">&nbsp;</span> Language
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <em class="fa fa-power-off">&nbsp;</em> Logout</a>
            </li>
        </ul>
    </div>
    <!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li>
                    <a href="#">
                        <em class="fa fa-home"></em>
                    </a>
                </li>
            </ol>
        </div>
        <!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ $title or null }}</h1>
            </div>
        </div>
        <!--/.row-->

        @yield('content')

        <!-- /.col-->
        <div class="col-sm-12">
            <p class="back-link">Lumino Theme by
                <a href="https://www.medialoot.com">Medialoot</a>
            </p>
        </div>
    </div>
    <!-- /.row -->

    <script src="{{ asset('lumino/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('lumino/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lumino/js/custom.js') }}"></script>

    @stack('js')

</body>

</html>