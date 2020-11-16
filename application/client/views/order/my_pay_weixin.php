<style>
    .arrow_icon {
        width: 14px;
        height: 6px;
        display: inline-block;
        background-position: -368px -74px;
        vertical-align: middle;
        margin-left: 5px;
        background: url(images/default/arrow_d.png) no-repeat;
    }
    .cart_table th {
        text-align: center;
        background: #f8f8f8;
    }
    .cart_table {width:auto}
    .cart_table tbody{width: auto}
</style>
<section style="width: 1200px;margin: 0px auto;padding: 50px 0 10px;">
    <div style="float: left;">
        <p style="font-size:16px;">请您及时付款，以便订单为您及时处理哟！<span>订单号：<?php if ($item_info) { echo $item_info['order_number'];} ?></span></p>
    </div>
    <div style="float: right;">
        <p style="color: red;font-size: 20px;">￥<?php echo $total; ?></p>
        <p style="cursor: pointer;font-size:14px;" onclick="javascript:show_detail();">订单详情<span class="m_icon arrow_icon"></span></p>
    </div>
    <div class="clear"></div>

    <div style="display: none;float:right; position:relative" id="order_detail" class="info clearfix">
        <table border="0" cellspacing="0" cellpadding="0" width="100%" class="cart_table" style="width: auto">
            <tr>
                <th width="200" class="tac">订单号</th>
                <th width="200" class="tac">店铺名称</th>
                <th width="200" class="tac">金额（元）</th>
                <th width="200" class="tac">送积分</th>
            </tr>
            <tr>
                <td><?php if ($item_info) {echo $item_info['order_number'];} ?></td>
                <td><?php if ($item_info) {echo $item_info['store_name'];} ?></td>
                <td><?php if ($item_info) {echo $item_info['total'];} ?></td>
                <td><?php if ($item_info) {echo $item_info['score'];} ?></td>
            </tr>
        </table>
    </div>
</section>
<div class="clear"></div>
<section class="warp" style="margin-top: 30px;">
<div class="order_count clearfix" style="background: #fff;">
    <div style="float: left;border-right: #ddd 1px solid;padding: 0 130px 0 40px">
    <img src="images/default/wx3.jpg" style="padding-left: 60px;display: block">
<img alt="模式二扫码支付" src="<?php echo getBaseUrl(false, "", "order/get_weixin_qr", $client_index)."?url=".urlencode($qr_url);?>" style="width:350px;height:350px;"/>
    <img src="images/default/wx2.jpg" style="display: block;padding-left: 60px">
    </div>
    <div style="float: right">
    <img src="images/default/wx1.jpg" style="width: 475px;">
    </div>
<?php if (array_key_exists('result_code', $result) && $result['result_code'] == 'FAIL') {
	echo '&nbsp;原因：'.$result['err_code_des'];
} ?>
</div>
    <div style="padding: 20px 0"><a style="color:#9d9a9a;" href="javascript:history.go(-1);">&lt; 选择其他支付方式</a></div>

</section>
<div class="clear"></div>
<script type="text/javascript">
    function show_detail() {
        if ($('#order_detail').is(':visible') == true) {
            $('#order_detail').hide();
        } else {
            $('#order_detail').show();
        }
    }
function weixin_heart() {
	$.post(base_url+"index.php/"+controller+"/get_weixin_heart",
			{	"out_trade_no":'<?php echo $out_trade_no; ?>'
			},
			function(res){
				if(res.success) {
					if (res.data.trade_status != 'WAIT_BUYER_PAY') {
	                    window.location.href = base_url+'index.php/'+controller+'/pay_result/'+res.data.order_num+'.html';
					}
				}
			},
			"json"
	);
}

window.setInterval("weixin_heart()", 1500);
</script>