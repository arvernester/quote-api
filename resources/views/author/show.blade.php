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

                        <button class="btn btn-danger">Remove Picture</button>
                    </form>
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

                <a href="{{ url()->previous() ?? route('admin.author.index') }}" class="btn btn-default">Back</a>
                <a href="{{ route('admin.author.edit', $author) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('admin.author.destroy', $author) }}" class="btn btn-danger delete">Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    form.delete {
        margin-top: 20px;
    }
</style>
@endpush