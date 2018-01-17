@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <img src="{{ $banner->full_path }}" alt="{{ $banner->title }}" class="img-responsive">
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-container">
            <div class="panel-body">
                <div class="form-group">
                    <label for="title">Title</label>
                    <p class="form-control-static">
                        {{ $banner->title }}
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <p class="form-control-static">
                        {{ $banner->description }}
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <p class="form-control-static">
                        {{ $banner->is_active ? 'Published': 'Unpublished' }}
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="created">Created</label>
                    <p class="form-control-static">
                        {{ $banner->created_at->diffForHumans() }}
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="updated">Updated</label>
                    <p class="form-control-static">
                        {{ $banner->updated_at->diffForHumans() }}
                    </p>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>
                <a href="{{ route('admin.banner.edit', $banner) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('admin.banner.destroy', $banner) }}" class="btn btn-danger delete">Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection