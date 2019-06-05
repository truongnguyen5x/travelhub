/*click button follow*/
$(document).ready(function(){
	$("button#follow").click(function(){
		var token = $('button#comment').attr('name');
		var planId = $('div#wrapper').attr('name');
		var join = $("#join").text();
		var follow = $("#follow").text();

		$.ajax({
			type: "POST",
			url: "/follow",
			data:{
				_token: token,
				planId: planId,
				join: join,
				follow: follow,
			},
			success:function(data)
			{
				if(data.follow == "Đã theo dõi")
				{
					$("#follow").attr('class', 'btn btn-primary');
					$("#follow").text(data.follow);
				}
				if(data.follow == "Theo dõi")
				{
					$("#follow").attr('class', 'btn btn-secondary');
					$("#follow").text(data.follow);
				}
				$("#amountFollow").text('Số người theo dõi: ' + data.amountFollow + ' người');
			},  
			error: function (error)
			{
				alert('loi');
			}       
		});
	});
});