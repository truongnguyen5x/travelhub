
<div class="row"style="position: fixed;top: 70px;right: 245px;width: 342px;">
    <div class="col-md-3" style="padding: 5px;" >
        <img id="avatar" src="/{{Auth::user()->avatar}}" alt="" >
    </div>
    @if(Auth::check())
    <div class="col-md-9" style="padding: 3px;margin-top: 10px;">
        <h5><b><a style="color: black;text-decoration: none;" href="/thong-tin-ca-nhan/{{Auth::user()->id}}">{{Auth::user()->full_name}}</a></b></h5>
        <p>{{Auth::user()->email}}</p>
    </div>
    @endif
    <div class="col-md-12 space"></div>
    {{--<div class="col-md-12">--}}
        {{--<div class="row" style="height:170px;width:300px;border:1px solid black;overflow:auto;">--}}
            {{--@foreach($user as $u)--}}
            {{--<div class="col-md-3" style="padding: 5px;" >--}}
                {{--<img src="/{{$u->avatar}}" alt="" >--}}
            {{--</div>--}}
            {{--<div class="col-md-9" style="padding: 3px;margin-top: 10px;">--}}
                {{--<h6><b><a style="color: black;text-decoration: none;" href="/thong-tin-ca-nhan/{{$u->id}}">{{$u->full_name}}</a></b></h6>--}}
            {{--</div>--}}
            {{--@endforeach--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="col-md-12" id="map" style="margin: 10px;padding: 0px">
        {{--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.2987359001168!2d105.77735921436833!3d21.020729593429547!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454ac8f59f9cb%3A0x461eaf9b92a8dbc1!2sT%C3%B2a+nh%C3%A0+Keangnam+Landmark+Tower!5e0!3m2!1svi!2s!4v1531039753958"--}}
        {{--style="width: 100%; height:200px ;border:1px solid #b4b0b0" frameborder="0" allowfullscreen>--}}
    {{--</iframe>--}}
    <div id="panel" style="min-height: 270px"></div>

</div>
<p style="font-size: 13px;margin-left:10px;padding: 0px;display: inline; color: #6c757d">
    <i>Giới thiệu về chúng tôi*Hỗ trợ * Báo chí * APV * Việc làm *  Quyền riêng tư * Điều khoản * thư mục* Trang cá nhân</i>
</p>
</div>

@include('plan.api-key')

    <script>

    function initMap() {

        var map=new google.maps.Map(document.getElementById('panel'),{
            zoom: 17,
            draggable:true,
            streetViewControl: false,
            gestureHandling: 'greedy',
            clickable:true
        });
        var marker=new google.maps.Marker({
            map:map
        });
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                marker.setPosition({lat:position.coords.latitude ,lng: position.coords.longitude});
                map.setCenter(marker.getPosition());
            });
        } else {

        }


    }
    google.maps.event.addDomListener(window, 'load', initMap);


</script>



