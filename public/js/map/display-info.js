//hàm chuyển toạ độ chữ về số
function searchByLatLngText(geometryText, marker, showInfoWindow) {
    var latlngStr = geometryText.split(',', 2);
    var latlng = {
        lat: parseFloat(latlngStr[0]),
        lng: parseFloat(latlngStr[1])
    };
    console.log(latlng);
    map.setCenter(latlng);
    map.setZoom(17);
    marker.setPosition(latlng);
    geocodeGetPlaceId(latlng, marker, showInfoWindow);
}
//hàm geocode
function geocodeGetPlaceId(latLng, marker, showInfoWindow) {
    if (!placeSaveMode) {
        console.log('FUNCTION GEOCODE');
        geocoder.geocode({
            'location': latLng
        }, function(results, status) {
            if (status == "OK") {
                if (!results[0].formatted_address.includes('Unnamed Road')) marker.placeId = results[0].place_id;
                else marker.placeId = results[1].place_id;
                placeServiceGetDetail(marker.placeId, marker, showInfoWindow);
            } else {
                console.log("geocode error " + status);
            }
        });
    } else {
        //chế độ tiết kiệm
        marker.placeDetail = {
            name: 'Nowhere ' + Math.random().toString(36).substring(5),
            formatted_address: 'Unknown address ' + Math.random().toString(36).substring(5),
            url: 'google.com'
        }
        marker.placeId = 'fsdfsfsdfsd';
        displayInformation(marker.placeDetail, marker, showInfoWindow);
    }
}
//hàm place service get detail
function placeServiceGetDetail(placeID, marker, showInfoWindow) {
    if (!placeSaveMode) {
        placeService.getDetails({
            placeId: placeID,
            fields: ['formatted_address', 'name', 'photos', 'rating', 'url']
        }, function(place, status) {
            if (status == "OK") {
                console.log('FUNCTION PLACE DETAIL');
                marker.placeDetail = place;
                displayInformation(place, marker, showInfoWindow);
            } else {
                alert("place detail error " + status);
            }
        });
    } else {
        //tiết kiệm
        marker.placeDetail = {
            name: 'Nowhere ' + Math.random().toString(36).substring(5),
            formatted_address: 'Unknown address ' + Math.random().toString(36).substring(5),
            url: 'google.com'
        }
        marker.placeId = 'fsdfsfsdfsd';
        displayInformation(marker.placeDetail, marker, showInfoWindow);
    }
}
//gán div chứa ảnh lên #info
function displayInformation(place, marker, showInfoWindow) {
    console.log('function displayInformation');
    infoDiv.empty();
    infoDiv.prepend(placeToDiv(place, marker.hasLink));
    if (showInfoWindow) {
        infoWindow.setContent(place.name);
        if (marker.arriverTime) infoWindow.setContent(infoWindow.getContent() + "<br><span style='word-break:break-word'>" + convertTime(marker.arriverTime) + "</span>");
        infoWindow.open(map, marker);
    }
}
//hiển thị 1 địa điểm lên div
function placeToDiv(place, showLink) {
    console.log(place);
    var div = $('<div></div>');
    if (place.photos != undefined) {
        var src = place.photos[0].getUrl({
            'maxWidth': 500,
            'maxHeight': 300
        });
        div.append("<div style='max-height:250px;overflow:hidden'><img src='" + src + "' style='width:100%;'></div>");
    }
    div.append("<p style='font-weight:bold;font-size:20px;color:#2400FF;margin-bottom:10px'>" + place.name + "</p>");
    div.append("<p style='margin-bottom:5px'><i class='fas fa-map-marked' style='color:red'></i>  " + place.formatted_address + "</p>")
    if (place.rating != undefined) div.append("<p style='margin-bottom:5px'><i class='fas fa-star' style='color:red'></i> Rating: " + place.rating + "</p>");
    if (showLink) div.append("<p ><i class='fas fa-info-circle' style='color:red'></i> <a href='" + place.url + "''>Xem chi tiết trên Google maps</a></p>")
    return div;
}
//hiển thị thời gian, hoatk động tại 1 địa điểm
function activityToDiv(marker) {
    displayInformation(marker.placeDetail, marker, true);
    if (marker.activity) {
        var div = $('<div></div>');
        var str;
        div.append("<p style='color:#2400FF;font-size:20px;font-weight:bold;margin-top:15px;margin-bottom:7px'>Hoạt động tại đây: </p>");
        //thời gian tới
        str = convertTime(marker.arriverTime);
        div.append("<p style='margin-bottom:5px'><i class='fas fa-clock' style='color:red'></i> Thời gian bắt đầu: " + str + "</p>");
        //thời gian rời
        str = convertTime(marker.leaveTime);
        div.append("<p style='margin-bottom:5px'><i class='fas fa-clock' style='color:red'></i> Thời gian kết thúc: " + str + "</p>");
        div.append("<p style='margin-bottom:5px;word-break:break-word'><i class='fas fa-child' style=color:red></i> Nội dung: " + marker.activity + "</p>");
        infoDiv.append(div);
        //show infoWindow
        var title = marker.activity;
        if (title.length > 25) title = title.substring(0, 40) + '...';
        infoWindow.setContent(infoWindow.getContent() + "<br><span style='font-weight:bold;word-break:break-word'>" + title + "</span>");
    }
}
//hiển thị thông tin của chặng lên div  //not done
function roadToDiv(road) {
    infoDiv.empty();
    var div = $('<div></div');
    var str;
    str = convertTime(road.startMarker.leaveTime);
    div.append("<p style='margin-bottom:5px'><i class='fas fa-clock' style='color:red'></i> Thời gian xuất phát: " + str + "</p>");
    //thời gian rời
    if (checkLastRoad(planManager, road)) {
        str = convertTime($('input#end-time-input').datetimepicker('getValue'));
    } else str = convertTime(road.endMarker.arriverTime);
    div.append("<p style='margin-bottom:5px'><i class='fas fa-clock' style='color:red'></i> Thời gian tới nơi: " + str + "</p>");
    div.append("<p style='margin-bottom:5px;word-break:break-word'><i class='fas fa-car' style=color:red></i> Phương tiện: " + road.vehicle + "</p>");
    var div2 = document.createElement('div');
    infoDiv.append(div, div2);
    road.render.setPanel(div2);
}