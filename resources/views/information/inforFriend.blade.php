@extends('header')
@section('search')

    <form class=" navbar-left row float-right" xmlns="http://www.w3.org/1999/html">

        <div class="form-group col-xs-8" style="padding: 0px;">
            <input type="text" class="form-control" style="width: 400px;margin:0px 5px 0px 100px;" placeholder="Tìm kiếm">
        </div>
        <div class="col-xs-4" >
            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
        </div>
    </form>


@endsection
@section('content')

    <div class="row display_plans" style=" margin: 10px 0px 0px -15px;">
        <div class="col-md-4 text-center"><img id="image_avatar" style="width: 60% !important;" src="/{{$user->avatar}}" alt="" ></div>
        <div class="col-md-8" style="padding: 5px;margin:0px ">
            <h3><b>{{$user->full_name}}</b></h3>
            <div class="row"style="margin-top: 30px;">
                <div style="margin: 5px;font-family: Times New Roman;margin-right: 30px">
                    <li style="margin-bottom: 10px">
                        <h5 style="display: inline;margin-right: 40px">Tài khoản</h5>
                        <p style="display: inline">: {{$user->username}}</p>
                    </li>
                    <li style="margin-bottom: 10px">
                        <h5 style="display: inline;margin-right: 49px">Giới tính</h5>
                        @if($user->gender==0)
                            <p style="display: inline">:Nam</p>
                        @else
                            <p style="display: inline">:Nữ</p>
                        @endif
                    </li>
                    <li style="margin-bottom: 10px">
                        <h5 style="display: inline;margin-right: 40px">Ngày sinh</h5>
                        <p style="display: inline">: {{Carbon::parse($user->date_of_birth)->format('d-m-Y')}}</p>
                    </li>
                </div>
                <div style="margin: 5px;font-family: Times New Roman ;">
                    <li style="margin-bottom: 10px">
                        <h5 style="display: inline;margin-right: 16px">Số điện thoại</h5>
                        <p style="display: inline">: 0{{$user->phone_number}}</p>
                    </li>
                    <li style="margin-bottom: 10px">
                        <h5 style="display: inline;margin-right: 74px">Email</h5>
                        <p style="display: inline">: {{$user->email}}</p>
                    </li>
                </div>
            </div>
        </div>
        <div class="space"></div>
        <div class="col-md-12 text-center " style="margin-top: 30px;" >
            <div class="row btn-group" style="width: 61% ">
                <button style="width: 33%" type="button" class="btn btn-default"><a class="nav-link" href="/thong-tin-ca-nhan/{{$user->id}}">Kế hoạch của tôi</a></button>
                <button style="width: 33%" type="button" class="btn btn-default"><a class="nav-link" href="/trang-ca-nhan/ke-hoach-tham-gia/{{$user->id}}">Kế hoạch tham gia</a></button>
                <button style="width: 33%" type="button" class="btn btn-default"><a class="nav-link" href="/trang-ca-nhan/ke-hoach-theo-doi/{{$user->id}}">Kế hoạch theo dõi</a></button>
            </div>
        </div>
        @foreach($plan as $p )
            <div class="row justify-content-center">
                <div class="col-md-8 col-of" style="border:1px solid #b4b0b0;border-radius: 6px;;margin: 10px 0px 0px 0px">
                    <div class="row" style="margin-top: 10px" >
                        <div class="col-md-1"><img id="image_avatar" src="/{{$user->avatar}}" alt="" ></div>
                        <div class="col-md-11" style="padding: 5px;margin-left: -10px; ">
                            <h6><b>{{$user->full_name}}</b></h6>
                        </div>
                        <p style="margin: 10px">{{$p->name}}</p>
                      <a href="/plan/detail/{{$p->id}}"> <img src="{{Storage::url($p->cover_image)}}" style="margin: 10px;width: 97%;object-fit: cover; height: 400px" alt=""></a>   
                            <p style="margin-left: 477px">{{$p->comments->count()}} Bình luận- {{$p->follows->count()}} Theo dõi</p>
                    </div>
                    <div class="row text-center click-button" style="margin-bottom: 15px">
                        <div class="col-md-4 ">
                            @php
                                $temp=false;
                                foreach ($p->follows as $pf)
                           if ($pf->user_id==$user_id)$temp=true;
                            @endphp
                            @if($temp)
                                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-bookmark"></i> Đã theo dõi</button>
                            @else
                                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-bookmark"></i> Theo dõi</button>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <a style="  " href="/plan/detail/{{$p->id}}"><button type="button" class="btn btn-outline-secondary"><i class="fas fa-comments"></i> Bình luận</button></a>
                        </div>
                        <div class="col-md-4">
                            @php
                                $temp=false;
                                foreach ($p->participants as $pp)
                           if ($pp->user_id==$user_id)$temp=true;
                            @endphp
                            @if($temp)
                                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-check"></i> Đã tham gia</button>
                            @else
                                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-check"></i> Tham gia</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection