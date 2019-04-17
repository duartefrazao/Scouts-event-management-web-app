<article class="event" data-id="{{ $event->id }}">
    <header>
        <h2><a href="/events/{{ $event->id }}">{{ $event->title }}</a></h2>
        <a href="#" class="delete">&#10761;</a>
    </header>
    <div>
        {{ $event->description }}
    </div>
</article>
