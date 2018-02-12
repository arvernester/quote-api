@extends('layouts.default')

@section('content')
<article class="post featured">
    <header class="major">
        <span class="date">
            {{ __('Author') }}
        </span>
        <h1>{{ $author->name }}</h1>
    </header>

    <div class="ads">
        @include('layouts.partials.ad')
    </div>
</article>

<article class="post">
    <h3>{{ __('Quote by :author', ['author' => $author->name]) }}</h3>
    @foreach ($author->quotes as $quote)
        <div class="box">{{ $quote->text }}</div>
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