@extends('layouts.app')

@section('title', 'Events')

@section('navbar')
    @include('components.user_navbar')
@endsection

@section('content')
    <div id="events" class="container-fluid events-flex ">
        @each('partials.event', $events, 'event')
    </div>

@endsection


