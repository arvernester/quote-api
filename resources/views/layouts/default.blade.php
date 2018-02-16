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
	<meta name="theme-color" content="#212931">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	@if (env('FACEBOOK_APP_ID'))
	<meta property="fb:app_id" content="{{ env('FACEBOOK_APP_ID') }}">
	@endif
	<meta property="og:site_name" content="{{ config('app.name') }}">
	<meta property="og:locale" content="{{ app()->getLocale() ?? config('app.locale') }}">
    <meta property="og:url" content="{{ url()->current() }}">
	@stack('meta')

	<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/main.min.css') }}" />
	<noscript>
		<link rel="stylesheet" href="{{ asset('css/noscript.css') }}" />
	</noscript>

	<link rel="alternate" href="{{ route_lang('index') }}" hreflang="{{ app()->getLocale() }}" />

	@stack('css')
</head>

<body class="">

	<!-- Wrapper -->
	<div id="wrapper" class="fade-in">

		<!-- Intro -->
		@if(request()->routeIs('index'))
		<div id="intro" class="fb-quotable">
			<h1>{{ __('Quote of the Day') }}</h1>
			<p>{{ $today->text }}</p>
			<div class="fb-quote"></div>
			<p>
				<strong>
					<a href="{{ route_lang('author.show.slug', $today->author->slug) }}">{{ $today->author->name }}</a>
				</strong>
			</p>
			<ul class="actions">
				@if(strlen($shareTodayQuote) <= 280)
				<li>
					<a rel="nofollow" title="{{ __('Share to Twitter') }}" href="{{ route('share.twitter', $today) }}" class="button icon fa-twitter special">
						{{ __('Tweet') }}
					</a>
				</li>
				@else
				<li>
					<a rel="nofollow" href="{{ route('share.facebook', $today) }}" class="button icon special fa-facebook">
						Facebook
					</a>
				</li>
				@endif
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
				<li class="{{ request()->routeIs('index') ? 'active' : '' }}">
					<a href="{{ route_lang('index') }}">
						{{ __('Homepage') }}
					</a>
				</li>
				<li class="{{ request()->routeIs('quote.index') ? 'active' : '' }}">
					<a href="{{ route_lang('quote.index') }}">
						{{ __('Quotes') }}
					</a>
				</li>
				<li class="{{ request()->routeIs('quote.random') ? 'active' : '' }}">
					<a href="{{ route_lang('quote.random') }}">
						{{ __('Random') }}
					</a>
				</li>
				<li class="{{ request()->routeIs('quote.create') ? 'active' : '' }}">
					<a href="{{ route_lang('quote.create') }}">
						{{ __('Submit Quote') }}
					</a>
				</li>
				<li class="{{ request()->routeIs('category.*') ? 'active' : '' }}">
					<a href="{{ route_lang('category.index') }}">
						{{ __('Category') }}
					</a>
				</li>
			</ul>
			<ul class="icons">
				@if(env('TWITTER_USERNAME'))
				<li>
					<a href="https://www.twitter.com/{{ env('TWITTER_USERNAME') }}" class="icon fa-twitter" title="{{ __('Twitter profile') }}">
						<span class="label">Twitter</span>
					</a>
				</li>
				@endif

				@if(env('FACEBOOK_USERNAME'))
				<li>
					<a href="https://www.facebook.com/{{ env('FACEBOOK_USERNAME') }}" class="icon fa-facebook" title="{{ __('Facebook page') }}">
						<span class="label">Facebook</span>
					</a>
				</li>
				@endif

				@if(env('INSTAGRAM_USERNAME'))
				<li>
					<a href="https://www.github.com/{{ env('INSTAGRAM_USERNAME') }}" class="icon fa-instagram" title="{{ __('Instagram profile') }}">
						<span class="label">Instagram</span>
					</a>
				</li>
				@endif

				@if(env('GITHUB_USERNAME'))
				<li>
					<a href="https://www.github.com/{{ env('GITHUB_USERNAME') }}" class="icon fa-git" title="{{ __('Git repository') }}">
						<span class="label">Git</span>
					</a>
				</li>
				@endif

				<li>
					<a href="{{ route_lang('quote.feed') }}" class="icon fa-rss" title="{{ __('JSON Feed') }}">
						<span class="label">{{ __('JSON Feed') }}</span>
					</a>
				</li>
				
				<li>
					<a href="{{ route('api') }}" class="icon fa-random" title="{{ __('API service') }}">
						<span class="label">{{ __('API service') }}</span>
					</a>
				</li>
			</ul>
		</nav>

		<!-- Main -->
		<div id="main">

			@yield('content')

		</div>

		<!-- Footer -->
		<footer id="footer">
			<contact-form></contact-form>
			<section class="split contact">
				<section>
					<h3>{{ __('Email') }}</h3>
					<p>
						<a href="mailto:mail@kutip.org">mail@kutip.org</a>
					</p>
				</section>
				<section>
					<h3>{{ __('Social') }}</h3>
					<ul class="icons alt">
						@if(env('TWITTER_USERNAME'))
						<li>
							<a href="https://www.twitter.com/{{ env('TWITTER_USERNAME') }}" class="icon fa-twitter" title="{{ __('Twitter profile') }}">
								<span class="label">Twitter</span>
							</a>
						</li>
						@endif

						@if(env('FACEBOOK_USERNAME'))
						<li>
							<a href="https://www.facebook.com/{{ env('FACEBOOK_USERNAME') }}" class="icon fa-facebook" title="{{ __('Facebook page') }}">
								<span class="label">Facebook</span>
							</a>
						</li>
						@endif

						@if(env('INSTAGRAM_USERNAME'))
						<li>
							<a href="https://www.github.com/{{ env('INSTAGRAM_USERNAME') }}" class="icon fa-instagram" title="{{ __('Instagram profile') }}">
								<span class="label">Instagram</span>
							</a>
						</li>
						@endif

						@if(env('GITHUB_USERNAME'))
						<li>
							<a href="https://www.github.com/{{ env('GITHUB_USERNAME') }}" class="icon fa-git" title="{{ __('Git repository') }}">
								<span class="label">Git</span>
							</a>
						</li>
						@endif

						<li>
							<a href="{{ route_lang('quote.feed') }}" class="icon fa-rss" title="{{ __('JSON Feed') }}">
								<span class="label">{{ __('JSON Feed') }}</span>
							</a>
						</li>

						<li>
							<a href="{{ route('api') }}" class="icon fa-random" title="{{ __('API service') }}">
								<span class="label">{{ __('API service') }}</span>
							</a>
						</li>
					</ul>
				</section>
				<section>
					<h3>{{ __('Language') }}</h3>
					<p>
						@foreach ($langs as $lang)
							@if (session('lang') == $lang->code_alternate)
								{{ $lang->name }} ({{ $lang->code_alternate }}) <em class="fa fa-check fa-fw">&nbsp;</em> <br>
							@else
								<a href="{{ route('index', $lang->code_alternate) }}">
									{{ $lang->name }} ({{ $lang->code_alternate }}) <br>
								</a>
							@endif
						@endforeach
					</p>
				</section>
			</section>
		</footer>

		<!-- Copyright -->
		<div id="copyright">
			<ul>
				<li><em class="fa fa-copyright"></em> {{ config('app.name') }}</li>
				<li>{{ __('Design') }}:
					<a href="https://html5up.net">HTML5 UP</a>
				</li>
			</ul>
		</div>

	</div>

	<!-- Scripts -->
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/lang.js') }}"></script>
	<script src="{{ asset('js/jquery.scrollex.min.js') }}"></script>
	<script src="{{ asset('js/jquery.scrolly.min.js') }}"></script>
	<script src="{{ asset('js/skel.min.js') }}"></script>
	<script src="{{ asset('js/util.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>

	@stack('js')

	@include('layouts.partials.google-analytic')

	<script type="application/ld+json">
		{!! json_encode([
			'@context' => 'http://schema.org',
			'@type' => 'Organization',
			'url' => route('index'),
			'logo' => asset('img/logo.png')
		]) !!}
	</script>

	<script type="application/ld+json">
		{!! json_encode([
			'@context' => 'http://schema.org',
			'@type' => 'Person',
			'name' => config('app.name'),
			'url' => route('index'),
			'sameAs' => [
				'https://www.twitter.com/'.env('TWITTER_USERNAME')
			]
		]) !!}
	</script>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	@stack('schema')

</body>

</html>