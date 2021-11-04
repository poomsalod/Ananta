@extends('master')

@section('style')
<link href="{{ asset('css/igd_info/Igd_info_index_style.css') }}" rel="stylesheet">
@endsection

@section('nav')
<li class="nav-item">

</li>
@endsection

@section('title')
เพิ่มวัตถุดิบในเมนู
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-9 col-sm-8 colhead1">
                <span class="haedline1">เพิ่มวัตถุดิบในเมนู</span>
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
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{ url('/food/show/add/igd') }}" method="Post" role="form">
                    {{csrf_field()}}
                    <input type="hidden" name="food_id" value="{{ $food_id }}">
                    <input type="hidden" name="igd_info_id" value="{{ $igd->igd_info_id }}">
                    <div class="form-group">


                        <img src="{{ asset('/storage/images/igd/'.$igd->image) }}" class="img_igd" alt="Image">
                        <br>
                        <br>
                        ชื่อวัตถุดิบ:
                        <label for="">{{ $igd->name }}</label>
                        <br>
                        รายละเอียด
                        <input type="text" class="form-control" name="des" value="">
                        <br>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio1" id="radio1" value="Enable" checked>
                            <label class="form-check-label" for="radio1">
                                ระบุจำนวน
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio1" id="radio1" value="Disable">
                            <label class="form-check-label" for="radio1">
                                ไม่ระบุจำนวน
                            </label>
                        </div>
                        <br>
                        จำนวน
                        <input id="input1" type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3" name="value" value="0">
                        <br>
                        หน่วย
                        <select id="select1" name="unit1" class="form-control">
                            <option value="">เลือก</option>
                            <option value="กรัม">กรัม</option>
                            <option value="ช้อนชา">ช้อนชา</option>
                            <option value="ช้อนโต๊ะ">ช้อนโต๊ะ</option>
                            <option value="ถ้วยตวง">ถ้วยตวง</option>
                            <!-- <option value="อื่นๆ">อื่นๆ</option> -->
                        </select>
                        <br>
                        
                        <a href="{{ url('/food/show/create/igd' , $food_id) }}"><button type="button" class="btn btn-primary">ย้อนกลับ</button></a>
                        <button type="submit" class="btn btn-primary">เพิ่ม</button>

                    </div>
                </form>

            </div>

            <div class="col-md-3"></div>

        </div>

    </div>
</div>
</div>



@endsection
@section('script')
<script>
    $('input[name="radio1"]').on('change', function() {
        $('select[name="unit1"]').attr('disabled', this.value != 'Enable')
        $('input[name="value"]').attr('readonly', this.value != 'Enable')
    })
</script>
@endsection