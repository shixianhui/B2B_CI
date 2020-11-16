<div class="member_right mt20">
	<div class="box_shadow clearfix m_border">
		<div class="member_title"><span class="bt">修改手机号码</span></div>
<div class="member_tab">
	<form action="<?php echo $_SERVER['REQUEST_URI'];?>" id="jsonForm" name="jsonForm" method="post">
		<ul class="m_form">
			<li class="clearfix"><span>手机号码：</span>
				<?php echo $user_info['mobile'];?>
			</li>
			<li class="clearfix"><span>新手机：</span><input type="text" name="mobile" id="mobile" valid="required|isMobile" errmsg="新手机不能为空|手机号码格式错误" class="input_txt mr15"></li>
			<li class="clearfix"><span>图形验证码：</span><input type="text" class="input_txt mr15" valid="required" errmsg="验证码不能为空" maxlength="4" name="code" id="code" style="width:100px;">
				<img id="valid_code_pic" src="index.php/verifycode/index/1" alt="看不清，换一张" onclick="javascript:this.src = this.src + 1;">
				<a style="color:#333;" onclick="javascript:document.getElementById('valid_code_pic').src = document.getElementById('valid_code_pic').src + 1;" href="javascript:void(0);">换一张</a>
			</li>
			<li class="clearfix"><span>短信验证码：</span><input type="text" name="smscode" id="smscode" valid="required|isNumber" errmsg="短信验证码不能为空|短信验证码错误" style="width:100px;" placeholder="" class="input_txt w160 mr15 ">
				<a href="javascript:void(0)" class="get_yzm fl" id="getyzm">发送短信验证码</a>
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
	var times = 60,
		cuttime;

	function getyzm(idn) {
		times--;
		if(times > 0 && times < 60) {
			$(idn).text(times + "秒后重新获取");
			$(idn).addClass("fail");
			cuttime = setTimeout(function() {
				getyzm(idn)
			}, 1000);
		} else {
			$(idn).text("获取短信验证码");
			times = 60;
			$(idn).removeClass("fail");
			clearTimeout(cuttime);
		}
	}
	$(function() {
		$("#getyzm").bind("click", function() {
			var message = '';
			var mobile = $("input[name=mobile]").val();
			if (!mobile) {
				message = '请填写新的手机号';
				var d = dialog({
					width: 300,
					title: '提示',
					fixed: true,
					content: message
				});
				d.show();
				setTimeout(function() {
					d.close().remove();
				}, 2000);
				return false;
			}
			if(!/^1[356789]\d{9}$/.test(mobile)) {
				message = '手机号码格式不正确';
				var d = dialog({
					width: 300,
					title: '提示',
					fixed: true,
					content: message
				});
				d.show();
				setTimeout(function() {
					d.close().remove();
				}, 2000);
				return false;
			}
			var code = $("input[name=code]").val();
			if(!/^\w{4}$/.test(code)) {
				message = '请正确填写图形验证码';
				var d = dialog({
					width: 300,
					title: '提示',
					fixed: true,
					content: message
				});
				d.show();
				setTimeout(function() {
					d.close().remove();
				}, 2000);
				return false;
			}
			if(times == 60) {
				$.ajax({
					url: base_url + 'index.php/user/get_reg_sms_code',
					type: 'post',
					data: {
						type: "change_mobile",
						mobile: mobile,
						code: code
					},
					dataType: 'json',
					success: function(json) {
						if(json.success) {
							getyzm("#getyzm");
						}
						var d = dialog({
							width: 300,
							title: '提示',
							fixed: true,
							content: json.message
						});
						d.show();
						setTimeout(function() {
							d.close().remove();
						}, 2000);
					}
				});
			}
			return false;
		});
	});
</script>