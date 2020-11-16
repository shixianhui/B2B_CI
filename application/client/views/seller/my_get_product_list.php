<style type="text/css">
	.product_search span{font-size:13px;line-height:30px;}
	.product_search input{line-height:30px;border:1px solid #eaebeb;padding:0 5px;color:#666;}
	.product_search label{position: relative;vertical-align:middle;font-size:13px;color:#333;line-height:30px;}
	.product_search label div{display:inline-block;position: relative;
    overflow: hidden;
    height: 30px;
    border: 1px solid #eaebeb;
    background: #fff;
    color: #666;
    -webkit-transition: border-color 0.2s linear;
    transition: border-color 0.2s linear;
    vertical-align:top; padding:0; line-height:20px;}

	.product_search select{-webkit-box-sizing: border-box;
    box-sizing: border-box;
    height: 30px;
    margin: 0;
    border: 0;
    padding: 0 20px 0 5px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    font-size: 12px;
    font-weight: 400;
    line-height: 29px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    vertical-align: middle;
    background: none;
    color: #666;
    outline: none;
    cursor: pointer;}
    .down{    position: absolute;
    right: 5px;
    top: 10px;
    z-index: 1;
    width: 16px;
    height: 16px;
    color: #b0b0b0;
    cursor: pointer;
    pointer-events: none;
    background: url(images/default/icon.png) no-repeat -402px -96px;
}
</style>
<div class="member_right mt20">

    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">商品管理</span><a href="<?php echo getBaseUrl(false, '', 'seller/my_save_product.html', $client_index); ?>" class="more"><font class="blue">+ 新增商品</font></a></div>
        <form class="product_search" id="product_search" method="post" action="index.php/<?php echo $template; ?>/my_get_product_list/1.html">
            <div style="padding-top: 20px;">
            <span>商品名称：</span><input style="width:100px;" type="text" name="title">
            <span>产品编号：</span><input style="width:100px;" type="text" name="product_num">
            <label>
                品牌：<div><span class="down"></span>
                <select class="" name="brand_name">
                    <option value="">全部</option>
                    <?php if ($brand_list){
                        foreach ($brand_list as $value){ ?>
                            <option value="<?php echo $value['brand_name']; ?>"><?php echo $value['brand_name']; ?></option>
                        <?php }} ?>
                </select>
                </div>
            </label>
            <label>
                风格：
                <div><span class="down"></span>
                <select class="" name="style_name">
                    <option value="">全部</option>
                    <?php if ($style_list){
                        foreach ($style_list as $value){ ?>
                            <option value="<?php echo $value['style_name']; ?>"><?php echo $value['style_name']; ?></option>
                        <?php }} ?>
                </select>
                </div>
            </label>
            <label for="feedbackType">分类：
            	<div><span class="down"></span>
            <select class="" name="product_category_id">
                <option value="" >选择产品分类</option>
                <?php if (! empty($my_product_category_list)) { ?>
                    <!-- 一级 -->
                    <?php foreach ($my_product_category_list as $menu) {
                        ?>
                        <option <?php if ($menu['subMenuList']) {echo 'disabled="disabled"';} ?> value="<?php echo $menu['id']; ?>"><?php echo $menu['product_category_name']; ?></option>
                        <!-- 二级 -->
                        <?php foreach ($menu['subMenuList'] as $subMenu) {
                            ?>
                            <option <?php if ($subMenu['subMenuList']) {echo 'disabled="disabled"';} ?> value="<?php echo $menu['id'].','.$subMenu['id']; ?>">&nbsp;&nbsp;┣<?php echo $subMenu['product_category_name']; ?></option>
                        <?php }}} ?>
            </select>
            </div>
            </label>
                <div style="margin-top: 10px">
                <label>
                    推荐：
                    <div><span class="down"></span>
                        <select class="" name="recommend_to_store_index">
                            <option value="">是否推荐到首页</option>
                            <option value="1">推荐到首页商品</option>
                            <option value="0">非推荐商品</option>
                        </select>
                    </div>
                </label>
                <span>价格区间：</span><input type="text" name="sell_price_start" style="width: 50px;">--<input type="text" name="sell_price_end" style="width: 50px">
                <input type="submit" value="查询" style="width: 70px;color: #000;margin-left: 5px">
                </div>
            </div>
        </form>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="b_shop_table">
            <tr>
                <th width="4%"></th>
                <th width="20%" style="text-align:left">商品信息</th>
                <th width="8%">产品编号</th>
                <th width="15%">品牌</th>
                <th width="10%">风格</th>
                <th width="19%">分类</th>
                <th width="8%">价格</th>
                <th width="8%">数量</th>
                <th width="8%">操作</th>
            </tr>
            <?php
               if($product_list){
                   foreach($product_list as $item){
                       $url = getBaseUrl(false,'','product/detail/'.$item['id'].'.html',$client_index)
            ?>
            <tr id="id_<?php echo $item['id'];?>">
                <td align="center"><input type="checkbox" name="ids" value="<?php echo $item['id'];?>"></td>
                <td><a href="<?php echo $url;?>" class="property"><img src="<?php echo str_replace('.','_thumb.',$item['path']);?>"><?php echo $item['title']; ?><?php if ($item['recommend_to_store_index']){?><span style="color: red"> [推荐]</span><?php } ?></a></td>
                <td align="center"><?php echo $item['product_num'];?></td>
                <td align="center"><?php echo $item['brand_name'];?></td>
                <td align="center"><?php echo $item['style_name'];?></td>
                <td align="center"><?php echo $item['product_category_str'];?></td>
                <td align="center"><span class="red"><?php if ($item['unclear_price']){ echo '在线咨询'; }else{ ?><small>￥</small><?php echo $item['sell_price'];}?></span></td>
                <td align="center"><?php echo $item['stock'];?></td>
                <td align="center"><a href="<?php echo getBaseUrl(false,'','seller/my_save_product/'.$item['id'],$client_index)?>">编辑</a></td>
            </tr>
                   <?php }}?>
            <tr>
                <td colspan="8" align="center"><div class="delete"><label><input type="checkbox" id="selectAll">全选</label><a href="javascript:void(0);" id="deleteProduct">删除</a><a href="javascript:void(0);" id="cusProduct">推荐到店铺首页</a></div></td>
            </tr>
        </table>
         <div class="clear"></div>
	<div class="pagination">
		<ul>
		<?php echo $pagination; ?>
		</ul>
	</div>
    </div>
</div>
<script>
    $("#selectAll").change(function(){
        if($(this).is(":checked")){
            $("input[type=checkbox]").prop('checked',true);
        }else{
            $("input[type=checkbox]").prop('checked',false);
        };
    });
     $("#deleteProduct").click(function(){
    	var con = confirm("你确定要删除数据吗？删除后将不可恢复！");
    	if (con == true) {
	        $ids = "";
	    	$("input[name='ids']:checked").each(function(i,n){
	    		$ids += $(this).val() + ",";
	    	});
	    	if (! $ids) {
	    		alert("请选定值!");
	    		return false;
	    	}
			$.post(base_url+"index.php/"+controller+"/my_delete_product",
					{	"ids": $ids.substr(0, $ids.length - 1)
					},
					function(res){
						if(res.success){
							for (var i = 0, data = res.data.ids, len = data.length; i < len; i++){
								$("#id_"+data[i]).remove();
							}
							return false;
						}else{
							alert(res.message);
							return false;
						}
					},
					"json"
			);
    	}
	});

    $("#cusProduct").click(function(){
            $ids = "";
            $("input[name='ids']:checked").each(function(i,n){
                $ids += $(this).val() + ",";
            });
            if (! $ids) {
                alert("请选定值!");
                return false;
            }
            $.post(base_url+"index.php/"+controller+"/my_cus_product",
                {	"ids": $ids.substr(0, $ids.length - 1)
                },
                function(res){
                    if(res.success){
                        var d = dialog({
                            fixed: true,
                            title: '提示',
                            content: res.message
                        });
                        d.show();
                        setTimeout(function () {
                            d.close().remove();
                        }, 2000);
                        window.location.reload(true);
                        return false;
                    }else{
                        alert(res.message);
                        return false;
                    }
                },
                "json"
            );
    });
</script>