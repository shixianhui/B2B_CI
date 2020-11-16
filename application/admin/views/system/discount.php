<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>限时抢购(此功能只开启抢购功能，哪些商品参与此活动，请到“产品管理”设置)</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>广告标题</strong> <br/>
	  </th>
      <td>
      <input name="discount_title" id="discount_title" value="<?php if($itemInfo){echo $itemInfo['discount_title'];} ?>" size="80"  class="input_blur" type="text">
      <font color="red">首页滚动商品标题</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>广告词</strong> <br/>
	  </th>
      <td>
      <input name="discount_ad" id="discount_ad" value="<?php if($itemInfo){echo $itemInfo['discount_ad'];} ?>" size="80"  class="input_blur" type="text">
      <font color="red">首页滚动商品标题后面的广告词</font>
	</td>
	</tr>
 	<tr>
      <th width="20%">
      <strong>限时打折活动起止时间</strong> <br/>
	  </th>
      <td>
     <input class="input_blur" name="discount_add_time" id="discount_add_time"  size="21" readonly="readonly" type="text"/>
	<script language="javascript" type="text/javascript">
	    datetime = "<?php if(! empty($itemInfo)){ echo date('Y-m-d H:i:s', $itemInfo['discount_add_time']);} ?>";
		date = new Date();
		if (datetime == "" || datetime == null) {
			datetime = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
		}
		document.getElementById ("discount_add_time").value =datetime;
		Calendar.setup({
			inputField     :    "discount_add_time",
			ifFormat       :    "%Y-%m-%d %H:%M:%S",
			showsTime      :    true,
			timeFormat     :    "24"
		});
	</script>至
	<input class="input_blur" name="discount_end_time" id="discount_end_time"  size="21" readonly="readonly" type="text"/>&nbsp;
	<script language="javascript" type="text/javascript">
	    datetime = "<?php if(! empty($itemInfo)){ echo date('Y-m-d H:i:s', $itemInfo['discount_end_time']);} ?>";
		date = new Date();
		if (datetime == "" || datetime == null) {
			datetime = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
		}
		document.getElementById ("discount_end_time").value =datetime;
		Calendar.setup({
			inputField     :    "discount_end_time",
			ifFormat       :    "%Y-%m-%d %H:%M:%S",
			showsTime      :    true,
			timeFormat     :    "24"
		});
	</script>
	</td>
	</tr>
    <tr>
      <th width="20%">
      <strong>在销售价基础上打多少折</strong> <br/>
	  </th>
      <td>
      <input name="discount_percent" id="discount_percent" value="<?php if($itemInfo){echo $itemInfo['discount_percent'];} ?>" size="80"  class="input_blur" type="text"><br/><font color="red">注：“100”表示不打折，“0”表示商品免费，“95”表示打九五折，“9”表示打九折，以次类推</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>限时打折广告内容</strong> <br/>
	  </th>
      <td>
<?php echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
<script id="discount_content" name="discount_content" type="text/plain" style="width:800px;height:200px;"><?php if(! empty($itemInfo)){ echo html($itemInfo["discount_content"]);}else{echo "";} ?></script>
<script type="text/javascript">
    UE.getEditor('discount_content');
</script>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>是否开启打折活动功能</strong> <br/>
	  </th>
      <td>
      <input type="radio" value="0" name="discount_open" class="radio_style" <?php if($itemInfo){if($itemInfo['discount_open']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 关闭
      <input type="radio" value="1" name="discount_open" class="radio_style" <?php if($itemInfo){if($itemInfo['discount_open']=='1'){echo 'checked="checked"';}} ?> > 开启
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
<br/><br/>