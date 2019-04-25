<div class="event-wrap">
<a class="card-wrap" href="/events/{{ $event->id }}">
    @php
        $date = new Datetime($event->start_date)
    @endphp
    
    <div class="card">
        <div class="card-block">
            <div class="event-info">
                <div class="event-basic-info">
                    @if($event->start_date)
                        @php
                        $date = new Datetime($event->start_date)
                        @endphp
                    <time datetime="2019-03-03" class="icon calendar">
                        <span class="event-card-month ">{{$date->format('M')}}</span>
                        <span class="event-card-day"> {{$date->format('d')}} </span>
                        <span class="event-card-week-day">{{$date->format('l')}}</span>
                    </time>
                    @else
                        <time datetime="2019-03-03" class="icon">
                        <span class="event-card-month">Data</span>
                        <span class="event-card-day">???</span>
                        <span class="event-card-week-day"></span>
                        </time>
                    @endif
                    <div class="container center-container-vertically">

                        <h5 class="card-title">{{$event->title}}</h5>
                        <h6 class="card-subtitle sec  text-muted">
                            <div class="loc text-muted ">
                            @if ($event->location)
                            {{$event->loc_name}}
                            @else 
                            Local Indefinido
                            @endif </div>
                            <div class="text-muted card-number-participants justify-content-center">
                            @if ($event->going)
                            {{count($event->going)}}
                            @else
                            0
                            @endif
                            confirmaram </div>    
                                
                        </h6>
                        @if($event->start_date)
                        <div class="text-muted">Hora: {{$date->format('H:i')}}</div>
                        @else 
                        <div class="text-muted">Hora: Por definir</div>
                        @endif
                        <div class="text-muted">Preço: 
                        @if ($event->price > 0)
                            {{$event->price}} euros
                        @else
                            Grátis
                        @endif    
                        </div>
                        

                        <div class=" card-test-invited"> 
                            Convidados 
                        </div>

                        <div class="card-body group-members">
                            
                            @foreach($event['invited'] as $inv)
                            <div class="member-wrap">
                                <a href="#" class="group-member-name text-muted">{{$inv}}</a>
                            </div>

                            @endforeach
                            @if ($event['invited'] = 4)
                            <div class="member-wrap">
                                <a href="#" class="group-member-name text-muted">...</a>
                            </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
           
            
                       
                </div>

                <hr class="event-line"> 
                <div class="card-common-groups">
                    @foreach ($event->groups as $group)
                        <button type="button" class="btn btn-light card-group-name">{{$group}}</button>
                    @endforeach
                </div>
                        
        </div>
    </div>
</a>
</div>
