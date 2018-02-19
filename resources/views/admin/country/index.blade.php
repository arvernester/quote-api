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
                                <th>{{ __('Total Language') }}</th>
                                <th>{{ __('Updated') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($countries as $country)
                            <tr>
                                <td width="80">{{ strtolower($country->code_alternate) }}</td>
                                <td width="80">{{ strtolower($country->code) }}</td>
                                <td>
                                    <img src="{{ $country->flag_path }}" alt="{{ $country->name }}" class="img-reponsive flag" width="29"> 
                                    {{ $country->name }}
                                </td>
                                <td>{{ $country->native_name }}</td>
                                <td class="text-right">
                                    <a href="{{ route('admin.language.index', ['country' => $country->id]) }}">
                                        {{ Numbers\Number::n($country->languages_count)->format() }}
                                    </a>
                                </td>
                                <td width="150">{{ $country->updated_at->diffForHumans() }}</td>
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