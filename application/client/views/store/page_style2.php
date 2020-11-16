<?php echo $this->load->view("element/header_{$style}_tool", '', TRUE); ?>
<div class="shop-Slide">
	<div class="bd">
		<ul>
<?php $ad_store_list = $this->advdbclass->get_ad_store_list(1, $store_id, 10);
if ($ad_store_list) {
foreach ($ad_store_list as $key=>$item) {
	?>
			<li _src="url(<?php echo $item['path']; ?>)" style="background:center 0 no-repeat;">
			<a target="_blank" href="<?php echo $item['url']; ?>"></a>
			</li>
<?php }} ?>
		</ul>
	</div>
	<div class="hd">
		<ul></ul>
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
</section>
<script type="text/javascript">
	jQuery(".shop-Slide").find(function() {
		jQuery(this).find(".prev,.next").stop(true, true).fadeTo("show", 1)
	}, function() {
		jQuery(this).find(".prev,.next").fadeOut()
	});
	jQuery(".shop-Slide").slide({
		titCell: ".hd ul",
		mainCell: ".bd ul",
		effect: "fold",
		autoPlay: true,
		autoPage: true,
		trigger: "click",
		startFun: function(i) {
			var curLi = jQuery(".shop-Slide .bd li").eq(i);
			if(!!curLi.attr("_src")) {
				curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")
			}
		}
	});
</script>