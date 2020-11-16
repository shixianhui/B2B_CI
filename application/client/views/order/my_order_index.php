<div class="member_right mt20">

  <div class="box_shadow clearfix m_border">
     <div class="member_title"><span class="bt">我的订单</span></div>


<div class="member_tab mt20">
 <div class="hd">
 <ul>
	<li <?php if ($select_status == 'all') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "{$template}/my_order_index/all.html", $client_index); ?>'">所有订单</li>
	<li <?php if ($select_status == 'a') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "{$template}/my_order_index/a.html", $client_index); ?>'">待付款</li>
	<li <?php if ($select_status == 'b') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "{$template}/my_order_index/b.html", $client_index); ?>'">待发货</li>
	<li <?php if ($select_status == 'c') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "{$template}/my_order_index/c.html", $client_index); ?>'">待收货</li>
	<li <?php if ($select_status == 'd') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "{$template}/my_order_index/d.html", $client_index); ?>'">待评价</li>
</ul>
 </div>
 <div class="bd">
 <div class="clearfix">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
   <thead>
  <tr>
    <th width="41%" class="tal">属性</th>
    <th width="13%">单价（元）</th>
    <th width="8%">数量</th>
    <th width="17%">实付款（元）</th>
    <th width="9%">订单状态</th>
    <th width="14%">操作</th>
  </tr>
  </thead>
  </table>
<?php if ($item_list) { ?>
<?php foreach ($item_list as $key=>$value) {
          $view_url = getBaseUrl($html, "", "{$template}/my_view/{$value['id']}.html", $client_index);
          $stoe_url = getBaseUrl($html, "", "store/home/{$value['store_id']}.html", $client_index);
          $comment_url = getBaseUrl($html, "", "user/my_comment_save/{$value['id']}.html", $client_index);
          $view_comment_url = getBaseUrl($html, "", "user/my_comment_view/{$value['id']}.html", $client_index);
?>
  <table style="margin-top: 10px;" width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table">
  <tbody>
  <tr>
    <th colspan="6" align="left"><div class="fl"><input type="checkbox" name="order_ids[]" value="checkbox" style="margin-right:5px;" /><font class="c9">下单时间：</font><?php echo date('Y-m-d H:i:s', $value['add_time']); ?>&nbsp;&nbsp;&nbsp;订单编号：<?php echo $value['order_number']; ?></div><div class="shop-name"><a href="<?php echo $stoe_url; ?>" target="_blank"><?php echo $value['store_name']; ?></a></div></th>
    </tr>
    <?php if ($value['order_detail_list']) { ?>
	<?php foreach ($value['order_detail_list'] as $od_key=>$od_value) {
		      $url = getBaseUrl($html, "", "product/detail/{$od_value['product_id']}.html", $client_index);
	?>
    <tr>
    <td width="41%" valign="middle"><div class="info"><a href="<?php echo $url; ?>" target="_blank"><img src="<?php if ($od_value['path']) { echo preg_replace('/\./', '_thumb.', $od_value['path']);}else{echo 'images/default/load.jpg';} ?>"><?php echo $od_value['product_title']; ?>
    <?php if ($od_value['color_size_open']) { ?>
	<p class="c9">
	<?php echo $od_value['product_color_name']; ?>：<?php echo $od_value['color_name']; ?>
	<?php echo $od_value['product_size_name']; ?>：<?php echo $od_value['size_name']; ?>
	</p>
	<?php } ?>
	</a></div></td>
    <td width="13%" align="center"><small>¥</small><?php echo $od_value['buy_price']; ?></td>
    <td width="8%" align="center"><?php echo $od_value['buy_number']; ?></td>
    <?php if($od_key == 0) { ?>
    <td rowspan="<?php echo count($value['order_detail_list']); ?>" width="17%" align="center"><span class="red"><small>¥</small><?php echo $value['total']; ?></span>
 <br/>
    （含运费：￥<?php echo number_format($value['taxation_total']+$value['postage_price'],2, '.', ''); ?>）
        <br/><?php if ($value['order_type']){ ?>团预购定金：￥<?php echo floatval($value['deposit']); ?><?php } ?>
    </td>
    <td rowspan="<?php echo count($value['order_detail_list']); ?>" width="9%" align="center" ><font class="c9"><?php echo $status[$value['status']]; ?></font><br><a href="<?php echo $view_url; ?>"><font class="c9 mt5">查看详情</font></a>
    </td>
    <td rowspan="<?php echo count($value['order_detail_list']); ?>" width="14%" align="center">
        <a href="m_order_detail.html" class="m_btn" style="display: none">再次购买</a>
        <?php if ($value['status'] == 0){ ?>
            <a href="<?php echo getBaseUrl($html, "", "order/my_go_to_pay/{$value['id']}.html", $client_index); ?>" class="m_btn">去付款</a>
        <?php }elseif ($value['status'] == 2){ ?>
        <a href="javascript:void(0);" onclick="change_receiving(<?php echo $value['id'].','.$value['order_number']; ?>)" class="m_btn">确认收货</a>
        <?php }elseif ($value['status'] == 3){?>
            <?php if ($value['is_comment_to_seller'] == 0){ ?>
        <a href="<?php echo $comment_url;?>" class="m_btn">我要评价</a>
        <?php }else{ ?>
                <a href="<?php echo $view_comment_url;?>" class="m_btn">查看评价</a>
            <?php }} ?>
    </td>
    <?php } ?>
  </tr>
  <?php }} ?>
  </tbody>
</table>
<?php }} ?>
<div class="delete_cuont mt20">
<input type="checkbox" name="checkbox" style="margin-right:2px;" onclick="javascript:select_all(this);" /> 全选<a href="javascript:void(0);"><span class="icon delete_icon"></span>删除</a></div>
<div class="clear"></div>
<div class="pagination">
	<ul>
		<?php echo $pagination;?>
	</ul>
</div>
 </div>
</div>
</div>
   </div>
 </div>
<script type="text/javascript">
function select_all(obj) {
	if($(obj).attr("checked") == "checked"){
		$("input[name='order_ids[]']").prop('checked', true);
	} else {
		$("input[name='order_ids[]']").prop('checked', false);
	}
}

//确认收货
function change_receiving(id, order_num) {
    var html = '请确定订单【' + order_num + '】已经收货并签收，操作后将不可恢复，“确认收货”？';
    var d = dialog({
        width: 300,
        fixed: true,
        title: '确认收货提示',
        content: html,
        okValue: '确认收货',
        ok: function () {
            $.post(base_url + "index.php/<?php echo $template; ?>/receiving",
                {
                    "id": id
                },
                function (res) {
                    if (res.success) {
                        return my_alert_flush('fail', 0, res.message);
                    } else {
                        return my_alert('fail', 0, res.message);
                    }
                },
                "json"
            );
        },
        cancelValue: '取消',
        cancel: function () {
        }
    });
    d.show();
}

</script>