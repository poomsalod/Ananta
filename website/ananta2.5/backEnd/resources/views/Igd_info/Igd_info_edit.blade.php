@extends('master')

@section('style')
<link href="{{ asset('css/igd_info/Igd_info_edit_style.css') }}" rel="stylesheet">
@endsection

@section('title')
แก้ไขข้อมูลวัตถุดิบ
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-12 line3">
                <span class="haedline">แก้ไขข้อมูลวัตถุดิบ</span>
            </div>
        </div>

        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
        </div>
        @endif

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">

                <form action="{{url('/igd-info/update')}}" method="POST" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <input type="hidden" name="id" value="{{ $igd_info->igd_info_id }}">
                    <div class="form-group">
                        <label for="">ชื่อวัตถุดิบ</label>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" class="form-control ipMIGD mb-3" name="name" value="{{ $igd_info->name }}">

                        <label for="">ประเภท</label>
                        @error('category')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <select class="form-control mb-3" name="category" id="selecter" onChange="goAddCate()">
                            <option value="{{ $igd_info->Cate_igd->cate_igd_id }}">{{ $igd_info->Cate_igd->name }}</option>
                            @foreach($cate_igd as $key => $value)
                            <option value="{{ $value->cate_igd_id }}">{{ $value->name }}</option>
                            @endforeach
                            <option value="-5">เพิ่มประเภท</option>
                        </select>

                        <img src="{{ asset('/storage/images/igd/'.$igd_info->image) }}" onClick="triggerClick()" id="profileDisplay">
                        <label for="">อัพโหลดรูป</label>
                        @error('img')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="custom-file mb-3">
                            <input type="file" class="form-control custom-file-input" onChange="displayImage(this)" id="profileImage" name="img" value="">
                            <label class="custom-file-label" for="profileImage">{{ $igd_info->image }}</label>
                        </div>

                        <label for="">ที่มาของรูปภาพ</label>
                        @error('addess_img')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <label for="">(เช่น https://www.maeban.co.th/) </label>
                        <input type="text" class="form-control ipMIGD mb-3" name="addess_img" value="{{ $igd_info->addess_img }}">

                        <label for="">แคลอรี่ (kcal)</label>
                        @error('cal')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3 fontcolorpower" name="cal" value="{{ $igd_info->calorie }}">

                        <label for="">ไขมัน (g)</label>
                        @error('fat')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3 fontcolorpower" name="fat" value="{{ $igd_info->fat }}">

                        <label for="">โปรตีน (g)</label>
                        @error('pro')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3 fontcolorpower" name="pro" value="{{ $igd_info->protein }}">

                        <label for="">คาร์โบไฮเดรต (g)</label>
                        @error('car')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3 fontcolorpower" name="car" value="{{ $igd_info->carbohydrate}}">

                        <label for="">ใยอาหาร (g)</label>
                        @error('fib')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3 fontcolorpower" name="fib" value="{{ $igd_info->fiber }}">

                        <label for="">ที่มาของข้อมูล</label>
                        @error('addess')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <label for="">(เช่น https://www.maeban.co.th/) </label>
                        <input type="text" class="form-control ipMIGD mb-3" name="addess" value="{{ $igd_info->addess }}">

                        
                        <a href="{{ url('/igd-info/index') }}"><button type="button" class="btn btn-primary">ย้อนกลับ</button></a>
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