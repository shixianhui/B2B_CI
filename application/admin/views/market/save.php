<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<div class="tag_menu" style="width: 99%; margin-top: 10px;">
<ul>
  <li><a href="javascript:void(0);" id="basic" class="selected">商场信息</a></li>
  <li><a href="javascript:void(0);" id="advanced" >商场平面图</a></li>
  <li><a href="javascript:void(0);" id="kefu" >商场广告图</a></li>
  <li><a href="javascript:void(0);" id="chouzhi">营销选项</a></li>
</ul>
</div>
<div id="basics" style="border-top:2px solid #99d3fb;" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>商场分类</strong> <br/>
	  </th>
      <td>
      <input name="select_category_id" id="select_category_id" type="hidden" value="<?php if(! empty($item_info)){ echo $item_info['category_id'];} ?>" >
      <select class="input_blur" name="category_id" id="category" valid="required" errmsg="请选择商场分类!">
       <option value="" >请选择商场分类</option>
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
      <font color="red">*</font> <strong>所属城市</strong> <br/>
	  </th>
      <td>
      <select class="input_blur" name="site_category_1" id="site_category_1" valid="required" errmsg="请选择所属城市">
       <option value="" >请选择所属城市</option>
       <?php if (! empty($site_list)) { ?>
       <?php foreach ($site_list as $key=>$value) {
       	     $selector = '';
                 if ($item_info && $item_info['site_category_1'] == $value['id']) {
                 	$selector = 'selected="selected"';
                 }
       	?>
       <option <?php echo $selector; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
      <?php }} ?>
      </select>
      </td>
    </tr>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>商场名称</strong> <br/>
	  </th>
      <td>
      <input name="title" id="title" value="<?php if(! empty($item_info)){ echo $item_info['title'];} ?>" size="80" maxlength="100" valid="required" errmsg="商场名称不能为空!" class="inputtitle input_blur" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>所在地</strong> <br/>
	  </th>
      <td>
      <input id="txt_address" name="txt_address" type="hidden" value="<?php if(! empty($item_info)){ echo $item_info['txt_address'];} ?>" />
    <select valid="required" errmsg="请选择省" class="input_blur" id="province_id" name="province_id" onchange="javascript:get_city('province_id','city_id',0,0,1);">
    <option value="">选择省</option>
    <?php if ($area_list) { ?>
    <?php foreach ($area_list as $key=>$value) {
	    	$selector = '';
	    	if ($item_info) {
	    		if ($item_info['province_id'] == $value['id']) {
	    			$selector = 'selected="selected"';
	    		}
	    	}
    	?>
    <option <?php echo $selector; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
    <?php }} ?>
    </select>
    <select valid="required" errmsg="请选择市" class="input_blur" id="city_id" name="city_id" onchange="javascript:get_city('city_id','area_id',0,0,2);">
    <option>选择市</option>
    </select>
    <select onchange="javascript:change_area();" valid="required" errmsg="选择区/县" class="input_blur" id="area_id" name="area_id">
    <option>选择区/县</option>
    </select>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>详细地址</strong> <br/>
	  </th>
      <td>
      <input name="address" id="address" value="<?php if(! empty($item_info)){ echo $item_info['address'];} ?>" size="80" maxlength="100" valid="required" errmsg="详细地址不能为空" class="input_blur" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>联系人</strong> <br/>
	  </th>
      <td>
      <input name="contacts" id="contacts" value="<?php if(! empty($item_info)){ echo $item_info['contacts'];} ?>" maxlength="15" class="input_blur" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>电话</strong> <br/>
	  </th>
      <td>
      <input name="phone" id="phone" value="<?php if(! empty($item_info)){ echo $item_info['phone'];} ?>" maxlength="15" class="input_blur" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>传真</strong> <br/>
	  </th>
      <td>
      <input name="fax" id="fax" value="<?php if(! empty($item_info)){ echo $item_info['fax'];} ?>" maxlength="15" class="input_blur" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>邮箱</strong> <br/>
	  </th>
      <td>
      <input name="email" id="email" value="<?php if(! empty($item_info)){ echo $item_info['email'];} ?>" maxlength="15" class="input_blur" type="text">
      </td>
    </tr>
    <tr>
    <th width="20%">
    <strong>商场LOGO</strong> <br/>
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
               <span style="color:#9c9c9c;margin-left:30px;">注：缩略图大小＝<?php echo $image_size_arr['width']; ?>x<?php echo $image_size_arr['height']; ?>；原图建议：138x138</span>
               <?php } ?>
               </div>

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
</div>
<div id="advanceds" style="border-top:2px solid #99d3fb;display:none;" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>商场平面图设置</caption>
 	<tbody>
 	<tr>
      <th width="20%"><font color="red">*</font> <strong>商场介绍</strong> <br/>
	  </th>
      <td>
      <textarea name="introduce" id="introduce" rows="4" maxlength="400" cols="50"  class="textarea_style" style="width: 80%;" ><?php if(! empty($item_info)){ echo $item_info['introduce'];} ?></textarea>
     </td>
    </tr>
 	<tr>
      <th width="20%"><font color="red">*</font> <strong>商场平面图 </strong>
      </th>
      <td>
<?php echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
<script id="content" name="content" type="text/plain" style="width:800px;height:400px;"><?php if(! empty($item_info)){ echo html($item_info["content"]);}else{echo "";} ?></script>
<script type="text/javascript">
    var ue = UE.getEditor('content');
