<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('lumino/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lumino/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lumino/css/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('lumino/css/styles.css') }}" rel="stylesheet">

    @stack('css')

    <!--Custom Font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
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
                    @include('layouts.partials.notification')
                </ul>
            </div>
        </div>
        <!-- /.container-fluid -->
    </nav>
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <div class="profile-sidebar">

            <div class="profile-usertitle">
                <div class="profile-usertitle-name">
                    <a href="#">{{ __('Profile') }}</a>
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
                <input value="{{ request('keyword') }}" name="keyword" type="text" class="form-control">
            </div>
        </form>
        <ul class="nav menu">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : ''  }}">
                <a href="{{ route_lang('admin.dashboard') }}">
                    <em class="fa fa-dashboard">&nbsp;</em> {{ __('Dashboard') }}</a>
            </li>
            <li class="{{ request()->routeIs('admin.banner.*') ? 'active' : '' }}">
                <a href="{{ route_lang('admin.banner.index') }}">
                    <em class="fa fa-picture-o">&nbsp;</em> {{ __('Banner') }}</a>
            </li>
            <li class="{{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
                <a href="{{ route_lang('admin.category.index') }}">
                    <em class="fa fa-th">&nbsp;</em> {{ __('Category') }}</a>
            </li>
            <li class="{{ request()->routeIs('admin.author.*') ? 'active' : '' }}">
                <a href="{{ route_lang('admin.author.index') }}">
                    <em class="fa fa-users">&nbsp;</em> {{ __('Author') }}
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.quote.*') ? 'active' : '' }}">
                <a href="{{ route_lang('admin.quote.index') }}">
                    <em class="fa fa-quote-right">&nbsp;</em> {{ __('Quote') }}</a>
            </li>
            <li class="parent">
                <a data-toggle="collapse" href="#misc">
                    <em class="fa fa-snowflake-o">&nbsp;</em> {{ __('Miscellaneous') }}
                    <span data-toggle="collapse" href="#misc" class="icon pull-right">
                        <em class="fa fa-plus"></em>
                    </span>
                </a>
                <ul class="children collapse" id="misc">
                    <li>
                        <a href="{{ route_lang('admin.user.index') }}">
                            <span class="fa fa-users">&nbsp;</span> {{ __('User') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route_lang('admin.country.index') }}">
                            <span class="fa fa-globe">&nbsp;</span> {{ __('Country') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route_lang('admin.language.index') }}">
                            <span class="fa fa-language">&nbsp;</span> {{ __('Language') }}
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <em class="fa fa-power-off">&nbsp;</em> {{ __('Logout') }}</a>
            </li>
        </ul>
    </div>
    <!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            {!! Breadcrumbs::render() !!}
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
            <p class="back-link">Lumino Theme {{ __('by') }}
                <a href="https://www.medialoot.com">Medialoot</a>
            </p>
        </div>
    </div>
    <!-- /.row -->

    <script src="{{ asset('lumino/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('lumino/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lumino/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('lumino/js/custom.js') }}"></script>

    @stack('js')

</body>

</html>