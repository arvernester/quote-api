@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <img src="{{ $banner->full_path }}" alt="{{ $banner->title }}" class="img-responsive">
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-container">
            <div class="panel-body">
                <div class="form-group">
                    <label for="title">{{ __('Title') }}</label>
                    <p class="form-control-static">
                        {{ $banner->title }}
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                    <p class="form-control-static">
                        {{ $banner->description }}
                    </p>
                </div>

                <div class="form-group">
                    <label for="path">{{ __('Image Path') }}</label>
                    <p class="form-control-static">
                        {{ $banner->path }}
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="status">{{ __('Status') }}</label>
                    <p class="form-control-static">
                        {{ $banner->is_active ? 'Published': 'Unpublished' }}
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="created">{{ __('Created') }}</label>
                    <p class="form-control-static">
                        {{ $banner->created_at->diffForHumans() }}
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="updated">{{ __('Updated') }}</label>
                    <p class="form-control-static">
                        {{ $banner->updated_at->diffForHumans() }}
                    </p>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-default">{{ __('Back') }}</a>
                <a href="{{ route_lang('admin.banner.edit', $banner) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                <a href="{{ route_lang('admin.banner.destroy', $banner) }}" class="btn btn-danger delete">{{ __('Delete') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection