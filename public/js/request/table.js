/*load list request join*/
$(document).ready(function(){
	$("button#listJoins").click(function(){
		var token = $('button#comment').attr('name');
		var planId = $('div#wrapper').attr('name');

		$.ajax({
			type: "POST",
			url: "/loadList",
			data:{
				_token: token,
				planId: planId,
			},
			success:function(data)
			{
				for (var i = 0; i < data.userRequests.length; i++) 
				{
					var id = data.userRequests[i].id;
					var name = data.users[i].full_name;
					var birthday = data.users[i].date_of_birth;
					if(data.users[i].gender == 1)
					{
						var gender = 'Nam';
					}
					else
					{
						var gender = 'Nữ';
					}
					if(data.userRequests[i].state > -1)
					{
						if(data.userRequests[i].state == 0)
						{
							var state = 'Đang chờ phê duyệt';
							var button = '<button type="button" class="btn btn-success" onclick="accept(' 
							+ id
							+ ')">Chấp nhận</button><button type="button" class="btn btn-warning" onclick="deny(' 
							+ id
							+ ')">Từ chối</button>';
						}
						else
						{
							var state = 'Đã tham gia';
							var button = '<button type="button" class="btn btn-danger" onclick="remove(' 
							+ id
							+ ')">Xóa</button>';
						}

						$("#tbody").append('<tr align="center" id="request' 
							+ id
							+ '"><th>' 
							+ (i+1) 
							+ '</th><th>' 
							+ name
							+ '</th><th>' 
							+ gender
							+ '</th><th>' 
							+ birthday
							+ '</th><th>' 
							+ state 
							+ '</th><th>'
							+ button 
							+ '</th></tr>'
							);
					}	
				}
				$("#listRequests").removeAttr('hidden');
			},  
			error: function (error)
			{
				alert('loi');
			}       
		});
	});

	$("button#list").click(function(){
		var token = $('button#comment').attr('name');
		var planId = $('div#wrapper').attr('name');

		$.ajax({
			type: "POST",
			url: "/loadList",
			data:{
				_token: token,
				planId: planId,
			},
			success:function(data)
			{
				for (var i = 0; i < data.userRequests.length; i++) 
				{
					var id = data.userRequests[i].id;
					var name = data.users[i].full_name;
					var birthday = data.users[i].date_of_birth;
					if(data.users[i].gender == 1)
					{
						var gender = 'Nam';
					}
					else
					{
						var gender = 'Nữ';
					}
					if(data.userRequests[i].state > 0)
					{
						if(data.userRequests[i].state == 0)
						{
							var state = 'Đang chờ phê duyệt';
							var button = '';
						}
						else
						{
							var state = 'Đã tham gia';
							var button = '';
						}

						$("#tbody").append('<tr align="center" id="request' 
							+ id
							+ '"><th>' 
							+ (i+1) 
							+ '</th><th>' 
							+ name
							+ '</th><th>' 
							+ gender
							+ '</th><th>' 
							+ birthday
							+ '</th><th>' 
							+ state 
							+ '</th></tr>'
							);
					}	
				}
				$("#listRequests").removeAttr('hidden');
			},  
			error: function (error)
			{
				alert('loi');
			}       
		});
	});
});

/*click accept button*/
function accept($id)
{
	var token = $('button#comment').attr('name');

	$.ajax({
		type: "POST",
		url: "/process/request",
		data: {
			_token: token,
			id: $id,
			action: "accept",
		},
		success:function(data){
			$("#tbody").empty();
			for (var i = 0; i < data.userRequests.length; i++) 
			{
				var id = data.userRequests[i].id;
				var name = data.users[i].full_name;
				var birthday = data.users[i].date_of_birth;
				if(data.users[i].gender == 1)
				{
					var gender = 'Nam';
				}
				else
				{
					var gender = 'Nữ';
				}
				if(data.userRequests[i].state > -1)
				{
					if(data.userRequests[i].state == 0)
					{
						var state = 'Đang chờ phê duyệt';
						var button = '<button type="button" class="btn btn-success" onclick="accept(' 
						+ id
						+ ')">Chấp nhận</button><button type="button" class="btn btn-warning" onclick="deny(' 
						+ id
						+ ')">Từ chối</button>';
					}
					else
					{
						var state = 'Đã tham gia';
						var button = '<button type="button" class="btn btn-danger" onclick="remove(' 
						+ id
						+ ')">Xóa</button>';
					}

					$("#tbody").append('<tr align="center" id="request' 
						+ id
						+ '"><th>' 
						+ (i+1) 
						+ '</th><th>' 
						+ name
						+ '</th><th>' 
						+ gender
						+ '</th><th>' 
						+ birthday
						+ '</th><th>' 
						+ state 
						+ '</th><th>'
						+ button 
						+ '</th></tr>'
					);
				}	
			}

			$("#amountJoin").text('Số người tham gia: ' + data.extra + ' người');
		},  
		error: function (error){
			alert('lol');
		}       
	});
}

