@extends('Users.master_user')

@section('style')
<link href="{{ asset('css/users/user_home_style.css') }}" rel="stylesheet">
@endsection

@section('title')
หน้าแรก
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-9 col-sm-8 colhead1">
                <span class="haedline1">ยินดีต้อนรับคุณ {{ Auth::user()->username }}</span>
            </div>
            <div class="col-md-3 col-sm-4 colhead1">
               
            </div>
        </div>
    </div>

    <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table tbb">
                        <thead>
                            <tr>
                                <th scope="col">รูป</th>
                                <th scope="col">ชื่อ</th>
                                <th scope="col">ประเภท</th>
                                <th scope="col">จำนวนวัตถุดิบ</th>
                                <th scope="col">จำนวนวิธีทำ</th>
                                <th scope="col">แคลอรี่</th>
                                <th scope="col">แก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($foodrec as $key => $value)

                            <tr>
                                <td class="table_img"><img src="{{ asset('/storage/images/food/'.$value->image) }}" class="img_igd" alt="Image"></td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->Cate_food->name }}</td>
                                <td>{{ count($value->iof) }}</td>
                                <td>{{ count($value->step) }}</td>
                                <td class="fontcolorpower">{{ floor($value->calorie) }}</td>
                                <td>
                                    <a href="{{url('/food/show',$value->food_id)}}" class="btn btn-primary">รายละเอียด</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
</div>


@endsection