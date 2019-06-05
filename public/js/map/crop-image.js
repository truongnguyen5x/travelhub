//cắt ảnh avatar với JCrop
var div = $('div.preview-div');
$('input#avatar').change(function(event) {
    if ($('input#avatar').val() != '') {
        //source của input
        var src = URL.createObjectURL(event.target.files[0]);
        div.html("<p style='color:red;text-align:center'>Hãy chọn vùng bạn muốn hiển thị</p><img id='target' width='300px' /><div style='float:right'><div id='preview-pane'><div class='preview-container'><img class='jcrop-preview' /></div></div><p align='center' style='margin-bottom:0'>Ảnh xem trước</p></div><div class='clearfix'></div>");
        var target = $('img#target');
        var previewImage = $('img.jcrop-preview');
        div.show();
        //hiển thị ảnh lên target
        target.attr('src', src);
        previewImage.attr('src', src);
        var boundX, boundY, size = 170;
        target.Jcrop({
            onChange: updatePreview,
            onSelect: updatePreview,
            aspectRatio: 1 / 1
        }, function() {
            //init
            var bounds = this.getBounds();
            boundX = bounds[0];
            boundY = bounds[1];
            $('.jcrop-holder').css('float', 'left');
            if (boundY < boundX) {
                var size = Math.round(boundY * 0.9);
                var y2 = Math.round(boundY * 0.95);
                var y1 = Math.round(boundY * 0.05);
                var x1 = Math.round(boundX / 2.0 - size / 2.0);
                var x2 = Math.round(boundX / 2.0 + size / 2.0);
            } else {
                var size = Math.round(boundX * 0.9);
                var x2 = Math.round(boundX * 0.95);
                var x1 = Math.round(boundX * 0.05);
                var y1 = Math.round(boundY / 2.0 - size / 2.0);
                var y2 = Math.round(boundY / 2.0 + size / 2.0);
            }
            this.setSelect([x1, y1, x2, y2]);
        });
        //cập nhật khung hình vuông khi kéo thả
        function updatePreview(rectangle) {
            if (parseInt(rectangle.w) > 0) {
                var scaleX = size / rectangle.w;
                var scaleY = size / rectangle.h;
                previewImage.css({
                    width: Math.round(scaleX * boundX) + 'px',
                    height: Math.round(scaleY * boundY) + 'px',
                    marginLeft: '-' + Math.round(scaleX * rectangle.x) + 'px',
                    marginTop: '-' + Math.round(scaleY * rectangle.y) + 'px'
                });
            }
            $('input#rectX').val(rectangle.x);
            $('input#rectY').val(rectangle.y);
            $('input#size').val(rectangle.h);
        };
    } else {
        div.hide();
    }
});