<div class="container col-lg-6 col-xs-11" id="managers-content">
    <div class="admin-section-title"> Gestão de Secções</div>
    <ul class="nav nav-tabs admin-select-tab" id="section-choice" role="tablist">
        <li class="nav-item">
            <a class="nav-link active color-lobitos-tab" id="lobitos-section-tab" href="#lobitos-section" role="tab"
               aria-controls="lobitos-section" aria-selected="false">Lobitos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link color-pioneiros-tab" id="pioneiros-section-tab" href="#pioneiros-section" role="tab"
               aria-controls="pioneiros-section" aria-selected="false">Pioneiros</a>
        </li>
        <li class="nav-item">
            <a class="nav-link color-exploradores-tab" id="exploradores-section-tab" href="#exploradores-section"
               role="tab" aria-controls="exploradores-section" aria-selected="false">Exploradores</a>
        </li>
        <li class="nav-item">
            <a class="nav-link color-caminheiros-tab" id="caminheiros-section-tab" href="#caminheiros-section"
               role="tab" aria-controls="caminheiros-section" aria-selected="false">Caminheiros</a>
        </li>
    </ul>


    <div class="tab-content">
        <div class="tab-pane active" id="lobitos-section" role="tabpanel" aria-labelledby="lobitos-section-tab">
            @include('partials.admin.common.moderators_list', ['section' => 'lobitos', 'moderators'=> $moderators])
        </div>
        <div class="tab-pane" id="pioneiros-section" role="tabpanel" aria-labelledby="pioneiros-section-tab">
            @include('partials.admin.common.moderators_list', ['section' => 'pioneiros', 'moderators'=> $moderators])
        </div>
        <div class="tab-pane" id="exploradores-section" role="tabpanel" aria-labelledby="exploradores-section-tab">
            @include('partials.admin.common.moderators_list', ['section' => 'exploradores', 'moderators'=> $moderators])
        </div>
        <div class="tab-pane" id="caminheiros-section" role="tabpanel" aria-labelledby="caminheiros-section-tab">
            @include('partials.admin.common.moderators_list', ['section' => 'caminheiros', 'moderators'=> $moderators])
        </div>
    </div>


    <button type="button" class="btn btn-success add-manager"> Adicionar</button>

</div>