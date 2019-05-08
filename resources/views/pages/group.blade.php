@extends('layouts.app')

@section('title', $group->title)

@section('navbar')
    @include('navbars.user_navbar')
@endsection

@section('content')

<div class="group-page container-fluid events-flex">
        <div class="modal-body">
            
            <h5 class="group-title container-fluid col-xs-11 col-sm-10 col-lg-6">{{$group->name}}</h5>
        
            <div class="group-events event-wrap">
                <div class="container events-flex">
                @each('partials.event', $group->events, 'event')
                </div>
            </div>

            <div class="container-fluid col-xs-11 col-sm-10 col-lg-6">

                <hr>

                <div class="moderators-container">
                    <header>
                        <h3 class="common-page-subtitle">Moderadores</h3>
                    </header>

                    <div class="member-container container">
                        @foreach($group->moderators as $moderator)
                            <div class="member-wrap">
                                <img src="{{asset('images/profile.jpg')}}" class="rounded-circle" />
                                <a href="#" class="group-member-name">{{$moderator->name}}</a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr>

                <div class="members-container">
                    <header>
                        <h3 class="common-page-subtitle">Membros</h3>
                    </header>

                    <div class="member-container container"> 
                        @foreach($group->members as $member)
                            <div class="member-wrap">
                                <img src="{{asset('images/profile.jpg')}}" class="rounded-circle" />
                                <a href="#" class="group-member-name">{{$member->name}}</a>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

        <div class="modal-footer">
        </div>

    </div>

@endsection('content')