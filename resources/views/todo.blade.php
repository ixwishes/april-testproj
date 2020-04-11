<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>To-Do</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:200,400,800|Montserrat&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<header>
    <nav class="navbar navbar-toggleable-md navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="/">aprilandkirt</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              @if (Route::has('login'))
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                @if (Route::has('logout'))
                  <li class="nav-item">
                  <a class="nav-link" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                </li>
                @endif

                @else
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                    @if (Route::has('register'))
                      <li class="nav-item">
                          <a class="nav-link" href="/register">Register</a>
                      </li>
                    @endif
                  @endauth
              @endif
            </ul>
        </div>
    </nav>
    <style>
      .form-group input {
        width: 80%;
        padding: 3px;
      }

      button {
        float: right;
      }

      .card {
        margin: 10px 0px;
      }

      .show-complete, .task-header {
        display: inline-block;
      }
    </style>
</header>

<body>
    <div id="app">
      <new-task></new-task>
    </div>
  <script src="{{mix('js/app.js')}}"></script>
</body>

</html>
