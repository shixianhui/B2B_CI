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
<div style="background:url(css/default/<?php echo $style; ?>/images/shop_floor_ad.png) no-repeat center; height:180px;"></div>
<div class="shop-ad">
	<ul>
<?php $ad_store_list = $this->advdbclass->get_ad_store_list(2, $store_id, 1);
if ($ad_store_list) {
foreach ($ad_store_list as $key=>$item) {
	?>
		<li>
			<a href="<?php echo $item['url']; ?>" target="_blank"><img alt="<?php echo clearstring($item['ad_text']); ?>" src="<?php echo $item['path'] ?>"></a>
		</li>
<?php }} ?>
	</ul>
</div>
<div class="shop-main-product clearfix">
	<ul>
		<?php
//		$item_list = $this->advdbclass->get_cus_product_list('', 12, $store_id);
//        $CI =& get_instance();
//        $CI->load->model('Attachment_model','',true);
//        if($item_list){
//            foreach($item_list as $item){
//                $url = getBaseUrl(false,'','product/detail/'.$item['id'].'.html',$client_index);
//                //主图拿第一张商品图
//                $attachment_list = NULL;
//                if ($item && $item['batch_path_ids']) {
//                    $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item['batch_path_ids']);
//                    $attachment_list = $CI->Attachment_model->gets4($tmp_atm_ids);
//                    if ($attachment_list){
//                        $item['path'] = $attachment_list[0]['path'];
//                    }
//                }
        if($recommend_product_list){
            foreach ($recommend_product_list as $item){
                $url = getBaseUrl(false,'','product/detail/'.$item['id'].'.html',$client_index);
            ?>
			<Li>
				<div class="picture">
					<a href="<?php echo $url;?>" target="_blank"><img alt="<?php echo clearstring($item['title']); ?>" class="lazy" data-original="<?php echo str_replace('.','_max.',$item['path']);?>" style="width:380px;"></a>
				</div>
				<div class="version">
					<div class="name">
						<a href="<?php echo $url;?>">
                            <?php echo my_substr($item['title'],20);?>
						</a>
					</div>
					<div class="price">销售价
						<font><small>¥</small>
							<?php echo $item['sell_price'];?>
						</font>
					</div>
					<a href="<?php echo $url;?>" class="btn" target="_blank">立即查看</a>
				</div>
			</Li>
			<?php }}?>
	</ul>
</div>
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