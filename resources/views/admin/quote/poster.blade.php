@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="panel panel-default">
            <div class="panel-body text-center">
                @if (! empty($quote->poster_path))
                    <img src="{{ Storage::url($quote->poster_path) }}" alt="{{ __('Image is missing.') }}" class="img-responsive">
                @else
                    <p>{{ __('No poster background uploaded.') }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{ route('admin.quote.poster.store', $quote) }}" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}
                    {{ method_field('POST') }}

                    <div class="form-group">
                        <label for="quote">{{ __('Quote') }}</label>
                        <p class="form-control-static">{{ $quote->text }}</p>
                    </div>

                    <div class="form-group {{ !$errors->has('background') ?: 'has-error' }}">
                        <label for="background">{{ __('Background') }}</label>
                        <input type="file" name="background" id="background">
                        <span class="help-block text-danger">{{ $errors->first('background') }}</span>
                    </div>

                    <div class="actions">
                        <button name="action" value="submit" type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                        <button name="action" value="submit_view" type="submit" class="btn btn-default">{{ __('Submit & View') }}</button>
                        <a href="{{ route('admin.quote.show', $quote) }}" class="btn btn-default">{{ __('See') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection