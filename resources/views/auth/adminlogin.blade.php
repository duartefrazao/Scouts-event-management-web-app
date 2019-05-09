@extends('layouts.app')


@section('content')


    <div class="container col-sm-12 col-md-6 col-lg-4">

        <form class="p-4" id="login" method="POST" action="{{ route('admin.login') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email_login">Endereço de email</label>
                <input id="email_login" type="email" class="form-control" name="email" value="{{ old('email') }}"
                       required
                       autofocus>
                @if ($errors->has('email'))
                    <span class="error">
                {{ $errors->first('email') }}
                </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password_login">Palavra-passe</label>
                <input id="password_login" class="form-control" type="password" name="password" required autocomplete>
                @if ($errors->has('password'))
                    <span class="error">
                    {{ $errors->first('password') }}
                </span>
                @endif
            </div>

            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            </label>


            <button type="submit">
                Login
            </button>

            <a href="{{route('home')}}">
                Voltar
            </a>
        </form>

    </div>

@endsection

