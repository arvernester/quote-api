@extends('layouts.admin')

@section('content')
@include('layouts.partials.flash')

<div class="row">
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-body">
                @if ($author->full_image_path)
                    <figure>
                        <img src="{{ $author->full_image_path }}" alt="{{ $author->name }}" class="img-responsive">
                    </figure>

                    <form class="delete" action="{{ route('admin.author.removePicture', $author) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}

                        <button class="btn btn-danger">{{ __('Remove Picture') }}</button>
                    </form>
                @else
                    <div class="alert alert-info">
                        {{ __('Author has no picture.') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-container">
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <p class="form-control-static">{{ $author->name }}</p>
                </div>
                
                <div class="form-group">
                    <label for="total">{{ __('Total Quote') }}</label>
                    <p class="form-control-static">{{ $author->quotes->count() }}</p>
                </div>

                <div class="form-group">
                    <label for="created">{{ __('Created') }}</label>
                    <p class="form-control-static">{{ $author->created_at->diffForHumans() }}</p>
                </div>

                <div class="form-group">
                    <label for="updated">{{ __('Updated') }}</label>
                    <p class="form-control-static">{{ $author->created_at->diffForHumans() }}</p>
                </div>

                <a href="{{ url()->previous() ?? route('admin.author.index') }}" class="btn btn-default">{{ __('Back') }}</a>
                <a href="{{ route('admin.author.edit', $author) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                <a href="{{ route('admin.author.destroy', $author) }}" class="btn btn-danger delete">{{ __('Delete') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default ">
            <div class="panel-heading">
                {{ __('Quote') }}
                <ul class="pull-right panel-settings panel-button-tab-right">
                    <li class="dropdown">
                        <a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                            <em class="fa fa-cogs"></em>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <ul class="dropdown-settings">
                                    <li>
                                        <a href="{{ route('admin.quote.index') }}">
                                            <em class="fa fa-cog"></em> {{ __('All Quote') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <span class="pull-right clickable panel-toggle panel-button-tab-left">
                    <em class="fa fa-toggle-up"></em>
                </span>
            </div>
            <div class="panel-body timeline-container">
                <ul class="timeline">
                    @foreach ($author->quotes as $quote)
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
            </div>
        </div>
    </div
</div>
@endsection

@push('css')
<style>
    form.delete {
        margin-top: 20px;
    }
</style>
@endpush