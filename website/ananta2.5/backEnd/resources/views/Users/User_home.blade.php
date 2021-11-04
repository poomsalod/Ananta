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
</div>


@endsection