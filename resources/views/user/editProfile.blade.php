@extends('layout.index')

@section('content')

<script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<div id="wrapper" style="margin-top:58px;" class="container" name="">
    {{-- chỉnh sửa profile --}}
    <form class="form-login" method="POST" action="/profile/edit" style="margin-top: 30px" enctype="multipart/form-data">
        @if(session('success'))
        <div class="alert alert-success">
            <strong>{{session('success')}}</strong>
        </div>
        @endif
        <h1 align="center">Chỉnh sửa thông tin cá nhân
        </h1>
        <div class="row">
            <div class="col-lg-4">
                {{-- ảnh avatar --}}
                <div class="form-group avatar" style="text-align: center;">
                    <img id="avatar" src="/{{Auth::user()->avatar}}" style='width:256px;height:256px;object-fit:cover;border-radius:128px'>
                </div>
                <div class="form-group" style="margin-bottom: 30px">
                    <label>Ảnh đại diện</label>
                    <input type="file" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}"  name="image"  id="image" accept="image/*" >
                    @if ($errors->has('image'))
                    <span class="invalid-feedback" role="alert" style="display: block">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-lg-8">
                @csrf
                <br>
                {{-- họ tên --}}
                <div class="form-group">
                    <label>Họ tên</label>
                    <input class="form-control{{$errors->has('name')?' is-invalid':''}}" name="name" type="text" value="{{Auth::user()->full_name}}">
                    @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                {{-- email --}}
                <div class="form-group">
                    <label>Địa chỉ email</label>
                    <input class="form-control{{$errors->has('email')?' is-invalid':''}}" name="email" type="email" value="{{Auth::user()->email}}">
                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                {{-- số đt --}}
                <div class="form-group">
                    <label >Số điện thoại </label>
                    <input class="form-control{{$errors->has('phone_number')?' is-invalid':''}}" name="phone_number" type="text" value="{{Auth::user()->phone_number}}">
                    @if ($errors->has('phone_number'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('phone_number') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="row">
                    {{-- giới tính --}}
                    <div class="form-group col-lg-6">
                        <label>Giới tính</label>
                        <select class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender">
                            <option value="nam" {{'nam'==Auth::user()->gender?' selected ':''}}>Nam</option>
                            <option value="nu" {{'nu'==Auth::user()->gender?' selected ':''}}>Nữ</option>
                        </select>
                    </div>
                    {{--  ngày sinh --}}
                    <div class="form-group col-lg-6">
                        <label>Ngày sinh</label>
                        <input class="form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" type="date" name="date_of_birth"  value="{{Auth::user()->date_of_birth}}">
                        @if ($errors->has('date_of_birth'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('date_of_birth') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- nút bấm --}}
        <div align="center">
            <button class="btn btn-success" type="submit" style="display: inline;">Lưu thay đổi
            </button>
        </div>
    </form>
</div>

<script type="text/javascript">       
    $('#image').change(function(event){  
        $('#avatar').attr('src', 'http://placehold.it/256x256');      
        var src = URL.createObjectURL(event.target.files[0]);                
        $('#avatar').attr('src', src);
    });
</script>


@endsection