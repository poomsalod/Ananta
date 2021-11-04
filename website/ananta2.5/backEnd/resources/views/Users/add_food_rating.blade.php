@extends('Users.master_user')

@section('style')
<link href="{{ asset('css/igd_info/Igd_info_index_style.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/viewmenu_rating.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('css/users/add_food.css') }}" rel="stylesheet"> -->
<link href="{{ asset('css/users/viewmenu.css') }}" rel="stylesheet">

@endsection


@section('nav')
<li class="nav-item">

</li>
@endsection

@section('title')
เพิ่มเมนูอาหาร
@endsection

@section('content')
<?php

use App\Models\Food_rating; ?>
<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-9 col-sm-8 colhead1">
                <span class="haedline1">เพิ่มคะแนนในเมนูอาหาร</span>
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


        <div class="row">
            <div class="col-md-12">

                <form action="{{url('/show_food_data')}}" method="GET" role="form">
                    <div class="input-group">
                        <input type="search" class="form-control" name="search" placeholder="ป้อนข้อมูลที่ต้องการค้นหา">
                        <select class="input-group-prepend" name="category">
                            <option value="0">ทั้งหมด</option>
                            @foreach($cate_food as $key => $value)
                            <option value="{{ $value->cate_food_id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-prepend"><button type="submit" class="btn btn-primary" style="border-radius: 5px;">ค้นหา</button></span>
                    </div>
                </form>

            </div>
        </div>
        {!! $food_info->links() !!}


        <div class="row">
            <div class="col-md-12">
                <article class="leaderboard">
                    <header>
                        <h1 class="leaderboard__title">
                            <span class="leaderboard__title--top">รายการเมนูอาหาร</span>
                            <span class="leaderboard__title--bottom">จำนวนเมนูอาหาร: {{$i+30 .'/'.$count}}</span>
                        </h1>
                    </header>
                    <div class="rog">
                        <main class="leaderboardprofiles">
                            <div class="tbb">
                                @if($count == 0)
                                <tr>
                                    <td class="text-danger">**ไม่มีข้อมูล**</td>
                                </tr>
                                @endif

                                <?php
                                $number_id = 1;
                                ?>

                                @foreach($food_info as $key => $value)

                                <article class="leaderboardprofile">
                                    <img src="{{ asset('/storage/images/food/'.$value->image) }}" alt="Image" class="leaderboardpicture">
                                    <span class="leaderboardname">{{ $value->name." " }}{{ floor($value->calorie)." " }}แคลอรี่</span>
                                    <div class="modal fade" id="exampleModal{{$number_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{url('/ViewMenu_AddRating')}}" method="POST" role="form" id="id_food{{$number_id}}">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="user_id" value="{{Auth::user()->user_profile->user_id}}">
                                                    <input type="hidden" name="food_id" value="{{$value->food_id}}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">คะแนนเมนูอาหาร</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="rating-css">
                                                            <div class="star-icon">
                                                                <?php
                                                                $food_rating = Food_rating::where('food_id', $value->food_id)->where('user_id', Auth::user()->user_profile->user_id)->get();
                                                                $check_user = 0;
                                                                foreach ($food_rating as $key => $value2) {
                                                                    $star_num = $value2->rating_score;
                                                                    $score = 0;
                                                                    for ($i = 1; $i <= $star_num; $i++) {
                                                                        echo '<input type="radio" value="' . ++$score . '" name="score_rating" checked id="rating' . $value->food_id . ($number_id + $score) . '">';
                                                                        echo '<label for="rating' . $value->food_id . ($number_id + $score) . '" class="fa fa-star"></label>';
                                                                    }
                                                                    for ($j = $star_num + 1; $j <= 5; $j++) {
                                                                        echo '<input type="radio" value="' . ++$score . '" name="score_rating" id="rating' . $value->food_id . ($number_id + $score) . '">';
                                                                        echo '<label for="rating' . $value->food_id . ($number_id + $score) . '" class="fa fa-star"></label>';
                                                                    }
                                                                    $check_user = 1;
                                                                }
                                                                if ($check_user == 0) {
                                                                    $score = 0;
                                                                    echo '<input type="radio" value="' . ++$score . '" name="score_rating" checked id="rating' . $value->food_id . ($number_id + $score) . '">';
                                                                    echo '<label for="rating' . $value->food_id . ($number_id + $score) . '" class="fa fa-star"></label>';
                                                                    echo '<input type="radio" value="' . ++$score . '" name="score_rating" id="rating' . $value->food_id . ($number_id + $score) . '">';
                                                                    echo '<label for="rating' . $value->food_id . ($number_id + $score) . '" class="fa fa-star"></label>';
                                                                    echo '<input type="radio" value="' . ++$score . '" name="score_rating" id="rating' . $value->food_id . ($number_id + $score) . '">';
                                                                    echo '<label for="rating' . $value->food_id . ($number_id + $score) . '" class="fa fa-star"></label>';
                                                                    echo '<input type="radio" value="' . ++$score . '" name="score_rating" id="rating' . $value->food_id . ($number_id + $score) . '">';
                                                                    echo '<label for="rating' . $value->food_id . ($number_id + $score) . '" class="fa fa-star"></label>';
                                                                    echo '<input type="radio" value="' . ++$score . '" name="score_rating" id="rating' . $value->food_id . ($number_id + $score) . '">';
                                                                    echo '<label for="rating' . $value->food_id . ($number_id + $score) . '" class="fa fa-star"></label>';
                                                                }
                                                                ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                                                        <input type="submit" class="btn btn-success" value="บันทึก" form="id_food{{$number_id}}">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rating" style="text-align: center;">
                                        <?php
                                        $food_rating = Food_rating::where('food_id', $value->food_id)->where('user_id', Auth::user()->user_profile->user_id)->get();
                                        $check_user = 0;
                                        foreach ($food_rating as $key => $value2) {
                                            $star_num = $value2->rating_score;
                                            for ($i = 1; $i <= $star_num; $i++) {
                                                echo "<i class='fa fa-star checked'></i>";
                                            }
                                            for ($j = $star_num + 1; $j <= 5; $j++) {
                                                echo "<i class='fa fa-star ddg'></i>";
                                            }
                                            $check_user = 1;
                                        }
                                        if ($check_user == 0) {
                                            echo "<i class='fa fa-star ddg'></i>";
                                            echo "<i class='fa fa-star ddg'></i>";
                                            echo "<i class='fa fa-star ddg'></i>";
                                            echo "<i class='fa fa-star ddg'></i>";
                                            echo "<i class='fa fa-star ddg'></i>";
                                        }
                                        ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center;">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$number_id}}" style="background-color: #ffb561; border:0">ให้คะแนนเมนู</button>
                                            <?php
                                            $number_id++;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-12" style="text-align: center;">
                                            <a href="{{url('/menu/rating', [$value->food_id, Auth::user()->user_profile->user_id])}}" type="button" class="btn btn-primary" style="background-color: #ff9100; border:0">รายละเอียด</a>
                                        </div>
                                    </div>

                                </article>
                                @endforeach
                            </div>
                        </main>
                    </div>
                </article>

                {!! $food_info->links() !!}

            </div>
        </div>
    </div>
</div>


@endsection