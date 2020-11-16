<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">物流管理</span></div>
        <div class="model active">
            <a href="<?php echo getBaseUrl(false, '', 'seller/my_save_postage_way.html', $client_index); ?>" class="add_btn" >+ 新增物流模板</a>
            <ul class="model_content">
                <?php
                    if($item_list){
                        foreach($item_list as $item){
                            $url = getBaseUrl(false,'', 'seller/my_save_postage_way/'.$item['id'],$client_index);
                ?>
                <li id="table_<?php echo $item['id'];?>">
                    <table>
                        <tr>
                            <td colspan="6">
                                <h4><?php echo $item['title'];?></h4>
                                <p>
                                    <a href="<?php echo $url;?>">修改</a> |
                                    <a href="javascript:void(0)" onclick="delete_postage_way(<?php echo $item['id'];?>)">删除</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:32.0%;">运送到</td>
                            <td>首件(<?php echo $measurement[$item['charging_mode']];?>)</td>
                            <td>运费(元)</td>
                            <td>续件(<?php echo $measurement[$item['charging_mode']];?>)</td>
                            <td>运费(元)</td>
                        </tr>
                        <?php
                            foreach($item['postagepriceList'] as $ls){
                        ?>
                        <tr>
                            <td><?php echo $ls['area'];?></td>
                            <td><?php echo $ls['start_val'];?></td>
                            <td><?php echo $ls['start_price'];?></td>
                            <td><?php echo $ls['add_val'];?></td>
                            <td><?php echo $ls['add_price'];?></td>
                        </tr>
                            <?php }?>
                    </table>
                </li>
                        <?php }}?>
            </ul>
        </div>
    </div>
</div>
<script>
    	function delete_postage_way(id) {
		var d = dialog({
			title: '提示',
			width: 300,
			fixed: true,
			content: '您确定要删除此发货模板？',
			okValue: '确定',
			ok: function() {
				$.post(base_url + 'index.php/seller/my_delete_postage_way', {
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
					$("#table_"+id).remove();
				}, 'json');
			},
			cancelValue: '取消',
			cancel: function() {}
		});
		d.show();
	}
</script>