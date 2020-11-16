<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<input name="id" value="" type="hidden">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody> 	
	<tr>
      <th width="20%"><strong>订单编号</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['order_number'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>下单时间</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo date('Y-m-d H:i', $itemInfo['add_time']);} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>交易关闭的原因</strong> <br/>
	  </th>
      <td>
     <textarea name="cancel_cause" id="cancel_cause" rows="4" cols="50" valid="required" errmsg="请填交易关闭的原因！" class="textarea_style"></textarea>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 交易关闭 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>