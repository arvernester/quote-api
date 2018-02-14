@extends('layouts.admin')

@section('content')
@include('layouts.partials.flash')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-container">
            <div class="panel-body">

                <div class="form-group">
                    <label for="permalink">{{ __('Permalink') }}</label>
                    <p class="form-control-static">
                        <a href="{{ route_lang('quote.show.slug', $quote->slug) }}">{{ route_lang('quote.show.slug', $quote->slug) }}</a>
                    </p>
                </div>

                <div class="form-group">
                    <label for="lang">{{ __('Language') }}</label>
                    <p class="form-control-static">
                        {{ $quote->language->name }} ({{ $quote->language->native_name }})
                        <span class="label label-info">{{ $quote->language->code_alternate }}</span>
                    </p>
                </div>

                <div class="form-group">
                    <label for="lang">{{ __('Quote') }}</label>
                    <p class="form-control-static">
                        {{ $quote->text }}

                        <div class="actions">
                            <a title="Share to Twitter" href="{{ route('share.twitter', $quote) }}" class="btn btn-xs btn-primary">
                                <em class="fa fa-twitter fa-fw"></em>
                            </a>
                            
                            <a title="Share to Facebook" href="{{ route('share.twitter', $quote) }}" class="btn btn-xs btn-facebook">
                                <em class="fa fa-facebook fa-fw"></em>
                            </a>
                            
                            <a title="Share to Google Plus" href="{{ route('share.twitter', $quote) }}" class="btn btn-xs btn-google">
                                <em class="fa fa-google-plus fa-fw"></em>
                            </a>
                        </div>
                    </p>
                </div>

                <div class="form-group">
                    <label for="author">{{ __('Author') }}</label>
                    <p class="form-control-static">
                        <a href="{{ route('admin.author.show', $quote->author) }}">
                            {{ $quote->author->name }}
                        </a>
                    </p>
                </div>

                <div class="form-group">
                    <label for="category">{{ __('Category') }}</label>
                    <p class="form-control-static">
                        <a href="{{ route('admin.category.show', $quote->category) }}">
                            {{ $quote->category->name }}
                        </a>
                    </p>
                </div>

                @if ($quote->user)
                    <div class="form-group">
                        <label for="category">{{ __('User') }}</label>
                        <p class="form-control-static">
                            <a href="{{ route('admin.user.show', $quote->user) }}">
                                {{ $quote->user->name }}
                            </a>
                        </p>
                    </div>
                @endif

                @if ($quote->source)
                    <div class="form-group">
                        <label for="source">{{ __('Source') }}</label>
                        <p class="form-control-static">
                            {{ $quote->source }}
                        </p>
                    </div>
                @endif

                <div class="form-group">
                    <label for="status">{{ __('Status') }}</label>
                    <p class="form-control-static">
                        @if ($quote->status == 'A')
                            <span class="label label-success">{{ __('Published') }}</span>
                        @else
                            <span class="label label-warning">{{ __('Unpublished') }}</span>
                        @endif
                    </p>
                </div>

                <div class="form-group">
                    <label for="created">{{ __('Created') }}</label>
                    <p class="form-control-static">
                        {{ $quote->created_at->diffForHumans() }}
                    </p>
                </div>

                <div class="form-group">
                    <label for="updated">{{ __('Updated') }}</label>
                    <p class="form-control-static">
                        {{ $quote->updated_at->diffForHumans() }}
                    </p>
                </div>

                <a href="{{ route('admin.quote.index') }}" class="btn btn-default">{{ __('Back') }}</a>
                <a href="{{ route('admin.quote.edit', $quote) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                <a href="{{ route('admin.quote.edit', $quote) }}" class="btn btn-danger delete">{{ __('Delete') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection