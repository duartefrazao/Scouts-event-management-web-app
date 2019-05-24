<div id="{{$id}}" class="modal" tabindex="-1" role="dialog">
    @php
    switch($id){
        case 'moderatorModal':
            $ident = 'Moderadores';
            break;
        case 'organizerModal':
            $ident = 'Organizadores';
            break;
        default:
            $ident = 'Membros';
            break;
    }
    @endphp
    
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar {{$ident}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input id="invite-members" type="text" class="input-transparent input-border" placeholder="Pesquisa">

                <div class="search-results">
                </div>

                <div class="added-members">
                    <header>
                        <h4>{{$ident}} adicionados</h4>
                    </header>
                    <div class="list-members">

                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary save-members" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>