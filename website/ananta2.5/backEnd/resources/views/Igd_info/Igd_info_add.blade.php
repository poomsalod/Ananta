@extends('master')

@section('style')
<link href="{{ asset('css/igd_info/Igd_info_add_style.css') }}" rel="stylesheet">
@endsection

@section('title')
เพิ่มข้อมูลวัตถุดิบใหม่
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-12 line3">
                <span class="haedline">เพิ่มข้อมูลวัตถุดิบใหม่</span>
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
        <div id="alert-success" class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
        </div>

        <script>
            $('#alert-success').delay(3000).fadeOut("slow");

            function clearLocalStore() {
                localStorage.removeItem('newIgdName');
                localStorage.removeItem('newIgdCate');
                localStorage.removeItem('newIgdAddessImg');
                localStorage.removeItem('newIgdCal');
                localStorage.removeItem('newIgdFat');
                localStorage.removeItem('newIgdPro');
                localStorage.removeItem('newIgdCar');
                localStorage.removeItem('newIgdFib');
                localStorage.removeItem('newIgdAddess');
            }
            clearLocalStore();
        </script>
        @endif

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">

                <form action="{{url('/igd-info/add')}}" method="POST" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="">ชื่อวัตถุดิบ</label>
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
                            @foreach($cate_igd as $key => $value)
                            <option value="{{ $value->cate_igd_id }}">{{ $value->name }}</option>
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

                        <label for="">ที่มาของรูปภาพ</label>
                        @error('addess_img')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <label for="">(เช่น https://www.maeban.co.th/) </label>
                        <input type="text" class="form-control ipMIGD mb-3" name="addess_img" id="input_addess_img" onblur="goToAnotherPage()" value="{{ old('addess_img') }}">

                        <label for="">แคลอรี่ (kcal)</label>
                        @error('cal')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3 fontcolorpower" name="cal" id="input_cal" onblur="goToAnotherPage()" value="0">

                        <label for="">ไขมัน (g)</label>
                        @error('fat')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3 fontcolorpower" name="fat" id="input_fat" onblur="goToAnotherPage()" value="0">

                        <label for="">โปรตีน (g)</label>
                        @error('pro')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3 fontcolorpower" name="pro" id="input_pro" onblur="goToAnotherPage()" value="0">

                        <label for="">คาร์โบไฮเดรต (g)</label>
                        @error('car')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3 fontcolorpower" name="car" id="input_car" onblur="goToAnotherPage()" value="0">

                        <label for="">ใยอาหาร (g)</label>
                        @error('fib')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3 fontcolorpower" name="fib" id="input_fib" onblur="goToAnotherPage()" value="0">

                        <label for="">ที่มาของข้อมูล</label>
                        @error('addess')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <label for="">(เช่น https://www.maeban.co.th/) </label>
                        <input type="text" class="form-control ipMIGD mb-3" name="addess" id="input_addess" onblur="goToAnotherPage()" value="{{ old('addess') }}">

                        <input type="hidden" name="backpageUrl" value="{{ \Session::has('backpageUrl') ? \Session::get('backpageUrl') : url()->previous() }}">
                        <a href="{{ \Session::has('backpageUrl') ? \Session::get('backpageUrl') : url()->previous() }}"><button type="button" class="btn btn-primary">ย้อนกลับ</button></a>
                        <a hidden href="{{url('/igd-info/cate/create')}}" id="add_cate"><button type="button" class="btn btn-primary">เพิ่มประเภท</button></a>
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
    $(document).ready(function() {
        bsCustomFileInput.init()

        input_name = document.getElementById('input_name');
        input_cate = document.getElementById('selecter');
        input_addess_img = document.getElementById('input_addess_img');
        input_cal = document.getElementById('input_cal');
        input_fat = document.getElementById('input_fat');
        input_pro = document.getElementById('input_pro');
        input_car = document.getElementById('input_car');
        input_fib = document.getElementById('input_fib');
        input_addess = document.getElementById('input_addess');

        if (localStorage.getItem('newIgdName')) {
            input_name.value = localStorage.getItem('newIgdName');
        }
        if (localStorage.getItem('newIgdCate')) {
            if (localStorage.getItem('newIgdCate') == -5) {
                input_cate.value = 'เลือกประเภท';
            } else {
                input_cate.value = localStorage.getItem('newIgdCate');
            }
        }
        if (localStorage.getItem('newIgdAddessImg')) {
            input_addess_img.value = localStorage.getItem('newIgdAddessImg');
        }
        if (localStorage.getItem('newIgdCal')) {
            input_cal.value = localStorage.getItem('newIgdCal');
        }
        if (localStorage.getItem('newIgdFat')) {
            input_fat.value = localStorage.getItem('newIgdFat');
        }
        if (localStorage.getItem('newIgdPro')) {
            input_pro.value = localStorage.getItem('newIgdPro');
        }
        if (localStorage.getItem('newIgdCar')) {
            input_car.value = localStorage.getItem('newIgdCar');
        }
        if (localStorage.getItem('newIgdFib')) {
            input_fib.value = localStorage.getItem('newIgdFib');
        }
        if (localStorage.getItem('newIgdAddess')) {
            input_addess.value = localStorage.getItem('newIgdAddess');
        }
    })

    function goToAnotherPage() {
        localStorage.setItem('newIgdName', input_name.value);
        localStorage.setItem('newIgdCate', input_cate.value);
        localStorage.setItem('newIgdAddessImg', input_addess_img.value);
        localStorage.setItem('newIgdCal', input_cal.value);
        localStorage.setItem('newIgdFat', input_fat.value);
        localStorage.setItem('newIgdPro', input_pro.value);
        localStorage.setItem('newIgdCar', input_car.value);
        localStorage.setItem('newIgdFib', input_fib.value);
        localStorage.setItem('newIgdAddess', input_addess.value);
    }

    function clearLocalStore() {
        //addFood
        localStorage.removeItem('newIgdName');
        localStorage.removeItem('newIgdCate');
        localStorage.removeItem('newIgdAddessImg');
        localStorage.removeItem('newIgdCal');
        localStorage.removeItem('newIgdFat');
        localStorage.removeItem('newIgdPro');
        localStorage.removeItem('newIgdCar');
        localStorage.removeItem('newIgdFib');
        localStorage.removeItem('newIgdAddess');
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