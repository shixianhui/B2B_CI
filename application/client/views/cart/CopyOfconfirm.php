<link rel="stylesheet" type="text/css" href="css/default/style.css"/>
<section class="warp">
<div class="cart_main clearfix mt30">
<div class="cart_tit "><span class="bt">选择收货地址</span></div>
<ul class="addr-list clearfix" id="addr-list">
<?php
$default_user_address_id = '';
$default_user_address_str = '';
?>
<?php if ($user_address_list) { ?>
<?php foreach ($user_address_list as $key=>$value) {
          if ($value['is_default']) {
          	$default_user_address_id = $value['id'];
          	$default_user_address_str = "寄送至：{$value['txt_address']}{$value['address']}<br/>收货人：{$value['buyer_name']}  {$value['mobile']}";
          }
	?>
<li onclick="javascript:select_user_address('<?php echo $value['id']; ?>');" id="user_address_li_<?php echo $value['id']; ?>" <?php if ($value['is_default']) {echo 'class="is_default active"';} ?>>
<div class="title">
<div class="name"><?php echo $value['buyer_name']; ?><span class="space"></span> 收</div>
<div class="default">
<a onclick="javascript:set_default_user_address(this,'<?php echo $value['id']; ?>');" href="javascript:void(0);" class="set red">设为默认</a>
<span class="ok">默认地址</span>
</div>
</div>
<div class="text-box">
<p><?php echo $value['txt_address']; ?></p>
<p><?php echo $value['address']; ?></p>
<p><?php echo createMobileBit($value['mobile']); ?></p>
</div>
<div class="opn"><a onclick="javascript:change_user_address('<?php echo $value['id']; ?>');" href="javascript:void(0);">修改</a><span class="space2"></span><a onclick="javascript:delete_user_address(this,'<?php echo $value['id']; ?>');" href="javascript:void(0);">删除</a></div>
<i class="ico-yes m_icon"></i>
</li>
<?php }} ?>
<li class="add_new">
<a href="javascript:void(0);">+添加新地址</a>
</li>
</ul>
 <!-- 添加地址开始 -->
<div class="alert_box">
	<h3><span id="title_span">添加新的收货地址</span><a href="javascript:void(0);" class="fr"></a></h3>
	<div class="alert_where">
		<span>所在地区：</span>
		<input id="user_address_id" type="hidden" />
		<input id="txt_address" type="hidden" />
		<select id="country_id" onchange="javascript:get_city('country_id','province_id',0,0,1);">
		<option value="">-选择国家-</option>
		<?php if ($area_list) { ?>
	    <?php foreach ($area_list as $key=>$value) { ?>
	    <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
	    <?php }} ?>
		</select>
		<select id="province_id" onchange="javascript:get_city('province_id','city_id',0,0,2);">
		<option>-选择省-</option>
		</select>
		<select id="city_id" onchange="javascript:get_city('city_id','area_id',0,0,3);">
		<option>-选择市-</option>
		</select>
		<select id="area_id" onchange="javascript:change_area();">
		<option>-选择区/县-</option>
		</select>
	</div>
	<div class="alert_detailed">
		<span class="fl">详细地址：</span>
		<textarea id="address" maxlength="100" style="height:60px;"placeholder="无需重复填写国家省市县，长度不超过100个字"></textarea>
	</div>
	<div class="alert_name">
		<span>收货人姓名：</span>
		<input maxlength="20" id="buyer_name" type="text" placeholder="请输入姓名" style="width:228px;" />
	</div>

	<div class="alert_tel">
		<span>手机号码：</span>
		<input maxlength="11" id="mobile" type="text" placeholder="请输入正确的手机号码" />
	</div>

	<div class="alert_phone">
		<span>电话号码：</span>
		<input maxlength="20" id="phone" class="m_phone_text" type="text" style="width:228px;" placeholder="请输入电话号码" />
		<p><input id="user_address_default" type="checkbox" value="1" />&nbsp;&nbsp;设置为默认收货地址</p>
		<a onclick="javascript:add_user_address();" href="javascript:void(0);">确认保存</a>
	</div>

