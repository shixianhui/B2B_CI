<section class="warp">
	<div class="cart_repeat mt25">
		<div class="bar clearfix">
			<h3 class="fl"><span class="icon"></span>您的订单已提交成功，请尽 快付款！
  <p>请您在提交订单后24小时内完成支付，否则订单会自动取消。</p></h3>
			<span class="price fr">应付金额：<b class="red f18"><?php echo $total; ?></b>元</span>
		</div>
		<P> 收货地址：<?php echo $delivery_address; ?> 收货人：<?php if ($item_info) {echo $item_info['buyer_name'].' '.$item_info['mobile'];} ?></P>
		<?php if ($order_detail_list){
		    foreach ($order_detail_list as $key=>$value){ ?>
        <P>商品名称：<?php echo $value['product_title']; ?> &nbsp;&nbsp;<?php if ($value['product_color_name'] || $value['product_size_name']){ ?>规格：<?php echo $value['color_name'].' '.$value['size_name']; }?></P>
        <?php }} ?>
	</div>
	<div class="cart_border mt30">
		<span class="tit">选择支付方式</span>
		<div class="border_d clearfix">
			<div class="cart_pay">
                <?php if ($user_info && $user_info['total'] >= $total){ ?><div class="balance_pay"><label><input type="checkbox" id="yue">余额支付 </label><span style="padding-left: 20px">账户余额 <b class="red"><?php if ($user_info) { echo $user_info['total'];}else{echo '0.00';}?></b> 元</span><div>支付密码：<input type="password" name="pay_password">
                        <a href="<?php echo getBaseUrl(false,'','user/my_change_pay_pass.html',$client_index);?>" target="_blank" style="color: #666;">忘记密码?</a></div>
                </div><?php }?>
				<div class="bank_pay">
					<div class="hd clearfix">
						<ul id="selectPay">
							<Li>支付宝</Li>
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
			</div>
		</div>
		<div class="clear"></div>
		<a class="btn_pay fr mt30" id="goPay">下一步</a>
	</div>
</section>
<script type="text/javascript">
    $(function () {
        $(".checkbox_item dd").click(function () {
            $(this).addClass("clickdd").parent().parent().siblings('.bank_list').find('dd').removeClass("clickdd");
        });
    });
    $("#goPay").click(function(){
        var pay_type = $("#selectPay dd.clickdd").data('type');
        if($('#yue').attr("checked")){
            $.ajax({
                url : base_url+'index.php/order/my_yue_pay',
                type : 'post',
                data : {
                    order_id: '<?php if ($item_info) {echo $item_info['id'];} ?>',
                    pay_password : $("input[name=pay_password]").val()
                },
                dataType : 'json',
                beforeSend : function(){
                    $("body").append('<div id="loading"></div>');
                },
                success : function(json){
                    $("#loading").remove();
                    var d = dialog({
                        width: 300,
                        title: '提示',
                        fixed: true,
                        content: json.message
                    });
                    d.show();
                    setTimeout(function () {
                        d.close().remove();
                    }, 2000);
                    if(json.success){
                        setTimeout(function () {
                            window.location.href = json.field;
                            d.close().remove();
                        }, 2000);
                    }
                }
            });
        }else if(pay_type == 'alipay'){
            location.href = base_url+'index.php/order/alipay_pay/<?php if ($item_info) {echo $item_info['id'];} ?>.html';
        } else if(pay_type == 'weixin') {
            location.href = base_url+'index.php/'+controller+'/my_pay_weixin/<?php if ($item_info) {echo $item_info['id'];} ?>.html';
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
</script>