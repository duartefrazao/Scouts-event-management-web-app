<div id="manager-{{ $section }}" class="managers-container container-fluid">
    <header>
        <h2>Moderadores dos {{ $section }} </h2>
    </header>

    <ul class="list-group">

        @each('partials.admin.common.moderator_info', $moderators[$section], 'moderator')

    </ul>

</div>