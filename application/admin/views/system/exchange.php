<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>积分兑换(此功能只开启积分兑换功能，哪些商品参与此活动，请到“产品管理”设置)</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <strong>两次兑换的间隔时间</strong> <br/>
	  </th>
      <td>
      <input name="exchange_space_min" id="exchange_space_min" value="<?php if($itemInfo){echo $itemInfo['exchange_space_min'];} ?>" size="30"  class="input_blur" type="text"> <font color="red">分钟</font>
	</td>
	</tr>
        <tr>
      <th width="20%">
      <strong>街贝抵扣金额设置</strong> <br/>
	  </th>
      <td>
      <input name="score_deductible" id="exchange_space_min" value="<?php if($itemInfo){echo $itemInfo['score_deductible'];} ?>" size="30"  class="input_blur" type="text"> <font color="red">/元(多少个街贝抵扣1元)</font>
	</td>
	</tr>
    <tr>
      <th width="20%">
      <strong>销售价的百分之多少<br/>为所需的购买积分</strong> <br/>
	  </th>
      <td>
      销售价 <font color="red">x</font> <input name="exchange_percent" id="exchange_percent" value="<?php if($itemInfo){echo $itemInfo['exchange_percent'];} ?>" size="30"  class="input_blur" type="text"> % = <strong>购买积分</strong><br/><font color="red">注：“100”表示百分之百，“90”表示百分之九十，以次类推,例如：100（销售价）x 90% = 90(积分)</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>是否开启打折活动功能</strong> <br/>
	  </th>
      <td>
      <input type="radio" value="0" name="exchange_open" class="radio_style" <?php if($itemInfo){if($itemInfo['exchange_open']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 关闭
      <input type="radio" value="1" name="exchange_open" class="radio_style" <?php if($itemInfo){if($itemInfo['exchange_open']=='1'){echo 'checked="checked"';}} ?> > 开启
	</td>
	</tr>
	<tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input class="button_style" name="reset" value=" 重置 " type="reset">
	  </td>
    </tr>
   </tbody>
</table>
</form>
<br/><br/>