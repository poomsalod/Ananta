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
    <!-- <script src="jquery-3.5.1.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/master_style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/test-res_style.css') }}" rel="stylesheet">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">


    <title>test responsive</title>

</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <!--------------------------------------------------------------- nav ---------------------------------------------------------------------->
            <nav class="navbar navbar-expand-sm navbar-dark nav-master">
                <!-- Brand -->
                <a class="navbar-brand" href="#">Logo</a>

                <!-- Links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.index')}}">หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('migd.index')}}">วัตถุดิบในระบบ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('food.index')}}">เมนูอาหาร</a>
                    </li>
                </ul>
            </nav>
            <!--------------------------------------------------------------- ///////// ---------------------------------------------------------------------->
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-6 col-12" style="background-color: ffffff; border-radius: 10px;">
                <img src="https://tonkit360.com/wp-content/uploads/2021/04/fast-food.jpg" class="img-fluid w-100">
            </div>
            <div class="col-lg-5 col-md-5 col-sm-6 col-12" style="background-color: ffffff; border-radius: 10px;">
                <span>Bootstrap’s JavaScript includes every component in our primary dist files (bootstrap.js and bootstrap.min.js), and even our primary dependency (Popper) with our bundle files (bootstrap.bundle.js and bootstrap.bundle.min.js). While you’re customizing via Sass, be sure to remove related JavaScript.</span>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-6 col-12" style="background-color: ffffff; border-radius: 10px;">
                <span>col 3</span>
                <h1>h1</h1>
            </div>
            <!-- <div class="col-lg-2 col-md-4 col-sm-6 col-12" style="background-color: ffffff; border-radius: 10px;height: 50%;">
                <span>col 4</span>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-12" style="background-color: ffffff; border-radius: 10px;height: 50%;">
                <span>col 5</span>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-12" style="background-color: ffffff; border-radius: 10px;height: 50%;">
                <span>col 6</span>
            </div> -->
            
        </div>

    </div>
    <div class="container">100% wide until smally breakpoint</div>
    <div class="container-sm">100% wide until small breakpoint</div>
    <div class="container-md">100% wide until medium breakpoint</div>
    <div class="container-lg">100% wide until large breakpoint</div>
    <div class="container-xl">100% wide until extra large breakpoint</div>
    <div class="container-xxl">100% wide until extra extra large breakpoint</div>

    </div>
</body>

</html>