<div class="member_right mt20">

  <div class="box_shadow clearfix m_border">
     <div class="member_title"><span class="bt">我的团预购</span></div>


<div class="member_tab mt20">

 <div class="bd">
 <div class="clearfix">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
   <thead>
  <tr>
    <th width="35%" class="tal">商品信息</th>
      <th width="10%">拼团人数</th>
      <th width="13%">当前拼团价（元）</th>
    <th width="15%">定金（元）</th>
    <th width="15%">活动状态</th>
    <th width="14%">操作</th>
  </tr>
  </thead>
  </table>
<?php if ($item_list) { ?>
<?php foreach ($item_list as $key=>$value) {
          $view_url = getBaseUrl(false, "", "groupon/detail/{$value['ptkj_id']}.html", $client_index);
?>
  <table style="margin-top: 10px;" width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table">
  <tbody>
  <tr>
    <th colspan="6" align="left"><div class="fl"><font class="c9">参团时间：</font><?php echo date('Y-m-d H:i:s', $value['add_time']); ?></div><div class="shop-name">活动结束时间：<?php echo date('Y-m-d H:i:s', $value['end_time']); ?></div></th>
    </tr>
    <?php if ($value['product_info']) { ?>

    <tr>
    <td width="35%" valign="middle"><div class="info"><img src="<?php if ($value['product_info']['path']) { echo preg_replace('/\./', '_thumb.', $value['product_info']['path']);}else{echo 'images/default/load.jpg';} ?>"><?php echo $value['product_info']['title']; ?>
            <p class="c9">原价：<?php echo $value['product_info']['sell_price']; ?></p>
            <p class="c9">数量：1</p>
	</div></td>
    <td width="10%" align="center"><?php echo $value['pintuan_people']; ?></td>
        <td width="13%" align="center"><span class="red"><?php echo $value['pintuan_price']; ?></span></td>
    <td width="15%" align="center"><span class="red"><small>¥</small><?php echo $value['deposit']; ?></span>
    </td>
    <td width="15%" align="center" ><?php echo $value['status']; ?><br>
    </td>
    <td width="14%" align="center">
        <a href="<?php echo $view_url; ?>"><font class="c9 mt5">查看详情</font></a>
    </td>
  </tr>
  <?php } ?>
  </tbody>
</table>
<?php }} ?>

<div class="clear"></div>

 </div>
</div>
</div>
   </div>
 </div>
