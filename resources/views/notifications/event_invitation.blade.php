<li data-alert_id="{{$notification->id}}" class="alert_li">
    <span class="notification-important"> {{$notification->data['host'][1]}} </span> convidou-te para o evento
    <a class="notification-important"
       href="events/{{$notification->data['event'][0]}}">{{$notification->data['event'][1]}}</a>
</li>