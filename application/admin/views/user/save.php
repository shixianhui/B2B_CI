<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>用户名</strong> <br/>
	  </th>
      <td>
      <input name="username" id="username" value="<?php if(! empty($user_info)){ echo $user_info['username'];} ?>" <?php if(! empty($user_info)){ echo 'readonly="true"';} ?> size="50" maxlength="50" valid="required" errmsg="用户名不能为空!" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>密&nbsp;&nbsp;&nbsp;码</strong> <br/>
	  </th>
      <td>
      <input name="password" id="password" value="" size="50" maxlength="50" <?php if(empty($user_info)){ echo 'valid="required" errmsg="密码不能为空!"';} ?> type="password">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>确认密码</strong> <br/>
	  </th>
      <td>
      <input name="ref_password" id="ref_password" value="" size="50" maxlength="50" valid="eqaul" eqaulName="password" errmsg="前后密码不一致!" type="password">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>会员组</strong> <br/>
	  </th>
      <td>
      <input name="select_category_id" id="select_category_id" type="hidden" value="<?php if(! empty($user_info)){ echo $user_info['user_group_id'];} ?>" >
      <select name="user_group_id" id="category" valid="required" errmsg="请选择会员组!">
       <option value="" >请选择栏目</option>
       <?php if (! empty($user_group_list)): ?>
       <?php foreach ($user_group_list as $item): ?>
       <option value="<?php echo $item['id'] ?>" ><?php echo $item['group_name'] ?></option>
       <?php endforeach; ?>
       <?php endif; ?>
      </select>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>昵&nbsp;&nbsp;称</strong> <br/>
	  </th>
      <td>
     <input name="nickname" id="nickname" value="<?php if(! empty($user_info)){ echo $user_info['nickname'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>真实姓名</strong> <br/>
	  </th>
      <td>
     <input name="real_name" id="real_name" value="<?php if(! empty($user_info)){ echo $user_info['real_name'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>QQ号</strong> <br/>
	  </th>
      <td>
     <input name="qq_number" id="qq_number" value="<?php if(! empty($user_info)){ echo $user_info['qq_number'];} ?>" size="50" valid="isQQ" errmsg="QQ号格式错误!" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>旺旺号</strong> <br/>
	  </th>
      <td>
     <input name="wangwang_number" id="wangwang_number" value="<?php if(! empty($user_info)){ echo $user_info['wangwang_number'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>邮&nbsp;&nbsp;件</strong> <br/>
	  </th>
      <td>
     <input name="email" id="email" value="<?php if(! empty($user_info)){ echo $user_info['email'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>手机号</strong> <br/>
	  </th>
      <td>
     <input name="mobile" id="mobile" value="<?php if(! empty($user_info)){ echo $user_info['mobile'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>固定电话</strong> <br/>
	  </th>
      <td>
     <input name="phone" id="phone" value="<?php if(! empty($user_info)){ echo $user_info['phone'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>邮编</strong> <br/>
	  </th>
      <td>
     <input name="zip" id="zip" value="<?php if(! empty($user_info)){ echo $user_info['zip'];} ?>" maxlength="6" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>地域</strong> <br/>
	  </th>
      <td>
      <input id="txt_address" name="txt_address" type="hidden" value="<?php if(! empty($user_info)){ echo $user_info['txt_address'];} ?>" />
     <select class="input_blur" id="province_id" name="province_id" onchange="javascript:get_city('province_id','city_id',0,0,1);">
    <option value="">选择省</option>
    <?php if ($item_list) { ?>
    <?php foreach ($item_list as $key=>$value) {
          $selector = '';
          if ($user_info) {
              if ($user_info['province_id'] == $value['id']) {
                  $selector = 'selected="selected"';
              }
          }
        ?>
    <option <?php echo $selector; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
    <?php }} ?>
    </select>
    <select class="input_blur" id="city_id" name="city_id" onchange="javascript:get_city('city_id','area_id',0,0,0);">
    <option>选择市</option>
    </select>
    <select onchange="javascript:change_area();" class="input_blur" id="area_id" name="area_id">
    <option>选择区/县</option>
    </select>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>详细地址</strong> <br/>
	  </th>
      <td>
     <input name="address" id="address" value="<?php if(! empty($user_info)){ echo $user_info['address'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>积分</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($user_info)){ echo $user_info['score'];} ?>
	</td>
    </tr>
    <tr>
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
    </tr>
    <tr>
      <th width="20%"> <strong>最后登录IP</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($user_info)){ echo $user_info['ip_address'];} ?>
	</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>
<script type="text/javascript">
function change_area() {
	//省 市 县
	var province_id_txt = $("#province_id").find("option:selected").text();
	var city_id_txt = $("#city_id").find("option:selected").text();
	var area_id_txt = $("#area_id").find("option:selected").text();
	$("#txt_address").val(province_id_txt+' '+city_id_txt+' '+area_id_txt);
}

function get_city(cur_id, next_id, next_select_val, prev_select_val, is_city) {
	var parent_id = $("#"+cur_id).val();
	if (prev_select_val) {
		parent_id = prev_select_val;
	}
	$.post(base_url+"admincp.php/user/get_city",
			{	"parent_id": parent_id
			},
			function(res){
				if(res.success){
					var html = '<option value="">--选择市--</option>';
					if (is_city == 0) {
						html = '<option value="">--选择区/县--</option>';
					}
					for (var i = 0, data = res.data, len = data.length; i < len; i++){
						if (data[i]['id'] == next_select_val) {
							html += '<option selected="selected" value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
						} else {
							html += '<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
						}
					}
					$("#"+next_id).html(html);
					return false;
				}else{
					alert(res.message);
					return false;
				}
			},
			"json"
	);
}
<?php if ($user_info) { ?>
get_city('province_id','city_id',<?php echo $user_info['city_id']; ?>,<?php echo $user_info['province_id']; ?>,1);
get_city('city_id','area_id',<?php echo $user_info['area_id']; ?>,<?php echo $user_info['city_id']; ?>,0);
<?php } ?>
</script>
<br/><br/>