<style type="text/css">
	.click_1{width:750px; height:140px !important;top:200px;position:absolute;left:50%;margin-left:-375px;}
	.click_2{width:270px; height:120px !important;bottom:0;left:;position:absolute;left:50%;margin-left:-375px;}
	.click_3{width:270px; height:120px !important;bottom:0;position:absolute;right:50%;margin-right:-375px;}
</style>

<?php $adList = $this->advdbclass->getAd(1, 10);
if ($adList) { ?>
<div class="fullSlide">
	<div class="bd">
		<ul>
			<?php foreach ($adList as $ad) { ?>
			<li _src="url(<?php echo $ad['path']; ?>)" style="background:center 0 no-repeat;">
				<?php if ($ad['id'] == 44) { ?>
				<a class="click_1" href="javascript:;"></a>
				<a class="click_2" href="javascript:;"></a>
				<a class="click_3" href="javascript:;"></a>
				<?php } else { ?>
				<a target="_blank" href="<?php echo $ad['url']; ?>"></a>
				<?php } ?>
			</li>
			<?php } ?>
		</ul>
	</div>
	<div class="hd">
		<ul></ul>
	</div>
	<?php $adList2 = $this->advdbclass->getAd(2, 2); ?>
	<?php if ($adList2) { ?>
	<div class="right-sidebar">
		<ul>
			<?php foreach ($adList2 as $ad2) { ?>
			<Li>
				<a href="<?php echo $ad2['url']; ?>" target="_blank"><img alt="<?php echo clearstring($ad2['ad_text']); ?>" src="<?php echo $ad2['path']; ?>"></a>
			</Li>
			<?php } ?>
		</ul>
	</div>
	<?php } ?>
</div>
<?php } ?>
<section class="floorList">
	<div class="floor-business fl mt20">
		<div class="tit"><span class="bt">实体商家<small>线上看款，实体体验无误差！</small></span>
			<a onclick="javascript:flush_store('c');" href="javascript:void(0);" class="more">换一批<i class="icon"></i></a>
		</div>
		<ul id="store_c">
		<?php $store_list = $this->advdbclass->get_cus_store_list('c', 4); ?>
		<?php if ($store_list) { ?>
		<?php foreach ($store_list as $key=>$value) {
			      $url = getBaseUrl($html, "", "store/home/{$value['id']}.html", $client_index);
			?>
			<Li>
				<a href="<?php echo $url; ?>"><img alt="<?php echo clearstring($value['store_name']); ?>" data-original="<?php echo preg_replace('/\./', '_thumb.', $value['index_path']); ?>" class="picture lazy"><span><img alt="<?php echo clearstring($value['store_name']); ?>" src="<?php echo preg_replace('/\./', '_thumb.', $value['logo_path']); ?>"></span></a>
			</Li>
		<?php }} ?>
		</ul>
	</div>
	<div class="floor-business fr mt20">
		<div class="tit"><span class="bt">实力电商<small>根据喜欢，精选位您推荐！</small></span>
			<a onclick="javascript:flush_store('a');" href="javascript:void(0);" class="more">换一批<i class="icon"></i></a>
		</div>
		<ul id="store_a">
		<?php $store_list = $this->advdbclass->get_cus_store_list('a', 4); ?>
		<?php if ($store_list) { ?>
		<?php foreach ($store_list as $key=>$value) {
			      $url = getBaseUrl($html, "", "store/home/{$value['id']}.html", $client_index);
			?>
			<Li>
				<a href="<?php echo $url; ?>"><img alt="<?php echo clearstring($value['store_name']); ?>" data-original="<?php echo preg_replace('/\./', '_thumb.', $value['index_path']); ?>" class="picture lazy"><span><img alt="<?php echo clearstring($value['store_name']); ?>" src="<?php echo preg_replace('/\./', '_thumb.', $value['logo_path']); ?>"></span></a>
			</Li>
		<?php }} ?>
		</ul>
	</div>
	<div class="floor"></div>
