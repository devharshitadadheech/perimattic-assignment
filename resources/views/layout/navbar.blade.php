<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#060c21; background: linear-gradient(315deg, #e91e63, #5d02ff);">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Contacts
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('contacts.import')}}">Import</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{route('contacts.export')}}">Export</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" aria-disabled="true" style="color: white;"><i class="fa fa-sign-out"></i>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
