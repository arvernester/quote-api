@extends('layouts.admin')

@section('content')

@include('layouts.partials.flash')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Author Name</th>
                                <th>Has Picture</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($authors as $author)
                            <tr>
                                <td>{{ $author->name }}</td>
                                <td>{{ $author->image_path ? 'Yes' : 'No' }}</td>
                                <td>{{ $author->created_at }}</td>
                                <td>{{ $author->updated_at }}</td>
                                <td>
                                    <a href="{{ route('admin.author.show', $author) }}" class="btn btn-primary btn-table">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <a href="{{ route('admin.author.edit', $author) }}" class="btn btn-primary btn-table">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </a>
                                    <a href="{{ route('admin.author.edit', $author) }}" class="btn btn-danger btn-table delete">
                                        <i class="fa fa-trash fa-fw"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{ $authors->links() }}
    </div>
</div>
@endsection