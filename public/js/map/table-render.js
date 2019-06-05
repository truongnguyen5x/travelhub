//tạo bảng các cung đường  //done
function renderTable(planManager, editableMode) {
    console.log('function render table');
    table.empty();
    var index = 0;
    for (var i = 0; i < planManager.roads.length; i++) {
        var road = planManager.roads[i];
        if (road.startMarker.activity) {
            table.append(renderRowActivity(planManager, road, index++, editableMode));
            table.append(renderRow(planManager, road, index++, true, editableMode));
        } else table.append(renderRow(planManager, road, index++, false, editableMode));
        console.log(planManager);
    }
}
//tạo 1 hàng chứa 1 chặng chỉ có hoạt động
function renderRowActivity(planManager, road, index, editableMode) {
    console.log('function render a row has activity');
    var row = $("<tr align='center'></tr>");
    var startMarker = road.startMarker;
    //number
    var no = $("<td>" + (index + 1) + "</td>");
    row.append(no);
    //startName
    var startName = $("<td align='left'> " + startMarker.getLabel().text + ': <b>' + startMarker.placeDetail.name + "</b></td>");
    row.append(startName);
    //time
    var startTime = $("<td>" + convertTime(startMarker.arriverTime) + "</td>");
    row.append(startTime);
    //end Name
    row.append("<td>---</td>");
    //time
    var endTime = $("<td>" + convertTime(startMarker.leaveTime) + "</td>");
    row.append(endTime);
    //vehicle
    row.append("<td>---</td>");
    //action
    var action = $("<td> " + startMarker.activity + "</td>");
    row.append(action);
    //nút bấm
    var button = $("<td ></td>");
    var ul = $("<ul class='two-button-center' style='min-width:150px'>" + '' + "</ul>");
    button.append(ul);
    var li = $("<li style='display: inline;'></li>");
    var li2 = $("<li style='display: inline;'></li>");
    ul.append(li, li2);
    //2 nút bấm
    var btnEdit = $("<button class='btn btn-primary' style='margin-right:5px;font-size:13px'><i class='fas fa-edit'></i> Sửa </button>");
    btnEdit.click(function(event) {
        editActivityPopup(startMarker);
    });
    li.append(btnEdit);
    //nút xóa
    var btnDel = $("<button class='btn btn-danger' style='font-size:13px'><i class='fas fa-trash-alt'></i> Xóa hđ tại " + startMarker.getLabel().text + "</button>");
    btnDel.click(function(event) {
        planManager.removeActivity(startMarker);
    });
    li2.append(btnDel);
    if (editableMode) row.append(button);
    return row;
}

function renderRow(planManager, road, index, hasActivity, editableMode) {
    console.log('function render a row');
    var row = $("<tr align='center'></tr>");
    var startMarker = road.startMarker;
    var endMarker = road.endMarker;
    //number
    var no = $("<td>" + (index + 1) + "</td>");
    row.append(no);
    //start name
    var startName = $("<td align='left'> " + startMarker.getLabel().text + ': <b>' + startMarker.placeDetail.name + "</b></td>");
    row.append(startName);
    //time
    var startTime = $("<td>" + convertTime(startMarker.leaveTime) + "</td>");
    row.append(startTime);
    //end name
    var endName = $("<td align='left'> " + endMarker.getLabel().text + ': <b>' + endMarker.placeDetail.name + "</b></td>");
    row.append(endName);
    //time
    if (checkLastRoad(planManager, road)) var endTime = $("<td>" + convertTime($('input#end-time-input').datetimepicker('getValue')) + "</td>");
    else var endTime = $("<td>" + convertTime(endMarker.arriverTime) + "</td>");
    row.append(endTime);
    //phương tiện
    var vehicle = $("<td>" + road.vehicle + "</td>");
    row.append(vehicle);
    //action
    var action = $("<td> " + 'Di chuyển' + "</td>");
    row.append(action);
    //nút
    var button = $("<td ></td>");
    var ul = $("<ul class='two-button-center' style='min-width:250px'>" + '' + "</ul>");
    button.append(ul);
    var li = $("<li style='display: inline;'></li>");
    var li2 = $("<li style='display: inline;'></li>");
    ul.append(li, li2);
    //2 nút
    var btnAdd = $("<button class='btn btn-success' type='button' style='margin-right:5px;font-size:13px'><i class='fas fa-child'></i> Thêm hđ tại " + startMarker.getLabel().text + "</button>");
    btnAdd.click(function(event) {
        addActivityPopup(startMarker);
    });
    if (!hasActivity) li.append(btnAdd);
    //nút sửa
    var btnEdit = $("<button class='btn btn-primary' type='button' style='font-size:13px'><i class='fas fa-edit'></i> Sửa chặng</button>");
    btnEdit.click(function(event) {
        editRoadPopup(road);
    });
    li2.append(btnEdit);
    if (editableMode) row.append(button);
    //
    if (startMarker != endMarker) return row;
}