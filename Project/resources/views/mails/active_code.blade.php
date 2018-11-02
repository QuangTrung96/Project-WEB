<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
	</head>

	<body>
		<h1 style="color: #4286f4">Xin chào, {{ $username }}</h1>
		<b style="color: #339933">Bạn vừa, gửi yêu cầu lấy lại mật khẩu cho chúng tôi.</b>
		<p style="color: #339933">Để thay đổi mật khẩu, vui lòng nhấp chọn vào lên kết bên dưới.</p>
		<a  style='color:red;' href="{{ route('active_reset_get', [$username, urlencode($code)]) }}">Nhấn chuột vào đây để xác nhân.</a>
		<p>Trân trọng.</p>
	</body>
</html>