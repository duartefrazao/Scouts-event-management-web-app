
@if(isset($events) && collect($events)->isNotEmpty())
    <div class="search-section-title">
        Eventos
    </div>
    <div id="events-cards" class="container-fluid events-flex ">
        @each('partials.event', $events, 'event')
        
    </div>
@endif

@if(isset($groups) && collect($groups)->isNotEmpty())
    <div class="search-section-title">
        Grupos
    </div>
    <div id="groups" class="container-fluid group-container">
        @each('partials.group', $groups, 'group')
    </div>
@endif

@if(isset($users) && collect($users)->isNotEmpty())
    <div class="search-section-title">
        Utilizadores
    </div>
    <div id="users" class="container-fluid user-container">
        @each('partials.user', $users, 'user')
    </div>
@endif
