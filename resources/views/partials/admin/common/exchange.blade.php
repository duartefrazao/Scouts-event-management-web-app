<div class="list-group-item guardian-exchange mt-4">
    <div class="guardians">
        <div class="col from">
            <legend> De:</legend>
            @include('partials.admin.common.user_info', ['user' => $exchange['from']])
        </div>
        <div class="col-auto align-self-center arrow">
            <i class="fas fa-arrow-right fa-2x arrow-desktop"></i>
            <i class="fas fa-arrow-down fa-1.5x arrow-mobile"></i>
        </div>
        <div class="col to">
            <legend> Para:</legend>
            @include('partials.admin.common.user_info', ['user' => $exchange['to']])
        </div>
    </div>
    <div class="row exchanged">
        <legend> Escuteiro:</legend>
        @include('partials.admin.common.user_info', ['user' => $exchange['user']])
    </div>
    <div class="row buttons">
        <button type="button" class="btn btn-danger">Recusar</button>
        <button type="button" class="btn btn-success">Aceitar</button>
    </div>
</div>