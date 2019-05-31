<li class="list-group-item">
    <div class="pending-single-info d-flex flex-md-row flex-column">
        <div class="align-self-center name-toggle" data-toggle="collapse" data-target="#register-serial-{{$user['id']}}"
             aria-expanded="false" aria-controls="register-serial-{{$user['id']}}">
                {{ $user['name'] }} 
        </div>
        <span class="member-face"> </span>
        <button type="button" class="btn btn-success registration-accept" data-id="{{$user['id']}}">Aceitar</button>
        <button type="button" class="btn btn-danger registration-reject" data-id="{{$user['id']}}">Reset</button>
    </div>
    <div class="collapse pending pt-1" id="register-serial-{{ $user['id'] }}">
        <div class="card card-body">
            @include('partials.admin.common.user_info', ['user' => $user])
            
        </div>
    </div>
</li>