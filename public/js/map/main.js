//preview ảnh       
$('input#cover').change(function(event) {
    console.log('event input#cover change');
    var div = $('div.image_thumb');
    if (event.target.files.length != 0) {
        var src = URL.createObjectURL(event.target.files[0]);
        div.show();
        div.html("<img src='" + src + "'style='width:100%;height:256px;object-fit:cover;border-radius:7px;margin-top:18px'>");
    } else {
        div.hide();
    }
});
//các input của route, marker
$('input#start-time-input').datetimepicker({
    format: 'd-m-Y H:i',
    onChangeDateTime: function(current_time, $input) {
        fixedTime();
        renderTable(planManager, !isDetailPlan);
    }
});
//các input của route, marker
$('input#end-time-input').datetimepicker({
    format: 'd-m-Y H:i',
    onChangeDateTime: function(current_time, $input) {
        fixedTime();
        renderTable(planManager, !isDetailPlan);
    }
});
//các input của route, marker
$('#popup1 #start-time-value').datetimepicker({
    format: 'd-m-Y H:i'
});
//các input của route, marker
$('#popup1 #end-time-value').datetimepicker({
    format: 'd-m-Y H:i'
});
//các input của route, marker
$('#popup2 #start-time-value').datetimepicker({
    format: 'd-m-Y H:i'
}); //các input của route, marker
$('#popup2 #end-time-value').datetimepicker({
    format: 'd-m-Y H:i'
});
//ngày sinh->date picker
$('input#date_of_birth').datetimepicker({
    format: 'd-m-Y',
    timepicker: false
});
//xóa tất cả
$('button#btn-clear-all').click(function() {
    planManager.removeAllMarker();
    if (!isAddPlan) drawPlan(roads, planManager);
});
//function date parse
function dateParse(string) {
    return new Date(string.substr(0, 10) + 'T' + string.substr(11, 8));
}
//đổi thời gian //done
function convertTime(dateTime) {
    if (dateTime) {
        var h = dateTime.getHours();
        var m = dateTime.getMinutes();
        var d = dateTime.getDate();
        var mon = dateTime.getMonth() + 1;
        h = checkTime(h);
        m = checkTime(m);
        d = checkTime(d);
        mon = checkTime(mon);
        return h + ':' + m + '  ' + d + '/' + mon + '/' + dateTime.getFullYear();
    }
    return '';
}
//đổi thời gian 
function convertTime2(dateTime) {
    if (dateTime) {
        var h = dateTime.getHours();
        var m = dateTime.getMinutes();
        var d = dateTime.getDate();
        var mon = dateTime.getMonth() + 1;
        h = checkTime(h);
        m = checkTime(m);
        d = checkTime(d);
        mon = checkTime(mon);
        return d + '-' + mon + '-' + dateTime.getFullYear() + ' ' + h + ':' + m;
    } else return '';
}
// add zero in front of numbers < 10  //done
function checkTime(i) {
    if (i < 10) {
        i = "0" + i
    };
    return i;
}
//đặt lại thời gian bắt đầu
function fixedTime() {
    if (planManager.roads.length > 0) {
        var time = $('input#start-time-input').datetimepicker('getValue');
        planManager.roads[0].startMarker.arriverTime = time;
        if (planManager.roads[0].startMarker.activity == '') planManager.roads[0].startMarker.leaveTime = time;
    }
}
//return is last road in plan
function checkLastRoad(planManager, road) {
    // return road === planManager.roads[planManager.roads.length - 1];
    return road.endMarker.getLabel().text=='A';
}