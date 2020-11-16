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
    <div class="hd"><ul></ul></div>	
    <div class="shop-btn">
        <a href="javascript:;" class="prev"><img src="css/default/<?php echo $style; ?>/images/prev.png"></a>
        <a href="javascript:;" class="next"><img src="css/default/<?php echo $style; ?>/images/next.png"></a>
    </div>
</div>
<div class="warp">

    <div class="shop-content">
        <h2><img src="css/default/<?php echo $style; ?>/images/shop-title1.png"></h2>
        <?php $ad_store_list = $this->advdbclass->get_ad_store_list(2, $store_id, 1);
        if ($ad_store_list) {
        foreach ($ad_store_list as $key=>$item) {
        ?>
        <a href="<?php echo $item['url']; ?>"><img src="<?php echo $item['path']; ?>" style="width: 1200px;height: 420px"></a>
        <?php }} ?>
        <ul class="">
          		<?php
		$item_list = $this->advdbclass->get_cus_product_list('', 12, $store_id);
//		$CI =& get_instance();
//		$CI->load->model('Attachment_model','',true);
		if($item_list){
                    foreach($item_list as $item){
                       $url = getBaseUrl(false,'','product/detail/'.$item['id'].'.html',$client_index);
//                        //主图拿第一张商品图
//                        $attachment_list = NULL;
//                        if ($item && $item['batch_path_ids']) {
//                            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item['batch_path_ids']);
//                            $attachment_list = $CI->Attachment_model->gets4($tmp_atm_ids);
//                            if ($attachment_list){
//                                $item['path'] = $attachment_list[0]['path'];
//                            }
//                        }
                   ?>  
            <li>
                <a href="<?php echo $url;?>"><img src="<?php echo str_replace('.','_thumb.',$item['path']);?>">
                    <p><?php echo my_substr($item['title'],20);?></p>
                    <p><span>热销价</span><i>￥</i><?php echo $item['sell_price'];?></p>
                </a>
            </li>
			<?php }}?>
        </ul>
        <h2><img src="css/default/<?php echo $style; ?>/images/shop-title2.png"></h2>
        <?php $ad_store_list = $this->advdbclass->get_ad_store_list(2, $store_id, 1,1);
        if ($ad_store_list) {
            foreach ($ad_store_list as $key=>$item) {
                ?>
                <a href="<?php echo $item['url']; ?>"><img src="<?php echo $item['path']; ?>" style="width: 1200px;height: 420px"></a>
            <?php }} ?>
        <ul class="">
            <?php
            $item_list = $this->advdbclass->get_cus_product_list('a', 8, $store_id);
            if($item_list){
                foreach($item_list as $item){
                    $url = getBaseUrl(false,'','product/detail/'.$item['id'].'.html',$client_index);
            ?>
            <li>
                <a href="<?php echo $url;?>"><img src="<?php echo str_replace('.','_thumb.',$item['path']);?>">
                    <p><?php echo my_substr($item['title'],20);?></p>
                    <p><span>热销价</span><i>￥</i><?php echo $item['sell_price'];?></p>
                </a>
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