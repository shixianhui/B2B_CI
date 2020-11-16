<script type="text/javascript" language="javascript"  src="js/default/jquery.omniwindow.js"></script>
<script>
 //弹窗效果
$(function(){
  var $modal3 = $('div.adder-modal').omniWindow({

      overlay: {
      animations: {
        hide: function(subjects, internalCallback) {
          subjects.overlay.fadeOut(250, function(){
            internalCallback(subjects); // call internal callback AFTER jQuery animations will stop
          })
        },
        show: function(subjects, internalCallback) {
          subjects.overlay.fadeIn(250, function(){
            internalCallback(subjects);
          })
        }
      }
    }
  }
  );
  $('div.adder-modal a.close-button').click(function(e){
    e.preventDefault();
    $modal3.trigger('hide');
  });



  $('a.ex3').click(function(e){
    e.preventDefault();
    $modal3.trigger('show');
    $('#user_address_id').val('');
	$('#title_span').html('添加新的收货地址');
  });
  });

</script>
<section class="warp">
	<div class="cart_border mt30">
		<span class="tit">选择收货地址</span>
		<div class="border_d clearfix">
			<ul class="addr_select clearfix" id="addr_select">
<?php
$default_user_address_id = '';
$default_user_address_str = '';
$default_user_address_str_2 = '';
?>
<?php if ($user_address_list) { ?>
<?php foreach ($user_address_list as $key=>$value) {
          if ($value['is_default']) {
          	$default_user_address_id = $value['id'];
          	$default_user_address_str = "<span>寄送至：</span>{$value['txt_address']}{$value['address']}";
          	$default_user_address_str_2 = "<span>收货人：</span>{$value['buyer_name']}  {$value['mobile']}";
          }
	?>
				<li onclick="javascript:select_user_address('<?php echo $value['id']; ?>');" id="user_address_li_<?php echo $value['id']; ?>" <?php if ($value['is_default']) {echo 'class="is_default active"';} ?>>
					<div class="title">
						<div class="name"><?php echo $value['buyer_name']; ?><span class="space"></span>收</div>
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
					<div class="opn">
						<a onclick="javascript:change_user_address('<?php echo $value['id']; ?>');" href="javascript:void(0);">修改</a><span class="space2"></span>
						<a onclick="javascript:delete_user_address(this,'<?php echo $value['id']; ?>');" href="javascript:void(0);">删除</a>
					</div>
					<i class="ico-yes icon"></i>
				</li>
<?php }} ?>
			</ul>
			<div class="addnew">
				<a class="ex3">+&nbsp;新增收货地址</a>
			</div>
		</div>
	</div>
	<div class="cart_border mt30">
		<span class="tit">确认订单信息<a href="<?php echo getBaseUrl($html, "", "cart.html", $client_index); ?>"><font class="f12" color="#df0679">（返回购物车修改）</font></a></span>
		<div class="border_d clearfix">
