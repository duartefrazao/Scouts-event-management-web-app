@extends('layouts.app')

@section('title', $event->title)

@section('content')
    @include('partials.event', ['event' => $event])
@endsection
