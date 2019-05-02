@extends('layouts.app')

@section('title', 'Create event')

@section('navbar')
    @include('components.user_navbar')
@endsection

@section('content')
    <div class="event-page container-fluid col-xs-11 col-sm-10 col-lg-8">

        <input type="text" class="event-title input-transparent w-100 input-border" placeholder="Title" required>

        <div class="date-container event-container">
            <header>
                <h3>Datas</h3>
            </header>

            <div class="date-selection">
                <label for="begin-date">Data inicial:</label>
                <input type="date" class="form-control" id="begin-date" value="{{ old('begin-date') }}">
                @if ($errors->has('begin-date'))
                    <span class="error">
                  {{ $errors->first('begin-date') }}
              </span>
                @endif

                <label for="end-date">Data final:</label>
                <input type="date" class="form-control" id="end-date" value="{{ old('end-date') }}">
                @if ($errors->has('end-date'))
                    <span class="error">
                  {{ $errors->first('end-date') }}
              </span>
                @endif
            </div>
        </div>

        <hr>

        <div class="add-member-container event-container">

            <h3>Membros</h3>
            <a data-toggle="modal" data-target="#memberModal">
                <img data-toggle="tooltip"
                     data-placement="top"
                     title="Criar evento"
                     src="../icons/plus-icon-white.png"
                     class="plus-icon"/>
            </a>


            @include('components.member_selector',['id'=>"memberModal"])

        </div>

        <div class="description-container event-container">
            <header>
                <h3 class="common-page-subtitle">Descrição</h3>
            </header>
            <div class="price-box">
                <i class="euro-sign fas fa-euro-sign "></i>
                <input type="number" class="input-price input-transparent input-border" placeholder="Custo">
            </div>

            <textarea class="input-description input-transparent w-100 input-border" wrap="hard"
                      placeholder="Escreva a descrição do evento..." required></textarea>

        </div>

        <div class="location-container event-container">
            <header>
                <h3 class="common-page-subtitle">Localização</h3>
            </header>
            <span>
                <select class="custom-select">
                    @foreach($locations as $location)
                        <option value="{{$location->id}}"> {{$location->name}} </option>
                    @endforeach
                    <option value="-1"> <a data-toggle="modal" data-target="#organizerModal" href=""> Criar uma localização nova </a></option>
                </select>
            </span>

            @include('components.location_create')
        </div>

        <hr>

        <div class="file-container event-container">
            <header>
                <h3 class="common-page-subtitle">Ficheiros</h3>
            </header>
            <span>
                    <button type="button" class="input-file-btn btn btn-primary"><i class="far fa-plus"></i>
                        Adicionar</button>
                    <input type="file" class="input-file-hidden" name="file">
                </span>
        </div>

        <hr>

        <div class="add-organizer-container event-container">

            <h3 class="common-page-subtitle">Organizadores do Evento</h3>

            <a data-toggle="modal" data-target="#organizerModal" href="">
                <img data-toggle="tooltip"
                     data-placement="top"
                     title="Criar evento"
                     src="../icons/plus-icon-white.png"
                     class="plus-icon"/>
            </a>
            @include('components.member_selector',['id'=>"organizerModal"])
        </div>

        <div class="event-controls">
            <button type="button" id="btn-create-event" class="btn btn-primary btn-circle"><i class="fa fa-check"></i>
            </button>
        </div>

    </div>

@endsection