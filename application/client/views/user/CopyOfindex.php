<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right mt20">
        <div class="member_headline box_shadow clearfix">
            <div class="info">
                <img src="<?php if ($userInfo){echo preg_match('/^http/',$userInfo['avatar']) ? $userInfo['avatar'] : preg_replace("/\./","_thumb.",$userInfo['avatar']);} ?>" onerror="this.src='images/default/defluat.png'" style="width:100px;">
                <p><b><?php echo get_cookie('user_username');?></b>  上次登录时间：<?php echo date('Y-m-d H:i:s',$userInfo['login_time']);?><a href="<?php echo getBaseUrl(false,"","user/my_change_user_info",$client_index);?>">修改资料/图像</a></p>
            </div>
            <ul class="short">
                <Li><b>我的资产</b>
                    <span class="purple"><small>￥</small><?php echo $userInfo['total'];?></span><a href="<?php echo getBaseUrl(false,"","pay/recharge.html",$client_index);?>" class="m_btn">充值</a>
                </Li>
                <Li><b>我的街贝</b>
                    <span><?php echo $userInfo['score'];?></span>
<!--                    <a href="" class="m_btn gray">使用</a>-->
                </Li>
                <Li><b>优惠券</b>
                    <span>0</span>
                </Li>
            </ul>
        </div>
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">最近订单</span><a href="<?php echo getBaseUrl($html, "", "order.html", $client_index); ?>" class="more">查看全部订单</a></div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
                <thead>
                    <tr>
                        <th width="44%" class="tal">属性</th>
                        <th width="15%">单价</th>
                        <th width="13%">数量</th>
                        <th width="11%">金额</th>
                        <th width="10%">订单状态</th>
                        <th width="7%">操作</th>
                    </tr>
                    <tr>
                        <td colspan="6" class="bj">&nbsp;</td>
                    </tr>
                </thead>

                <tbody class="mt10">
                   <?php if ($orderList) { ?>
                        <?php foreach ($orderList as $order) { ?>
                    <tr>
                        <th colspan="6"><font class="c9">下单时间：<?php echo date('Y-m-d H:i:s',$order['add_time']);?></font>&nbsp;&nbsp;&nbsp;订单编号：<?php echo $order['order_number'];?></th>
                    </tr>
                       <?php
                          if($order['product']){
                               foreach($order['product'] as $item){  
                                  $url = getBaseUrl($html, "", "product/detail/{$item['product_id']}.html", $client_index); 
                            ?>
                        <tr>
                            <td valign="middle"><div class="info"><a href="<?php echo $url;?>"><img src="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"><?php echo $item['product_title'];?> 尺码：<?php echo $item['size_name'];?> 颜色：<?php echo $item['color_name'];?></a></div></td>
                            <td align="center"><small>¥</small><?php echo $item['buy_price'];?></td>
                            <td align="center"><?php echo $item['buy_number'];?></td>
                            <td align="center"><span class="purple"><small>¥</small><?php echo $item['buy_price']*$item['buy_number'];?></span></td>
                            <td align="center" ><font class="c9"><?php echo $status[$order['status']]?></font><br></td>
                            <td align="center"><a href="<?php echo getBaseUrl($html, "", "order/view/{$order['id']}.html", $client_index); ?>" class="m_btn gray">查看详情</a></td>
                        </tr>
                             <?php }}?>
                <?php }} ?>
                </tbody>
            </table>
        </div>
<!--        <div class="box_shadow clearfix mt20 m_border member_product">
            <div class="member_title"><span class="bt">猜您喜欢的产品</span></div>
            <div class="bd">
                <a href="javascript:void(0)" class="prev"></a>
                <a href="javascript:void(0)" class="next"><i class="icon"></i></a>	
                <ul class="picList">
                    <Li>
                        <div class="picture"><a href="product_detail.html"><img class="lazy" data-original="images/default/img5.png"></a></div>
                        <div class="property"><P class="nowrap"><a href="product_detail.html">夏季时尚女灰色修身连衣裙</a></P>
                            <p><span class="price"><small>￥</small>168<s>￥598</s></span></p>
                        </div>
                    </Li>
                </ul>
            </div>
        </div>-->
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });

</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>

