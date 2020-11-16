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
      <input name="select_category_id" id="select_category_id" type="hidden" value="<?php if(! empty($newsInfo)){ echo $newsInfo['category_id'];} ?>" >
      <select name="category_id" id="category" valid="required" errmsg="请选择栏目!">
       <option value="" >请选择栏目</option>
       <?php if (! empty($menuList)): ?>
       <!-- 一级 -->
       <?php foreach ($menuList as $menu): ?>
       <option value="<?php echo $menu['id']; ?>"><?php echo $menu['menu_name']; ?></option>
       <!-- 二级 -->
       <?php foreach ($menu['subMenuList'] as $subMenu): ?>
       <option value="<?php echo $subMenu['id']; ?>">&nbsp;&nbsp;|-<?php echo $subMenu['menu_name']; ?></option>
       <!-- 三级 -->
       <?php foreach ($subMenu['subMenuList'] as $sSubMenu): ?>
       <option value="<?php echo $sSubMenu['id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;|-<?php echo $sSubMenu['menu_name']; ?></option>
       <?php endforeach; ?>
       <?php endforeach; ?>
       <?php endforeach; ?>
       <?php endif;?>
      </select>
      </td>
    </tr>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>标题</strong> <br/>
	  </th>
      <td>
      <input name="title" id="title" value="<?php if(! empty($newsInfo)){ echo $newsInfo['title'];} ?>" size="80" maxlength="100" valid="required" errmsg="标题不能为空!" class="inputtitle input_blur" type="text">
	</td>
    </tr>
	<tr>
      <th width="20%">
      <strong>颜色</strong> <br/>
	  </th>
      <td>
    <select name="title_color" id="title_color">
	<option value="<?php if(! empty($newsInfo)){echo $newsInfo['title_color'];} ?>" selected="selected">颜色</option>
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
      <th width="20%"> <strong>关键词</strong> <br/>
	  多关键词之间用逗号隔开
	  </th>
      <td>
      <input name="keyword" id="keyword" size="50"  value="<?php if(! empty($newsInfo)){ echo $newsInfo['keyword'];} ?>"  maxlength="100" class="input_blur" type="text" />
      </td>
    </tr>
	<tr>
      <th width="20%"> <strong>摘要</strong> <br/>
	  </th>
      <td>还可以输入 <font id="ls_description" color="#ff0000">255</font> 个字符！<br/>
      <textarea name="abstract" id="abstract" rows="4" cols="50"  class="textarea_style" style="width: 80%;" ><?php if(! empty($newsInfo)){ echo $newsInfo['abstract'];} ?></textarea>
 </td>
    </tr>
	<tr>
      <th width="20%"> <strong>内容</strong>
      </th>
      <td>
	<textarea name="content" cols="50" rows="4" id="content"><?php if(! empty($newsInfo)){ echo $newsInfo["content"];}else{echo "&nbsp;";} ?></textarea>
	<script src="js/admin/fckeditor/fckeditor.js"></script>
	<script type="text/javascript">
		var oFCKeditor = new FCKeditor('content') ;
		oFCKeditor.BasePath = 'js/admin/fckeditor/';
		oFCKeditor.Width = '100%';
		oFCKeditor.Height = '300px';
		oFCKeditor.ToolbarSet = 'Basic';
		oFCKeditor.ReplaceTextarea();

		function getContentValue() {
			var oEditor = FCKeditorAPI.GetInstance('content');
			var acontent = oEditor.GetXHTML();
			$("#content").val(acontent);
		}
	</script>
      </td>
    </tr>
   <!-- <tr>
    <th width="20%">
    <strong>自定义属性</strong> <br/>
	</th>
    <td>
    <label><input class="checkbox_style" name="custom_attribute[]" id="h"  value="h" <?php if(! empty($newsInfo)){if(substr_count($newsInfo['custom_attribute'], "h")>0){echo "checked=true";}} ?> type="checkbox"/> 头条[h]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="c"  value="c" <?php if(! empty($newsInfo)){if(substr_count($newsInfo['custom_attribute'], "c")>0){echo "checked=true";}} ?> type="checkbox"/> 推荐[c]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="a"  value="a" <?php if(! empty($newsInfo)){if(substr_count($newsInfo['custom_attribute'], "a")>0){echo "checked=true";}} ?> type="checkbox"/> 特荐[a]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="f"  value="f" <?php if(! empty($newsInfo)){if(substr_count($newsInfo['custom_attribute'], "f")>0){echo "checked=true";}} ?> type="checkbox"/> 幻灯[f]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="s"  value="s" <?php if(! empty($newsInfo)){if(substr_count($newsInfo['custom_attribute'], "s")>0){echo "checked=true";}} ?> type="checkbox"/> 滚动[s]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="b"  value="b" <?php if(! empty($newsInfo)){if(substr_count($newsInfo['custom_attribute'], "b")>0){echo "checked=true";}} ?> type="checkbox"/> 加粗[b]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="p"  value="p" <?php if(! empty($newsInfo)){if(substr_count($newsInfo['custom_attribute'], "p")>0){echo "checked=true";}} ?> type="checkbox"/> 图片[p]</label>
	<label><input class="checkbox_style" name="custom_attribute[]" id="j"  value="j" <?php if(! empty($newsInfo)){if(substr_count($newsInfo['custom_attribute'], "j")>0){echo "checked=true";}} ?> type="checkbox"/> 跳转[j]</label>
    </td>
    </tr> --> 
    <tr>
      <th width="20%"> <strong>作者</strong> <br/>
	  </th>
      <td>
      <input name="author" id="author" size="30" value="<?php if(! empty($newsInfo)){ echo $newsInfo['author'];} ?>" maxlength="12" class="input_blur" type="text" />
      </td>
    </tr>
	<tr>
      <th width="20%">
      <strong>来源</strong> <br/>
	  </th>
      <td>
      <input name="source" id="source" size="30"  value="<?php if(! empty($newsInfo)){ echo $newsInfo['source'];} ?>"  maxlength="100" class="input_blur" type="text" />
      </td>
    </tr>
	<tr>
      <th width="20%"> <strong>浏览次数</strong> <br/>
	  </th>
      <td>
      <input name="hits" id="hits<?php if(! empty($newsInfo)){ echo $newsInfo['hits'];} ?>" value="<?php if(! empty($newsInfo)){ echo $newsInfo['hits'];} ?>"  type="text" valid="required|isNumber" errmsg="浏览次数不能为空!|浏览次数必须为数字!"/>
      </td>
    </tr>
	<tr>
      <th width="20%"> <strong>发布时间</strong> <br/>
	  </th>
      <td>
	<input class="input_blur" name="add_time" id="add_time"  size="21" readonly="readonly" type="text"/>&nbsp;
	<script language="javascript" type="text/javascript">
	    datetime = "<?php if(! empty($newsInfo)){ echo date('Y-m-d H:i:s', $newsInfo['add_time']);} ?>";
		date = new Date();
		if (datetime == "" || datetime == null) {
			datetime = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
		}
		document.getElementById ("add_time").value =datetime;
		Calendar.setup({
			inputField     :    "add_time",
			ifFormat       :    "%Y-%m-%d %H:%M:%S",
			showsTime      :    true,
			timeFormat     :    "24"
		});
	</script>
	 </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input class="button_style" name="reset" value=" 重置 " type="reset">
	  </td>
    </tr>
</tbody>
</table>
</form>