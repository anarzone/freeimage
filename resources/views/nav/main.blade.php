<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">{{config('app.name')}}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('saved')}}">Saved images</a>
                </li>
            </ul>
            @if(request()->is('/'))
                <div class="d-flex">
                    <input class="form-control me-2 search-input" type="text" placeholder="type something" aria-label="Search">
                    <button class="btn btn-outline-success btn-sm me-4 search">Search</button>
                </div>
            @endif
        </div>
    </div>
</nav>
