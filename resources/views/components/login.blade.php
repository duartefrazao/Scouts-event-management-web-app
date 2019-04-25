<div class="container initial-page-container">
    <form class="p-4" id="login" method="POST" action="{{ route('login') }}">
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
            <a href="#forgot-pass" class="forgot-pass">Esqueceste-te da palavra-passe?</a>
            {{-- @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
            @endif --}}
        </div>
        <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Lembrar
        </label>

        <button type="submit" id="login-submit-button" class="btn btn-primary">
            Entrar
        </button>
        <a class="register-btn" href="#toregister">Não tem conta? Registe-se</a>
    </form>

    <form method="POST" class="p-4" action="{{ route('register') }}" id="register">
        {{ csrf_field() }}

        <div class="btn-group btn-group-toggle user-type" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="radio" name="options" id="radio-scout" autocomplete="off"> Escuteiro
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="radio-guardian" autocomplete="off"> Encarregado
            </label>
        </div>

        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" name="name"  placeholder="Nome" value="{{ old('name') }}" required
                   autofocus>
            @if ($errors->has('name'))
                <span class="error">
                  {{ $errors->first('name') }}
              </span>
            @endif
        </div>
        <div class="form-group">
            <label for="birthdate">Data de nascimento</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required>
            @if ($errors->has('birthdate'))
                <span class="error">
                  {{ $errors->first('birthdate') }}
              </span>
            @endif
        </div>

        <div class="form-group">
            <label for="email">Endereço de email</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                   placeholder="Endereço de email" name="email" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
                <span class="error">
                  {{ $errors->first('email') }}
              </span>
            @endif
        </div>
        <div class="form-group">
            <label for="password">Palavra-passe</label>
            <input type="password" class="form-control" name="password"  id="password" placeholder="Palavra-passe" required autocomplete>
            @if ($errors->has('password'))
                <span class="error">
                  {{ $errors->first('password') }}
              </span>
            @endif
        </div>
        <div class="form-group">
            <label for="password-confirmation">Confirmar palavra-passe</label>
            <input type="password" class="form-control" id="password-confirmation"  name="password_confirmation" placeholder="Palavra-passe" required
                   autocomplete>
            @if ($errors->has('password-confirmation'))
                <span class="error">
                  {{ $errors->first('password-confirmation') }}
              </span>
            @endif
        </div>

        <!--  Error handle -->
        @if($errors->any())
            <div class="row collapse">
                <ul class="alert-box warning radius">
                    @foreach($errors->all() as $error)
                        <li> {{ $error }} </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Registar</button>

        <a href="#login" class="register-btn">Já tem conta? Autentique-se</a>

    </form>

</div>
</div>
