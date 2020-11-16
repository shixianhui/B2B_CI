<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>栏目</strong> <br/>
	  </th>
      <td>
      <input name="select_category_id" id="select_category_id" type="hidden" value="<?php if(! empty($item_info)){ echo $item_info['category_id'];} ?>" >
      <select class="input_blur" name="category_id" id="category" valid="required" errmsg="请选择栏目!">
       <option value="" >请选择栏目</option>
       <?php if (! empty($menu_list)) { ?>
       <!-- 一级 -->
       <?php foreach ($menu_list as $menu) { ?>
       <option <?php if ($menu['subMenuList']) {echo 'disabled="disabled"';} ?> value="<?php echo $menu['id']; ?>"><?php echo $menu['menu_name']; ?></option>
       <!-- 二级 -->
       <?php foreach ($menu['subMenuList'] as $subMenu) { ?>
       <option <?php if ($subMenu['subMenuList']) {echo 'disabled="disabled"';} ?> value="<?php echo $subMenu['id']; ?>">&nbsp;&nbsp;┣<?php echo $subMenu['menu_name']; ?></option>
       <!-- 三级 -->
       <?php foreach ($subMenu['subMenuList'] as $sSubMenu) { ?>
       <option <?php if ($sSubMenu['subMenuList']) {echo 'disabled="disabled"';} ?> value="<?php echo $sSubMenu['id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;┣<?php echo $sSubMenu['menu_name']; ?></option>
       <!-- 四级 -->
       <?php foreach ($sSubMenu['subMenuList'] as $sSubMenu4) { ?>
       <option <?php if ($sSubMenu4['subMenuList']) {echo 'disabled="disabled"';} ?> value="<?php echo $sSubMenu4['id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┣<?php echo $sSubMenu4['menu_name']; ?></option>
       <!-- 五级 -->
       <?php foreach ($sSubMenu4['subMenuList'] as $sSubMenu5) { ?>
       <option value="<?php echo $sSubMenu5['id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┣<?php echo $sSubMenu5['menu_name']; ?></option>
       <?php }}}}}} ?>
      </select>
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>链接类型</strong> <br/>
	  </th>
      <td>
      <label>
      <input type="radio" value="logo" name="link_type" class="radio_style" <?php if(! empty($item_info)){ if($item_info['link_type']=='logo'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?>> 图片链接&nbsp;&nbsp;&nbsp;&nbsp;
	  </label>
	  <label>
	  <input type="radio" value="text" name="link_type" class="radio_style" <?php if(! empty($item_info)){ if($item_info['link_type']=='text'){echo 'checked="checked"';}} ?>> 文字链接
	  </label>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>网站名称</strong> <br/>
	  </th>
      <td>
      <input class="input_blur" name="site_name" id="site_name" value="<?php if(! empty($item_info)){ echo $item_info['site_name'];} ?>" size="50" maxlength="60" valid="required" errmsg="网站名称不能为空!" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>网站地址</strong> <br/>
	  </th>
      <td>
     <input class="input_blur" name="url" id="url" value="<?php if(! empty($item_info)){ echo $item_info['url'];} ?>" size="50" maxlength="100" valid="required" errmsg="网站地址不能为空!" type="text">
	</td>
    </tr>
    <tr id="tr_image_path">
      <th width="20%">
      <strong>网站Logo</strong> <br/>
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
    <tr>
      <th width="20%">
      <strong>网站介绍</strong> <br/>
	  </th>
      <td>
     <textarea id="description" rows="4" cols="50" name="description"><?php if(! empty($item_info)){ echo $item_info['description'];} ?></textarea>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>排序</strong> <br/>
	  </th>
      <td>
     <input class="input_blur" name="sort" id="sort" value="<?php if(! empty($item_info)){ echo $item_info['sort'];}else{echo '0';} ?>" size="50" valid="isNumber" errmsg="排序只能是数字!" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>QQ号</strong> <br/>
	  </th>
      <td>
     <input class="input_blur" name="qq" id="qq" value="<?php if(! empty($item_info)){ echo $item_info['qq'];} ?>" size="50" maxlength="15" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>邮件</strong> <br/>
	  </th>
      <td>
     <input class="input_blur" name="email" id="email" value="<?php if(! empty($item_info)){ echo $item_info['email'];} ?>" size="50" maxlength="100" valid="isEmail" errmsg="邮件格式错误!" type="text">
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