/*var road={
    startMarker: '',
    endMarker: '',
    travelMode: '',
    vehicle:'',
    render: '',
    polylines: ''
}
var marker= {
    hasLink: ''.
    placeId:'',
    placeDetail: '',
    activity: '',
    arriverTime:'',
    leaveTime: '',
}
*/
//class chuyến đi
function Plan() {
    this.labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    this.roads = new Array();
    //thêm địa điểm đầu tiên
    this.addFirstMarker = function() {
        console.log('function plan add first marker');
        var temp = new google.maps.Marker({
            draggable: true,
            map: map,
            position: marker.getPosition(),
        });
        //sao chép thông tin
        temp.placeDetail = marker.placeDetail;
        temp.placeId = marker.placeId;
        temp.hasLink = marker.hasLink;
        temp.activity = '';
        markerAddListener(temp);
        //đặt tên cho marker change
        this.roads.push({
            startMarker: temp,
            endMarker: temp,
            travelMode: 'DRIVING',
            vehicle: 'Ô tô',
            routeIndex: 0
        });
        temp.parentRight = this.roads[0];
        temp.parentLeft = this.roads[0];
        this.assignLabel();
        placeServiceGetDetail(temp.placeId, temp, true);
        fixedTime();
        renderTable(this, !isDetailPlan);
        console.log(this.roads);
    }
    //thêm 1 địa điểm vào 1 cung
    this.addMarker = function(roadIndex) {
        console.log('function plan add mid marker ' + roadIndex);
        index = parseInt(roadIndex);
        var road = this.roads[index];
        var temp = new google.maps.Marker({
            draggable: true,
            map: map,
            position: marker.getPosition(),
        });
        //sao chép thông tin
        temp.placeDetail = marker.placeDetail;
        temp.placeId = marker.placeId;
        temp.hasLink = marker.hasLink;
        temp.activity = '';
        markerAddListener(temp);
        //thêm road
        var endMarker = road.endMarker;
        this.roads.splice(index + 1, 0, {
            startMarker: temp,
            endMarker: endMarker,
            travelMode: road.travelMode,
            vehicle: 'Ô tô',
            routeIndex: 0
        });
        road.endMarker = temp;
        temp.parentLeft = road;
        temp.parentRight = this.roads[index + 1];
        endMarker.parentLeft = this.roads[index + 1];
        //render route
        getDirection(temp.parentLeft, null);
        getDirection(temp.parentRight, null);
        this.assignLabel();
        placeServiceGetDetail(temp.placeId, temp, true);
        fixedTime();
        renderTable(this, !isDetailPlan);
        console.log(this.roads);
    }
    //chuyển 1 địa điểm
    this.newPosition = function(marker, latLng) {
        console.log('click change position marker ' + marker.getLabel().text);
        marker.setPosition(latLng);
        geocodeGetPlaceId(latLng, marker, true);
        //hiển thị route mới
        getDirection(marker.parentRight, null);
        getDirection(marker.parentLeft, null);
        renderTable(this, !isDetailPlan);
        console.log(this.roads);
    }
    //xoá 1 địa điểm
    this.removeMarker = function(marker) {
        console.log('function bạn chọn xoá marker ' + marker.getLabel().text);
        //xóa các route cũ
        removeRoute(marker.parentRight);
        if (this.roads.length > 1) {
            for (var i in this.roads) {
                if (this.roads[i].startMarker === marker) {
                    var endMarker = this.roads[i].endMarker;
                    this.roads.splice(i, 1);
                    //đặt lại con trỏ, tạo route mới
                    endMarker.parentLeft = marker.parentLeft;
                    marker.parentLeft.endMarker = endMarker;
                    if (this.roads.length > 1) getDirection(endMarker.parentLeft, null);
                    break;
                }
            }
        } else {
            this.roads = new Array();
        }
        this.assignLabel();
        fixedTime();
        renderTable(this, !isDetailPlan);
        console.log(this.roads);
    }
    //xoá tất cả địa điểm
    this.removeAllMarker = function() {
        if (confirm('Bạn có muốn xoá tất cả?')) {
            for (var i in this.roads) {
                removeRoute(this.roads[i]);
                this.roads[i].startMarker.setMap(null);
            }
            this.roads = [];
            renderTable(this, !isDetailPlan);
            console.log(this.roads);
        }
    }
    //sửa hoạt động tại địa điểm
    this.editActivity = function(marker, action, startTime, endTime) {
        console.log('function editActivity ' + marker.getLabel().text);
        marker.activity = action;
        marker.arriverTime = startTime;
        marker.leaveTime = endTime;
        activityToDiv(marker);
        fixedTime();
        renderTable(this, !isDetailPlan);
        console.log(this.roads);
    }
    //xoá hoạt động tại địa điểm
    this.removeActivity = function(marker) {
        console.log('choose removeActivity' + marker.getLabel().text);
        if (confirm('Bạn có muốn xoá hoạt động tại địa điểm ' + marker.getLabel().text + "?")) {
            marker.leaveTime = marker.arriverTime;
            marker.activity = '';
            activityToDiv(marker);
            fixedTime();
            renderTable(this, !isDetailPlan);
            console.log(this.roads);
        }
    }
    //đặt thời gian cho 1 cung đường
    this.editRoad = function(road, startTime, endTime, travelMode, vehicle) {
        console.log('function choose edit roadd ' + road.startMarker.getLabel().text + road.endMarker.getLabel().text);
        road.startMarker.leaveTime = startTime;
        if (road.startMarker.activity == '') road.startMarker.arriverTime = startTime;
        road.endMarker.arriverTime = endTime;
        if (road.endMarker.activity == '' && road.endMarker.getLabel().text != 'A') road.endMarker.leaveTime = endTime;
        if (travelMode != road.travelMode) {
            road.travelMode = travelMode;
            getDirection(road);
        }
        road.vehicle = vehicle;
        fixedTime();
        renderTable(this, !isDetailPlan);
        console.log(this.roads);
    }
    //đặt lại tên cung theo ABC
    this.assignLabel = function() {
        for (var i in this.roads) {
            var temp = this.roads[i].startMarker;
            var index = i % this.labels.length;
            temp.setLabel({
                color: 'white',
                text: this.labels[index]
            });
        }
    }
}