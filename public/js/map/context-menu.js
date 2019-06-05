//file này có thể add trước init map

//lớp menu chuột phải kế thừa overlays
ContextMenu.prototype = new google.maps.OverlayView();
//class
function ContextMenu(position, data, map) {
    this.position_ = position;
    this.data_ = data;
    this.div_ = null;
    this.setMap(map);
}
//khi overlay được setMap
ContextMenu.prototype.onAdd = function() {
    var div = document.createElement('div');
    div.classList.add('dropdown-menu', 'show');
    for (var i in this.data_) {
        div.appendChild(this.data_[i]);
    }
    this.div_ = div;
    var panes = this.getPanes();
    panes.floatPane.appendChild(div);
};
//khi overlay được repaint
ContextMenu.prototype.draw = function() {
    var overlayProjection = this.getProjection();
    var pixel = overlayProjection.fromLatLngToDivPixel(this.position_);
    var div = this.div_;
    var map = $('div#map');
    var subMenu = $('div.sub-menu');
    //căn chỉnh menu vào trong màn hình map
    if (pixel.x > map.width() / 2 - div.offsetWidth) pixel.x -= div.offsetWidth;
    if (pixel.y > map.height() / 2 - div.offsetHeight) pixel.y -= div.offsetHeight;
    div.style.left = pixel.x + 'px';
    div.style.top = pixel.y + 'px';
    var parent = subMenu.parent();
    for (var i = 0; i < subMenu.length; i++) {
        var left = div.offsetWidth - 10;
        var top = -8;
        pixel.y += parent[i].offsetTop;
        subMenu2 = $(subMenu[i]);
        if (pixel.x > map.width() / 2 - div.offsetWidth - subMenu2.width() + 10) left = -subMenu2.width();
        if (pixel.y > map.height() / 2 + 8 - subMenu2.height()) top = -subMenu2.height() + 15;
        subMenu2.css('left', left + 'px');
        subMenu2.css('top', top + 'px');
    }
}
//khi overlay được setMap(null);
ContextMenu.prototype.onRemove = function() {
    this.div_.parentNode.removeChild(this.div_);
    this.div_ = null;
};
//ẩn menu chuột phải
function hideContextMenu() {
    contextMenu.setMap(null);
    infoWindow.setMap(null);
}