<div class="container col-lg-6 col-xs-11" id="users-list-page">
    <div class="admin-section-title users"> Utilizadores <input class="form-control" type="search" placeholder="Search"
                                                                aria-label="Search"></div>
    <ul class="nav nav-tabs admin-select-tab" id="users-choice" role="tablist">
        <li class="nav-item">
            <a class="nav-link active " id="all-users-tab" href="#all-users" role="tab" aria-controls="all-users"
               aria-selected="true">Todos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link color-lobitos-tab" id="lobitos-users-tab" href="#lobitos-users" role="tab"
               aria-controls="lobitos-users"
               aria-selected="false">Lobitos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link color-pioneiros-tab" id="pioneiros-users-tab" href="#pioneiros-users" role="tab"
               aria-controls="pioneiros-users"
               aria-selected="false">Pioneiros</a>
        </li>
        <li class="nav-item">
            <a class="nav-link color-exploradores-tab" id="exploradores-users-tab" href="#exploradores-users" role="tab"
               aria-controls="exploradores-users"
               aria-selected="false">Exploradores</a>
        </li>
        <li class="nav-item ">
            <a class="nav-link color-caminheiros-tab" id="caminheiros-users-tab" href="#caminheiros-users" role="tab"
               aria-controls="caminheiros-users"
               aria-selected="false">Caminheiros</a>
        </li>
        <li class="nav-item ">
            <a class="nav-link color-encarregados-tab" id="encarregados-users-tab" href="#encarregados-users" role="tab"
               aria-controls="encarregados-users"
               aria-selected="false">Encarregados</a>
        </li>

    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="all-users" role="tabpanel" aria-labelledby="all-users-tab">
            @each('partials.admin.common.list_user', $users['all'], 'user')
        </div>
        <div class="tab-pane" id="lobitos-users" role="tabpanel" aria-labelledby="lobitos-users-tab">
            @each('partials.admin.common.list_user', $users['lobitos'], 'user')
        </div>
        <div class="tab-pane" id="pioneiros-users" role="tabpanel" aria-labelledby="pioneiros-users-tab">
            @each('partials.admin.common.list_user', $users['pioneiros'], 'user')
        </div>
        <div class="tab-pane" id="exploradores-users" role="tabpanel" aria-labelledby="exploradores-users-tab">
            @each('partials.admin.common.list_user', $users['exploradores'], 'user')
        </div>
        <div class="tab-pane" id="caminheiros-users" role="tabpanel" aria-labelledby="caminheiros-users-tab">
            @each('partials.admin.common.list_user', $users['caminheiros'], 'user')
        </div>
        <div class="tab-pane" id="encarregados-users" role="tabpanel" aria-labelledby="encarregados-users-tab">
            @each('partials.admin.common.list_user', $users['guardians'], 'user')
        </div>
    </div>
</div>