<section class="warp">
<div  class="cart_border mt30">
 <div class="border_d clearfix">
 <div class="cart_success clearfix">
  <span class="icon"></span><p class="fl"><b>您的支付款已成功！</b>您的订单号：<?php if ($item_info) {echo $item_info['order_number'];} ?><br><a href="<?php echo getBaseUrl($html,"order/my_order_index.html","order/my_order_index.html",$client_index);?>" class="btn mt10">查看订单</a></p>
 </div>
</div>
</div>
</section>