@extends('header')
@section('search')
<form class=" navbar-left row float-right">
    <div class="form-group col-xs-8" style="padding: 0px;">
        <input class="form-control" placeholder="Tìm kiếm" style="width: 400px;margin:0px 5px 0px 100px;" type="text">
        </input>
    </div>
    <div class="col-xs-4">
        <button class="btn btn-default" style="padding-bottom: 9px" type="submit">
            <i class="fas fa-search" style="margin-top:4px ">
            </i>
        </button>
    </div>
</form>
@endsection
@section('content')
<div class="col-md-12">
    <div class="row">
        @extends('top')
        <div class="col-md-8">
            @foreach($plan as $p)
            <div class="row display_plans" style=" margin: 10px 0px 0px -15px;">
                <div class="col-xs-12 col-md-12 ">
                    <div class="row">
                        <div class="col-md-1">
                            <img alt="" id="image_avatar" src="{{$p->user->avatar}}"/>
                        </div>
                        <div class="col-md-11" style="padding: 5px;margin-left: -15px; ">
                            {{--  @if($user_id == $p->user->id)
                            <h6>
                                <b>
                                    <a href="thong-tin-ca-nhan/{{$p->user->id}}" style="color: black;text-decoration: none;">
                                        {{$p->user->full_name}}
                                    </a>
                                </b>
                            </h6>
                            --}}
                                  {{--   @else --}}
                            <h6>
                                <b>
                                    <a href="thong-tin-ca-nhan/{{$p->user->id}}" style="color: black;text-decoration: none;">
                                        {{$p->user->full_name}}
                                    </a>
                                </b>
                            </h6>
                            {{--  @endif --}}
                        </div>
                        <p style="margin: 10px">
                            {{$p->name}}
                        </p>
                        <a href="/plan/detail/{{$p->id}}">
                            <img alt="" src="{{Storage::url($p->cover_image)}}" style="margin: 10px;width: 97%;object-fit: cover; height: 400px"/>
                        </a>
                        <p style="margin-left: 477px">
                            {{$p->comments->count()}} Bình luận- {{$p->follows->count()}} Theo dõi
                        </p>
                    </div>
                    <div class="row text-center click-button">
                        <div class="col-md-4 ">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-bookmark">
                                </i>
                                Theo dõi
                            </button>
                        </div>
                        <div class="col-md-4">
                            <a href="/plan/detail/{{$p->id}}">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-comments">
                                    </i>
                                    Bình luận
                                </button>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-check">
                                </i>
                                Tham gia
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-4">
            @extends('right')
        </div>
    </div>
</div>
@endsection
