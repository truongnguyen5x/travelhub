/*comment*/
$(document).ready(function(){
    $("button#checkin").click(function(){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position){ 
                $("#lat").text(position.coords.latitude);
                $("#lng").text(position.coords.longitude);
                var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                var geocoder = geocoder = new google.maps.Geocoder();

                geocoder.geocode({ 'latLng': latlng }, function (results, status) {

                    if (status == google.maps.GeocoderStatus.OK) 
                    {
                        if (results[0]) 
                        {
                            $('#address').text(' in ' + results[0].formatted_address);
                        }
                    }
                });
            });
        } else {
            $('#address').text('');
            alert('looi');
        }
    });

    $("button#comment").click(function(){

        var token = $('button#comment').attr('name');
        var planId = $('div#wrapper').attr('name');
        var content = $('textarea#comment').val();
        var userId = $('div#form_comment').attr('name');
        var lat = $('#lat').text();
        var lng = $('#lng').text();
        var address = $('#address').text();
        var formData = new FormData($("#uploadImage")[0]);
        formData.append('_token', token);
        formData.append('planId', planId);
        formData.append('content', content);
        formData.append('userId', userId);
        formData.append('lat', lat);
        formData.append('lng', lng);
        formData.append('address', address);
        $.ajax({
            type: "POST",
            url: "/comment",
            data: formData,
            processData: false,
            contentType: false,
            success:function(data)
            {
                if(data.owner)
                {
                    var deleteComment = "<a style='color: #1362F3' onclick='deleteComment(" 
                    + data.commentId
                    + ")'><small>  Delete</small></a>";
                }
                else var deleteComment = "";

                if(data.marker == null)
                {
                    var myLocation = "";
                }
                else
                {
                    var myLocation = data.marker.label;
                }

                $('div#preview').empty();
                $('hr#after').after(
                    "<div class='media mt-3' id='" 
                    + data.commentId 
                    + "Comment'><a class='media-object' href='/thong-tin-ca-nhan/" 
                    + userId
                    + "'><img src='/" 
                    + data.avatar
                    + "' style='width:64px;height:64px;object-fit:cover;border-radius: 32px'></a><div class='media-body' style='margin-left: 20px'><h5 class='mt-0'><a href='/thong-tin-ca-nhan/" 
                    + userId 
                    + "'>" 
                    + data.userName 
                    + "  </a><small>" 
                    + myLocation
                    + " at " 
                    + data.dateCreated 
                    + "</small></h5><p>" 
                    + data.content 
                    + "</p><div id='listImage" 
                    + data.commentId 
                    + "'></div><a style='color: #1362F3' onclick='reply(" 
                    + data.commentId 
                    + ")'><small>Reply  </small></a>" 
                    + deleteComment
                    + "<div class='well1' style='display: none;' id='replyForm_" 
                    + data.commentId 
                    + "' name='form'><div class='media mt-3'><div class='media-body'><h6>Viết bình luận ...<span class='glyphicon glyphicon-pencil'></span></h6><div class='form-group'><textarea class='form-control' rows='1' id='text" 
                    + data.commentId 
                    + "'></textarea><button type='button' class='btn btn-default'><i class='fa fa-map-marker'></i></button><small id='address" 
                    + data.commentId 
                    + "'></small><small id='lat" 
                    + data.commentId 
                    + "' style='display: none;'></small><small id='lng" 
                    + data.commentId 
                    + "' style='display: none;'></small></div><div id='preview" 
                    + data.commentId 
                    + "'></div><form id='uploadImage" 
                    + data.commentId 
                    + "' enctype='multipart/form-data'><input type='file' id='image" 
                    + data.commentId 
                    + "' name='image[]' multiple onclick='chooseImage(" 
                    + data.commentId
                    + ")'></form><button id='reply' class='btn btn-primary' onclick='replyComment(" 
                    + data.commentId 
                    + ")'>Gửi</button></div></div></div><hr>"
                    );
                for(var i=0; i<data.path.length; i++)
                    $('div#listImage' + data.commentId).append(
                        "<img id='img" 
                        + i 
                        + "' src='"
                        + data.path[i]
                        + "' style='width:150px;height:150px;' onclick='myclick()'>"
                        );
            },  
            error: function (error)
            {
                alert('loi');
            }       
        });
    });
});

