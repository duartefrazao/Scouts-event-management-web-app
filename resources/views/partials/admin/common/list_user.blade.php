<li class="list-group-item user-list-info {{ $user['type'] }}" data-id="{{$user['id']}}">
    <div class=" d-flex flex-md-row flex-column">
        <div class="align-self-center name-toggle" data-toggle="collapse"
             data-target="#register-serial-{{ $user['id'] }}"
             aria-expanded="false" aria-controls="register-serial- {{ $user['id'] }}">
                    {{ $user['name'] }}
        </div>
        <span class="member-face"> </span>
        <button class="ml-auto btn btn-warning" id="block_user" type="button"> Bloquear </button>
        <button class="ml-1 btn btn-danger" id="remove_user" type="button"> Remover </button>
    </div>
    <div class="collapse pending pt-1" id="register-serial-{{$user['id'] }}">
        <div class="card card-body">
            @include('partials.admin.common.user_info',['user' => $user])
        </div>
    </div>
</li>