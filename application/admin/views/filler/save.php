<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>填充物名称</strong> <br/>
	  </th>
      <td>
      <input valid="required" errmsg="填充物名称不能为空!" name="filler_name" id="filler_name" value="<?php if(! empty($item_info)){ echo $item_info['filler_name'];} ?>" size="80" type="text">
      <br/><font color="red">注：中间加“|”分隔符可以实现批量添加，格式如：“韩都衣舍|南极人|秋水伊人|初语|欧时力”</font>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>类别</strong> <br/>
	  </th>
      <td>
      <input name="tag" id="tag" value="<?php if(! empty($item_info)){ echo $item_info['tag'];} ?>" size="20" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%"><strong>排序</strong> <br/>
	  </th>
      <td>
      <input name="sort" id="sort" value="<?php if(! empty($item_info)){ echo $item_info['sort'];}else{ echo '0';} ?>" size="20" type="text">
	</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>
<script type="text/javascript">
//参数mulu
$(function () {
	//形象照片
	$("#path_file").wrap("<form id='path_upload' action='<?php echo base_url(); ?>admincp.php/upload/uploadImage2' method='post' enctype='multipart/form-data'></form>");
    $("#path_file").change(function(){ //选择文件
		$("#path_upload").ajaxSubmit({
			dataType:  'json',
			data: {
                'model': 'product_category',
                'field': 'path_file'
            },
			beforeSend: function() {
            	$("#path_load").show();
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(res) {
    			$("#path_load").hide();
    			if (res.success) {
    				$("#path_src_a").attr("href", res.data.file_path);
      			    $("#path_src").attr("src", res.data.file_path.replace('.', '_thumb.')+"?"+res.data.field);
      			    $("#path").val(res.data.file_path);
        		} else {
        			var d = dialog({
        				fixed: true,
    				    title: '提示',
    				    content: res.message
    				});
    				d.show();
    				setTimeout(function () {
    				    d.close().remove();
    				}, 2000);
            	}
			},
			error:function(xhr){
			}
		});
	});
});
load_image();
function load_image() {
	var path = $('#path').val();
	if (path) {
		$("#path_src_a").attr("href", path);
	    $("#path_src").attr("src", path.replace('.', '_thumb.'));
	}
}
</script>