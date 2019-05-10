<script src="../js/calendar.js" type="text/javascript" defer></script>

<div class="container col-lg-10 col-xs-12" id="calendar">

    <div class="row">

        <div class="col-auto month-selector previous-month" data-toggle="tooltip" data-placement="left"
             title="Mês Anterior">
            <
        </div>
        <div class="col-auto month">
            <h3 class="month-name"> January </h3>
        </div>
        <div class="col-auto month-selector next-month" data-toggle="tooltip" data-placement="right"
             title="Mês Seguinte"> >
        </div>

    </div>

    @php
        $days = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom'];
        $shorter_days = ['S', 'T', 'Q', 'Q', 'S', 'S', 'D'];
    @endphp

    <div class="row">


        @foreach($days as $num =>$day)
            <div class="calendar-desktop week-day {{$num}} col">
                <h4> {{$day}} </h4>
            </div>
        @endforeach

        @foreach($shorter_days as $num =>$day)
            <div class="calendar-mobile week-day col">
                <h4> {{$day}}</h4>
            </div>
        @endforeach

    </div>

    @for($i = 0; $i <= 5; $i++)
        <div class="row week" data-id="week-{{$i}}">
            @for($j = 0; $j <= 6; $j++)
                <div class="day col text-muted container" data-id="day-{{$j}}">
                    <h6 class="day-value">
                        <span> 0 </span>
                    </h6>
{{--                    @if($j == 5 && $i == 0 || $j == 0 && $i == 2 || $i == 4 && $j == 3)
                        <div class="container calendar-event calendar-desktop">
                            Evento
                        </div>
                        <div class="container calendar-event calendar-mobile">
                            E
                        </div>
                    @endif--}}
                </div>
            @endfor
        </div>
    @endfor
</div>


