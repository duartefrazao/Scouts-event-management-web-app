@extends('layouts.app')

@section('navbar')
    @include('navbars.empty_navbar')
@endsection

@section('content')

<div class="container col-lg-7 col-md-9 col-xs-11" id="accordionExample">
    <div id="faq-header">
        Questões Frequentes
    </div>
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    Qual a informação necessária para o registo?
                </button>
            </h2>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                Todo os utilizadores têm de fornecer os seguintes dados:
                <ul>
                    <li> Primeiro e último nome </li>
                    <li> Email </li>
                    <li> Data de Nascimento </li>
                </ul>
                Caso se trate do registo de um escuteiro menor de idade, os dados do seu encarregado de educação também terão de ser inseridos.
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="false" aria-controls="collapseTwo">
                    Como funciona o processo de registo?
                </button>
            </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                Após a inserção dos dados, o pedido de registo será enviado para o administrador do site para confirmação. Uma vez validado, receberá no email
                fornecido no registo uma notificação a avisar que já pode entrar no sistema. 
                Caso o pedido, por alguma razão, seja recusado, também será notificado.
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingThree">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="false" aria-controls="collapseThree">
                    Posso controlar a ativadade do meu educandos no sistema?
                </button>
            </h2>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
                Sim. O sistema fornece a todos os Encarregados de Educação uma ferramenta de controlo de atividade dos respetivos educandos.
                Com esta ferramenta poderá aceder à conta do seu educando e visualizar/editar a sua informação. Isto também envolve confirmar
                ou negar idas a eventos.
            </div>
        </div>
    </div>
</div>

@endsection('content')
