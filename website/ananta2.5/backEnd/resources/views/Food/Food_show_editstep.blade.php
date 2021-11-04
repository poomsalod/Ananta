@extends('master')

@section('style')
<link href="{{ asset('css/food/food_show_style.css') }}" rel="stylesheet">
@endsection

@section('nav')

@endsection

@section('title')
แก้ไขวิธีทำในเมนู
@endsection

@section('content')


<div class="row">

    <div class="col-md-12 colblock">
        @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul> @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(\Session::has('error'))
        <div class="alert alert-danger">
            <p>{{ \Session::get('error')}}</p>
        </div>
        @endif

        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
        </div>
        @endif

        <div class="row">
            <div class="col-md-12 colhead1">
                <span class="sphead" style="font-size: 150%;">แก้ไขวิธีทำในเมนู</span>
            </div>
        </div>

        <form action="{{url('/food/show/update/step')}}" method="POST" role="form">
            {{csrf_field()}}
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <span>ขั้นตอนที่ {{ $step->order }}</span> -->
                                <span>รายละเอียด</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="form-control" name="step" rows="5" >{{ $step->step }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="sof_id" value="{{ $step->step_of_food_id }}">
                                <!-- <input class="form-control" type="number" min="1" name="order" value="{{ $step->order }}"> -->
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('/food/show',$step->food_id) }}" type="button" class="btn btn-danger">ย้อนกลับ</a>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </form>




    </div>

</div>



@endsection