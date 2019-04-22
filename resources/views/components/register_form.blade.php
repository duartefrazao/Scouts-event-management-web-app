<div class="container initial-page-container">
<form method="POST" class="p-4" action="{{ route('register') }}" id="register">
        {{ csrf_field() }}
      
        <div class="btn-group btn-group-toggle user-type" data-toggle="buttons">
            <label class="btn btn-secondary active" >
                <input type="radio" name="options" id="radio-scout" autocomplete="off"> Escuteiro
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="radio-guardian" autocomplete="off"> Encarregado
            </label>
        </div>
      
        <div class="form-group">
            <label for="name" >Nome</label>
            <input type="email" class="form-control" id="name" placeholder="Nome" value="{{ old('name') }}" required autofocus>
            @if ($errors->has('name'))
              <span class="error">
                  {{ $errors->first('name') }}
              </span>
            @endif
        </div>
        <div class="form-group">
            <label for="birth-date">Data de nascimento</label>
            <input type="date" class="form-control" id="birth-date" value="{{ old('birth-date') }}" required >
            @if ($errors->has('birth-date'))
              <span class="error">
                  {{ $errors->first('birth-date') }}
              </span>
            @endif
        </div>
      
        <div class="form-group">
            <label for="email">Endereço de email</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Endereço de email"  value="{{ old('email') }}" required>
            @if ($errors->has('email'))
              <span class="error">
                  {{ $errors->first('email') }}
              </span>
            @endif
        </div>
        <div class="form-group">
            <label for="password">Palavra-passe</label>
            <input type="password" class="form-control" id="password" placeholder="Palavra-passe" required>
            @if ($errors->has('password'))
              <span class="error">
                  {{ $errors->first('password') }}
              </span>
            @endif
        </div>
        <div class="form-group">
            <label for="password-confirmation">Confirmar palavra-passe</label>
            <input type="password" class="form-control" id="password-confirmation" placeholder="Palavra-passe" required>
            @if ($errors->has('password-confirmation'))
              <span class="error">
                  {{ $errors->first('password-confirmation') }}
              </span>
            @endif
        </div>
      
      
        <button id="login-submit-button" type="submit" class="btn btn-primary">Registar</button>
        <a href="{{ route('login') }}" class="register-btn">Já tem conta? Autentique-se</a>
      </form>
</div>
</div>