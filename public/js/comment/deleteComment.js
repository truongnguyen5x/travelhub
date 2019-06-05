/*delete comment*/
function deleteComment($id)
{
    var token = $('button#comment').attr('name');

    $.ajax({
        type: "POST",
        url: "/delete/comment",
        data: {
            _token: token,
            commentId: $id,
        },
        success:function(data)
        {
            $("#" + data.commentId + "Comment").remove();
        },  
        error: function (error){
            alert('lol');
        }       
    });
}