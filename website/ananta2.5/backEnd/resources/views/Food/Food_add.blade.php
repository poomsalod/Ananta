@extends('master')

@section('style')
<link href="{{ asset('css/food/food_add_style.css') }}" rel="stylesheet">
@endsection

@section('title')
เพิ่มเมนูใหม่
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-12 line3">
                <span class="haedline">เพิ่มเมนูใหม่</span>
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
        <script>clearLocalStore()</script>
        @endif

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">

                <form action="{{url('/food/add')}}" method="POST" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="">ชื่อเมนู</label>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" class="form-control ipMIGD mb-3" name="name" id="input_name" onblur="goToAnotherPage()" value="{{ old('name') }}">

                        <label for="">ประเภท</label>
                        @error('category')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <select class="form-control mb-3" name="category" id="selecter" onChange="goAddCate()">
                            <option selected>เลือกประเภท</option>
                            @foreach($cate_food as $key => $value)
                            <option value="{{ $value->cate_food_id }}">{{ $value->name }}</option>
                            @endforeach
                            <option value="-5">เพิ่มประเภท</option>
                        </select>

                        <img src="" onClick="triggerClick()" id="profileDisplay">
                        <label for="">อัพโหลดรูป</label>
                        @error('img')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="custom-file mb-3">
                            <input type="file" class="form-control custom-file-input" onChange="displayImage(this)" id="profileImage" name="img">
                            <label class="custom-file-label" for="profileImage">เลือกรูปภาพ</label>
                        </div>

                        <label for="">ที่มาของข้อมูล</label>
                        @error('addess')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <label for="">(เช่น https://www.maeban.co.th/) </label>
                        <input type="text" class="form-control ipMIGD mb-3" name="addess" id="input_addess" onblur="goToAnotherPage()" value="{{ old('addess') }}">

                        <input type="hidden" name="backpageUrl" value="{{ \Session::has('backpageUrl') ? \Session::get('backpageUrl') : url()->previous() }}">
                        <a href="{{ \Session::has('backpageUrl') ? \Session::get('backpageUrl') : url()->previous() }}"><button type="button" class="btn btn-primary">ย้อนกลับ</button></a>
                        <a hidden href="{{url('/food/cate/create')}}" id="add_cate"><button type="button" class="btn btn-primary">เพิ่มประเภท</button></a>
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
    // const input_name;
    // const input_cate;
    // const input_addess;

    $(document).ready(function() {
        bsCustomFileInput.init()

        input_name = document.getElementById('input_name');
        input_cate = document.getElementById('selecter');
        input_addess = document.getElementById('input_addess');

        if(localStorage.getItem('newFoodName')){
            input_name.value = localStorage.getItem('newFoodName');
        }
        // if(localStorage.getItem('newFoodCate')){
        //     input_cate.value = 'เลือกประเภท';
        // }

        if(localStorage.getItem('newFoodCate')){
            if(localStorage.getItem('newFoodCate')==-5){
                input_cate.value = 'เลือกประเภท';
            }else{
                input_cate.value = localStorage.getItem('newFoodCate');
            }
        }
        if(localStorage.getItem('newFoodAddess')){
            input_addess.value = localStorage.getItem('newFoodAddess');
        }

    })

    function goToAnotherPage() {
        localStorage.setItem('newFoodName', input_name.value);
        localStorage.setItem('newFoodCate', input_cate.value);
        localStorage.setItem('newFoodAddess', input_addess.value);
    }

    function clearLocalStore() {
        //addFood
        localStorage.removeItem('newFoodName');
        localStorage.removeItem('newFoodCate');
        localStorage.removeItem('newFoodAddess');
    }

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



    function goAddCate(e) {
        goToAnotherPage();
        var value = document.getElementById("selecter").value;
        console.log(value);
        if (value == -5) {
            document.querySelector('#add_cate').click();
        }
    }
</script>
@endsection