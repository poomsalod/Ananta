@extends('Users.master_user')

@section('style')
<link href="{{ asset('css/igd_info/Igd_info_index_style.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/viewmenu_rating.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/add_food.css') }}" rel="stylesheet">

@endsection


@section('nav')
<li class="nav-item">

</li>
@endsection

@section('title')
เพิ่มวัตถุดิบที่รับประทานไม่ได้
@endsection

@section('content')
<?php

use App\Models\Food_rating; ?>
<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-9 col-sm-8 colhead1">
                <span class="haedline1">เพิ่มวัตถุดิบที่มี</span>
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
                <form action="{{ url('/search/igd/') }}" method="GET" role="form">
                    <div class="input-group">
                        <input type="search" class="form-control" name="search" placeholder="ป้อนข้อมูลที่ต้องการค้นหา">
                        <select class="input-group-prepend" name="category">
                            <option value="0">ทั้งหมด</option>
                            @foreach($cate_igd as $key => $value)
                            <option value="{{ $value->cate_igd_id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-prepend"><button type="submit" class="btn btn-primary" style="border-radius: 5px;">ค้นหา</button></span>
                    </div>

                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <article class="leaderboard">
                    <header>
                        <h1 class="leaderboard__title">
                            <span class="leaderboard__title--top">รายการวัตถุดิบ</span><span class="leaderboard__title--bottom">จำนวนวัตถุดิบ: {{$count}}</span>
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
                                @foreach($igd_info as $key => $value)
                                <form action="/show/igd_stock/create" method="post">
                                    {{csrf_field()}}
                                    <article class="leaderboardprofile">
                                        <input type="hidden" name="igd_info_id" value="{{ $value->igd_info_id }}">
                                        <img src="{{ asset('/storage/images/igd/'.$value->image) }}" alt="Image" class="leaderboardpicture">
                                        <span class="leaderboardname">{{ $value->name}}</span>

                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8" style="text-align: right;">
                                                <input type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3" name="value" value="0">
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8" style="text-align: center;">
                                                <span>กรัม</span>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8" style="text-align: right;">
                                                <button type="submit" class="btn btn-success">เพิ่ม</button>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>

                                    </article>
                                </form>
                                @endforeach
                            </div>
                        </main>
                    </div>

                </article>

                {!! $igd_info->links() !!}

            </div>
        </div>
    </div>
</div>


@endsection