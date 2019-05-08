@extends('layouts.app')

@section('title', 'Notifications')

@section('navbar')
    @include('navbars.user_navbar')
@endsection

@section('content')

    <div class="container col-lg-6 col-xs-11" id="notifications-page">
        <div class="notifications-title"> As tuas notificações</div>
        <ul class="list-group">
            @foreach(Auth::user()->notifications()->limit(3)->get() as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @switch($notification->type)
                        @case('App\Notifications\EventInvitation')
                        @include('notifications.types.event_invitation', ['notification' => $notification])
                        <span class="text-primary"> <i class="fas fa-calendar"></i> </span>
                        @break
                        @case('App\Notifications\EventOrganizerInvitation')
                        @include('notifications.types.event_organizer_invitation', ['notification' => $notification])
                        <span class="text-primary"> <i class="fas fa-calendar"></i> </span>
                        @break
                        @default
                        @break
                    @endswitch
                </li>
            @endforeach
        </ul>
    </div>

@endsection