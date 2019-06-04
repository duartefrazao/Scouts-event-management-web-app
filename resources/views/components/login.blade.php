<div class="container initial-page-container">
    
    <form class="p-4" id="login" method="POST" action="{{ route('login') }}" >
        {{ csrf_field() }}
        <div class="form-group">
            <label for="email_login">Endereço de email</label>
            <input id="email_login" type="email" class="form-control" name="email" value="{{ old('email') }}" required
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
            <a href="/password/reset" class="forgot-pass">Esqueceste-te da palavra-passe?</a>
            @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>
        <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Lembrar
        </label>

        <button type="submit" id="login-submit-button" class="btn btn-primary">
            Entrar
        </button>
        <a class="register-btn" href="#toregister">Não tem conta? Registe-se</a>
    </form>


    @include('components.register_form');


</div>


@include('components.image_crop')
@include('components.session_message')
</div>
