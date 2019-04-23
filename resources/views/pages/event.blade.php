@extends('layouts.app')

@section('title', $event->title)

@section('navbar')
    @include('components.user_navbar')
@endsection

@section('content')

<div class="event-page container-fluid col-xs-11 col-sm-10 col-lg-6">


    <div class="modal-body">

        <h5 class="event-title" data-id="{{$event->id}}">{{$event->title}}</h5>

        <div class="first-row">
            <!-- the icon as a time element -->
            <a class="" data-toggle="collapse" href="#date-poll" role="button" aria-expanded="false" aria-controls="date-poll">

            <time datetime="2019-03-03" class="icon">
                <span class="event-card-month">Selecione</span>
                <span class="event-card-day">Data</span>
                <span class="event-card-week-day"></span>
            </time>

            </a>
            <div class="collapse" id="date-poll">

            <ul class="available-dates">
                <li>
                    <div class="custom-control custom-checkbox" style="float:left; margin-right:1em;">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked1">
                        <label class="custom-control-label" for="defaultUnchecked1">10/03 18:00 </label>
                    </div>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0"
                            aria-valuemax="100">50%</div>
                    </div>
                </li>

                <li>
                    <div class="custom-control custom-checkbox" style="float:left; margin-right:1em;">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked2">
                        <label class="custom-control-label" for="defaultUnchecked2">10/03 20:00 </label>
                    </div>

                    <div class="progress">

                        <div class="progress-bar" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0"
                            aria-valuemax="100">15%</div>
                    </div>
                </li>

                <li>
                    <div class="custom-control custom-checkbox" style="float:left; margin-right:1em;">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked3">
                        <label class="custom-control-label" for="defaultUnchecked3">12/03 17:00 </label>
                    </div>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0"
                            aria-valuemax="100">35%</div>
                    </div>
                </li>
            </ul>
            </div>

            <div class="btn-group-toggle presence d-flex" data-toggle="buttons">
                <label class="btn btn-light confirm-presence">
                    <input type="radio" name="presence" checked autocomplete="off"><i class="fal fa-check"></i> Vou
                </label>

                <label class="btn btn-light deny-presence">
                    <input type="radio" name="presence" checked autocomplete="off"><i class="fal fa-times"></i> Não vou
                </label>
            </div>

            <div class="member-container">
            </div>

        </div>


        <hr>


        <div class="description-container">
            <header>
                <h3 class="common-page-subtitle">Descrição</h3>
            </header>
            <p>
                <i class="far fa-euro-sign fa-sm"></i>
                <i class="far fa-euro-sign fa-sm"></i>
                <i class="far fa-euro-sign fa-sm"></i>
                <strong>{{$event->price}}</strong>
            </p>
            <p>
            {{$event->description}}
            </p>
        </div>
        <div class="map-container">
            <h6 class="map-caption"><i class="fas fa-map-marker-alt fa-sm"></i>{{$event->loc_name}}</h6>
            <div class="map"></div>
        </div>

        <div class="file-container">
            <header>
                <h3 class="common-page-subtitle">Ficheiros</h3>
            </header>
            <span>
                <button type="button" class="btn btn-secondary"><i class="far fa-arrow-alt-circle-down"></i>
                    File1.pdf</button>
                <button type="button" class="btn btn-secondary"><i class="far fa-arrow-alt-circle-down"></i>
                    File2.pdf</button>
                <button type="button" class="btn btn-secondary"><i class="far fa-arrow-alt-circle-down"></i>
                    File3.pdf</button>
                <button type="button" class="btn btn-secondary"><i class="far fa-arrow-alt-circle-down"></i>
                    File4.pdf</button>
                <button type="button" class="btn btn-secondary"><i class="far fa-arrow-alt-circle-down"></i>
                    File5.pdf</button>
            </span>
        </div>

        <hr>


        <div class="organizer-container">
            <header>
                <h3 class="common-page-subtitle">Organizadores do Evento</h3>
            </header>

            <div class="member-container">

            </div>

        </div>

        <hr>

        <div class="event-comments">

            <h3 class="common-page-subtitle"> Comentários </h3>

            <div class="row col-11">
                <textarea class="input-description input-transparent w-100 input-border" wrap="hard"
                    placeholder="Adicione um comentário.."></textarea>
            </div>

            <div class="row col-11">
                <div class="col-12 event-comment ">
                    <span class="comment-author"> João </span>
                    <span class="comment-body">Este evento é mesmo fixe! </span>
                </div>
            </div>
            <div class="row col-11">
                <div class="col-12 event-comment ">
                    <span class="comment-author"> Pedro </span>
                    <span class="comment-body">Vamos todos caminhar!</span>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
    </div>
</div>
@endsection
