//AJAX
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("button#btn-submit").click(function() {
        var result = convertToJSON();
        var form_data = new FormData();
        form_data.append('planName', $('input#plan-name').val());
        form_data.append('startTime', $('input#start-time-input').val());
        form_data.append('endTime', $('input#end-time-input').val());
        form_data.append('hasCover', $('input#cover')[0].files.length);
        form_data.append('cover', $('input#cover')[0].files[0]);
        form_data.append('markers', result);
        form_data.append('state', $("#state option:selected").val());
        $.ajax({
            type: "POST",
            url: thisPostUrl,
            data: form_data,
            processData: false,
            contentType: false,
            success: function(data) {
                window.location = data;
            },
            error: function(error) {
                showResponseError(error.responseJSON);
            }
        });
    });
});
//chuyển kế hoạch sang JSON
function convertToJSON() {
    console.log('function json');
    var listMarkers = [];
    if (planManager.roads.length > 1) {
        for (var i in planManager.roads) {
            var road = planManager.roads[i];
            var startMarker = planManager.roads[i].startMarker;
            listMarkers.push({
                lat: startMarker.getPosition().lat(),
                lng: startMarker.getPosition().lng(),
                placeId: startMarker.placeId,
                hasLink: startMarker.hasLink,
                placeDetail: JSON.stringify(startMarker.placeDetail),
                leaveTime: convertTime2(startMarker.leaveTime),
                arriverTime: convertTime2(startMarker.arriverTime),
                activity: startMarker.activity,
                travelMode: road.travelMode,
                vehicle: road.vehicle,
                hasWaypoints: road.hasWaypoints,
                routeIndex: routeSaveMode ? null : road.render.getRouteIndex(),
                waypoints: routeSaveMode ? null : JSON.stringify(road.waypoints)
            });
        }
    }
    return JSON.stringify(listMarkers);
}
//hiển thị một vài lỗi
function showResponseError(errorJSON) {
    console.log(errorJSON);
    lisrError = [];
    if (errorJSON.planName) {
        lisrError.push('Lỗi! Bạn cần điền tên kế hoạch');
        $("strong#plan-name-error").text(errorJSON.planName[0]);
        $('input#plan-name').addClass('is-invalid');
    } else {
        $("strong#plan-name-error").text('');
        $('input#plan-name').removeClass('is-invalid');
    }
    if (errorJSON.startTime) {
        lisrError.push('Lỗi! Tthời gian bắt đầu sai');
        $("strong#start-time-error").text(errorJSON.startTime[0]);
        $('input#start-time-input').addClass('is-invalid');
    } else {
        $("strong#start-time-error").text('');
        $('input#start-time-input').removeClass('is-invalid');
    }
    if (errorJSON.endTime) {
        lisrError.push('Lỗi! Tthời gian kết thúc sai');
        $("strong#end-time-error").text(errorJSON.endTime[0]);
        $('input#end-time-input').addClass('is-invalid');
    } else {
        $("strong#end-time-error").text('');
        $('input#end-time-input').removeClass('is-invalid');
    }
    if (errorJSON.cover) {
        lisrError.push('Lỗi! Ảnh bìa sai');
        $("strong#avatar-error").text(errorJSON.cover[0]);
        $('input#cover').addClass('is-invalid');
    } else {
        $("strong#avatar-error").text('');
        $('input#cover').removeClass('is-invalid');
    }
    if (errorJSON.error) {
        lisrError.push(errorJSON.error);
    }
    alert(lisrError[0]);
}