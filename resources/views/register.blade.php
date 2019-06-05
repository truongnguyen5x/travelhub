<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        Đăng ký tài khoản
    </title>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/css/add-plan.css" rel="stylesheet" type="text/css">
    <link href="/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css">
    <link href="/css/jquery.Jcrop.css" rel="stylesheet" type="text/css"/>
</link>
</link>
</link>
</meta>
</head>
<body>
    <div class="background-login" id="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <form action="register" class="form-login row" enctype="multipart/form-data" method="POST" style="margin-top: 30px">
                        <div class="col-lg-1">
                        </div>
                        <div class="col-lg-10">
                            @csrf
                            <h1 align="center">
                                <a href="/" title="Trang web cá cược bet247">
                                    Đăng ký thành viên TravelHub
                                </a>
                            </h1>
                            <br>
                            {{-- tên đăng nhập --}}
                            <div class="form-group">
                                <label>
                                    Tên đăng nhập
                                </label>
                                <input autocomplete="off" class="form-control{{$errors->has('username')?' is-invalid':''}}" name="username" type="text" value="{{old('username')}}">
                                @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        {{ $errors->first('username') }}
                                    </strong>
                                </span>
                                @endif

                            </div>
                            {{-- email --}}
                            <div class="form-group">
                                <label>
                                    Địa chỉ email
                                </label>
                                <input autocomplete="off" class="form-control{{$errors->has('email')?' is-invalid':''}}" name="email" type="email" value="{{old('email')}}">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        {{ $errors->first('email') }}
                                    </strong>
                                </span>
                                @endif

                            </div>
                            {{-- họ tên --}}
                            <div class="form-group">
                                <label>
                                    Họ tên
                                </label>
                                <input autocomplete="off" class="form-control{{$errors->has('name')?' is-invalid':''}}" name="name" type="text" value="{{old('name')}}">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        {{ $errors->first('name') }}
                                    </strong>
                                </span>
                                @endif

                            </div>
                            {{-- mật khẩu --}}
                            <div class="form-group">
                                <label>
                                    Mật khẩu
                                </label>
                                <input class="form-control{{$errors->has('password')?' is-invalid':''}}" name="password" type="password">
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        {{ $errors->first('password') }}
                                    </strong>
                                </span>
                                @endif

                            </div>
                            {{-- nhập lại mk --}}
                            <div class="form-group">
                                <label>
                                    Nhập lại mật khẩu
                                </label>
                                <input class="form-control{{$errors->has('password_confirm')?' is-invalid':''}}" name="password_confirm" type="password">
                                @if ($errors->has('password_confirm'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        {{ $errors->first('password_confirm') }}
                                    </strong>
                                </span>
                                @endif

                            </div>
                            {{-- số đt --}}
                            <div class="form-group">
                                <label>
                                    Số điện thoại
                                </label>
                                <input autocomplete="off" class="form-control{{$errors->has('phone_number')?' is-invalid':''}}" name="phone_number" type="text" value="{{old('phone_number')}}">
                                @if ($errors->has('phone_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        {{ $errors->first('phone_number') }}
                                    </strong>
                                </span>
                                @endif

                            </div>
                            <div class="row">
                                {{-- giới tính --}}
                                <div class="form-group col-lg-6">
                                    <label>
                                        Giới tính
                                    </label>
                                    <select class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender">
                                        <option value='nam' {{old('gender')=='nam'?' selected': ' '}}>Nam </option>
                                        <option value='nu' {{old('gender')=='nu'?' selected': ' '}}>Nữ </option>
                                    </select>
                                </div>
                                {{-- ngày sinh --}}
                                <div class="form-group col-lg-6">
                                    <label>
                                        Ngày sinh
                                    </label>
                                    <input autocomplete="off" class="form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" id="date_of_birth" name="date_of_birth" type="text" value="{{old('date_of_birth')}}">
                                    @if ($errors->has('date_of_birth'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            {{ $errors->first('date_of_birth') }}
                                        </strong>
                                    </span>
                                    @endif

                                </div>
                            </div>
                            {{-- ảnh avatar --}}
                            <div class="form-group" style="margin-bottom: 30px">
                                <label style="margin: 0">
                                    Ảnh đại diện
                                </label>
                                <div class="preview-div" style="display: none;">
                                </div>
                                <input accept="image/*" class="form-control{{ $errors->has('anh') ? ' is-invalid' : '' }}" id="avatar" name="avatar" style="margin-top:10px" type="file">
                                @if ($errors->has('avatar'))
                                <span class="invalid-feedback" role="alert" style="display: block">
                                    <strong>
                                        {{ $errors->first('avatar') }}
                                    </strong>
                                </span>
                                @endif
                            </div>
                            {{-- nút bấm --}}
                            <div align="center">
                                <button class="btn btn-success" style="display: inline;" type="submit">
                                    Đăng ký
                                </button>
                                <label>
                                    <a href="login">
                                        Trang đăng nhập
                                    </a>
                                </label>
                            </div>
                            <input id="rectX" name="rectX" type="hidden">
                            <input id="rectY" name="rectY" type="hidden">
                            <input id="size" name="size" type="hidden">        
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/jquery-3.3.1.min.js">
    </script>
    <script src="/js/jquery.Jcrop.min.js">
    </script>
    <script src="/js/jquery.datetimepicker.full.min.js">
    </script>
    <script src="/js/map/crop-image.js" type="text/javascript">
    </script>
    <script src="/js/map/main.js">
    </script>
</body>
</html>