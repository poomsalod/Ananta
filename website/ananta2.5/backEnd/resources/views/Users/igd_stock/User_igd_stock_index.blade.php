@extends('Users.master_user')



@section('title')
รายการวัตถุดิบที่รับประทานไม่ได้
@endsection

@section('style')
<link href="{{ asset('css/users/show_food_user.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/viewmenu_rating.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/add_food.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="row">
    <div class="col-md-12 col-12 colblock">
        <div class="row">
            <div class="col-md-9 colhead1">
                <span class="sphead" style="font-size: 200%;">รายการวัตถุดิบที่มี</span>
            </div>
            <div class="col-md-3 col-sm-4 colhead2">
                <a href="{{ url('/show/igd_stock/add') }}" class="btn btn-success" style="height: 100%; width: 100%;">เพิ่มวัตถุดิบที่มี</a>
            </div>
        </div>

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
            <div class="col-md-12 col-12">
                <article class="leaderboard">
                    <header>
                        <h1 class="leaderboard__title"><span class="leaderboard__title--top">รายการวัตถุดิบ</span><span class="leaderboard__title--bottom">ผลลัพธ์: {{$count}}</span></h1>
                    </header>
                    <main class="leaderboardprofiles">
                        @if($count == 0)
                        <article class="leaderboardprofile">
                            <span class="leaderboardname">ไม่มีข้อมูล</span>
                        </article>
                        @else
                        @foreach($stock_igd as $key => $value)
                        <article class="leaderboardprofile">
                            <img src="{{ asset('/storage/images/igd/'.$value->igd_info->image) }}" alt="Image" class="leaderboardpicture">
                            <span class="leaderboardname">{{ $value->igd_info->name}} {{ $value->value}} กรัม</span>
                            <div class="row">
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-12" style="text-align: center;">
                                    <a class="btn btn-info " href="{{ url('/show/igd_stock/edit' , $value->stock_igd_id) }}">แก้ไข</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-12" style="text-align: center;">
                                    <form action="{{ url('/show/igd_stock/delete' , $value->stock_igd_id) }}" method="post" class="delete_form" onSubmit="if(!confirm('คุณต้องการลบข้อมูลหรือไม่ ?')){return false;}" style="margin:  0%;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">ลบ</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                        @endforeach
                        @endif
                    </main>
                </article>
            </div>
            {!! $stock_igd->links() !!}
        </div>
    </div>
</div>


@endsection