<fieldset disabled="disabled">
    <legend> Encarregado de Educação: </legend>
    <div class="form-group guardian-info align-self-center">
        <span class="guardian-name align-self-center"> {{ $user['name'] }} </span>
        <span class="member-face"> </span>
    </div>
    <div class="form-group  ">
        <label>Data de Nascimento:</label>
        <input type="name" class="form-control" placeholder="birthdate" value="{{ $user['birthdate'] }}">
    </div>
    <div class="form-group  ">
        <label>Descrição:</label>
        <textarea class="form-control" draggable="false">{{ $user['description'] }}</textarea>
    </div>

    <div class="form-group  ">
        <label>Endereço de email:</label>
        <input type="email" class="form-control" placeholder="O teu email" value="{{ $user['email'] }}">
    </div>
</fieldset>