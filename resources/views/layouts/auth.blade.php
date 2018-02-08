<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex">
	<title>{{ config('app.name') }}</title>
	
	<link href="{{ asset('lumino/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('lumino/css/datepicker3.css') }}" rel="stylesheet">
	<link href="{{ asset('lumino/css/styles.css') }}" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="{{ asset('lumino/js/html5shiv.js') }}"></script>
	<script src="{{ asset('lumino/js/respond.min.js') }}"></script>
	<![endif]-->
</head>

<body>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			@yield('content')
		</div>
		<!-- /.col-->
	</div>
	<!-- /.row -->

	<script src="{{ asset('lumino/js/jquery-1.11.1.min.js') }}"></script>
	<script src="{{ asset('lumino/js/bootstrap.min.js') }}"></script>
</body>

</html>