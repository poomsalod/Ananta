@extends('master')

@section('style')
<link href="{{ asset('css/igd_info/Igd_info_edit_style.css') }}" rel="stylesheet">
@endsection

@section('title')
แก้ไขประเภทเมนู
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-12 line3">
                <span class="haedline">แก้ไขประเภทเมนู</span>
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

                <form action="{{url('/food/cate/update')}}" method="POST" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    
                    <input type="hidden" name="id" value="{{ $cate_food->cate_food_id }}">
                    <div class="form-group">
                        <label for="">ชื่อประเภทเมนู</label>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" class="form-control ipMIGD mb-3" name="name" value="{{ $cate_food->name }}">

                        <a href="{{ url('/food/cate/index') }}"><button type="button" class="btn btn-primary">ย้อนกลับ</button></a>
                        <button type="submit" class="btn btn-success">บันทึก</button>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>

@endsection

