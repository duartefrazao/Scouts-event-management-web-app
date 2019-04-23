
<div class="container initial-page-container">
    <form class="p-4" id="login" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="email">Endereço de email</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
                <span class="error">
                {{ $errors->first('email') }}
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="password" >Palavra-passe</label>
            <input id="password"  class="form-control" type="password" name="password" required>
            <a href="#forgot-pass" class="forgot-pass">Esqueceste-te da palavra-passe?</a>
            {{-- @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
            @endif --}}
        </div>

        {{-- <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Lembrar
        </label> --}}

        <button type="submit" id="login-submit-button" class="btn btn-primary">
            Entrar
        </button>
        <a class="register-btn" href="#toregister">Não tem conta? Registe-se</a>
    </form>

    <form class="p-4" action="{{route('register') }}" id="register">

        <div class="btn-group btn-group-toggle user-type" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="radio" name="options" id="radio-scout" autocomplete="off" checked> Escuteiro
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="radio-guardian" autocomplete="off"> Encarregado
            </label>
        </div>

        <div class="form-group">
            <label for="name">Nome</label>
            <input type="email" class="form-control" id="name" placeholder="Nome">
        </div>
        <div class="form-group">
            <label for="birth-date">Data de nascimento</label>
            <input type="date" class="form-control" id="birth-date">
        </div>

        <div class="form-group">
            <label for="email">Endereço de email</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Endereço de email">
        </div>
        <div class="form-group">
            <label for="password">Palavra-passe</label>
            <input type="password" class="form-control" id="password" placeholder="Palavra-passe">
        </div>


        <button id="login-submit-button" type="submit" class="btn btn-primary">Registar</button>
        <a href="#tologin" class="register-btn">Já tem conta? Autentique-se</a>
    </form> 
</div>
</div>
