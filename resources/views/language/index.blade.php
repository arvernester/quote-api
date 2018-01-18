@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-container">
            <div class="panel-body">
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
                            <td>{{ $language->code }}</td>
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
@endsection