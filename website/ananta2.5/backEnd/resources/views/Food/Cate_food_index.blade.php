@extends('master')

@section('style')
<link href="{{ asset('css/igd_info/Igd_info_index_style.css') }}" rel="stylesheet">
@endsection

@section('nav')
<li class="nav-item">

</li>
@endsection

@section('title')
ประเภทเมนู
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-9 col-sm-8 colhead1">
                <span class="haedline1">รายการประเภทเมนู</span>
            </div>
            <div class="col-md-3 col-sm-4 colhead1">
                <a href="{{url('/food/cate/create')}}" class="btn btn-success" style="height: 100%; width: 100%;">เพิ่มประเภทเมนู</a>
            </div>
        </div>

        @if(\Session::has('success'))
            @if(\Session::get('success') != 1)
            <div class="alert alert-success">
                <p>{{ \Session::get('success')}}</p>
            </div>
            @else
            <div class="alert alert-danger">
                <p>ลบไม่ได้ เนื่องจากข้อมูลนี้ถูกเชื่อมโยงแล้ว</p>
            </div>
            @endif
        @endif

        <div class="row">
            <div class="col-md-12 mb-3">
                <span>ผลลัพธ์: {{$count}}</span>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table tbb">
                        <thead>
                            <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">ชื่อประเภท</th>
                                <th scope="col">แก้ไข</th>
                                <th scope="col">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($count == 0)
                            <tr>
                                <td class="text-danger">**ไม่มีข้อมูล**</td>
                            </tr>
                            @endif

                            @foreach($cate_food as $key => $value)
                            <tr>
                                <th scope="row">{{ ++$i }}</th>
                                <td>{{ $value->name }}</td>
                                <td>
                                    <a href="{{url('/food/cate/edit',$value->cate_food_id)}}" class="btn btn-primary">แก้ไข</a>
                                </td>
                                <td>
                                    <form action="{{ url('/food/cate/delete' , $value->cate_food_id) }}" method="post" class="delete_form" onSubmit="if(!confirm('คุณต้องการลบข้อมูลหรือไม่ ?')){return false;}" style="margin:  0%;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                {!! $cate_food->links() !!}
            </div>
        </div>
    </div>
</div>



@endsection