<div class="m_main fr">
	<div class="m_center">
		<div class="sigh">
			<a class="sigh_icon"><img src="images/default/m_sigh.gif" /></a><span>订单状态：</span><em><?php if ($item_info){echo $status[$item_info['status']];} ?></em>
		</div>
	</div>
	<div class="m_orderwrap" style="margin-top:20px;">
		<div class="m_order">
			<div class="m_goods" style="background:#fff;">
				<table class="m_goodmess">
					<tbody>
						<tr style="border-bottom:1px solid #f60;">
							<td >商品信息</td>
							<td width="15%">单价（元）</td>
							<td width="7.6%">数量</td>
							<td width="16.2%">金额（元）</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="m_buyer" style="display:block;">
				<table class="m_buyermess">
					<tbody>
					<?php if ($item_info) { ?>
					<?php if ($item_info['orders_detail_list']) { ?>
					<?php foreach ($item_info['orders_detail_list'] as $key=>$value) {
						      $url = getBaseUrl($html, "", "product/detail/{$value['product_id']}.html", $client_index);
						?>
						<tr>
							<td >
								<div <?php if ($key+1 == count($item_info['orders_detail_list'])) {echo 'style="padding-bottom:20px;"';} ?> class="m_goodlist clearfix">
									<a href="<?php echo $url; ?>" target="_blank" class="m_good_pic m_good_picdif fl"><img src="<?php if ($value['path']) { echo preg_replace('/\./', '_thumb.', $value['path']);}else{echo 'images/default/load.jpg';} ?>" /></a>
									<p class="fl" style="width:400px;">
										<a href="<?php echo $url; ?>" target="_blank"><?php echo $value['product_title']; ?></a>
									</p>
									<?php if ($value['color_size_open']) { ?>
									<p class="fl" style="color:#999;width:400px;">
								    <?php echo $value['product_color_name']; ?>：<?php echo $value['color_name']; ?><br/>
								    <?php echo $value['product_size_name']; ?>：<?php echo $value['size_name']; ?>
								    </p>
									<?php } ?>
								</div>
							</td>
							<td width="15%">
								<div class="m_money">
									<em>￥<?php echo $value['buy_price']; ?></em>
								</div>
							</td>
							<td width="7.6%">
								<div class="m_no">
									<em><?php echo $value['buy_number']; ?></em>
								</div>
							</td>
							<td width="16.2%">
								<div class="m_price">
									<p>￥<?php echo number_format($value['buy_price']*$value['buy_number'], 2, '.', ''); ?></p>
								</div>
							</td>
						</tr>
					<?php }}} ?>
					<tr style="margin-top: 20px;">
					<td class="cart_legend" style="border-top:none;background: #f8f8f8 none repeat scroll 0 0;" colspan="4">
					<div class="fr mr20" style="color:#999999;font-size:14px;text-align:right;"><span style="margin-left:20px;">商品总价：￥<span><?php if ($item_info){echo $item_info['product_total'];} ?></span></span></div>
					</td>
					</tr>
					<tr>
					<td class="cart_legend" style="border-top:none;background: #f8f8f8 none repeat scroll 0 0;" colspan="4">
					<div class="fr mr20" style="color:#999999;font-size:14px;text-align:right;"><span style="margin-left:20px;">运费：￥<span><?php if ($item_info){echo $item_info['postage_price'];} ?></span></span></div>
					</td>
					</tr>
					<tr>
					<td class="cart_legend" style="border-top:none;background: #f8f8f8 none repeat scroll 0 0;" colspan="4">
					<div class="fr mr20" style="color:#999999;font-size:14px;text-align:right;"><span style="margin-left:20px;">税费：￥<span><?php if ($item_info){echo $item_info['taxation_total'];} ?></span></span></div>
					</td>
					</tr>
					<tr>
					<td class="cart_legend" style="border-top:none;background: #f8f8f8 none repeat scroll 0 0;" colspan="4">
					<div class="fr mr20" style="color:#999999;font-size:14px;text-align:right;"><span style="margin-left:20px;">支付手续费：￥<span><?php if ($item_info){echo $item_info['payment_price'];} ?></span></span></div>
					</td>
					</tr>
					<tr>
					<td class="cart_legend" style="border-top:none;background: #f8f8f8 none repeat scroll 0 0;" colspan="4">
					<div class="fr mr20" style="color:#999999;font-size:14px;text-align:right;"><span style="margin-left:20px;">优惠：－￥<span><?php if ($item_info){echo $item_info['discount_total'];} ?></span></span></div>
					</td>
					</tr>
					<tr>
					<td class="cart_legend" style="border-top:none;background: #f8f8f8 none repeat scroll 0 0;" colspan="4">
					<div class="fr mr20" style="color:#999999;font-size:14px;text-align:right;"><span style="margin-left:20px;">实付款：<span style="color: #f51a2f;">￥<?php if ($item_info){echo $item_info['total'];} ?></span></span></div>
					</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="m_address">
				<ul>
					<strong>收货信息</strong>
					<li><span style="display: inline-block;width:70px;text-align:right;">订单编号：</span><em>    <?php if ($item_info) {echo $item_info['order_number'];} ?></em></li>
					<li><span style="display: inline-block;width:70px;text-align:right;">成交时间：</span><em>    <?php if ($item_info) {echo date('Y-m-d H:i:s', $item_info['add_time']);} ?></em></li>
					<li><span style="display: inline-block;width:70px;text-align:right;">商家：</span><em>    <?php if ($item_info) {echo $item_info['store_name'];} ?></em></li>
					<li>&nbsp;&nbsp;收 货 人：<em>    <?php if ($item_info) {echo $item_info['buyer_name'];} ?></em></li>
					<li><span style="display: inline-block;width:70px;text-align:right;">手机号码：</span><em>    <?php if ($item_info) {echo $item_info['mobile'];} ?></em></li>
					<li><span style="display: inline-block;width:70px;text-align:right;">固定电话：</span><em>    <?php if ($item_info) {echo $item_info['phone'];} ?></em></li>
					<li><span style="display: inline-block;width:70px;text-align:right;">收货地址：</span><em>    <?php if ($item_info) {echo $item_info['txt_address'].$item_info['address'];} ?></em></li>
					<li><span style="display: inline-block;width:70px;text-align:right;">买家留言：</span><em>    <?php if ($item_info) {echo $item_info['remark'];} ?></em></li>
				</ul>
			</div>
			<div class="m_order_Track">
				<strong>订单跟踪</strong>
				<div class="m_information">
					<div>
						<p>处理时间</p>
					</div>
					<div>
						<p>订单处理</p>
					</div>
					<div>
						<p>&nbsp;</p>
					</div>
					<?php if ($item_info) { ?>
					<?php if ($item_info['orders_process_list']) { ?>
					<?php foreach ($item_info['orders_process_list'] as $key=>$value) { ?>
					<div>
						<p><?php echo date('Y-m-d H:i:s', $value['add_time']); ?></p>
					</div>
					<div>
						<p><?php echo $value['content']; ?></p>
					</div>
					<div>
						<p>&nbsp;</p>
					</div>
					<?php }}} ?>
				</div>
			</div>
		</div>
	</div>
</div>