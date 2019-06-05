<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" name="csrf-token" content="{{ csrf_token() }}">
	<title>Thêm kế hoạch</title>
	<link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/add-plan.css">
	<link rel="stylesheet" type="text/css" href="/font-awesome/css/all.css">
	<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css">
	<script src="/js/jquery-3.3.1.min.js"></script>
	<script>
		var isAddPlan=true;
		var isEditPlan=false;
		var isDetailPlan=false;
		var thisPostUrl='/plan/add';
	</script>
</head>
<body style="background-color: #f6f7f9;">
	<div class="navbar-top">
		{{-- <a href="/" style="font-size: 25px;color: white">  Trang chủ</a> --}}
		@include('layout.header');
		{{-- @include('navbar') --}}
	</div>
	<div class="container" id="wrapper" style="margin-top:49px;" >
		<div class="box-shadow">
			<div style="margin: 18px 20px 25px; color:#260C96" ><h2>Thêm kế hoạch</h2></div>
			<div class="dropdown-divider"></div>
			<div class="col-lg-12"><h4>Thông tin cơ bản</h4></div>
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					<div class="form-row">
						<label class="col-sm-2 col-form-label">Tên kế hoạch</label>
						<div class="col-sm-10">
							<input type="text"  class="form-control" id="plan-name" autocomplete="off">
							<span class="invalid-feedback" role="alert" style="display: block">
								<strong id="plan-name-error" class="error-strong"></strong>
							</span>
						</div>
					</div>
					{{-- thời gian --}}
					<div class="row">
						<div class="col-lg-6 form-group">
							<p>Thời gian bắt đầu</p>
							<input type="text" class="form-control" name="" id="start-time-input">
							<span class="invalid-feedback" role="alert" style="display: block">
								<strong id="start-time-error" class="error-strong"></strong>
							</span>							
						</div>
						<div class="col-lg-6 form-group">
							<p>Thời gian kết thúc</p>
							<input type="text" class="form-control" name="" id='end-time-input'>
							<span class="invalid-feedback" role="alert" style="display: block">
								<strong id="end-time-error" class="error-strong"></strong>
							</span>
						</div>
					</div>					
					{{-- ảnh avatar --}}
					<div class="form-group image_thumb" style="text-align: center"></div>
					<div class="form-group">
						<label>Ảnh đại diện</label>
						<input type="file" class="form-control"  name="cover"  id="cover" accept="image/*" >			
						<span class="invalid-feedback" role="alert" style="display: block">
							<strong id="avatar-error" class="error-strong"></strong>
						</span>						
					</div>
				</div>
			</div>
		</div>
		<div class="box-shadow">
			<div class="col-lg-12"><h4>Các cung đường:</h4> </div>
			<div class="row" style="margin: 8px">
				<div class="col-lg-3" style="padding: 0 10px 0 0;">
					<div id="pac-container" >
						<input id="pac-input" type="text" placeholder="Tìm địa điểm" class="form-control">
					</div>
					<div>
						<p id="info"></p>
					</div>
				</div>
				<div class="col-lg-9" id="map"></div>
			</div>
		</div>
		<div class="box-shadow" style="padding: 5px 13px 5px">
			<div class="col-lg-12"><h4>Bảng các cung đường</h4></div>
			<table class="table table-bordered table-striped table-hover" >
				<thead class="thead-dark">
					<tr align="center" >
						<th style="vertical-align: middle;">No.</th>
						<th style="vertical-align: middle;">Xuất phát</th>
						<th style="vertical-align: middle;">Thời gian</th>
						<th style="vertical-align: middle;">Đến</th>
						<th style="vertical-align: middle;">Thời gian</th>
						<th style="vertical-align: middle;">Phương tiện</th>
						<th style="vertical-align: middle;">Hoạt động</th>
						<th style="vertical-align: middle;">Thao tác</th>
					</tr>
				</thead>
				<tbody id='table-body'>
				</tbody>
			</table>
			{{-- nút bấm --}}
			<ul class="two-button-center" >
				<li style="display: inline;">
					<button class="btn btn-success" type="button" id='btn-submit'>Thêm kế hoạch</button>
				</li>
				<li style="display: inline;">
					<button class="btn btn-secondary" type="button" id='btn-clear-all'>Xoá tất cả</button>
				</li>
				<li style="display: inline;">
					<a href="/thong-tin-ca-nhan/{{Auth::user()->id}}"><button class="btn btn-primary" type="button" >Trở về</button></a>
				</li>
			</ul>
			<form action="plan/add" method="POST" enctype="multipart/form-data"></form>
		</div>
	</div>
	<div class="popup" id='popup1'>
		<div class="popup-content">
			<i class="fas fa-times-circle" id="exit-popup"></i>
			<div style="margin: 25px">
				<h3 class="h3-popup"></h3>
				<div class="error"></div>
				<div class="form-row">
					<div class="form-group col-md-6" style="margin-top: 20px" class="start-time-div">
						<label>Thời gian bắt đầu</label>
						<input type="text" class="form-control"  name="time" id='start-time-value'>
					</div>
					<div class="form-group col-md-6" style="margin-top: 20px" class="end-time-div">
						<label>Thời gian kết thúc</label>
						<input type="text" class="form-control"  name="time2" id='end-time-value'>
					</div>
				</div>
				<div class="form-group" style="margin-top: 20px" class='action-div'>
					<label>Các hoạt động sẽ diễn ra</label>
					<textarea class="form-control" name="action" id="action-value"></textarea>
				</div>
				<div align="center">
					<button class="btn btn-primary" style="display: inline;" id="btn-popup" type='button'>Thêm hoạt động</button>
				</div>
			</div>
		</div>
	</div>
	<div class="popup" id='popup2'>
		<div class="popup-content">
			<i class="fas fa-times-circle" id="exit-popup"></i>
			<div style="margin: 25px">
				<h3 class="h3-popup"></h3>
				<div class="error"></div>
				<div class="form-row">
					<div class="form-group col-md-6" style="margin-top: 20px" class="start-time-div">
						<label>Thời gian bắt đầu</label>
						<input type="text" class="form-control"  name="time" id='start-time-value'>
					</div>
					<div class="form-group col-md-6" style="margin-top: 20px" class="end-time-div">
						<label>Thời gian kết thúc</label>
						<input type="text" class="form-control"  name="time2" id='end-time-value'>
					</div>
				</div>
				
				<div class="form-group" style="margin-top: 20px" class='vehicle-div'>
					<label>Phương tiện di chuyển</label>
					<div class="container">
						<div class="form-check">
							<label class="form-check-label">
								<input type="radio" class="form-check-input" name="optradio" id='radio-driving'>Ô tô
							</label>
						</div>
						<div class="form-check">
							<label class="form-check-label">
								<input type="radio" class="form-check-input" name="optradio" id="radio-walking">Đi bộ
							</label>
						</div>
						<div class="form-check ">
							<label class="form-check-label">
								<input type="radio" class="form-check-input" name="optradio" id="radio-transit">Phương tiện công cộng
							</label>
						</div>
						<div class="form-check" >
							<input type="radio" class="form-check-input" name="optradio" id="other-vehicle">
							<div>
								<label class="form-check-label">Phương tiện khác</label>
								<input type="text" class="form-control" name="" id="other-value">
							</div>
						</div>
					</div>
				</div>
				<div align="center">
					<button class="btn btn-primary" style="display: inline;" id="btn-popup" type='button'>Lưu thay đổi</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="/js/jquery.datetimepicker.full.min.js"></script>
	<script type="text/javascript" src="/js/map/main.js"></script>
	@include('plan.api-key')
	{{-- map javascript files --}}
	<script type="text/javascript" src="/js/map/plan-manager.js"></script>
	<script type="text/javascript" src="/js/map/context-menu.js"></script>
	<script type="text/javascript" src="/js/map/make-context-menu.js"></script>
	<script type="text/javascript" src="/js/map/direction.js"></script>
	<script type="text/javascript" src="/js/map/display-info.js"></script>
	<script type="text/javascript" src="/js/map/add-event.js"></script>
	<script type="text/javascript" src="/js/map/popup.js"></script>
	<script type="text/javascript" src="/js/map/init-map.js"></script>
	<script type="text/javascript" src="/js/map/table-render.js"></script>
	<script type="text/javascript" src="/js/map/ajax.js"></script>
</body>
</html>