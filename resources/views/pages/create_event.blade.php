@extends('layouts.app')

@section('title', 'Create event')

@section('navbar')
    @include('components.user_navbar')
@endsection

@section('content')
<div class="event-page container-fluid col-xs-11 col-sm-10 col-lg-6">

        <div class="event-controls">
            <button type="button" class="btn btn-primary btn-circle"><i class="fa fa-check"></i></button>
        </div>
    
        <input type="text" class="event-title input-transparent w-100 input-border" placeholder="Title">
    
        
    
        <div class="modal-body">
    
            <div class="date-container event-container">
                <header>
                    <h3 >Data</h3>
                </header>
    
                @include('components.date_selector')
            </div>
    
            <hr>
    
            <div class="add-member-container event-container">
                <header>
                    <h3>Membros</h3>
                </header>
    
                <div class="member-wrap">
                    <figure class="add_member" data-toggle="modal">
                        <a data-toggle="modal" data-target="#memberModal"><img data-toggle="tooltip" data-placement="top"
                                title="Criar evento" src="../icons/plus-icon-white.png" class="plus-icon" /></a>
                        <figcaption></figcaption>
                    </figure>
                </div>
    
                @include('components.member_selector',['id'=>"memberModal"])
                
            </div>
    
            <hr>
    
            <div class="description-container event-container">
                <header>
                    <h3 class="common-page-subtitle">Descrição</h3>
                </header>
                <div class="price-box">
                    <i class="euro-sign fas fa-euro-sign "></i>
                    <input type="number" class="input-price input-transparent input-border" placeholder="Custo">
                </div>
    
                <textarea class="input-description input-transparent w-100 input-border" wrap="hard"
                    placeholder="Escreva a descrição do evento..."></textarea>
    
            </div>
    
            <hr>
            
            <div class="file-container event-container">
                <header>
                    <h3 class="common-page-subtitle">Ficheiros</h3>
                </header>
                <span>
                    <button type="button" class="btn btn-secondary"><i class="far fa-arrow-alt-circle-down"></i>
                        File1.pdf</button>
                    <button type="button" class="input-file-btn btn btn-primary"><i class="far fa-plus"></i></i>
                        Adicionar</button>
                    <input type="file" class="input-file-hidden" name="file">
                </span>
            </div>
    
            <hr>
    
            <div class="add-organizer-container event-container">
                <header>
                    <h3 class="common-page-subtitle">Organizadores do Evento</h3>
                </header>
    
                <div class="member-wrap">
                    <figure class="add_member" data-toggle="modal" data-target="#exampleModal">
                        <a data-toggle="modal" data-target="#organizerModal" href=""><img data-toggle="tooltip"
                                data-placement="top" title="Criar evento" src="../icons/plus-icon-white.png"
                                class="plus-icon" /></a>
                        <figcaption></figcaption>
                    </figure>
                </div>
                @include('components.member_selector',['id'=>"organizerModal"])
            </div>
    
        </div>
        <div class="modal-footer">
        </div>
    </div>
    
@endsection