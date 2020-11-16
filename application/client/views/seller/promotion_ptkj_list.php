<style type="text/css">
	.product_search span{font-size:13px;line-height:30px;}
	.product_search input{line-height:30px;border:1px solid #eaebeb;padding:0 5px;color:#666;}
	.product_search label{position: relative;vertical-align:middle;font-size:13px;color:#333;line-height:30px;padding-left: 3px}
	.product_search label div{display:inline-block;position: relative;
    overflow: hidden;
    height: 30px;
    border: 1px solid #eaebeb;
    background: #fff;
    color: #666;
    -webkit-transition: border-color 0.2s linear;
    transition: border-color 0.2s linear;
    vertical-align:top; padding:0; line-height:20px;}

	.product_search select{-webkit-box-sizing: border-box;
    box-sizing: border-box;
    height: 30px;
    margin: 0;
    border: 0;
    padding: 0 20px 0 5px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    font-size: 12px;
    font-weight: 400;
    line-height: 29px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    vertical-align: middle;
    background: none;
    color: #666;
    outline: none;
    cursor: pointer;}
    .down{    position: absolute;
    right: 5px;
    top: 10px;
    z-index: 1;
    width: 16px;
    height: 16px;
    color: #b0b0b0;
    cursor: pointer;
    pointer-events: none;
    background: url(images/default/icon.png) no-repeat -402px -96px;
}
    .member_table tbody th{font-weight: bold}
</style>
<div class="member_right mt20">

    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">团预购活动管理</span> <span style="color:#9c9c9c;margin-left:50px;"></span>
            <a href="<?php echo getBaseUrl(false, '', 'seller/promotion_ptkj_save.html', $client_index); ?>" class="add_btn">+ 新增团预购</a></div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="b_shop_table member_table" style="margin-top: 20px">
            <tr>
                <th width="30%">商品信息</th>
                <th width="10%">活动方式</th>
                <th width="25%">活动时间</th>
                <th width="12%">参团人数</th>
                <th width="8%">状态</th>
                <th width="15%">操作</th>
            </tr>
            <?php
               if($item_list){
                   foreach($item_list as $item){
            ?>
            <tr id="id_<?php echo $item['id'];?>">
                <td valign="middle">
                    <div class="info"><img src="<?php if ($item['path']) { echo preg_replace('/\./', '_thumb.', $item['path']);}else{echo 'images/default/load.jpg';} ?>" style="height: "><?php echo $item['title']; ?>
                        <p class="c9">
                            原价：¥<?php echo $item['sell_price']; ?>
                        </p>
                    </div>
                </td>
                <td align="center"><?php echo $item['type'] == 0 ? '叠加优惠金额' : '固定优惠金额'; ?></td>
                <td align="center"><?php echo date('Y-m-d H:i:s', $item['start_time']) . '～' . date('Y-m-d H:i:s', $item['end_time']); ?>
                    <?php
                    if($item['start_time'] < time() &&  $item['end_time'] > time()){
                        echo  '<font color="red">进行中...</font>';
                    }
                    if( $item['end_time'] < time()){
                        echo  '<font color="red">已结束</font>';
                    }
                    if( $item['start_time'] > time()){
                        echo  '<font color="red">暂未开始</font>';
                    }
                    ?></td>
                <td align="center"><?php echo $item['pintuan_people'];?></td>
                <td align="center"><?php echo $item['is_open'] == 0 ? '关闭' : '开启'; ?></td>
                <td align="center">
                       <?php if($item['start_time'] > time() || $item['is_open']==0){ ?>
                    <a href="<?php echo getBaseUrl(false,'','seller/promotion_ptkj_save/'.$item['id'].'.html',$client_index);;?>">修改</a>
                       <?php }else{ ?>
                    <a href="<?php echo getBaseUrl(false,'','seller/promotion_ptkj_view/'.$item['id'].'.html',$client_index);;?>">查看</a>
                           <?php } ?>
                    <a href="javascript:void(0)" onclick="my_delete_seller_group(<?php echo $item['id'];?>,this);">删除</a>
                </td>
            </tr>
                   <?php }}?>
        </table>
         <div class="clear"></div>
	<div class="pagination">
		<ul>
		<?php echo $pagination; ?>
		</ul>
	</div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#add_time_start').calendar({ maxDate:'#add_time_end', btnBar:false });
        $('#add_time_end').calendar({ minDate:'#add_time_start', btnBar:false });
    });
</script>
<script>
    function my_delete_seller_group(id, obj) {
        var d = dialog({
            title: '提示',
            width: 300,
            fixed: true,
            content: '您确定要删除此团预购活动吗？',
            okValue: '确定',
            ok: function() {
                $.post(base_url + 'index.php/seller/my_delete_promotion_ptkj', {
                    'id': id
                }, function(data) {
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
                    if(data.success == false) {
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