@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-container">
            <div class="panel-body">
                <div class="alert alert-warning">
                    <strong>Warning!</strong><br>
                    Quote inside source category will be moved to destination category. This action cannot be undone.
                </div>
                <form action="{{ route('admin.category.fuse') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    
                    <div class="form-group {{ !$errors->has('source') ?: 'has-error' }}">
                        <label for="source">Source</label>
                        <select name="source" id="category-source" class="form-control select2">
                            <option value="">Select first category</option>
                            @foreach ($categories as $value => $label)
                                <option value="{{ $value }}" {{ request('source') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <span class="help-block text-danger">
                            {{ $errors->first('from') }}
                        </span>
                    </div>
                    
                    <div class="form-group {{ !$errors->has('destination') ?: 'has-error' }}">
                        <label for="destination">Destination</label>
                        <select name="destination" id="category-destination" class="form-control select2">
                            <option value="">Select destination category</option>
                            @foreach ($categories as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <span class="help-block text-danger">
                            {{ $errors->first('destination') }}
                        </span>
                    </div>

                    <button class="btn btn-primary" type="submit">Merge</button>
                    <a href="{{ url()->previous() ?? route('admin.category.index') }}" class="btn btn-default">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('lumino/vendor/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}">
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
    $(function(){
        $('.select2').select2({
            theme: 'bootstrap'
        })
    })
</script>
@endpush