
<div class="container col-lg-6 col-xs-10" id="profile-page">
    <div class="profile-top">
        <img src="https://avatars3.githubusercontent.com/u/19807634?s=460&v=4"
             class="rounded mx-auto d-block profile-image" alt="...">

        <label for="file-input">
            <i class="fas fa-pen-square fa-2x profile-edit-image "> </i>
        </label>

        <input id="file-input" type="file" />



    </div>
    <h2 class="profile-section-name"> {{$user->section}} </h2>
    <hr class="profile-line-identified">




    <form>
        <fieldset class="profile-information" disabled="disabled">
            <div class="form-group profile-form-group">
                <label>Nome</label>
                <input type="name" class="form-control" placeholder="O teu nome" value="{{$user->name}}" id="profile_name">
            </div>

            <div class="form-group profile-form-group">
                <label>Descrição</label>
                <textarea class="form-control profile-description" draggable="false"
                          rows="3" id="profile_description">{{$user->description}}</textarea>
            </div>

            <div class="form-group profile-form-group">
                <label>Endereço de email</label>
                    <input type="email" id="profile_email" class="form-control" placeholder="O teu email" value="{{$user->email}}" >
            </div>
        </fieldset>

        <div class="profile-edit">
            <a href="{{route('logout', [Auth::id()]) }}" class="btn btn btn-danger" role="button">Terminar Sessão</a>
            <i class="fas fa-pen-square fa-3x account-manage"></i>
        </div>


        <div class="profile-form-btns">
            <button type="button" id="undo-action" class="btn btn-warning">Cancelar</button>
            <button type="submit" class="btn btn-success profile-update-btn">Atualizar</button>
        </div>

    </form>

</div>

