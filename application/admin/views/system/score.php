<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>街贝设置</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>每次登录送街贝</strong> <br/>
	  </th>
      <td>
      <input name="login_score" id="login_score" value="<?php if($itemInfo){echo $itemInfo['login_score'];} ?>" size="50"  class="input_blur" type="text">
     </td>
	</tr>
	<tr>
      <th width="20%">
      <strong>注册送街贝</strong> <br/>
	  </th>
      <td>
      <input name="register_score" id="register_score" value="<?php if($itemInfo){echo $itemInfo['register_score'];} ?>" size="50"  class="input_blur" type="text">
     </td>
	</tr>
	<tr>
      <th width="20%">
      <strong>购买商品送街贝</strong> <br/>
	  </th>
      <td>
      <input name="product_percent" id="product_percent" value="<?php if($itemInfo){echo $itemInfo['product_percent'];} ?>" size="50" maxlength="3"  class="input_blur" type="text"> %
     <font color="red">注：商品最终销售价格上乘上这个比例,如：100x100%=100</font>
     </td>
	</tr>
	<tr>
      <th width="20%">
      <strong>是否开启送街贝功能</strong> <br/>
	  </th>
      <td>
      <input type="radio" value="0" name="open_score" class="radio_style" <?php if($itemInfo){if($itemInfo['open_score']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 关闭
      <input type="radio" value="1" name="open_score" class="radio_style" <?php if($itemInfo){if($itemInfo['open_score']=='1'){echo 'checked="checked"';}} ?> > 开启
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