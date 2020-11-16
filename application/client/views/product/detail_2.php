<link href="css/default/MagicZoom.css" rel="stylesheet" type="text/css" />
<link href="css/default/member.css?v=1.1" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/default/MagicZoom.js"></script>
<script language="javascript" type="text/javascript" src="js/default/zzsc.js"></script>
<style>
    #page_navigation{
        text-align: center;
        margin-top: 25px;
        height: 40px;
    }
    #page_navigation a{
        border:solid thin #DDDDDD;
        margin:2px;
        padding: 5px 10px;
        color:black;
        text-decoration:none
    }
    .active_page{
        background:#0099FF;
        color:white !important;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        var show_per_page = 10;
        var number_of_items = $('#content').children('.clearfix').size();
        var number_of_pages = Math.ceil(number_of_items/show_per_page);

        $('#current_page').val(0);
        $('#show_per_page').val(show_per_page);
        var navigation_html = '<a class="previous_link" href="javascript:previous();">上一页</a>';
        var current_link = 0;
        while(number_of_pages > current_link){
            navigation_html += '<a class="page_link" href="javascript:go_to_page(' + current_link +')" longdesc="' + current_link +'">'+ (current_link + 1) +'</a>';
            current_link++;
        }
        navigation_html += '<a class="next_link" href="javascript:next();">下一页</a>';
        $('#page_navigation').html(navigation_html);
        $('#page_navigation .page_link:first').addClass('active_page');
        $('#content').children('.clearfix').css('display', 'none');
        $('#content').children('.clearfix').slice(0, show_per_page).css('display', 'block');
    });
    function previous(){
        new_page = parseInt($('#current_page').val()) - 1;
        if($('.active_page').prev('.page_link').length==true){
            go_to_page(new_page);
        }
    }
    function next(){
        new_page = parseInt($('#current_page').val()) + 1;
        //if there is an item after the current active link run the function
        if($('.active_page').next('.page_link').length==true){
            go_to_page(new_page);
        }
    }
    function go_to_page(page_num){
        var show_per_page = parseInt($('#show_per_page').val());
        start_from = page_num * show_per_page;
        end_on = start_from + show_per_page;
        $('#content').children('.clearfix').css('display', 'none').slice(start_from, end_on).css('display', 'block');
        $('.page_link[longdesc=' + page_num +']').addClass('active_page').siblings('.active_page').removeClass('active_page');
        $('#current_page').val(page_num);
    }
    function initialization() {
        var show_per_page = 10;
        var number_of_items = $('#content').children('.clearfix').size();
        var number_of_pages = Math.ceil(number_of_items/show_per_page);

        $('#current_page').val(0);
        $('#show_per_page').val(show_per_page);
        var navigation_html = '<a class="previous_link" href="javascript:previous();">上一页</a>';
        var current_link = 0;
        while(number_of_pages > current_link){
            navigation_html += '<a class="page_link" href="javascript:go_to_page(' + current_link +')" longdesc="' + current_link +'">'+ (current_link + 1) +'</a>';
            current_link++;
        }
        navigation_html += '<a class="next_link" href="javascript:next();">下一页</a>';
        $('#page_navigation').html(navigation_html);
        $('#page_navigation .page_link:first').addClass('active_page');
        $('#content').children('.clearfix').css('display', 'none');
        $('#content').children('.clearfix').slice(0, show_per_page).css('display', 'block');
    }
    function select_evaluate(obj, id) {
        if(id == 0){
            $(obj).siblings().removeClass('current');
            $(obj).addClass('current');
            $('#content').children().attr('class','clearfix').css('display','');
            initialization();
        }
        if(id == 1){
            $(obj).siblings().removeClass('current');
            $(obj).addClass('current');
            $('#content').children().attr('class','evaluate').css('display','none');
            $('#content').children('#1').attr('class','clearfix').css('display','block');
            initialization();
        }
        if(id == 2){
            $(obj).siblings().removeClass('current');
            $(obj).addClass('current');
            $('#content').children().attr('class','evaluate').css('display','none');
            $('#content').children('#2').attr('class','clearfix').css('display','block');
            initialization();
        }
        if(id == 3){
            $(obj).siblings().removeClass('current');
            $(obj).addClass('current');
            $('#content').children().attr('class','evaluate').css('display','none');
            $('#content').children('#3').attr('class','clearfix').css('display','block');
            initialization();
        }
    }
</script>
<div class="seat warp mt20"><?php echo $location; ?></div>
<div class="product-detail clearfix">
<div class="warp">
 <div class="product-picture">
<div id="tsShopContainer">
<div id="tsImgS">
<?php if ($attachment_list) { ?>
<a href="<?php echo $attachment_list[0]['path']; ?>" class="MagicZoom" id="MagicZoom"><img alt="<?php if ($item_info) {echo clearstring($item_info['title']);} ?>" src="<?php echo $attachment_list[0]['path']; ?>" style="width:430px; height:430px;" id="imgs" /></a>
<?php } else { ?>
<a href="<?php if ($item_info){echo $item_info['path'];} ?>" class="MagicZoom" id="MagicZoom"><img alt="<?php if ($item_info) {echo clearstring($item_info['title']);} ?>" src="<?php if ($item_info){echo $item_info['path'];} ?>" style="width:430px; height:430px;" id="imgs" /></a>
<?php } ?>
	</div>
	<img class="MagicZoomLoading" width="16" height="16" src="images/default/loading.gif" alt="Loading..." />
</div>
<div class="zoom-scroll" id="zoom_scroll">
<div class="scrollpic" >
<ul id="scrollpic">
<?php if ($attachment_list) { ?>
<?php foreach ($attachment_list as $key=>$item) { ?>
<li><a href="javascript:void(0);" class="pic" bigimg="<?php echo $item['path']; ?>" smallimg="<?php echo preg_replace('/\./', '_max.', $item['path']); ?>"><img alt="<?php echo clearstring($item['alt']); ?>" src="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>" /></a></li>
<?php }} ?>
</ul>
</div>
</div>

</div>

 <div class="product-info">
  <h2 class="nowrap"><?php if ($item_info){echo $item_info['title'];} ?></h2>
     <?php if ($item_info && $item_info['is_promise']){ ?>
         <div class="desc">商家承诺：提供“送货入户并安装”服务，未履行最高可获300元赔付</div>
     <?php } ?>
  <div class="price-box clearfix">
  <ul>
      <li><div style="font-size: 16px;padding: 0 40px 0 0;line-height: 24px;overflow: hidden;font-family: '黑体';color: #333;font-weight: normal;display: inline-block;"><p>此商品需实体店咨询价格 ，请直接与商家实体沟通、议价</p>
              <p>此类产品暂不支持7天退换货规则</p>
          </div>
  <div class="fr" style="position:relative;">
      <a onclick="javascript:save_favorite('product', '<?php if ($item_info){echo $item_info['id'];} ?>');" href="javascript:void(0);" class="collect"><i class="icon icon-collect"></i><span id="fav_product_btn_span"><?php echo $favorite_count > 0 ? '取消收藏' : '收藏';?></span></a>
      <a href="javascript:void(0);" class="share" ><i class="icon icon-share"></i><span>分享</span></a>
          <!-- JiaThis Button BEGIN -->
     <div class="jiathis_style" style="position:absolute;top:2px;right:25px;opacity:0;">
             <a class="jiathis_counter_style"></a>
     </div>
     <script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js" charset="utf-8"></script>
     <!-- JiaThis Button END -->
  </div>

  <input type="hidden" id="sell_price" value="<?php if ($item_info){echo $item_info['sell_price'];} ?>" >
  </li>
  </ul>
  </div>
 </div>
 </div>
</div>
<div class="clear"></div>
<div class="warp">
<div class="w210">
<div class="business-desc clearfix">
 <div class="tit"><?php if ($store_info) {echo $store_info['store_name'];} ?><span class="icon"></span></div>
 <ul>
 <span>9.99</span>
 <Li>商品评价   9.98<i class="icon"></i></Li>
 <Li>服务态度   9.98<i class="icon"></i></Li>
 <Li>物流速度   9.98<i class="icon"></i></Li>
 </ul>
 <div class="btn"><a href="<?php if ($store_info) { echo getBaseUrl($html, "", "store/home/{$store_info['id']}.html", $client_index);} ?>" class="fl"><i class="icon1 icon"></i>进店逛逛</a><a onclick="javascript:save_favorite('store', '<?php if ($item_info) {echo $item_info['store_id'];} ?>')" href="javascript:void(0);" class="fr"><i class="icon3 icon"></i><em id="fav_store_btn_span"><?php echo $favorite_store_count > 0 ? '取消收藏' : '收藏店铺'?></em></a></div>
</div>
<div class="shop-search mt20">
  <div class="tit">店内搜索</div>
  <ul>
  <form method="get" action="<?php echo getBaseUrl($html,'product/index/80.html','product/index/80.html',$client_index);?>" id="product_search_2">
   <Li><span>关键字：</span><input name="search_keyword" type="text" class="input_type"></Li>
   <Li><span>价   格：</span><input name="start_price" type="text" class="input_type" style="width:32px;"><em class="fl">-</em><input name="end_price" type="text" class="input_type" style="width:32px;"></Li>
   <Li><span>&nbsp;</span><a onclick="javascript:$('#product_search_2').submit();" href="javascript:void(0);" class="btn">搜索</a></Li>
  </form>
  </ul>
</div>
<div class="product-recommend mt20">
 <div class="hd">
  <ul>
  <Li>人气推荐</Li>
  <Li>热门关注</Li>
  </ul>
 </div>
 <div class="bd">
  <ul class="recommend-item">
  <?php
  $cus_list = $this->advdbclass->get_cus_product_list('a', 5);
  if ($cus_list) {
      foreach ($cus_list as $item) {
		$url = getBaseUrl(false, "", "product/detail/{$item['id']}.html", $client_index);
   ?>
  <Li><a href="<?php echo $url; ?>" target="_blank"><div class="picture"><img alt="<?php echo clearstring($item['title']); ?>" class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"><span class="mask"><?php echo my_substr($item['title'], 24); ?></span></div><span class="price"><small>￥</small><?php echo $item['sell_price']; ?></span></a></Li>
 <?php }} ?>
  </ul>
  <ul class="recommend-item">
  <?php
  $cus_list = $this->advdbclass->get_cus_product_list('f', 5);
  if ($cus_list) {
      foreach ($cus_list as $item) {
		$url = getBaseUrl(false, "", "product/detail/{$item['id']}.html", $client_index);
   ?>
  <Li><a href="<?php echo $url; ?>" target="_blank"><div class="picture"><img alt="<?php echo clearstring($item['title']); ?>" class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"><span class="mask"><?php echo my_substr($item['title'], 24); ?></span></div><span class="price"><small>￥</small><?php echo $item['sell_price']; ?></span></a></Li>
 <?php }} ?>
  </ul>
 </div>
</div>
</div>
<div class="product-comment fr">
 <div class="hd">
  <ul>
  <Li>商品详情</Li>
  <Li>商品评价</Li>
  </ul>
 </div>
 <div class="bd">
 <div class="product-introduce" style="padding:0 20px;text-align:center;">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:left;margin:20px 0px;">
  <tr>
    <td colspan="7">商品名称：<?php if ($item_info){echo $item_info['title'];} ?></td>
    </tr>
  <tr>
    <td>商品编号：<?php if ($item_info){echo $item_info['product_num'];} ?></td>
    <td>风格： <?php if ($item_info){echo $item_info['style_name'];} ?> </td>
    <td>品牌：<?php if ($item_info){echo $item_info['brand_name'];} ?></td>
    <td>材质：<?php if ($item_info){echo $item_info['material_name'];} ?></td>
      <td>面料：<?php if ($item_info){echo $item_info['fabric_name'];} ?></td>
      <td>皮革：<?php if ($item_info){echo $item_info['leather_name'];} ?></td>
      <td>填充物：<?php if ($item_info){echo $item_info['filler_name'];} ?></td>
  </tr>
</table>
<?php if ($item_info){echo html($item_info['content']);} ?>
 </div>
 <div class="comment-detail" style="display:block">
   <div class="classly mt20"><a onclick="select_evaluate(this,0)" class="current" href="javascript:void(0)">全部评价(<?php echo $comment_count;?>)</a><a onclick="select_evaluate(this,1)" href="javascript:void(0)">好评(<?php echo $evaluate_a_count;?>)</a><a onclick="select_evaluate(this,2)" href="javascript:void(0)">中评(<?php echo $evaluate_b_count;?>)</a><a onclick="select_evaluate(this,3)" href="javascript:void(0)">差评(<?php echo $evaluate_c_count;?>)</a></div>
     <input type='hidden' id='current_page' />
     <input type='hidden' id='show_per_page' />
     <div id="content">
       <?php if($comment_list){
       foreach ($comment_list as $key=>$comment){
       ?>
    <dl class="clearfix" id="<?php echo $comment['evaluate']; ?>"><dt>
            <img src="<?php if($comment['user_logo']){ echo preg_replace('/\./', '_thumb.', $comment['user_logo']);}else{ echo "images/default/defluat.png";}?>" width="50px">
        <p><?php if($comment['is_anonymous']){ echo hideStar($comment['username']); ?><font class="c9">(匿名)</font><?php } else { echo $comment['username'];}?></p></dt>
    <dd>
        <div class="flower">
            <?php if ($comment['evaluate'] == 1){ ?>
                <label><span class="red">好评</span></label>
            <?php }elseif($comment['evaluate'] == 2){ ?>
                <label><span class="yellow">中评</span></label>
            <?php }else{ ?>
                <label><span>差评</span></label>
            <?php } ?>
        </div>
        <p><?php if($comment['content']){ echo str_replace(array("\r\n", "\n", "\r"), '<br/>', $comment['content']);}else{ echo "此用户未填写评论";} ?></p>
        <div style="padding-top: 10px">
            <?php if ($comment['attachment_list']){
                foreach ($comment['attachment_list'] as $value){
                    ?>
                    <a data-lightbox="image_list_group_<?php echo $key; ?>" data-title="" href="<?php echo $value['path']; ?>" style="padding-right: 3px;"><img src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>" width="60px" height="60px"></a>
                <?php }} ?>
        </div>
        <?php if ($comment['store_reply']){ ?>
        <div style="padding-top: 10px"><span>[商家回复] </span><span style="color: #B28500"><?php echo str_replace(array("\r\n", "\n", "\r"), '<br/>', $comment['store_reply']); ?></span></div>
        <?php } ?>
    </dd>
    <dd class="author"><?php echo date('Y-m-d H:i', $comment['add_time']);?></dd>
    </dl>
       <?php }} ?>
   </div>
     <div id='page_navigation'></div>
 </div>
</div>
</div>
</div>
<form method="post" action="<?php echo getBaseUrl($html, "", "cart/confirm.html", $client_index); ?>" id="json_form_submit">
<input type="hidden" id="cart_ids" name="cart_ids[]" >
</form>
<script type="text/javascript" src="js/default/jquery.ZoomScrollPic.js"></script>
<script type="text/javascript">
//放大镜图片切换效果
$("#scrollpic").ZoomScrollPic({
			jqBox:"#zoom_scroll",
			box_w:84,
			Interval:3000,
			bun:true,
			autoplay:false
		});



$("#scrollpic li .pic").bind({
		click:function(){
			$("#scrollpic li .pic").removeClass("active");
			$(this).addClass("active");
			var smallimg=$(this).attr("smallimg");
			var bigimg=$(this).attr("bigimg");
			$("#MagicZoom img").eq(0).attr("src",smallimg);
			$("#MagicZoom img").eq(1).attr("src",bigimg);
			return false;
			}
});
/*********购物**********/

