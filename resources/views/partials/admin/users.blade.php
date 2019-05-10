<div class="container col-lg-6 col-xs-11" id="users-list-page">
    <div class="admin-section-title users"> Utilizadores

        <form class="form-inline ml-auto" method="GET" action="{{ route('admin.searchUsers') }}">
            {{ csrf_field() }}
            <input class="form-control" type="search" placeholder="Search" name ="name"
                   aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Pesquisa</button>
        </form>
    </div>
    <ul class="nav nav-tabs admin-select-tab" id="users-choice" role="tablist">
        <li class="nav-item">
            <a class="nav-link active " id="all-users-tab" href="#all" role="tab" aria-controls="all-users"
               aria-selected="true">Todos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link color-lobitos-tab" id="lobitos-users-tab" href="#lobitos" role="tab"
               aria-controls="lobitos"
               aria-selected="false">Lobitos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link color-pioneiros-tab" id="pioneiros-users-tab" href="#pioneiros" role="tab"
               aria-controls="pioneiros"
               aria-selected="false">Pioneiros</a>
        </li>
        <li class="nav-item">
            <a class="nav-link color-exploradores-tab" id="exploradores-users-tab" href="#exploradores" role="tab"
               aria-controls="exploradores"
               aria-selected="false">Exploradores</a>
        </li>
        <li class="nav-item ">
            <a class="nav-link color-caminheiros-tab" id="caminheiros-users-tab" href="#caminheiros" role="tab"
               aria-controls="caminheiros"
               aria-selected="false">Caminheiros</a>
        </li>
        <li class="nav-item ">
            <a class="nav-link color-encarregados-tab" id="encarregados-users-tab" href="#encarregados" role="tab"
               aria-controls="encarregados"
               aria-selected="false">Encarregados</a>
        </li>

    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="all" role="tabpanel" aria-labelledby="all-users-tab">
            @each('partials.admin.common.list_user', $users['all'], 'user')
        </div>
        <div class="tab-pane" id="lobitos" role="tabpanel" aria-labelledby="lobitos-users-tab">
            @each('partials.admin.common.list_user', $users['lobitos'], 'user')
        </div>
        <div class="tab-pane" id="pioneiros" role="tabpanel" aria-labelledby="pioneiros-users-tab">
            @each('partials.admin.common.list_user', $users['pioneiros'], 'user')
        </div>
        <div class="tab-pane" id="exploradores" role="tabpanel" aria-labelledby="exploradores-users-tab">
            @each('partials.admin.common.list_user', $users['exploradores'], 'user')
        </div>
        <div class="tab-pane" id="caminheiros" role="tabpanel" aria-labelledby="caminheiros-users-tab">
            @each('partials.admin.common.list_user', $users['caminheiros'], 'user')
        </div>
        <div class="tab-pane" id="encarregados" role="tabpanel" aria-labelledby="encarregados-users-tab">
            @each('partials.admin.common.list_user', $users['guardians'], 'user')
        </div>
    </div>
</div>