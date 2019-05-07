@extends('layouts.app')

@section('title', 'Admin Board')

@section('navbar')
    @include('navbars.admin_navbar')
@endsection



@section('content')

    <div class="container-fluid" id="admin-content">
        <div class="tab-content">
            <div class="tab-pane active" id="pending-users" role="tabpanel" aria-labelledby="pending-tab">
                @include('partials.admin.pending_requests', ['requests' => $requests])
            </div>
            <div class="tab-pane " id="users" role="tabpanel" aria-labelledby="users-tab">
                @include('partials.admin.users', ['users' => $users])
            </div>
            <div class="tab-pane " id="guardians" role="tabpanel" aria-labelledby="guardians-tab">
                @include('partials.admin.exchanges', ['exchanges' => $exchanges])
            </div>
            <div class="tab-pane " id="managers" role="tabpanel" aria-labelledby="managers-tab">
                @include('partials.admin.moderators', ['moderators' => $moderators])
            </div>
        </div>
    </div>


@endsection
