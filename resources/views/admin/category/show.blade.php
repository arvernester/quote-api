@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-container">
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <p class="form-control-static">
                        {{ $category->name }}
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="created">Created</label>
                    <p class="form-control-static">
                        {{ $category->created_at->diffForHumans() }}
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="updated">Updated</label>
                    <p class="form-control-static">
                        {{ $category->updated_at->diffForHumans() }}
                    </p>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>
                <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('admin.category.destroy', $category) }}" class="btn btn-danger">Edit</a>
            </div>
        </div>
    </div>
</div>
@endsection