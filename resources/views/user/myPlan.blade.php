@extends('layout.index')

@section('content')

<script type="text/javascript" src="/js/comment/reply.js"></script>
<script type="text/javascript" src="/js/comment/comment.js"></script>
<script type="text/javascript" src="/js/comment/previewImage.js"></script>
<script type="text/javascript" src="/js/comment/deleteComment.js"></script>
<script type="text/javascript" src="/js/request/join.js"></script>
<script type="text/javascript" src="/js/request/follow.js"></script>
<script type="text/javascript" src="/js/request/table.js"></script>
<script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.1/socket.io.js"></script>
<script type="text/javascript" src="/js/comment/socket.js"></script>
 <script>
        var isAddPlan=false;
        var isEditPlan=false;
        var isDetailPlan=true;
        var plan= {!!json_encode($plan)!!};
        var roads={!!json_encode($plan->markers)!!}
</script>
<div id="wrapper" style="margin-top:58px;" class="container" name="{{$plan->id}}">
    <div style="margin: 20px" >
        <h2>
            Chi tiết kế hoạch: {{$plan->name}}
        </h2>
    </div>
    <div class="form-group image_thumb" style="text-align: center">
        <img src="{{Storage::url($plan->cover_image)}}" style="width:100%;height:256px;object-fit:cover;border-radius:7px;margin-top:18px">
    </div>
    {{-- thong tin --}}
    <div class="box-shadow">
        <div class="col-lg-12" align="center"><h2>Thông tin cơ bản</h2></div>
        <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8">
                <div>
                    <label>
                        Tên kế hoạch: {{$plan->name}}
                    </label>
                </div>
                <div>
                    <label>
                        Người tạo kế hoạch: 
                        <a href="/thong-tin-ca-nhan/{{$plan->user->id}}">
                            {{$plan->user->full_name}}
                        </a>
                    </label>
                </div>
                <div>
                    <label>
                        Trạng thái: {{$plan->state}}
                    </label>
                </div>
                <div>
                    <label id="amountJoin">
                        Số người tham gia: {{$plan->participants->count()}} người
                    </label>
                </div>
                <div>
                    <label id="amountFollow">
                        Số người theo dõi: {{$plan->follows->count()}} người
                    </label>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <p>Thời gian bắt đầu:</p>
                        <input type="text" class="form-control" name="" value="{{Carbon::parse($startTime)->format('H:i d/m/Y')}}" readonly="true" id="start-time-input" disabled>
                    </div>
                    <div class="col-lg-6 form-group">
                        <p>Thời gian kết thúc</p>
                        <input type="text" class="form-control" name="" value="{{Carbon::parse($endTime)->format('H:i d/m/Y')}}" readonly="true" id="end-time-input" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 form-group">
                        @if($plan->state == "Lên kế hoạch")
                        <button id="listJoins" class="btn btn-primary" type="button">Danh sách tham gia</button>
                        @else
                        <button id="list" class="btn btn-primary" type="button">Danh sách tham gia</button>
                        @endif
                    </div>
                    @if($plan->state == "Lên kế hoạch")
                    <div class="col-lg-4 form-group">
                        <a href="/plan/edit/{{$plan->id}}">
                            <button class="btn btn-primary" type="button">Chỉnh sửa kế hoạch</button>
                        </a>
                    </div>
                    <div class="col-lg-4 form-group">
                        {{-- <a href="/plan/delete/{{$plan->id}}">
                            <button class="btn btn-primary" type="button">Hủy kế hoạch</button>
                        </a> --}}
                        <form action="/plan/delete/{{$plan->id}}" method="POST"
                      id="del-form{{$plan->id}}" style="display: inline;"
                         class='form-deleted'> @csrf
                            <button type="submit" class="btn btn-primary">Hủy kế hoạch</button>
                        </form>

                    </div>
                    @endif  
                </div>
            </div>
        </div>
    </div>
    {{-- table list user --}}
    <div id="listRequests" class="box-shadow" style="padding: 5px 13px 5px" hidden="true">
        <div class="col-lg-12"><h3>Bảng các cung đường</h3></div>
        <table class="table table-bordered table-striped table-hover" >
            <thead>
                <tr align="center">
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>                       
            </thead>
            <tbody id="tbody">
                
            </tbody>
        </table>
    </div>
    {{-- map --}}
    <div class="box-shadow">
        <div class="col-lg-12"><h3>Các cung đường</h3> </div>
        <div class="row" style="margin: 8px">
            <div class="col-lg-3" style="padding: 0 10px 0 0;">
                <div>
                    <p id="info"></p>
                </div>
            </div>
            <div class="col-lg-9" id="map" style="height: 590px;border-radius: 6px;border: 1px solid #AEA4A4"></div>
        </div>
    </div>
    {{-- table --}}
    <div class="box-shadow" style="padding: 5px 13px 5px">
        <div class="col-lg-12"><h3>Bảng các cung đường</h3></div>
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
                    </tr>
            </thead>
            <tbody id='table-body'>               
            </tbody>
        </table>
    </div>
    {{-- comment --}}
    <div class="box-shadow">
        <div class="col-lg-12">
            <h3>
                Bình luận
            </h3>
        </div>
        <!-- Comments Form -->
        <div class="well col-lg-12" id="form_comment" name="@if(Auth::check()){{Auth::user()->id}}@endif">
            <div class="form-group">
                <textarea class="form-control" id="comment"></textarea>
                <button id="checkin" type="button" class="btn btn-default">
                    <i class="fa fa-map-marker"></i>
                </button>
                <small id="address"></small>
                <small id="lat" style="display: none;"></small>
                <small id="lng" style="display: none;"></small>
            </div>
            <div id="preview"></div>
            <form id="uploadImage" enctype="multipart/form-data">
                <input type="file" id="image" name="image[]" multiple onclick="chooseImage('')">
            </form>
            <button id="comment" class="btn btn-primary" style="min-width: 100px;" name="{{ csrf_token() }}">Gửi</button>
        </div>

        <hr id="after">

        <!-- Posted Comments -->

        @foreach($comments as $key => $comment)
        <div class="media mt-3" id="{{$comment->id}}Comment">
            <a class="media-object" href="/thong-tin-ca-nhan/{{$comment->user->id}}">
                <img src="/{{$comment->user->avatar}}" style="width:64px;height:64px;object-fit:cover;border-radius: 32px">
            </a>
            <div class="media-body" style="margin-left: 20px">
                <h5 class="mt-0">
                    <a href="/thong-tin-ca-nhan/{{$comment->user->id}}">
                        {{$comment->user->full_name}}
                    </a>  
                    <small>
                        @if($comment->marker != null) {{$comment->marker->label}} @endif
                        at {{date_format(date_create($comment->date_created), 'M d, Y h:i A')}}
                    </small>
                </h5>
                <p>
                    {{$comment->content}}
                </p>
                <div>
                    @foreach($comment->images as $key => $image)
                    <a id="image{{$image->id}}" class="fancybox-thumb" rel="fancybox-thumb">
                        <img src="{{$image->path}}" style="width: 150px; height: 120px" alt="" />
                    </a>
                    @endforeach
                </div>
                <a id="reply" style="color: #1362F3" onclick="reply({{$comment->id}})">
                    <small>
                        Reply 
                    </small>
                </a>
                <a style="color: #1362F3" onclick="deleteComment({{$comment->id}})">
                    <small>
                         Delete
                    </small>
                </a>
                {{-- form reply --}}
                <div class="well1" style="display: none;" id = "replyForm_{{$comment->id}}" name="form">
                    <div class="media mt-3">
                        <div class="media-body">
                            <h6>
                                Viết bình luận <span class="glyphicon glyphicon-pencil"></span>
                            </h6>
                            <div class="form-group">
                                <textarea class="form-control" rows="1" id="text{{$comment->id}}"></textarea>
                                <button type="button" class="btn btn-default">
                                    <i class="fa fa-map-marker"></i>
                                </button>
                                <small id="address{{$comment->id}}"></small>
                                <small id="lat{{$comment->id}}" style="display: none;"></small>
                                <small id="lng{{$comment->id}}" style="display: none;"></small>
                            </div>
                            <div id="preview{{$comment->id}}"></div>
                            <form id="uploadImage{{$comment->id}}" enctype="multipart/form-data">
                                <input type="file" id="image{{$comment->id}}" name="image[]" multiple onclick="chooseImage({{$comment->id}})">
                            </form>
                            <button id="reply" class="btn btn-primary" onclick="replyComment({{$comment->id}})">Gửi
                            </button>
                        </div>                        
                    </div>
                </div>
                {{-- reply comment --}}
                @foreach($comment->replycomments as $replyComment)
                <div class="media mt-3" id="{{$replyComment->id}}Comment">
                    <a class="media-object" href="/thong-tin-ca-nhan/{{$replyComment->user->id}}">
                        <img src="/{{$replyComment->user->avatar}}" style="width:64px;height:64px;object-fit:cover;border-radius: 32px">
                    </a>
                    <div class="media-body" style="margin-left: 20px">
                        <h5 class="mt-0">
                            <a href="/thong-tin-ca-nhan/{{$replyComment->user->id}}">
                                {{$replyComment->user->full_name}}
                            </a>  
                            <small>
                                @if($replyComment->marker != null) {{$replyComment->marker->label}} @endif
                                at {{date_format(date_create($replyComment->date_created), 'M d, Y h:i A')}}
                            </small>
                        </h5>
                        <p>
                            {{$replyComment->content}}
                        </p>
                        <div>
                            @foreach($replyComment->images as $key => $image)
                            <a id="image{{$image->id}}" class="fancybox-thumb" rel="fancybox-thumb">
                                <img src="{{$image->path}}" style="width: 150px; height: 120px" alt="" />
                            </a>
                            @endforeach
                        </div>
                        <a style="color: #1362F3" onclick="deleteComment({{$replyComment->id}})">
                            <small>
                                Delete
                            </small>
                        </a>
                    </div>
                </div>
                @endforeach
                <hr>
            </div>  
        </div>
        @endforeach
    </div>
</div>

<script>
    var isAddPlan=false;
    var isEditPlan=false;
    var isDetailPlan=true;
    var plan= {!!json_encode($plan)!!};
    var roads={!!json_encode($plan->markers)!!}  
    $(document).ready(function(){
        $("input#start-time-input").datetimepicker({
            value: dateParse(plan.start_time)
        });
        $("input#end-time-input").datetimepicker({
            value: dateParse(plan.end_time)
        });
    });
</script>
@include('plan.api-key')
{{-- map javascript files --}}
<script type="text/javascript" src="/js/map/context-menu.js"></script>
<script type="text/javascript" src="/js/map/plan-manager.js"></script>
<script type="text/javascript" src="/js/map/direction.js"></script>
<script type="text/javascript" src="/js/map/display-info.js"></script>
<script type="text/javascript" src="/js/map/init-map.js"></script>
<script type="text/javascript" src="/js/map/reload-map.js"></script>
<script type="text/javascript" src="/js/map/add-event.js"></script>
<script type="text/javascript" src="/js/map/table-render.js"></script>

@endsection