<link href="css/default/multi_select.css" rel="stylesheet" type="text/css"/>
<style>
    .but_4 {
        background: #c81624 none repeat scroll 0 0;
        border-radius: 6px;
        color: #fff;
        display: inline-block;
        font: 1.2em/32px "微软雅黑";
        height: 32px;
        margin-left: 10px;
        padding: 0 10px;
        position: relative;
    }
    .pic_info {
        display: inline-block;
        width:68px;
        height;80px;
        text-align:center;
        position:relative;
        margin-top:5px;
    }
    .picture span.icon_arrow{    width: 30px;
		    height: 50px;
		    display: inline-block;
		    background-position: 0 0;
		    bottom:-60px;
		    position:absolute;
            background: url(images/default/icon1.png) no-repeat;
            opacity: 0.7;
    }
    #pic_list{
    	overflow:hidden;
    	height:80px;
    	margin:0 20px;
    	white-space:nowrap;
    }
    .pic_img {
        border:1px solid red;
    }
    img.del_pic {
        cursor: pointer;
        position:absolute;
        right:7px;
        width: 13px;
        height: 13px;
    }
    img.select_pice_path {
        cursor: pointer;
        position:absolute;
        right: 50px;
        width: 13px;
        height: 13px;
    }
    .b_shop_update .picture img.select_pice_path {
        width: 13px;
        height: 13px;
    }
    .b_shop_update .picture img.del_pic {
        width: 13px;
        height: 13px;
    }
    .m_form li span.pri_text{
        text-align: right;
        padding-left: 3px;
        float: left;
        /*margin-right: 25px;*/
    }
</style>
<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">发布商品</span></div>
        <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" name="jsonForm" id="jsonForm">
        <ul class="m_form" style="padding-left:0px;">
            <li class="clearfix"><span>商品分类：</span><div class="xm-select fl">
                    <div class="dropdown">
                        <label class="iconfont" for="feedbackType"></label>
                           <select class="input_blur" name="category_ids" valid="required" errmsg="请选择产品分类!">
                                    <option value="" >请选择产品分类</option>
                                    <?php if (! empty($product_category_list)) { ?>
                                    <!-- 一级 -->
                                    <?php foreach ($product_category_list as $menu) {
                                          $selector = '';
                                          if ($item_info) {
                                                  if ($menu['id'] == $item_info['category_id_1']) {
                                                     $selector = 'selected="selected"';
                                                  }
                                          }
                                     ?>
                                    <option <?php if ($menu['subMenuList']) {echo 'disabled="disabled"';}else{echo $selector;} ?> value="<?php echo $menu['id']; ?>"><?php echo $menu['product_category_name']; ?></option>
                                    <!-- 二级 -->
                                    <?php foreach ($menu['subMenuList'] as $subMenu) {
                                                     $selector = '';
                                                     if ($item_info) {
                                                             if ($subMenu['id'] == $item_info['category_id_2']) {
                                                                     $selector = 'selected="selected"';
                                                             }
                                                     }
                                     ?>
                                    <option <?php if ($subMenu['subMenuList']) {echo 'disabled="disabled"';}else{echo $selector;} ?> value="<?php echo $menu['id'].','.$subMenu['id']; ?>">&nbsp;&nbsp;┣<?php echo $subMenu['product_category_name']; ?></option>
                                    <?php }}} ?>
                                   </select>
                    </div>
                </div>
            </li>
            <li class="clearfix" style="padding-bottom:0px;"><span>本店分类：</span></li>
        </ul>
            <div style="width:400px;margin:0px 0px 10px 105px;">
                        <select id="pre-selected-options" multiple="multiple" name="product_category_id[]" valid="required" errmsg="请选择本店分类!">
                          <?php if (! empty($my_product_category_list)) { ?>
                                     一级
                                    <?php foreach ($my_product_category_list as $menu) {
                                          $selector = '';
                                          if ($item_info) {
                                                  if(myInArray($menu['id'], $pci_info)){ $selector = 'selected="selected"';}
                                          }
                                     ?>
                                      <?php
                                        if(!$menu['subMenuList']){
                                     ?>
                                     <option <?php if ($menu['subMenuList']) {echo 'disabled="disabled"';}else{echo $selector;} ?> value="<?php echo $menu['id']; ?>"><?php echo $menu['product_category_name']; ?></option>
                                        <?php }?>
                                     二级
                                     <?php
                                        if($menu['subMenuList']){
                                     ?>
                                     <optgroup label="<?php echo $menu['product_category_name'];?>">
                                            <?php foreach ($menu['subMenuList'] as $subMenu) {
                                                             $selector = '';
                                                             if ($item_info) {
                                                                      if(myInArray($subMenu['id'], $pci_info)){ $selector = 'selected="selected"';}
                                                             }
                                             ?>
                                            <option <?php if ($subMenu['subMenuList']) {echo 'disabled="disabled"';}else{echo $selector;} ?> value="<?php echo $menu['id'].','.$subMenu['id']; ?>">&nbsp;&nbsp;<?php echo $subMenu['product_category_name']; ?></option>
                                            <?php }?>
                                     </optgroup>
                                        <?php }?>
                                        <?php }} ?>
                         </select>
                </div>
        <h3>基本信息</h3>
        <div class="b_shop_update">
            <div class="picture mt20" style="position:relative;">
                <img src="<?php if($item_info){ echo str_replace('.','_thumb.',$item_info['path']);}?>" onerror="this.src='images/default/load.jpg'">
