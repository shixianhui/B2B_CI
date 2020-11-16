<div class="member_right mt20">

  <div class="box_shadow clearfix m_border">
     <div class="member_title"><span class="bt">修改登录密码</span></div>
            <form action="<?php echo getBaseUrl(false, "", "user/my_change_pass.html", $client_index); ?>" id="jsonForm" name="jsonForm" method="post">
     <ul class="m_form" >
        <li class="clearfix"><span>旧密码：</span><input type="password" id="old_password" name="old_password" valid="required" errmsg="原密码不能为空" class="input_txt"></li>
        <li class="clearfix"><span>新密码：</span><input type="password" id="new_password" name="new_password" valid="required" errmsg="新密码不能为空" class="input_txt"></li>
        <li class="clearfix"><span>确认密码：</span><input type="password" id="con_password" name="con_password" valid="eqaul" eqaulName="con_password" errmsg="密码前后不一致" class="input_txt" > </li>
        <li class="clearfix"><span>&nbsp;</span><a href="javascript:void(0)" onclick="submit();" class="btn_r">确认修改</a></li>
   </ul>
             </form>
  </div>




 </div>
<script>
    function submit() {
        $('#jsonForm').submit();
        window.location.href = base_url+'index.php/user/login.html';
    }

</script>