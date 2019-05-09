@extends('layouts.app')

@section('title', 'Admin Board')

@section('navbar')
    @include('navbars.admin_navbar', ['active' => 'sections'])
@endsection



@section('content')

    <div class="container-fluid" id="admin-content">
        <div id="managers">
            @include('partials.admin.moderators', ['moderators' => $moderators])
        </div>
    </div>


@endsection