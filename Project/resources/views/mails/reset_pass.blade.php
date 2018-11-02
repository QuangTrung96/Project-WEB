<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
	</head>
	<body>
		<h1 style="color: red">Xin chào, {{ $username }}</h1>
		<p>Cám ơn bạn đã thực hiện yêu cầu xác nhận lấy lại mật khẩu, sau đây là mậy khẩu mới của bạn.</p>
		Mật khẩu: <b>{{ $password }}</b>
		<p><a style='color:red;' href="{{ route('index') }}" target='_blank'>Nhấp chuột, để quay trở lại trang web.</a></p>
		<strong>(Ps: Vui lòng, đổi lại mật khẩu sau khi đã thực hiện việc đăng nhâp.)</strong><br />
		Trân trọng.
	</body>
</html>