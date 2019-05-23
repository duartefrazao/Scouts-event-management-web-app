@extends('layouts.app')

@section('title', 'Create group')

@section('navbar')
    @include('navbars.user_navbar')
@endsection

@section('content')
    <script src="../js/group.js" type="text/javascript" defer></script>

    <div class="group-page container-fluid col-xs-11 col-sm-10 col-lg-8 pb-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('createGroup') }}" enctype="multipart/form-data" id="createGroup">
            {{ csrf_field() }}

            <input type="text" class="group-title input-transparent w-100 input-border" value="{{old('name')}}"
                   name="name" placeholder="Nome">

            <div class="add-member-container event-container">

                <h3 class="common-page-subtitle">Membros</h3>
                <a data-toggle="modal" data-target="#memberModal">
                    <img data-toggle="tooltip"
                         data-placement="top"
                         title="Criar grupo"
                         alt="Icon com sinal de adicionar"
                         src="../icons/plus-icon-white.png"
                         class="plus-icon"/>
                </a>
                <hr>
                <span class="members-name"></span>
                @include('components.member_selector',['id'=>"memberModal"])

                <div class="add-organizer-container event-container">

                    <h3 class="common-page-subtitle">Moderadores do Evento</h3>

                    <a data-toggle="modal" data-target="#moderatorModal" href="">
                        <img data-toggle="tooltip"
                             data-placement="top"
                             title="Criar grupo"
                             src="../icons/plus-icon-white.png"
                             alt="Icon com sinal de adicionar"
                             class="plus-icon"/>
                    </a>
                    <hr>
                    <span class="moderators-name">
                </span>
                    @include('components.member_selector',['id'=>"moderatorModal"])
                </div>

            </div>

            <div class="event-controls">
                <button type="submit" id="btn-create-event" class="btn btn-primary btn-circle">
                    <i class="fa fa-check"> </i>
                </button>
            </div>
        </form>
    </div>


@endsection('content')