//sinh menu của điểm đầu tiên
function createFirstMarkerMenu() {
    console.log('function show menu thêm 1 điểm bắt đầu');
    var items = new Array();
    var item1 = document.createElement('a');
    item1.classList.add('dropdown-item');
    item1.innerHTML = 'Đặt làm địa điểm bắt đầu';
    google.maps.event.addDomListener(item1, 'click', function(e) {
        console.log('event click Đặt làm địa điểm bắt đầu');
        planManager.addFirstMarker();
        marker.setMap(null);
        e.stopPropagation();
        contextMenu.setMap(null);
    });
    items.push(item1);
    contextMenu = new ContextMenu(marker.getPosition(), items, map);
}
//sinh menu khi click các marker tiếp theo
function createMarkerMenu(event) {
    console.log('function show menu thêm 1 địa điểm');
    var items = new Array();
    //dòng thứ 1: thêm vào cuối chuyến đi
    var item1 = document.createElement('a');
    item1.classList.add('dropdown-item');
    item1.innerHTML = 'Thêm địa điểm vào cuối hành trình';
    google.maps.event.addDomListener(item1, 'click', function(e) {
        console.log('event click Thêm địa điểm vào cuối hành trình');
        planManager.addMarker(planManager.roads.length - 1);
        e.stopPropagation();
        marker.setMap(null);
        contextMenu.setMap(null);
    });
    items.push(item1);
    //dòng thứ 2: thêm vào giữa 2 điểm
    if (planManager.roads.length > 1) {
        var list = planManager.roads;
        var item2 = document.createElement('a');
        item2.classList.add('dropdown-item', 'expand');
        item2.innerHTML = "Thêm địa điểm vào giữa..<i class='fas fa-angle-right' style='float:right'></i>";
        var subMenu = document.createElement('div');
        subMenu.classList.add('dropdown-menu', 'sub-menu');
        item2.appendChild(subMenu);
        for (var i in list) {
            var item = document.createElement('a');
            item.classList.add('dropdown-item');
            item.innerText = 'Thêm giữa ' + list[i].startMarker.getLabel().text + list[i].endMarker.getLabel().text;
            item.name = i + "";
            subMenu.appendChild(item);
            google.maps.event.addDomListener(item, 'click', function(e) {
                console.log('event click thêm vào giữa ...cụ thể');
                planManager.addMarker(this.name);
                e.stopPropagation();
                marker.setMap(null);
                contextMenu.setMap(null);
            });
        }
        google.maps.event.addDomListener(item2, 'click', function(e) {
            e.stopPropagation();
        });
        items.push(item2);
    }
    //dòng thứ 3: đặt địa điểm
    if (planManager.roads.length > 0) {
        var item3 = document.createElement('a');
        item3.classList.add('dropdown-item', 'expand');
        item3.innerHTML = "Đặt địa điểm này là..<i class='fas fa-angle-right' style='float:right'></i>";
        var subMenu = document.createElement('div');
        subMenu.classList.add('dropdown-menu', 'sub-menu');
        item3.appendChild(subMenu);
        for (var i in planManager.roads) {
            var item = document.createElement('a');
            item.classList.add('dropdown-item');
            item.innerText = 'Địa điểm ' + planManager.roads[i].startMarker.getLabel().text;
            item.name = i + "";
            subMenu.appendChild(item);
            google.maps.event.addDomListener(item, 'click', function(e) {
                console.log('event click thay đổi địa chỉ ');
                planManager.newPosition(planManager.roads[this.name].startMarker, marker.getPosition());
                e.stopPropagation();
                marker.setMap(null);
                contextMenu.setMap(null);
            });
        }
        google.maps.event.addDomListener(item3, 'click', function(e) {
            e.stopPropagation();
        });
        items.push(item3);
    }
    contextMenu = new ContextMenu(event.latLng, items, map);
}
//sinh menu khi click 1 địa điểm
function editMarkerMenu(marker) {
    console.log('function show menu sửa địa điểm');
    var items = new Array();
    //dòng thêm hoạt động tại đây
    if (marker.activity == '') {
        var item4 = document.createElement('a');
        item4.classList.add('dropdown-item');
        item4.innerText = "Thêm hoạt động tại đây";
        google.maps.event.addDomListener(item4, 'click', function(e) {
            console.log('event click thêm hoạt động');
            addActivityPopup(marker);
            e.stopPropagation();
            contextMenu.setMap(null);
        });
        items.push(item4);
    }
    //dòng sửa hoạt động tại đây
    if (marker.activity != '') {
        var item2 = document.createElement('a');
        item2.classList.add('dropdown-item');
        item2.innerText = "Sửa hoạt động tại đây";
        google.maps.event.addDomListener(item2, 'click', function(e) {
            console.log('event click chọn sửa hoạt động');
            editActivityPopup(marker);
            e.stopPropagation();
            contextMenu.setMap(null);
        });
        items.push(item2);
    }
    //dòng xoá hoạt động
    if (marker.activity != '') {
        var item5 = document.createElement('a');
        item5.classList.add('dropdown-item');
        item5.innerText = "Xoá hoạt động tại đây";
        google.maps.event.addDomListener(item5, 'click', function(e) {
            console.log('event click chọn xoá hoạt động');
            planManager.removeActivity(marker);
            e.stopPropagation();
            contextMenu.setMap(null);
        });
        items.push(item5);
    }
    //phân cách
    var divider = document.createElement('div');
    divider.classList.add('dropdown-divider');
    items.push(divider);
    //dòng: xoá 1 marker
    var item1 = document.createElement('a');
    item1.classList.add('dropdown-item');
    item1.innerHTML = 'Xoá địa điểm';
    google.maps.event.addDomListener(item1, 'click', function(e) {
        console.log('event click xoá 1 điạ điểm');
        planManager.removeMarker(marker);
        marker.setMap(null);
        e.stopPropagation();
        contextMenu.setMap(null);
    });
    items.push(item1);
    //dòng: xoá tất cả marker
    var item3 = document.createElement('a');
    item3.classList.add('dropdown-item');
    item3.innerText = "Xoá tất cả địa điểm";
    google.maps.event.addDomListener(item3, 'click', function(e) {
        console.log('event click chọn xoá tất cả');
        planManager.removeAllMarker();
        e.stopPropagation();
        contextMenu.setMap(null);
    });
    if (planManager.roads.length > 1) items.push(item3);
    contextMenu = new ContextMenu(marker.getPosition(), items, map);
}
//menu khi click 1 cung đường
function editRoadMenu(road, position) {
    console.log('function show menu sửa đường');
    var items = new Array();
    //dòng thứ 1: tìm lại đường
    var item1 = document.createElement('a');
    item1.classList.add('dropdown-item');
    item1.innerHTML = 'Tìm đường đi tốt nhất';
    google.maps.event.addDomListener(item1, 'click', function(e) {
        console.log('event click Tìm đường đi tốt nhất');
        road.waypoints=null;
        getDirection(road);
        contextMenu.setMap(null);
        marker.setMap(null);
        e.stopPropagation();
    });
    items.push(item1);
    //dòng thứ 2: sửa thông tin
    var item2 = document.createElement('a');
    item2.classList.add('dropdown-item');
    item2.innerHTML = 'Sửa thông tin cung đường';
    google.maps.event.addDomListener(item2, 'click', function(e) {
        console.log('event click sửa cung');
        contextMenu.setMap(null);
        marker.setMap(null);
        e.stopPropagation();
        editRoadPopup(road);
    });
    items.push(item2);
    contextMenu = new ContextMenu(position, items, map);
}