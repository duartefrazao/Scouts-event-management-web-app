<div>
    <span class="notification-important"> {{$notification->data['host'][1]}} </span> convidou-te para o grupo
    <a class="notification-important"
       href="{{$notification->data['url']}}?notification_read={{$notification->id}}">{{$notification->data['group'][1]}}</a>
</div>
