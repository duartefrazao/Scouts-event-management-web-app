@extends('layouts.app')

@section('title', 'Events')

@section('navbar')
    @include('components.user_navbar')
@endsection

@section('content')
    <div id="home-container" class="container-fluid col-xs-12">
        <nav>
            <div class="nav nav-tabs " id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-event-tab" href="#events" role="tab" aria-controls="events"
                   aria-selected="true"> <i class="fas fa-calendar-check"></i> Events</a>
                <a class="nav-item nav-link" id="nav-groups-tab" href="#groups" role="tab" aria-controls="nav-groups"
                   aria-selected="false"> <i class="fas fa-users"></i> Groups</a>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="events" role="tabpanel" aria-labelledby="nav-event-tab">

                <div id="events" class="container-fluid events-flex ">
                    @each('partials.event', $events, 'event')
                    <div class="event-wrap">
                        <a class="card-wrap" href="">
                            <div class="card formatting-card">
                            </div>
                        </a>
                    </div>
                    <div class="event-wrap">
                        <a class="card-wrap" href="">
                            <div class="card formatting-card">
                            </div>
                        </a>
                    </div>
                </div>
                <a href="event/create">
                    <img data-toggle="tooltip" data-placement="top" title="Criar evento"
                         src="../icons/plus-icon-white.png" class="add-icon"/>
                </a>
            </div>

            <div class="tab-pane fade" id="groups" role="tabpanel" aria-labelledby="nav-groups-tab">
                <div id="groups" class="container-fluid group-container">
                    @each('partials.group', $groups, 'group')
                </div>
                <a href="../pages/create_group.php">
                    <img data-toggle="tooltip" data-placement="top" title="Criar grupo"
                         src="../icons/plus-icon-white.png" class="add-icon"/>
                </a>
            </div>

        </div>
    </div>


@endsection


