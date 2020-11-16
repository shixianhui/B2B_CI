<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <strong>用户名</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($user_info)){ echo $user_info['username'];} ?>
      <input onclick="javascript:window.location.href='<?php echo base_url().'admincp.php/user/save/'.$id; ?>';" class="button_style" name="back" value=" 修改当前信息 " type="button">
	  </td>
	  <th width="20%">
      <strong>会员组</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($user_info)){ echo $user_info['group_name'];} ?>
	  </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>昵称</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($user_info)){ echo $user_info['nickname'];} ?>
	</td>
	<th width="20%">
      <strong>真实姓名</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($user_info)){ echo $user_info['real_name'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>QQ号</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($user_info)){ echo $user_info['qq_number'];} ?>
	</td>
	<th width="20%"> <strong>旺旺号</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($user_info)){ echo $user_info['wangwang_number'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>邮件</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($user_info)){ echo $user_info['email'];} ?>
	</td>
	<th width="20%"> <strong>手机号</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($user_info)){ echo $user_info['mobile'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>固定电话</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($user_info)){ echo $user_info['phone'];} ?>
	</td>
	<th width="20%"> <strong>邮编</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($user_info)){ echo $user_info['zip'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>积分</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($user_info)){ echo $user_info['score'];} ?>
	</td>
	<th width="20%"> <strong>余额</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($user_info)){ echo number_format($user_info['total'], 2, '.', '');} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>最后登录时间</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($user_info)){ echo date('Y-m-d H:i:s', $user_info['login_time']);} ?>
	</td>
	<th width="20%"> <strong>最后登录IP</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($user_info)){ echo $user_info['ip_address'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>地域信息</strong> <br/>
	  </th>
      <td colspan="3">
      <?php if(! empty($user_info)){ echo $user_info['txt_address'];} ?>
      <?php if(! empty($user_info)){ echo $user_info['address'];} ?>
	</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">
	  <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="back" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>
<br/><br/>