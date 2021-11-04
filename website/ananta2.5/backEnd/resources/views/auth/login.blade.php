@extends('auth.master_log_reg')

@section('title')
ล็อกอิน
@endsection

@section('content')
<div class="row">
	<div class="col-md-12 colblock">
		<h4 class="card-title">ล็อกอิน</h4>
		<form method="POST" class="my-login-validation" autocomplete="off" action="{{ route('checklogin') }}">
			@csrf

			@if ($message = Session::get('error'))
			<div class="alert alert-danger alert-blok">
				<button type="button" class="close" data-dismiss="alert">x</button>
				<strong>{{$message}}</strong>
			</div>
			@endif

			<div class="form-group">
				<label for="username">ชื่อผู้ใช้</label>
				<input id="username" type="username" class="form-control" name="username" value="" required autofocus placeholder="กรอกชื่อผู้ใช้">

				@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror

			</div>

			<div class="form-group">
				<label for="password">รหัสผ่าน
					<!-- <a href="{{route('password.request')}}" class="float-right">
						Forgot Password?
					</a> -->
				</label>
				<input id="password" type="password" class="form-control" name="password" required data-eye placeholder="กรอกรหัสผ่าน">

				@error('password')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror

			</div>

			<!-- <div class="form-group">
				<div class="custom-checkbox custom-control">
					<input type="checkbox" name="remember" id="remember" class="custom-control-input">
					<label for="remember" class="custom-control-label">Remeber Me</label>
				</div>
			</div> -->

			<div class="form-group m-0">
				<button type="submit" class="btn btn-primary btn-block">
					ล็อกอิน
				</button>
			</div>
			<div class="mt-4 text-center">
				ยังไม่มีบัญชีผู้ใช้? <a href="{{route('register')}}">สมัครสมาชิก</a>
			</div>
		</form>
	</div>
</div>
@endsection