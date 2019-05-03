@extends('layouts.app')

@section('navbar')
    @include('components.empty_navbar')
@endsection

@section('content')


<div class="container col-lg-7 col-md-11 about-section">

    <span class="about-title"> Sobre</span>

    <span class="about-initial">

        <p> Na organização de eventos escutistas existe uma grande problemática na dispersão de informação,
            acabando por serem usadas várias plataformas para o mesmo fim. Nesse âmbito, surge o
            <strong>Agrupa</strong>. </p>
        <p>O Agrupa é um sistema de gestão de eventos completamente livre direcionado aos Escuteiros. Oferecemos
            serviços de criação, agendamento e partilha de eventos e grupos.
            Em cada evento é possível criar sondagens, partilhar ficheiros e comentar, permitindo assim um bom ambiente
            social. </p>
        <p>Fornece um serviço de controlo de menores aos encarregados de edução respectivos, estando todas as decisões
            importantes ao cargo do último. </p>


    </span>


    <span class="about-us"> Sobre Nós </span>

    <span class="about-initial">
        <p> Somos uma equipa de 4 pessoas dedicadas a fornecer um serviço de agendamento de eventos
            melhor aos Escuteiros! </p>
    </span>

    <div class="card-deck mt-2">
        <!-- Team Member 1 -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow">
                <img src="../images/team/team_cesar.jpg" class="card-img-top" alt="Membro de Equipa">
                <div class="card-body text-center">
                    <h5 class="card-title mb-0">César Medeiros</h5>
                </div>
            </div>
        </div>
        <!-- Team Member 2 -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow">
                <img src="../images/team/team_duarte.jpg" class="card-img-top" alt="Membro de Equipa">
                <div class="card-body text-center">
                    <h5 class="card-title mb-0">Duarte Frazão</h5>
                </div>
            </div>
        </div>
        <!-- Team Member 3 -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card  shadow">
                <img src="../images/team/team_margarida.jpg" class="card-img-top" alt="Membro de Equipa">
                <div class="card-body text-center">
                    <h5 class="card-title mb-0">Margarida Silva</h5>
                </div>
            </div>
        </div>
        <!-- Team Member 4 -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow">
                <img src="../images/team/team_pedro.JPG" class="card-img-top" alt="Membro de Equipa">
                <div class="card-body text-center">
                    <h5 class="card-title mb-0">Pedro Costa</h5>
                </div>
            </div>
        </div>
    </div>

@endsection('content')