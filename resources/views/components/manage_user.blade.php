<li class="list-group-item promote-user-info">
    <div class=" d-flex flex-sm-row flex-column">
        <div class="align-self-center name-toggle" data-toggle="collapse" data-target="#user-serial-<?= $user->id ?>"
            aria-expanded="false" aria-controls="user-serial-<?= $user->id ?>">
            <span class="member-face"> </span>
            <?= $user->name ?>
        </div>

        
        <label id="user-{{$user->id}}" class="manage-section-label">
            <input id="user-{{$user->id}}" type="checkbox" name="user[]" value="{{$user->id}}" class="manage-section-checkbox"> 
            <i class="align-self-center promote-arrow fas fa-arrow-up"></i>
        </label>
        
    </div>
    <div class="collapse pt-1" id="user-serial-<?= $user->id ?>">
        <div class="card card-body">
            <fieldset disabled="disabled">
                <div class="form-group">
                    <label>Data de Nascimento:</label>
                    <input type="name" class="form-control" placeholder="birthdate" value="<?= $user->birthdate ?>">
                </div>
            
                <div class="form-group">
                    <label>Descrição:</label>
                    <textarea class="form-control" draggable="false"><?= $user->description ?></textarea>
                </div>
            
                <div class="form-group ">
                    <label>Endereço de email:</label>
                    <input type="email" class="form-control" placeholder="O teu email" value="<?= $user->email ?>">
                </div>
            </fieldset>
        </div>
    </div>
</li>