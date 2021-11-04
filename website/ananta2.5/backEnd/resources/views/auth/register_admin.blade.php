@extends('auth.master_log_reg')

@section('title')
สมัครเป็นผู้ดูแลระบบ
@endsection

@section('content')
<div class="row">
	<div class="col-md-12 colblock">
		<h4 class="card-title">สมัครเป็นผู้ดูแลระบบ</h4>
		<form method="POST" class="my-login-validation" autocomplete="off" action="{{ route('admin_createregister') }}">

			@if ( Session::get('success'))
			<div class="alert alert-success">
				{{ Session::get('success') }}
			</div>
			@endif
			@if ( Session::get('error'))
			<div class="alert alert-danger">
				{{ Session::get('error') }}
			</div>
			@endif
			@csrf

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="f_name">ชื่อ</label>
						<input id="f_name" type="text" class="form-control" name="f_name" autofocus placeholder="กรอกชื่อ" value="{{ old('f_name') }}">
						<span class="text-danger">@error('f_name'){{ $message }}@enderror</span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="l_name">นามสกุล</label>
						<input id="l_name" type="text" class="form-control" name="l_name" autofocus placeholder="กรอกนามสกุล" value="{{ old('l_name') }}">
						<span class="text-danger">@error('l_name'){{ $message }}@enderror</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="name">ชื่อผู้ใช้</label>
				<input id="username" type="text" class="form-control" name="username" autofocus placeholder="กรอกชื่อผู้ใช้" value="{{ old('username') }}">
				<span class="text-danger">@error('username'){{ $message }}@enderror</span>
			</div>

			<div class="form-group">
				<label for="password">รหัสผ่าน</label>
				<input id="password" type="password" class="form-control" name="password" data-eye placeholder="กรอกรหัสผ่าน">
				<span class="text-danger">@error('password'){{ $message }}@enderror</span>
			</div>

			<div class="form-group">
				<label for="password-confirm">ยืนยัน รหัสผ่าน</label>
				<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required data-eye placeholder="กรอกรหัสผ่านอีกครั้ง">
				<span class="text-danger">@error('password_confirmation'){{ $message }}@enderror</span>
			</div>

			<div class="form-group">
				<label for="email">อีเมล</label>
				<input id="email" type="email" class="form-control" name="email" autofocus placeholder="กรอกอีเมล" value="{{ old('email') }}">
				<span class="text-danger">@error('email'){{ $message }}@enderror</span>
			</div>

			<div class="form-group m-0">
				<button type="submit" class="btn btn-primary btn-block">
					บันทึก
				</button>
			</div>
			<div class="mt-4 text-center">
				มีบัญชีผู้ใช้อยู่แล้ว <a href="{{route('login')}}">ล็อกอิน</a>
			</div>
		</form>
	</div>
</div>
@endsection