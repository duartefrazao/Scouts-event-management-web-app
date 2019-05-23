<div id="notifications-toggle-content" class="hidden">
    <ul class="unstyled">
        @foreach(Auth::user()->notifications()->limit(3)->get() as $notification)
            @php
                $class = $notification->read_at != null ? "read" : "not-read";
            @endphp
            <li data-alert_id="{{$notification->id}}" class="alert_li {{$class}}">
                @switch($notification->type)
                    @case('App\Notifications\EventInvitation')
                    @include('notifications.types.event_invitation', ['notification' => $notification])
                    @break
                    @case('App\Notifications\EventOrganizerInvitation')
                    @include('notifications.types.event_organizer_invitation', ['notification' => $notification])
                    @break
                    @case('App\Notifications\GroupInvitation')
                    @include('notifications.types.group_invitation', ['notification' => $notification])
                    @break
                    @case('App\Notifications\GroupOrganizerInvitation')
                    @include('notifications.types.group_organizer_invitation', ['notification' => $notification])
                    @break
                    @default
                    @break
                @endswitch
            </li>
        @endforeach
    </ul>
</div>