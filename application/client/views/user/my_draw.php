<div class="member_right mt20">
	<div class="box_shadow clearfix m_border">
		<div class="member_title"><span class="bt">账户提现</span></div>
		<ul class="m_form">
			<li class="clearfix"><span>账户余额：</span><b class="f18 red"><small>￥</small><?php if ($user_info){ echo $user_info['total']; } ?></b></li>
			<li class="clearfix"><span>提现金额：</span><input type="" placeholder="" class="input_txt mr15" style="width:180px;">元</li>
			<li class="clearfix"><span>提现至：</span>
				<div class="bank_pay">
					<div class="hd ">
						<ul>
							<Li onclick="change_show(this,1);" class="on">支付宝</Li>
							<Li onclick="change_show(this,0);">银行卡</Li>
						</ul>
					</div>
					<div class="bd clearfix">
						<ul class="m_form" style="padding-left:0px;" id="alipay_form">
							<li class="clearfix"><span>开户名：</span><input type="" placeholder="" class="input_txt"></li>
							<li class="clearfix"><span>支付宝账号：</span><input type="" placeholder="" class="input_txt"> </li>
							<li class="clearfix"><span>&nbsp;</span>
								<a href="" class="btn_r">立即提现</a>
							</li>

						</ul>

						<ul class="m_form" style="padding-left:0px;display: none" id="bank_form">
							<li class="clearfix"><span>开户行：</span><input type="" placeholder="" class="input_txt"></li>
							<li class="clearfix"><span>开户名：</span><input type="" placeholder="" class="input_txt"> </li>
							<li class="clearfix"><span>银行账号：</span><input type="" placeholder="" class="input_txt"> </li>
							<li class="clearfix"><span>手机验证：</span><input type="" placeholder="" class="input_txt" style=" width:120px;">
								<a href="#" class="getyzm" id="getyzm">获取验证码</a>
							</li>
							<li class="clearfix"><span>&nbsp;</span>
								<a href="" class="btn_r">立即提现</a>
							</li>
						</ul>
					</div>
				</div>
		</ul>
	</div>
</div>
<script>
    function change_show(obj,type) {
        if(type){
            $('#alipay_form').show();
            $('#bank_form').hide();
            $(obj).addClass('on');
            $(obj).siblings('li').removeClass('on');
        }else{
            $('#alipay_form').hide();
            $('#bank_form').show();
            $(obj).addClass('on');
            $(obj).siblings('li').removeClass('on');
        }

    }
</script>