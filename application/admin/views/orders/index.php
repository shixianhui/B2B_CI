<?php echo $tool; ?>
<form method="post" action="admincp.php/orders/index/<?php echo $statusPrema; ?>">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>信息查询</caption>
<tbody>
<tr>
<td class="align_c">
    订单类型 <select name="order_type">
        <option value="">请选择</option>
        <?php
          foreach($order_type_arr as $key=>$item){
        ?>
        <option value="<?php echo $key;?>"><?php echo $item;?></option>
          <?php }?>
    </select>
    订单编号 <input class="input_blur" name="order_number" id="order_number" size="20" type="text">&nbsp;
收货人姓名 <input class="input_blur" name="buyer_name" id="buyer_name" size="20" type="text">&nbsp;
发布时间 <input class="input_blur" name="inputdate_start" id="inputdate_start" size="10" readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
					date = new Date();
					Calendar.setup({
						inputField     :    "inputdate_start",
						ifFormat       :    "%Y-%m-%d",
						showsTime      :    false,
						timeFormat     :    "24"
					});
				 </script> - <input class="input_blur" name="inputdate_end"
id="inputdate_end" size="10"  readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
					date = new Date();
					Calendar.setup({
						inputField     :    "inputdate_end",
						ifFormat       :    "%Y-%m-%d",
						showsTime      :    false,
						timeFormat     :    "24"
					});
				 </script>&nbsp;
<input class="button_style" name="dosubmit" value=" 查询 " type="submit">
</td>
</tr>
</tbody>
</table>
</form>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="80">选中</th>
<th width="80">订单编号</th>
<th width="80">收货人信息</th>
<th>订单描述</th>
<th width="120">总金额</th>
<th width="80">下单时间</th>
<th width="80">订单状态</th>
<th width="100">管理操作</th>
</tr>
<?php if (! empty($ordersList)): ?>
<?php foreach ($ordersList as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background=''">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox">  <?php echo $value['id']; ?></td>
<td class="align_c"><?php echo $value['order_number'] ?></td>
<td class="align_c" title="<?php echo clearstring($value['address']); ?>"><?php echo my_substr($value['address'], 4); ?><br/><?php echo $value['buyer_name']; ?></td>
<td class="align_c">
<table cellpadding="0" cellspacing="1">
<?php if ($value['orderdetailList']) { ?>
<?php foreach ($value['orderdetailList'] as $key=>$orderdetail) {
	  $strClass = 'table_td';
      if ($key+1 == count($value['orderdetailList'])) {
          $strClass = '';
      }
	?>
<tr>
<td class="<?php echo $strClass; ?>">
<span><?php echo $orderdetail['product_title']; ?></span><br/>
产品编号：<?php echo $orderdetail['product_num']; ?><br/>
<?php echo getColorName(0); ?>：<?php echo $orderdetail['color_name']; ?> <?php echo getSizeName(0); ?>：<?php echo $orderdetail['size_name']; ?>
</td>
<td class="<?php echo $strClass; ?>" width="40" class="align_c"><?php echo number_format($orderdetail['buy_price'], 2, '.', ''); ?></td>
<td class="<?php echo $strClass; ?>" width="20" class="align_c"><?php echo $orderdetail['buy_number']; ?></td>
</tr>
<?php }} ?>
</table>
</td>
<td class="align_c"><span class="priceColor"><?php echo number_format($value['total'], 2, '.', ''); ?></span>
<?php if ($value['postage_price'] != 0) { ?>
<br/>(含运费：<?php echo number_format($value['postage_price'], 2, '.', ''); ?>
<?php } else { ?>
<br/>(含运费：免运费 
<?php } ?>
<?php if ($value['payment_price'] != 0) { ?>
<br/>含手续：<?php echo number_format($value['payment_price'], 2, '.', ''); ?>
<?php } ?>
)
</td>
<td class="align_c"><?php echo date("Y-m-d H:i", $value['add_time']); ?></td>
<td class="align_c"><?php echo $status[$value['status']]; ?>
    <?php  if($value['exchange_status'] != ''){ ?><p style="color: #CCCCCC"><?php echo $exchange_status_arr[$value['exchange_status']]; ?></p><?php } ?>
</td>
<td class="align_c">
<?php if ($value['status'] == 0) { ?>
<span style="line-height:25px;"><a href="javascript:changeStatus2(<?php echo $value['id']; ?>);" title="用于线下付款修改订单状态">状态改为已付款</a></span><br/>
<span style="line-height:25px;"><a href="admincp.php/orders/changePrice/<?php echo $value['id']; ?>">修改价格</a></span><br/>
<span style="line-height:25px;"><a href="admincp.php/orders/closeOrder/<?php echo $value['id']; ?>">交易关闭</a></span><br/>
<?php } else if ($value['status'] == 1) { ?>
<span style="line-height:25px;"><a href="admincp.php/orders/delivery/<?php echo $value['id']; ?>">发货</a></span><br/>
<?php } else if ($value['status'] == 2) {  ?>
<span style="line-height:25px;"><a href="javascript:changeReceiving(<?php echo $value['id']; ?>);">确认收货</a></span><br/>
<?php } ?>
<span style="line-height:25px;"><a href="admincp.php/orders/view/<?php echo $value['id']; ?>">详情</a></span></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div class="button_box">
<span style="width: 60px;"><a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
<a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a></span>
<input class="button_style" name="delete" id="delete" value=" 删除 "  type="button">
</div>
<div id="pages" style="margin-top: 5px;">
<?php echo $pagination; ?>
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
</div>
<br/><br/>
<script language="javascript" type="text/javascript">
//备货中
//function changeStatus(id) {
//	$.post("admincp.php/orders/changeStatus",
//			{	"id":id
//			},
//			function(res){
//				if(res.success){
//					window.location.reload();
//					return false;
//				}else{
//					alert(res.message);
//					return false;
//				}
//			},
//			"json"
//	);
//}
//已付款
function changeStatus2(id) {
	var con = confirm("确定要将此订单状态修改为“已付款”？修改后将不可恢复！");
	if (con == true) {
		$.post("admincp.php/orders/changeStatus2", 
				{	"id":id 
				},
				function(res){
					if(res.success){
						window.location.reload();
						return false;
					}else{
						alert(res.message);
						return false;
					}
				},
				"json"
		);
	}
}
//确认收货
function changeReceiving(id) {
	var con = confirm("确定进行“确认收货”？");
	if (con == true) {
		$.post("admincp.php/orders/receiving", 
				{	"id":id
				},
				function(res){
					if(res.success) {
						window.location.reload();
						return false;
					} else {
						alert(res.message);
						return false;
					}
				},
				"json"
		);
	}	
}
</script>