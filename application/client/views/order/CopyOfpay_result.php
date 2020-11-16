<section class="warp">
<div class="cart_success clearfix mt30">
  <span class="m_icon"></span><p >您已成功支付金额：<b><small>￥</small><?php echo $total; ?></b>
  <br>
  您的订单号：
  <?php if ($item_list) { ?>
  <?php foreach ($item_list as $key=>$value) { ?>
  <?php echo $value['order_number']; ?><?php if ($key+1 != count($item_list)) {echo '；';}  ?>
  <?php }} ?>
  <br><a href="<?php echo getBaseUrl($html,"order/my_order_index.html","order/my_order_index.html",$client_index);?>" class="btn mt10">查看订单</a></p>
 </div>
</section>
<div class="clear"></div>