<?php echo $this->load->view("element/header_{$style}_tool", '', TRUE); ?>
<div class="warp">
	<div class="shop-intro mt20">
<?php $ad_store_list = $this->advdbclass->get_ad_store_list(1, $store_id, 1);
if ($ad_store_list) {
foreach ($ad_store_list as $key=>$item) {
	?>
		<img alt="<?php echo clearstring($item['ad_text']); ?>" src="<?php echo $item['path']; ?>">
<?php }} ?>
	    <div class="mask">
			<h2>店铺公告</h2><?php if ($item_info) {echo html($item_info['description']);} ?>
		</div>
	</div>
</div>
<section class="about">
	<div class="warp clearfix mt20">
		<div class="side fl">
			<div class="service-box">
				<?php if ($item_info) {echo $item_info['store_name'];} ?>
				<a href="http://wpa.qq.com/msgrd?uin=<?php if ($item_info) {echo $item_info['im_qq'];} ?>&amp;menu=yes" class="person" target="_blank"></a>
			</div>
			<div class="info-msg">
				<div class="score">
					<p>描述相符：<span><?php if ($item_info) {echo $item_info['des_grade'];} ?></span></p>
					<p>服务态度：<span><?php if ($item_info) {echo $item_info['serve_grade'];} ?></span></p>
					<p>发货速度：<span><?php if ($item_info) {echo $item_info['express_grade'];} ?></span></p>
				</div>
				<div class="link">
					<p>联系电话：<span><?php if ($item_info) {echo $item_info['contact_num'];} ?></span></p>
					<p>工作时间：<span><?php if ($item_info) {echo $item_info['work_time'];} ?></span></p>
					<p>所在地区：<span><?php if ($item_info) {echo $item_info['txt_address'].$item_info['address'];} ?></span></p>
					<p>商家认证：<span>已认证</span></p>
				</div>
				<a href="javascript:;" class="shop-ad">
					<img src="css/default/<?php echo $style; ?>/images/shop-ad.jpg" />
				</a>
				<ul class="sign-list">
					<li><img src="css/default/<?php echo $style; ?>/images/shop-ad1.jpg" /></li>
					<li><img src="css/default/<?php echo $style; ?>/images/shop-ad2.jpg" /></li>
					<li><img src="css/default/<?php echo $style; ?>/images/shop-ad3.jpg" /></li>
				</ul>
			</div>
		</div>
		<div class="main fr">
			<div class="evaluate">
				<table>
					<tr>
						<th class="rate" width="25%">好评率（100%）</th>
						<th width="15%">最近一周</th>
						<th width="17%">最近一个月</th>
						<th width="15%">最近6个月</th>
						<th width="17%">6个月前</th>
						<th>总计</th>
					</tr>
					<tr>
						<td class="good"><i></i>好评</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td class="normal"><i></i>中评</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td class="bad"><i></i>差评</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td class="all">总计</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
				</table>
			</div>
			<div class="evaluate-info mt20">
				<div class="control">
					<ul>
						<li class="active">全部评价</li>
						<li>好评(0)</li>
						<li>中评(0)</li>
						<li>差评(0)</li>
					</ul>
				</div>
				<div class="tab-wrap">

					<div class="tab-box clearfix" style="display: block;">
						<div class="tab-left">
							<i class="star"></i>
							<p>收货2天后评论</p>
							<p>2016-08-29 20:20</p>
							<p>1.8米床+床头柜*2+衣柜+床垫</p>
						</div>
						<div class="tab-center">我家的家具全套是全友的，用了10多年了，没有问题。这次新家装修家具必须还是全友的。质量没的说价格也划算非常值得推荐！</div>
						<div class="tab-right">
							<p>J***O<span>(匿名)</span></p>
							<p>黄金会员</p>
						</div>
					</div>

					<div class="tab-box clearfix">
						<div class="tab-left">
							<i class="star"></i>
							<p>收货3天后评论</p>
							<p>2016-08-29 20:20</p>
							<p>1.8米床+床头柜*2+衣柜+床垫</p>
						</div>
						<div class="tab-center">我家的家具全套是全友的，用了10多年了，没有问题。这次新家装修家具必须还是全友的。质量没的说价格也划算非常值得推荐！</div>
						<div class="tab-right">
							<p>J***O<span>(匿名)</span></p>
							<p>黄金会员</p>
						</div>
					</div>

					<div class="tab-box clearfix">
						<div class="tab-left">
							<i class="star"></i>
							<p>收货4天后评论</p>
							<p>2016-08-29 20:20</p>
							<p>1.8米床+床头柜*2+衣柜+床垫</p>
						</div>
						<div class="tab-center">我家的家具全套是全友的，用了10多年了，没有问题。这次新家装修家具必须还是全友的。质量没的说价格也划算非常值得推荐！</div>
						<div class="tab-right">
							<p>J***O<span>(匿名)</span></p>
							<p>黄金会员</p>
						</div>
					</div>

					<div class="tab-box clearfix">
						<div class="tab-left">
							<i class="star"></i>
							<p>收货5天后评论</p>
							<p>2016-08-29 20:20</p>
							<p>1.8米床+床头柜*2+衣柜+床垫</p>
						</div>
						<div class="tab-center">我家的家具全套是全友的，用了10多年了，没有问题。这次新家装修家具必须还是全友的。质量没的说价格也划算非常值得推荐！</div>
						<div class="tab-right">
							<p>J***O<span>(匿名)</span></p>
							<p>黄金会员</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="fix-service">
	<div class="link1">
		<i class="person"></i>
		<span>客服</span>
		<div class="person-box">
            <ul>
                <li>
                    <p><?php if ($item_info) {echo $item_info['store_name'];} ?></p>
                    <a href="http://wpa.qq.com/msgrd?uin=<?php if ($item_info) {echo $item_info['im_qq'];} ?>&amp;menu=yes" class="person-link" target="_blank"></a>
                </li>
                <li>
                    <p>在线客服</p>
                    联系客服
                    <a href="http://wpa.qq.com/msgrd?uin=<?php if ($item_info) {echo $item_info['im_qq'];} ?>&amp;menu=yes" class="person-link" target="_blank"></a>
                </li>
                <li>
                    <h4>工作时间</h4>
                    <h4><span><?php if ($item_info) {echo $item_info['work_time'];} ?></span></h4>
                </li>
                <li>
                    <h4>联系电话</h4>
                    <h4><?php if ($item_info) {echo $item_info['contact_num'];} ?></h4>
                </li>
            </ul>
		</div>
	</div>
	<div class="link2">
		<i class="up"></i>
	</div>
	</ul>
</section>