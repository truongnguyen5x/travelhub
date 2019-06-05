//cần đặt sau plan,context menu,add event
//các thành phần để hiển thị
var map;
var card = document.getElementById('pac-card'); //do not modify
var input = document.getElementById('pac-input'); //do not modify
var infoDiv = $('p#info');
var infoDiv2 = infoDiv[0];
var table = $("tbody#table-body");
var infoWindow;
var marker;
var contextMenu = new ContextMenu(null, null, null);
//các biến service
var autocomplete;
var geocoder;
var placeService;
var directionsService;
//data
var planManager = new Plan();
var currentRoute; //route hiện tại
var placeSaveMode = false; //chế độ tiết kiệm
var routeSaveMode = false; //chế độ tiết kiệm
//hàm khởi tạo map
function initMap() {
    console.log('initMap success');
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: {
            "lat": 21.0277644,
            "lng": 105.8341597999
        },
        streetViewControl: false,
        gestureHandling: 'greedy'
    });
    marker = new google.maps.Marker({
        draggable: true,
        map: map,
    });
    infoWindow = new google.maps.InfoWindow({
        maxWidth: 180
    });
    //bắt sự kiện
    mapAddEvent(map);
    markerAddEvent(marker);
    //1 số khởi tạo
    if (!routeSaveMode) directionsService = new google.maps.DirectionsService();
    if (!placeSaveMode) {
        placeService = new google.maps.places.PlacesService(map);
        geocoder = new google.maps.Geocoder();
        autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.setFields(['geometry', 'place_id']);
        //sự kiện chọn 1 địa điểm
        autocomplete.addListener('place_changed', autocompleteEvent);
    }
    if (!isAddPlan) {
        drawPlan(roads, planManager);
    }
}
google.maps.event.addDomListener(window, 'load', initMap);