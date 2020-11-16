<div class="member_right mt20">
	<div class="box_shadow clearfix m_border">
		<div class="member_title"><span class="bt">我的订单</span></div>
		<div class="m_order_head mt20">
			<ul style=" border-bottom:none;">
				<li>订单编号：<b class="c3"><?php if ($item_info) {echo $item_info['order_number'];} ?></b></li>
				<li>订单金额：<b class="red"><small>￥</small><?php if ($item_info) {echo number_format($item_info['total'], 2, '.', '');} ?></b></li>
				<li>状态：<b class="c3"><?php if ($item_info){echo $status[$item_info['status']];} ?></b></li>
			</ul>
		</div>
		<div class="order_step">
			<!-- 普通订单 -->
			<ul>
				<li>
					<span title="等待付款">
                            <b><?php echo date('Y-m-d H:i:s', $item_info['add_time']); ?></b><br>等待付款
                        </span>
					<span title="付款成功">
                            <b><?php if ($item_info['pay_time']){ echo date('Y-m-d H:i:s', $item_info['pay_time']);} ?></b><br>付款成功
                        </span>
					<span title="商品出库">
                            <b><?php if ($item_info['delivery_time']){ echo date('Y-m-d H:i:s', $item_info['delivery_time']);} ?></b><br>商品出库
                        </span>
					<span title="确认收货">
                            <b><?php if ($item_info['receiving_time']){ echo date('Y-m-d H:i:s', $item_info['receiving_time']);} ?></b><br>确认收货
                        </span>
				</li>
				<li class="process_icon processStep<?php echo $item_info['status']+1; ?>" title="订单流程进度条"></li>
			</ul>
		</div>
		<div class="clear"></div>
		<div class="m_title mt20"><span></span>订单信息</div>
		<div class="m_order_adder">
			<li><span>收货地址：</span>
				<font class="red"><?php if ($item_info) {echo $item_info['buyer_name'];} ?></font>&nbsp;&nbsp;<?php if ($item_info) {echo $item_info['mobile'];} ?>&nbsp;&nbsp;<?php if ($item_info) {echo $item_info['txt_address'].$item_info['address'];} ?>&nbsp;&nbsp;<?php if ($item_info) {echo $item_info['zip'];} ?></li>
			<li><span class="fl">支付方式及配送：</span><i class="fl">支付方式：	<?php if ($item_info) {echo $item_info['payment_title'];} ?><br>
配送方式：	<?php if ($item_info) {echo $item_info['postage_title'];} ?><br>
运   费：	<?php if ($item_info) {echo $item_info['postage_price'];} ?> 元</i></li>
			<li><span>买家留言：</span><?php if ($item_info) {echo $item_info['remark'];} ?></li>
		</div>
		<div class="m_title mt20"><span></span>商品信息</div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table">
			<tbody>
				<tr>
					<th width="37%" class="tal"><b>属性</b></th>
					<th width="15%"><b>单价（元）</b></th>
					<th width="10%"><b>数量</b></th>
                    <th width="13%" style="display: none" id="ex_t"><b>操作</b></th>
					<th width="18%" ><b>商品总价（元）</b></th>
					<th><b>运费</b></th>
				</tr>
				<?php if ($item_info) { ?>
				<?php if ($item_info['orders_detail_list']) { ?>
				<?php foreach ($item_info['orders_detail_list'] as $key=>$value) {
					      $url = getBaseUrl($html, "", "product/detail/{$value['product_id']}.html", $client_index);
				?>
				<tr>
					<td  valign="middle">
						<div class="info">
							<a href="<?php echo $url; ?>"><img src="<?php if ($value['path']) { echo preg_replace('/\./', '_thumb.', $value['path']);}else{echo 'images/default/load.jpg';} ?>"><?php echo $value['product_title']; ?>
								<?php if ($value['color_size_open']) { ?>
								<p class="c9">
								<?php echo $value['product_color_name']; ?>：<?php echo $value['color_name']; ?><br/>
								<?php echo $value['product_size_name']; ?>：<?php echo $value['size_name']; ?>
								</p>
							    <?php } ?>
							</a>
						</div>
					</td>
					<td align="center"><small>¥</small><?php echo $value['buy_price']; ?></td>
					<td align="center"><?php echo $value['buy_number']; ?></td>
                    <?php if ($item_info['status'] > 0 && $item_info['status'] < 3) { ?>
                        <?php if (!$value['exchange_info']['is_exchange']){ ?>
                    <td align="center" id="ex">
                            <p>
                                <a href="<?php echo getBaseUrl(false, "", "user/my_save_exchange/{$value['id']}.html", $client_index); ?>" class="m_btn">申请退款</a>
                            </p>
                    </td>
                        <?php }} ?>
                    <?php if ($value['exchange_info']['is_exchange']){ ?>
                    <td align="center" id="ex">
                        <p>
                            <a href="<?php echo getBaseUrl(false, "", "user/my_view_exchange/{$value['id']}.html", $client_index); ?>" class="m_btn">退款进度</a>
                        </p>
                    </td>
                    <?php } ?>
					<?php if ($key == 0) { ?>
					<td rowspan="<?php echo count($item_info['orders_detail_list']); ?>" align="center"><small>¥</small><?php echo $item_info['product_total']; ?></td>
					<td rowspan="<?php echo count($item_info['orders_detail_list']); ?>" align="center"><small>¥</small><?php echo $item_info['postage_price']; ?><br/>(快递)</td>
					<?php } ?>
				</tr>
				<?php }}} ?>
			</tbody>
		</table>
		<div class="m_title mt20"><span></span>物流信息</div>
		<div class="m_order_logistics">
			<ul>
				<li>
					<P><span>快递公司：</span><?php if ($item_info) {echo $item_info['delivery_name'];}  ?>&nbsp;</P>
					<P><span>递  单 号：</span><?php if ($item_info) {echo $item_info['express_number'];}  ?>&nbsp;</P>
				</li>
				<li style="display: none"><span class="fl">物流跟踪：</span>
					<p>2016-01-05 15:34:40 已出库<br> 2016-01-05 18:12:29 成都市【成都盐市口分部】，【2黄毅15102825321】已揽收<br> 2016-01-05 20:11:03 成都市【成都盐市口分部】，正发往【成都分拨中心】<br> 2016-01-05 22:33:36 到成都市【成都分拨中心】<br> 2016-01-05 22:45:55 成都市【成都分拨中心】，正发往【杭州分拨中心】<br> 2016-01-07 09:58:03 到杭州市【杭州分拨中心】<br> 2016-01-07 10:40:31 杭州市【杭州分拨中心】，正发往【下沙一部】<br> 2016-01-07 11:01:17 到杭州市【下沙一部】<br> 2016-01-07 12:18:13 杭州市【下沙一部】，正发往【下沙金沙居分部】<br> 2016-01-07 14:12:11 杭州市【下沙金沙居分部】，【鲍增强/18069827805】正在派件<br> 2016-01-07 14:12:11 到杭州市【下沙金沙居分部】<br> 2016-01-07 20:42:57 杭州市【下沙金沙居分部】，前台李女士 已签收</p>
				</li>
			</ul>
		</div>
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        if($('#ex').length){
            $('#ex_t').show();
        }
    });
</script>