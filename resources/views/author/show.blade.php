@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-body">
                @if ($author->full_image_path)
                    <figure>
                        <img src="{{ $author->full_image_path }}" alt="{{ $author->name }}" class="img-responsive">
                        <figcaption>{{ $author->name }}</figcaption>
                    </figure>
                @else
                    <div class="alert alert-info">
                        Author has no picture.
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-container">
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <p class="form-control-static">{{ $author->name }}</p>
                </div>

                <div class="form-group">
                    <label for="created">Created</label>
                    <p class="form-control-static">{{ $author->created_at->diffForHumans() }}</p>
                </div>

                <div class="form-group">
                    <label for="updated">Updated</label>
                    <p class="form-control-static">{{ $author->created_at->diffForHumans() }}</p>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>
                <a href="{{ route('admin.author.edit', $author) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('admin.author.destroy', $author) }}" class="btn btn-danger delete">Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection