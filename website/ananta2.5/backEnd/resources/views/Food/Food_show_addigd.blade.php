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
            <div class="col-md-12">

                <form action="{{ url('/food/search/igd') }}" method="GET" role="form">
                    <div class="input-group">
                        <input type="hidden" name="id" value="{{ $food->food_id }}">
                        <input type="search" class="form-control" name="search" placeholder="ป้อนข้อมูลที่ต้องการค้นหา">
                        <select class="input-group-prepend" name="category">
                            <option value="0">ทั้งหมด</option>
                            @foreach($cate_igd as $key => $value)
                            <option value="{{ $value->cate_igd_id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-prepend"><button type="submit" class="btn btn-primary" style="border-radius: 5px;">ค้นหา</button></span>
                    </div>

                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <span>ผลลัพธ์: {{$count}}</span>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">

                <div class="table-responsive">
                    <table class="table tbb" style="width: 1050;">
                        <thead>
                            <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">รูป</th>
                                <th scope="col">ชื่อ</th>
                                <th scope="col">ประเภท</th>
                                <th scope="col"></th>
                                <!-- <th scope="col" style="width: 200;">รายละเอียด</th>
                                <th scope="col" style="width: 100;">จำนวน</th>
                                <th scope="col" style="width: 100;">หน่วย</th>
                                <th scope="col">เพิ่ม</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @if($count == 0)
                            <tr>
                                <td class="text-danger">**ไม่มีข้อมูล**</td>
                            </tr>
                            @endif

                            @foreach($igd_info as $key => $value)
                            <form action="{{ url('/food/show/add/igd/detail') }}" method="POST" role="form">
                                {{csrf_field()}}
                                <input type="hidden" name="food_id" value="{{ $food->food_id }}">
                                <div class="form-group">
                                    <tr>
                                        <th scope="row">{{ ++$i }}</th>
                                        <td class="table_img"><img src="{{ asset('/storage/images/igd/'.$value->image) }}" class="img_igd" alt="Image"></td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->Cate_igd->name }}</td>
                                        <input type="hidden" name="igd_info_id" value="{{ $value->igd_info_id }}">
                                        <!-- <td>
                                            <input type="text" class="form-control" name="des" value="">
                                        </td>
                                        <td>
                                            <input type="number" step="0.0001" min="0" max="9999" class="form-control ipMIGD mb-3" name="value" value="0">
                                        </td>
                                        <td>
                                            <select name="unit1" class="form-control">
                                                <option value="อื่นๆ">เลือก</option>
                                                <option value="กรัม">กรัม</option>
                                                <option value="ช้อนชา">ช้อนชา</option>
                                                <option value="ช้อนโต๊ะ">ช้อนโต๊ะ</option>                                               
                                                <option value="ถ้วยตวง">ถ้วยตวง</option>
                                                <option value="อื่นๆ">อื่นๆ</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary">เพิ่ม</button>
                                        </td> -->
                                        <td>
                                            <a href="{{ url('/food/show/add/igd/detail' , [$food->food_id,$value->igd_info_id]) }}" type="button" class="btn btn-primary">เลือก</a>
                                            <!-- <button type="submit" class="btn btn-primary">เลือก</button> -->
                                        </td>
                                    </tr>
                                </div>
                            </form>
                            @endforeach
                        </tbody>
                    </table>

                    

                </div>
                {!! $igd_info->links() !!}


            </div>
            <a href="{{ url('/food/show',$food->food_id) }}" type="button" class="btn btn-danger">ย้อนกลับ</a>
        </div>
    </div>
</div>



@endsection