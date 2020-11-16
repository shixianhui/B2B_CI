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
    	<div class="shop-btn">
		<a href="javascript:;" class="prev"><img src="css/default/<?php echo $style; ?>/images/prev.png"></a>
		<a href="javascript:;" class="next"><img src="css/default/<?php echo $style; ?>/images/next.png"></a>
	</div>
</div>
<div class="">
			
			<div class="shop-content warp">
				<div style="position:absolute;">
					<img src="css/default/<?php echo $style; ?>/images/xilie.png">
				</div>
				<h2><img src="css/default/<?php echo $style; ?>/images/shop_title.png"></h2>
                <?php $ad_store_list = $this->advdbclass->get_ad_store_list(2, $store_id, 1);
                if ($ad_store_list) {
                    foreach ($ad_store_list as $key=>$item) {
                        ?>
                        <a href="<?php echo $item['url']; ?>"><img src="<?php echo $item['path']; ?>" style="width: 1200px;height: 500px"></a>
                    <?php }} ?>
                <ul class="">
				<ul class="">
                    <?php
                    $item_list = $this->advdbclass->get_cus_product_list('a', 3, $store_id);
                    if($item_list){
                        foreach($item_list as $item){
                            $url = getBaseUrl(false,'','product/detail/'.$item['id'].'.html',$client_index);
                            ?>
                            <li>
                                <a href="<?php echo $url;?>"><img src="<?php echo str_replace('.','_thumb.',$item['path']);?>" style="height: 378px"></a>
                                <p><?php echo my_substr($item['title'],23);?></p>
                                <p>抢购价：￥<i style="font-size: 30px"><?php echo floatval($item['sell_price']);?></i></p>

                                <a class="buy-btn" href="<?php echo $url;?>">立即购买&gt;</a>
                            </li>
                        <?php }} ?>
				</ul>
				
				
			</div>
			<div class="picture" style="clear:both;background:url(css/default/<?php echo $style; ?>/images/shop_banner2.jpg)center no-repeat ; width:100%; overflow:hidden;height:700px;"></div>
			<div class="shop-content warp">
				
				<ul class="">

                    <?php
                    $item_list = $this->advdbclass->get_cus_product_list('', 6, $store_id);
                    if($item_list){
                        foreach($item_list as $item){
                            $url = getBaseUrl(false,'','product/detail/'.$item['id'].'.html',$client_index);
                            ?>
                            <li>
                                <a href="<?php echo $url;?>"><img src="<?php echo str_replace('.','_thumb.',$item['path']);?>" style="height: 378px"></a>
                                    <p><?php echo my_substr($item['title'],23);?></p>
                                    <p>抢购价：￥<i style="font-size: 30px"><?php echo floatval($item['sell_price']);?></i></p>

                                <a class="buy-btn" href="<?php echo $url;?>">立即购买&gt;</a>
                            </li>
                        <?php }} ?>

				</ul>
				
				
			</div>
		
		</div>
<script type="text/javascript">
 jQuery(".shop-Slide").find(function(){ 
 	jQuery(this).find(".prev,.next").stop(true,true).fadeTo("show",1) 
 },function(){ 
 	jQuery(this).find(".prev,.next").fadeOut() 
 });
 jQuery(".shop-Slide").slide({
 	titCell:".hd ul", mainCell:".bd ul", effect:"fold",  autoPlay:true, autoPage:true, trigger:"click",
 	startFun:function(i){
 		var curLi = jQuery(".shop-Slide .bd li").eq(i); 	
 		if( !!curLi.attr("_src") ){				
 			curLi.css("background-image",curLi.attr("_src")).removeAttr("_src") 
 		}			
 	}		
 });
 $(function () {
            $("img.lazy").lazyload({
                placeholder: "images/load.jpg", //加载图片前的占位图片
                effect: "fadeIn" //加载图片使用的效果(淡入)
            });
        });
</script>