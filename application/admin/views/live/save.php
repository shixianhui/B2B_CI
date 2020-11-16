<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<input name="id" value="" type="hidden">
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
      <font color="red">*</font> <strong>标题</strong> <br/>
	  </th>
      <td>
      <input name="title" id="title" value="<?php if(! empty($item_info)){ echo $item_info['title'];} ?>" size="80" maxlength="100" valid="required" errmsg="标题不能为空!" class="inputtitle input_blur" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>SEO标题</strong> <br/>
	  </th>
      <td>
      <input name="seo_title" id="seo_title" value="<?php if(! empty($item_info)){ echo $item_info['seo_title'];} ?>" size="80" class="input_blur" type="text">
	</td>
    </tr>
	<tr>
      <th width="20%">
      <strong>颜色</strong> <br/>
	  </th>
      <td>
    <select class="input_blur" name="title_color" id="title_color">
	<option value="<?php if(! empty($item_info)){echo $item_info['title_color'];} ?>" selected="selected">颜色</option>
	<option value="#000000" class="bg1"></option>
	<option value="#ffffff" class="bg2"></option>
	<option value="#008000" class="bg3"></option>
	<option value="#800000" class="bg4"></option>
	<option value="#808000" class="bg5"></option>
	<option value="#000080" class="bg6"></option>
	<option value="#800080" class="bg7"></option>
	<option value="#808080" class="bg8"></option>
	<option value="#ffff00" class="bg9"></option>
	<option value="#00ff00" class="bg10"></option>
	<option value="#00ffff" class="bg11"></option>
	<option value="#ff00ff" class="bg12"></option>
	<option value="#ff0000" class="bg13"></option>
	<option value="#0000ff" class="bg14"></option>
	<option value="#008080" class="bg15"></option>
	</select>
   </td>
  </tr>
  <tr>
    <th width="20%">
    <strong>缩略图</strong> <br/>
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
      <th width="20%"> <strong>关键词</strong> <br/>
	  多关键词之间用逗号隔开
	  </th>
      <td>
      <input name="keyword" id="keyword" size="50"  value="<?php if(! empty($item_info)){ echo $item_info['keyword'];} ?>"  maxlength="100" class="input_blur" type="text" />
      </td>
    </tr>
	<tr>
      <th width="20%"> <strong>摘要</strong> <br/>
	  </th>
      <td>还可以输入 <font id="ls_description" color="#ff0000">255</font> 个字符！<br/>
      <textarea name="abstract" id="abstract" rows="4" cols="50"  class="textarea_style" style="width: 80%;" ><?php if(! empty($item_info)){ echo $item_info['abstract'];} ?></textarea>
 </td>
    </tr>
	<tr>
      <th width="20%"> <strong>内容</strong>
      </th>
      <td>
<?php echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
<script id="content" name="content" type="text/plain" style="width:800px;height:200px;"><?php if(! empty($item_info)){ echo html($item_info["content"]);}else{echo "";} ?></script>
<script type="text/javascript">
    var ue = UE.getEditor('content');
</script>
      </td>
    </tr>
   <tr>
    <th width="20%">
    <strong>自定义属性</strong> <br/>
	</th>
    <td>
    <label><input class="checkbox_style" name="custom_attribute[]" id="h"  value="h" <?php if(! empty($item_info)){if(substr_count($item_info['custom_attribute'], "h")>0){echo "checked=true";}} ?> type="checkbox"/> 头条[h]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="c"  value="c" <?php if(! empty($item_info)){if(substr_count($item_info['custom_attribute'], "c")>0){echo "checked=true";}} ?> type="checkbox"/> 推荐[c]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="a"  value="a" <?php if(! empty($item_info)){if(substr_count($item_info['custom_attribute'], "a")>0){echo "checked=true";}} ?> type="checkbox"/> 特荐[a]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="f"  value="f" <?php if(! empty($item_info)){if(substr_count($item_info['custom_attribute'], "f")>0){echo "checked=true";}} ?> type="checkbox"/> 幻灯[f]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="s"  value="s" <?php if(! empty($item_info)){if(substr_count($item_info['custom_attribute'], "s")>0){echo "checked=true";}} ?> type="checkbox"/> 滚动[s]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="b"  value="b" <?php if(! empty($item_info)){if(substr_count($item_info['custom_attribute'], "b")>0){echo "checked=true";}} ?> type="checkbox"/> 加粗[b]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="p"  value="p" <?php if(! empty($item_info)){if(substr_count($item_info['custom_attribute'], "p")>0){echo "checked=true";}} ?> type="checkbox"/> 图片[p]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="j"  value="j" <?php if(! empty($item_info)){if(substr_count($item_info['custom_attribute'], "j")>0){echo "checked=true";}} ?> type="checkbox"/> 跳转[j]</label>
    </td>
    </tr>
    <tr>
      <th width="20%"> <strong>相关内容</strong> <br/>
	  </th>
      <td>
      <input name="relation" id="relation" size="50" value="<?php if(! empty($item_info)){ echo $item_info['relation'];} ?>" class="input_blur" type="text" /> <font color="red">注：填写相关内容的ID，如“1,2,3,4”</font>
      </td>
    </tr>
    <tr>
      <th width="20%"> <strong>作者</strong> <br/>
	  </th>
      <td>
      <input name="author" id="author" size="30" value="<?php if(! empty($item_info)){ echo $item_info['author'];} ?>" maxlength="12" class="input_blur" type="text" />
      </td>
    </tr>
	<tr>
      <th width="20%">
      <strong>来源</strong> <br/>
	  </th>
      <td>
      <input name="source" id="source" size="30"  value="<?php if(! empty($item_info)){ echo $item_info['source'];} ?>"  maxlength="100" class="input_blur" type="text" />
      </td>
    </tr>
	<tr>
      <th width="20%"> <strong>浏览次数</strong> <br/>
	  </th>
      <td>
      <input class="input_blur" name="hits" id="hits<?php if(! empty($item_info)){ echo $item_info['hits'];} ?>" value="<?php if(! empty($item_info)){ echo $item_info['hits'];} ?>"  type="text" valid="required|isNumber" errmsg="浏览次数不能为空!|浏览次数必须为数字!"/>
      </td>
    </tr>
	<tr>
      <th width="20%"> <strong>发布时间</strong> <br/>
	  </th>
      <td>
	<input class="input_blur" name="add_time" id="add_time"  size="21" readonly="readonly" type="text"/>&nbsp;
	<script language="javascript" type="text/javascript">
	    datetime = "<?php if(! empty($item_info)){ echo date('Y-m-d H:i:s', $item_info['add_time']);} ?>";
		date = new Date();
		if (datetime == "" || datetime == null) {
			datetime = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
		}
		document.getElementById ("add_time").value =datetime;
		Calendar.setup({
			inputField     :    "add_time",
			ifFormat       :    "%Y-%m-%d %H:%M:%S",
			showsTime      :    true,
			timeFormat     :    "24",
			align          :    "Tr"
		});
	</script>
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