<script src="js/default/jquery.form.js"></script>
<script src="js/default/formvalid.js" type="text/javascript"></script>
<script src="js/default/index.js" type="text/javascript"></script>
<form method="post" action="index.php/order/add" name="jsonForm" id="jsonForm">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="order_table">
<?php if ($item_list) { ?>
<?php foreach ($item_list as $item) { ?>
				<thead>
					<tr>
						<th colspan="4"><?php echo $item['store_name'];?></th>
					</tr>
					<tr>
						<td width="730" class="tal">商品信息</td>
						<td width="180" align="center">单价（元）</td>
						<td width="137" align="center">数量</td>
						<td width="151" align="center">金额（元）</td>
					</tr>
				</thead>
				<tbody>
<?php if ($item['cart_list']) { ?>
<?php foreach ($item['cart_list'] as $cart) {
	      $url = getBaseUrl($html, "", "product/detail/{$cart['product_id']}.html", $client_index);
	?>
					<tr>
						<td align="left" valign="top" class="tal">
							<div class="product_info">
								<a href="<?php echo $url; ?>" target="_blank" class="picture fl"><img src="<?php if ($cart['path']) { echo preg_replace('/\./', '_thumb.', $cart['path']);}else{echo 'images/default/load.jpg';} ?>"></a>
								<p>
									<a href="<?php echo $url; ?>"><?php echo $cart['title']; ?></a>
									<br>
									<?php if ($cart['color_size_open']) { ?>
								    <?php echo $cart['product_color_name']; ?>：<?php echo $cart['color_name']; ?><br/>
								    <?php echo $cart['product_size_name']; ?>：<?php echo $cart['size_name']; ?>
								    <?php } ?>
									</p>
							</div>
						</td>
						<td align="center"><s class="tdl"><?php echo $cart['market_price']; ?></s><br><b class="unit red"><?php echo $cart['sell_price']; ?></b></td>
						<td align="center"><?php echo $cart['buy_number']; ?></td>
						<td align="center"><b class="u-price red f14"><?php echo number_format($cart['buy_number']*$cart['sell_price'], 2, '.', ''); ?></b></td>
					</tr>
<?php }} ?>
<tr>
   <td class="cart_legend" style="background: #f8f8f8 none repeat scroll 0 0;" colspan="6"><div class="fl">补充说明（选填）：<input name="store_remark[]" type="text" style="width:260px; height:30px; border:#d6d6d6 1px solid"></div>
   <div class="fr" style="color:#999999;font-size:12px;text-align:right;margin-right:20px;line-height:30px;">
	<span style="margin-left:20px;">运费：￥<span class="taxation_total" id="store_postage_price"><?php echo $item['store_postage_price']; ?></span></span>
	</div>
   <div class="fr"><span class="fl" style="margin-top:8px;">配送方式：</span>
<!--   <input type="hidden" name="store_postage_ids[]" value="--><?php //if ($postage_way_list){echo $postage_way_list[0]['id'];} ?><!--">-->
       <select name="store_postage_ids[]" style="height: 30px;border: #d6d6d6 1px solid;" onchange="javascript:change_postage_way(this,'<?php echo $item['store_cart_ids']; ?>');">
           <option value="">请选择配送方式</option>
        <?php if ($item['postage_way_list']) { ?>
        <?php foreach ($item['postage_way_list'] as $key=>$value) { ?>
                <option value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
        <?php }} ?>
	 </select>
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
<div class="fr mr20" style="color:#999999;font-size:12px;text-align:right;"><span style="margin-left:20px;">店铺合计(含运费)：￥<span class="orange store_total"><?php echo $item['store_total']; ?></span></span></div>
    <input type="hidden" value="<?php echo $item['store_total']; ?>" id="store_product_total">
</td>
</tr>
				</tbody>
<?php }} ?>
			</table>
		</div>
	</div>
	<div class="clear"></div>
	<div class="cart_conunt">
		<p><span>应付金额：</span><b class="red" id="total">￥<?php echo $total; ?></b></p>
		<input valid="required" errmsg="请选择收货地址" type="hidden" id="select_user_address_id" name="select_user_address_id" value="<?php echo $default_user_address_id; ?>">
		<P id="select_user_address"><?php echo $default_user_address_str; ?></P>
		<p id="select_user_address_2"><?php echo $default_user_address_str_2; ?></p>
		<a onclick="javascript:$('form').submit();" href="javascript:void(0);" class="btn_pay mt5">提交订单</a>
	</div>
	<input type="hidden" id="cart_ids" name="cart_ids" value="<?php echo $cart_ids; ?>">
</form>
</section>
<div class="ow-overlay ow-closed"></div>
<div class="adder-modal ow-closed">
	<div class="tit"><span id="title_span">新增收货地址</span>
		<a class='close-button'>×</a>
	</div>
	<ul class="m-form">
		<li class="clearfix"><span>收货人：</span><input maxlength="20" id="buyer_name" type="text" placeholder="请输入姓名" class="input_txt mr35 w255"></li>
		<li class="clearfix"><span>手机：</span><input maxlength="11" id="mobile" type="text" placeholder="请输入正确的手机号码" class="input_txt mr35 w255"> </li>
		<li style="display: none;" class="clearfix"><span>电话号码：</span><input maxlength="20" id="phone" type="text" placeholder="请输入电话号码" class="input_txt mr35 w255"> </li>
		<Li class="clearfix"><span>收货地址：</span>
			<input id="user_address_id" type="hidden" />
		<input id="txt_address" type="hidden" />
		<select id="country_id" onchange="javascript:get_city('country_id','province_id',0,0,1);">
		<option value="">-选择国家-</option>
		<option value="0">-中国-</option>
<!--		--><?php //if ($area_list) { ?>
<!--	    --><?php //foreach ($area_list as $key=>$value) { ?>
<!--	    <option value="--><?php //echo $value['id']; ?><!--">--><?php //echo $value['name']; ?><!--</option>-->
<!--	    --><?php //}} ?>
		</select>
		<select id="province_id" onchange="javascript:get_city('province_id','city_id',0,0,2);">
		<option>-选择省-</option>
		</select>
		<select id="city_id" onchange="javascript:get_city('city_id','area_id',0,0,3);">
		<option>-选择市-</option>
		</select>
		<select id="area_id" onchange="change_area()">
		<option>-选择区/县-</option>
		</select>
			<div class="clear"></div>
			<textarea id="address" class="textarea_txt" placeholder="无需重复填写省市县，长度不超过100个字" style="margin-left:85px"></textarea>
		</Li>
		<li class="clearfix"><span>&nbsp;</span><input id="user_address_default" type="checkbox" value="1" /> 设为默认地址</li>
		<li class="clearfix"><span>&nbsp;</span>
			<a onclick="javascript:add_user_address();" href="javascript:void(0);" class="btn">保存</a>
		</li>
	</ul>
</div>
<script>
var is_sub_click = false;
 //收货地址
$(function(){
	$("#addr_select li").bind({
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
					$("#addr_select li").removeClass("is_default");
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

    if (country_id === '') {
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
					var select_id = $('#addr_select').find('li.active').attr('id');
					var cur_id = 'user_address_li_'+user_address_id;
					var str_class = '';
					if (user_address_id && typeof(user_address_id) != 'undefined') {
						//修改
						//修改选定的项
						if (select_id == cur_id && typeof(select_id) != 'undefined') {
							if (user_address_default ==  1&& typeof(user_address_default) != 'undefined' ) {
								$("#addr_select li").removeClass('active');
								$("#addr_select li").removeClass('is_default');
								str_class = 'class="is_default active"';
							} else {
								$("#addr_select li").removeClass('active');
								str_class = 'class="active"';
							}
						} else {
							if (user_address_default == 1 && typeof(user_address_default) != 'undefined') {
								$("#addr_select li").removeClass('is_default');
								str_class = 'class="is_default"';
							} else {
								str_class = '';
							}
						}
					} else {
						$("#addr_select li").removeClass('active');
						//添加
						if (user_address_default == 1 && typeof(user_address_default) != 'undefined') {
							$("#addr_select li").removeClass('is_default');
							str_class = 'class="is_default active"';
						} else {
							str_class = 'class="active"';
						}
					}
					var html = '<li onclick="javascript:select_user_address('+res.data.id+');" id="user_address_li_'+res.data.id+'" '+str_class+'>';
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
						var size = $('#addr_select').find('li').size();
						if (size == 0) {
							$('#addr_select').html(html);
						} else {
							$('#addr_select').find('li:last').after(html);
						}
                        select_user_address(res.data.id);

					}
					$('div.adder-modal a.close-button').click();
					//事件绑定
					$("#addr_select li").bind({
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
					$('a.ex3').click();
					$('#user_address_id').val(res.data.id);
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
	$('#addr_select li').removeClass('active');
	$('#user_address_li_'+id).addClass('active');
	$.post(base_url+"index.php/"+controller+"/get_user_address",
			{	"id": id
			},
			function(res){
				if(res.success){
					$('#select_user_address_id').val(id);
					//运费
                    $("select[name='store_postage_ids[]']").each(function () {
                        if($(this).val()){
                            $(this).trigger("change");
                        }
                    });
					$('#select_user_address').html('<span>寄送至：</span>'+res.data.txt_address+res.data.address);
					$('#select_user_address_2').html('<span>收货人：</span>'+res.data.buyer_name+'  '+res.data.mobile);

				}
			},
			"json"
	);
}


/**
 * 选择快递线路
 * @param postage_id
 */
function change_postage_way(obj, store_cart_ids) {
    var select_user_address_id = $('#select_user_address_id').val();
    if (!select_user_address_id) {
        return my_alert('select_user_address_id', 1, '请选择收货地址');
    }
    var postage_id = $(obj).val();
    if (!postage_id) {
        return my_alert('postage_id', 1, '请选择配送线路');
    }
    //选择线路
    $.post(base_url+"index.php/order/get_postage_way_info",
        {	"postage_id": postage_id,
            "user_address_id":select_user_address_id,
            "store_cart_ids":store_cart_ids
        },
        function(res){
            if(res.success){
                //店铺
                $(obj).parent().parent().find('#store_postage_price').html(res.data.postage_price);

                var store_product_total = $(obj).parent().parent().parent().parent().find('#store_product_total').val();
                var store_total = (parseFloat(store_product_total)+parseFloat(res.data.postage_price)).toFixed(2);
                $(obj).parent().parent().parent().parent().find('.store_total').html(store_total);
                //总计

                var total = 0;
                $(".store_total").each(function(i,n){
                    total += parseFloat($(this).html());
                });

                $('#total').html('￥'+total.toFixed(2));
            } else {
                return my_alert('fail', 0, res.message);
            }
        },
        "json"
    );
}
</script>