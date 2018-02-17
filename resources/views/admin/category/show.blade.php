@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="panel panel-body">
            @if ($category->poster_path)
                <img src="{{ Storage::url($category->poster_path) }}" alt="{{ __('Image is missing.') }}" class="img-responsive">
            @else
                <p>{{ __('No poster background uploaded.') }}</p>                
            @endif
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div class="panel panel-container">
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <p class="form-control-static">
                        {{ $category->name }}
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="created">{{ __('Created') }}</label>
                    <p class="form-control-static">
                        {{ $category->created_at->diffForHumans() }}
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="updated">{{ __('Updated') }}</label>
                    <p class="form-control-static">
                        {{ $category->updated_at->diffForHumans() }}
                    </p>
                </div>

                <a href="{{ url()->previous() ?? route('admin.category.index') }}" class="btn btn-default">{{ __('Back') }}</a>
                <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                <a href="{{ route('admin.category.destroy', $category) }}" class="btn btn-danger">{{ __('Delete') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection