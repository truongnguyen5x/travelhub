<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/add-plan.css">
</head>
<body>
    <div id="wrapper" class="background-login" >
        <div class="container-fluid ">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <form class="form-login" method="POST" action="login" >
                        @csrf
                        <h1 align="center">
                            <a href="/" style="color: inherit;" title="Đến trang chủ">Chào mừng đến với TravelHub</a>
                            <p></p>
                            <p style="font-size: 20px ;margin:  0px">Trang du lịch bụi hàng đầu</p>                        
                        </h1>
                        @if(session('notify'))
                        <div class="alert alert-danger">
                            <strong>{{session('notify')}}</strong>
                        </div>
                        @endif
                        <br>
                        {{-- tên đăng nhập --}}
                        <div class="form-group">
                            <label>Tên đăng nhập hoặc email</label>
                            <input class="form-control" type="text" name="username" value="{{old('username')}}" autofocus>
                        </div>
                        {{-- mật khẩu --}}
                        <div class="form-group">
                            <label> Mật khẩu</label>
                            <input class="form-control" type="password" name="password">
                        </div>
                        {{-- nút bấm --}}
                        <ul class="two-button-center" >
                            <li style="display: inline;">
                                <button class="btn btn-success" type="submit">Đăng nhập</button>
                            </li>
                            <li style="display: inline;">
                                <a href="register">
                                    <button class="btn btn-success" type="button">Đăng ký</button>
                                </a>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>