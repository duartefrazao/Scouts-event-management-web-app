@extends('layouts.app')

@section('title', $event->title)

@section('navbar')
    @include('navbars.user_navbar')
@endsection

@section('content')


<div class="event-page container-fluid col-xs-11 col-sm-10 col-lg-8">
    <div class="modal-body">

        <h5 class="event-title" data-id="{{$event->id}}">{{$event->title}}</h5>

        <div class="first-row">
            @if($event->start_date)
            @php
                $date = new Datetime($event->start_date)
            @endphp
            <time datetime="{{$date->format('Y:M:d')}}" class="icon calendar">
                <span class="event-card-month ">{{$date->format('M')}}</span>
                <span class="event-card-day"> {{$date->format('d')}} </span>
                <span class="event-card-week-day">{{$date->format('l')}}</span>
            </time>
            @else
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
            @foreach($event->options as $option)
                <li>
                    <div class="custom-control custom-checkbox" style="float:left; margin-right:1em;">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked1">
                        <label class="custom-control-label" for="defaultUnchecked1">{{date("m-d-Y H:i", strtotime($option->date))}}</label>
                    </div>

                    <div class="progress">
                    @php
                        if ($event->total_votes > 0)
                            $val = $option->num_votes*100/$event->total_votes;
                        else $val = 0;
                    
                    @endphp
                        <div class="progress-bar" role="progressbar" style="width: {{$val}}%;" aria-valuenow="{{$val}}" aria-valuemin="0"
                            aria-valuemax="100">{{$option->votes->count()}}</div>
                    </div>
                </li>
            @endforeach
            </ul>
            </div>
            @endif

            <div class="btn-group-toggle presence d-flex" data-toggle="buttons">
                <label class="btn btn-light confirm-presence">
                    <input type="radio" name="presence" checked autocomplete="off"><i class="fal fa-check"></i> Vou
                </label>

                <label class="btn btn-light deny-presence">
                    <input type="radio" name="presence" checked autocomplete="off"><i class="fal fa-times"></i> Não vou
                </label>
            </div>

            <div class="member-container">
                @foreach($event->going as $part)
                <div class="member-wrap" data-id="{{$part->id}}">
                    <label>
                        <img src="{{asset($part->profile_image)}}" class="rounded-circle" />
                        {{$part->name}}
                   </label>
                </div>
                @endforeach
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
            <h6 class="map-caption"><i class="fas fa-map-marker-alt fa-sm"></i>
            @if ($event->location)
            {{$event->location}}
            @else 
            Local Indefinido
            @endif 
            </h6>
            <div class="map"></div>
        </div>

        <div class="file-container">
            <header>
                <h3 class="common-page-subtitle">Ficheiros</h3>
            </header>
            <div class="form-group">
                <div class="files">
                    @foreach ($event->files as $file)
                    <form action= "/events/{{$event->id}}/file" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="file" value="{{$file}}">
                        
                    <button type="submit" class="btn btn-secondary file-btn download-file-btn"><i class="far fa-arrow-alt-circle-down"></i>
                    {{$file}}</button>
                    </form>
                    @endforeach
                </div>{{-- 
                <label for="file" class="input-file-btn btn btn-primary"><i class="far fa-plus"></i>
                    Adicionar</label>
                <input name="files[]" type="file"  class="input-file-hidden  form-control-file" id="file" multiple> --}}
            </div>
        </div>
        <hr>


        <div class="organizer-container">
            <header>
                <h3 class="common-page-subtitle">Organizadores do Evento</h3>
            </header>

            <div class="member-container">
                @foreach($event->organizers as $organizer)
                <div class="member-wrap" data-id="{{$organizer->id}}">
                    <img src="{{asset($organizer->profile_image)}}" class="rounded-circle" />
                    <label>{{$organizer->name}}</label>
                </div>
                @endforeach
            </div>

        </div>

        <hr>

        <div class="event-comments">

            <h3 class="common-page-subtitle"> Comentários </h3>

            @if(session()->has('parent')|| Auth::user()->is_responsible)
                <div class="row">
                    <textarea name="comment" class="input-description input-transparent w-100 input-border comment-box" wrap="hard"
                            placeholder="Adicione um comentário.."></textarea>
                </div>
            @endif

        </div>

    </div>
    <div class="modal-footer">
    </div>
</div>
@endsection
