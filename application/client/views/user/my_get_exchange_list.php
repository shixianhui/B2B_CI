<div class="member_right mt20">

  <div class="box_shadow clearfix m_border">
     <div class="member_title"><span class="bt">申请退换货</span></div>

<div class="member_tab mt20">
 <div class="hd">
 <ul>
 <li <?php if ($select_status == 'all') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "user/my_get_exchange_list/all.html", $client_index); ?>'">全部</li>
 <Li <?php if ($select_status == 'a') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "user/my_get_exchange_list/a.html", $client_index); ?>'">申请中</Li>
 <Li <?php if ($select_status == 'c') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "user/my_get_exchange_list/c.html", $client_index); ?>'">申请成功</Li>
 <Li <?php if ($select_status == 'b') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "user/my_get_exchange_list/b.html", $client_index); ?>'">申请失败</Li>
 <Li <?php if ($select_status == 'd') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "user/my_get_exchange_list/d.html", $client_index); ?>'">退款成功</Li>
 </ul>
 </div>
 <div class="bd">
     <?php if ($item_list){
         foreach ($item_list as $key => $item){
             ?>
 <div class="clearfix">
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
     <thead>
  <tr>
    <th width="36%" class="tal">属性</th>
    <th width="11%">单价</th>
    <th width="7%">数量</th>
    <th width="11%">退款金额</th>
    <th width="18%">退款原因</th>
    <th width="17%">状态</th>
  </tr>
    <tr>
    <td colspan="6" class="bj">&nbsp;</td>
    </tr>
  </thead>
</table>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table">
  <tbody>
  <tr>
    <th colspan="6" align="left"><div class="fl"><font class="c9">退单时间：</font><?php echo date('Y-m-d', $item['add_time']);?>&nbsp;&nbsp;&nbsp;退款订单编号：<?php echo $item['order_num']; ?></div><div class="shop-name"><a href="<?php echo base_url().getBaseUrl(false, "", "store/home/{$item['store_id']}.html", $client_index); ?>" target="_blank"><?php echo $item['store_name']?></a></div></th>
    </tr>
  <?php if ($item['orders_detail_info']){
      $url = getBaseUrl($html, "", "product/detail/{$item['orders_detail_info']['product_id']}.html", $client_index);
      ?>
  <tr>
    <td width="36%" valign="middle"><div class="info"><a href="<?php echo $url; ?>" target="_blank"><img src="<?php if ($item['orders_detail_info']['path']) { echo preg_replace('/\./', '_thumb.', $item['orders_detail_info']['path']);}else{echo 'images/default/load.jpg';} ?>"><?php echo $item['orders_detail_info']['product_title'];?><p class="c9"></p></a></div></td>
    <td width="11%" align="center"><small>¥</small><?php echo $item['orders_detail_info']['buy_price']; ?></td>
    <td width="7%" align="center"><?php echo $item['orders_detail_info']['buy_number']; ?></td>
    <td width="11%" align="center"><span class="red"><small>¥</small><?php echo $item['price'];?></span></td>
    <td width="18%" align="center"><span class="c9"><?php echo $exchange_reason_arr[$item['exchange_reason_id']]; ?></span></a></td>
    <td width="17%" align="center"><font class="red"><?php echo $exchange_status_arr[$item['status']]; ?></font><p><a href="<?php echo base_url().getBaseUrl(false, "", "user/my_view_exchange/{$item['orders_detail_id']}.html", $client_index); ?>" class="m_btn gray mr5">查看</a><a onclick="cancel_exchange(<?php echo $item['id']; ?>);" class="m_btn mt5 gray">取消</a></p></td>
  </tr>
  <?php } ?>
  </tbody>
</table>
 </div>
    <?php }} ?>
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
<script type="text/javascript">
    function cancel_exchange(id) {
        var d = dialog({
            width:350,
            fixed: true,
            title: '取消退款申请提示',
            content: '非审核中的退款订单不能取消！',
            okValue: '确认取消退款申请',
            ok: function () {
                $.post(base_url+"index.php/"+controller+"/my_delete_exchange",
                    {	"id": id
                    },
                    function(res){
                        if(res.success){
                            return my_alert_flush('fail', 0, res.message);
                        } else {
                            return my_alert_flush('fail', 0, res.message);
                        }
                    },
                    "json"
                );
                return false;
            },
            cancelValue: '取消',
            cancel: function () {
            }
        });
        d.show();
    }
</script>