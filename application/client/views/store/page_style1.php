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
			<div class="about-us">
				<?php if ($nav_info) {echo $nav_info['title'];} ?>
			</div>
			<div class="about-text mt20">
				<?php if ($nav_info) {echo html($nav_info['content']);} ?>
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
<!--					<h4>周六至周日   ：<span> 9：00-23：00</span></h4>-->
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