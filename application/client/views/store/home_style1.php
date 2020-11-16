<?php echo $this->load->view("element/header_{$style}_tool", '', TRUE); ?>
<div class="warp">
	<div class="shop-intro mt20">
<?php $ad_store_list = $this->advdbclass->get_ad_store_list(1, $store_id, 1);
if ($ad_store_list) {
foreach ($ad_store_list as $key=>$item) {
	?>
		<img alt="<?php echo clearstring($item['ad_text']); ?>" src="<?php echo $item['path']; ?>">
<?php }} ?>
<!--		<div class="mask">-->
<!--			<h2>店铺介绍</h2>--><?php //if ($item_info) {echo html($item_info['description']);} ?>
<!--		</div>-->
	</div>
	<div class="s225 fl">
		<div class="shop-info mt20 side">
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
	</div>
	<div class="s960 fr">
		<div class="shop-product mt20">
			<h2>产品展示<br><span>高品质的生活，高品位的享受</span></h2>

			<div class="activityBox">
				<span class="prev"></span>
				<div class="content">
					<div class="contentInner">
						<ul>
<?php $ad_store_list = $this->advdbclass->get_ad_store_list(2, $store_id, 10);
if ($ad_store_list) {
foreach ($ad_store_list as $key=>$item) {
	?>
							<li>
								<a href="<?php echo $item['url'] ? $item['url'] : 'javascript:void(0)';?>" target="_blank"><img alt="<?php echo clearstring($item['ad_text']); ?>" src="<?php echo $item['path']; ?>" /></a>
								<p>
									<a href="<?php echo $item['url'] ? $item['url'] : 'javascript:void(0)';?>" target="_blank"><?php echo $item['ad_text']; ?></a>
								</p>
							</li>
<?php }} ?>
						</ul>
					</div>
				</div>
				<span class="next"></span>
			</div>

		</div>
		<div class="shop-recommend mt20" style="height:auto;">
			<div class="tit">精品推荐</div>
			<ul>
				<?php
                //		$item_list = $this->advdbclass->get_cus_product_list('', 12, $store_id);
                //        if($item_list){
                //            foreach($item_list as $item){
                //                $url = getBaseUrl(false,'','product/detail/'.$item['id'].'.html',$client_index);
                if($recommend_product_list){
                    foreach ($recommend_product_list as $item){
                        $url = getBaseUrl(false,'','product/detail/'.$item['id'].'.html',$client_index);
            ?>
					<Li>
						<div class="picture">
							<a href="<?php echo $url;?>" target="_blank"><img alt="<?php echo clearstring($item['title']);?>" class="lazy" data-original="<?php echo str_replace('.','_thumb.',$item['path']);?>"></a>
							<div class="mask">
								<p class="nowrap fl">
									<?php echo $item['title'];?>
								</p><span class="fr"><a href="<?php echo $url;?>"><i><img src="css/default/<?php echo $style; ?>/images/shop_icon4.png"></i>分享</a><a href=""><i><img src="css/default/<?php echo $style; ?>/images/shop_icon5.png"></i>收藏</a></span></div>
						</div>
						<div class="version">
							<div class="price"><span class="fl"><s>原价：<?php echo $item['market_price'];?></s>销售价 ¥</span>
								<font>
									<?php echo $item['sell_price'];?>
								</font>
							</div>
							<a href="<?php echo $url;?>" class="btn" target="_blank">立即查看</a>
						</div>
					</Li>
					<?php }}?>

			</ul>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(".activityBox").slide({
		mainCell: ".contentInner ul",
		effect: "left",
		delayTime: 400
	});

	$('.shop-recommend ul li').mouseenter(function() {
		$(this).find('.mask').stop().animate({
			bottom: '0px',
			height: '35px'
		});
	})
	$('li').mouseleave(function() {
		$(this).find('.mask').stop().animate({
			bottom: '-35px',
			height: '0px'
		});

	})
</script>