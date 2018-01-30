@extends('layouts.admin')

@section('content')
@include('layouts.partials.flash')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-container">
            <div class="panel-body">
                <form action="{{ route('admin.quote.update', $quote) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}

                    <div class="form-group {{ !$errors->has('category') ?: 'has-error' }}">
                        <label for="category">Category</label>
                        <select name="category" class="select2 form-control">
                            @foreach ($categories as $value => $label)
                                <option value="{{ $value }}" {{ $quote->category_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <span class="help-block text-danger">{{ $errors->first('category') }}</span>
                    </div>

                    <div class="form-group {{ !$errors->has('language') ?: 'has-error' }}">
                        <label for="language">Language</label>
                        <select name="language" class="select2 form-control">
                            @foreach ($languages as $value => $label)
                                <option value="{{ $value }}" {{ $quote->language_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <span class="help-block text-danger">{{ $errors->first('language') }}</span>
                    </div>
                    
                    <div class="form-group {{ !$errors->has('author') ?: 'has-error' }}">
                        <label for="author">Author</label>
                        <input type="text" name="author" class="form-control" value="{{ old('author', $quote->author->name) }}">
                        <span class="help-block text-danger">{{ $errors->first('author') }}</span>
                    </div>
                    
                    <div class="form-group {{ !$errors->has('text') ?: 'has-error' }}">
                        <label for="text">Quote</label>
                        <textarea name="text" id="quote_text" rows="5" class="form-control">{{ old('text', $quote->text) }}</textarea>
                        <span class="help-block text-danger">{{ $errors->first('text') }}</span>
                    </div>
                    
                    <div class="form-group {{ !$errors->has('source') ?: 'has-error' }}">
                        <label for="source">Source <small>(Link, Tweet, etc)</small></label>
                        <input type="text" name="source" class="form-control" value="{{ old('source', $quote->source) }}">
                        <span class="help-block text-danger">{{ $errors->first('source') }}</span>
                    </div>

                    <button name="action" class="btn btn-primary" type="submit" value="submit">Submit</button>
                    <button name="action" class="btn btn-default" type="submit" value="view">Submit &amp; View</button>
                    <a href="{{ url()->previous() ?? route('admin.quote.index') }}" class="btn btn-default">Back</a>
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