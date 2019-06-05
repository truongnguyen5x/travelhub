
//cần dặt trước reload map
//tìm đường
function getDirection(road) {
    console.log('function getDirections');
    if (!routeSaveMode) {
        var request = {
            origin: road.startMarker.getPosition(),
            destination: road.endMarker.getPosition(),
            provideRouteAlternatives: true,
            travelMode: road.travelMode,
        }
        if (road.hasWaypoints) request.waypoints = road.waypoints;
        removeRoute(road);
        var render = new google.maps.DirectionsRenderer();
        road.render = render;
        road.polylines = [];
        console.log('FUNCTION ROUTE');
        directionsService.route(request, function(results, status) {
            if (status == "OK") {
                render.setDirections(results);
                console.log('function route');
                render.setOptions({
                    draggable: !isDetailPlan,
                    markerOptions: {
                        visible: false
                    },
                    polylineOptions: {
                        strokeOpacity: 0.6,
                        strokeColor: '#0090FF',
                        strokeWeight: 6
                    },
                    hideRouteList: isDetailPlan,
                    routeIndex: road.routeIndex
                });
                makePolyline(road);
                collapseRoute(road);
            } else {
                alert('direction error ' + status);
            }
        });
        //khi kéo 1 route
        render.addListener('directions_changed', function(event) {
            console.log('function direction change');
            removeRoute(road);
            makePolyline(road);
            var polyline = road.polylines[0];
            var path = getPathPolyline(this.getDirections().routes[0], road.startMarker, road.endMarker);
            polyline.setPath(path);
            render.setMap(map);
            if (this.getDirections().request.waypoints) {
                road.waypoints = this.getDirections().request.waypoints;
                road.hasWaypoints = true;
            } else road.hasWaypoints = false;
        });
    }
}
// vẽ qua các cung thay thế và thêm sự kiện
function makePolyline(road) {
    console.log('function make polyline');
    for (var i in road.render.getDirections().routes) {
        var polyline = new google.maps.Polyline({
            map: null,
            strokeWeight: 6,
        });
        polyline.index = i;
        polyline.baseColor = '#807A7A';
        polylineAddEvent(road, polyline);
        road.polylines[i] = polyline;
    }
}
//thu gọn các cung thay thế
function collapseRoute(road) {
    console.log('function collapse route');
    if (!routeSaveMode) {
        removeRoute(road);
        var index = road.render.getRouteIndex();
        var polyline = road.polylines[index];
        if (polyline.getPath().length == 0) {
            var path = getPathPolyline(road.render.getDirections().routes[index], road.startMarker, road.endMarker);
            polyline.setPath(path);
        }
        polyline.baseColor = '#3AB326';
        polyline.setMap(map);
        polyline.setOptions({
            strokeColor: polyline.baseColor,
            zIndex: -11,
            strokeOpacity: 0.6,
        });
    }
}
//sự kiện click 1 cung //done
function polylineClickEvent(road, polyline) {
    hideRoute();
    currentRoute = road;
    console.log('event polyline click ' + polyline.index);
    var routes = road.render.getDirections().routes;
    for (var i = 0; i < routes.length; i++) {
        var temp = road.polylines[i];
        if (temp.getPath().length == 0) {
            var path = getPathPolyline(routes[i], road.startMarker, road.endMarker);
            temp.setPath(path);
        }
        temp.baseColor = '#807A7A';
        if (!isDetailPlan) temp.setMap(map);
        temp.setOptions({
            strokeColor: temp.baseColor,
            zIndex: -10,
            strokeOpacity: 0.6,
        });
    }
    road.render.setRouteIndex(parseInt(polyline.index));
    road.render.setMap(map);
    roadToDiv(road);
}
//sinh polyline  ///done
function getPathPolyline(route, startMarker, endMarker) {
    var legs = route.legs;
    var i, j;
    var path = [];
    path.push(startMarker.getPosition());
    for (i = 0; i < legs.length; i++) {
        var steps = legs[i].steps;
        for (j = 0; j < steps.length; j++) {
            var nextSegment = steps[j].path;
            for (k = 0; k < nextSegment.length; k++) {
                path.push(nextSegment[k]);
            }
        }
    }
    path.push(endMarker.getPosition());
    return path;
}
//xoá cung  //done
function removeRoute(road) {
    console.log('function xóa cung');
    if (!routeSaveMode) {
        if (road.render) {
            road.render.setMap(null);
            for (var i in road.polylines) {
                road.polylines[i].setMap(null);
            }
        }
    }
}
//thu gọn route hiện tại đang mở
function hideRoute() {
    if (currentRoute) {
        collapseRoute(currentRoute);
    }
    currentRoute = null;
    hideContextMenu();
}