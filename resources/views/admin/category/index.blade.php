@extends('layouts.admin')

@section('content')
@include('layouts.partials.flash')

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
                                            <em class="fa fa-plus"></em> {{ __('Create Category') }}
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
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>{{ __('Name') }}</td>
                                <td>{{ __('Total Quote') }}</td>
                                <td>{{ __('Created') }}</td>
                                <td>{{ __('Updated') }}</td>
                                <td>{{ __('Actions') }}</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($categories as $category)
                            <tr class="{{ $category->quotes_count <= 0 ? 'text-muted' : '' }}">
                                <td>
                                    @if ($category->poster_path)
                                        <em class="fa fa-image fa-fw">&nbsp;</em>
                                    @else
                                        <em class="fa fa-image fa-fw text-muted">&nbsp;</em>
                                    @endif
                                    <a href="#" class="editable" data-name="name" data-type="text" data-pk="{{ $category->id }}" data-url="{{ route('admin.category.updateable') }}">{{ $category->name }}</a>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.quote.index', ['category' => $category->id]) }}">
                                        {{ Numbers\Number::n($category->quotes_count)->format() }}
                                    </a>
                                </td>
                                <td>{{ $category->created_at->format(config('app.date_format')) }}</td>
                                <td>{{ $category->updated_at->diffForHumans() }}</td>
                                <td width="150">
                                    <a href="{{ route('admin.category.show', $category) }}" class="btn btn-primary btn-table">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-primary btn-table">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </a>
                                    <a href="{{ route('admin.category.merge', ['source' => $category->id]) }}" class="btn btn-warning btn-table" title="Move or merge category {{ $category->name }}">
                                        <i class="fa fa-compress fa-fw"></i>
                                    </a>
                                    <a href="{{ route('admin.category.poster', ['source' => $category]) }}" class="btn btn-warning btn-table" title="Move or merge category {{ $category->name }}">
                                        <em class="fa fa-upload fa-fw">&nbsp;</em>
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
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('lumino/vendor/bootstrap3-editable-1.5.1/bootstrap3-editable/css/bootstrap-editable.css') }}">
@endpush

@push('js')
<script src="{{ asset('lumino/vendor/bootstrap3-editable-1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
@endpush