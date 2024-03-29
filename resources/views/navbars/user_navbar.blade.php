@if(Auth::user()->is_guardian || session()->has('parent'))
    <div class="modal fade" id="manage-children-modal" tabindex="-1" role="dialog"
         aria-labelledby="manage-children-modal-Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manage-children-modal">Educandos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div data-toggle="modal" data-target="#manage-children-modal" class="modal-body member-container"
                     id="manage-kids-faces">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Perfil de Encarregado</button>
                    <button type="button" class="btn btn-primary">Selecionar</button>
                </div>
            </div>
        </div>
    </div>
@endif


@include('notifications.notification_list')


<nav id="navbar" class="navbar navbar-expand-lg navbar-light ">
    <a class="navbar-brand" href="{{ route('/') }}" id="website-name">
        <img src="../icons/favicon.png" width="35" height="35" class="d-inline-block align-top"
             alt=""> {{ config('app.name', 'Laravel') }}
    </a>
    <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <form class="form-inline mr-2" method="GET" action="/search">
                <span id="search">
                    <input type="hidden" name="resource" value="simple">
                    <input name="query" class="form-control" type="search" placeholder="Pesquisa" aria-label="Search">
                    <button class="nav-search-button" type="submit"><i class="fas fa-search search-icon"></i></button>
                </span>
            </form>

            @if(Auth::user()->is_guardian || session()->has('parent'))
                <li>
                <span>
                    <a data-toggle="modal" data-target="#manage-children-modal" href="#"
                       class="navbar-text navbar-manage-kid" onClick="placeChildren()">
                        Gerir educando
                    </a>
                </span>
                </li>
            @endif


            <li>
                <a class="navbar-section-manage navbar-text" href="/manage-section/1">
                    Gerir secção
                </a>
            </li>
            <li>
                <a class="user-name navbar-text" href="{{route('profile', [Auth::id()]) }}">
                    {{Auth::user()->name }}
                </a>
            </li>
            <li>
                <span id="notification-bell" data-toggle="tooltip" data-placement="right" title="Notificações">
                    <a class="navbar-text" id="notifications-toggle" tabindex="0" data-toggle="popover"
                       data-trigger="focus" title="Notificações" data-placement="bottom">
                        <i class="far fa-bell"></i>
                    </a>
                </span>
            </li>
        </ul>
    </div>
</nav>
