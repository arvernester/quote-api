@extends('layouts.admin')

@section('content')
@include('layouts.partials.flash')

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <img src="{{ $author->full_image_path }}" alt="{{ $author->name }}" class="img-responsive">
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
                        <label for="name">Name</label>
                        <input type="text" name="name" value="{{ old('name', $author->name) }}" class="form-control">
                        <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                    </div>

                    <div class="form-group {{ !$errors->has('picture') ?: 'has-error' }}">
                        <label for="picture">Picture</label>
                        <input type="file" name="picture">
                        <span class="help-block text-danger">
                            {{ $errors->first('picture') }}
                        </span>
                    </div>

                    <button name="action" value="update" class="btn btn-primary" type="submit">Update</button>
                    <button name="action" value="view" class="btn btn-default" type="submit">Update &amp; View</button>
                    <a href="{{ url()->previous() ?? route('admin.author.index') }}" class="btn btn-default">Back</a>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection