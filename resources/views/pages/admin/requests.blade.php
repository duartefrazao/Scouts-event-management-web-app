@extends('layouts.app')

@section('title', 'Admin Board')

@section('navbar')
    @include('navbars.admin_navbar',['active' => 'requests'])
@endsection



@section('content')

    <div class="container-fluid" id="admin-content">
        <div id="pending-users">
            @include('partials.admin.pending_requests', ['requests' => $requests])
        </div>
    </div>


@endsection
