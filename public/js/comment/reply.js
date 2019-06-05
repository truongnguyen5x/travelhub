/*click reply*/
function reply($id) 
{
    var d = document.getElementById("replyForm_" + $id);
    $('div.well1').hide();

    if (d.style.display === "none") 
    {
        d.style.display = "block";
    } 
    else 
    {
        d.style.display = "none";
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position){ 
            $("#lat" + $id).text(position.coords.latitude);
            $("#lng" + $id).text(position.coords.longitude);
            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

            var geocoder = geocoder = new google.maps.Geocoder();

            geocoder.geocode({ 'latLng': latlng }, function (results, status) {

                if (status == google.maps.GeocoderStatus.OK) 
                {
                    if (results[0]) 
                    {
                        $('#address' + $id).text(' in ' + results[0].formatted_address);
                    }
                }
            });
        });
    } else {
        $('#address').text('');
        alert('looi');
    }
}


/*click checkin button*/



/*reply comment*/
function replyComment($id)
{
    var token = $('button#comment').attr('name');
    var planId = $('div#wrapper').attr('name');
    var content = document.getElementById("text" + $id).value;
    var userId = $('div#form_comment').attr('name');
    var parentCommentId = $id;
    var lat = $('#lat' + $id).text();
    var lng = $('#lng' + $id).text();
    var address = $('#address' +$id).text();
    var formData = new FormData($("#uploadImage" + $id)[0]);
    formData.append('_token', token);
    formData.append('planId', planId);
    formData.append('content', content);
    formData.append('userId', userId);
    formData.append('parentCommentId', parentCommentId);
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
                + ")'><small> Delete</small></a>";
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

            $('div#preview' + $id).empty();
            $('div#replyForm_' + data.parentCommentId).after(
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
                + "'></div>" 
                + deleteComment
                + "</div></div>"
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
        error: function (error){
            alert('lol');
        }       
    });
}