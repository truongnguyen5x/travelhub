//cần load trước render table
//vẽ kế hoạch ra map                       
function drawPlan(roads,planManager) {
	console.log('function reload');
    var listMarker = [];
    for (var i in roads) {
        console.log('function reload '+i);
        var marker = new google.maps.Marker({
            draggable: !isDetailPlan,
            map: map,
            position: {
                lat: roads[i].lat,
                lng: roads[i].lng
            },
        });
        marker.activity = roads[i].activity;
        marker.arriverTime = dateParse(roads[i].arriver_time);
        marker.leaveTime = dateParse(roads[i].leave_time);
        marker.hasLink = roads[i].has_link;
        marker.placeDetail = JSON.parse(roads[i].place_detail);
        marker.placeId = roads[i].place_id;
        markerAddListener(marker);
        listMarker.push(marker);
    }
    planManager.roads = [];
    for (var i = 0; i < roads.length; i++) {
        var road = {
            startMarker: listMarker[i],
            endMarker: listMarker[(i + 1) % roads.length],
            hasWaypoints: roads[i].has_waypoints,
            vehicle: roads[i].vehicle,
            travelMode: roads[i].travel_mode,
            routeIndex: roads[i].route_index,
            waypoints: JSON.parse(roads[i].waypoints)
        };
        road.startMarker.parentRight = road;
        road.endMarker.parentLeft = road;
        planManager.roads.push(road);
        getDirection(road);
        console.log(road.waypoints);
    }
    map.setCenter(planManager.roads[0].startMarker.getPosition());
    planManager.assignLabel();
    renderTable(planManager,!isDetailPlan);
}

function setViewport(plan){
    var maxLat=0;
    var maxLng=0;
    var minLng=0;
    var minLng=0;
    for(var i in map){
        var position=map[i].startMarker.getPosition();
        // if(position.lat)
    }
}
