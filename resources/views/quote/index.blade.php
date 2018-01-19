@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Motivational and inspirational quotes
                    <ul class="pull-right panel-settings panel-button-tab-right">
                    <li class="dropdown">
                        <a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                            <em class="fa fa-cogs"></em>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <ul class="dropdown-settings">
                                    <li>
                                        <a href="{{ route('admin.quote.create') }}">
                                            <em class="fa fa-plus fa-fw"></em> Add New
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.quote.create') }}">
                                            <em class="fa fa-user fa-fw"></em> Submitted Quotes
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{ route('admin.quote.create') }}'">
                                            <em class="fa fa-trash fa-fw"></em> Trash Bin
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
                                <th>Language</th>
                                <th>Quote</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($quotes as $quote)
                            <tr>
                                <td>{{ $quote->language->code }}</td>
                                <td>{{ $quote->text }}</td>
                                <td>
                                    <a href="{{ route('admin.author.show', $quote->author) }}">{{ $quote->author->name }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.category.show', $quote->category) }}">{{ $quote->category->name }}</a>
                                </td>
                                <td>{{ $quote->updated_at }}</td>
                                <td width="100">
                                    <a href="{{ route('admin.quote.show', $quote) }}" class="btn btn-primary btn-table">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <a href="{{ route('admin.quote.edit', $quote) }}" class="btn btn-primary btn-table">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </a>
                                    <a href="{{ route('admin.quote.destroy', $quote) }}" class="btn btn-danger btn-table">
                                        <i class="fa fa-trash fa-fw"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{ $quotes->links() }}
        </div>
    </div>
@endsection