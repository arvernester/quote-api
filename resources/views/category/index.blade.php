@extends('layouts.default') @section('content')
<section class="post">
    <header class="major">
        <h1>{{ __('Category') }}</h1>
    </header>

    <hr>

    <!-- Table -->

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Total Quote</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td class="text-right">
                        {{ Numbers\Number::n($category->quotes_count)->format() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</section>
@endsection

@push('css')
<style>
    td.text-right {
        text-align: right;
    }
</style>
@endpush