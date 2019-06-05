/*preview image*/

function chooseImage($id)
{
	$("#image" + $id).change(function(){
		$('#preview' + $id).html("");
		var total_file=document.getElementById("image" + $id).files.length;

		for(var i=0; i<total_file; i++)
		{
			$('#preview' + $id).append("<img src='"
				+ URL.createObjectURL(event.target.files[i]) 
				+ "' style='width: 150px; height: 120px'>"
				);
		}
	});
}