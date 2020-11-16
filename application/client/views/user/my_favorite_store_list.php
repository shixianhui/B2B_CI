<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">收藏店铺</span></div>
        <div class="member_tab mt20">
            <div class="member_shop">
                <?php
                 if($item_list){
                     foreach($item_list as $item){
                ?>
                <dl>
                    <dt><div class="b_logo"><img src="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"></div><div class="btn"><a target="_blank" href="<?php echo getBaseUrl(false, "", "store/home/{$item['item_id']}.html", $client_index);?>">进入店铺</a><a href="javascript:delete_favorite(<?php echo $item['id'];?>)">取消收藏</a></div></dt>
                    <dd>
                        <ul class="member_shop_item">
                            <?php
                                 if($item['product_list']){
                                     foreach($item['product_list'] as $ls){
                                           $url = getBaseUrl(false, "", "product/detail/{$ls['id']}.html", $client_index);
                            ?>
                            <li><a href="<?php echo $url;?>" target="_blank"><div class="picture"><img class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $ls['path']); ?>" src="images/default/load.jpg" style="display: inline;"><span class="mask" style="overflow: hidden; bottom: -10px; height: 0px;"><?php  echo $ls['title'];?></span></div><span class="price"><small>￥</small><?php echo $ls['sell_price'];?></span></a></li>
                         <?php }}?>
                        </ul>
                    </dd>
                </dl>
                     <?php }}?>
            </div>
            <div class="clear"></div>
            <div class="pagination">
                <ul>
                   <?php echo $pagination;?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
            $('.member_shop_item li').mouseenter(function(){
			$(this).find('.mask').stop().animate({bottom:'0px',height:'40px'});
		})
		$('li').mouseleave(function(){
			$(this).find('.mask').stop().animate({bottom:'-10px',height:'0px'});
		});
                    function delete_favorite(id) {
	var con = confirm("您确定要删除此收藏吗 ？删除后将不可恢复！");
	if (con == true) {
		$.post(base_url+"index.php/user/my_delete_favorite",
				{	"id": id,
                                        'type' : 'store'
				},
				function(res){
					if(res.success){
						 location.reload();
					}else{
						var d = dialog({
						    title: '提示',
						    fixed: true,
						    content: res.message
						});
						d.show();
						setTimeout(function () {
						    d.close().remove();
						}, 2000);
				}
				},
				"json"
		);
	}
}
 </script>