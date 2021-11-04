@extends('Users.master_user')

@section('title')
Edit Profile
@endsection

@section('style')
<link href="{{ asset('css/users/show_food_user.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/edit_profile.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/Users_stock/Photo_igd_stock.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 colblock">
        <form action="{{url('/show/igd_stock/update')}}" method="POST" role="form" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="col-md-12 colblock">

                <input type="hidden" name="id" value="{{ $igd_stock->stock_igd_id }}">
                <input type="hidden" name="igd_info_id" value="{{ $igd_stock->igd_info_id }}">

                <div class="row">
                    <div class="col-md-12 line3">
                        <div class="addd">
                            <span class="haedline" style="font-size: 25;">แก้ไขข้อมูลวัตถุดิบที่มี</span>
                        </div>
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
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-12 colblock" style="padding: 2%; font-size: 25; text-align: center;">
                                    <img src="{{ asset('/storage/images/igd/'.$igd_stock->igd_info->image) }}" alt="Image" class="Photo_igd_stock">
                                </div>
                            </div>

                            <div class="row" style="text-align: center;">
                                <div class="col-md-12" style="padding: 2%; font-size: 25;">
                                    <span class="leaderboardname">{{ $igd_stock->igd_info->name}}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-3"></div>
                                <div class="col-md-2 col-2" style="padding: 2%; text-align: center;">
                                    <span for="" class="floatLabel">จำนวน</span>
                                </div>

                                <div class="col-md-2 col-2" style="padding: 2%;">
                                    <input name="value" class="form-control mb-3" type="number" value="{{ $igd_stock->value}}">
                                </div>
                            
                                <div class="col-md-2 col-2" style="padding: 2%; text-align: center;">
                                    <span class="floatLabel">กรัม</span>
                                </div>
                                <div class="col-md-3 col-3"></div>
                            </div>

                            <div class="afoi">
                                <a class="btn btn-info " href="{{ url('/show/igd_stock/') }}">กลับ</a>
                                <button type="submit" class="btn btn-success">บันทึก</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection