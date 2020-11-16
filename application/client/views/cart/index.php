<section id="cart_list" class="warp">
<form method="post" action="index.php/cart/confirm.html" name="jsonForm" id="jsonForm">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="cart_table mt20">
		<thead>
			<tr>
				<td width="45"><input onclick="javascript:select_all(this);" type="checkbox" class="choose_all" value=""></td>
				<td width="99" class="tal"><span style="margin-left:-10px;">全选</span></td>
				<td width="411" class="tal">商品信息</td>
				<td width="183">单价（元）</td>
				<td width="202">数量</td>
				<td width="134">金额（元）</td>
				<td width="126">操作</td>
			</tr>
		</thead>
	</table>
<?php if ($item_list) { ?>
<?php foreach ($item_list as $item) { ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="cart_table mt20 cart_list">
		<thead>
			<tr>
				<th colspan="7"><input onclick="javascript:select_store(this);" type="checkbox" class="store" value=""><?php echo $item['store_name']; ?></th>
			</tr>
		</thead>
		<tbody>
<?php if ($item['cart_list']) { ?>
<?php foreach ($item['cart_list'] as $cart) {
	      $url = getBaseUrl($html, "", "product/detail/{$cart['product_id']}.html", $client_index);
	?>
			<tr>
				<td width="41"><input name="cart_ids[]" onclick="javascript:select_item(this);" type="checkbox" class="choose" value="<?php echo $cart['id']; ?>"></td>
				<td width="100" class="tal">
					<a href="<?php echo $url; ?>" target="_blank" class="picture"><img src="<?php if ($cart['path']) { echo preg_replace('/\./', '_thumb.', $cart['path']);}else{echo 'images/default/load.jpg';} ?>"></a>
				</td>
				<td width="416" valign="top" class="tal lh18">
					<a href="<?php echo $url; ?>"><?php echo $cart['title']; ?></a>
					<p>
	<?php if ($cart['color_size_open']) { ?>
    <?php echo $cart['product_color_name']; ?>：<?php echo $cart['color_name']; ?><br/>
    <?php echo $cart['product_size_name']; ?>：<?php echo $cart['size_name']; ?>
    <?php } ?>
					</p>
				</td>
				<td width="180"><s class="tdl"><?php echo $cart['market_price']; ?></s><br><b class="unit red"><?php echo $cart['sell_price']; ?></b></td>
				<td width="207">
					<div class="amount">
						<a href="javascript:void(0);" onclick="javascript:increase(this, '<?php echo $cart['id']; ?>', '<?php echo $cart['sell_price']; ?>');" class="Increase">+</a>
						<input onchange="javascript:change_num(this, '<?php echo $cart['id']; ?>', '<?php echo $cart['sell_price']; ?>');" type="text" value="<?php echo $cart['buy_number']; ?>" class="unum">
						<a href="javascript:void(0);" onclick="javascript:reduce(this, '<?php echo $cart['id']; ?>', '<?php echo $cart['sell_price']; ?>');" class="Reduce">-</a>
					</div>
				</td>
				<td width="130"><b class="u-price red f14"><?php echo number_format($cart['buy_number']*$cart['sell_price'], 2, '.', ''); ?></b></td>
				<td width="126">
					<a onclick="javascript:move_to_favorite(this, '<?php echo $cart['id']; ?>');" href="javascript:void(0);">移入收藏夹</a><br>
					<a onclick="javascript:delete_item(this, '<?php echo $cart['id']; ?>');" href="javascript:void(0);" class="btn-del">×</a>
				</td>
			</tr>
<?php }} ?>
		<tr store_id="<?php echo $item['store_id']; ?>">
		<td colspan="7">
		<div class="fr mr20" style="color:#999999;font-size:12px;text-align:right;"><span>活动优惠：－￥<span class="discount_total">0.00</span></span><span style="margin-left:20px;">商品应付总计：￥<span class="product_total">0.00</span></span><span style="margin-left:20px;">商品税费：￥<span class="taxation_total">0.00</span></span></div>
		</td>
		</tr>
		</tbody>
	</table>
<?php }} ?>
	<div class="cart_count mt20">
		<div class="fl"><label><input onclick="javascript:select_all(this);" type="checkbox" class="choose_all" value=""> 全选</label>
			<a onclick="javascript:batch_delete_item();" href="javascript:void(0);"  class="ml20">删除选中商品</a>
		</div>
		<div class="fr">已选商品<b class="purple" id="select_num"> 1 </b>件 <span class="ml10">合计（不含运费）：￥<b id="total" class="t-price purple f14">0.00</b></span>
			<a onclick="javascript:go_buy();" href="javascript:void(0);" class="btn_pay">
				<font color="#fff">结算</font>
			</a>
		</div>
		<div class="fr mr20" style="color:#999999;font-size:12px;text-align:right;"><span>活动优惠：－￥<span id="discount_total">0.00</span></span><span style="margin-left:20px;">商品应付总计：￥<span id="product_total">0.00</span></span><span style="margin-left:20px;">商品税费：￥<span id="taxation_total">0.00</span></span></div>
	</div>
