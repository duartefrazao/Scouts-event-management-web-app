@extends('layouts.app')

@section('title', 'Create event')

@section('navbar')
    @include('navbars.user_navbar')
@endsection

@section('content')

<script src="../js/event.js" type="text/javascript" defer></script>

    <div class="event-page container-fluid col-xs-11 col-sm-10 col-lg-8 pb-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form method="POST" action="{{ route('createEvent') }}" enctype="multipart/form-data" id="createEvent">
            {{ csrf_field() }}
            <input type="text" class="event-title input-transparent w-100 input-border"
                   value="{{old('title')}}" name="title" placeholder="Título">


            <div class="description-container event-container">
                <header>
                    <h3 class="common-page-subtitle">Descrição</h3>
                </header>

                <textarea class="input-description input-transparent w-100 input-border" name="description"
                          placeholder="Escreve a descrição do evento..."
                >@if(old('description', null) != null){{old('description')}}@endif</textarea>


                <div class="price-box mt-3">
                    <i class="euro-sign fas fa-euro-sign "></i>
                    <input type="number" name="price" value="{{old('price')}}"
                           class="input-price input-transparent input-border"
                           placeholder="Custo">
                </div>


            </div>

            <div class="location-container event-container">
                <header>
                    <h3 class="common-page-subtitle">Localização</h3>
                </header>
                <span>
                    <input type="hidden" name="location">
                    <input list="location" class="custom-select">
                    <datalist id="location">
                    @foreach($locations as $location)
                            <option data-value="{{$location->id}}" value="{{$location->name}}">
                        @endforeach
                    <option data-value="-1" value="Criar uma localização nova"></option>
                   </datalist>
                </span>
                @include('components.location_create')
            </div>

            <div class="date-container event-container mt-4 ">
                <header>
                    <h3>Datas</h3>
                </header>

                <ul class="nav nav-tabs d-flex justify-content-center mb-2" id="dateSelectionNav" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="selectDate-tab" data-toggle="tab" href="#chooseDate" role="tab"
                           aria-controls="chooseDate" aria-selected="true">Selecionar Datas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="createPoll-tab" data-toggle="tab" href="#createPoll" role="tab"
                           aria-controls="createPoll" aria-selected="false">Criar Sondagem</a>
                    </li>
                </ul>
                <div class="tab-content" id="dateSelectionContent">
                    <div class="tab-pane fade show active" id="chooseDate" role="tabpanel"
                         aria-labelledby="selectDate-tab">
                        <div class="date-selection d-flex flex-sm-column flex-md-row flex-column justify-content-center">
                            {{--                            <label for="start_date">Data inicial:</label>
                                                        <input type="datetime-local" class="form-control" name="start_date" id="start_date"
                                                               value="{{ old('start_date') }}">


                                                        <label for="final_date">Data final:</label>
                                                        <input type="datetime-local" class="form-control" id="final_date" name="final_date"
                                                               value="{{ old('final_date') }}">--}}

                            {{--<input type="text" id="dateSelectionInput" name="datetimes" />--}}

                            <div id="dateSelection">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <input type="text" id="dateSelectionInput" name="datetimes"/> <i
                                        class="fa fa-caret-down"></i>
                            </div>

                        </div>

                    </div>
                    <div class="tab-pane fade" id="createPoll" role="tabpanel" aria-labelledby="createPoll-tab">

                        <div class="options-selection">


                        </div>


                        <button id="add-poll-option" type="button"> Adiciona outra opção</button>
                    </div>
                </div>

            </div>


            <div class="add-member-container event-container">

                <h3 class="common-page-subtitle">Participantes</h3>
                <a data-toggle="modal" data-target="#memberModal">
                    <img data-toggle="tooltip"
                         data-placement="top"
                         title="Criar evento"
                         src="../icons/plus-icon-white.png"
                         class="plus-icon"/>
                </a>
                <hr>
                <span class="members-name"></span>
                @include('components.member_selector',['id'=>"memberModal"])

            </div>

            <div class="add-organizer-container event-container">

                <h3 class="common-page-subtitle">Organizadores do Evento</h3>

                <a data-toggle="modal" data-target="#organizerModal" href="">
                    <img data-toggle="tooltip"
                         data-placement="top"
                         title="Criar evento"
                         src="../icons/plus-icon-white.png"
                         class="plus-icon"/>
                </a>
                <hr>
                <span class="organizers-name">
                </span>
                @include('components.member_selector',['id'=>"organizerModal"])
            </div>


            <div class="file-container event-container">
                <header>
                    <h3 class="common-page-subtitle">Ficheiros</h3>
                </header>
                <div class="form-group">
                    <div class="files">

                    </div>
                    <label for="file" class="input-file-btn btn btn-primary"><i class="far fa-plus"></i>
                        Adicionar</label>
                    <input name="files[]" type="file" class="input-file-hidden  form-control-file" id="file" multiple>
                </div>
            </div>


            <div class="event-controls">
                <button type="submit" id="btn-create-event" class="btn btn-primary btn-circle">
                    <i class="fa fa-check"> </i>
                </button>
            </div>
        </form>
    </div>


@endsection