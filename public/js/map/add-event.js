//sự kiện place change
function autocompleteEvent(event) {
    console.log('envent autocomplete place_change');
    hideRoute();
    var place = autocomplete.getPlace();
    if (!place.geometry) searchByLatLngText(place.name, marker, true);
    else {
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setMap(map);
        marker.setPosition(place.geometry.location);
        marker.placeId = place.place_id;
        marker.hasLink = true;
        placeServiceGetDetail(place.place_id, marker, true);
    }
}
//các sự kiện cho map
function mapAddEvent(map) {
    map.addListener('click', function(event) {
        console.log('event map click');
        hideRoute();
        marker.setMap(map);
        marker.setPosition(event.latLng);
        marker.hasLink = false;
        if (event.placeId) {
            marker.placeId = event.placeId;
            marker.hasLink = true;
            placeServiceGetDetail(event.placeId, marker, false);
        } else geocodeGetPlaceId(event.latLng.toJSON(), marker, false);
        event.stop();
    });
    map.addListener('rightclick', function(event) {
        console.log('event map right click');
        hideRoute();
        if(isDetailPlan)return;
         if (planManager.roads.length == 0) createFirstMarkerMenu();
        else createMarkerMenu(event);
    });
    map.addListener('dragstart', function() {
        console.log('event map drag');
        hideContextMenu();
    });
}
// các sự kiện cho marker
function markerAddEvent(marker) {
    marker.addListener('click', function(event) {
        console.log('event marker click');
        hideRoute();
        placeServiceGetDetail(marker.placeId, marker, true);
    });
    marker.addListener('rightclick', function(event) {
        console.log('event marker rigth click');
        hideRoute();
        if(isDetailPlan)return;
        if (planManager.roads.length == 0) createFirstMarkerMenu();
        else createMarkerMenu(event);
    });
    marker.addListener('dragend', function(event) {
        console.log('event marker drag end');
        geocodeGetPlaceId(event.latLng.toJSON(), marker, true);
    });
    marker.addListener('dragstart', function(event) {
        hideRoute();
    });
}
//thêm sự kiện
function markerAddListener(marker) {
    marker.addListener('click', function(event) {
        console.log('event marker click ');
        hideRoute();
        activityToDiv(this);
    });
    marker.addListener('rightclick', function(event) {
        if(isDetailPlan)return;
        console.log('event marker rigth click');
        hideRoute();
        editMarkerMenu(this);
    });
    marker.addListener('dragend', function(event) {
        console.log('event marker drag end');
        geocodeGetPlaceId(event.latLng.toJSON(), this, true);
        //hiển thị route mới
        getDirection(this.parentRight, null);
        getDirection(this.parentLeft, null);
        renderTable(planManager,!isDetailPlan);
    });
    marker.addListener('dragstart', function(event) {
        hideRoute();
    });
}
//sự kiện click polyline
function polylineAddEvent(road, polyline) {
    polyline.addListener('click', function(event) {
        polylineClickEvent(road, this);
    });
    polyline.addListener('mousemove', function(event) {
        this.setOptions({
            strokeColor: '#F41313',
            zIndex: 10
        });
    });
    polyline.addListener('mouseout', function(event) {
        this.setOptions({
            strokeColor: this.baseColor,
            zIndex: -11
        });
    });
    polyline.addListener('rightclick', function(event) {
        contextMenu.setMap(null);
        editRoadMenu(road, event.latLng);
    });
}