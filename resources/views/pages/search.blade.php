@extends("layouts.app")

@section('title', 'Search')


@section('navbar')
    @include('navbars.user_navbar')
@endsection


@section('content')


    @component('components.search.options',compact('query'))
    @endcomponent
    
    @component('components.search.results',compact('query','users','events','groups'))
    @endcomponent


@endsection

