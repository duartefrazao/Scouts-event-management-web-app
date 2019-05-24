@extends("layouts.app")

@section('title', 'Gerir Secção')


@section('navbar')
    @include('navbars.user_navbar')
@endsection


@section('content')

    <div class="container col-lg-6 col-xs-10 col-md-10 col-sm-10" id="chief-section-manage">
        <div class="section-manage-title"> Gestão de Secção dos Exploradores</div>
    
        <form method="POST" action="/manage-section/{{$section}}" >
            @csrf
            <div class="section-manage-info">
                <span class="section-manage-subtitle"> Novos membros a entrar: </span>
                <button type="button" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-success">Aceitar</button>
            </div>

            <ul class="list-group">
        
                @each('components.manage_user',$users,'user')
        
            </ul>
        </form>
    </div>
@endsection



