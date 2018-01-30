@extends('layouts.default')

@section('content')
<!-- Featured Post -->
<article class="post featured">
    <header class="major">
        <span class="date">{{ __('Random Quote') }}</span>
        <h2>
            <a href="#">{{ $random->author->name }}</a>
        </h2>
        <p>{{ $random->text }}</p>
    </header>
    <a href="#" class="image main">
        <img src="/images/pic01.jpg" alt="" />
    </a>
    <ul class="actions">
        <li>
            <a href="{{ route('share.twitter', $random) }}" class="button icon special fa-twitter">
                {{ __('Tweet') }}
            </a>
        </li>
        <li>
            <a href="#" class="button icon fa-copy">
                {{ __('Copy') }}
            </a>
        </li>

    </ul>

    <div class="ads">
        @include('layouts.partials.ad')
    </div>
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
                <a href="#">{{ $quote->author->name }}</a>
            </h2>
        </header>
        <a href="#" class="image fit">
            <img src="images/pic02.jpg" alt="" />
        </a>
        <p>{{ $quote->text }}</p>
        <ul class="actions">
            <li>
                <a href="{{ route('quote.show', [session('lang'), $quote]) }}" class="button small">
                    {{ __('See') }}
                </a>
            </li>
        </ul>
    </article>
    @endforeach
</section>

<!-- Footer -->
<footer>
    {{ $quotes->links() }}
</footer>
@endsection