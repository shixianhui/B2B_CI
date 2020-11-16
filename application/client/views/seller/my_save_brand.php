<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">新增品牌</span><span style="float: right;font-size:16px;"><a href="<?php echo getBaseUrl(false, '', 'seller/my_get_brand_list.html', $client_index) ?>" style="color:#333;">返回</a></span></div>
       <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" name="jsonForm" id="jsonForm">
        <div class="b_shop_update">
            <ul class="m_form fl">
                <li class="clearfix"><span>品牌名称：</span><input type="text" name="brand_name" id="brand_name" value="<?php if($item_info){ echo $item_info['brand_name'];}?>" valid="required" maxlength="100" errmsg="品牌名称不能为空" class="input_txt">
                    <font color="#cc0011">*</font>
                    <font color="red" style="font-size: 14px;">注：以"|"分隔可以批量添加</font>
                </li>
                <li class="clearfix"><span>分类：</span><input type="text" name="tag" id="tag" value="<?php if($item_info){ echo $item_info['tag'];}?>" class="input_txt"></li>
                <li class="clearfix">
                    <span>品牌LOGO：</span>
                    <p id="imgBox" style="padding-top:10px;display:inline-block;padding-right:10px;">
                        <?php if($item_info && $item_info['path']){ echo '<img src="'.str_replace('.','_thumb.',$item_info['path']).'" style="width:130px;height:60px;">';}?>
                    </p>
                     <p style="display:inline-block;width:65px;height:48px;position:relative;">
                        <img src="images/default/upload_image.png" id="path_load">
                        <input style="left:0px;top:0px; background:#000; width:65px;height:48px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="path_file" name="path_file" >
                    </p>
                     <font color="red" style="font-size: 14px;">注：图大小130x60</font>
                    <input type="hidden" name="path" value="<?php if($item_info){ echo $item_info['path'];}?>">
                </li>
            </ul>
        </div>
        <div class="clear"></div>
        <div style="margin:20px 0px 20px 200px; clear:both; display:block;">
            <a href="javascript:void(0);" class="b_btn" onclick="$('#jsonForm').submit();">确认提交</a>
        </div>
        </form>
    </div>
</div>
<script language="javascript" type="text/javascript">
    //形象照片
    $("#path_file").wrap("<form id='path_upload' action='"+base_url+"index.php/upload/uploadImage' method='post' enctype='multipart/form-data'></form>");
    $("#path_file").change(function(){ //选择文件
		$("#path_upload").ajaxSubmit({
			dataType:  'json',
			data: {
                        'model': 'brand',
                        'field': 'path_file'
                        },
			beforeSend: function() {
                                $("#path_load").attr('src','images/default/loading_2.gif');
                            },
                        uploadProgress: function(event, position, total, percentComplete) {},
			success: function(res) {
    			 $("#path_load").attr('src','images/default/upload_image.png');
    			if (res.success) {
                            $("#imgBox").html('<img src="'+res.data.file_path.replace('.', '_thumb.')+'" style="width:130px;height:60px;">');
                            $("input[name=path]").val(res.data.file_path);
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
			error:function(xhr){}
		});
	});
</script>