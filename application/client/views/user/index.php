<div class="member_right mt20">
   <div class="member_headline box_shadow clearfix">
     <div class="info"><img src="<?php if ($userInfo){echo preg_match('/^http/',$userInfo['path']) ? $userInfo['path'] : preg_replace("/\./","_thumb.",$userInfo['path']);} ?>">
     <p><b><?php echo get_cookie('user_username');?></b>  上次登录时间：<?php echo date('Y.m.d H:i:s',$userInfo['login_time']);?><a href="<?php echo getBaseUrl(false,"","user/my_change_user_info",$client_index);?>">修改资料/图像</a></p>
     </div>
     <ul class="short">
        <Li><b>我的资产</b>
        <span class="purple"><small>￥</small><?php echo $userInfo['total'];?></span><a href="<?php echo getBaseUrl(false,"","user/my_recharge.html",$client_index);?>" class="m_btn">充值</a>
        </Li>
        <Li><b>我的积分</b>
        <span><?php echo $userInfo['score'];?></span><a href="javascript:;" class="m_btn gray">使用</a>
        </Li>
        <Li><b>优惠券</b>
        <span>6</span>
        </Li>
     </ul>
   </div>
   <div class="box_shadow clearfix mt20 m_border">
       <div class="member_title"><span class="bt">最近订单</span><a href="<?php echo getBaseUrl(false,'','order/my_order_index.html', $client_index)?>" class="more">查看全部订单</a></div>
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
          $view_url = getBaseUrl($html, "", "order/my_view/{$value['id']}.html", $client_index);
          $stoe_url = getBaseUrl($html, "", "store/home/{$value['store_id']}.html", $client_index);
          $comment_url = getBaseUrl($html, "", "user/my_comment_save/{$value['id']}.html", $client_index);
          $view_comment_url = getBaseUrl($html, "", "user/my_comment_view/{$value['id']}.html", $client_index);
?>
  <table style="margin-top: 10px;" width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table">
  <tbody>
  <tr>
    <th colspan="6" align="left"><div class="fl"><font class="c9">下单时间：</font><?php echo date('Y-m-d H:i:s', $value['add_time']); ?>&nbsp;&nbsp;&nbsp;订单编号：<?php echo $value['order_number']; ?></div><div class="shop-name"><a href="<?php echo $stoe_url; ?>" target="_blank"><?php echo $value['store_name']; ?></a></div></th>
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
   </div>
 </div>
    <script>
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
                    $.post(base_url + "index.php/order/receiving",
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