<li class="list-group-item">
    <div class="pending-single-info d-flex flex-md-row flex-column">
        <div class="align-self-center name-toggle" data-toggle="collapse" data-target="#register-serial-{{$request['id']}}"
             aria-expanded="false" aria-controls="register-serial-{{$request['id']}}">
                {{ $request['name'] }} -
            @if($request['type'] == "guardian" )
                Registo com Encarregado de Educação
            @else
                Registo Simples
            @endif
        </div>
        <span class="member-face"> </span>
        <button type="button" class="btn btn-success registration-accept" data-id="{{$request['id']}}">Aceitar</button>
        <button type="button" class="btn btn-danger registration-reject" data-id="{{$request['id']}}">Reset</button>
    </div>
    <div class="collapse pending pt-1" id="register-serial-{{ $request['id'] }}">
        <div class="card card-body">
            @include('partials.admin.common.user_info', ['user' => $request])
        </div>
    </div>
</li>