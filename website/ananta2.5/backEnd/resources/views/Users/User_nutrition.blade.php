@extends('Users.master_user')

@section('title')
รายการเมนู
@endsection

@section('style')
<link href="{{ asset('css/users/show_food_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <form action="#" method="POST" role="form" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="col-md-12 colblock">
                <input type="hidden" name="user_id" value="{{Auth::user()->user_profile->user_id}}">
                <div class="row">
                    <div class="col-md-12 line3">
                        <span class="haedline" style="font-size: 25;">ข้อมูลโภชนาการ</span>
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
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">เพศ</label>
                            @error('name')
                            <span class="text-danger" name="gender">{{$message}}</span>
                            @enderror

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="1" value="1">
                                <label class="form-check-label" for="flexRadioDefault1">ชาย</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="2" value="2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">หญิง</label>
                            </div>

                            <label for="">อายุ</label>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input type="number" class="form-control mb-3" name="age" placeholder="กรอกอายุของคุณ">

                            <label for="">น้ำหนัก</label>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input type="number" class="form-control mb-3" name="weight" placeholder="กรอกน้ำหนัก (kg)">

                            <label for="">ส่วนสูง</label>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input type="number" class="form-control mb-3" name="height" placeholder="กรอกส่วนสูง (cm)">

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
                        <button type="submit" class="btn btn-success">บันทึก</button>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection