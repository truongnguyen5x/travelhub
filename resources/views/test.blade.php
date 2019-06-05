<!DOCTYPE html>
<html>
<body>
	<p>Kích vào button để lấy toạ độ của bạn</p>

	<button onclick="getLocation()">Lấy vị trí</button>

	<p id="demo"></p>

	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script>
		var x = document.getElementById("demo");

		function getLocation() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition);
			} else {
				x.innerHTML = "Geolocation không được hỗ trợ bởi trình duyệt này.";
			}
		}

		function showPosition(position) {
			x.innerHTML = "Vĩ độ: " + position.coords.latitude +
			"<br>Kinh độ: " + position.coords.longitude;
			var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

			var geocoder = geocoder = new google.maps.Geocoder();

			geocoder.geocode({ 'latLng': latlng }, function (results, status) {

				if (status == google.maps.GeocoderStatus.OK) 
				{
					if (results[0]) 
					{
						alert("Location: " + results[0].formatted_address);
					}
				}

			});
		}
	</script>

</body>
</html>