/*click deny button*/
function deny($id)
{
	var token = $('button#comment').attr('name');

	$.ajax({
		type: "POST",
		url: "/process/request",
		data: {
			_token: token,
			id: $id,
			action: "deny",
		},
		success:function(data){
			$("#tbody").empty();
			for (var i = 0; i < data.userRequests.length; i++) 
			{
				var id = data.userRequests[i].id;
				var name = data.users[i].full_name;
				var birthday = data.users[i].date_of_birth;
				if(data.users[i].gender == 1)
				{
					var gender = 'Nam';
				}
				else
				{
					var gender = 'Nữ';
				}
				if(data.userRequests[i].state > -1)
				{
					if(data.userRequests[i].state == 0)
					{
						var state = 'Đang chờ phê duyệt';
						var button = '<button type="button" class="btn btn-success" onclick="accept(' 
						+ id
						+ ')">Chấp nhận</button><button type="button" class="btn btn-warning" onclick="deny(' 
						+ id
						+ ')">Từ chối</button>';
					}
					else
					{
						var state = 'Đã tham gia';
						var button = '<button type="button" class="btn btn-danger" onclick="remove(' 
						+ id
						+ ')">Xóa</button>';
					}

					$("#tbody").append('<tr align="center" id="request' 
						+ id
						+ '"><th>' 
						+ (i+1) 
						+ '</th><th>' 
						+ name
						+ '</th><th>' 
						+ gender
						+ '</th><th>' 
						+ birthday
						+ '</th><th>' 
						+ state 
						+ '</th><th>'
						+ button 
						+ '</th></tr>'
					);
				}	
			}
		},  
		error: function (error){
			alert('lol');
		}       
	});
}

/*click remove button*/
function remove($id)
{
	var token = $('button#comment').attr('name');

	$.ajax({
		type: "POST",
		url: "/process/request",
		data: {
			_token: token,
			id: $id,
			action: "remove",
		},
		success:function(data){
			$("#tbody").empty();
			for (var i = 0; i < data.userRequests.length; i++) 
			{
				var id = data.userRequests[i].id;
				var name = data.users[i].full_name;
				var birthday = data.users[i].date_of_birth;
				if(data.users[i].gender == 1)
				{
					var gender = 'Nam';
				}
				else
				{
					var gender = 'Nữ';
				}
				if(data.userRequests[i].state > -1)
				{
					if(data.userRequests[i].state == 0)
					{
						var state = 'Đang chờ phê duyệt';
						var button = '<button type="button" class="btn btn-success" onclick="accept(' 
						+ id
						+ ')">Chấp nhận</button><button type="button" class="btn btn-warning" onclick="deny(' 
						+ id
						+ ')">Từ chối</button>';
					}
					else
					{
						var state = 'Đã tham gia';
						var button = '<button type="button" class="btn btn-danger" onclick="remove(' 
						+ id
						+ ')">Xóa</button>';
					}

					$("#tbody").append('<tr align="center" id="request' 
						+ id
						+ '"><th>' 
						+ (i+1) 
						+ '</th><th>' 
						+ name
						+ '</th><th>' 
						+ gender
						+ '</th><th>' 
						+ birthday
						+ '</th><th>' 
						+ state 
						+ '</th><th>'
						+ button 
						+ '</th></tr>'
					);
				}	
			}

			$("#amountJoin").text('Số người tham gia: ' + data.extra + ' người');
		},  
		error: function (error){
			alert('lol');
		}       
	});
}