/*listen and display new comment*/

var socket = io('http://localhost:6002')
socket.on('chat:message', function(data){
	console.log(data)

	if(data.commentLocation == null)
	{
		var myLocation = "";
	}
	else
	{
		var myLocation = data.commentLocation;
	}

	if(data.user.id != $('div#form_comment').attr('name'))
	{
		if(data.comment.parent_comment_id == null)
		{
			$('hr#after').after(
				"<div class='media mt-3' id='" 
				+ data.comment.id 
				+ "Comment'><a class='media-object' href='/thong-tin-ca-nhan/" 
				+ data.user.id
				+ "'><img src='/" 
				+ data.user.avatar
				+ "' style='width:64px;height:64px;object-fit:cover;border-radius: 32px'></a><div class='media-body' style='margin-left: 20px'><h5 class='mt-0'><a href='/thong-tin-ca-nhan/" 
				+ data.user.id 
				+ "'>" 
				+ data.user.full_name 
				+ "  </a><small> " 
				+ myLocation 
				+ " at " 
				+ data.comment.date_created 
				+ "</small></h5><p>" 
				+ data.comment.content 
				+ "</p><div id='listImage" 
				+ data.comment.id 
				+ "'></div><a style='color: #1362F3' onclick='reply(" 
				+ data.comment.id 
				+ ")'><small>Reply</small></a><div class='well1' style='display: none;' id='replyForm_"
				+ data.comment.id 
				+ "' name='form'><div class='media mt-3'><div class='media-body'><h6>Viết bình luận ...<span class='glyphicon glyphicon-pencil'></span></h6><div class='form-group'><textarea class='form-control' rows='1' id='text" 
				+ data.comment.id 
				+ "'></textarea><button type='button' class='btn btn-default'><i class='fa fa-map-marker'></i></button><small id='address" 
				+ data.comment.id 
				+ "'></small><small id='lat" 
				+ data.comment.id 
				+ "' style='display: none;'></small><small id='lng" 
				+ data.comment.id 
				+ "' style='display: none;'></small></div><div id='preview" 
				+ data.comment.id 
				+ "'></div><form id='uploadImage" 
				+ data.comment.id 
				+ "' enctype='multipart/form-data'><input type='file' id='image" 
				+ data.comment.id 
				+ "' name='image[]' multiple  onclick='chooseImage(" 
				+ data.comment.id 
				+ ")'></form><button id='reply' class='btn btn-primary' onclick='replyComment(" 
				+ data.comment.id 
				+ ")'>Gửi</button></div></div></div><hr>"
				)
			for(var i=0; i<data.path.length; i++)
				$('div#listImage' + data.comment.id).append(
					"<img id='img" 
					+ i 
					+ "' src='"
					+ data.path[i]
					+ "' style='width:150px;height:150px;' onclick='myclick()'>"
					)  
		}
		else
		{
			$('div#replyForm_' + data.comment.parent_comment_id).after(
				"<div class='media mt-3' id='" 
				+ data.comment.id 
				+ "Comment'><a class='media-object' href='/thong-tin-ca-nhan/" 
				+ data.user.id
				+ "'><img src='/" 
				+ data.user.avatar
				+ "' style='width:64px;height:64px;object-fit:cover;border-radius: 32px'></a><div class='media-body' style='margin-left: 20px'><h5 class='mt-0'><a href='thong-tin-ca-nhan/" 
				+ data.user.id 
				+ "'>" 
				+ data.user.full_name 
				+ "  </a><small>" 
				+ myLocation
				+ " at " 
				+ data.comment.date_created 
				+ "</small></h5><p>" 
				+ data.comment.content 
				+ "</p><div id='listImage"
				+ data.comment.id
				+ "'></div></div></div>"
				)
			for(var i=0; i<data.path.length; i++)
				$('div#listImage' + data.comment.id).append(
					"<img id='img" 
					+ i 
					+ "' src='"
					+ data.path[i]
					+ "' style='width:150px;height:150px;' onclick='myclick()'>"
					)
		}
	}
})