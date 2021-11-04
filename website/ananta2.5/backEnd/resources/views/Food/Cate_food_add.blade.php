@extends('master')

@section('style')
<link href="{{ asset('css/igd_info/Igd_info_add_style.css') }}" rel="stylesheet">
@endsection

@section('title')
เพิ่มประเภทเมนูใหม่
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-12 line3">
                <span class="haedline">เพิ่มประเภทเมนูใหม่</span>
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

                <form action="{{url('/food/cate/add')}}" method="POST" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="">ชื่อประเภทเมนู</label>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" class="form-control ipMIGD mb-3" name="name" value="{{ old('name') }}">

                        <input type="hidden" name="backpageUrl" value="{{ \Session::has('backpageUrl') ? \Session::get('backpageUrl') : url()->previous() }}">
                        <a href="{{ \Session::has('backpageUrl') ? \Session::get('backpageUrl') : url()->previous() }}"><button type="button" class="btn btn-primary">ย้อนกลับ</button></a>
                        <button type="submit" class="btn btn-success">บันทึก</button>
                    </div>

                </form>


            </div>
            <div class="col-md-2"></div>
        </div>


    </div>
</div>


@endsection
