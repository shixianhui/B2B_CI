<?php $store_info = $this->advdbclass->get_store_info($store_id); ?>
	<div class="shop-head" <?php if ($store_info && $store_info['store_banner']) { ?>style="background:#f7f7f7 url(<?php echo $store_info['store_banner'];?>) no-repeat center center;"<?php } ?>>
			<div class="head-content">
                            <?php if ($store_info && $store_info['path']) { ?>
				<a class="advert" href="">
                                    <img src="<?php if($store_info){ echo $store_info['path'];}?>" class="logo" style="display: none">
                                </a>
                            	<?php } ?>
<!--				<a href="" class="shop-logo"><img src="css/default/--><?php //echo $style; ?><!--/images/shop_logo.png"></a>-->
				<ul class="head-link">
					<li>
						<a href=""><i><img src="css/default/<?php echo $style; ?>/images/shop_icon1.png"></i>查看直播</a>
					</li>
					<li>
						<a href=""><i><img src="css/default/<?php echo $style; ?>/images/shop_icon2.png"></i>手机店铺
							<div class="wechat"><img src="css/default/<?php echo $style; ?>/images/wechat.png"></div>
						</a>
					</li>
					<li>
                        <a href="javascript:void(0)" onclick="save_favorite('store', '<?php echo $store_id; ?>')"><i><img src="css/default/<?php echo $style; ?>/images/shop_icon3.png"></i><em id="fav_store_btn_span"><?php echo $store_info['is_favorite'] ? '取消收藏' : '收藏店铺'?></em></a>
                    </li>
				</ul>
			</div>
			<div class="mall-menu">
					<ul  class="nav">
			<li>
				<a href="<?php echo getBaseUrl(false, '', "store/home/{$store_id}.html", $client_index); ?>" <?php if ($this->uri->segment(2) == 'home' || $this->uri->segment(2) == 'product') {echo 'class="current"';} ?>>店铺首页</a>
			</li>
			<?php $navigation_list = $this->advdbclass->get_navigation_list($store_id, 7);
				  if ($navigation_list) {
				      foreach ($navigation_list as $key=>$item) {
				      	$selector = '';
				      	$url = '';
				      	if ($item['url']) {
				      		$url = $item['url'];
				      	} else {
				      		if ($this->uri->segment(2) == 'page' && $this->uri->segment(4) == $item['id']) {
				      			$selector = 'class="current"';
				      		}
				      		$url = getBaseUrl(false, '', "store/page/{$store_id}/{$item['id']}.html", $client_index);
				      	}
				?>
			<Li>
			<a href="<?php echo $url; ?>" <?php echo $selector; ?>><?php echo $item['title']; ?></a>
			</Li>
			<?php }} ?>
			<Li>
				<a href="<?php echo getBaseUrl(false, '', "store/credit/{$store_id}.html", $client_index); ?>" <?php if ($this->uri->segment(2) == 'credit') {echo 'class="current"';} ?>>信誉评价</a>
			</Li>
		</ul>
				</div>
			</div>