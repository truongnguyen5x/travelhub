/*click button join*/
$(document).ready(function(){
	$("button#join").click(function(){
		var token = $('button#comment').attr('name');
		var planId = $('div#wrapper').attr('name');
		var join = $("#join").text();
		var follow = $("#follow").text();

		$.ajax({
			type: "POST",
			url: "/join",
			data:{
				_token: token,
				planId: planId,
				join: join,
				follow: follow,
			},
			success:function(data)
			{
				if(data.join == "Đã gửi yêu cầu tham gia")
				{
					$("#join").attr('class', 'btn btn-primary');
					$("#join").text(data.join);
					$("#follow").attr('disabled', 'true');
					if(data.follow == "Đã theo dõi")
					{
						$("#follow").attr('class', 'btn btn-primary');
						$("#follow").attr('disabled', 'true');
						$("#follow").text(data.follow);
						$("#amountFollow").text('Số người theo dõi: ' + data.amountFollow + ' người');
					}
				}
				if(data.join == "Tham gia")
				{
					$("#join").attr('class', 'btn btn-secondary');
					$("#join").text(data.join);
					$("#follow").removeAttr('disabled');
				}
				if(data.join == "Đã bỏ tham gia")
				{
					$("#join").attr('class', 'btn btn-secondary');
					$("#join").attr('disabled', 'true');
					$("#join").text(data.join);
					$("#follow").removeAttr('disabled');
				}

			},  
			error: function (error)
			{
				alert('loi');
			}       
		});
	});
});