<?php echo $tool; ?>
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>订单状态跟踪</caption>
 	<tbody>
 	<?php if($ordersprocessList) { ?>
 	<?php foreach ($ordersprocessList as $ordersprocess) { ?>
	<tr>
      <th width="20%">
      <strong><?php echo date('Y-m-d H:i:s', $ordersprocess['add_time']); ?></strong> <br/>
	  </th>
      <td>
      <?php echo $ordersprocess['content']; ?>
	</td>
	<?php }} ?>
    </tr>
</tbody>
</table>
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>订单信息</caption>
 	<tbody> 	
	<tr>
      <th width="20%">
      <strong>订单编号</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['order_number'];} ?>
	</td>
    </tr>
    <tr>
        <th width="20%">
            <strong>店铺名称</strong> <br/>
        </th>
        <td>
            <?php if(! empty($itemInfo)){ echo $itemInfo['store_name'].'[编号：'.$itemInfo['store_id'].']';} ?>
        </td>
    </tr>

    <tr>
      <th> <strong>下单时间</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo date('Y-m-d H:i:s', $itemInfo['add_time']);} ?>
      </td>
    </tr>
    <tr>
      <th> <strong>订单状态</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $status[$itemInfo['status']];} ?>
          <?php  if($itemInfo['exchange_status'] != ''){ ?>&nbsp;<span style="color: #CCCCCC"><?php echo $exchange_status_arr[$itemInfo['exchange_status']]; ?></span><?php } ?>
      </td>
    </tr>
    <?php if(! empty($itemInfo) && $itemInfo['status'] >= 1){ ?>
        <tr>
            <th> <strong>付款方式</strong> <br/>
            </th>
            <td>
                <?php if(! empty($itemInfo)){ echo $itemInfo['payment_title'];} ?>
            </td>
        </tr>
    <?php } ?>
    <?php if(! empty($itemInfo) && $itemInfo['status'] == 4){ ?>
    <tr>
      <th> <strong>交易关闭原因</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['cancel_cause'];} ?>
      </td>
    </tr>
    <?php } ?>
</tbody>
</table>
<div id="myDiv">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>买家信息</caption>
 	<tbody> 	
	<tr>
      <th width="20%">
      <strong>会员名</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo) && $itemInfo['userInfo']){ echo $itemInfo['userInfo']['username'].'[编号:'.$itemInfo['userInfo']['id'].']';} ?>
	</td>
	<th width="20%">
      <strong>会员等级</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo) && $itemInfo['userInfo']){ echo $itemInfo['userInfo']['group_name'];} ?>
	</td>
    </tr>
    <tr>
      <th> <strong>昵称</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo) && $itemInfo['userInfo']){ echo $itemInfo['userInfo']['nickname'];} ?>
      </td>
      <th>
      <strong>真实姓名</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo) && $itemInfo['userInfo']){ echo $itemInfo['userInfo']['real_name'];} ?>
	</td>
    </tr>
    <tr>
      <th> <strong>QQ号</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo) && $itemInfo['userInfo']){ echo $itemInfo['userInfo']['qq_number'];} ?>
      </td>
      <th>
      <strong>邮件</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo) && $itemInfo['userInfo']){ echo $itemInfo['userInfo']['email'];} ?>
	</td>
    </tr>
