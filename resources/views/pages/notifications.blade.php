@extends('layouts.app')

@section('title', 'Notifications')

@section('navbar')
    @include('navbars.user_navbar')
@endsection

@section('content')

    <div class="container col-lg-6 col-xs-11" id="notifications-page">
        <div class="notifications-title"> As tuas notificações </div>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="#">
                    <span class="notification-important"> João </span> também comentou no
                    grupo Caminheiros!
                </a>
                <span class="text-primary"> <i class="fas fa-users"></i> </span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="#">
                Atenção! O teu evento <span class="notification-important"> XPTO </span> é amanhã.
            </a>
                <span class="text-primary"> <i class="fas fa-calendar"></i> </span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="#">
                <span class="notification-important"> António </span> e <span class="notification-important">
                    Diogo </span> também vão a 4 eventos na terça!
                </a>
                <span class="text-primary">  <i class="fas fa-calendar"></i></span>
            </li>
        </ul>
    </div>

@endsection