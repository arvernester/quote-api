@extends('layouts.auth')

@section('content')
<div class="login-panel panel panel-default">
    <div class="panel-heading">{{ __('Login') }}</div>
    <div class="panel-body">
        <form method="post" action="{{ route('login') }}" role="form">
            {{ csrf_field() }}

            <fieldset>
                <div class="form-group {{ !$errors->has('email') ?: 'has-error' }}">
                    <input class="form-control" placeholder="{{ __('Email') }}" name="email" type="email" autofocus="" value="{{ old('email') }}">
                </div>
                <div class="form-group {{ !$errors->has('password') ?: 'has-error' }}">
                    <input class="form-control" placeholder="{{ __('Password') }}" name="password" type="password" value="">
                </div>
                <div class="checkbox icheck-primary">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">{{ __('Remember me') }}</label>
                </div>
                <button class="btn btn-primary" type="submit">{{ __('Log In') }}</button>

            </fieldset>
        </form>
    </div>
</div>
@endsection