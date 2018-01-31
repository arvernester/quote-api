@extends('layouts.admin')

@section('content')

@include('layouts.partials.flash')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default ">
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
                                        <a href="{{ route('admin.banner.create') }}">
                                            <em class="fa fa-plus"></em> {{ __('Upload Banner') }}
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
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Created') }}</th>
                                <th>{{ __('Updated') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $banner)
                            <tr class="{{ $banner->is_active ? '' : 'warning' }}">
                                <td>{{ $banner->title }}</td>
                                <td>{{ $banner->description }}</td>
                                <td>{{ $banner->created_at->format(config('app.date_format')) }}</td>
                                <td>{{ $banner->updated_at->diffForHumans() }}</td>
                                <td>

                                    <a href="{{ route('admin.banner.show', $banner) }}" class="btn btn-table btn-primary">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <a href="{{ route('admin.banner.edit', $banner) }}" class="btn btn-primary btn-table">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </a>
                                    <a href="{{ route('admin.banner.destroy', $banner) }}" class="btn btn-danger btn-table">
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