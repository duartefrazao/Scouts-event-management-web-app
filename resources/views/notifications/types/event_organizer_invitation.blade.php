<div>
    <span class="notification-important"> {{$notification->data['host'][1]}} </span> atribuiu-te o cargo de organizador
    no evento
    <a class="notification-important"
       href="{{$notification->data['url']}}?notification_read={{$notification->id}}">{{$notification->data['event'][1]}}</a>
</div>