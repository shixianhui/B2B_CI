<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>批量上传图片</title>
<base href="<?php echo base_url(); ?>" />
<link href="css/admin/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/admin/swfupload.js"></script>
<script type="text/javascript" src="js/admin/handlers.js"></script>
<script src="js/admin/jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var swfu;
    window.onload = function () {
		swfu = new SWFUpload({
		// Backend Settings
		upload_url: "admincp.php/upload/batchUpload",
		post_params: {"id": "<?php echo $adminId; ?>"},

		// File Upload Settings
		file_size_limit : "20 MB",	// 2MB
		file_types : "*.gif;*.jpg;*.png",
		file_types_description : "JPG Images",
		file_upload_limit : "0",

		// Event Handler Settings - these functions as defined in Handlers.js
		//  The handlers are not part of SWFUpload but are part of my website and control how
		//  my website reacts to the SWFUpload events.
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,

		// Button Settings
		button_image_url : "images/admin/upload_batch.jpg",
		button_placeholder_id : "spanButtonPlaceholder",
		button_width: 100,
		button_height: 20,
		button_text : '批量传图',
		button_text_style : '.button { font-family: Helvetica, Arial, sans-serif; font-size: 14px; } .buttonSmall { font-size: 14px; }',
		button_text_top_padding: 0,
		button_text_left_padding: 18,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
				
		// Flash Settings
		flash_url : "flash/swfupload.swf",

		custom_settings : {
			upload_target : "divFileProgressContainer"
		},				
		// Debug Settings
		debug: false
		});
    };
</script>
<style>
li {list-style-type:none;}
</style>
</head>
<body>
<div id="content">
	<?php
	if( !function_exists("imagecopyresampled") ){
		?>
	<div class="message">
		<h4><strong>Error:</strong> </h4>
		<p>Application Demo requires GD Library to be installed on your system.</p>
	</div>
	<?php
	} else {
	?>
	<form>
		<div style="display: inline; border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 2px;">
			<span id="spanButtonPlaceholder"></span>
		</div>
	</form>
	<?php
	}
	?>
	<div id="divFileProgressContainer" style="height: 75px;"></div>	
	<div id="thumbnails">	
	<?php if ($attachmentList): ?>
	<?php foreach ($attachmentList as $attachment): ?>
	 <li>
	    <img src="<?php echo preg_replace('/\./', '_thumb.', $attachment['path']); ?>" />
	    <br/>
	    <input type="hidden" name="upload_id[]" value="<?php echo $attachment['id'] ?>" />
	    <input style="border: 1px solid #CCCCCC;height: 20px;width: 200px;margin-top:2px;" type="text" name="alt[]" size="40" value="<?php echo $attachment['alt'] ?>" title="注释" />
	 </li>
	<?php endforeach; ?>
	<?php endif; ?>
	</div>
	<input name="update_alt" id="update_alt" type="button" value="修改注释" />
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#update_alt").click(function(){
		$attachmentIds = "";
		$alts = "";		
    	$("input[name='upload_id[]']").each(function(i,n){
    		$attachmentIds += $(this).val() + ",";
    	});
    	
    	$("input[name='alt[]']").each(function(i,n){
    		$alts += $(this).val().replace(/,/g, "") + ",";
    	});
		$.post("admincp.php/upload/updateAlt", 
				{	"attachmentIds": $attachmentIds.substr(0, $attachmentIds.length - 1),
			        "alts": $alts.substr(0, $alts.length - 1),
				},
				function(res){
					if(res.success){
						alert(res.message);
						return false;
					}else{
						alert(res.message);
						return false;
					}
				},
				"json"
		);
	});
});
</script>
</body>
</html>
