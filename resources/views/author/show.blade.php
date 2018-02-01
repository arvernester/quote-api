@extends('layouts.default')

@section('content')
<article class="post featured">
    <header class="major">
        <span class="date">
            {{ __('Author') }}
        </span>
        <h2>{{ $author->name }}</a></h2>
    </header>

    <div class="ads">
        @include('layouts.partials.ad')
    </div>
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