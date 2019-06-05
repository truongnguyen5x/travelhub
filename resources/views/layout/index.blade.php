<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" name="csrf" content="{{ csrf_token() }}">
	<title>Chi tiết kế hoạch</title>

	<link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/add-plan.css">
	<link rel="stylesheet" type="text/css" href="/font-awesome/css/all.css">
	<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css">
	<script src="/js/jquery-3.3.1.min.js"></script>
	
</head>
<body style="background-color: #f6f7f9">
	
	<!-- header -->
	@include('layout.header')

	<!-- content -->
	@yield('content')

	<!-- footer -->
	@include('layout.footer')
	
	<script type="text/javascript" src="/js/jquery.datetimepicker.full.min.js"></script>
	<script type="text/javascript" src="/js/map/main.js"></script>
	<script>
		$("form.form-deleted").on("submit", function(){
			return confirm("Bạn có muốn xoá kế hoạch không?");
		});
	</script>
	
</body>
</html>