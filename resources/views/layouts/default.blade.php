<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html lang="{{ app()->getLocale() }}">

<head>
	<title>{{ $title or config('app.name') }}</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="/css/font-awesome.min.css">
	<link rel="stylesheet" href="/css/main.css" />
	<noscript>
		<link rel="stylesheet" href="/css/noscript.css" />
	</noscript>

	@stack('css')
</head>

<body class="is-loading">

	<!-- Wrapper -->
	<div id="wrapper" class="fade-in">

		<!-- Intro -->
		@if(request()->routeIs('index'))
		<div id="intro">
			<h1>{{ __('Quote of the Day') }}</h1>
			<p>{{ $quote->text }}</p>
			<p>
				<strong>
					<a href="#">{{ $quote->author->name }}</a>
				</strong>
			</p>
			<ul class="actions">
				<li>
					<a href="{{ route('share.twitter', $quote) }}" class="button icon fa-twitter special">
						{{ __('Tweet') }}
					</a>
				</li>
				<li>
					<a href="#header" class="button icon fa-arrow-down scrolly">{{ __('Continue') }}</a>
				</li>
			</ul>
		</div>
		@endif

		<!-- Header -->
		<header id="header">
			<a href="{{ route('index', session('lang')) }}" class="logo">
				{{ config('app.name') }}
			</a>
		</header>

		<!-- Nav -->
		<nav id="nav">
			<ul class="links">
				<li class="active">
					<a href="{{ route('index', session('lang')) }}">
						{{ __('Quotes') }}
					</a>
				</li>
			</ul>
			<ul class="icons">
				@if(ENV('TWITTER_USERNAME'))
				<li>
					<a href="https://www.twitter.com/{{ ENV('TWITTER_USERNAME') }}" class="icon fa-twitter">
						<span class="label">Twitter</span>
					</a>
				</li>
				@endif

				@if(ENV('FACEBOOK_USERNAME'))
				<li>
					<a href="https://www.github.com/{{ ENV('FACEBOOK_USERNAME') }}" class="icon fa-facebook">
						<span class="label">Facebook</span>
					</a>
				</li>
				@endif

				@if(ENV('INSTAGRAM_USERNAME'))
				<li>
					<a href="https://www.github.com/{{ ENV('INSTAGRAM_USERNAME') }}" class="icon fa-instagram">
						<span class="label">Instagram</span>
					</a>
				</li>
				@endif

				@if(ENV('GITHUB_USERNAME'))
				<li>
					<a href="https://www.github.com/{{ ENV('GITHUB_USERNAME') }}" class="icon fa-github">
						<span class="label">GitHub</span>
					</a>
				</li>
				@endif
			</ul>
		</nav>

		<!-- Main -->
		<div id="main">

			@yield('content')

		</div>

		<!-- Footer -->
		<footer id="footer">
			<section>
				<form method="post" action="#">
					<div class="field">
						<label for="name">{{ __('Name') }}</label>
						<input type="text" name="name" id="name" />
					</div>
					<div class="field">
						<label for="email">{{ __('Email') }}</label>
						<input type="text" name="email" id="email" />
					</div>
					<div class="field">
						<label for="message">{{ __('Message') }}</label>
						<textarea name="message" id="message" rows="3"></textarea>
					</div>
					<ul class="actions">
						<li>
							<input type="submit" value="{{ __('Send') }}" />
						</li>
					</ul>
				</form>
			</section>
			<section class="split contact">
				<section class="alt">
					<h3>{{ __('Address') }}</h3>
					<p>1234 Somewhere Road #87257
						<br /> Nashville, TN 00000-0000</p>
				</section>
				<section>
					<h3>{{ __('Phone') }}</h3>
					<p>
						<a href="#">(000) 000-0000</a>
					</p>
				</section>
				<section>
					<h3>{{ __('Email') }}</h3>
					<p>
						<a href="#">info@kutip.org</a>
					</p>
				</section>
				<section>
					<h3>{{ __('Social') }}</h3>
					<ul class="icons alt">
						<li>
							<a href="#" class="icon alt fa-twitter">
								<span class="label">Twitter</span>
							</a>
						</li>
						<li>
							<a href="#" class="icon alt fa-facebook">
								<span class="label">Facebook</span>
							</a>
						</li>
						<li>
							<a href="#" class="icon alt fa-instagram">
								<span class="label">Instagram</span>
							</a>
						</li>
						<li>
							<a href="#" class="icon alt fa-github">
								<span class="label">GitHub</span>
							</a>
						</li>
					</ul>
				</section>
			</section>
		</footer>

		<!-- Copyright -->
		<div id="copyright">
			<ul>
				<li>&copy; {{ config('app.name') }}</li>
				<li>{{ __('Design') }}:
					<a href="https://html5up.net">HTML5 UP</a>
				</li>
			</ul>
		</div>

	</div>

	<!-- Scripts -->
	<script src="/js/jquery.min.js"></script>
	<script src="/js/jquery.scrollex.min.js"></script>
	<script src="/js/jquery.scrolly.min.js"></script>
	<script src="/js/skel.min.js"></script>
	<script src="/js/util.js"></script>
	<script src="/js/main.js"></script>

	@stack('js')

</body>

</html>