<?php $menu_tree_list = $this->advdbclass->getMenuList(294); ?>
<?php if ($menu_tree_list) { ?>
<?php foreach ($menu_tree_list as $key=>$item) {
	?>
	<div class="floor">
		<div class="floor-tit mt30">
			<span class="bt"><?php echo $item['menu_name']; ?><small><?php echo $item['en_menu_name']; ?></small></span>
			<span class="more">
			<!-- 顶部分类 -->
			<?php $top_menu_list = $this->advdbclass->getMenuList($item['id'], 'navigation', 12);?>
			<?php if ($top_menu_list) { ?>
			<?php foreach ($top_menu_list as $sub_key=>$sub_item) { ?>
			<a href="<?php echo $sub_item['url']; ?>"><?php echo $sub_item['menu_name']; ?></a>
			<?php }} ?>
			</span>
		</div>
		<div class="floor-ad mt10 fl">
			<div class="ad-picture">
			<!-- 左侧广告 -->
			<?php $left_ad_list = $this->advdbclass->getAd($left_ad_id_arr[$key], 1); ?>
			<?php if ($left_ad_list) { ?>
			<?php foreach ($left_ad_list as $a_key=>$a_value) { ?>
				<a href="<?php echo $a_value['url']; ?>"><img alt="<?php echo clearstring($a_value['ad_text']); ?>" src="<?php echo $a_value['path']; ?>"></a>
			<?php }} ?>
			</div>
			<div class="ad-menu">
				<ul class="txt-nav clearfix">
				<!-- 底部分类 -->
				<?php $footer_menu_list = $this->advdbclass->getMenuList($item['id'], 'footer', 12); ?>
				<?php if ($footer_menu_list) { ?>
			    <?php foreach ($footer_menu_list as $sub_key=>$sub_item) { ?>
					<li>
						<a href="<?php echo $sub_item['url']; ?>"><?php echo $sub_item['menu_name']; ?></a>
					</li>
				<?php }} ?>
				</ul>
				<ul class="pic-nav">
				<!-- 品牌 -->
				<?php $brand_list = $this->advdbclass->get_brand_list($item['brand_ids']); ?>
				<?php if ($brand_list) { ?>
				<?php foreach ($brand_list as $b_key=>$b_item) { ?>
					<Li>
						<a href="<?php echo getBaseUrl($html, "", "product/index/80-{$b_item['id']}.html", $client_index); ?>"><img width="129px" height="60px"  src="<?php echo preg_replace('/\./', '_thumb.', $b_item['path']); ?>"></a>
					</Li>
				<?php }} ?>
				</ul>
			</div>
		</div>
		<?php if (($key+1)%2 != 0) { ?>
		<div class="floor-section mt10 fl">
			<div class="floor-slide fl">
				<div class="hd">
				<?php $lb_ad_list = $this->advdbclass->getAd($lb_ad_id_arr[$key], 10); ?>
					<ul>
					<?php if ($lb_ad_list) { ?>
					<?php foreach ($lb_ad_list as $a_key=>$a_value) { ?>
						<li></li>
					<?php }} ?>
					</ul>
				</div>
				<div class="bd">
					<ul>
			<!-- 轮播广告 -->
			<?php if ($lb_ad_list) { ?>
			<?php foreach ($lb_ad_list as $a_key=>$a_value) { ?>
						<li>
							<a href="<?php echo $a_value['url']; ?>"><img alt="<?php echo clearstring($a_value['ad_text']); ?>" src="<?php echo $a_value['path']; ?>" /></a>
						</li>
			<?php }} ?>
					</ul>
				</div>
			</div>
			<div class="floor-porduct w450 fl">
				<ul>
				<?php $product_list = $this->advdbclass->get_product_list($item['product_category_ids'], $item['id'], 4, 'RAND()'); ?>
				<?php if ($product_list) { ?>
				<?php foreach ($product_list as $p_key=>$p_value) {
					  $url = getBaseUrl($html, "", "product/detail/{$p_value['id']}.html", $client_index);
					?>
					<li class="clearfix">
						<div class="picture">
							<a href="<?php echo $url; ?>"><img alt="<?php echo clearstring($p_value['title']); ?>" data-original="<?php echo preg_replace('/\./', '_thumb.', $p_value['path']); ?>" class="picture lazy"></a>
						</div>
						<div class="property">
							<a href="<?php echo $url; ?>" class="nowrap" title="<?php echo clearstring($p_value['title']); ?>"><?php echo $p_value['title']; ?></a><span class="price"><small>￥</small><?php echo $p_value['sell_price']; ?></span></div>
					</li>
				<?php }} ?>
				</ul>
			</div>
		</div>
		<?php } else { ?>
		<div class="floor-section mt10 fl">
			<div class="floor-porduct fl">
				<ul>
					<div class="floor-slide1 fl">
						<div class="hd">
							<ul>
				    <?php $lb_ad_list = $this->advdbclass->getAd($lb_ad_id_arr[$key], 10); ?>
					<?php if ($lb_ad_list) { ?>
					<?php foreach ($lb_ad_list as $a_key=>$a_value) { ?>
						<li></li>
					<?php }} ?>
							</ul>
						</div>
						<div class="bd">
							<ul>
			<!-- 轮播广告 -->
			<?php if ($lb_ad_list) { ?>
			<?php foreach ($lb_ad_list as $a_key=>$a_value) { ?>
						<li>
							<a href="<?php echo $a_value['url']; ?>"><img alt="<?php echo clearstring($a_value['ad_text']); ?>" src="<?php echo $a_value['path']; ?>" /></a>
						</li>
			<?php }} ?>
							</ul>
						</div>
					</div>
				<?php $product_list = $this->advdbclass->get_product_list($item['product_category_ids'], $item['id'],6, 'RAND()'); ?>
				<?php if ($product_list) { ?>
				<?php foreach ($product_list as $p_key=>$p_value) {
					  $url = getBaseUrl($html, "", "product/detail/{$p_value['id']}.html", $client_index);
					?>
					<li class="clearfix">
						<div class="picture">
							<a href="<?php echo $url; ?>"><img alt="<?php echo clearstring($p_value['title']); ?>" data-original="<?php echo preg_replace('/\./', '_thumb.', $p_value['path']); ?>" class="picture lazy"></a>
						</div>
						<div class="property">
							<a href="<?php echo $url; ?>" title="<?php echo clearstring($p_value['title']); ?>" class="nowrap"><?php echo $p_value['title']; ?></a><span class="price"><small>￥</small><?php echo $p_value['sell_price']; ?></span>
						</div>
					</li>
				<?php }} ?>
				</ul>
			</div>
		</div>
		<?php } ?>
	</div>
<?php }} ?>
</section>
<script type="text/javascript">
function flush_store(type) {
	$.get("<?php echo base_url(); ?>index.php/store/get_rand_store_list/"+type,
			{},
			function(res){
				if(res.success){
					var html = '';
					for (var i = 0, data = res.data.item_list, len = data.length; i < len; i++){
						html += '<Li>';
						html += '<a href="'+data[i].url+'"><img alt="'+data[i].store_name+'" data-original="'+data[i].index_path_thumb+'" class="picture lazy"><span><img alt="'+data[i].store_name+'" src="'+data[i].logo_path_thumb+'"></span></a>';
						html += '</Li>';
					}
					$('#store_'+type).html(html);
					$(function () {
			            $("img.lazy").lazyload({
			                placeholder: "images/default/load.jpg", //加载图片前的占位图片
			                effect: "fadeIn" //加载图片使用的效果(淡入)
			            });
			        });
					return false;
				}
			},
			"json"
	);
}
</script>