</script>
      </td>
    </tr>
    <tr>
      <th width="20%"><font color="red">*</font> <strong>商场位置图片 </strong>
      </th>
      <td>
<script id="location_txt" name="location_txt" type="text/plain" style="width:800px;height:300px;">
<?php if(! empty($item_info)){ echo html($item_info["location_txt"]);}else{echo "";} ?>
</script>
<script type="text/javascript">
    var ue = UE.getEditor('location_txt');
</script>
<font color="red">注：大小=780x330</font>
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
</div>
<div id="kefus" style="border-top:2px solid #99d3fb;display:none;" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>商场广告图设置</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>商场顶部广告图</strong> <br/>
	  </th>
      <td>
    <input name="batch_path_ids_top" id="batch_path_ids_1" size="50" class="input_blur" value="<?php if(! empty($item_info)){ echo $item_info['batch_path_ids_top'];} ?>" type="text" />
    <input class="button_style" name="batch_upload_image" onclick="javascript:upload_image_bg(1);" value="批量添加" style="width: 60px;"  type="button" />
    <font color="#9c9c9c">注：区域大小750x70,可放两张原图345x70的图片</font>
    </td>
    </tr>
 	<tr>
      <th width="20%">
      <strong>商场首页轮播图</strong> <br/>
	  </th>
      <td>
    <input name="batch_path_ids" id="batch_path_ids_2" size="50" class="input_blur" value="<?php if(! empty($item_info)){ echo $item_info['batch_path_ids'];} ?>" type="text" />
    <input class="button_style" name="batch_upload_image" onclick="javascript:upload_image_bg(2);" value="批量添加" style="width: 60px;"  type="button" />
    <font color="#9c9c9c">注：原图大小＝1920x470</font>
    </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>商场底部广告图</strong> <br/>
	  </th>
      <td>
    <input name="batch_path_ids_bottom" id="batch_path_ids_3" size="50" class="input_blur" value="<?php if(! empty($item_info)){ echo $item_info['batch_path_ids_bottom'];} ?>" type="text" />
    <input class="button_style" name="batch_upload_image" onclick="javascript:upload_image_bg(3);" value="批量添加" style="width: 60px;"  type="button" />
    <font color="#9c9c9c">注：区域大小1200x120,一张图可放原图大小为1200x120,其他根据实际效果计算大小</font>
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
</div>
<div id="chouzhis" style="border-top:2px solid #99d3fb;display:none;" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>SEO设置</caption>
 	<tbody>
 	<tr>
      <th width="20%"><strong>SEO标题</strong> <br/>
	  </th>
      <td>
      <input name="seo_title" id="seo_title" value="<?php if(! empty($item_info)){ echo $item_info['seo_title'];} ?>" size="80" class="input_blur" type="text">
	</td>
    </tr>
 	<tr>
      <th width="20%"> <strong>关键词</strong> <br/>
	  多关键词之间用逗号隔开
	  </th>
      <td>
      <input name="keyword" id="keyword" size="80"  value="<?php if(! empty($item_info)){ echo $item_info['keyword'];} ?>"  maxlength="100" class="input_blur" type="text" />
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
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
    </tbody>
</table>
</div>
</form>
<script type="text/javascript">
function change_area() {
	//国 省 市 县
	var province_id_txt = $("#province_id").find("option:selected").text();
	var city_id_txt = $("#city_id").find("option:selected").text();
	var area_id_txt = $("#area_id").find("option:selected").text();
	$("#txt_address").val(province_id_txt+' '+city_id_txt+' '+area_id_txt);
}

function get_city(cur_id, next_id, next_select_val, prev_select_val, is_city) {
	var parent_id = $("#"+cur_id).val();
	if (prev_select_val) {
		parent_id = prev_select_val;
	}
	$.post(base_url+"admincp.php/store/get_city",
			{	"parent_id": parent_id
			},
			function(res){
				if(res.success){
					var html = '';
					if (is_city == 1) {
						html = '<option value="">--选择市--</option>';
					} else if (is_city == 2) {
						html = '<option value="">--选择区/县--</option>';
					}
					for (var i = 0, data = res.data, len = data.length; i < len; i++){
						if (data[i]['id'] == next_select_val) {
							html += '<option selected="selected" value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
						} else {
							html += '<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
						}
					}
					$("#"+next_id).html(html);
					return false;
				}else{
					alert(res.message);
					return false;
				}
			},
			"json"
	);
}
<?php if ($item_info) { ?>
get_city('province_id','city_id',<?php echo $item_info['city_id']; ?>,<?php echo $item_info['province_id']; ?>,1);
get_city('city_id','area_id',<?php echo $item_info['area_id']; ?>,<?php echo $item_info['city_id']; ?>,2);
<?php } ?>
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

function upload_image_bg(id) {
	var batchPathIds = $("#batch_path_ids_"+id).val();
	var model = "<?php echo $table; ?>";
	var parseImagePathIds = batchPathIds.replace(/\//g, ":");
	parseImagePathIds = parseImagePathIds.replace(/\./g, "_");
	if (parseImagePathIds == "") {
	    parseImagePathIds = '0';
	}
	var d = dialog({
		fixed: true,
	    title: '批量上传图片：',
	    content: '<iframe frameborder="0" src="'+base_url+'admincp.php/upload/batch_upload/'+model+'/'+parseImagePathIds+'/'+id+'" width="680" height="400"></iframe>'
	});
	d.show();
}
</script>