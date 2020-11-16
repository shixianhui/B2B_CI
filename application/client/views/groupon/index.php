
<div class="warp">
<!--    <div class="special_tab mt30">
        <ul>
            <Li class="current"><a href=""><img src="images/default/img7.png"><span>拼团砍价</span></a></Li>
            <Li><a href=""><img src="images/default/img7.png"><span>幸运转盘</span></a></Li>
            <Li><a href=""><img src="images/default/img7.png"><span>竞猜达人</span></a></Li>
            <Li><a href=""><img src="images/default/img7.png"><span>限时秒杀</span></a></Li>
        </ul>
    </div>-->
    <div class="clear"></div>
    <div class="floor-tit1 mt30">
        <div class="bt"><strong><i class="icon2"></i>蚁立团预购</strong><span> GROUP PRE PURCHASE </span></div>
<!--        <a href="mryg.html" class="time"><i class="icon"></i>明日预告</a>-->
    </div> 
    <?php
    if ($item_list) {
        foreach ($item_list as $item) {
            ?>
            <div class="special_item clearfix" data-time="<?php echo $item['end_time'] - time(); ?>">
                <div class="picture"><img class="lazy" data-original="<?php echo $item['path']; ?>"></div>
                <div class="information">
                    <h4 class="nowrap"><?php echo $item['title']; ?></h4>
                    <div class="price"><small>¥</small><?php echo $item['pintuan_price']; ?><span class="status">当前价</span><s>¥<?php echo $item['market_price']; ?></s><span style="font-size: 14px"> (<?php echo $type_arr[$item['type']]; ?>)</span></div>
                    <div class="process">已参团<font class="purple ml10"><?php echo $item['pintuan_people'];?>人</font></div>
            <?php if ($item['end_time'] > time()){ ?>
                    <div class="time">距结束：<em>01</em>天<em>16</em>时<em>38</em>分<em>16</em>秒</div>
                <?php }else{ ?>
                    <div class="time" style="font-size: 16px">活动已结束!</div>
                <?php } ?>
                    <a href="<?php echo getBaseUrl(false,"","groupon/detail/".$item['id'],$client_index)?>" class="btn t-f" target="_blank">查看详情</a>
                </div>
            </div>
        <?php }
    } ?>
    <div class="clear"></div>
    <div class="special_introduce mt30">
        <h2><span>活动规则</span></h2>
        <p>1、定金规则：买家参团需要支付定金，成团不退定金，不成团可退定金，截团后支付尾款，逾期不支付尾款不退定金，产生退款、退换货不退定金。</p>
        <p>2、成团规则：参团人数满足最少人数即可成团。参团人数满足最多人数或者活动时间结束立即截团。</p>
        <p>3、叠加团规则：活动期间，产品价格将会随参团人数的增加而减少，（如:人数1-99人，价格为100；人数100-199，价格为90，以此类推）<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当参团人数达最高值时，可享受本次活动的最低参团价格。</p>
        <p>4、固定团规则：固定优惠金额，不管多少人参团都是相同的优惠价格。</p>
        <p>5、购买规则：每款活动产品，<font class="purple">每个ID限购一件</font>，且不享受其它优惠政策。</p>
        <p>6、订单规则：支付完尾款，卖家生产制作商品，发货时间以商家自己承诺时间为准。（家具为大件产品，买家发货后产生退换货纠纷，质量问题由卖家承担相应费用，无质量问题由买家承担相应费用）</p>

    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
    function countdown(ele) {
        var t = $(ele).data('time');
        if(t <= 0){
            $(ele).find('.time').html('活动已结束!');
            $(ele).find('.time').css('font-size','16px');
            return false;
        }

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
            $(ele).find('.time').html('距结束：<em>'+d+'</em>天<em>'+h+'</em>时<em>'+m+'</em>分<em>'+s+'</em>秒');
        }else{
            $(ele).find('.time').html('距结束：<em>'+h+'</em>时<em>'+m+'</em>分<em>'+s+'</em>秒');
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
                $(ele).find('.time').html('距结束：<em>'+d+'</em>天<em>'+h+'</em>时<em>'+m+'</em>分<em>'+s+'</em>秒');
            }else{
                $(ele).find('.time').html('距结束：<em>'+h+'</em>时<em>'+m+'</em>分<em>'+s+'</em>秒');
            }
            if (t <= 0) {
                clearInterval(ID);
                $(ele).find('.time').html('活动已结束!');
                $(ele).find('.time').css('font-size','16px');
            }
        }, 1000);
    }
  $(".special_item").each(function(){
      countdown(this);
  })
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>


