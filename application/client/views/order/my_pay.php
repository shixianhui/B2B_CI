<section class="warp">
	<div class="cart_repeat mt25">
		<div class="bar clearfix">
			<h3 class="fl"><span class="icon"></span>您的订单已提交成功，请尽 快付款！
  <p>请您在提交订单后24小时内完成支付，否则订单会自动取消。</p>
                <?php if (count($item_list) > 1) { ?>
                    <p>共<?php echo count($item_list);?>笔订单</p>
                <?php } ?></h3>
			<span class="price fr">应付金额：<b class="red f18"><?php echo $total; ?></b>元</span>
		</div>
        <div class="clear"></div>
        <div class="info clearfix">
            <table border="0" cellspacing="0" cellpadding="0" width="100%" class="cart_table" style="width: 100%;">
                <tbody style="width: 75%">
                <tr>
                    <th width="200" class="tac" style="text-align: center">订单号</th>
                    <th width="200" class="tac" style="text-align: center">店铺名称</th>
                    <th width="200" class="tac" style="text-align: center">金额（元）</th>
                    <th width="200" class="tac" style="text-align: center">操作</th>
                </tr>
                <?php if ($item_list) { ?>
                    <?php foreach ($item_list as $key=>$value) { ?>
                        <tr>
                            <td><?php echo $value['order_number']; ?></td>
                            <td><?php echo $value['store_name']; ?></td>
                            <td><?php echo $value['total']; ?></td>
                            <td>
                                <?php if ($value['status'] == 0) { ?>
                                    <a href="<?php echo getBaseUrl(false,'','order/my_go_to_pay/'.$value['id'].'.html', $client_index);?>" target="_blank">去付款</a>
                                <?php } else {echo '----';} ?>
                            </td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
	</div>
</section>