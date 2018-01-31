@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Created') }}</th>
                                <th>{{ __('Updated') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format(config('app.date_format')) }}</td>
                                <td>{{ $user->updated_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.user.show', $user) }}" class="btn btn-primary btn-table">
                                        <em class="fa fa-eye fa-fw"></em>
                                    </a>
                                    <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-primary btn-table">
                                        <em class="fa fa-edit fa-fw"></em>
                                    </a>
                                    <a href="{{ route('admin.user.destroy', $user) }}" class="btn btn-danger btn-table delete">
                                        <em class="fa fa-trash fa-fw"></em>
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