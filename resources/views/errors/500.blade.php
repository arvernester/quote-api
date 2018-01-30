@extends('layouts.exception')

@section('content')
<h1>{{ $exception->getStatusCode() }}</h1>
<div class="title">
    {{ $exception->getMessage() }}
</div>
@endsection