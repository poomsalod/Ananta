@extends('master')

@section('style')
<link href="{{ asset('css/food/food_index_style.css') }}" rel="stylesheet">
@endsection

@section('nav')
<li class="nav-item">

</li>
@endsection

@section('title')
การระงับบัญชีผู้ใช้
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-9 col-sm-8 colhead1">
                <span class="haedline1">รายการบัญชีผู้ใช้ที่ถูกระงับ</span>
            </div>
            <div class="col-md-3 col-sm-4 colhead1">
                <a href="{{url('/admin/account/show')}}" class="btn btn-success" style="height: 100%; width: 100%;">ระงับบัญชี</a>
            </div>
        </div>

        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
        </div>
        @endif

        <div class="row">
            <div class="col-md-12 mb-3">
                <span>ผลลัพธ์: {{ $count }} </span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table tbb">
                        <thead>
                            <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">Account Id</th>
                                <th scope="col">ตัวเลือก</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($count == 0)
                            <tr>
                                <td class="text-danger">**ไม่มีข้อมูล**</td>
                            </tr>
                            @endif

                            @foreach($baduser as $key => $value)
                            <td>{{ ++$i }}</td>
                            <td>{{ $value->account_id }}</td>
                            <form action="{{ url('/admin/account/edit') }}" method="POST" role="form" onSubmit="if(!confirm('คุณต้องยกเลิกการระงับบัญชีหรือไม่ ?')){return false;}">
                                {{csrf_field()}}
                                <input type="hidden" name="account_id" value="{{ $value->account_id }}">
                                <td>
                                    <button type="submit" class="btn btn-danger">ยกเลิกการระงับบัญชี</button>
                                </td>
                            </form>
                            @endforeach
                        </tbody>
                    </table>

                </div>


            </div>
        </div>
    </div>
</div>



@endsection