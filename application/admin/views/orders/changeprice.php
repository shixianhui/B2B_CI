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
      <th width="20%"><strong>总金额</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo number_format($itemInfo['total'], 2, '.', '');} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>总金额修改为</strong> <br/>
	  </th>
      <td>
      <input name="total" id="total" size="30" class="input_blur" valid="required|isMoney" errmsg="修改价格不能为空!|修改价格必须为钱数！" type="text" />
      <span id="jianshenPice"></span>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 修改价格 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$("#total").change(function(){
		$total = '<?php if(! empty($itemInfo)){ echo $itemInfo['total'];} ?>';
    	$changePrice = $("#total").val();
    	$jianshenPice = $total - $changePrice;
    	$("#jianshenPice").html('总共节省：'+$jianshenPice+" <font color='red'>元</font>");
	});
});
</script>