</div>
<div class="mask"></div>
 <!-- 添加地址结束 -->
<div class="cart_tit mt20"><span class="bt">订单确认</span></div>
<script src="js/default/jquery.form.js"></script>
<script src="js/default/formvalid.js" type="text/javascript"></script>
<script src="js/default/index.js" type="text/javascript"></script>
<form method="post" action="index.php/order/add" name="jsonForm" id="jsonForm">
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="mt20 cart_table" >
<?php if ($item_list) { ?>
<?php foreach ($item_list as $item) { ?>
<thead>
<tr>
<td style="text-align: left;height:40px;vertical-align:bottom;" colspan="6"><strong><?php echo $item['store_name']; ?></strong></td>
</tr>
</thead>
<tr>
<th class="tac">商品信息</th>
<th width="150" class="tac">&nbsp;</th>
<th width="140" class="tac">重量(千克)</th>
<th width="140" class="tac">单价（元）</th>
<th width="140" class="tac">数量</th>
<th width="114" class="tac">小计（不含税）</th>
</tr>
<?php if ($item['cart_list']) { ?>
<?php foreach ($item['cart_list'] as $cart) {
	      $url = getBaseUrl($html, "", "product/detail/{$cart['product_id']}.html", $client_index);
	?>
<tr>
    <td class="tal p_info"><a href="<?php echo $url; ?>" target="_blank"><span class="picture"><img src="<?php if ($cart['path']) { echo preg_replace('/\./', '_thumb.', $cart['path']);}else{echo 'images/default/load.jpg';} ?>"></span><?php echo $cart['title']; ?></a></td>
    <td style="text-align: left;color:#999;font-size:12px;" valign="top">
    <?php if ($cart['color_size_open']) { ?>
    <?php echo $cart['product_color_name']; ?>：<?php echo $cart['color_name']; ?><br/>
    <?php echo $cart['product_size_name']; ?>：<?php echo $cart['size_name']; ?>
    <?php } ?>
    </td>
    <td>
   <span class="unit"><?php echo $cart['weight']; ?></span>
    </td>
    <td><span class="unit"><?php echo $cart['sell_price']; ?></span></td>
    <td>x<?php echo $cart['buy_number']; ?></td>
    <td><span class="u-price orange f14"><?php echo number_format($cart['buy_number']*$cart['sell_price'], 2, '.', ''); ?></span></td>
</tr>
<?php }} ?>
<tr>
   <td class="cart_legend" style="background: #f8f8f8 none repeat scroll 0 0;" colspan="6"><div class="fl">补充说明（选填）：<input name="store_remark[]" type="text" style="width:260px; height:30px; border:#d6d6d6 1px solid"></div>
   <div class="fr" style="color:#999999;font-size:12px;text-align:right;margin-right:20px;line-height:30px;">
	<span style="margin-left:20px;">运费：￥<span class="taxation_total"><?php echo $item['store_postage_price']; ?></span></span>
	</div>
   <div class="fr"><span class="fl" style="margin-top:8px;">配送方式：</span>
   <input type="hidden" name="store_postage_ids[]" value="<?php if ($postage_way_list){echo $postage_way_list[0]['id'];} ?>">
   <dl class="select w160">
		<dt><?php if ($postage_way_list){echo $postage_way_list[0]['title'];} ?></dt>
		<dd>
        <div class="select_txt">
        <?php if ($postage_way_list) { ?>
        <?php foreach ($postage_way_list as $key=>$value) { ?>
        <p><a postage_id="<?php echo $value['id']; ?>" href="javascript:viod(0);"><?php echo $value['title']; ?></a></p>
        <?php }} ?>
		</div>
		</dd>
	</dl>
	</div>
	</td>
   </tr>
<tr>
<td class="cart_legend" style="border-top:none;background: #f8f8f8 none repeat scroll 0 0;" colspan="6">
<div class="fr mr20" style="color:#999999;font-size:12px;text-align:right;"><span style="margin-left:20px;">税费：￥<span class="taxation_total"><?php echo $item['store_taxation_total']; ?></span></span></div>
</td>
</tr>
<tr>
<td class="cart_legend" style="border-top:none;background: #f8f8f8 none repeat scroll 0 0;" colspan="6">
<div class="fr mr20" style="color:#999999;font-size:12px;text-align:right;"><span style="margin-left:20px;">优惠：－￥<span class="taxation_total"><?php echo $item['store_discount_total']; ?></span></span></div>
</td>
</tr>
<tr>
<td class="cart_legend" style="border-top:none;background: #f8f8f8 none repeat scroll 0 0;" colspan="6">
<div class="fr mr20" style="color:#999999;font-size:12px;text-align:right;"><span style="margin-left:20px;">店铺合计(含运费)：￥<span class="taxation_total orange"><?php echo $item['store_total']; ?></span></span></div>
</td>
</tr>
<?php }} ?>
</table>
<div class="cart_count mt20">
 <p>应付金额：<span class="orange f18"><small>￥</small><?php echo $total; ?></span></p>
