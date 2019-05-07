@extends('layouts.app')

@section('navbar')
    @include('navbars.initial_navbar')
@endsection

@section('content')

    @component('components.login')
    @endcomponent

    @component('components.contacts')
    @endcomponent

    
@endsection
