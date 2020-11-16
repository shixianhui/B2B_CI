<link href="css/default/member.css?v=1.1" type="text/css" rel="stylesheet">
<section class="warp">
    <div  class="cart_border mt30">
        <div class="border_d clearfix">
            <div class="cart_success clearfix">
                <span class="icon"></span><p class="fl"><b>您已成功充值：</b><b><small>￥</small><?php if ($item_info) {echo $item_info['total_fee'];} ?></b>
                    <br>
                    您的交易单号：<?php if ($item_info) {echo $item_info['out_trade_no'];} ?>
                    <br><a href="<?php echo getBaseUrl(false, "", "user/my_financial_list/recharge_in.html",$client_index);?>" class="btn mt10">查看充值记录</a></p>
            </div>
        </div>
    </div>
</section>