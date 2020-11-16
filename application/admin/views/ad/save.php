<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>广告位置</strong> <br/>
	  </th>
      <td>
      <input name="select_category_id" id="select_category_id" type="hidden" value="<?php if(! empty($item_info)){ echo $item_info['category_id'];} ?>" >
      <select class="input_blur" name="category_id" id="category" valid="required" errmsg="请选择广告位置!">
       <option value="" >请选择广告位置</option>
       <?php if (! empty($ad_group_list)): ?>
       <?php foreach ($ad_group_list as $item): ?>
       <option value="<?php echo $item['id'] ?>" ><?php echo $item['group_name'] ?></option>
       <?php endforeach; ?>
       <?php endif; ?>
      </select>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>广告类型</strong> <br/>
	  </th>
      <td>
      <label>
      <input type="radio" value="image" name="ad_type" class="radio_style" <?php if (! empty($item_info)){if($item_info['ad_type']=='image'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?>> 图片广告
      </label>
      <label>
      <input type="radio" value="flash" name="ad_type" class="radio_style" <?php if (! empty($item_info)){if($item_info['ad_type']=='flash'){echo 'checked="checked"';}} ?>> Flash广告
	  </label>
	  <label>
	  <input type="radio" value="html" name="ad_type" class="radio_style" <?php if (! empty($item_info)){if($item_info['ad_type']=='html'){echo 'checked="checked"';}} ?>> Html广告
	  <label>
	  <input type="radio" value="text" name="ad_type" class="radio_style" <?php if (! empty($item_info)){if($item_info['ad_type']=='text'){echo 'checked="checked"';}} ?>> 文字广告
	  </label>
	</td>
    </tr>
    <tr id="tr_image_path">
      <th width="20%">
      <strong>广告图片</strong> <br/>
	  </th>
      <td>
                <a id="path_src_a" title="点击查看大图" href="<?php if ($item_info && $item_info['path']){echo $item_info['path'];}else{echo 'images/admin/no_pic.png';} ?>" target="_blank" style="float:left;"><img id="path_src" width="60px" src="<?php if ($item_info && $item_info['path']){echo preg_replace('/\./', '_thumb.', $item_info['path']);}else{echo 'images/admin/no_pic.png';} ?>" onerror="javascript:this.src='images/admin/no_pic.png';" /></a>

                <div style="float:left; margin-top:22px;">
                <a style=" position:relative; width:auto; " >
		        <span style="cursor:pointer;" class="but_4">上传照片<input style="left:0px;top:0px; background:#000; width:100%;height:36px;line-height:36px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="path_file" name="path_file" ></span>
		        <i class="load" id="path_load" style="cursor:pointer;display:none;width:auto;padding-left:0px; left:50%; margin-left:-16px;"><img src="images/admin/loading_2.gif" width="32" height="32"></i>
		       </a>

		       <input value="<?php if ($item_info){echo $item_info['path'];} ?>" type="hidden" id="path" name="path">
		       <input name="model" id="model"  value="<?php echo $table; ?>" type="hidden" />
               <span id="cut_image" style="cursor:pointer;" class="but_4">裁剪图片</span>
               <?php $image_size_arr = get_image_size($table);
                     if ($image_size_arr) {
               ?>
               <span style="color:#9c9c9c;margin-left:30px;">注：缩略图大小＝<?php echo $image_size_arr['width']; ?>x<?php echo $image_size_arr['height']; ?></span>
               <?php } ?>
               </div>
                </td>
    </tr>
    <tr id="tr_content" style="display:none;">
      <th width="20%"> <strong>广告内容</strong>
      </th>
      <td>
<?php echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
<script id="content" name="content" type="text/plain" style="width:800px;height:200px;"><?php if(! empty($itemInfo)){ echo html($itemInfo["content"]);}else{echo "";} ?></script>
<script type="text/javascript">
    var ue = UE.getEditor('content');
</script>
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>广告大小</strong> <br/>
	  </th>
      <td>
     宽：<input class="input_blur" name="width" id="width" value="<?php if(! empty($item_info)){ echo $item_info['width'];}else{echo '0';} ?>" size="10" valid="isNumber" errmsg="宽只能是数字!" type="text"> <font color="red">px</font>
    高：<input class="input_blur" name="height" id="height" value="<?php if(! empty($item_info)){ echo $item_info['height'];}else{echo '0';} ?>" size="10" valid="isNumber" errmsg="高只能是数字!" type="text"> <font color="red">px</font>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>广告状态</strong> <br/>
	  </th>
      <td>
     <label>
     <input type="radio" value="1" name="display" class="radio_style" <?php if (! empty($item_info)){if($item_info['display']=='1'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 开启
	 </label>
	 <label>
	 <input type="radio" value="0" name="display" class="radio_style" <?php if (! empty($item_info)){if($item_info['display']=='0'){echo 'checked="checked"';}} ?> > 关闭
	 </label>
	 </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>广告词</strong> <br/>
	  </th>
      <td>
      <input name="ad_text" id="ad_text" size="80" class="input_blur" value="<?php if(! empty($item_info)){ echo $item_info['ad_text'];} ?>" type="text" />
    </td>
    </tr>
    <tr id="tr_image_path">
      <th width="20%">
      <strong>PC端广告链接</strong> <br/>
	  </th>
      <td>
      <input name="url" id="url" size="80" class="input_blur" value="<?php if(! empty($item_info)){ echo $item_info['url'];} ?>" type="text" />
    </td>
    </tr>
    <tr id="tr_image_path">
        <th width="20%">
            <strong>小程序广告链接</strong> <br/>
        </th>
        <td>
            <input name="xcx_url" id="xcx_url" size="80" class="input_blur" value="<?php if(! empty($item_info)){ echo $item_info['xcx_url'];} ?>" type="text" />
            <ul>
                <li>商品详情页:/pages/classify/product_view/product_view?item_id=36</li>
                <li>店铺详情页:/pages/index/entity_shop/shop_classify/shop_classify2/shop_flagship/shop_flagship?item_id=35</li>
                <li>店铺列表页:/pages/index/local_entity/local_entity?style_id=1&store_category_id=1&market_id=0</li>
            </ul>
        </td>
    </tr>
    <tr id="tr_image_path">
        <th width="20%">
            <strong>APP广告链接</strong> <br/>
        </th>
        <td>
            <input name="app_url" id="app_url" size="80" class="input_blur" value="<?php if(! empty($item_info)){ echo $item_info['app_url'];} ?>" type="text" />
            <ul>
                <li>商品详情页:product-view.html??item_id=186</li>
                <li>店铺详情页:store-view.html?item_id=35</li>
                <li>店铺列表页:store-list.html</li>
            </ul>
        </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody></table>
</div>
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