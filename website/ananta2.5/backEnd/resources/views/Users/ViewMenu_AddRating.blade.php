@extends('Users.master_user')

@section('style')
<link href="{{ asset('css/food/food_show_style.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/viewmenu_rating.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/viewmenu.css') }}" rel="stylesheet">



@endsection

@section('nav')

@endsection

@section('title')
แสดงเมนูอาหาร
@endsection

@section('content')

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{url('/ViewMenu_AddRating')}}" method="POST" role="form">

                {{csrf_field()}}

                <input type="hidden" name="user_id" value="{{Auth::user()->user_profile->user_id}}">
                <input type="hidden" name="food_id" value="{{$food->food_id}}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">คะแนนเมนูอาหาร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="rating-css">
                        <div class="star-icon">
                            <input type="radio" value="1" name="score_rating" checked id="rating1">
                            <label for="rating1" class="fa fa-star"></label>
                            <input type="radio" value="2" name="score_rating" id="rating2">
                            <label for="rating2" class="fa fa-star"></label>
                            <input type="radio" value="3" name="score_rating" id="rating3">
                            <label for="rating3" class="fa fa-star"></label>
                            <input type="radio" value="4" name="score_rating" id="rating4">
                            <label for="rating4" class="fa fa-star"></label>
                            <input type="radio" value="5" name="score_rating" id="rating5">
                            <label for="rating5" class="fa fa-star"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>

            </form>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-9 col-sm-8 colhead1">
                <a href="{{ url('/rating_menu')}}"><img src="{{ asset('/storage/images/icon/ic-back_97586.png') }}"></a>
            </div>
        </div>

        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
        </div>
        @endif

        @if(\Session::has('error'))
        <div class="alert alert-danger">
            <p>{{ \Session::get('error')}}</p>
        </div>
        @endif

        @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul> @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif



        <div class="row" style="text-align: center;">
            <div class="col-md-12" style="padding: 2%; font-size: 25;">
                <span>{{ $food->name }}</span>
            </div>

        </div>
        <div class="row" style="text-align: center;">
            <div class="col-md-12" style="padding: 2%; font-size: 25;">
                <!-- <span style=" margin-right: 10px; margin-top: 26px;">คะแนน <?php $star_num = ($rating) ?></span> -->
                <div class="staar">
                    <div class="rating">

                        <?php

                        for ($i = 1; $i <= $star_num; $i++) {
                            echo "<i class='fa fa-star checked'></i>";
                        }
                        for ($j = $star_num + 1; $j <= 5; $j++) {
                            echo "<i class='fa fa-star ddg'></i>";
                        }
                        ?>

                    </div>
                </div>
                <div class="agoo">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">ให้คะแนนเมนู</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-md-12">
                <img src="{{ asset('/storage/images/food/'.$food->image) }}" class="rounded mx-auto d-block imm">
            </div>
        </div>

        <div class="row" style="text-align: center;">
            <div class="col-md-12" style="padding: 2%; font-size: 25;">
                <span>โภชนาการ</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 col-2"></div>
            <div class="col-2 col-md-2 profile-circel-image-200" style="text-align: center;">
                <img src="{{ asset('/storage/images/nutrition/calories.png') }}" class="rounded img-fluid rounded-circle">
                <h5 class="bgg">Calorie</h5>
                <p class="bgga">{{ $food->calorie }}</p>
            </div>
            <div class="col-2 col-md-2 profile-circel-image-200" style="text-align: center;">
                <img src="{{ asset('/storage/images/nutrition/protein-shake.png') }}" class="rounded img-fluid rounded-circle">
                <h5 class="bgg">Protein</h5>
                <p class="bgga">{{ $food->protein }}</p>
            </div>
            <div class="col-2 col-md-2 profile-circel-image-200" style="text-align: center;">
                <img src="{{ asset('/storage/images/nutrition/bread.png') }}" class="rounded img-fluid rounded-circle">
                <h5 class="bgg">Carbohydrates</h5>
                <p class="bgga">{{ $food->carbohydrate }}</p>
            </div>
            <div class="col-2 col-md-2 profile-circel-image-200" style="text-align: center;">
                <img src="{{ asset('/storage/images/nutrition/trans-fat.png') }}" class="rounded img-fluid rounded-circle">
                <h5 class="bgg">fat</h5>
                <p class="bgga">{{ $food->fat }}</p>
            </div>
            <div class="col-md-2 col-2"></div>
        </div>
    </div>
    <!-- //////////////////////////////////////////////////////////////////////////////////////////// -->

    <!-- วัตถุดิบ -->
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-12">
                <article class="leaderboard">
                    <header>
                        <h1 class="leaderboard__title"><span class="leaderboard__title--top">รายการวัตถุดิบ</span><span class="leaderboard__title--bottom">ผลลัพธ์: {{$count_iof}}</span></h1>
                    </header>
                    <div class="rog">
                        <main class="leaderboardprofiles">
                            <div class="tbb">
                                @foreach($iof as $key => $value)
                                <article class="leaderboardprofile">
                                    <img src="{{ asset('/storage/images/igd/'.$value->igd_info->image) }}" alt="Mark Zuckerberg" class="leaderboardpicture">
                                    <span class="leaderboardname">{{ $value->igd_info->name }}{{ $value->description." " }}</span>
                                    @if($value->importance==1)
                                    @if($value->value==0.125)
                                    <span class="leaderboardvalue">&frac18{{" " }}{{ $value->unit }}</span>
                                    @elseif($value->value==0.25)
                                    <span class="leaderboardvalue">&frac14{{" " }}{{ $value->unit }}</span>
                                    @elseif($value->value==0.50)
                                    <span class="leaderboardvalue">&frac12{{" " }}{{ $value->unit }}</span>
                                    @elseif($value->value==1)
                                    <span class="leaderboardvalue">1{{" " }}{{ $value->unit }}</span>
                                    @else
                                    <span class="leaderboardvalue">{{$value->value." " }}{{ $value->unit }}</span>
                                    @endif
                                    @endif
                                </article>
                                @endforeach
                            </div>

                        </main>
                    </div>

                </article>
            </div>
        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////// -->

    <!-- รายการวิธีทำ -->
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-9 col-sm-8 colhead1">
                <span class="sphead" style="font-size: 150%;">รายการวิธีทำ</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <span>จำนวนวิธีทำ: {{$count_step}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <article class="leaderboard">
                    <div class="rog">
                        <main class="leaderboardprofiles">
                            <div class="tbb">
                                @foreach($step as $key => $value)
                                <article class="leaderboardprofile">
                                    <span class="leaderboardnumber">{{ $value->order }}</span>
                                    <span class="leaderboardname">{{ $value->step }}</span>
                                </article>
                                @endforeach
                            </div>

                        </main>
                    </div>

                </article>
            </div>
        </div>
        <div class="agoo">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">ให้คะแนนเมนู</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection