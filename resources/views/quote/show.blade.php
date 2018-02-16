@extends('layouts.default')

@push('meta')
    <meta name="title" content="{{ __('Quote by :author', ['author' => $quote->author->name]) }}" />
    <meta name="description" content="{{ $quote->text }}">

    <meta property="og:title" content="{{ __('Quote by :author', ['author' => $quote->author->name]) }}" />
    <meta property="og:description" content="{{ $quote->text }}" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="{{ route('quote.poster', $quote->slug) }}" />
    <meta property="og:image:height" content="400">
    <meta property="og:image:width" content="600">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ '@' . env('TWITTER_USERNAME') }}">
    <meta name="twitter:creator" content="{{ '@' . env('TWITTER_USERNAME') }}">
    <meta name="twitter:title" content="{{ __('Quote by :author', ['author' => $quote->author->name]) }}">
    <meta name="twitter:description" content="{{ $quote->text }}">
    <meta name="twitter:image" content="{{ route('quote.poster', $quote->slug) }}">
@endpush

@section('content')
<article class="post featured">
    <header class="major">
        <span class="date">
            <a href="#">{{ $quote->category->name }}</a>
        </span>
        <h2>
            <a href="{{ route_lang('author.show.slug', $quote->author->slug) }}">{{ $quote->author->name }}</a>
        </h2>
        <p>{{ $quote->text }}</p>
        <div class="fb-quote"></div>
    </header>
    <ul class="actions">
        @if (strlen($shareQuote) <= 280)
        <li>
            <a rel="nofollow" href="{{ route('share.twitter', $quote) }}" class="button icon special fa-twitter">
                {{ __('Tweet') }}
            </a>
        </li>
        @else
        <li>
            <a rel="nofollow" href="{{ route('share.facebook', $quote) }}" class="button icon special fa-facebook">
                Facebook
            </a>
        </li>
        @endif
        <li>
            <button class="button icon fa-copy button-copy" data-clipboard-text="{{ $quote->text }} {{ ucwords(__('by')) }} {{ $quote->author->name }}.">
                {{ __('Copy') }}
            </button>
        </li>
        @if (! empty($language))
        <li>
            <button id="button-translate" class="button icon fa-flag">{{ __('Translate to') }} {{ $language->native_name }}</button>
        </li>
        @endif
    </ul>

    <header class="major" id="translated-quote">
        <span class="date">
            {{ __('Translated Quote') }}
        </span>
        <p class="translated"></p>
        <p class="translate-powered">
            {{ __('Powered by') }} <a href="https://translate.yandex.com/">Yandex Translate</a>.
            {{ __('Thank you') }} <a href="https://www.yandex.com">Yandex</a>!
        </p>
    </header>

    <div class="ads">
        @include('layouts.partials.ad')
    </div>
</article>

<div class="post image-center">
    <h2>{{ __('Quote Poster') }}</h2>
    <img class="image fit" src="{{ route('quote.poster', $quote->slug) }}" alt="{{ __('Quote by :author', ['author' => $quote->author->name]) }}">
</div>
@endsection

@push('css')
<style>
    #translated-quote {
        margin-top:5em;
    }
</style>
@endpush

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'http://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'item' => [
                'id' => route_lang('index'),
                'name' => __('Quote')
            ]
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'item' => [
                'id' => url()->current(),
                'name' => __('Quote by :author', ['author' => $quote->author->name])
            ]
        ]
    ]
]) !!}

{!! json_encode([
    '@context' => 'http://schema.org',
    '@type' => 'Person',
    'name' => $quote->author->name
]) !!}
    
{!! json_encode([
    '@context' => 'http://schema.org/',
    '@type' => 'Quotation',
    'spokenByCharacter' => [
        '@type' => 'Person',
        'name' => $quote->author->name
    ],
    'text' => $quote->text
]) !!}
</script>
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
<script>
    var clipboard = new Clipboard('.button-copy')
    $(function(){
        var quote = {!! json_encode($quote) !!}
        var token = $('meta[name=csrf-token]').attr('content')
        var defaultButtonLabel = $('#button-translate').text()
        var translatingLabel = '{{ __('Translating') }}'

        $('header#translated-quote').hide()

        $('#button-translate').click(function(){
            $('header#translated-quote').hide()
            $('#button-translate').text(translatingLabel + '...')

            $.ajax({
                url: '{{ route('translation.translate') }}',
                method: 'POST',
                dataType: 'json',
                data: {
                    _token: token,
                    quote_id: quote.id,
                    source: quote.language.code_alternate,
                    destination: '{{ $language->code_alternate ?? '' }}',
                    text: quote.text
                },
                success: function(data) {
                    $('#button-translate').text(defaultButtonLabel)
                    $('header#translated-quote').show()
                    $('p.translated').text(data.translated_text)
                },
                error: function() {
                    $('#button-translate').text(defaultButtonLabel)
                    $('header#translated-quote').hide()
                }
            })
        })
    })
</script>
@endpush