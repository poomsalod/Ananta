@extends('Users.master_user')

@section('title')
Edit Profile
@endsection

@section('style')
<link href="{{ asset('css/users/show_food_user.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/edit_profile.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <form action="{{url('/edti/profile/update')}}" method="POST" role="form" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="col-md-12 colblock">

                <input type="hidden" name="user_id" value="{{Auth::user()->user_profile->user_id}}">
                <div class="row">

                    <div class="col-md-12 line3">
                        <div class="addd">
                            <span class="haedline" style="font-size: 25;">แก้ไขข้อมูลส่วนตัว</span>
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

                            <label for="" class="floatLabel">ชื่อ</label>
                            <input name="f_name" class="form-control mb-3" type="text" value="{{ Auth::user()->user_profile->f_name }}">

                            <label for="" class="floatLabel">นามสกุล</label>
                            <input name="l_name" class="form-control mb-3" type="text" value="{{ Auth::user()->user_profile->l_name }}">


                            <label for="" class="floatLabel">วันเกิด</label>
                            <input name="birthday" class="form-control mb-3" type="date" value="{{ Auth::user()->user_profile->birthday }}">

                            <label for="">เพศ</label>
                            @error('name')
                            <span class="text-danger" name="gender">{{$message}}</span>
                            @enderror

                            <select class="form-control mb-3" name="gender" id="">
                                @if( $data->gender == 1 )
                                <option value="1">ชาย</option>
                                <option value="2">หญิง</option>
                                @else
                                <option value="2">หญิง</option>
                                <option value="1">ชาย</option>
                                @endif

                            </select>

                            <label for="">น้ำหนัก</label>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input type="number" step="0.0001" min="0" max="9999" class="form-control mb-3" name="weight" value="{{ $data->weight }}" placeholder="กรอกน้ำหนัก (หน่วยเป็นกิโลกรัม)">

                            <label for="">ส่วนสูง</label>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input type="number" step="0.0001" min="0" max="9999" class="form-control mb-3" name="height" value="{{ $data->height }}" placeholder="กรอกส่วนสูง (หน่วยเป็นเซนติเมตร)">

                            <label for="">กิจกรรมที่ทำต่อสัปดาห์</label>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <select class="form-control mb-3" name="activity" id="">
                                <?php
                                $atv = [1.2, 1.375, 1.55, 1.725, 1.9];
                                $atvname = ['ไม่ออกกำลังกายหรือทำงานนั่งโต๊ะ', 'ออกกำลังกายเบาๆ(1-2 ครั้งต่อสัปดาห์ )', 'ออกกำลังกายปานกลาง(3-5 ครั้งต่อสัปดาห์)', 'ออกกำลังกายหนัก(6-7 ครั้งต่อสัปดาห์)', 'ออกกำลังกายหนักมาก(ทุกวัน วันละ 2 เวลา)'];
                                for ($i = 0; $i < count($atv); $i++) {
                                    if ($data->activity == $atv[$i]) {
                                        echo "<option value=" . $atv[$i] . ">" . $atvname[$i] . "</option>";
                                    }
                                }
                                for ($i = 0; $i < count($atv); $i++) {
                                    if ($data->activity != $atv[$i]) {
                                        echo "<option value=" . $atv[$i] . ">" . $atvname[$i] . "</option>";
                                    }
                                }
                                ?>
                            </select>

                        </div>

                        <div class="afoi">
                                <a class="btn btn-info " href="{{ url('/setting/profile' ,Auth::user()->user_profile->user_id ) }}">กลับ</a>
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