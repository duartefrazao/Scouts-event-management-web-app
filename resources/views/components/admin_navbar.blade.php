<nav id="navbar" class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href={{ route('admin.dashboard') }} id="website-name">
        <img src="../icons/favicon.png" width="30" height="30" class="d-inline-block align-top" alt=""> Admin
    </a>
    <button class="navbar-toggler admin-toggle navbar-dark" type="button" data-toggle="collapse"
            data-target="#admin-tab" aria-controls="admin-tab" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="admin-tab">
        <ul class="nav nav-tabs d-flex flex-sm-row flex-column ml-auto" id="admin-actions" role="tablist">
            <li class="nav-item" href="#pending-users">
                <a class="nav-link active" id="pending-tab" href="#pending-users" role="tab" aria-controls="pending"
                   aria-selected="true"> Registos Pendentes </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="users-tab" href="#users" role="tab" aria-controls="users"
                   aria-selected="false">
                    Utilizadores </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="guardians-tab" href="#guardians" role="tab" aria-controls="guardians"
                   aria-selected="false"> Encarregados de Educação </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="managers-tab" href="#managers" role="tab" aria-controls="managers"
                   aria-selected="false"> Gestores de Secção </a>
            </li>
        </ul>
    </div>
</nav>
