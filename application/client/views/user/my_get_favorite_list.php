<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">收藏产品</span></div>
        <div class="member_product">
            <ul>
                    <?php if ($item_list) { ?>
		<?php foreach ($item_list as $key=>$value) {
			  $url = getBaseUrl($html, "", "product/detail/{$value['item_id']}.html", $client_index);
			?>
                <Li><div class="picture"><a href="<?php echo $url;?>" target="_blank"><img class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>"></a></div>
                    <div class="property">
                        <p><span class="price"><small>￥</small><?php echo $value['sell_price']; ?></span></p>
                        <P class="nowrap"><a href="<?php echo $url;?>" target="_blank"><?php echo $value['title']; ?></a></P>

                        <div class="btn"><a href="<?php echo $url;?>" class="m_btn" target="_blank">购买</a><a href="javascript:delete_favorite(<?php echo $value['id'];?>)" class="m_btn gray">取消收藏</a></div>
                    </div>
                </Li>
           <?php }} ?>

            </ul>
        </div>
        <div class="clear"></div>
	<div class="pagination">
		<ul>
		<?php echo $pagination; ?>
		</ul>
	</div>
    </div>
</div>
<script type="text/javascript">
    function delete_favorite(id) {
	var con = confirm("您确定要取消此收藏吗 ，取消后将不可恢复？");
	if (con == true) {
		$.post(base_url+"index.php/user/my_delete_favorite",
				{	"id": id,
                                        'type' : 'product'
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