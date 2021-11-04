@extends('master')

@section('style')
<link href="{{ asset('css/igd_info/Igd_info_index_style.css') }}" rel="stylesheet">
@endsection

@section('nav')
<li class="nav-item">

</li>
@endsection

@section('title')
ข้อมูลวัตถุดิบ
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-9 col-sm-8 colhead1">
                <span class="haedline1">รายการข้อมูลวัตถุดิบ</span>
            </div>
            <div class="col-md-3 col-sm-4 colhead1">
                <a href="{{url('/igd-info/create')}}" class="btn btn-success" style="height: 100%; width: 100%;">เพิ่มวัตถุดิบในระบบ</a>
            </div>
        </div>

        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
        </div>
        @endif

        <div class="row">
            <div class="col-md-12">

                <form action="{{ url('/igd-info/search') }}" method="GET" role="form">
                    <div class="input-group">
                        <input type="search" class="form-control" name="search" placeholder="ป้อนข้อมูลที่ต้องการค้นหา">
                        <select class="input-group-prepend" name="category" >
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
            <div class="col-md-12 mb-3" style="text-align: right;">
                <span class="fontcolorpower">ค่าพลังงานของข้อมูลทั้งหมดคิดจากปริมาณ 1 กรัม</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table tbb">
                        <thead>
                            <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">รูป</th>
                                <th scope="col">ชื่อ</th>
                                <th scope="col">ประเภท</th>
                                <th scope="col">โปรตีน (g)</th>
                                <th scope="col">คาร์โบไฮเดรต (g)</th>
                                <th scope="col">ไขมัน (g)</th>
                                <th scope="col">ใยอาหาร (g)</th>
                                <th scope="col">แคลอรี่ (kcal)</th>
                                <th scope="col">ตัวเลือก</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($count == 0)
                            <tr>
                                <td class="text-danger">**ไม่มีข้อมูล**</td>
                            </tr>
                            @endif

                            @foreach($igd_info as $key => $value)
                            <tr>
                                <th scope="row">{{ ++$i }}</th>
                                <td class="table_img"><img src="{{ asset('/storage/images/igd/'.$value->image) }}" class="img_igd" alt="Image"></td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->Cate_igd->name }}</td>
                                <td class="fontcolorpower">{{ $value->protein }}</td>
                                <td class="fontcolorpower">{{ $value->carbohydrate }}</td>
                                <td class="fontcolorpower">{{ $value->fat }}</td>
                                <td class="fontcolorpower">{{ $value->fiber }}</td>
                                <td class="fontcolorpower">{{ $value->calorie }}</td>
                                <td>
                                    <a href="{{url('/igd-info/edit',$value->igd_info_id)}}" class="btn btn-primary">แก้ไข</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                {!! $igd_info->links() !!}
            </div>
        </div>
    </div>
</div>



@endsection