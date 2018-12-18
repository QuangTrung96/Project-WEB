@if (Sentinel::check())
<div id="rightcontent"><h1>Categories</h1>
	<ul>
		@if (Sentinel::getUser()->hasAccess('scholastic_view'))
		<li><a href="{{ route('scholastic_list_get') }}">Quản lý năm học</a></li>
		@endif

		@if (Sentinel::getUser()->hasAccess('semester_view'))
		<li><a href="{{ route('semester_list_get') }}">Quản lý học kỳ</a></li>
		@endif

		@if (Sentinel::getUser()->hasAccess('subject_view'))
		<li><a href="{{ route('subject_list_get') }}">Quản lý môn học</a></li>
		@endif

		@if (Sentinel::getUser()->hasAccess('point_view'))
		<li><a href="{{ route('point.index') }}">Quản lý điểm</a></li>
		@endif

		@if (Sentinel::getUser()->hasAccess('student_view'))
		<li><a href="{{ route('student.index') }}">Quản lý sinh viên</a></li>
		@endif

		<li><a href="{{ route('changepass_get') }}">Đổi mật khẩu</a></li>
		<li><a href="{{ route('logout_get') }}">Đăng xuất</a></li>								
	</ul>
</div>
@else
<div id="rightcontent"><h1>Thông báo</h1>
	<ul>
		<li><a href="http://hus.vnu.edu.vn/vi/ann/main/5/100/58495" style="font-size: 13px;">Thông tin LATS của NCS Đặng Văn Thái</a></li>
		<li><a href="http://hus.vnu.edu.vn/vi/ann/main/5/100/58492" style="font-size: 13px;">Thông tin LATS của NCS Đỗ Tuấn Long</a></li>
		<li><a href="http://hus.vnu.edu.vn/vi/ann/main/5/100/58506" style="font-size: 13px;">Thông tin LATS của NCS Trần Hồng Trâm</a></li>
		<li><a href="http://hus.vnu.edu.vn/vi/ann/main/5/100/58494" style="font-size: 13px;">Thông tin LATS của NCS Lê Quang Toan</a></li>
	</ul>
</div>
@endif