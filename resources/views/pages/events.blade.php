@extends('layouts.app')

@section('title', 'Events')

@section('navbar')
    @include('components.user_navbar')
@endsection

@section('content')

    <section id="events">
        @each('partials.event', $events, 'event')
    </section>

@endsection