$("#spec_color_id").val("");
$("#spec_size_id").val("");
//选颜色
function select_color(obj, color_id) {
	$(obj).parent().parent().find('a').removeClass("hovered");
	$(obj).addClass("hovered");
	$("#spec_color_id").val(color_id);

	var size_id = $("#spec_size_id").val();
    if (size_id && color_id) {
    	//选定
        $.post(base_url+"index.php/product/get_stock",
				{	"product_id": '<?php if ($item_info){ echo $item_info['id']; } ?>',
					"size_id": size_id,
					"color_id": color_id
				},
				function(res){
					if(res.success) {
						$('.kc.ml20').html("库存："+res.data.stock);
						$("#product_stock").val(res.data.stock);
						$('.price.purple').html('¥'+res.data.price);
						$('#sell_price').val(res.data.price);
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
					}
				},
				"json"
		);
    }
}
//选尺码
function select_size(obj, size_id) {
	$(obj).parent().parent().find('a').removeClass("hovered");
	$(obj).addClass("hovered");
	$("#spec_size_id").val(size_id);

	var color_id = $("#spec_color_id").val();
	if (size_id && color_id) {
		//选定
        $.post(base_url+"index.php/product/get_stock",
				{	"product_id": '<?php if ($item_info){ echo $item_info['id']; } ?>',
					"size_id": size_id,
					"color_id": color_id
				},
				function(res){
					if(res.success) {
						$('.kc.ml20').html("库存："+res.data.stock);
						$("#product_stock").val(res.data.stock);
						$('.price.purple').html('¥'+res.data.price);
						$('#sell_price').val(res.data.price);
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
					}
				},
				"json"
		);
    }
}
//减
function reduce() {
   //buy_num
	var buy_num = $('#buy_num').val();
	if (buy_num < 2) {
        var d = dialog({
			fixed: true,
		    title: '提示',
		    content: '购买数量不能再减了'
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    } else {
    	$('#buy_num').val(buy_num - 1);
	}
}

//加
function increase() {
	var product_stock = parseInt($('#product_stock').val());
	var buy_num = parseInt($('#buy_num').val());
	if (buy_num >= product_stock) {
        var d = dialog({
			fixed: true,
		    title: '提示',
		    content: '购买数量不能大于库存'
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    } else {
    	buy_num++;
    	$('#buy_num').val(buy_num);
	}
}

function add_cart() {
	var color_id = $("#spec_color_id").val();
	var size_id = $("#spec_size_id").val();
	var buy_num = $('#buy_num').val();
    <?php if ($item_info && $item_info['color_size_open']) { ?>
	if (!size_id) {
    	var d = dialog({
			fixed: true,
		    title: '提示',
		    content: "请选择<?php if ($item_info){echo $item_info['product_size_name'];} ?>"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    }
    if (!color_id) {
    	var d = dialog({
			fixed: true,
		    title: '提示',
		    content: "请选择<?php if ($item_info){echo $item_info['product_color_name'];} ?>"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
             return false;
    }
    <?php } ?>
    if (!buy_num) {
    	var d = dialog({
			fixed: true,
		    title: '提示',
		    content: "请填写购买数量"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    }
    //加入购物车
    $.post(base_url+"index.php/cart/add",
			{	"product_id": <?php if ($item_info){ echo $item_info['id']; } ?>,
				"color_id": color_id,
				"size_id": size_id,
				"buy_type":0,
				"buy_number": buy_num
			},
			function(res){
				if(res.success){
					$('#cart_sum').html(res.data.cart_count);
					var sell_price = $('#sell_price').val();
					var total = (sell_price*buy_num).toFixed(2);
					var path = '<?php if ($item_info){echo preg_replace('/\./', '_thumb.', $item_info['path']);} ?>';
                    var html = '<table width="100%" border="0">';
                    	html += '<tr>';
                    	html += '<td style="width:100px;height:80px;vertical-align:middle; text-align:center;" rowspan="3"><a class="pic"><img width="60" height="60" src="'+path+'"></a></td>';
                    	html += '<td style="line-height:25px;color:#666;"><strong><?php if ($item_info){echo $item_info['title'];} ?></strong></td>';
                    	html += ' </tr>';
                    	html += '<tr>';
                    	html += '<td style="line-height:25px;color:#666;">加入数量：<span style="color:#ff1f1f;">'+buy_num+'</span></td>';
                    	html += '</tr>';
                    	html += '<tr>';
                    	html += ' <td style="line-height:25px;color:#666;">总计金额：<span style="color:#ff1f1f;">¥'+total+'</span></td>';
                    	html += '</tr>';
                    	html += '</table>';

					var d = dialog({
						width: 350,
						fixed: true,
					    title: '商品已成功加入购物车',
					    content: html,
					    okValue: '去结算',
					    ok: function () {
						    window.location.href=base_url+'index.php/cart.html';
					    },
					    cancelValue: '继续购物',
					    cancel: function () {
					    }
					});
					d.show();
                    return false;
				}else{
					if (res.field == 'go_login') {
						var d = dialog({
							width:200,
							fixed: true,
						    title: '提示',
						    content: res.message,
						    okValue: '登录',
						    ok: function () {
						    	window.location.href= base_url+'index.php/user/login.html';
						    },
						    cancelValue: '取消',
						    cancel: function () {
						    }
						});
						d.show();
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
					}
					return false;
				}
			},
			"json"
	);
}

//立即购买
function add_now_cart() {
	var color_id = $("#spec_color_id").val();
	var size_id = $("#spec_size_id").val();
	var buy_num = $('#buy_num').val();
    <?php if ($item_info && $item_info['color_size_open']) { ?>
	if (!size_id) {
    	var d = dialog({
			fixed: true,
		    title: '提示',
		    content: "请选择<?php if ($item_info){echo $item_info['product_size_name'];} ?>"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    }
    if (!color_id) {
    	var d = dialog({
			fixed: true,
		    title: '提示',
		    content: "请选择<?php if ($item_info){echo $item_info['product_color_name'];} ?>"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    }
    <?php } ?>
    if (!buy_num) {
    	var d = dialog({
			fixed: true,
		    title: '提示',
		    content: "请填写购买数量"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    }
    //加入购物车
    $.post(base_url+"index.php/cart/add",
			{	"product_id": <?php if ($item_info){ echo $item_info['id']; } ?>,
				"color_id": color_id,
				"size_id": size_id,
				"buy_type":1,
				"buy_number": buy_num
			},
			function(res){
				if(res.success){
					$('#cart_ids').val(res.data.cart_id);
					$('#json_form_submit').submit();
				}else{
					if (res.field == 'go_login') {
						var d = dialog({
							width:200,
							fixed: true,
						    title: '提示',
						    content: res.message,
						    okValue: '登录',
						    ok: function () {
						    	window.location.href= base_url+'index.php/user/login.html';
						    },
						    cancelValue: '取消',
						    cancel: function () {
						    }
						});
						d.show();
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
					}
					return false;
				}
			},
			"json"
	);
}

$("#collectStore").click(function(){
         $.post(base_url + 'index.php/product/collect_store_favorite', {'store_id': '<?php if($item_info){ echo $item_info['store_id'];}; ?>'}, function (data) {
            if (data.success == true) {
                if (data.data.action == 'delete') {
                    $("#collectStore em").html('收藏店铺');
                } else {
                    $("#collectStore em").html('取消收藏');
                }
            } else {
                var d = dialog({
                    width: 300,
                    title: '提示',
                    fixed: true,
                    content: data.message
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                    if (data.field == 'go_login') {
                        window.location.href = base_url + 'index.php/user/login';
                    }
                }, 2000);
            }
        }, 'json');
})

//收藏
function save_favorite(type, product_id) {
    $.post(base_url+"index.php/product/save_favorite",
			{	"item_id": product_id,
		        "type": type
			},
			function(res){
				if(res.success){
					if (type == 'product') {
						if (res.data.action == 'add') {
	                        $('#fav_product_btn_span').html('取消收藏');
						} else if (res.data.action == 'delete') {
							$('#fav_product_btn_span').html('收藏');
						}
					} else if (type == 'store') {
						if (res.data.action == 'add') {
	                        $('#fav_store_btn_span').html('取消收藏');
						} else if (res.data.action == 'delete') {
							$('#fav_store_btn_span').html('收藏店铺');
						}
					}
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
</script>
<link rel="stylesheet" href="js/admin/lightbox2-master/src/css/lightbox.css">
<script src="js/admin/lightbox2-master/src/js/lightbox.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 300,
        'wrapAround': true,
        'positionFromTop': 200,
        showImageNumberLabel: false
    });

</script>