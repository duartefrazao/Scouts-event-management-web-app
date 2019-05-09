<nav id="navbar" class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href={{ route('admin.requests') }} id="website-name">
        <img src="../icons/favicon.png" width="30" height="30" class="d-inline-block align-top" alt=""> Admin
    </a>
    <button class="navbar-toggler admin-toggle navbar-dark" type="button" data-toggle="collapse"
            data-target="#admin-tab" aria-controls="admin-tab" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>


    <div class="collapse navbar-collapse" id="admin-tab">
        <ul class="navbar-nav ml-auto" id="admin-actions">
            <li class="nav-item {{$active == 'requests' ? 'active' : ''}}">
                <a class="nav-link {{$active == 'requests' ? 'active' : ''}}" id="pending-tab"
                   href="{{route('admin.requests')}}"> Registos Pendentes </a>
            </li>
            <li class="nav-item {{$active == 'users' ? 'active' : ''}}">
                <a class="nav-link  {{$active == 'users' ? 'active' : ''}}" id="users-tab"
                   href="{{route('admin.users')}}">
                    Utilizadores </a>
            </li>
            <li class="nav-item {{$active == 'guardians' ? 'active' : ''}}">
                <a class="nav-link {{$active == 'guardians' ? 'active' : ''}}" id="guardians-tab"
                   href="{{route('admin.guardians')}}"> Encarregados de
                    Educação </a>
            </li>
            <li class="nav-item {{$active == 'sections' ? 'active' : ''}}">
                <a class="nav-link  {{$active == 'sections' ? 'active' : ''}}" id=" managers-tab"
                href="{{route('admin.sections')}}"> Gestores de Secção </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="admin-logout" href="{{route('admin.logout')}}"> Logout </a>
            </li>
        </ul>
    </div>
</nav>