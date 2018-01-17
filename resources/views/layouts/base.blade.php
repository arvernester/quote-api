<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
	<!--META-->
	<meta charset="utf-8">
	<meta name="csrf-token" value="{{ csrf_token() }}">	
	<meta name="viewport" content="width=device-width initial-scale=1.0">

	<title>{{ config('app.name') }} - Inspirational and Motivational Quotes</title>

	<!--FONT-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,300italic,500,700,600,800' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

	<!--CSS-->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/grid.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.bxslider.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">

</head>

<body>
	<div id="app">
		@include('layouts.partials.header')

        @yield('content')
        
		@include('layouts.partials.footer')
	</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/fixed-responsive-nav.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
	<script src="{{ asset('js/jquery.bxslider.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/waypoints.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>