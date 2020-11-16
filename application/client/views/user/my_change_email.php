<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">认证邮箱</span></div>
        <div class="member_tab">
<form action="<?php echo $_SERVER['REQUEST_URI'];?>" id="jsonForm" name="jsonForm" method="post">
<ul class="m_form">
	<li class="clearfix"><span>邮箱：</span>
		<?php echo $user_info['email'];?>
	</li>
	<li class="clearfix"><span>新邮箱：</span><input type="text" name="email" id="email" valid="required|isEmail" errmsg="新邮箱不能为空|邮箱格式错误" class="input_txt mr15"></li>
	<li class="clearfix"><span>图片验证码：</span><input type="text" class="input_txt mr15" valid="required" errmsg="验证码不能为空" maxlength="4" name="code" id="code" style="width:100px;">
		<img id="valid_code_pic" src="index.php/verifycode/index/1" alt="看不清，换一张" onclick="javascript:this.src = this.src + 1;">
		<a style="color:#333;" onclick="javascript:document.getElementById('valid_code_pic').src = document.getElementById('valid_code_pic').src + 1;" href="javascript:void(0);">换一张</a>
		<li class="clearfix"><span>邮箱验证码：</span><input style="width:100px;" type="text" name="email_code" id="email_code" valid="required|isNumber" errmsg="邮箱验证码不能为空|邮箱验证码" placeholder="" class="input_txt w160 mr15 ">
			<a href="javascript:void(0)" class="m_btn ml5" id="sendEmail">发送邮件</a>
		</li>
		<li class="clearfix"><span>&nbsp;</span>
			<a href="javascript:void(0)" onclick="$('#jsonForm').submit();" class="btn_r">提交修改</a>
		</li>
</ul>
</form>
        </div>
    </div>
</div>
<script>
	$("#sendEmail").click(function() {
		$.ajax({
			url: base_url + 'index.php/user/send_email',
			type: 'post',
			data: {
				email: $('#email').val(),
				code: $('#code').val(),
			},
			dataType: 'json',
			beforeSend: function() {
				$('body').append($('<div id="loading"></div>'));
			},
			success: function(data) {
				$("#loading").remove();
				var d = dialog({
					width: 300,
					title: '提示',
					fixed: true,
					content: data.message
				});
				d.show();
			}
		})
	})
</script>