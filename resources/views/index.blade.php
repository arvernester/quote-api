@extends('layouts.default')

@push('meta')
    <meta name="title" content="{{ config('app.name') }}" />
    <meta name="description" content="{{ __('Get daily and random inspirational and motivational quotes for your make your life better and happier') }}">
    <meta name="keywords" content="quotes, free quotes, inspirational quotes, motivational quotes, quoets about life">

    <meta property="og:title" content="{{ config('app.name') }}" />
    <meta property="og:description" content="{{ __('Get daily and random inspirational and motivational quotes for your make your life better and happier') }}" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="{{ asset('img/header-'.(app()->getLocale() ?? 'en').'.png') }}" />
@endpush

@section('content')
<!-- Featured Post -->
<article class="post featured">
    <header class="major">
        <span class="date">{{ __('Random Quote') }}</span>
        <p class="body-quote">"{{ $random->text }}"</p>
        <p class="body-author"><a href="{{ route_lang('author.show.slug', $random->author->slug) }}">{{ $random->author->name }}</a>
            @if (! empty($random->source))
                <sup class="quote-source">(<a href="{{ $random->source }}" title="{{ __('Go to source link :url', ['url' => $random->source]) }}" target="_blank">{{ __('Source') }}</a>)</sup>
            @endif
        </p>

        <div class="fb-quote"></div>
    </header>
    <ul class="actions">
        @if (strlen($shareRandomQuote) <= 280)
        <li>
            <a rel="nofollow" href="{{ route('share.twitter', $random) }}" class="button icon special fa-twitter">
                {{ __('Tweet') }}
            </a>
        </li>
        @else
        <li>
            <a rel="nofollow" href="{{ route('share.facebook', $random) }}" class="button icon special fa-facebook">
                Facebook
            </a>
        </li>
        @endif
        <li>
            <button class="button icon fa-copy button-copy" data-clipboard-text="{{ $random->text }} {{ ucwords(__('by')) }} {{ $random->author->name }}.">
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
        <p class="translated body-quote"></p>
        <p class="translate-powered">
            {{ __('Powered by') }} <a href="https://translate.yandex.com/">Yandex Translate</a>.
            {{ __('Thank you') }} <a href="https://www.yandex.com">Yandex</a>!
        </p>
    </header>

    @if (app()->environment('production'))
        <div class="ads">
            @include('layouts.partials.ad')
        </div>
    @endif
</article>

<!-- Posts -->
<section class="posts">
    @foreach ($quotes as $quote)
    <article>
        <header>
            <span class="date">
                {{ $quote->created_at->diffForHumans() }}
            </span>
            <h2>
                <a href="{{ route_lang('author.show.slug', $quote->author->slug) }}">{{ $quote->author->name }}</a>
            </h2>
        </header>
        <p>{{ $quote->text }}</p>
        <ul class="actions">
            <li>
                <a href="{{ route_lang('quote.show.slug', $quote->slug) }}" class="button small">
                    {{ __('See') }}
                </a>
            </li>
            <li>
                <button class="button small special button-copy" data-clipboard-text="{{ $quote->text }} {{ __('By') }} {{ $quote->author->name }}.">
                    {{ __('Copy') }}
                </button>
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

    @if (app()->environment('production'))
        <div class="ad" style="margin-top:20px">
            @include('layouts.partials.ad')
        </div>
    @endif
</footer>
@endsection

@push('css')
<style>
    #translated-quote {
        margin-top:5em;
    }
</style>
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
<script>
    var clipboard = new Clipboard('.button-copy')
    
    $(function(){
        var quote = {!! json_encode($random) !!}
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
                    $('p.translated').text("\"" + data.translated_text + "\"")
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