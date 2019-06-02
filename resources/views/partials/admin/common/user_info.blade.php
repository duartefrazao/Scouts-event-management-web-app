<fieldset disabled="disabled">

    <div class="form-group guardian-info align-self-center">
            <span class="member-face">
                    <img src="{{asset($user['profile_image']) }}">
            </span>
            <span class="guardian-name align-self-center"> {{ $user['name'] }} </span>
    </div>

    <div class="form-group">
        <label>Data de Nascimento:</label>
        <input type="name" class="form-control" value=" {{ $user['birthdate'] }}">
    </div>

    <div class="form-group">
        <label>Descrição:</label>
        <textarea class="form-control" draggable="false">{{ $user['description'] }}</textarea>
    </div>

    <div class="form-group ">
        <label>Endereço de email:</label>
        <input type="email" class="form-control" value="{{ $user['email'] }}">
    </div>

    
</fieldset>