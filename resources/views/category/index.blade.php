@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <ul class="pull-right panel-settings panel-button-tab-right">
                    <li class="dropdown">
                        <a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                            <em class="fa fa-cogs"></em>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <ul class="dropdown-settings">
                                    <li>
                                        <a href="{{ route('admin.category.create') }}">
                                            <em class="fa fa-plus"></em> Create Category
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <span class="pull-right clickable panel-toggle panel-button-tab-left">
                    <em class="fa fa-toggle-up"></em>
                </span>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Total Quote</td>
                            <td>Created</td>
                            <td>Updated</td>
                            <td>Actions</td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a href="{{ route('admin.quote.index', ['category' => $category->id]) }}">
                                    {{ number_format($category->quotes_count, 0) }}
                                </a>
                            </td>
                            <td>{{ $category->created_at }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>
                                <a href="{{ route('admin.category.show', $category) }}" class="btn btn-primary btn-table">
                                    <i class="fa fa-eye fa-fw"></i>
                                </a>
                                <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-primary btn-table">
                                    <i class="fa fa-edit fa-fw"></i>
                                </a>
                                <a href="{{ route('admin.category.destroy', $category) }}" class="btn btn-danger btn-table">
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
</div>
@endsection