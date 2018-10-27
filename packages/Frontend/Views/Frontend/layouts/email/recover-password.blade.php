<html>
	<head>
	    <title>Email user</title>
	    <meta name="description" content="" />
	    <meta name="keywords" content="" />
	</head>
	<body>
	   Chào bạn.<br />
	   Chúng tôi nhận được yêu cầu khôi phục mật khẩu của bạn. <br />
	   Vui lòng nhấn vào link <a href="{{ url('') }}/{{ HelperCommon::getPrefixLang() }}/recover/{{ $token }}" target="_blank" >đổi mật khẩu</a> nếu bạn vẫn còn muốn tiếp tục.<br />
	   Cám ơn.
	</body>
</html>