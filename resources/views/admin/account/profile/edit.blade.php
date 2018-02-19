@extends('layouts.admin')

@section('content')
@include('layouts.partials.flash')
<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <img src="https://www.gravatar.com/avatar/{{ md5($user->email) }}?s=300" class="img-responsive" alt="{{ __('Gravatar image') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{ route('admin.account.profile.update') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group {{ !$errors->has('name') ?: 'has-error' }}">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
                        <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                    </div>

                    <div class="form-group {{ !$errors->has('email') ?: 'has-error' }}">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" readonly disabled value="{{ old('email', $user->email) }}" class="form-control">
                        <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                    </div>

                    <div class="actions">
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection