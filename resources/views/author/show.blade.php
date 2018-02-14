@extends('layouts.default')

@push('meta')
    <meta name="title" content="{{ $author->name }}" />
    @if (! empty($description))
    <meta name="description" content="{{ $description }}">
    @endif

    <meta property="og:title" content="{{ $author->name }}" />
    @if (! empty($description))
    <meta property="og:description" content="{{ $description }}">
    @endif
    <meta property="og:type" content="article" />
@endpush

@section('content')
<article class="post featured">
    <header class="major">
        <span class="date">
            {{ __('Author') }}
        </span>
        <h1>{{ $author->name }}</h1>
        @if (! empty($description))
            <p>{{ $description }}</p>
        @endif

        @if (! empty($url))
            <ul class="actions">
                <li>
                    <a href="{{ $url }}" class="button icon fa-wikipedia">{{ __('Full Profile') }}</a>
                </li>
            </ul>
        @endif
    </header>

    <div class="ads">
        @include('layouts.partials.ad')
    </div>
</article>

<article class="post">
    <h3>{{ __('Quote by :author', ['author' => $author->name]) }}</h3>
    
    @foreach ($author->quotes as $quote)
    <div class="fb-quote" data-href="{{ route_lang('quote.show', $quote) }}"></div>
        <div class="box">
            {{ $quote->text }}
        </div>
    @endforeach
</article>
@endsection

@push('schema')
<script type="application/ld+json">
    {!! json_encode([
        '@context' => 'http://schema.org',
        '@type' => 'Person',
        'name' => $author->name
    ]) !!}
</script>
@endpush