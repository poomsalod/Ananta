@extends('master')

@section('style')
<link href="{{ asset('css/igd_info/Igd_info_index_style.css') }}" rel="stylesheet">
@endsection

@section('nav')
<li class="nav-item">

</li>
@endsection

@section('title')
แก้ไขวัตถุดิบในเมนู
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-9 col-sm-8 colhead1">
                <span class="haedline1">แก้ไขวัตถุดิบในเมนู</span>
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
                <form action="{{ url('/food/show/update/igd') }}" method="Post" role="form">
                    {{csrf_field()}}
                    <input type="hidden" name="iof_id" value="{{ $iof->igd_of_food_id }}">

                    <div class="form-group">


                        <img src="{{ asset('/storage/images/igd/'.$iof->igd_info->image) }}" class="img_igd" alt="Image">
                        <br>
                        <br>
                        ชื่อวัตถุดิบ:
                        <label for="">{{ $iof->igd_info->name }}</label>
                        <br>
                        รายละเอียด
                        <input type="text" class="form-control" name="des" value="">
                        <br>

                        <input type="hidden" name="importance" id="importance" value="{{ $iof->importance }}">
                        @if($iof->importance == 1)
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
                        @else
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio1" id="radio1" value="Enable">
                            <label class="form-check-label" for="radio1">
                                ระบุจำนวน
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio1" id="radio1" value="Disable" checked>
                            <label class="form-check-label" for="radio1">
                                ไม่ระบุจำนวน
                            </label>
                        </div>
                        @endif
                        <br>
                        จำนวน
                        <input id="input1" type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3" name="value" value="{{ $iof->value }}">
                        <br>
                        หน่วย
                        <select id="select1" name="unit1" class="form-control">
                            @if($iof->importance == 1)
                            <option value="{{ $iof->unit }}">{{ $iof->unit }}</option>
                            @else
                            <option value="">เลือก</option>
                            @endif
                            <option value="กรัม">กรัม</option>
                            <option value="ช้อนชา">ช้อนชา</option>
                            <option value="ช้อนโต๊ะ">ช้อนโต๊ะ</option>
                            <option value="ถ้วยตวง">ถ้วยตวง</option>
                            <!-- <option value="อื่นๆ">อื่นๆ</option> -->
                        </select>
                        <br>
                        <a href="{{ url('/food/show',$iof->food_id) }}" type="button" class="btn btn-danger">ย้อนกลับ</a>
                        <button type="submit" class="btn btn-primary">บันทึก</button>

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
    $(document).ready(function() {
        var importance = document.getElementById('importance').value;
        console.log(importance);
        if(importance == 0){
            $('select[name="unit1"]').attr('disabled',true)
            $('input[name="value"]').attr('readonly',true)
        }

        $('input[name="radio1"]').on('change', function() {
            $('select[name="unit1"]').attr('disabled', this.value != 'Enable')
            $('input[name="value"]').attr('readonly', this.value != 'Enable')
        })
    });
</script>
@endsection