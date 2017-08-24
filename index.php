<?php
require 'restful/db.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create RESTful API using Slim PHP Framework</title>
<link href='css/style.css' rel='stylesheet' type='text/css'/>
</head>

<body>
<div style="margin:0 auto;width:1000px;">
<h1>User Updates</h1>
<a href="http://www.9lessons.info">www.9lessons.info</a>

<h3>RESTful API URLs</h3>

Get Users <a href="restful/users">http://localhost/SocialProject/restful/users</a><br/><br/>
Get Updates <a href="restful/updates">http://localhost/SocialProject/restful/updates</a><br/><br/>
User Search <a href="restful/users/search/s">http://localhost/SocialProject/restful/users/search/s</a><br/><br/>
Delete Update <a href="restful/updates/delete/1">http://localhost/SocialProject/restful/updates/delete/1</a><br/><br/>
Post Update <a href="restful/updates">http://localhost/SocialProject/restful/updates</a><br/>


<div>
<textarea id="update" class="stupdatebox"></textarea><br/>
<input type="submit" value="POST" class="stpostbutton">
</div>


<div id="mainContent">

</div>

<input type="hidden" id="user_id" value="<?php echo $session_uid; ?>">
<input type="hidden" value="<?php echo $apiKey; ?>" id="apiKey"/>

</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/ajaxGetPost.js"></script>
<script>
$(document).ready(function()
{
var base_url="http://localhost/SocialProjectKey/";
var url,encodedata,apiKey,user_id;
apiKey=$('#apiKey').val();
user_id=$('#user_id').val();
$("#update").focus();

/* Load Updates */
url=base_url+'restful/userUpdates';


encode=JSON.stringify({
        "user_id": user_id,
        "apiKey": apiKey
        });
post_ajax_data(url,encode, function(data)
{
$.each(data.updates, function(i,data)
{
var html="<div class='stbody' id='stbody"+data.update_id+"'><div class='stimg'><img src='"+data.profile_pic+"' class='stprofileimg'/></div>"
         +"<div class='sttext'><strong>"+data.name+"</strong>"+data.user_update+"<span id='"+data.update_id+"' class='stdelete'>Delete</span>";
		 +"</div></div>";
$(html).appendTo("#mainContent");

});

});

/* Insert Update */
$('body').on("click",'.stpostbutton',function()
{
var update=$('#update').val();
encode=JSON.stringify({
        "user_update": update,
        "user_id": user_id,
        "apiKey": apiKey
        });
url=base_url+'restful/insertUpdate';
if(update.length>0)
{
post_ajax_data(url,encode, function(data) 
{
var data=data.updates;
var html="<div class='stbody' id='stbody"+data.update_id+"'><div class='stimg'><img src='"+data.profile_pic+"' class='stprofileimg'/></div>"
         +"<div class='sttext'><strong>"+data.name+"</strong>"+data.user_update+"<span id='"+data.update_id+"' class='stdelete'>Delete</span>";
		 +"</div></div>";
$("#mainContent").prepend(html);
$('#update').val('').focus();

});
}

});

/* Delete Updates */
$('body').on("click",'.stdelete',function()
{
var ID=$(this).attr("id");
url=base_url+'restful/updates/delete/'+ID+'/'+user_id+'/'+apiKey;
ajax_data('DELETE',url, function(data) 
{
$("#stbody"+ID).fadeOut("slow");
});
});


});
</script>

</body>
</html>