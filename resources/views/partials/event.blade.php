<div class="event-wrap">
<a class="card-wrap" href="/events/{{ $event->id }}">
    @php
        $date = new Datetime($event->start_date)
    @endphp
    <div class="card">
        <div class="card-block">
            <div class="event-info">
                <div class="event-basic-info">
                    <time datetime="2019-03-03" class="icon calendar">
                        <span class="event-card-month ">{{$date->format('M')}}</span>
                        <span class="event-card-day"> {{$date->format('d')}} </span>
                        <span class="event-card-week-day">{{$date->format('l')}}</span>
                    </time>
                    <div class="container center-container-vertically">

                        <h5 class="card-title">{{$event->title}}</h5>
                        <h6 class="card-subtitle sec  text-muted">
                            <div class="loc text-muted ">{{$event->loc_name}} </div>
                            <div class="text-muted card-number-participants justify-content-center">18 confirmaram </div>    
                                
                        </h6>

                        <div class="text-muted">Hora: {{$date->format('H:i')}}</div>
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
                            <div class="member-wrap">
                                <a href="#" class="group-member-name text-muted">Daniel</a>
                            </div>

                            <div class="member-wrap">
                                <a href="#" class="group-member-name text-muted">Bruno</a>
                            </div>

                            <div class="member-wrap">
                                <a href="#" class="group-member-name text-muted">Sofia</a>
                            </div>

                            <div class="member-wrap">
                                <a href="#" class="group-member-name text-muted">Joana</a>
                            </div>
                            

                            <div class="member-wrap">
                                <a href="#" class="group-member-name text-muted">António ...</a>
                            </div>
                        </div>
                    </div>
                </div>
           
            
                       
                </div>

                <hr class="event-line"> 
                <div class="card-common-groups">
                    <button type="button" class="btn btn-light card-group-name">Caminheiros</button>
                    <button type="button" class="btn btn-light card-group-name">ENG</button>
                    <button type="button" class="btn btn-light card-group-name">Imaginário</button>
                    <button type="button" class="btn btn-light card-group-name">ACAVER</button>
                </div>
                        
        </div>
    </div>
</a>
</div>