</form>
</section>
<script type="text/javascript">
/********************选定操作开始*******************/
//所有
function select_all(obj) {
	if($(obj).attr("checked") == "checked"){
		$('input[type=checkbox]').prop('checked', true);
	} else {
		$('input[type=checkbox]').prop('checked', false);
	}
	get_select_num();
}
//店铺
function select_store(obj) {
	if($(obj).attr("checked") == "checked"){
		$(obj).parent().parent().parent().parent().find("input[type=checkbox]").prop('checked', true);
		var num = $('input[type=checkbox].store').size();
		var select_num = $('input[type=checkbox].store:checked').size();
		if(num == select_num) {
			$('input[type=checkbox].choose_all').prop('checked', true);
		}
	} else {
		$(obj).parent().parent().parent().parent().find("input[type=checkbox]").prop('checked', false);
		$('input[type=checkbox].choose_all').prop('checked', false);
	}
	get_select_num();
}
//商品
function select_item(obj) {
	if($(obj).attr("checked") == "checked"){
		//店
		var num = $(obj).parent().parent().parent().parent().find("input[type=checkbox].choose").size();
		var select_num = $(obj).parent().parent().parent().parent().find("input[type=checkbox].choose:checked").size();
		if (num == select_num) {
			$(obj).parent().parent().parent().parent().find("input[type=checkbox].store").prop('checked', true);
		}
		//所有
		var all_num = $('#cart_list').find("input[type=checkbox].choose").size();
		var all_select_num = $('#cart_list').find("input[type=checkbox].choose:checked").size();
		if (all_num == all_select_num) {
			$('input[type=checkbox].choose_all').prop('checked', true);
		}
	} else {
		//取消选定
		$(obj).parent().parent().parent().parent().find("input[type=checkbox].store").prop('checked', false);
		$('input[type=checkbox].choose_all').prop('checked', false);
	}
	get_select_num();
}
get_select_num();
//获取商品件数
function get_select_num() {
	//获取选定商品件数－不是总数量
	var all_select_num = $('#cart_list').find("input[type=checkbox].choose:checked").size();
    var ids = '';
    $('#cart_list').find("input[type=checkbox].choose:checked").each(function(i,n){
    	ids+=$(this).val()+',';
	});
    $.post(base_url+"index.php/"+controller+"/get_select_cart_info",
			{	"ids": ids.substr(0, ids.length - 1)
			},
			function(res){
				if(res.success){
					$('#discount_total').html(res.data.discount_total);
					$('#taxation_total').html(res.data.taxation_total);
					$('#product_total').html(res.data.product_total);
					$('#total').html(res.data.total);
					$('#select_num').html(res.data.select_num);
                    //店级统计
					$('#cart_list').find('table.cart_list').find('tr:last').each(function(i,n) {
						var yes = false;
						for(i = 0, data = res.data.item_list; i < data.length; i++) {
							if (data[i].store_id == $(this).attr('store_id')) {
								$(this).find('.discount_total').html(data[i].store_discount_total);
		 						$(this).find('.product_total').html(data[i].store_product_total);
		 						$(this).find('.taxation_total').html(data[i].store_taxation_total);
								yes = true;
								break;
							}
						}
						if (yes == false) {
							$(this).find('.discount_total').html('0.00');
	 						$(this).find('.product_total').html('0.00');
	 						$(this).find('.taxation_total').html('0.00');
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

//减
function reduce(obj, cart_id, price) {
	var buy_num = $(obj).parent().find('input[type=text]').val();
	if (buy_num <= 1) {
        var d = dialog({
			fixed: true,
		    title: '提示',
		    content: '数量不能再减了'
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    } else {
    	var ids = '';
        $('#cart_list').find("input[type=checkbox].choose:checked").each(function(i,n){
        	ids+=$(this).val()+',';
    	});
    	$(obj).parent().find('input[type=text]').val(buy_num - 1);
    	$.post(base_url+"index.php/"+controller+"/change_buy_number",
    			{	"buy_number": parseInt(parseInt(buy_num) - 1),
			        "cart_id": cart_id,
			        "ids": ids.substr(0, ids.length - 1)
    			},
    			function(res){
    				if(res.success){
    					//金额
        				var tmp_total = parseFloat(parseFloat(price)*parseFloat(buy_num - 1)).toFixed(2);
    					$(obj).parent().parent().parent().find('.u-price.orange.f14').html(tmp_total);

    					$('#discount_total').html(res.data.discount_total);
    					$('#taxation_total').html(res.data.taxation_total);
    					$('#product_total').html(res.data.product_total);
    					$('#total').html(res.data.total);
    					$('#select_num').html(res.data.select_num);
    					//店级统计
    					$('#cart_list').find('table.cart_list').find('tr:last').each(function(i,n) {
    						var yes = false;
    						for(i = 0, data = res.data.item_list; i < data.length; i++) {
    							if (data[i].store_id == $(this).attr('store_id')) {
    								$(this).find('.discount_total').html(data[i].store_discount_total);
    		 						$(this).find('.product_total').html(data[i].store_product_total);
    		 						$(this).find('.taxation_total').html(data[i].store_taxation_total);
    								yes = true;
    								break;
    							}
    						}
    						if (yes == false) {
    							$(this).find('.discount_total').html('0.00');
    	 						$(this).find('.product_total').html('0.00');
    	 						$(this).find('.taxation_total').html('0.00');
    						}
    					});
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
}

//加
function increase(obj, cart_id, price) {
	var buy_num = $(obj).parent().find('input[type=text]').val();
	var ids = '';
    $('#cart_list').find("input[type=checkbox].choose:checked").each(function(i,n){
    	ids+=$(this).val()+',';
	});
	$.post(base_url+"index.php/"+controller+"/change_buy_number",
			{	"buy_number": parseInt(parseInt(buy_num) + 1),
		        "cart_id": cart_id,
		        "ids": ids.substr(0, ids.length - 1)
			},
			function(res){
				if(res.success){
					//金额
    				var tmp_total = parseFloat(parseFloat(price)*parseInt(parseInt(buy_num) + 1)).toFixed(2);
					$(obj).parent().parent().parent().find('.u-price.orange.f14').html(tmp_total);

					$(obj).parent().find('input[type=text]').val(parseInt(parseInt(buy_num) + 1));
					$('#discount_total').html(res.data.discount_total);
					$('#taxation_total').html(res.data.taxation_total);
					$('#product_total').html(res.data.product_total);
					$('#total').html(res.data.total);
					$('#select_num').html(res.data.select_num);

					//店级统计
					$('#cart_list').find('table.cart_list').find('tr:last').each(function(i,n) {
						var yes = false;
						for(i = 0, data = res.data.item_list; i < data.length; i++) {
							if (data[i].store_id == $(this).attr('store_id')) {
								$(this).find('.discount_total').html(data[i].store_discount_total);
		 						$(this).find('.product_total').html(data[i].store_product_total);
		 						$(this).find('.taxation_total').html(data[i].store_taxation_total);
								yes = true;
								break;
							}
						}
						if (yes == false) {
							$(this).find('.discount_total').html('0.00');
	 						$(this).find('.product_total').html('0.00');
	 						$(this).find('.taxation_total').html('0.00');
						}
					});
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
//直接修改数量
function change_num(obj, cart_id, price) {
	var buy_num = $(obj).val();
	if (buy_num < 1) {
        var d = dialog({
			fixed: true,
		    title: '提示',
		    content: '数量不能小于1'
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    }
	var ids = '';
    $('#cart_list').find("input[type=checkbox].choose:checked").each(function(i,n){
    	ids+=$(this).val()+',';
	});
	$.post(base_url+"index.php/"+controller+"/change_buy_number",
			{	"buy_number": buy_num,
		        "cart_id": cart_id,
		        "ids": ids.substr(0, ids.length - 1)
			},
			function(res){
				if(res.success){
					//金额
    				var tmp_total = parseFloat(parseFloat(price)*parseFloat(buy_num)).toFixed(2);
					$(obj).parent().parent().parent().find('.u-price.orange.f14').html(tmp_total);

					$('#discount_total').html(res.data.discount_total);
					$('#taxation_total').html(res.data.taxation_total);
					$('#product_total').html(res.data.product_total);
					$('#total').html(res.data.total);
					$('#select_num').html(res.data.select_num);

					//店级统计
					$('#cart_list').find('table.cart_list').find('tr:last').each(function(i,n) {
						var yes = false;
						for(i = 0, data = res.data.item_list; i < data.length; i++) {
							if (data[i].store_id == $(this).attr('store_id')) {
								$(this).find('.discount_total').html(data[i].store_discount_total);
		 						$(this).find('.product_total').html(data[i].store_product_total);
		 						$(this).find('.taxation_total').html(data[i].store_taxation_total);
								yes = true;
								break;
							}
						}
						if (yes == false) {
							$(this).find('.discount_total').html('0.00');
	 						$(this).find('.product_total').html('0.00');
	 						$(this).find('.taxation_total').html('0.00');
						}
					});
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
//删除商品
function delete_item(obj, delete_ids) {
	var ids = '';
	$('#cart_list').find("input[type=checkbox].choose:checked").each(function(i,n){
		ids+=$(this).val()+',';
	});
	$.post(base_url+"index.php/"+controller+"/delete_cart_product",
			{	"select_ids": ids.substr(0, ids.length - 1),
		        "delete_ids": delete_ids
			},
			function(res){
				if(res.success){
                    $('#cart_sum').html(res.data.cart_count);
                    var size = $(obj).parent().parent().parent().children('tr').size();
					if (size == 2) {
						$(obj).parent().parent().parent().parent().remove();
					} else {
						$(obj).parent().parent().remove();
					}
					$('#discount_total').html(res.data.discount_total);
					$('#taxation_total').html(res.data.taxation_total);
					$('#product_total').html(res.data.product_total);
					$('#total').html(res.data.total);
					$('#select_num').html(res.data.select_num);

					//店级统计
					$('#cart_list').find('table.cart_list').find('tr:last').each(function(i,n) {
						var yes = false;
						for(i = 0, data = res.data.item_list; i < data.length; i++) {
							if (data[i].store_id == $(this).attr('store_id')) {
								$(this).find('.discount_total').html(data[i].store_discount_total);
		 						$(this).find('.product_total').html(data[i].store_product_total);
		 						$(this).find('.taxation_total').html(data[i].store_taxation_total);
								yes = true;
								break;
							}
						}
						if (yes == false) {
							$(this).find('.discount_total').html('0.00');
	 						$(this).find('.product_total').html('0.00');
	 						$(this).find('.taxation_total').html('0.00');
						}
					});
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
//批量删除
function batch_delete_item() {
	var ids = '';
	$('#cart_list').find("input[type=checkbox].choose:checked").each(function(i,n){
		ids+=$(this).val()+',';
	});
	if (!ids) {
		var d = dialog({
			fixed: true,
		    title: '提示',
		    content: '请选择删除项'
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
	    return false;
	}
	$.post(base_url+"index.php/"+controller+"/batch_delete_cart_product",
			{	"delete_ids": ids.substr(0, ids.length - 1)
			},
			function(res){
				if(res.success){
                    $('#cart_sum').html(res.data.cart_count);
                    $('#cart_list').find("input[type=checkbox].choose:checked").each(function(i,n){
	 					var size = $(this).parent().parent().parent().children('tr').size();
	 					if (size == 2) {
	 						$(this).parent().parent().parent().parent().remove();
	 					} else {
	 						$(this).parent().parent().remove();
	 					}
					});
					$('#discount_total').html(res.data.discount_total);
					$('#taxation_total').html(res.data.taxation_total);
					$('#product_total').html(res.data.product_total);
					$('#total').html(res.data.total);
					$('#select_num').html(res.data.select_num);

					//店级统计
					$('#cart_list').find('table.cart_list').find('tr:last').each(function(i,n) {
						var yes = false;
						for(i = 0, data = res.data.item_list; i < data.length; i++) {
							if (data[i].store_id == $(this).attr('store_id')) {
								$(this).find('.discount_total').html(data[i].store_discount_total);
		 						$(this).find('.product_total').html(data[i].store_product_total);
		 						$(this).find('.taxation_total').html(data[i].store_taxation_total);
								yes = true;
								break;
							}
						}
						if (yes == false) {
							$(this).find('.discount_total').html('0.00');
	 						$(this).find('.product_total').html('0.00');
	 						$(this).find('.taxation_total').html('0.00');
						}
					});
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
//移入收藏夹
function move_to_favorite(obj, cart_id) {
	var ids = '';
	$('#cart_list').find("input[type=checkbox].choose:checked").each(function(i,n){
		ids+=$(this).val()+',';
	});
	$.post(base_url+"index.php/"+controller+"/move_product_to_favorite",
			{	"select_ids": ids.substr(0, ids.length - 1),
		        "cart_id": cart_id
			},
			function(res){
				if(res.success){
					var size = $(obj).parent().parent().parent().children('tr').size();
					if (size == 2) {
						$(obj).parent().parent().parent().parent().remove();
					} else {
						$(obj).parent().parent().remove();
					}
					$('#discount_total').html(res.data.discount_total);
					$('#taxation_total').html(res.data.taxation_total);
					$('#product_total').html(res.data.product_total);
					$('#total').html(res.data.total);
					$('#select_num').html(res.data.select_num);

					//店级统计
					$('#cart_list').find('table.cart_list').find('tr:last').each(function(i,n) {
						var yes = false;
						for(i = 0, data = res.data.item_list; i < data.length; i++) {
							if (data[i].store_id == $(this).attr('store_id')) {
								$(this).find('.discount_total').html(data[i].store_discount_total);
		 						$(this).find('.product_total').html(data[i].store_product_total);
		 						$(this).find('.taxation_total').html(data[i].store_taxation_total);
								yes = true;
								break;
							}
						}
						if (yes == false) {
							$(this).find('.discount_total').html('0.00');
	 						$(this).find('.product_total').html('0.00');
	 						$(this).find('.taxation_total').html('0.00');
						}
					});
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
/********************选定操作结束*******************/
function go_buy() {
	var ids = '';
	$('#cart_list').find("input[type=checkbox].choose:checked").each(function(i,n){
		ids+=$(this).val()+',';
	});
	if (!ids) {
		var d = dialog({
			fixed: true,
		    title: '提示',
		    content: '请选择结算商品'
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
		return false;
	}
	$('#jsonForm').submit();
}
</script>