</tbody>
</table>
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>商品信息</caption>
 	<tbody> 	
	<tr>
    <th class="align_c" scope="col"><strong>宝贝</strong></th>
    <th class="align_c" scope="col" width="150"><strong>宝贝属性</strong></th>
    <th class="align_c" scope="col" width="90"><strong>单价</strong></th>
    <th class="align_c" scope="col" width="90"><strong>数量</strong></th>
    <th class="align_c" scope="col" width="90"><strong>商品总价</strong></th>
  </tr>
  <?php if ($itemInfo && $itemInfo['productList']) {
        foreach ($itemInfo['productList'] as $key=>$product) {
  	?>
  <tr>
    <td class="align_c"><?php echo $product['product_title']; ?><br/>产品编号：<?php echo $product['product_num']; ?></td>
    <td><?php echo getColorName(0); ?>：<?php echo $product['color_name']; ?><br/><?php echo getSizeName(0); ?>：<?php echo $product['size_name']; ?></td>
    <td class="align_c"><?php echo number_format($product['buy_price'], 2, '.', ''); ?></td>
    <td class="align_c"><?php echo $product['buy_number']; ?></td>
    <?php if ($key == 0) { ?>
    <td class="align_c" rowspan="<?php echo count($itemInfo['productList']); ?>"><?php if(! empty($itemInfo)){ echo number_format($itemInfo['productSum'], 2, '.', '');} ?></td>
    <?php } ?>
  </tr>
  <?php }} ?>
  <tr>
    <td colspan="5" style="text-align:right;height:40px;">订单总金额(含运费：<?php echo number_format($itemInfo['postage_price'], 2, '.', ''); ?> 含手续费：<?php echo number_format($itemInfo['payment_price'], 2, '.', ''); ?>)：<span style="font-size:18px; font-weight:bold;margin-right:20px;">+ <?php if(! empty($itemInfo)){ echo number_format($itemInfo['productSum'] + $itemInfo['payment_price'] + $itemInfo['postage_price'], 2, '.', '');} ?></span></td>   
  </tr>
  <tr>
    <td colspan="5" style="text-align:right;height:40px;">优惠：<span style="font-size:18px; font-weight:bold;margin-right:20px;">- <?php if(! empty($itemInfo)){ echo number_format($itemInfo['productSum'] + $itemInfo['payment_price'] + $itemInfo['postage_price'] - $itemInfo['total'], 2, '.', '');} ?></span></td>   
  </tr>
  <tr>
    <td colspan="5" style="text-align:right;height:40px;"><?php if(! empty($itemInfo) && $itemInfo['score']){ ?>订单交易成功可获赠积分：<span style="font-size:14px;color:#E36439;"><?php echo $itemInfo['score']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>实收款：<span style="font-size:18px; font-weight:bold;color:#E36439;margin-right:20px;"><?php if(! empty($itemInfo)){ echo number_format($itemInfo['total'], 2, '.', '');} ?></span></td>   
  </tr>
</tbody>
</table>
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>收货与物流信息</caption>
 	<tbody> 	
	<tr>
      <th width="20%"><strong>收货地址</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['buyer_name'];} ?> , 
      <?php if(! empty($itemInfo)){ echo $itemInfo['mobile'];} ?> , 
      <?php if(! empty($itemInfo)){ echo $itemInfo['phone'];} ?> , 
      <?php if(! empty($itemInfo)){ echo $itemInfo['address'];} ?> , 
      <?php if(! empty($itemInfo)){ echo $itemInfo['zip'];} ?>
	</td>
    </tr>
    <?php if(! empty($itemInfo) && $itemInfo['invoice']){ ?>
    <tr>
      <th width="20%"> <strong><font color="#ff4200">发票抬头</font></strong> <br/>
	  </th>
      <td>
      <?php echo $itemInfo['invoice']; ?>
      </td>
    </tr>
    <?php } ?>
    <tr>
      <th width="20%"> <strong>送货时间段</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo) && $itemInfo['delivery_time']){ echo $deliveryTime[$itemInfo['delivery_time']];} ?>
      </td>
    </tr>
    <tr>
      <th width="20%"> <strong>订单附言</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['remark'];} ?>
      </td>
    </tr>
    <tr>
      <th width="20%"> <strong>运送方式</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['postage_title'];} ?>
      </td>
    </tr>
	<tr>
      <th width="20%">
      <strong>物流公司名称</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['delivery_name'];} ?>
      </td>
    </tr>
	<tr>
      <th width="20%"> <strong>运单号</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['express_number'];} ?>
      </td>
    </tr>
    <tr>
      <td class="align_c" colspan="2"><input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button"></td>
    </tr>
</tbody>
</table>
</div>
<br/>
<input type="button" id="bt" onclick="javascript:printpage('myDiv')" class="button_style"  value="打印订单" />
<script language="javascript" type="text/javascript">
    function printpage(myDiv){
	    var newstr = document.getElementById(myDiv).innerHTML;
	    var oldstr = document.body.innerHTML;
	    document.body.innerHTML = newstr;
	    window.print();
	    document.body.innerHTML = oldstr;
	    
	    return false;
    } 
</script>
<br/><br/>