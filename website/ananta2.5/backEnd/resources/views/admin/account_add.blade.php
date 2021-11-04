@extends('master')

@section('style')
<link href="{{ asset('css/igd_info/Igd_info_index_style.css') }}" rel="stylesheet">
@endsection

@section('nav')
<li class="nav-item">

</li>
@endsection

@section('title')
ระงับบัญชีผู้ใช้
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-9 col-sm-8 colhead1">
                <span class="haedline1">รายการบัญชีผู้ใช้ที่ไม่มีใช้งานนาน 3 ปี</span>
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
                            <form action="{{ url('/admin/account/add') }}" method="POST" role="form" onSubmit="if(!confirm('คุณต้องการระงับบัญชีหรือไม่ ?')){return false;}">
                                {{csrf_field()}}
                                <input type="hidden" name="account_id" value="{{ $value->account_id }}">
                                <td>{{ $value->account_id }}</td>
                                <td>
                                    <button type="submit" class="btn btn-danger">ระงับบัญชี</button>
                                </td>
                            </form>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <a href="{{ url('/admin/account/index') }}"><button type="button" class="btn btn-primary">ย้อนกลับ</button></a>


            </div>
        </div>

    </div>
</div>



@endsection