<section class="warp">
<div class="order_count clearfix">
  <div class="tip"><span class="m_icon tip_icon"></span><h2>您的订单已提交成功，请及时完成支付！</h2>
  <?php if (count($item_list) > 1) { ?>
  <p>合并&nbsp;|&nbsp;2笔订单</p>
  <?php } ?>
  <P style="cursor: pointer;" onclick="javascript:show_detail();">订单详情<span class="m_icon arrow_icon"></span></P>
  </div>
  <div class="price">
  <ul>
  <Li><span>应付总金额：</span><em><?php echo $total; ?><small>元</small></em></Li>
  </ul>
  </div>
  <div class="clear"></div>
  <div style="display: none;" id="order_detail" class="info clearfix">
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="cart_table" >
<tr>
<th width="200" class="tac">订单号</th>
<th width="200" class="tac">店铺名称</th>
<th width="200" class="tac">金额（元）</th>
</tr>
<?php if ($item_list) { ?>
<?php foreach ($item_list as $key=>$value) { ?>
<tr>
<td><?php echo $value['order_number']; ?></td>
<td><?php echo $value['store_name']; ?></td>
<td><?php echo $value['total']; ?></td>
</tr>
<?php }} ?>
</table>
  </div>
</div>
<div  class="cart_pay mt30 clearfix">
 <span class="tit">选择支付方式</span>
  <div class="bank_pay mt30">
   <div class="hd clearfix">
    <ul>
    <Li>支付宝</Li>
    <Li>网银支付</Li>
    </ul>
   </div>
   <div class="bd clearfix">
    <div class="bank_list">
  <dl class="checkbox_item"><dd ><a href="javascript:viod(0);"><img src="images/default/pay_logo.png"></a></dd></dl>
  </div>
    <div class="bank_list">
  <dl class="checkbox_item"><dd ><a href="javascript:viod(0);"><img src="images/default/pay_logo1.png"></a></dd></dl>
  </div>
   </div>
    <div class="clear"></div>
   <a href="<?php echo getBaseUrl($html,"order/pay_result/{$order_ids}.html","order/pay_result/{$order_ids}.html",$client_index);?>" class="btn_pay fr mt30">支付</a>
  </div>
</div>
</section>
<div class="clear"></div>
<script language="javascript" type="text/javascript">
function show_detail() {
    if ($('#order_detail').is(':visible') == true) {
        $('#order_detail').hide();
    } else {
    	$('#order_detail').show();
    }
}
</script>