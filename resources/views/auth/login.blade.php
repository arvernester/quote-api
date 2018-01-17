@extends('layouts.auth')

@section('content')
<div class="login-panel panel panel-default">
    <div class="panel-heading">Log in</div>
    <div class="panel-body">
        <form method="post" action="{{ route('login') }}" role="form">
            {{ csrf_field() }}

            <fieldset>
                <div class="form-group {{ !$errors->has('email') ?: 'has-error' }}">
                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus="" value="{{ old('email') }}">
                </div>
                <div class="form-group {{ !$errors->has('password') ?: 'has-error' }}">
                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                </div>
                <div class="checkbox">
                    <label>
                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                    </label>
                </div>
                <button class="btn btn-primary" type="submit">Login</button>

            </fieldset>
        </form>
    </div>
</div>
@endsection