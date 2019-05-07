@extends("layouts.app")

@section('title', 'Profile')


@section('navbar')
    @include('navbars.user_navbar')
@endsection


@section('content')

    @component('components.profile',['user'=>$user])
    @endcomponent

@endsection

