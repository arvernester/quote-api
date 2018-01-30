@extends('layouts.admin')

@section('content')
@include('layouts.partials.flash')

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                @if ($author->image_path)
                    <img src="{{ $author->full_image_path }}" alt="{{ $author->name }}" class="img-responsive">
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
            <form action="{{ route('admin.author.update', $author) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('put') }}

                <div class="panel-body">
                    <div class="form-group  {{ !$errors->has('name') ?: 'has-error' }}">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" name="name" value="{{ old('name', $author->name) }}" class="form-control">
                        <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                    </div>

                    <div class="form-group {{ !$errors->has('picture') ?: 'has-error' }}">
                        <label for="picture">{{ __('Picture') }}</label>
                        <input type="file" name="picture">
                        <span class="help-block text-danger">
                            {{ $errors->first('picture') }}
                        </span>
                    </div>

                    <button name="action" value="update" class="btn btn-primary" type="submit">{{ __('Update') }}</button>
                    <button name="action" value="view" class="btn btn-default" type="submit">{{ __('Update &amp; View') }}</button>
                    <a href="{{ url()->previous() ?? route('admin.author.index') }}" class="btn btn-default">{{ __('Back') }}</a>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection