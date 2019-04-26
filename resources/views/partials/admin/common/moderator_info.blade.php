<li class="list-group-item manager-info">
    <div class="d-flex flex-sm-row flex-column">
        <div class="align-self-center name-toggle" data-toggle="collapse"
             data-target="#manager-serial-{{$moderator['id']}}" aria-expanded="false"
             aria-controls="manager-serial-{{$moderator['id']}}">
            {{ $moderator['name'] }}
            <span class="member-face"> </span>
        </div>
        <button type="button" class="btn btn-danger"> Remover</button>
    </div>
    <div class="collapse pending pt-1" id="manager-serial-{{$moderator['id']}}">
        <div class="card card-body">
            @include('partials.admin.common.user_info', ['user' => $moderator])
        </div>
    </div>
</li>