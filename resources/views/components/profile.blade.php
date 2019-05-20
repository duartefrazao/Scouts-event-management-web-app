
<div class="container col-lg-6 col-xs-10" id="profile-page">
    <form enctype="multipart/form-data" method="POST" action="/api/users/{{$user->id}}">
        {{csrf_field()}}
        {{method_field("PUT")}}

        <div class="profile-top">
                <img src="{{asset($user->profile_image) }}"
                     class="rounded mx-auto d-block profile-image" alt="...">
        
                @if(session()->has('parent')|| Auth::user()->is_responsible)
                    <label for="new-profile-image">
                        <i class="fas fa-pen-square fa-2x profile-edit-image "> </i>
                    </label>
                @endif
        
                <input name="profile-image" id="new-profile-image" type="file" />
        
        
        
        </div>
        <h2 class="profile-section-name"> {{$user->section}} </h2>
        <hr class="profile-line-identified">

        <fieldset class="profile-information" disabled>
            <div class="form-group profile-form-group">
                <label>Nome</label>
                <input name="name" type="text" class="form-control" placeholder="O teu nome" value="{{$user->name}}" id="profile_name" required>
            
            </div>

            <div class="form-group profile-form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control profile-description" draggable="false"
                          rows="3" id="profile_description">{{$user->description}} </textarea>
               
            </div>

            <div class="form-group profile-form-group">
                <label>Endereço de email</label>
                    <input name="email" type="email" id="profile_email" class="form-control" placeholder="O teu email" value="{{$user->email}}" >
                   
            </div>

        </fieldset>
        @include('components.errors')

        @if(session()->has('parent')|| Auth::user()->is_responsible)
        <div class="profile-edit">
            <?php if($user->id == Auth::id()){ ?>
                <a href="{{route('logout', [Auth::id()]) }}" > <button type="button"  class="btn btn btn-danger" >Terminar Sessão</button> </a>
                <i class="fas fa-pen-square fa-3x account-manage"></i>
            <?php } ?>
            <div class="profile-form-btns">
                <button type="button" id="undo-action" class="btn btn-warning">Cancelar</button>
                <button type="submit" class="btn btn-success profile-update-btn">Atualizar</button>
            </div>
        </div>

        @endif




    </form>

</div>

