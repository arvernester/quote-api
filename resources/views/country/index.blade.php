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
                                <th>Updated</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($countries as $country)
                            <tr>
                                <td>{{ $country->code }}</td>
                                <td>{{ $country->name }}</td>
                                <td>{{ $country->native_name }}</td>
                                <td>{{ $country->updated_at }}</td>
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