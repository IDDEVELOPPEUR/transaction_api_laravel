<!DOCTYPE html>
<html lang="en">
    <title>web banking</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <body>
        <nav class="card navbar navbar-expand-lg navbar-light mb-2 mt-2" style="background-color: #e3f2fd">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">My Bank</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('transactions.index') }}">My transactions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contacts.index') }}">My contact list</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-items-center">

                    @if(Auth::check())
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-success me-3" type="submit">Deconnexion</button>
                    </form>
                    <a href="{{ route('profile.update') }}">
                        <em class="fas fa-user"></em>&nbsp;{{Auth::user()->prenom}}
                    </a>
                    @else
                    <a href="{{ route(name:'register')}}" class="btn btn-primary mx-2">inscription</a>
                    <a href="{{ route('login') }}" class="btn btn-success me-3">Connexion</a>
                    @endif

                </div>
            </div>
        </nav>
        @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
        @yield('script')
    </body>

</html>