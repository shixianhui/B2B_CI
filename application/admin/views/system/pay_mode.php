<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>支付方式</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>支付方式内容</strong> <br/>
	  </th>
      <td>
<?php echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
<script id="pay_mode" name="pay_mode" type="text/plain" style="width:800px;height:200px;"><?php if(! empty($itemInfo)){ echo html($itemInfo["pay_mode"]);}else{echo "";} ?></script>
<script type="text/javascript">
    UE.getEditor('pay_mode');
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
<br/><br/>