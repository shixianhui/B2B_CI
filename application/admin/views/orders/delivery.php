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
      <th width="20%"> <strong>快递名称</strong> <br/>
	  </th>
      <td>
      <input name="delivery_name" id="delivery_name" size="30" valid="required" errmsg="快递名称不能为空！" class="input_blur" type="text" />
      </td>
    </tr>
    <tr>
      <th width="20%"> <strong>快递单号</strong> <br/>
	  </th>
      <td>
      <input name="express_number" id="express_number" size="30" valid="required" errmsg="快递单号不能为空！" class="input_blur" type="text" />
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 发货 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>