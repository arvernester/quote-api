@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-container">
            <div class="panel-body">

                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <p class="form-control-static">
                        {{ $user->name }}
                    </p>
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <p class="form-control-static">
                        {{ $user->email }}
                    </p>
                </div>

                <div class="form-group">
                    <label for="created">{{ __('Created') }}</label>
                    <p class="form-control-static">
                        {{ $user->created_at->diffForHumans() }}
                    </p>
                </div>

                <div class="form-group">
                    <label for="updated">{{ __('Updated') }}</label>
                    <p class="form-control-static">
                        {{ $user->updated_at->diffForHumans() }}
                    </p>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('Quote from :user', ['user' => $user->name]) }}
            </div>
            <div class="panel-body timeline-container">
                <ul class="timeline">
                    @foreach ($quotes as $quote)
                    <li>
                        <div class="timeline-badge primary">
                            <em class="fa fa-quote-right"></em>
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">{{ $quote->author->name ?? 'Unknown' }}</h4>
                            </div>
                            <div class="timeline-body">
                                <p>{{ $quote->text }}</p>
                                <p><a href="{{ route('admin.quote.show', $quote) }}">{{ __('Show') }}</a></p>
                            </div>

                            <hr>

                            <div class="timeline-time">
                                <p>
                                    {{ $quote->created_at->diffForHumans() }} {{ __('in') }}
                                    <a href="{{ route('admin.category.show', $quote->category) }}">{{ $quote->category->name }}</a>
                                </p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('admin.quote.index', ['user' => $user->id]) }}" class="btn btn-block btn-primary">
                    {{ __('Show All Quotes from :user', ['user' => $user->name]) }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection