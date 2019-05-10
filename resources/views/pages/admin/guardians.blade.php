@extends('layouts.app')

@section('title', 'Admin Board')

@section('navbar')
    @include('navbars.admin_navbar', ['active' => 'guardians'])
@endsection



@section('content')

    <div class="container-fluid" id="admin-content">
        <div id="guardians">
            @include('partials.admin.exchanges', ['exchanges' => $exchanges])
        </div>
    </div>


@endsection