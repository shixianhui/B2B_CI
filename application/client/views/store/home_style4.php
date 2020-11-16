<?php echo $this->load->view("element/header_{$style}_tool", '', TRUE); ?>
<div class="warp">
			<div class="shop-intro mt20">
                                        <?php $ad_store_list = $this->advdbclass->get_ad_store_list(1, $store_id, 1);
if ($ad_store_list) {
foreach ($ad_store_list as $key=>$item) {
	?>
				<img alt="<?php echo clearstring($item['ad_text']); ?>" src="<?php echo $item['path']; ?>">
 <?php }} ?>
			</div>
			<div class="shop-content">
				<h2><span></span><p>精品推荐</p></h2>
				<ul class="">
                                                                    <?php $ad_store_list = $this->advdbclass->get_ad_store_list(2, $store_id, 10);
if ($ad_store_list) {
foreach ($ad_store_list as $key=>$item) {
	?>
					<li><a href="<?php echo $item['url'] ? $item['url'] : 'javascript:void(0)';?>"><img alt="<?php echo clearstring($item['ad_text']); ?>" src="<?php echo $item['path']; ?>"></a></li>
	                                <?php }} ?>
				</ul>
			</div>

		</div>