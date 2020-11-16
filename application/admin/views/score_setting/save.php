<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>积分设置管理</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>每次登录送</strong> <br/>
	  </th>
      <td>
      <input name="login_score" id="login_score" value="<?php if($itemInfo){echo $itemInfo['login_score'];} ?>" size="10"  class="input_blur" type="text"> <font color="red">个街贝</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>一天最多送</strong> <br/>
	  </th>
      <td>
      <input name="login_score_max" id="login_score_max" value="<?php if($itemInfo){echo $itemInfo['login_score_max'];} ?>" size="10"  class="input_blur" type="text"> <font color="red">个街贝</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>新用户注册送</strong> <br/>
	  </th>
      <td>
      <input name="reg_score" id="reg_score" value="<?php if($itemInfo){echo $itemInfo['reg_score'];} ?>" size="10"  class="input_blur" type="text"> <font color="red">个街贝</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>店面分销商推广的用户入驻送</strong> <br/>
	  </th>
      <td>
      <input name="store_score" id="store_score" value="<?php if($itemInfo){echo $itemInfo['store_score'];} ?>" size="10"  class="input_blur" type="text"> <font color="red">个街贝</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>街贝与人民币兑换比例</strong> <br/>
	  </th>
      <td>
      <input name="exchange_rmb_num" id="exchange_rmb_num" value="<?php if($itemInfo){echo $itemInfo['exchange_rmb_num'];} ?>" size="10"  class="input_blur" type="text"> <font color="red">个街贝＝1元</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>是否开启街贝抵现</strong> <br/>
	  </th>
      <td>
      <input type="radio" value="0" name="is_open" class="radio_style" <?php if($itemInfo){if($itemInfo['is_open']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 关闭
      <input type="radio" value="1" name="is_open" class="radio_style" <?php if($itemInfo){if($itemInfo['is_open']=='1'){echo 'checked="checked"';}} ?> > 开启&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">注:活动开启才可街贝抵现</font>
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