</div>
<div class="cart_adder clear mt20">
<a onclick="javascript:$('form').submit();" href="javascript:void(0);" class="btn_pay fr">提交订单</a>
<input valid="required" errmsg="请选择收货地址" type="hidden" id="select_user_address_id" name="select_user_address_id" value="<?php echo $default_user_address_id; ?>">
<p id="select_user_address" class="fr" style="margin-right:200px;"><?php echo $default_user_address_str; ?></p>
</div>
<input type="hidden" id="cart_ids" name="cart_ids" value="<?php echo $cart_ids; ?>">
</form>
</div>
</section>
<div class="clear"></div>
<script language="javascript" type="text/javascript">
var is_sub_click = false;
function show_div() {
	$('.mask').css({'display':'block','width':$(window).width(),'height':$(window).height()});
	$('.alert_box').css({
		'display':'block',
		'top':$(window).height()/2,
		'left':$(window).width()/2,
		'marginLeft':-$('.alert_box').width()/2,
		'marginTop':-$('.alert_box').height()/2
	});
}
$(function(){
	$('.add_new').on('click',function(){
		$('#user_address_id').val('');
		$('#title_span').html('添加新的收货地址');
		show_div();
		return false;
	});

	$('.alert_box a.fr').on('click',function(){
		$('.mask').css('display','none');
		$('.alert_box').css('display','none');
	});
});

$(function(){
	$("#addr-list li").bind({
		mouseenter:function(){
			$(this).addClass("current");
			},
		mouseleave:function(){
			$(this).removeClass("current");
			}
	});
});
//删除收货地址
function delete_user_address(obj,id) {
	is_sub_click = true;
	$.post(base_url+"index.php/"+controller+"/delete_user_address",
			{	"id": id
			},
			function(res){
				if(res.success){
					$(obj).parent().parent().remove();
				}else{
					var d = dialog({
						fixed: true,
					    title: '提示',
					    content: res.message
					});
					d.show();
					setTimeout(function () {
					    d.close().remove();
					}, 2000);
			        return false;
				}
			},
			"json"
	);
}
//设置默认的用户地址
function set_default_user_address(obj, id) {
	is_sub_click = true;
	$.post(base_url+"index.php/"+controller+"/set_default_user_address",
			{	"id": id
			},
			function(res){
				if(res.success){
					$("#addr-list li").removeClass("is_default");
					$(obj).parent().parent().parent().addClass("is_default");
				}else{
					var d = dialog({
						fixed: true,
					    title: '提示',
					    content: res.message
					});
					d.show();
					setTimeout(function () {
					    d.close().remove();
					}, 2000);
			        return false;
				}
			},
			"json"
	);
}

function change_area() {
	//国 省 市 县
	var country_id_txt = $("#country_id").find("option:selected").text();
	var province_id_txt = $("#province_id").find("option:selected").text();
	var city_id_txt = $("#city_id").find("option:selected").text();
	var area_id_txt = $("#area_id").find("option:selected").text();
	$("#txt_address").val(country_id_txt+' '+province_id_txt+' '+city_id_txt+' '+area_id_txt);
}

