<style>
    .bank_list{display: none}
    .checkbox{margin-top: 14px;}
</style>
<div class="member_right mt20">
	<div class="box_shadow clearfix m_border">
		<div class="member_title"><span class="bt">充值账户</span></div>
		<ul class="m_form">
			<li class="clearfix"><span>账户余额：</span><b class="f18 red"><small>￥</small><?php if ($user_info['total']){ echo $user_info['total']; }else{ echo '0.00'; }?></b></li>
			<li class="clearfix"><span>充值金额：</span><input type="number" placeholder="" id="money" name="money" class="input_txt mr15" style="width:180px;">元</li>
			<li class="clearfix"><span>付款方式：</span>
				<div class="bank_pay">
					<div class="hd">
						<ul>
							<Li class="on">支付宝</Li>
							<Li>微信支付</Li>
							<Li>网银支付</Li>
						</ul>
					</div>
					<div class="bd clearfix" id="selectPay">
						<div class="bank_list">
							<dl class="checkbox_item">
								<dd data-type="alipay">
									<a href="javascript:void(0);"><img src="images/default/pay2.png"></a>
								</dd>
							</dl>
						</div>
						<div class="bank_list">
							<dl class="checkbox_item">
								<dd data-type="weixin">
									<a href="javascript:void(0);"><img src="images/default/pay3.png"></a>
								</dd>
							</dl>
						</div>
						<div class="bank_list">
							<dl class="checkbox_item">
								<dd data-type="unionpay">
									<a href="javascript:void(0);"><img src="images/default/pay1.png"></a>
								</dd>
							</dl>
						</div>
					</div>
				</div>
			</li>
			<li class="clearfix"><span>&nbsp;</span><label><input name="agree" type="checkbox" value="1" class="checkbox" checked="checked">我同意<a href="index.php/page/index/292/51.html" target="_blank"><font class="blue">《资金管理协议》</font></a></label> </li>
			<li class="clearfix"><span>&nbsp;</span>
				<a href="javascript:void(0);" class="btn_r" id="goPay">提 交</a>
<!--                <input type="submit" value="提交" id="goPay" class="btn_r">-->
			</li>
		</ul>
	</div>
</div>
<script>
    $(function () {
        $('.bank_list').eq(0).show();
        $(".checkbox_item dd").click(function () {
            $(this).addClass("clickdd").parent().parent().siblings('.bank_list').find('dd').removeClass("clickdd");
        });
        $('.bank_pay li').click(function () {
            $(this).siblings().removeClass('on');
            $(this).addClass('on');
            var index = $('.bank_pay li').index(this);
            $('.bank_list').hide();
            $('.bank_list').eq(index).show();
        });

        $("#goPay").click(function() {
            var pay_type = $("#selectPay dd.clickdd").data('type');
            var money = $('#money').val();
            if(!money){
                my_alert('money',1,'充值金额未填写！');
                return false;
            }
            if(pay_type == 'alipay'){
                $('.m_form').wrap("<form id='alipay_from' action='"+base_url+"index.php/"+controller+"/alipay_pay_recharge' method='post'></form>");
                $("#alipay_from").submit();
            } else if(pay_type == 'weixin') {
                $('.m_form').wrap("<form id='wxpay_from' action='"+base_url+"index.php/"+controller+"/my_pay_weixin_recharge' method='post'></form>");
                $("#wxpay_from").submit();
            } else if(pay_type == 'unionpay'){
                var d = dialog({
                    width: 200,
                    title: '提示',
                    fixed: true,
                    content: '建设中....请选择其他支付方式！'
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 2000);
            }
        });
    });
</script>