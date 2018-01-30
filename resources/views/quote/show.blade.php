@extends('layouts.default')

@section('content')
<article class="post featured">
    <header class="major">
        <span class="date">{{ $quote->created_at->diffForHumans() }}</span>
        <h2>
            <a href="#">{{ $quote->author->name }}</a>
        </h2>
        <p>{{ $quote->text }}</p>
        <p>
            <a href="#">{{ $quote->category->name }}</a>
        </p>
    </header>
    <a href="#" class="image main">
        <img src="/images/pic01.jpg" alt="" />
    </a>
    <ul class="actions">
        <li>
            <a href="{{ route('share.twitter', $quote) }}" class="button icon special fa-twitter">
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
@endsection