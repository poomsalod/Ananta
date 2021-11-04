<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/master_log_reg_style.css') }}" rel="stylesheet">
    @yield('style')
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">


    <title>@yield('title')</title>

</head>

<body>
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Ananta</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            ล็อกอิน
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('register') }}">
                            สมัครสมาชิก
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="container">
        <div class="row martop">
            <div class="col-md-4 mt-3">
                @yield('content')
            </div>

            <div class="col-md-8 mt-3">
                <img class="img_logo" style="border-radius: 10px;" src="{{ asset('/storage/images/logo.jpg') }}">
            </div>
        </div>
    </div>

    @yield('script')
</body>
<footer>
    <div class="container">
        <div class="card-group">
            @foreach($food as $key => $value)
            <div class="card">
                <img class="card-img-top img_card" src="{{ asset('/storage/images/food/'.$value->image) }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{ $value->name }}</h5>
                    <p class="card-text">{{ floor($value->calorie) }} กิโลแคลอรี่</p>
                    <p class="card-text"><small class="text-muted">{{ $value->addess }}</small></p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</footer>

</html>