function get_city(cur_id, next_id, next_select_val, prev_select_val, is_city) {
	var parent_id = $("#"+cur_id).val();
	if (prev_select_val) {
		parent_id = prev_select_val;
	}
	$.post(base_url+"index.php/"+controller+"/get_city",
			{	"parent_id": parent_id
			},
			function(res){
				if(res.success){
					var html = '';
					if (is_city == 1) {
						html = '<option value="">-选择省-</option>';
					} else if (is_city == 2) {
						html = '<option value="">-选择市-</option>';
					} else if (is_city == 3) {
						html = '<option value="">-选择区/县-</option>';
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
					var d = dialog({
						fixed: true,
					    title: '提示',
					    content: res.message
					});
					d.show();
					setTimeout(function () {
					    d.close().remove();
					}, 2000);
			        return false;
				}
			},
			"json"
	);
}
//添加收货地址
function add_user_address() {
	var user_address_id = $('#user_address_id').val();
    var txt_address = $('#txt_address').val();
    var country_id = $('#country_id').val();
    var province_id = $('#province_id').val();
    var city_id = $('#city_id').val();
    var area_id = $('#area_id').val();
    var address = $('#address').val();
    var buyer_name = $('#buyer_name').val();
    var mobile = $('#mobile').val();
    var phone = $('#phone').val();
    var user_address_default = $('#user_address_default:checked').val();

    if (!country_id) {
    	var d = dialog({
			fixed: true,
		    title: '提示',
		    content: "请选择国家或地区"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    }
    if (!address) {
    	$('#address').focus();
    	var d = dialog({
			fixed: true,
		    title: '提示',
		    content: "请填写详细地址"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    }
    if (!buyer_name) {
    	$('#buyer_name').focus();
    	var d = dialog({
			fixed: true,
		    title: '提示',
		    content: "请填写收货人姓名"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    }
    if (!mobile) {
    	$('#mobile').focus();
    	var d = dialog({
			fixed: true,
		    title: '提示',
		    content: "请填写手机号码"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    }
    var reg = /^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/;
	if(!reg.test(mobile)) {
		$('#mobile').focus();
		var d = dialog({
			fixed: true,
		    title: '提示',
		    content: "请填写正确的手机号码"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
	}
	$.post(base_url+"index.php/"+controller+"/save_user_address",
			{	"buyer_name": buyer_name,
		        "country_id": country_id,
		        "province_id": province_id,
		        "city_id": city_id,
		        "area_id": area_id,
		        "address": address,
		        "txt_address": txt_address,
		        "phone": phone,
		        "mobile": mobile,
		        "is_default": user_address_default == 1?user_address_default:0,
				"id":user_address_id
			},
			function(res){
				if(res.success){
					$('#user_address_id').val('');
					//获取选定状态ID
					var select_id = $('#addr-list').find('li.active').attr('id');
					var cur_id = 'user_address_li_'+user_address_id;
					var str_class = '';
					if (user_address_id && typeof(user_address_id) != 'undefined') {
						//修改
						//修改选定的项
						if (select_id == cur_id && typeof(select_id) != 'undefined') {
							if (user_address_default ==  1&& typeof(user_address_default) != 'undefined' ) {
								$("#addr-list li").removeClass('active');
								$("#addr-list li").removeClass('is_default');
								str_class = 'class="is_default active"';
							} else {
								$("#addr-list li").removeClass('active');
								str_class = 'class="active"';
							}
						} else {
							if (user_address_default == 1 && typeof(user_address_default) != 'undefined') {
								$("#addr-list li").removeClass('is_default');
								str_class = 'class="is_default"';
							} else {
								str_class = '';
							}
						}
					} else {
						$("#addr-list li").removeClass('active');
						//添加
						if (user_address_default == 1 && typeof(user_address_default) != 'undefined') {
							$("#addr-list li").removeClass('is_default');
							str_class = 'class="is_default active"';
						} else {
							str_class = 'class="active"';
						}
					}
					var html = '<li id="user_address_li_'+res.data.id+'" '+str_class+'>';
					    html += '<div class="title">';
					    html += '<div class="name">'+buyer_name+'<span class="space"></span> 收</div>';
						html += '<div class="default">';
					    html += '<a onclick="javascript:set_default_user_address(this,'+res.data.id+');" href="javascript:void(0);" class="set red">设为默认</a>';
						html += '<span class="ok">默认地址</span>';
						html += '</div>';
						html += '</div>';
						html += '<div class="text-box">';
						html += '<p>'+txt_address+'</p>';
						html += '<p>'+address+'</p>';
						html += '<p>'+res.data.mobile+'</p>';
						html += '</div>';
						html += '<div class="opn"><a onclick="javascript:change_user_address(\''+res.data.id+'\');" href="javascript:void(0);">修改</a><span class="space2"></span><a onclick="javascript:delete_user_address(this,'+res.data.id+');" href="javascript:void(0);">删除</a></div>';
						html += '<i class="ico-yes m_icon"></i>';
						html += '</li>';
					if (user_address_id && typeof(user_address_id) != 'undefined') {
                        $('#user_address_li_'+user_address_id).replaceWith(html);
					} else {
						$('#addr-list').find('li.add_new').before(html);
					}
					$('.mask').css('display','none');
					$('.alert_box').css('display','none');
					//事件绑定
					$("#addr-list li").bind({
						mouseenter:function(){
							$(this).addClass("current");
							},
						mouseleave:function(){
							$(this).removeClass("current");
							}
					});
				}else{
					var d = dialog({
						fixed: true,
					    title: '提示',
					    content: res.message
					});
					d.show();
					setTimeout(function () {
					    d.close().remove();
					}, 2000);
			        return false;
				}
			},
			"json"
	);
}
//修改收货地址
function change_user_address(id) {
	is_sub_click = true;
	$('#title_span').html('编辑收货地址');
	$.post(base_url+"index.php/"+controller+"/get_user_address",
			{	"id": id
			},
			function(res){
				if(res.success){
					$('#user_address_id').val(res.data.id);
					$("#country_id>option").each(function(i,n){
						if($(n).val() == res.data.country_id){
							 $("#country_id").get(0).options[i].selected = true;
						}
					});
					get_city('country_id','province_id',res.data.province_id,res.data.country_id,1);
					get_city('province_id','city_id',res.data.city_id,res.data.province_id,2);
					get_city('city_id','area_id',res.data.area_id,res.data.city_id,3);
					$('#address').val(res.data.address);
					$('#txt_address').val(res.data.txt_address);
					$('#buyer_name').val(res.data.buyer_name);
					$('#mobile').val(res.data.mobile);
					$('#phone').val(res.data.phone);
					if (res.data.is_default == 1) {
						$('#user_address_default').prop('checked', true);
					} else {
						$('#user_address_default').prop('checked', false);
					}
					show_div();
				} else {
					var d = dialog({
						fixed: true,
					    title: '提示',
					    content: res.message
					});
					d.show();
					setTimeout(function () {
					    d.close().remove();
					}, 2000);
			        return false;
				}
			},
			"json"
	);
}
//选择收货地址
function select_user_address(id) {
	//点击了里面的元素，如删除、修改、设置默认地址
	if (is_sub_click == true) {
		is_sub_click = false;
		return;
	}
	$('#addr-list li').removeClass('active');
	$('#user_address_li_'+id).addClass('active');
	$.post(base_url+"index.php/"+controller+"/get_user_address",
			{	"id": id
			},
			function(res){
				if(res.success){
					$('#select_user_address_id').val(id);
					$('#select_user_address').html('寄送至：'+res.data.txt_address+res.data.address+'<br/>收货人：'+res.data.buyer_name+'  '+res.data.mobile);
				}
			},
			"json"
	);
}
</script>