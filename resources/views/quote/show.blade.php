@extends('layouts.admin')

@section('content')
@include('layouts.partials.flash')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Quote Detail</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="lang">Language</label>
                    <p class="form-control-static">
                        {{ $quote->language->name }} - {{ $quote->language->native_name }}
                        <span class="label label-info">{{ $quote->language->code }}</span>
                    </p>
                </div>

                <div class="form-group">
                    <label for="lang">Quote</label>
                    <p class="form-control-static">
                        {{ $quote->text }}

                        <div class="actions">
                            <a title="Share to Twitter" href="{{ route('share.twitter', $quote) }}" class="btn btn-xs btn-primary">
                                <em class="fa fa-twitter fa-fw"></em>
                            </a>
                        </div>
                    </p>
                </div>

                <div class="form-group">
                    <label for="author">Author</label>
                    <p class="form-control-static">
                        <a href="{{ route('admin.author.show', $quote->author) }}">
                            {{ $quote->author->name }}
                        </a>
                    </p>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <p class="form-control-static">
                        <a href="{{ route('admin.category.show', $quote->category) }}">
                            {{ $quote->category->name }}
                        </a>
                    </p>
                </div>

                @if ($quote->user)
                    <div class="form-group">
                        <label for="category">User</label>
                        <p class="form-control-static">
                            <a href="{{ route('admin.user.show', $quote->user) }}">
                                {{ $quote->user->name }}
                            </a>
                        </p>
                    </div>
                @endif

                @if ($quote->source)
                    <div class="form-group">
                        <label for="source">Source</label>
                        <p class="form-control-static">
                            {{ $quote->source }}
                        </p>
                    </div>
                @endif

                <div class="form-group">
                    <label for="created">Created</label>
                    <p class="form-control-static">
                        {{ $quote->created_at->diffForHumans() }}
                    </p>
                </div>

                <div class="form-group">
                    <label for="updated">Updated</label>
                    <p class="form-control-static">
                        {{ $quote->updated_at->diffForHumans() }}
                    </p>
                </div>

                <a href="{{ route('admin.quote.index') }}" class="btn btn-default">Back</a>
                <a href="{{ route('admin.quote.edit', $quote) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('admin.quote.edit', $quote) }}" class="btn btn-danger delete">Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection