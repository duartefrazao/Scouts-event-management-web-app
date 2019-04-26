@extends('layouts.app')

@section('title', 'Admin Board')

@section('navbar')
    @include('components.admin_navbar')
@endsection



@section('content')

    <div class="container-fluid" id="admin-content">
        <div class="tab-content">
            <div class="tab-pane active" id="pending-users" role="tabpanel" aria-labelledby="pending-tab">

                <div class="container col-lg-6 col-xs-10 col-md-10 col-sm-10" id="pending-content">
                    <div class="admin-section-title"> Registos</div>
                    @each('partials.admin.list_user', $users, 'user')
                </div>

            </div>
            <div class="tab-pane " id="users" role="tabpanel" aria-labelledby="users-tab">
            </div>
            <div class="tab-pane " id="guardians" role="tabpanel"
                 aria-labelledby="guardians-tab"></div>
            <div class="tab-pane " id="managers" role="tabpanel"
                 aria-labelledby="managers-tab"></div>
        </div>
    </div>


@endsection
