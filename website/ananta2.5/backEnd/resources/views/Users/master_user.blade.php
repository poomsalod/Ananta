<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

    <!-- <script src="jquery-3.5.1.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/master_style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/test.scss') }}" rel="stylesheet">
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
            <a class="navbar-brand" href="{{ url('/food/index') }}">Ananta</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ???????????????????????????
                        </a>
                    </li> -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ?????????????????????????????????????????????
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('/show_data_rating', Auth::user()->user_profile->user_id) }}">?????????????????????????????????????????????</a>
                            <a class="dropdown-item" href="{{ url('/rating_menu') }}">????????????????????????????????????</a>
                        </div>
                    </li>
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ??????????????????????????????????????????????????????
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('/show/igd_stock', Auth::user()->user_profile->user_id) }}">?????????????????????????????????????????????????????????????????????</a>
                        </div>
                    </li> -->
                </ul>

                <ul class="navbar-nav">

                    <!-- ???????????? -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img class="rounded-circle img_avatar" src="{{ asset('/storage/images/user/'.Auth::user()->user_profile->image) }}">
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item" href="{{ url('/setting/profile' ,Auth::user()->user_profile->user_id) }}">
                                <img src="{{ asset('/storage/images/icon/user.png') }}"> ?????????????????????
                            </a>

                            <a class="dropdown-item" href="{{ url('/show/food_allergy') }}">
                                <img src="{{ asset('/storage/images/icon/food.png') }}"> ???????????????????????????????????????????????????
                            </a>

                            <a class="dropdown-item" href="{{ url('/show/igd_stock') }}">
                                <img src="{{ asset('/storage/images/icon/ingredients.png') }}"> ?????????????????????????????????????????????????????????????????????
                            </a>

                            <!-- <a class="dropdown-item" href="{{ route('logout') }}">
                                <img src="{{ asset('/storage/images/icon/history.png') }}"> ????????????????????????????????????????????????
                            </a> -->

                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                <img src="{{ asset('/storage/images/icon/log-out.png') }}"> ??????????????????????????????
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="container">
        <!--------------------------------------------------------------- content ---------------------------------------------------------------------->
        @yield('content')
        <!--------------------------------------------------------------- ///////// ---------------------------------------------------------------------->
    </div>

    @yield('script')


</body>

</html>