
    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" class="form-control" id="name" name="name"  placeholder="Nome" value="Duarte" required
               autofocus>

        @if ($errors->has('name'))
            <span class="error">
              {{ $errors->first('name') }}
          </span>
        @endif
    </div>
    <div class="form-group">
        <label for="birthdate">Data de nascimento</label>
        <input type="date" class="form-control" id="birthdate" name="birthdate" value="2019-05-08" required>
        @if ($errors->has('birthdate'))
            <span class="error">
              {{ $errors->first('birthdate') }}
          </span>
        @endif
    </div>

    <div class="form-group">
        <label for="email">Endereço de email</label>
        <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
               placeholder="Endereço de email" name="email"  value="duartemarquesmano@gmail.com" required>
        @if ($errors->has('email'))
            <span class="error">
              {{ $errors->first('email') }}
          </span>
        @endif

    </div>
    <div class="form-group">
        <label for="password">Palavra-passe</label>
        <input type="password" class="form-control" name="password"  id="password" placeholder="Palavra-passe" value="123" required autocomplete>
        @if ($errors->has('password'))
            <span class="error">
              {{ $errors->first('password') }}
          </span>
        @endif

    </div>

    <div class="form-group">
        <label for="password-confirmation">Confirmar palavra-passe</label>
        <input name="password_confirmation" type="password" class="form-control" id="password-confirmation" placeholder="Palavra-passe" value="123" required>
        @if ($errors->has('password-confirmation'))
            <span class="error">
              {{ $errors->first('password-confirmation') }}
          </span>
        @endif
    </div>

    <div class="form-group">
        <label for="description">Descrição</label>
        <input name="description" type="text" class="form-control" id="description" value="123" placeholder="Descrição de ti" required>
        @if ($errors->has('description'))
            <span class="error">
                  {{ $errors->first('description') }}
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