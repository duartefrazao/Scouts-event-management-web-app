<div class="container col-lg-6 col-xs-11 search-options" >
    <div class="admin-section-title"> Pesquisa </div>
    <span class="advanced-toggle"> Pesquisa avançada <i class="fas fa-arrow-down"></i> </span>
    <div class="advanced-search">
        <ul class="nav nav-tabs search-choices" id="users-choice" role="tablist">
            <li class="nav-item">
                <a class="nav-link active " id="search-users-tab" href="#search-users" role="tab"
                    aria-controls="all-users" aria-selected="true"> Utilizadores </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="search-events-tab" href="#search-events" role="tab"
                    aria-controls="search-events" aria-selected="false"> Eventos </a>
            </li>

        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="search-users" role="tabpanel" aria-labelledby="search-users-tab">
                @component('components.search.options_users',compact('query'))
                @endcomponent
            </div>
            <div class="tab-pane" id="search-events" role="tabpanel" aria-labelledby="search-events-tab">
                @component('components.search.options_events',compact('query'))
                @endcomponent
            </div>
        </div>
    </div>
</div>