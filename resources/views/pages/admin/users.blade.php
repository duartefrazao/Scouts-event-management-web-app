@extends('layouts.app')

@section('title', 'Admin Board')

@section('navbar')
    @include('navbars.admin_navbar', ['active' => 'users'])
@endsection



@section('content')

    <div class="container-fluid" id="admin-content">
        <div id="users">
            @include('partials.admin.users', ['users' => $users])
        </div>
    </div>


@endsection