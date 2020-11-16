<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">品牌设置</span>
        <span style="color:#9c9c9c;margin-left:50px;">注：产品品牌设置，在发布商品页面可以快捷选项，在店铺搜索页面可以快捷搜索。</span>
        <a href="<?php echo getBaseUrl(false, '', 'seller/my_save_brand.html', $client_index); ?>" class="add_btn">+ 新增品牌</a></div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="b_shop_table">
            <tr>
                <th width="20%">品牌logo</th>
                <th>品牌</th>
                <th width="20%">分类</th>
                <th width="15%">操作</th>
            </tr>
            <?php
              if($item_list){
                  foreach($item_list as $item){
            ?>
            <tr class="form_tr">
                <td>
                    <?php
                      if($item['path']){
                    ?>
                    <img style="width: 130px;height:60px;" src="<?php echo str_replace('.','_thumb.',$item['path']);?>">
                      <?php }?>
                </td>
                <td style="text-align:center;"><?php echo $item['brand_name'];?></td>
                <td style="text-align:center;"><?php echo $item['tag'];?></td>
                <td class="link_action">
                <?php if ($item['store_id'] != 0){ ?>
                    <a href="<?php echo getBaseUrl(false,'','seller/my_save_brand/'.$item['id'].'.html',$client_index);;?>">修改</a>
                    <a href="javascript:void(0)" onclick="my_delete_brand(<?php echo $item['id'];?>,this);">删除</a>
                          <?php } ?>
                </td>
            </tr>
              <?php }}?>
        </table>
    </div>
</div>
<script>
	function my_delete_brand(id, obj) {
		var d = dialog({
			title: '提示',
			width: 300,
			fixed: true,
			content: '您确定要删除此品牌吗？',
			okValue: '确定',
			ok: function() {
				$.post(base_url + 'index.php/seller/my_delete_brand', {
					'id': id
				}, function(data) {
					if(data.success == false) {
						var d = dialog({
							width: 300,
							title: '提示',
							fixed: true,
							content: data.message
						});
						d.show();
						setTimeout(function() {
							d.close().remove();
						}, 2000);
						return false;
					}
					$(obj).parents('tr').remove();
				}, 'json');
			},
			cancelValue: '取消',
			cancel: function() {}
		});
		d.show();
	}
</script>