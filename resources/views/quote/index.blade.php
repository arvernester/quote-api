@extends('layouts.default')

@push('meta')
    <meta name="title" content="{{ config('app.name') }}" />
    <meta name="description" content="{{ $title }}">

    <meta property="og:title" content="{{ config('app.name') }}" />
    <meta property="og:description" content="{{ $title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="{{ asset('img/header-'.(app()->getLocale() ?? 'en').'.png') }}" />
@endpush

@section('content')
<section class="post">
    <header class="major">
        <h1>{{ __('Quotes') }}</h1>
    </header>
</section>

<!-- Posts -->
<section class="posts">
    <div class="fb-quote"></div>
    @foreach ($quotes as $quote)
    <article>
        <header>
            <span class="date">
                {{ $quote->created_at->diffForHumans() }}
            </span>
            <h2>
                <a href="{{ route_lang('author.show', $quote->author) }}">{{ $quote->author->name }}</a>
            </h2>
        </header>
        <p>{{ $quote->text }}</p>
        <ul class="actions">
            <li>
                <a href="{{ route_lang('quote.show', $quote) }}" class="button small">
                    {{ __('See') }}
                </a>
            </li>
        </ul>
    </article>
    @endforeach
</section>

<!-- Footer -->
<footer>
    <a href="{{ $quotes->previousPageUrl() }}" class="button {{ $quotes->previousPageUrl() ? 'special' : '' }}">
        &laquo; {{ __('Previous') }}
    </a>
    <a href="{{ $quotes->nextPageUrl() }}" class="button {{ $quotes->nextPageUrl() ? 'special' : '' }}">
        {{ __('Next') }} &raquo;
    </a>

    @if (!app()->environment('production'))
        <div class="ad" style="margin-top:20px">
            @include('layouts.partials.ad')
        </div>
    @endif
</footer>
@endsection