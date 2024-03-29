
<div class="container col-lg-6 col-xs-10" id="profile-page">
    <form enctype="multipart/form-data" method="POST" action="/api/users/{{$user->id}}" class="form_image">
        {{csrf_field()}}
        {{method_field("PUT")}}

        <div class="profile-top">
                <span class="member-face-registration">
                    <img src="{{asset($user->profile_image) }}" 
                    
                    @if(session()->has('parent')|| Auth::user()->is_responsible)
                        data-toggle="modal" data-target="#uploadImageModal" id="select-image-btn"
                    @endif
                    
                    />
                </span>
                
                <input name="originalFile" class="input_hidden " id="upload" type="file" />
                
        
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

        
        <div class="profile-edit">
            <?php if($user->id == Auth::id()){ ?>
                <a href="{{route('logout', [Auth::id()]) }}" > <button type="button"  class="btn btn btn-danger" >Terminar Sessão</button> </a>
                @if(session()->has('parent')|| Auth::user()->is_responsible)
                    <i class="fas fa-pen-square fa-3x account-manage"></i>
                    <div class="profile-form-btns">
                        <button type="button" id="undo-action" class="btn btn-warning">Cancelar</button>
                        <button type="submit" class="btn btn-success profile-update-btn">Atualizar</button>
                    </div>
                @endif
            <?php } ?>
        </div>





    </form>
</div>
</div>
@include('components.image_crop')

