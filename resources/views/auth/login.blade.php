@extends('layouts.app')

@section('navbar')
    @include('components.initial_navbar')
@endsection

@section('content')

    @component('components.login')
    @endcomponent

    @component('components.contacts')
    @endcomponent

    
@endsection
