@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="panel panel-default">
            <div class="panel-body text-center">
                @if (! empty($category->poster_path))
                    <img src="{{ Storage::url($category->poster_path) }}" alt="{{ __('Image is missing.') }}" class="img-responsive">
                @else
                    <p>{{ __('No poster background uploaded.') }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{ route('admin.category.poster.store', $category) }}" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}
                    {{ method_field('POST') }}

                    <div class="form-group">
                        <label for="quote">{{ __('Category') }}</label>
                        <p class="form-control-static">{{ $category->name }}</p>
                    </div>

                    <div class="form-group {{ !$errors->has('background') ?: 'has-error' }}">
                        <label for="background">{{ __('Background') }}</label>
                        <input type="file" name="background" id="background">
                        <span class="help-block text-danger">{{ $errors->first('background') }}</span>
                    </div>

                    <div class="actions">
                        <button name="action" value="submit" type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                        <button name="action" value="submit_view" type="submit" class="btn btn-default">{{ __('Submit & View') }}</button>
                        <a href="{{ route('admin.category.show', $category) }}" class="btn btn-default">{{ __('See') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection