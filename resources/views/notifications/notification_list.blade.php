<div id="notifications-toggle-content" class="hidden">
    <ul class="unstyled">
        @foreach(Auth::user()->notifications()->limit(3)->get() as $notification)
            <li data-alert_id="{{$notification->id}}" class="alert_li">
            @switch($notification->type)
                @case('App\Notifications\EventInvitation')
                @include('notifications.types.event_invitation', ['notification' => $notification])
                @break
                @case('App\Notifications\EventOrganizerInvitation')
                @include('notifications.types.event_organizer_invitation', ['notification' => $notification])
                @break
                @default
                @break
            @endswitch
            </li>
        @endforeach
    </ul>
</div>