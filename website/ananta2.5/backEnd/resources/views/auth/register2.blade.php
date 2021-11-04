<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Register page</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">

	<script src="jquery-3.4.1.min.js"></script>
	<script src="bootstrap/js/popper.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>
	<script src="js/my-login.js"></script>
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">

					<div class="cardx fat mt-4">
						<div class="card-body">
							<h4 class="card-title">Register</h4>
							<form method="POST" class="my-login-validation" autocomplete="off" action="{{ route('register') }}">

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

				</div>
			</div>
		</div>
	</section>

	
</body>

</html>