<!--                <a href="javascript:void(0)" style="position: relative;display: none">-->
<!--                    <input style="left:0px;top:0px; background:#000; width:100%;height:20px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="path_file" name="path_file" >-->
<!--                    上传图片-->
<!--                </a>-->
                <div id="pic_list" style="float: left;max-width:210px;">
                    <?php
                    if($attachment_list){
                        foreach ($attachment_list as $key=>$value){
                    ?>
                            <div class="pic_info" onmouseenter="enter_pic(this)" onmouseleave="leave_pic(this)">
                                <img src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>" style="width: 60px;height: 60px" id="list_path" onclick="select_img(this)"/>
                                <input type="hidden" name="batch_path_ids[]" value="<?php echo $value['id']; ?>" />
                                <input type="hidden" id="select_path" value="<?php echo $value['path']; ?>" />
                                <p style="position:absolute; background:#e8e8e8;opacity:1;width:100%;height:19px;bottom:0;z-index:1;display: none">
                                    <img onclick="javascript:del_pice(this);" <?php if($value['path'] == $item_info['path']){ ?> data-selected="1" <?php } ?> class="del_pic" src="images/default/close.png" title="删除">
                                    <img onclick="javascript:select_pice(this);" class="select_pice_path" src="images/default/open.png" title="设为封面" id="select_pice_path" <?php if($value['path'] == $item_info['path']){ ?>style="display: none" <?php } ?>>
                                </p>
                                
                            </div>
                        <?php }} ?>
                </div>
                <span id="last" class="icon_arrow" style="cursor:pointer; left:0px; transform:rotate(180deg); -moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);display: none"></span>
                <span id="next" class="icon_arrow" style="cursor:pointer;right:0px;display: none"></span>
                <a style="position:relative; width:auto;background:none;clear:both;padding-top:10px;" >
                    <span style="cursor:pointer;" class="but_4">批量上传图片<input style="cursor:pointer;left:0px;top:0px; background:#000; width:100%;height:36px;line-height:36px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" multiple="multiple" id="path_file" name="path_file[]" ></span>
                    <i class="load" id="path_load" style="cursor:pointer;display:none;width:auto;padding-left:0px; left:50%; margin-left:-16px;margin-top:0px;index: 9999;position: absolute;"><img src="images/admin/loading_2.gif" style="width: 32px;height: 32px"></i>
                </a>
                <input type="hidden" name="path" value="<?php if($item_info){ echo $item_info['path'];} ?>">
            </div>
            <ul class="m_form fl">
                <li class="clearfix"><span>商品名称：</span><input type="text" name="title" value="<?php if($item_info){ echo $item_info['title'];} ?>" id="title" valid="required" errmsg="商品名称不能为空!" class="input_txt"><font color="#cc0011">*</font></li>
                <li class="clearfix">
                    <span>品牌：</span><input autocomplete="off"  type="text" name="brand_name" value="<?php if($item_info){ echo $item_info['brand_name'];} ?>" id="brand_name" class="input_txt">
                     <?php
                       if($brand_list){
                    ?>
                    <dl class="select_tabs">
                        <?php
                           foreach($brand_list as $ls){
                        ?>
                        <dd><?php echo $ls['brand_name'];?></dd>
                           <?php }?>
                    </dl>
                       <?php }?>
                </li>
                <li class="clearfix">
                    <span>风格：</span><input autocomplete="off"  type="text" name="style_name" value="<?php if($item_info){ echo $item_info['style_name'];} ?>" id="style_name" class="input_txt">
                    <?php
                       if($style_list){
                    ?>
                    <dl class="select_tabs">
                        <?php
                           foreach($style_list as $ls){
                        ?>
                        <dd><?php echo $ls['style_name'];?></dd>
                           <?php }?>
                    </dl>
                       <?php }?>

                </li>
                <li class="clearfix">
                    <span>材质：</span><input autocomplete="off"  type="text" name="material_name" value="<?php if($item_info){ echo $item_info['material_name'];} ?>" id="material_name" class="input_txt">
                     <?php
                       if($material_list){
                    ?>
                    <dl class="select_tabs">
                        <?php
                           foreach($material_list as $ls){
                        ?>
                        <dd><?php echo $ls['material_name'];?></dd>
                           <?php }?>
                    </dl>
                       <?php }?>
                </li>
                <li class="clearfix">
                    <span>面料：</span><input autocomplete="off"  type="text" name="fabric_name" value="<?php if($item_info){ echo $item_info['fabric_name'];} ?>" id="fabric_name" class="input_txt">
                     <?php
                       if($fabric_list){
                    ?>
                    <dl class="select_tabs">
                        <?php
                           foreach($fabric_list as $ls){
                        ?>
                        <dd><?php echo $ls['fabric_name'];?></dd>
                           <?php }?>
                    </dl>
                       <?php }?>
                </li>
                <li class="clearfix">
                    <span>皮革：</span><input autocomplete="off"  type="text" name="leather_name" value="<?php if($item_info){ echo $item_info['leather_name'];} ?>" id="leather_name" class="input_txt">
                     <?php
                       if($leather_list){
                    ?>
                    <dl class="select_tabs">
                        <?php
                           foreach($leather_list as $ls){
                        ?>
                        <dd><?php echo $ls['leather_name'];?></dd>
                           <?php }?>
                    </dl>
                       <?php }?>
                </li>
                <li class="clearfix">
                    <span>填充物：</span><input autocomplete="off"  type="text" name="filler_name" value="<?php if($item_info){ echo $item_info['filler_name'];} ?>" id="filler_name" class="input_txt">
                     <?php
                       if($filler_list){
                    ?>
                    <dl class="select_tabs">
                        <?php
                           foreach($filler_list as $ls){
                        ?>
                        <dd><?php echo $ls['filler_name'];?></dd>
                           <?php }?>
                    </dl>
                       <?php }?>
                </li>

                <li class="clearfix">
                    <span>标价格：</span><input type="checkbox" name="unclear_price" value="1" id="unclear_price" style="margin-top: 9px;float: left;" <?php if($item_info && $item_info['unclear_price']){ echo 'checked="checked"';}?>><span class="pri_text">实体店咨询价格</span>
                </li>
                <style type="text/css">
                	.table_list{border:1px solid #D7D7D7;margin-top:10px;}
                	.table_list h5{padding-left:10px;background:#f0f0f0;border-bottom:1px solid #D7D7D7;color:#333;}
                    .table_list .size_color_list th {
                        /*background-color: #EDEDED;*/
                        border-bottom: 1px solid #D7D7D7;
                        font-weight: 400;
                        height: 40px;
                        text-align: left;
                        vertical-align: middle;
                        min-width:60px;
                        padding-left:10px;
                        font-size:12px;
                        color:#666;
                    }
                    .table_list th {
                        /*background-color: #EDEDED;*/
                        border-bottom: 1px solid #D7D7D7;
                        font-weight: 400;
                        height: 31px;
                        text-align: center;
                        vertical-align: middle;
                        min-width:60px;
                        padding-left:10px;
                        font-size:12px;
                        color:#666;
                    }
                    .table_list td {
                        border: 1px solid #D7D7D7;
                        height: 31px;
                        max-width: 200px;
                        min-width: 60px;
                        padding: 6px 5px;
                        text-align: center;
                        vertical-align: middle;
                        font-size:12px;
                        color:#666;
                    }
                    .table_list td:first-of-type{border-left:none;}
                    .table_list table:last-of-type tr:last-of-type td {
                        border-bottom:none;
                    }
                    .button_style{
                    	color:#fff;
                    	background:#c81624 none repeat scroll 0 0;border-radius: 6px;
                    	border:none;
                    	height:32px;
                    	padding:0 10px;
                    }
                    .table_list input[type=text]{height:22px;font-size:12px; color:#666;}
                    .m_form input{padding:0 10px;border:1px solid #e8e8e8;}
                </style>
                <li class="clearfix" id="size_li"><span>规格：</span>
                    <input type="hidden" name="color_size_open" id="color_size_open" value="<?php if(! empty($item_info)){ echo $item_info['color_size_open'];}else{echo '0';} ?>" />
                        <button onclick="javascript:change_color_size_open(1);" id="color_size_open_btn" type="button" class="button_style" style="<?php if(! empty($item_info) && $item_info['color_size_open']){ echo 'display:none;';} ?>">开启规格</button>
                        <button onclick="javascript:change_color_size_open(0);" id="color_size_close_btn" type="button" class="button_style" style="<?php if(! empty($item_info) && $item_info['color_size_open']){ echo '';}else{echo 'display:none;';} ?>">关闭规格</button>
                        <div id="size_color_list" class="table_list" style="height: auto; width: auto; <?php if(! empty($item_info) && $item_info['color_size_open']){ echo '';}else{echo 'display:none;';} ?>">
                            <!-- 颜色 -->
                            <h5>商品规格</h5>
                            <table id="color_table" class="size_color_list" style="width: 522px;" cellspacing="0" border="0">
                                <tr>
                                    <th colspan="4"><input name="product_color_name" id="product_color_name" value="<?php if ($item_info && $item_info['product_color_name']) {echo $item_info['product_color_name'];}else{echo '颜色';} ?>" style="text-align: center;" class="input_blur" type="text"></th>
                                </tr>
                                <?php $color_index = 1;  ?>
                                <?php if ($color_list) { ?>
                                    <?php foreach ($color_list as $key=>$value) {
                                        $color_index = max($value['color_id'], $color_index)+1;
                                        ?>
                                        <tr class="color_list">
                                            <td width="10%">
                                                <input onclick="javascript:get_size_color_list(this, 'color');"  class="checkbox_style" name="attribute_color_ids[]" value="<?php echo $value['color_id']; ?>" checked="checked" type="checkbox">
                                            </td>
                                            <td>
                                                <input onchange="javascript:change_color(this);" name="attribute_color_name[]" placeholder="请输入主属性" size="20" maxlength="60" class="input_blur" value="<?php echo $value['color_name']; ?>" type="text">
                                            </td>
                                            <td width="25%">
                                                <input name="attribute_color_hint[]" placeholder="主属性备注" size="10" maxlength="60" class="input_blur" value="<?php echo $value['color_name_hint']; ?>" type="text">
                                            </td>
                                            <td width="20%">
                                                <a class="good_url_path_file_src_a" title="点击查看大图" href="<?php echo $value['path']; ?>" target="_blank" style="float:left;"><img class="good_url_path_file_src" width="30px" height="30px" src="<?php if ($value['path']) { echo preg_replace('/\./', '_thumb.', $value['path']);}else{echo 'images/admin/no_pic.png';} ?>" onerror="javascript:this.src='images/admin/no_pic.png';" /></a>

                                                <div style="float:left; margin-top:0px;">
                                                    <a style=" position:relative; width:auto; " >
                                                        <span style="cursor:pointer;font-size:12px;height:30px;width: auto;color: #fff;padding-right:10px;border-radius:4px;" class="but_4">传图<input style="left:0px;top:0px; background:#000; width:100%;height:25px;line-height:25px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" class="good_url_path_file" onchange="javascript:file_change_upload(this);" name="good_url_path_file" ></span>
                                                        <i class="load good_url_path_file_load" style="cursor:pointer;display:none;width:auto;padding-left:0px; position: absolute;right: 4px;"><img src="images/admin/loading_2.gif" width="32" height="32"></i>
                                                    </a>
                                                    <input value="<?php echo $value['path']; ?>" type="hidden" name="attribute_path[]">
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }} ?>
                                <tr class="color_list">
                                    <td width="10%">
                                        <input onclick="javascript:get_size_color_list(this, 'color');"  class="checkbox_style" name="attribute_color_ids[]" value="<?php echo $color_index; ?>" type="checkbox">
                                    </td>
                                    <td>
                                        <input onchange="javascript:change_color(this);" name="attribute_color_name[]" placeholder="请输入主属性" size="20" maxlength="60" class="input_blur" type="text">
                                    </td>
                                    <td width="25%">
                                        <input name="attribute_color_hint[]" placeholder="主属性备注" size="10" maxlength="60" class="input_blur" type="text">
                                    </td>
                                    <td width="20%">
                                        <a class="good_url_path_file_src_a" title="点击查看大图" href="images/admin/no_pic.png" target="_blank" style="float:left;"><img class="good_url_path_file_src" width="30px" height="30px" src="images/admin/no_pic.png" onerror="javascript:this.src='images/admin/no_pic.png';" /></a>

                                        <div style="float:left; margin-top:0px;">
                                            <a style=" position:relative; width:auto; " >
                                                <span style="cursor:pointer;font-size:12px;height:30px;width: auto;color: #fff;padding-right:10px;border-radius:4px;" class="but_4">传图<input style="left:0px;top:0px; background:#000; width:100%;height:25px;line-height:25px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" class="good_url_path_file" onchange="javascript:file_change_upload(this);" name="good_url_path_file" ></span>
                                                <i class="load good_url_path_file_load" style="cursor:pointer;display:none;width:auto;padding-left:0px; position: absolute;right: 4px;"><img src="images/admin/loading_2.gif" width="32" height="32"></i>
                                            </a>
                                            <input value="" type="hidden" name="attribute_path[]">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <!-- 尺码 -->
                            <table id="size_table" class="size_color_list" style="width: 522px;" cellspacing="0" border="0">
                                <tr>
                                    <th colspan="3"><input name="product_size_name" id="product_size_name" value="<?php if ($item_info && $item_info['product_size_name']) {echo $item_info['product_size_name'];}else{echo '尺码';} ?>" class="input_blur" style="text-align: center;" type="text"></th>
                                </tr>
                                <?php $size_index = 1;  ?>
                                <?php if ($size_list) { ?>
                                    <?php foreach ($size_list as $key=>$value) {
                                        $size_index = max($value['size_id'], $size_index)+1;
                                        ?>
                                        <tr class="size_list">
                                            <td width="10%">
                                                <input onclick="javascript:get_size_color_list(this, 'size');"  class="checkbox_style" name="attribute_size_ids[]" value="<?php echo $value['size_id']; ?>" checked="checked" type="checkbox">
                                            </td>
                                            <td>
                                                <input onchange="javascript:change_size(this);" name="attribute_size_name[]" placeholder="请输入主属性" size="30" maxlength="60" class="input_blur" value="<?php echo $value['size_name']; ?>" type="text">
                                            </td>
                                            <td width="20%">
                                                <input name="attribute_size_hint[]" placeholder="主属性备注" size="15" maxlength="60" class="input_blur" value="<?php echo $value['size_name_hint']; ?>" type="text">
                                            </td>
                                        </tr>
                                    <?php }} ?>
                                <tr class="size_list">
                                    <td width="10%">
                                        <input onclick="javascript:get_size_color_list(this, 'size');"  class="checkbox_style" name="attribute_size_ids[]" value="<?php echo $size_index; ?>" type="checkbox">
                                    </td>
                                    <td>
                                        <input onchange="javascript:change_size(this);" name="attribute_size_name[]" placeholder="请输入主属性" size="30" maxlength="60" class="input_blur" type="text">
                                    </td>
                                    <td width="20%">
                                        <input name="attribute_size_hint[]" placeholder="主属性备注" size="15" maxlength="60" class="input_blur" type="text">
                                    </td>
                                </tr>
                            </table>
                             <h5>商品库存</h5>
                            <!-- 颜色-尺码 -->
                            <table style="width: 522px;" id="table_size_color" cellspacing="0" border="0">
                                <tr>
                                    <th>颜色</th>
                                    <th>尺码</th>
                                    <th>价格</th>
                                    <th>库存</th>
                                    <th>货号</th>
                                </tr>
                                <?php if ($color_size_list) { ?>
                                    <?php foreach ($color_size_list as $key=>$value) { ?>
                                        <?php foreach ($value['size_list'] as $s_key=>$s_value) { ?>
                                            <tr class="color_index_<?php echo $value['color_id'] ?>">
                                                <?php if ($s_key == 0) { ?>
                                                    <td rowspan="<?php echo count($value['size_list']); ?>"><?php echo $value['color_name']; ?></td>
                                                <?php } ?>
                                                <td class="size_index_<?php echo $s_value['size_id']; ?>"><?php echo $s_value['size_name']; ?></td>
                                                <td><input value="<?php echo $s_value['price']; ?>" onchange="javascript:change_price(this);" size="10" type="text" name="attribute_price[]"></td>
                                                <td><input value="<?php echo $s_value['stock']; ?>" onchange="javascript:change_stock(this);" size="10" type="text" name="attribute_stock[]"></td>
                                                <td><input value="<?php echo $s_value['product_num']; ?>" size="10" type="text" name="attribute_product_num[]"></td>
                                            </tr>
                                        <?php }}} ?>
                            </table>
                        </div>
                </li>
                <li class="clearfix"><span>产品编号：</span><input name="product_num" class="input_txt" id="product_num" value="<?php if(! empty($item_info)){ echo $item_info['product_num'];}else{echo $tmp_product_num;} ?>" valid="required" errmsg="产品编号不能为空!" type="text"/></li>
                <li class="clearfix" id="mar_input"><span>市场价：</span><input type="text" name="market_price" value="<?php if($item_info){ echo $item_info['market_price'];} ?>" id="market_price" class="input_txt" valid="isNumber" errmsg="请正确填写市场价!" style="width: 100px">&nbsp;元</li>
                <li class="clearfix" id="pri_input"><span>价格：</span><input type="text" name="sell_price" value="<?php if($item_info){ echo $item_info['sell_price'];} ?>" id="sell_price" class="input_txt" valid="isNumber" errmsg="请正确填写价格!" style="width: 100px">&nbsp;元</li>
                <li class="clearfix"><span>数量：</span><input type="text" name="stock" value="<?php if($item_info){ echo $item_info['stock'];} ?>" id="stock" class="input_txt" valid="isInt" errmsg="请正确填写数量"></li>
                <li class="clearfix"><span style="width: auto;">推荐到店铺首页：</span><input type="checkbox" name="recommend_to_store_index" value="1" id="recommend_to_store_index" style="margin-top: 9px;float: left;" <?php if($item_info && $item_info['recommend_to_store_index']){ echo 'checked="checked"';}?>><span style="text-align: left;padding-left: 3px;">推荐</span></li>
                <li class="clearfix"><span style="width: auto;">免运费：</span><span style="width: auto">满</span><input type="text" name="reduced_price" value="<?php if($item_info){ echo $item_info['reduced_price'];} ?>" id="reduced_price" class="input_txt" style="width: 80px">&nbsp;免运费</li>
                <li class="clearfix"><span style="width: auto;">商家承诺：</span><input type="checkbox" name="is_promise" value="1" id="is_promise" style="margin-top: 9px;float: left;" <?php if($item_info && $item_info['is_promise']){ echo 'checked="checked"';}?>><span style="text-align: left;padding-left: 3px;width: auto">提供“送货入户并安装”服务，未履行最高可获300元赔付</span></li>
                <li class="clearfix"><span style="width: auto;">服务选项：</span>
                    <?php if ($options_arr){
                        foreach ($options_arr as $key=>$value){ ?>
                    <input type="checkbox" name="service_options[]" value="<?php echo $key; ?>" id="service_options" style="margin-top: 9px;float: left;" <?php if($item_info && in_array($key,explode(',',$item_info['service_options']))){ echo 'checked="checked"';}?>><span style="text-align: left;padding-left: 3px;width: auto"><?php echo $value; ?></span>
                    <?php }} ?>
                </li>

            </ul>
        </div>
        <div class="clear"></div>
        <h3 class="mt30" style="margin-bottom: 10px;">商品描述(<span  style="font-size:14px;color:#cc0011;">内容最大宽928px</span>)</h3>
                 <?php echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
                            <script id="content" name="content" type="text/plain"><?php if($item_info){ echo html($item_info['content']);} ?></script>
                            <script type="text/javascript">
                                var ue = UE.getEditor('content', {
                                	toolbars: [
                                        [ 'source','bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc','simpleupload','insertimage','template','link', 'unlink', '|' ,'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts','fullscreen']
                                    ],
                                    initialFrameWidth : 930,
                                    initialFrameHeight : 450
                                });
                            </script>
            <div class="clear"></div>

        <h3 class="mt30" style="margin-bottom: 10px;">APP商品描述(<span  style="font-size:14px;color:#cc0011;">内容最大宽928px</span>)</h3>
<!--        --><?php //echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
        <script id="app_content" name="app_content" type="text/plain"><?php if($item_info){ echo html($item_info['app_content']);} ?></script>
        <script type="text/javascript">
            var ue = UE.getEditor('app_content', {
                toolbars: [
                    [ 'source','bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc','simpleupload','insertimage','template','link', 'unlink', '|' ,'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts','fullscreen']
                ],
                initialFrameWidth : 930,
                initialFrameHeight : 450
            });
        </script>
            <div class="clear"></div>
        <div style="text-align:center; margin:20px 0px; clear:both; display:block;"><a href="javascript:void(0)" onclick="$('#jsonForm').submit();" class="b_btn">确认提交</a></div>
        </form>
    </div>
</div>
<script src="js/default/jquery.multi-select.js" type="text/javascript"></script>
<script type="text/javascript">
	document.getElementById('next').onclick=function(){
		document.getElementById('pic_list').scrollLeft=document.getElementById('pic_list').scrollLeft+70;
	}
	document.getElementById('last').onclick=function(){
		document.getElementById('pic_list').scrollLeft=document.getElementById('pic_list').scrollLeft-70;
	}
</script>
<script type="text/javascript">
  $('#pre-selected-options').multiSelect();
</script>
<script language="javascript" type="text/javascript">
	//形象照片
//	$("#path_file").wrap("<form id='path_upload' action='" + base_url + "index.php/upload/uploadImage' method='post' enctype='multipart/form-data'></form>");
//	$("#path_file").change(function() { //选择文件
//		$("#path_upload").ajaxSubmit({
//			dataType: 'json',
//			data: {
//				'model': 'product',
//				'field': 'path_file'
//			},
//			beforeSend: function() {
//				$('body').append($('<div id="loading"></div>'));
//			},
//			uploadProgress: function(event, position, total, percentComplete) {},
//			success: function(res) {
//				$("#loading").remove();
//				if(res.success) {
//					$("#path").attr('src', res.data.file_path.replace('.', '_thumb.'));
//					$("input[name=path]").val(res.data.file_path);
//				} else {
//					var d = dialog({
//						fixed: true,
//						title: '提示',
//						content: res.message
//					});
//					d.show();
//					setTimeout(function() {
//						d.close().remove();
//					}, 2000);
//				}
//			},
//			error: function(xhr) {}
//		});
//	});
	$("#material_name,#fabric_name,#leather_name,#filler_name,#style_name,#brand_name").bind({
		focus: function(e) {
			$(this).siblings('.select_tabs').show();
		},
		click: function(e) {
			e.stopPropagation();
		}
	});
	$(".select_tabs dd").click(function(e) {
		e.stopPropagation();
		$(this).parent().siblings('input').val($(this).html());
		$(".select_tabs").hide();
	});
	$(document).click(function() {
		$(".select_tabs").hide();
	})
</script>
<script type="text/javascript">
    $(document).ready(function(){
        if ($('#pic_list').find('.pic_info').length){
            $('#last').show();
            $('#next').show();
        }
    });

    $('#pic_list').bind('DOMNodeInserted', function(e) {
        $('#last').show();
        $('#next').show();
    });
    function enter_pic(obj) {
        $(obj).find('p').slideDown('slow');
    }
    function leave_pic(obj) {
        $(obj).find('p').slideUp('slow');
    }
    function del_pice(obj) {
        var data_selected = $(obj).data("data-selected");
        if(data_selected == 1 && typeof(data_selected) != "undefined"){
            $("input[name='path']").val('');
        }
        $(obj).parent().parent().remove();
    }
    function select_pice(obj) {
        var path = $(obj).parent().siblings("#select_path").val();
        $(".picture img:first").attr('src',path);
        $("input[name='path']").val(path);
        $("#pic_list").find(".pic_info").each(function(){
            $(this).find('#select_pice_path').css('display', '');
            $(this).find('.del_pic').removeData('selected');
        });
        $(obj).prev('.del_pic').data("data-selected","1");
        $(obj).hide();
    }
    //参数mulu
    $(function () {
        //形象照片
        $("input[name='path_file[]']").wrap("<form id='path_upload' action='<?php echo base_url(); ?>index.php/upload/batch_uploadImage' method='post' enctype='multipart/form-data'></form>");
        $("#path_file").change(function(){ //选择文件
            $("#path_upload").ajaxSubmit({
                dataType:  'json',
                data: {
                    'model': 'product',
                    'field': 'path_file'
                },
                beforeSend: function() {
                    $("#path_load").show();
                },
                uploadProgress: function(event, position, total, percentComplete) {
                },
                success: function(res) {
                    $("#path_load").hide();
                    if (res.success) {
                        var html = '';
                        for(var i = 0; i < res.data.length; i++) {
                            html += '<div class="pic_info" onmouseenter="enter_pic(this)" onmouseleave="leave_pic(this)">';
                            html += '<img src="'+res.data[i].file_path.replace('.', '_thumb.')+'" style="width: 60px;height: 60px" id="list_path" onclick="select_img(this)"/>';
                            html += '<input type="hidden" name="batch_path_ids[]" value="'+res.data[i].id+'" />';
                            html += '<input type="hidden" id="select_path" value="'+res.data[i].file_path+'" />';
                            html += '<p style="position:absolute; background:#e8e8e8;opacity:1;width:100%;height:19px;bottom:0;z-index:1;display: none">';
                            html += '<img onclick="javascript:del_pice(this);" style="cursor: pointer;position:absolute;right:7px;bottom:3px;width: 13px;height: 13px;z-index:3;" src="images/default/close.png" title="删除">';
                            html += '<img onclick="javascript:select_pice(this);" style="cursor: pointer;position:absolute;width: 13px;right: 50px;bottom:3px;height: 13px;z-index:3;" src="images/default/open.png" title="设为封面" id="select_pice_path">';
                            html += '</p>';
                            html += '</div>';
                        }
                        $("#pic_list").append(html);
                        var src = res.data[0].file_path.replace('.', '_thumb.');
                        $(".picture img:first").attr('src',src);
                    } else {
                        return my_alert('fail', 0, res.message);
                    }
                },
                error:function(xhr){
                }
            });
        });
    });
    function select_img(obj){
        var src = $(obj)[0].src;
        $("#pic_list .pic_info #list_path").removeClass('pic_img');
        $(obj).addClass('pic_img');
        $(".picture img:first").attr('src',src);
    }

    /******************操作规格开始********************/
    function change_color(obj) {
        var index = $(obj).parents('tr.color_list').find("input[name='attribute_color_ids[]']").val();
        $("#table_size_color").find(".color_index_"+index+":first").find("td:first[rowspan]").html($(obj).val());
    }

    function change_size(obj) {
        var index = $(obj).parents('tr.size_list').find("input[name='attribute_size_ids[]']").val();
        $("#table_size_color").find(".size_index_"+index).html($(obj).val());
    }

    function change_price(obj) {
        var price = $(obj).val();
        if (isNaN(price)) {
            $(obj).val("")
            var d = dialog({
                width: 200,
                title: '提示',
                fixed: true,
                content: '请输入正确的价格'
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
            }, 2000);
            return false;
        }
    }

    function change_stock(obj) {
        var stock = $(obj).val();
        if (isNaN(stock)) {
            $(obj).val("")
            var d = dialog({
                width: 200,
                title: '提示',
                fixed: true,
                content: '请输入正确的库存数量'
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
            }, 2000);
            return false;
        }
    }

    function change_color_size_open(val) {
        if (val == 1) {
            $('#color_size_open_btn').hide();
            $('#color_size_close_btn').show();
            $('#size_color_list').show();
        } else {
            $('#color_size_open_btn').show();
            $('#color_size_close_btn').hide();
            $('#size_color_list').hide();
        }
        $('#color_size_open').val(val);
    }

    var color_id_index = 1;
    var size_id_index = 1;
    function get_size_color_list(obj, type) {
        var product_color_name = $('#product_color_name').val();
        var product_size_name = $('#product_size_name').val();
        var attribute_color_ids = '';
        var attribute_color_name = '';
        var attribute_size_ids = '';
        var attribute_size_name = '';
        var color_num = 0;
        var size_num = 0;
        if (!product_color_name) {
            $('#product_color_name').focus();
            var d = dialog({
                width: 200,
                title: '提示',
                fixed: true,
                content: '规格名称不能为空'
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
            }, 2000);
            return false;
        }
        if (!product_size_name) {
            $('#product_size_name').focus();
            var d = dialog({
                width: 200,
                title: '提示',
                fixed: true,
                content: '规格名称不能为空'
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
            }, 2000);
            return false;
        }
        if (type == 'color') {
            var color_tr_end = $('#color_table').find("tr:last").index();
            var color_tr_cur = $(obj).parents('tr').index();
            if (color_tr_end == color_tr_cur) {
//                color_id_index++;
                color_id_index = parseInt($('#color_table').find("tr:last").find("input[name='attribute_color_ids[]']").val()) + 1;
                //添加/删除颜色项
                var color_html = '<tr class="color_list">';
                color_html += '<td width="10%">';
                color_html += '<input onclick="javascript:get_size_color_list(this, \'color\');"  class="checkbox_style" name="attribute_color_ids[]" value="'+color_id_index+'" type="checkbox">';
                color_html += ' </td>';
                color_html += '<td>';
                color_html += '<input onchange="javascript:change_color(this);" name="attribute_color_name[]" placeholder="请输入主属性" size="20" maxlength="60" class="input_blur" type="text">';
                color_html += '</td>';
                color_html += '<td width="25%">';
                color_html += '<input name="attribute_color_hint[]" placeholder="主属性备注" size="10" maxlength="60" class="input_blur" type="text">';
                color_html += '</td>';
                color_html += '<td width="20%">';
                color_html += '<a class="good_url_path_file_src_a" title="点击查看大图" href="images/admin/no_pic.png" target="_blank" style="float:left;"><img class="good_url_path_file_src" width="30px" height="30px" src="images/admin/no_pic.png" onerror="javascript:this.src=\'images/admin/no_pic.png\';" /></a>';
                color_html += '<div style="float:left; margin-top:0px;">';
                color_html += '<a style=" position:relative; width:auto; " >';
                color_html += '<span style="cursor:pointer;font-size:12px;height:30px;width: auto;color: #fff;padding-right:10px;border-radius:4px;" class="but_4">传图<form class="myupload" action="'+base_url+'admincp.php/upload/uploadImage2" method="post" enctype="multipart/form-data"><input style="left:0px;top:0px; background:#000; width:100%;height:25px;line-height:25px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" class="good_url_path_file" onchange="javascript:file_change_upload(this);" name="good_url_path_file" ></form></span>';
                color_html += '<i class="load good_url_path_file_load" style="cursor:pointer;display:none;width:auto;padding-left:0px; position: absolute;right: 4px;"><img src="images/admin/loading_2.gif" width="32" height="32"></i>';
                color_html += '</a>';
                color_html += '<input value="" type="hidden" name="attribute_path[]">';
                color_html += '</div>';
                color_html += '</td>';
                color_html += '</tr>';
                $('#color_table').find("tr:last").after(color_html);
            } else {
                //删除
                $(obj).parents('tr.color_list').remove();
                //删除属性里的所有颜色项
                var index_val = $(obj).val();
                $("#table_size_color").find("tr.color_index_"+index_val).remove();
            }
        } else if (type == 'size') {
            var size_tr_end = $('#size_table').find("tr:last").index();
            var size_tr_cur = $(obj).parents('tr').index();
            if (size_tr_end == size_tr_cur) {
                //			size_id_index++;
                size_id_index = parseInt($('#size_table').find("tr:last").find("input[name='attribute_size_ids[]']").val()) + 1;
                //添加/删除尺码项
                var size_html = '<tr class="size_list">';
                size_html += '<td width="10%">';
                size_html += '<input onclick="javascript:get_size_color_list(this, \'size\');"  class="checkbox_style" name="attribute_size_ids[]" value="'+size_id_index+'" type="checkbox">';
                size_html += '</td>';
                size_html += '<td>';
                size_html += '<input onchange="javascript:change_size(this);"  name="attribute_size_name[]" placeholder="请输入主属性" size="30" maxlength="60" class="input_blur" type="text">';
                size_html += '</td>';
                size_html += '<td width="20%">';
                size_html += '<input name="attribute_size_hint[]" placeholder="主属性备注" size="15" maxlength="60" class="input_blur" type="text">';
                size_html += '</td>';
                size_html += '</tr>';
                $('#size_table').find("tr:last").after(size_html);
            } else {
                $(obj).parents('tr.size_list').remove();
                //删除属性里的所有尺码项
                var index_val = $(obj).val();
                if (size_tr_cur == 1) {
                    //当删除尺码是第一项值时，处理方法如下
                    var tmp_size_num = 0;
                    $("#table_size_color").find(".size_index_"+index_val).parent().remove();
                    //获取尺码数量
                    $("input[name='attribute_size_ids[]']:checked").each(function(i,n){
                        tmp_size_num++;
                    });
                    $("input[name='attribute_color_ids[]']:checked").each(function(i,n){
                        var tmp_color_id = $(this).val();
                        var name = $(this).parents("tr.color_list").find("input[name='attribute_color_name[]']").val();
                        $("#table_size_color").find(".color_index_"+tmp_color_id+":first").find('td:first').before("<td rowspan='"+tmp_size_num+"'>"+name+"<\/td>");
                    });
                } else {
                    $("#table_size_color").find(".size_index_"+index_val).parent().remove();
                }
            }
        }
        //颜色
        $("input[name='attribute_color_ids[]']:checked").each(function(i,n){
            color_num++;
            attribute_color_ids += $(this).val() + ",";
            var name = $(this).parents('tr.color_list').find("input[name='attribute_color_name[]']").val();
            if (!name) {
                $(this).parents('tr.color_list').find("input[name='attribute_color_name[]']").focus();
                return false;
            }
            attribute_color_name += name + ",";
        });
        //尺码
        $("input[name='attribute_size_ids[]']:checked").each(function(i,n){
//            size_num++;
            attribute_size_ids += $(this).val() + ",";
            var name = $(this).parents('tr.size_list').find("input[name='attribute_size_name[]']").val();
            if (!name) {
                $(this).parents('tr.size_list').find("input[name='attribute_size_name[]']").focus();
                return false;
            }
            attribute_size_name += name + ",";
        });
        size_num = $("input[name='attribute_size_ids[]']:checked").length;
        //颜色与尺码组合
        var color_size_html = '';
        var first = 0;
        $("input[name='attribute_color_ids[]']:checked").each(function(i,n){
            var color_id = $(this).val();
            var color_name = $(this).parents('tr.color_list').find("input[name='attribute_color_name[]']").val();
            $("input[name='attribute_size_ids[]']:checked").each(function(x,y){
                var size_id = $(this).val();
                var size_name = $(this).parents('tr.size_list').find("input[name='attribute_size_name[]']").val();

                //判断颜色class是否已存在
                if ($("#table_size_color tr").hasClass("color_index_"+color_id)) {
                    //修改颜色合并单元格里的值与名称
                    $("#table_size_color").find(".color_index_"+color_id+":first").find("td:first").attr("rowspan", size_num);
                    $("#table_size_color").find(".color_index_"+color_id+":first").find("td:first[rowspan]").html(color_name);
                    //判断尺码项是否存在
                    if ($("#table_size_color").find(".color_index_"+color_id).find("td").hasClass("size_index_"+size_id)) {
                        //存在此项，直接修改尺码名称
                        $("#table_size_color").find(".color_index_"+color_id).find("td.size_index_"+size_id).html(size_name);
                    } else {
                        //添加尺码项
                        var tr_html = '';
                        tr_html += '<tr class="color_index_'+color_id+'">';
                        tr_html += '<td class="size_index_'+size_id+'">'+size_name+'</td>';
                        tr_html += '<td><input onchange="javascript:change_price(this);" size="10" type="text" name="attribute_price[]"></td>';
                        tr_html += '<td><input onchange="javascript:change_stock(this);" size="10" type="text" name="attribute_stock[]"></td>';
                        tr_html += '<td><input size="10" type="text" name="attribute_product_num[]"></td>';
                        tr_html += ' </tr>';
                        $("#table_size_color").find(".color_index_"+color_id+":last").after(tr_html);
                    }
                } else {
                    first = 1;
                    //第一项
                    if (x == 0) {
                        color_size_html += '<tr class="color_index_'+color_id+'">';
                        color_size_html += '<td rowspan="'+size_num+'">'+color_name+'</td>';
                        color_size_html += '<td class="size_index_'+size_id+'">'+size_name+'</td>';
                        color_size_html += '<td><input onchange="javascript:change_price(this);" size="10" type="text" name="attribute_price[]"></td>';
                        color_size_html += '<td><input onchange="javascript:change_stock(this);" size="10" type="text" name="attribute_stock[]"></td>';
                        color_size_html += '<td><input size="10" type="text" name="attribute_product_num[]"></td>';
                        color_size_html += '</tr>';
                    } else {
                        color_size_html += '<tr class="color_index_'+color_id+'">';
                        color_size_html += '<td class="size_index_'+size_id+'">'+size_name+'</td>';
                        color_size_html += '<td><input onchange="javascript:change_price(this);" size="10" type="text" name="attribute_price[]"></td>';
                        color_size_html += '<td><input onchange="javascript:change_stock(this);" size="10" type="text" name="attribute_stock[]"></td>';
                        color_size_html += '<td><input size="10" type="text" name="attribute_product_num[]"></td>';
                        color_size_html += ' </tr>';
                    }
                }
            });
        });
        if (first == 1) {
            $("#table_size_color").find("tr:last").after(color_size_html);
        }
    }
    /******************操作规格结束********************/
    function file_change_upload(obj) {
        $(obj).parent().parent().find(".myupload").ajaxSubmit({
            dataType:  'json',
            data: {
                'model': 'product_size_color',
                'field': 'good_url_path_file'
            },
            beforeSend: function() {
                $(obj).parent().parent().parent().find(".good_url_path_file_load").show();
            },
            uploadProgress: function(event, position, total, percentComplete) {
            },
            success: function(res) {
                $(obj).parent().parent().parent().find(".good_url_path_file_load").hide();
                if (res.success) {
                    $(obj).parent().parent().parent().parent().parent().parent().find(".good_url_path_file_src_a").attr("href", res.data.file_path);
                    $(obj).parent().parent().parent().parent().parent().parent().find(".good_url_path_file_src").attr("src", res.data.file_path.replace('.', '_thumb.')+"?"+res.data.field);
                    $(obj).parent().parent().parent().parent().find("input[name='attribute_path[]']").attr("value", res.data.file_path);
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
            error:function(xhr){
            }
        });
    }
    //参数mulu
    $(function () {
        //多链接传图
        if (!$(".good_url_path_file").parent('form').hasClass("myupload")) {
            $(".good_url_path_file").wrap("<form class='myupload' action='<?php echo base_url(); ?>admincp.php/upload/uploadImage2' method='post' enctype='multipart/form-data'></form>");
        }
    });

    $('input[name="unclear_price"]').click(function () {
        if ($(this).attr('checked')){
            $('#size_li').hide();
            $('#mar_input').hide();
            $('#pri_input').hide();
//            $('#size_li').val();
            $('input[name="sell_price"]').val('');
            $('input[name="market_price"]').val('');
            $('input[name="attribute_color_ids[]"]').removeAttr("checked");
            $('input[name="attribute_color_name[]"]').val('');
            $('input[name="attribute_color_hint[]"]').val('');
            $('input[name="attribute_path[]"]').val('');
            $('.good_url_path_file_src').attr('src','');
            $('input[name="attribute_size_ids[]"]').removeAttr("checked");
            $('input[name="attribute_size_name[]"]').val('');
            $('input[name="attribute_size_hint[]"]').val('');
            $('input[name="attribute_price[]"]').val('');
            $('input[name="attribute_stock[]"]').val('');
            $('input[name="attribute_product_num[]"]').val('');
            change_color_size_open(0);
        }else{
            $('#size_li').show();
            $('#mar_input').show();
            $('#pri_input').show();
        }
    });

    $(function () {
       if($('input[name="unclear_price"]').is(":checked")){
           $('#size_li').hide();
           $('#mar_input').hide();
           $('#pri_input').hide();
//           $('#size_li').val();
           $('input[name="sell_price"]').val('');
           $('input[name="market_price"]').val('');
           $('input[name="attribute_color_ids[]"]').removeAttr("checked");
           $('input[name="attribute_color_name[]"]').val('');
           $('input[name="attribute_color_hint[]"]').val('');
           $('input[name="attribute_path[]"]').val('');
           $('.good_url_path_file_src').attr('src','');
           $('input[name="attribute_size_ids[]"]').removeAttr("checked");
           $('input[name="attribute_size_name[]"]').val('');
           $('input[name="attribute_size_hint[]"]').val('');
           $('input[name="attribute_price[]"]').val('');
           $('input[name="attribute_stock[]"]').val('');
           $('input[name="attribute_product_num[]"]').val('');
           change_color_size_open(0);
       }
    });


</script>