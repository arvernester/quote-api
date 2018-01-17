@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-container">
            <form action="{{ route('admin.author.update', $author) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('put') }}

                <div class="panel-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input disabled readonly type="text" name="name" value="{{ old('name', $author->name) }}" class="form-control">
                    </div>

                    <div class="form-group {{ !$errors->has('picture') ?: 'has-error' }}">
                        <label for="picture">Picture</label>
                        <input type="file" name="picture">
                        <span class="help-block text-danger">
                            {{ $errors->first('picture') }}
                        </span>
                    </div>

                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection