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
<style>
    .address_mask {
        background: rgba(0, 0, 0, 0.3);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 500;
        display: none;
    }

    .alert-box {
        width: 520px;
        background: #fff;
        z-index: 1000;
        position: absolute;
        border: 1px solid #e6e6e6;
    }

    .alert-box h4 {
        height: 40px;
        line-height: 40px;
        background: #f0f0f0;
        font-size: 16px;
        color: #666666;
        padding-left: 20px;
        position: relative;
    }

    .alert-box h4 a {
        width: 19px;
        height: 19px;
        background: url(images/default/close-btn.png) no-repeat;
        position: absolute;
        right: 20px;
        top: 8px;
    }

    .address_box {
        margin: 20px;
        height: 150px;
        overflow: auto;
    }

    .address-item {
        border: 1px solid #e6e6e6;
        height: 100px;
        width: 90%;
        margin-bottom: 10px;
        padding: 20px;
        overflow: hidden;
        cursor: pointer;
        position: relative;
    }

    .address-item p:nth-child(1) {
        font-size: 16px;
        font-weight: bold;
        color: #262626;
        margin-bottom: 16px;
    }

    .address-item p:nth-child(1) span {
        padding-left: 100px;
    }

    .address-item p:nth-child(2) {
        height: auto;
        line-height: 26px;
        font-size: 16px;
        color: #4c4c4c;
    }

    .address-item.active {
        border: 2px solid #c81624;
        background: url(images/default/true-btn.png) no-repeat right bottom;
    }

    .express {
        border: 1px solid #ccc;
    }

    .express .express-btn {
        position: relative;
        margin: 20px;
        height: 32px;
        padding: 0 20px;
        line-height: 32px;
        display: inline-block;
        cursor: pointer;
        font-size: 16px;
        color: #4c4c4c;
        border: 1px solid #ccc;
    }

    .express .express-btn:after {
        width: 390%;
        height: 1px;
        content: " ";
        background: #ccc;
        position: absolute;
        top: 50px;
        left: -20px;
    }

    .express .pay-btn {
        width: 130px;
        height: 38px;
        margin: 45px 0 25px 350px;
        line-height: 38px;
        text-align: center;
        display: block;
        background: #c81624;
        font-size: 18px;
        color: #fff;
    }

    .address-item .ok {
        position: absolute;
        right: 15px;
        top: 10px;
        z-index: 100;
    }

    .express .selected {
        background: url(images/default/true-btn.png) no-repeat right bottom;
        border: 1px solid #c81624;
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
                    <li><div class="fl" >当前价<font class="price purple"><small>¥</small><?php echo $pintuan_price; ?></font>
                            <i class="ml20">市场价<s>¥<?php if ($item_info){echo $item_info['market_price'];} ?></s></i>
                            <br><i>本次活动最低价：<font class="purple">¥<?php echo $pintuan_info['low_price'];?></font></i>

                        </div>
                        <div class="fr" style="position:relative;">
                            <div class="buy-time fr">
                                <div class=" clearfix mb5"><font class="purple">距离结束时间：</font><a id="countdown"><span class="icon2">10</span>小时<span class="icon2">52</span>小时<span class="icon2">30</span>秒</a></div>
                                <b class="purple"><?php echo $pintuan_info['pintuan_people'];?></b>人已参团
                            </div>
                        </div>
                        <input type="hidden" id="sell_price" value="<?php if ($item_info){echo $item_info['sell_price'];} ?>" >
                    </li>
                </ul>
            </div>
            <div class="text-box mt10">
                <ul>
                    <?php if ($item_info && $item_info['reduced_price'] > 0){ ?><li><span>运费</span><font class="free">免运费</font>（订单满<?php echo floatval($item_info['reduced_price']); ?>免运费）</li><?php } ?>
                </ul>
            </div>
            <?php if ($item_info && $item_info['color_size_open'] && !$item_info['unclear_price']){ ?>
                <div class="ncs-key clearfix">
                    <dl><dt><?php if ($item_info){echo $item_info['product_size_name'];} ?></dt>
                        <?php if ($size_list) { ?>
                            <?php foreach ($size_list as $key=>$value) { ?>
                                <dd><a onclick="javascript:select_size(this, '<?php echo $value['size_id']; ?>');" href="javascript:void(0);" title="<?php echo $value['size_name_hint']; ?>"><?php echo $value['size_name']; ?><i></i></a></dd>
                            <?php }} ?>
                    </dl>
                    <input type="hidden" id="spec_size_id" value="" />
                </div>
                <div class="clear"></div>
                <div class="ncs-key clearfix">
                    <dl><dt><?php if ($item_info){echo $item_info['product_color_name'];} ?></dt>
                        <?php if ($color_list) { ?>
                            <?php foreach ($color_list as $key=>$value) { ?>
                                <dd><a onclick="javascript:select_color(this, '<?php echo $value['color_id']; ?>');" href="javascript:void(0);" title="<?php echo $value['color_name'].'-'.$value['color_name_hint']; ?>"><?php echo $value['color_name']; ?><i></i></a></dd>
                            <?php }} ?>
                    </dl>
                    <input type="hidden" id="spec_color_id" value="" />
                </div>
                <div class="clear"></div>
            <?php } ?>
            <div class="ncs-buy ">
                <span>购买数量</span>
                <div class="ncs-figure-input"><font color="#c81624">每人限购一件</font></div><em class="kc ml20">库存：<?php if ($item_info){echo $item_info['stock'];} ?></em><input value="<?php if ($item_info){echo $item_info['stock'];} ?>" type="hidden" id="product_stock">
            </div>
            <div class="clear"></div>
            <div class="ncs-buy ">
                <span>定金</span>
                <div class="ncs-figure-input" style="margin-top: 11px"><font color="#c81624"><?php echo $pintuan_info['deposit'];?>元</font></div>
            </div>
            <div class="clear"></div>
            <?php if ($item_info && $item_info['service_options']){ ?>
                <div class="ncs-key clearfix mt10">
                    <dl><dt>服务</dt></dl>
                    <div class="notice">
                        <?php if ($options_arr){
                            foreach ($options_arr as $key=>$value){
                                if(in_array($key,explode(',',$item_info['service_options']))){?>
                                    <label style="margin-right: 10px"><img src="images/default/checked.png" style="width: 15px;margin: 0 10px 5px 0"><span><?php echo $value; ?></span></label>
                                <?php }}} ?>
                    </div>
                </div>
            <?php } ?>
            <div class="ncs-btn mt20">
                <?php if ($item_info && !$item_info['unclear_price']){ ?>
                    <a href="<?php echo $gourl; ?>"  class="addcart t-bg <?php echo $class_str; ?>" id="add_cart"><?php echo $button_str; ?></a>
                <?php } ?>
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
                <Li>活动规则</Li>
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
            <div class="product-introduce" style="padding:0 20px;text-align:left;">
                <h2><span>活动规则</span></h2>
                <p>1、定金规则：买家参团需要支付定金，成团不退定金，不成团可退定金，截团后支付尾款，逾期不支付尾款不退定金，产生退款、退换货不退定金。</p>
                <p>2、成团规则：参团人数满足最少人数即可成团。参团人数满足最多人数或者活动时间结束立即截团。</p>
                <p>3、叠加团规则：活动期间，产品价格将会随参团人数的增加而减少，（如:人数1-99人，价格为100；人数100-199，价格为90，以此类推）<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当参团人数达最高值时，可享受本次活动的最低参团价格。</p>
                <p>4、固定团规则：固定优惠金额，不管多少人参团都是相同的优惠价格。</p>
                <p>5、购买规则：每款活动产品，<font class="purple">每个ID限购一件</font>，且不享受其它优惠政策。</p>
                <p>6、订单规则：支付完尾款，卖家生产制作商品，发货时间以商家自己承诺时间为准。（家具为大件产品，买家发货后产生退换货纠纷，质量问题由卖家承担相应费用，无质量问题由买家承担相应费用）</p>
            </div>
        </div>
    </div>
</div>
<!--<form method="post" action="--><?php //echo getBaseUrl($html, "", "groupon/add_now_order.html", $client_index); ?><!--" id="json_form_submit">-->
<!--    <input type="hidden" id="cart_ids" name="cart_ids[]" >-->
<!--</form>-->
<div class="address_mask">
    <div class="alert-box">
        <h4 class="alert-title">请选择收货地址<a href="javascript:;" class="close-btn"></a></h4>
        <div class="address_box" id="addressBox">
            <ul>
                <?php
                if ($user_address_list) {
                    foreach ($user_address_list as $useraddress) {
                        ?>
                        <li class="address-item <?php echo $useraddress['is_default'] == 1 ? 'active' : ''; ?>"
                            data-addressid="<?php echo $useraddress['id']; ?>">

                            <p><?php echo $useraddress['buyer_name']; ?>
                                <span><?php echo $useraddress['mobile']; ?></span></p>
                            <p>地址：<?php echo $useraddress['txt_address']; ?> <?php echo $useraddress['address']; ?></p>
                            <?php
                            if ($useraddress['is_default'] == 1) {
                                ?>
                                <span class="ok" style="display:block;">默认地址</span>
                            <?php } ?>
                        </li>
                        <?php
                    }
                } else {
                    ?>
                    <li style="text-align: center;font-size:18px;line-height: 100px;">无收货地址,<a
                                href="<?php echo getBaseUrl(false, '', 'user/my_get_user_address.html', $client_index) ?>">去添加收货地址</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="express">
            <!--  					<h4 class="alert-title">配送方式</h4>-->
            <?php
            if (!empty($postage_way)){
            foreach ($postage_way as $key => $ls) {
                ?>
                <!--  					<span class="express-btn <?php echo $key == 0 ? 'selected' : ''; ?>" data-pid="<?php echo $ls['id']; ?>"><?php echo $ls['title']; ?></span>-->
            <?php }} ?>
            <a href="javascript:void(0);" class="pay-btn"
               onclick="add_now_order()">立即支付</a>
        </div>
    </div>
</div>
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
            $.post(base_url+"index.php/groupon/get_stock",
                {	"product_id": '<?php if ($item_info){ echo $item_info['id']; } ?>',
                	"ptkj_id": '<?php if ($pintuan_info){ echo $pintuan_info['id']; } ?>',
                    "size_id": size_id,
                    "color_id": color_id
                },
                function(res){
                    if(res.success) {
                        $('.kc.ml20').html("库存："+res.data.stock);
                        $("#product_stock").val(res.data.stock);
                        $('.price.purple').html('<small>¥</small>'+res.data.price);
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
            $.post(base_url+"index.php/groupon/get_stock",
                {	"product_id": '<?php if ($item_info){ echo $item_info['id']; } ?>',
                    "ptkj_id": '<?php if ($pintuan_info){ echo $pintuan_info['id']; } ?>',
                    "size_id": size_id,
                    "color_id": color_id
                },
                function(res){
                    if(res.success) {
                        $('.kc.ml20').html("库存："+res.data.stock);
                        $("#product_stock").val(res.data.stock);
                        $('.price.purple').html('<small>¥</small>'+res.data.price);
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


    function alertMask() {
        var color_id = $("#spec_color_id").val();
        var size_id = $("#spec_size_id").val();
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

        var w = $(window).width();
        var h = $(window).height();
        $('.address_mask').css({'display': 'block', 'width': w, 'height': h});
        var $alertBox = $('.alert-box');
        $alertBox.css({'top': h / 2 - $alertBox.height() / 2, 'left': w / 2 - $alertBox.width() / 2});
        return false;
    }

    $('.close-btn').on('click', function () {
        $('.address_mask').css({'display': 'none'});
    });

    $('.address-item').on('click', function () {
        $(this).addClass('active').siblings().removeClass('active');
    });


    //立即购买
    function add_now_order() {
        var color_id = $("#spec_color_id").val();
        var size_id = $("#spec_size_id").val();
        var address_id = $("#addressBox").find('li.active').data('addressid');
        if(!address_id){
            my_alert('',0,'请选择收货地址');
            return false;
        }
        $.post(base_url+"index.php/groupon/add_now_order",
            {	"ptkj_id": <?php if ($pintuan_info){ echo $pintuan_info['id']; } ?>,
                "color_id": color_id,
                "size_id": size_id,
                "address_id": address_id
            },
            function(res){
                if(res.success){
                    window.location.href = res.field;
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

    function countdown(t) {
        var d = Math.floor(t / 60 / 60 / 24);
        var h = Math.floor(t / 60 / 60 % 24);
        var m = Math.floor(t / 60 % 60);
        var s = Math.floor(t % 60);
        if (d < 10) {
            d = "0" + d;
        }
        if (h < 10) {
            h = "0" + h;
        }
        if (m < 10) {
            m = "0" + m;
        }
        if (s < 10) {
            s = "0" + s;
        }
        if (t <= 0) {
            $("#countdown").html('<span class="icon2">00</span>小时<span class="icon2">00</span>分<span class="icon2">00</span>秒');
            return false;
        }
        if(d > 0){
            $("#countdown").html('<span class="icon2">' + d + '</span>天<span class="icon2">' + h + '</span>小时<span class="icon2">' + m + '</span>分<span class="icon2">' + s + '</span>秒');
        }else{
            $("#countdown").html('<span class="icon2">' + h + '</span>小时<span class="icon2">' + m + '</span>分<span class="icon2">' + s + '</span>秒');
        }
        var ID = setInterval(function () {
            t--;
            var d = Math.floor(t / 60 / 60 / 24);
            var h = Math.floor(t / 60 / 60 % 24);
            var m = Math.floor(t / 60 % 60);
            var s = Math.floor(t % 60);
            if (d < 10) {
                d = "0" + d;
            }
            if (h < 10) {
                h = "0" + h;
            }
            if (m < 10) {
                m = "0" + m;
            }
            if (s < 10) {
                s = "0" + s;
            }
            if(d > 0){
                $("#countdown").html('<span class="icon2">' + d + '</span>天<span class="icon2">' + h + '</span>小时<span class="icon2">' + m + '</span>分<span class="icon2">' + s + '</span>秒');
            }else{
                $("#countdown").html('<span class="icon2">' + h + '</span>小时<span class="icon2">' + m + '</span>分<span class="icon2">' + s + '</span>秒');
            }
            if (t <= 0) {
                clearInterval(ID);
                $("#countdown").html('<span class="icon2">00</span>小时<span class="icon2">00</span>分<span class="icon2">00</span>秒');
                $("#add_cart").html('活动已结束');
                $("#add_cart").addClass('add_gray');
                $("#add_cart").attr('javascript:void(0);');
            }
        }, 1000);
    }
    countdown(<?php echo $pintuan_info['end_time'] - time();?>);
</script>