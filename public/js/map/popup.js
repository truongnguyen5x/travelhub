//thêm hoạt động tại một điểm
function addActivityPopup(marker) {
    console.log('function add activity popup ' + marker.getLabel().text);
    //lấy các thành phần
    var popup = $('div#popup1');
    var wrapper = $('div#wrapper');
    var exit = $('#popup1 #exit-popup');
    var error = $('#popup1 .error');
    var startTime = $('#popup1 #start-time-value');
    var endTime = $('#popup1 #end-time-value');
    var action = $('#popup1 #action-value');
    var btn = $('#popup1 #btn-popup');
    //setup
    $('#popup1 .h3-popup').html("Thêm hoạt động tại địa điểm <br>" + marker.placeDetail.name);
    btn.text('Thêm hoạt động');
    popup.show();
    wrapper.css('filter', 'blur(10px)');
    startTime.datetimepicker('reset');
    if (marker.arriverTime) startTime.datetimepicker({
        'value': new Date(marker.arriverTime.valueOf())
    });
    if (marker.getLabel().text == 'A') startTime.attr('disabled', true);
    endTime.datetimepicker('reset');
    //click
    btn.click(function() {
        var notify = "";
        if (startTime.val() != "" && startTime.datetimepicker('getValue') != null && endTime.val() != "" && endTime.datetimepicker('getValue') != null && action.val() != "") {
            if (startTime.datetimepicker('getValue') <= new Date() || startTime.datetimepicker('getValue') >= endTime.datetimepicker('getValue')) notify = " Thời gian bắt đầu không được ở trong quá khứ và thời phải sớm hơn thời gian kết thúc";
            else {
                planManager.editActivity(marker, action.val(), startTime.datetimepicker('getValue'), endTime.datetimepicker('getValue'));
                alert('Thêm hoạt động thành công!');
                doneWork();
            }
        } else {
            notify = " Bạn cần điền đầy đủ thông tin";
        }
        if (notify != "") {
            error.html("<div class='alert alert-danger'><strong>Lỗi!</strong>" + notify + "</div>");
        }
    });
    //ẩn popup
    exit.click(doneWork);
    $(document).click(function(event) {
        if (event.target.id == 'popup1') doneWork();
    });
    //khi xong việc
    function doneWork() {
        popup.hide();
        wrapper.css('filter', 'blur(0)');
        startTime.val('');
        startTime.attr('disabled', false);
        endTime.val('');
        action.val('');
        error.html('');
        btn.off('click');
    }
}
//sửa hoạt động tại 1 điểm
function editActivityPopup(marker) {
    console.log('function edit activity popup ' + marker.getLabel().text);
    //lấy các thành phần
    var popup = $('div#popup1');
    var wrapper = $('div#wrapper');
    var exit = $('#popup1 #exit-popup');
    var error = $('#popup1 .error');
    var startTime = $('#popup1 #start-time-value');
    var endTime = $('#popup1 #end-time-value');
    var action = $('#popup1 #action-value');
    var btn = $('#popup1 #btn-popup');
    //setup
    $('#popup1 .h3-popup').html("Sửa hoạt động tại địa điểm <br>" + marker.placeDetail.name);
    btn.text('Lưu thay đổi');
    popup.show();
    wrapper.css('filter', 'blur(4px)');
    startTime.datetimepicker('reset');
    if (marker.arriverTime) startTime.datetimepicker({
        'value': new Date(marker.arriverTime.valueOf())
    });
    endTime.datetimepicker('reset');
    if (marker.leaveTime) endTime.datetimepicker({
        'value': new Date(marker.leaveTime.valueOf())
    });
    if (marker.getLabel().text == 'A') startTime.attr('disabled', true);
    action.val(marker.activity);
    //click
    btn.click(function() {
        var notify = "";
        if (startTime.val() != "" && startTime.datetimepicker('getValue') != null && endTime.val() != "" && endTime.datetimepicker('getValue') != null && action.val() != "") {
            if (startTime.datetimepicker('getValue') <= new Date() || startTime.datetimepicker('getValue') >= endTime.datetimepicker('getValue')) notify = " Thời gian bắt đầu không được ở trong quá khứ và thời phải sớm hơn thời gian kết thúc";
            else {
                planManager.editActivity(marker, action.val(), startTime.datetimepicker('getValue'), endTime.datetimepicker('getValue'));
                alert('Sửa hoạt động thành công!');
                doneWork();
            }
        } else {
            notify = " Bạn cần điền đầy đủ thông tin";
        }
        if (notify != "") {
            error.html("<div class='alert alert-danger'><strong>Lỗi!</strong>" + notify + "</div>");
        }
    });
    //ẩn popup
    exit.click(doneWork);
    $(document).click(function(event) {
        if (event.target.id == 'popup1') doneWork();
    });
    //khi xong việc
    function doneWork() {
        popup.hide();
        wrapper.css('filter', 'blur(0)');
        startTime.val('');
        startTime.attr('disabled', false);
        endTime.val('');
        action.val('');
        error.html('');
        btn.off('click');
    }
}
//sửa thông tin 1 cung đường
function editRoadPopup(road) {
    console.log('function edit road ' + road.startMarker.getLabel().text + road.endMarker.getLabel().text);
    //lấy các thành phần
    var popup = $('div#popup2');
    var wrapper = $('div#wrapper');
    var exit = $('#popup2 #exit-popup');
    var startTime = $('#popup2 #start-time-value');
    var endTime = $('#popup2 #end-time-value');
    var radio = $('#popup2 .form-check-input');
    var otherValue = $('#popup2 #other-value');
    var vehicle = road.vehicle;
    var travelMode = road.travelMode;
    var error = $('#popup2 .error');
    var btn = $('#popup2 #btn-popup');
    //setup
    btn.text('Lưu thay đổi');
    popup.show();
    wrapper.css('filter', 'blur(4px)');
    $('#popup2 .h3-popup').html("Sửa chặng đường<br>" + road.startMarker.placeDetail.name + ' - ' + road.endMarker.placeDetail.name);
    //setup radio button
    if (travelMode == 'DRIVING') radio[0].checked = true;
    else if (travelMode == 'WALKING') radio[1].checked = true;
    else radio[2].checked = true;
    if (vehicle != 'Ô tô' && vehicle != 'Đi bộ' && vehicle != 'Phương tiện công cộng') {
        otherValue.val(vehicle);
        radio[3].checked = true;
    }
    if (!radio[3].checked) otherValue.attr('disabled', true);
    //setup time
    startTime.datetimepicker('reset');
    endTime.datetimepicker('reset');
    if (road.startMarker.leaveTime) startTime.datetimepicker({
        'value': new Date(road.startMarker.leaveTime.valueOf())
    });
    if (road.endMarker.arriverTime) endTime.datetimepicker({
        'value': new Date(road.endMarker.arriverTime.valueOf())
    });
    if (road === planManager.roads[0]) startTime.attr('disabled', true);
    if (checkLastRoad(planManager, road)) {
        endTime.attr('disabled', true);
        endTime.datetimepicker({
            value: $('input#end-time-input').datetimepicker('getValue')
        });
    }
    //sự kiện
    radio.change(function() {
        if (this.id == 'radio-driving') {
            travelMode = 'DRIVING';
            vehicle = 'Ô tô';
            otherValue.attr('disabled', true);
        } else if (this.id == 'radio-walking') {
            travelMode = 'WALKING';
            vehicle = 'Đi bộ';
            otherValue.attr('disabled', true);
        } else if (this.id == 'radio-transit') {
            travelMode = 'TRANSIT';
            vehicle = 'Phương tiện công cộng';
            otherValue.attr('disabled', true);
        } else {
            travelMode = 'DRIVING';
            otherValue.attr('disabled', false);
        }
    });
    //click
    btn.click(function() {
        var notify = "";
        if (radio[3].checked && otherValue.val() == '') var validate = false;
        else var validate = true;
        if (startTime.val() != "" && startTime.datetimepicker('getValue') != null && endTime.val() != "" && endTime.datetimepicker('getValue') != null && validate) {
            if (startTime.datetimepicker('getValue') <= new Date() || startTime.datetimepicker('getValue') >= endTime.datetimepicker('getValue')) {
                notify = " Thời gian xuất phát không được ở trong quá khứ và phải sớm hơn thời gian tới nơi";
            } else {
                if (radio[3].checked) planManager.editRoad(road, startTime.datetimepicker('getValue'), endTime.datetimepicker('getValue'), travelMode, otherValue.val());
                else planManager.editRoad(road, startTime.datetimepicker('getValue'), endTime.datetimepicker('getValue'), travelMode, vehicle);
                doneWork();
                alert('Sửa hoạt động thành công!');
            }
        } else {
            notify = " Bạn cần điền đủ thông tin";
        }
        if (notify != "") {
            error.html("<div class='alert alert-danger'><strong>Lỗi!</strong>" + notify + "</div>");
        }
    });
    //ẩn popup
    exit.click(doneWork);
    $(document).click(function(event) {
        if (event.target.id == 'popup2') doneWork();
    });
    //dọn dẹp khi xong việc
    function doneWork() {
        console.log('function doneWork');
        popup.hide();
        wrapper.css('filter', 'blur(0)');
        startTime.val('');
        endTime.val('');
        startTime.attr('disabled', false);
        endTime.attr('disabled', false);
        otherValue.val('');
        error.html('');
        btn.off('click');
        radio.off('change');
        for (var i = 0; i < radio.length; i++) radio[i].checked = false;
    }
}