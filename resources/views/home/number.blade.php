@extends('header')
@section('search')

    <form class=" navbar-left row float-right">

        <div class="form-group col-xs-8" style="padding: 0px;">
            <input type="text" class="form-control" style="width: 400px;margin:0px 5px 0px 100px;" placeholder="Tìm kiếm">
        </div>
        <div class="col-xs-4" >
            <button type="submit" class="btn btn-default" style="padding-bottom: 9px"><i style="margin-top:4px " class="fas fa-search"></i></button>
        </div>
    </form>


@endsection
@section('content')
    <div class="row">
        @extends("top")
        @foreach($user as $u)
        <div class="col-md-8 row display_plans" style=" margin: 10px 0px 0px -15px;">
            <div class="col-xs-12 col-md-12 " >
                <div class="row">
                    <div class="col-md-4"><img id="avatar" src="/{{$u->avatar}}" alt="" ></div>
                    <div class="col-md-8" style="padding: 5px;margin:0px; ">
                        <h3><b><a href="/thong-tin-ca-nhan/{{$u->id}}">{{$u->full_name}}</a></b></h3>
                        <div style="margin: 5px;font-family: Times New Roman">
                            <li style="margin-bottom: 10px">
                                <h5 style="display: inline;margin-right: 40px">Tài khoản</h5>
                                <p style="display: inline">: {{$u->	username}}</p>
                            </li>
                            <li style="margin-bottom: 10px">
                                <h5 style="display: inline;margin-right: 49px">Giới tính</h5>
                                <p style="display: inline">: {{$u->gender}}</p>
                            </li>
                            <li style="margin-bottom: 10px">
                                <h5 style="display: inline;margin-right: 40px">Ngày sinh</h5>
                                <p style="display: inline">: {{Carbon::parse($u->date_of_birth)->format('d-m-Y')}}</p>
                            </li>
                            <li style="margin-bottom: 10px">
                                <h5 style="display: inline;margin-right: 16px">Số điện thoại</h5>
                                <p style="display: inline">: {{$u->phone_number}}</p>
                            </li>
                            <li style="margin-bottom: 10px">
                                <h5 style="display: inline;margin-right: 74px">Email</h5>
                                <p style="display: inline">: {{$u->email}}</p>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-md-4 " >
            @extends("right")
        </div>
    </div>
@endsection