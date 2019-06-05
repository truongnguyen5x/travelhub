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
<div class="col-md-12">
    <div class="row">
        @extends('top')
        <div class="col-md-8">
            @foreach($plan as $p)
            <div class="row display_plans" style=" margin: 10px 0px 0px -15px;">
                <div class="col-xs-12 col-md-12 " >
                    <div class="row">
                        <div class="col-md-1">
                            <a href=""></a>
                            
                            <img id="image_avatar" src="/{{$p->user->avatar}}" alt="" ></div>
                            <div class="col-md-11" style="padding: 5px;margin-left: -15px; ">
                      {{--           @if($user_id == $p->user->id) --}}
                                <h6><b><a style="color: black;text-decoration: none;" href="/thong-tin-ca-nhan/{{$p->user->id}}">{{$p->user->full_name}}</a></b></h6>
                                {{-- @else
                                <h6><b><a style="color: black;text-decoration: none;" href="/thong-tin-ca-nhan/{{$p->user->id}}">{{$p->user->full_name}}</a></b></h6>
                                @endif --}}
                            </div>
                            <p style="margin: 10px">{{$p->name}}</p>
                            <a href="/plan/detail/{{$p->id}}"> <img src="{{Storage::url($p->cover_image)}}" style="margin: 10px;width: 97%;object-fit: cover; height: 400px" alt=""></a>   
                            <p style="margin-left: 477px">{{$p->comments->count()}} Bình luận- {{$p->follows->count()}} Theo dõi</p>

                        </div>
                        <div class="row text-center click-button">
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
                         <a href="/plan/detail/{{$p->id}}"><button type="button" class="btn btn-outline-secondary"><i class="fas fa-comments"></i> Bình luận</button></a>
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
     <div class="col-md-4">
        @extends('right')
    </div>
</div>
</div>



</div>
@endsection