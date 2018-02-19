@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-container">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('ISO 2') }}</th>
                                <th>{{ __('ISO 3') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Native Name') }}</th>
                                <th>{{ __('Country') }}</th>
                                <th>{{ __('Updated') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($languages as $language)
                            <tr>
                                <td><a href="{{ route('admin.quote.index', ['lang' => $language->code_alternate]) }}">{{ $language->code_alternate }}</a></td>
                                <td>{{ $language->code }} </td>
                                <td>{{ $language->name }}</td>
                                <td>{{ $language->native_name }}</td>
                                <td>{{ $language->country->name }}</td>
                                <td>{{ $language->updated_at->diffForHumans() }}</td>
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