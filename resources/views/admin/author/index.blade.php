@extends('layouts.admin')

@section('content')

@include('layouts.partials.flash')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Total Quote') }}</th>
                                <th>{{ __('Created') }}</th>
                                <th>{{ __('Updated') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($authors as $author)
                            <tr>
                                <td>
                                    @if ($author->image_path)
                                        <em class="text-info fa fa-picture-o"></em>
                                    @else
                                        <em class="text-muted fa fa-picture-o"></em>
                                    @endif
                                    <a href="#" class="editable" data-pk="{{ $author->id }}" data-name="name" data-url="{{ route('admin.author.updateable') }}">{{ $author->name }}</a>
                                </td>
                                <td class="text-right">{{ number_format($author->quotes->count()) }}</td>
                                <td>{{ $author->created_at->format(config('app.date_format')) }}</td>
                                <td>{{ $author->updated_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.author.show', $author) }}" class="btn btn-primary btn-table">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <a href="{{ route('admin.author.edit', $author) }}" class="btn btn-primary btn-table">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </a>
                                    <a href="{{ route('admin.author.edit', $author) }}" class="btn btn-danger btn-table delete">
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

        {{ $authors->links() }}
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('lumino/vendor/bootstrap3-editable-1.5.1/bootstrap3-editable/css/bootstrap-editable.css') }}">
@endpush

@push('js')
<script src="{{ asset('lumino/vendor/bootstrap3-editable-1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
@endpush