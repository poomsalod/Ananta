@extends('Users.master_user')



@section('title')
รายการการให้คะแนนเมนูอาหาร
@endsection

@section('style')
<link href="{{ asset('css/users/show_food_user.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/viewmenu_rating2.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/add_food.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/viewmenu.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="row">

    <div class="col-md-12">

        <form action="{{url('/add_data_nutrition')}}" method="POST" role="form" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="col-md-12 colblock">


                <!-- <div class="row">
                    <div class="col-md-9 col-sm-8 colhead1">
                        <span class="sphead" style="font-size: 200%;">การให้คะแนนเมนูอาหาร</span>
                    </div>
                    <div class="col-md-3 col-sm-4 colhead2">
                        <a href="{{ url('/rating_menu') }}" class="btn btn-success" style="height: 100%; width: 100%;">ให้คะแนนเมนูอาหาร</a>
                    </div>
                </div> -->

                @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul> @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success')}}</p>
                </div>
                @endif

                <div class="row">

                    <div class="col-md-12 mb-3">
                        <!-- <span>จำนวนเมนูที่ให้คะแนน: {{$count}}</span> -->
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12 ">

                        <article class="leaderboard">
                            <header>
                                <h1 class="leaderboard__title">
                                    <span class="leaderboard__title--top ">รายการเมนูอาหารที่ให้คะแนนแล้ว</span>
                                    <span class="leaderboard__title--bottom">ผลลัพธ์: {{$count}} / 20</span>
                                    <span class="leaderboard__title--bottom" style="color: red;">(กรุณาให้คะแนนเมนูอาหารอย่างน้อย 20 เมนู)</span>
                                    <a href="{{ url('/rating_menu') }}" class="btn btn-primary" style="margin-top: 10;border:0">ให้คะแนนเมนูอาหาร</a>
                                </h1>
                            </header>
                            
                            <div class="rog">
                                <main class="leaderboardprofiles">
                                    <div class="tbb">
                                        @if($count == 0)
                                        <article class="leaderboardprofile">
                                            <span class="leaderboardname">ไม่มีข้อมูล</span>
                                        </article>
                                        @else
                                        @foreach($ratingDB as $key => $value)
                                        <article class="leaderboardprofile">

                                            <img src="{{ asset('/storage/images/food/'.$value->food->image) }}" alt="Image" class="leaderboardpicture">
                                            <span class="leaderboardname">{{ $value->food->name." " }}{{ floor($value->food->calorie)." แคลอรี่" }}</span>

                                            <div class="rating" style="text-align: center;">
                                                <?php

                                                $check_user = 0;

                                                if ($value->user_id == Auth::user()->user_profile->user_id) {
                                                    $star_num = $value->rating_score;
                                                    for ($i = 1; $i <= $star_num; $i++) {
                                                        echo "<i class='fa fa-star checked'></i>";
                                                    }
                                                    for ($j = $star_num + 1; $j <= 5; $j++) {
                                                        echo "<i class='fa fa-star ddg'></i>";
                                                    }
                                                    $check_user = 1;
                                                }

                                                ?>
                                            </div>

                                        </article>
                                        @endforeach
                                        @endif
                                    </div>
                                </main>
                            </div>

                        </article>
                    </div>
                    {!! $ratingDB->links() !!}
                </div>
            </div>
        </form>
    </div>
</div>


@endsection