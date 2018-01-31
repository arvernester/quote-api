@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="panel">
                <div class="panel-body">
                    <img src="{{ $banner->full_path }}" alt="{{ $banner->title }}" class="img-responsive">
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel">
                <div>
                    <div class="panel-body">
                        <form action="{{ route('admin.banner.update', $banner) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            
                            <div class="form-group {{ !$errors->has('title') ?: 'has-error' }}">
                                <label for="title">{{ __('Title') }}</label>
                                <input type="text" name="title" value="{{ old('title', $banner->title) }}" class="form-control">
                                <span class="help-block">{{ $errors->first('title') }}</span>
                            </div>

                            <div class="form-group {{ !$errors->has('description') ?: 'has-error' }}">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea name="description" rows="3" class="form-control">{{ old('description', $banner->description) }}</textarea>
                                <span class="help-block">{{ $errors->first('description') }}</span>
                            </div>

                            <div class="form-group {{ !$errors->has('image') ?: 'has-error' }}">
                                <label for="image">{{ __('Image') }}</label>
                                <input type="file" name="image">
                                <span class="help-block">{{ $errors->first('image') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="status">
                                    <input type="checkbox" value="1" name="is_active" {{ $banner->is_active ? 'checked' : '' }}>
                                    {{ __('Is banner published?') }}
                                </label>
                            </div>

                            <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
                            <a href="{{ route('admin.banner.index') }}" class="btn btn-default">{{ __('Back') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection