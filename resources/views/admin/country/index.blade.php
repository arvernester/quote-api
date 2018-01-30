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
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Native Name') }}</th>
                                <th>{{ __('Updated') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($countries as $country)
                            <tr>
                                <td>{{ $country->code }}</td>
                                <td>
                                    <img src="{{ $country->flag_path }}" alt="{{ $country->name }}" class="img-reponsive flag" width="29"> 
                                    {{ $country->name }}
                                </td>
                                <td>{{ $country->native_name }}</td>
                                <td>{{ $country->updated_at->diffForHumans() }}</td>
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
<style>
    .flag {
        border: 1px solid;
    }
</style>
@endpush