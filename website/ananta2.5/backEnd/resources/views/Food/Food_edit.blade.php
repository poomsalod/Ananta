@extends('master')

@section('style')
<link href="{{ asset('css/food/food_add_style.css') }}" rel="stylesheet">
@endsection

@section('title')
แก้ไขเมนู
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-12 line3">
                <span class="haedline">แก้ไขเมนู</span>
            </div>
        </div>

        <!-- @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul> @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif -->

        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
        </div>
        @endif

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">

                <form action="{{ url('/food/show/update') }}" method="POST" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <input type="hidden" name="id" value="{{ $food->food_id }}">

                    <div class="form-group">
                        <label for="">ชื่อเมนู</label>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" class="form-control ipMIGD mb-3" name="name" value="{{ $food->name }}">

                        <label for="">ประเภท</label>
                        @error('category')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <select class="form-control mb-3" name="category" id="selecter" onChange="goAddCate()">
                            <option value="{{ $food->cate_food_id }}">{{ $food->cate_food->name }}</option>
                            @foreach($cate_food as $key => $value)
                            <option value="{{ $value->cate_food_id }}">{{ $value->name }}</option>
                            @endforeach
                            <option value="-5">เพิ่มประเภท</option>
                        </select>

                        <img src="{{ asset('/storage/images/food/'.$food->image) }}" onClick="triggerClick()" id="profileDisplay">
                        <label for="">อัพโหลดรูป</label>
                        @error('img')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="custom-file mb-3">
                            <input type="file" class="form-control custom-file-input" onChange="displayImage(this)" id="profileImage" name="img">
                            <label class="custom-file-label" for="profileImage">{{ $food->image }}</label>
                        </div>

                        <label for="">ที่มาของข้อมูล</label>
                        @error('addess')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <label for="">(เช่น https://www.maeban.co.th/) </label>
                        <input type="text" class="form-control ipMIGD mb-3" name="addess" value="{{ $food->addess }}">

                        <a href="{{ url('/food/show',$food->food_id) }}" type="button" class="btn btn-danger">ย้อนกลับ</a>
                        <button type="submit" class="btn btn-success">บันทึก</button>


                    </div>

                </form>


            </div>
            <div class="col-md-2"></div>
        </div>


    </div>
</div>


@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>

<script>
    function triggerClick(e) {
        document.querySelector('#profileImage').click();
    }

    function displayImage(e) {
        if (e.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);

        }
    }

    $(document).ready(function() {
        bsCustomFileInput.init()
    })

    function goAddCate(e) {
        var value = document.getElementById("selecter").value;
        console.log(value);
        if (value == -5) {
            document.querySelector('#add_cate').click();
        }
    }
</script>
@endsection