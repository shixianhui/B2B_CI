<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>购物流程</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>购物流程内容</strong> <br/>
	  </th>
      <td>
<?php echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
<script id="buy_process" name="buy_process" type="text/plain" style="width:800px;height:200px;"><?php if(! empty($itemInfo)){ echo html($itemInfo["buy_process"]);}else{echo "";} ?></script>
<script type="text/javascript">
    UE.getEditor('buy_process');
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