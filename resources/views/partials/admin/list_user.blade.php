<li class="list-group-item user-list-info {{ $user['type'] }}" data-id="{{$user['id']}}">
    <div class=" d-flex flex-md-row flex-column">
        <div class="align-self-center name-toggle" data-toggle="collapse" data-target="#register-serial-{{ $user['id'] }}"
             aria-expanded="false" aria-controls="register-serial- {{ $user['id'] }}">
            <div class="registration_name">
                    <input name="id" type="hidden" value="{{$user['id']}}">
                    {{ $user['name'] }}
            </div>
        </div>
        <span class="member-face"> </span>
    </div>
    <div class="collapse pending pt-1" id="register-serial-{{$user['id'] }}">
        <div class="card card-body">
        </div>
    </div>
</li>