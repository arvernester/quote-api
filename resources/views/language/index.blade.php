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
                                <th>Code</th>
                                <th>Name</th>
                                <th>Native Name</th>
                                <th>Country</th>
                                <th>Updated</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($languages as $language)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.quote.index', ['lang' => $language->code]) }}">{{ $language->code }}</a>
                                </td>
                                <td>{{ $language->name }}</td>
                                <td>{{ $language->native_name }}</td>
                                <td>{{ $language->country->name }}</td>
                                <td>{{ $language->updated_at }}</td>
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