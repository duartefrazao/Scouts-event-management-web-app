<li class="list-group-item">
    <div class="pending-single-info d-flex flex-md-row flex-column">
        <div class="align-self-center name-toggle" data-toggle="collapse" data-target="#register-serial-{{$duplex_regs['scout']['id']}}"
                aria-expanded="false" aria-controls="register-serial-{{$duplex_regs['scout']['id']}}">
                {{ $duplex_regs['scout']['name'] }} - Duplex
        </div>
        <span class="member-face"> </span>
        <button type="button" class="btn btn-success registration-accept" data-id="{{$duplex_regs['scout']['id']}}">Aceitar</button>
        <button type="button" class="btn btn-danger registration-reject" data-id="{{$duplex_regs['scout']['id']}}">Reset</button>
    </div>
    <div class="collapse pending pt-1" id="register-serial-{{ $duplex_regs['scout']['id'] }}">
        <div class="card card-body">
            @include('partials.admin.common.user_info', ['user' => $duplex_regs['scout']])
            {{--TO-DO Código repetido por o parent os atributos começarem por g, retirar isto --}}
            <fieldset disabled="disabled">
                    <legend> Encarregado de Educação: {{ $duplex_regs['parent']['name'] }}</legend>
                    <div class="form-group guardian-info align-self-center">
                        <span class="guardian-name align-self-center"> {{$duplex_regs['parent']['g_name']}} </span>
                        <span class="member-face"> </span>
                    </div>
                    <div class="form-group  ">
                        <label>Data de Nascimento:</label>
                        <input type="name" class="form-control" placeholder="birthdate" value="{{$duplex_regs['parent']['g_birthdate']}}">
                    </div>
                    <div class="form-group  ">
                        <label>Descrição:</label>
                        <textarea class="form-control" draggable="false">{{$duplex_regs['parent']['g_description']}}</textarea>
                    </div>
                
                    <div class="form-group  ">
                        <label>Endereço de email:</label>
                        <input type="email" class="form-control" placeholder="O teu email" value="{{$duplex_regs['parent']['g_email']}}">
                    </div>
                </fieldset>
        </div>
    </div>
</li>