@extends('layouts.app')

@section('title', $event->title)

@section('navbar')
    @include('components.user_navbar')
@endsection

@section('content')
    @include('partials.event', ['event' => $event])
@endsection
