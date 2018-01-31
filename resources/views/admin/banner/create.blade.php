@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div>
                    <div class="panel-body">
                        <form action="{{ route('admin.banner.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            
                            <div class="form-group {{ !$errors->has('title') ?: 'has-error' }}">
                                <label for="title">{{ __('Title') }}</label>
                                <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                <span class="help-block">{{ $errors->first('title') }}</span>
                            </div>

                            <div class="form-group {{ !$errors->has('description') ?: 'has-error' }}">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                                <span class="help-block">{{ $errors->first('description') }}</span>
                            </div>

                            <div class="form-group {{ !$errors->has('image') ?: 'has-error' }}">
                                <label for="image">{{ __('Image') }}</label>
                                <input type="file" name="image">
                                <span class="help-block">{{ $errors->first('image') }}</span>
                            </div>

                            <button class="btn btn-primary" type="submit">{{ __('Upload') }}</button>
                            <a href="{{ route('admin.banner.index') }}" class="btn btn-default">{{ __('Back') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection