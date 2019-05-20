@extends('layouts.app')

@section('title', 'Events')

@section('navbar')
    @include('navbars.user_navbar')
@endsection

@section('content')
    <div id="home-container" class="container-fluid col-xs-12">
        <nav>
            <div class="nav nav-tabs " id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-event-tab" href="#events" role="tab" aria-controls="events"
                   aria-selected="true"> <i class="fas fa-calendar-check"></i> Eventos</a>
                <a class="nav-item nav-link" id="nav-groups-tab" href="#groups" role="tab" aria-controls="nav-groups"
                   aria-selected="false"> <i class="fas fa-users"></i> Grupos</a>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="events" role="tabpanel" aria-labelledby="nav-event-tab">


                <nav id="calendar-toggle">
                    <div class="nav nav-tabs " id="event-view-toggle" role="tablist">
                        <a class="nav-item nav-link active" id="single-view-tab" href="#nav-list-view" role="tab"
                           aria-controls="nav-list-view" aria-selected="true">
                            <i class="fas fa-th"></i>
                        </a>
                        <a class="nav-item nav-link" id="calendar-view-tab" href="#calendar-view" role="tab"
                           aria-controls="calendar-view" aria-selected="false">
                            <i class="far fa-calendar-alt"></i>
                        </a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabView">
                    <div class="tab-pane fade show active" id="nav-list-view" role="tabpanel"
                         aria-labelledby="single-view-tab">
                        <div id="events-cards" class="container-fluid events-flex ">
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
                    </div>
                    <div class="tab-pane fade pt-4" id="calendar-view" role="tabpanel"
                         aria-labelledby="calendar-view">
                        @include('partials.calendar')
                    </div>
                </div>

                
                @if(Auth::user()->is_responsible)
                    <a href={{route('createEvent')}}>
                        <img data-toggle="tooltip" data-placement="top" title="Criar evento"
                            src="../icons/plus-icon-white.png" class="add-icon"/>
                    </a>
                @endif
            </div>

            <div class="tab-pane fade" id="groups" role="tabpanel" aria-labelledby="nav-groups-tab">
                <div id="groups" class="container-fluid group-container">
                    @each('partials.group', $groups, 'group')
                </div>
                @if(session()->has('parent')|| Auth::user()->is_responsible)
                    <a href="../pages/create_group.php">
                        <img data-toggle="tooltip" data-placement="top" title="Criar grupo"
                            src="../icons/plus-icon-white.png" class="add-icon"/>
                    </a>
                @endif
            </div>

        </div>
    </div>

    @include('components.session_message')
@endsection


