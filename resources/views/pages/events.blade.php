@extends('layouts.app')

@section('title', 'Events')

@section('content')

    <section id="events">
        @each('partials.event', $events, 'event')
    </section>

@endsection


