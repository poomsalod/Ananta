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
    <div class="col-md-12">
        <form action="{{url('/add/profile')}}" method="POST" role="form" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="col-md-12 colblock">

                <input type="hidden" name="user_id" value="{{Auth::user()->user_profile->user_id}}">
                <div class="row">

                    <div class="col-md-12 line3">
                        <div class="addd">
                            <span class="haedline" style="font-size: 25;">เพิ่มข้อมูลส่วนตัว</span>
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

                            <label for="">เพศ</label>
                            @error('name')
                            <span class="text-danger" name="gender">{{$message}}</span>
                            @enderror

                            <select class="form-control mb-3" name="gender" id="">
                                <option value="">กรุณาเลือกเพศคุณ</option>
                                <option value="1">ชาย</option>
                                <option value="2">หญิง</option>
                            </select>

                            <label for="">น้ำหนัก</label>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input type="number" step="0.0001" min="0" max="9999" class="form-control mb-3" name="weight" value="" placeholder="กรอกน้ำหนัก (หน่วยเป็นกิโลกรัม)">

                            <label for="">ส่วนสูง</label>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input type="number" step="0.0001" min="0" max="9999" class="form-control mb-3" name="height" value="" placeholder="กรอกส่วนสูง (หน่วยเป็นเซนติเมตร)">

                            <label for="">กิจกรรมที่ทำต่อสัปดาห์</label>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <select class="form-control mb-3" name="activity" id="">
                                <option value="">กรุณาเลือกกิจกรรมของคุณ</option>
                                <option value="1.2">ไม่ออกกำลังกายหรือทำงานนั่งโต๊ะ</option>
                                <option value="1.375">ออกกำลังกายเบาๆ(1-2 ครั้งต่อสัปดาห์ )</option>
                                <option value="1.55">ออกกำลังกายปานกลาง(3-5 ครั้งต่อสัปดาห์)</option>
                                <option value="1.725">ออกกำลังกายหนัก(6-7 ครั้งต่อสัปดาห์)</option>
                                <option value="1.9">ออกกำลังกายหนักมาก(ทุกวัน วันละ 2 เวลา)</option>
                            </select>

                        </div>

                        <div class="afoi">
                            <button type="submit" class="btn btn-success">บันทึก</button>
                        </div>

                    </div>


                    <div class="col-md-3"></div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection