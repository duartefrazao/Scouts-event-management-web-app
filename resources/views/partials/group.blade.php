<div class="group-wrap">

<a class="card-wrap group-card-wrap" href="/groups/{{ $group->id }}">
            <div class="group-top-side"> 
                <img class="group-image" src="https://agrupamento45caxias.weebly.com/uploads/3/7/5/7/37572967/4292110_8.jpg">
                <div class="group-header"> 
                    <h5 class="card-title group-title">{{$group->name}}</h5>
                        <div class="card-body group-members">
                        @foreach($group->members as $member)
                            <div class="member-wrap">
                                <a href="#" class="group-member-name">{{$member->name}}</a>
                            </div>
                        @endforeach
                        </div>
                </div>
            </div>
            <hr class="group-line">
            
            <div class="group-next-events">
                @foreach($group->events as $event)
                <button type="button" class="btn btn-light group-event">{{$event->title}}</button>
                @endforeach
            </div>
        
    </a>
</div>