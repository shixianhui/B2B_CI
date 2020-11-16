<?php echo $this->load->view("element/header_{$style}_tool", '', TRUE); ?>     
<div class="warp">
        <div class="shop-intro mt20">
            <?php $ad_store_list = $this->advdbclass->get_ad_store_list(1, $store_id, 1);
if ($ad_store_list) {
foreach ($ad_store_list as $key=>$item) {
	?>
		<img alt="<?php echo clearstring($item['ad_text']); ?>" src="<?php echo $item['path']; ?>">
<?php }} ?>
        </div>
        <div class="s225 fl  mt20">
           	<div class="side">
			<div class="service-box">
				<?php if ($item_info) {echo $item_info['store_name'];} ?>
				<a href="http://wpa.qq.com/msgrd?uin=<?php if ($item_info) {echo $item_info['im_qq'];} ?>&amp;menu=yes" class="person" target="_blank"></a>
			</div>
			<div class="info-msg">
				<div class="score">
					<p>描述相符：<span><?php if ($item_info) {echo $item_info['des_grade'];} ?></span></p>
					<p>服务态度：<span><?php if ($item_info) {echo $item_info['serve_grade'];} ?></span></p>
					<p>发货速度：<span><?php if ($item_info) {echo $item_info['express_grade'];} ?></span></p>
				</div>
				<div class="link">
					<p>联系电话：<span><?php if ($item_info) {echo $item_info['contact_num'];} ?></span></p>
					<p>工作时间：<span><?php if ($item_info) {echo $item_info['work_time'];} ?></span></p>
					<p>所在地区：<span><?php if ($item_info) {echo $item_info['txt_address'].$item_info['address'];} ?></span></p>
					<p>商家认证：<span>已认证</span></p>
				</div>
				<a href="javascript:;" class="shop-ad">
					<img src="css/default/<?php echo $style; ?>/images/shop-ad.jpg" />
				</a>
				<ul class="sign-list">
					<li><img src="css/default/<?php echo $style; ?>/images/shop-ad1.jpg" /></li>
					<li><img src="css/default/<?php echo $style; ?>/images/shop-ad2.jpg" /></li>
					<li><img src="css/default/<?php echo $style; ?>/images/shop-ad3.jpg" /></li>
				</ul>
			</div>
		</div>
        </div>
        <div class="s960 fr">
            <div class="shop-product mt20">
                <h2><img src="css/default/<?php echo $style; ?>/images/shop-title1.png"/></h2>
                <div class="activityBox">
                    <span class="prev"></span>
                    <div class="content">
                        <div class="contentInner">
                            <ul class="picture">
                                <?php $ad_store_list = $this->advdbclass->get_ad_store_list(2, $store_id, 10);
if ($ad_store_list) {
foreach ($ad_store_list as $key=>$item) {
	?>
                                <li>
                                    <a href="<?php echo $item['url'] ? $item['url'] : 'javascript:void(0)';?>"><img alt="<?php echo clearstring($item['ad_text']); ?>" src="<?php echo $item['path']; ?>"/></a>
                                </li>
                                <?php }} ?>
                            </ul>
                            <ul class="dian">
                                <?php
                                if ($ad_store_list) {
foreach ($ad_store_list as $key=>$item) {
	?>
                           
                                <li <?php echo $key==0 ? 'class="active"' : ''?>></li>
                                <?php }}?>
                            </ul>
                        </div>
                    </div>
                    <span class="next"></span>
                </div>
            </div>
        </div>
    </div>
<div class="pull-right contact">
        <ul class="wrap">
                <li>
                        <a href="javascript:;">
                                <img src="css/default/<?php echo $style; ?>/images/online.png"/>
                                <p>客服</p>
                        </a>
                        <div class="title">
                                <dl>
                                        <dt><?php if ($item_info) {echo $item_info['store_name'];} ?></dt>
                                        <dd><a href="http://wpa.qq.com/msgrd?uin=<?php if ($item_info) {echo $item_info['im_qq'];} ?>&amp;menu=yes" target="_blank"><img src="css/default/<?php echo $style; ?>/images/online.png"/><p>与我联系</p></a></dd>
                                </dl>
                                <dl>
                                        <dt>在线客服</dt>
                                        <dd><span>联系客服</span><a href="http://wpa.qq.com/msgrd?uin=<?php if ($item_info) {echo $item_info['im_qq'];} ?>&amp;menu=yes" target="_blank"><img src="css/default/<?php echo $style; ?>/images/online.png"/><p>与我联系</p></a></dd>
                                </dl>
                                <dl>
                                        <dt>工作时间</dt>
                                        <dd><?php if ($item_info) {echo $item_info['work_time'];} ?></dd>
                                </dl>
                                <dl>
                                        <dt>联系电话</dt>
                                        <dd><?php if ($item_info) {echo $item_info['contact_num'];} ?></dd>
                                </dl>
                        </div>
                </li>
                <li><a href="javascript:;"  onclick="$(window).scrollTop(0);">
                                <img src="css/default/<?php echo $style; ?>/images/top.png"/>
                        </a>
                </li>
        </ul>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var length,
                currentIndex = 0,
                interval,
                hasStarted = false, //是否已经开始轮播 
                t = 5000; //轮播时间间隔 
        length = $('.picture li').length;
        //将除了第一张图片隐藏 
        $('.picture li:not(:first)').hide();
        //将第一个slider-item设为激活状态 
        $('.dian li:first').addClass('active');
        //隐藏向前、向后翻按钮 
        //鼠标上悬时显示向前、向后翻按钮,停止滑动，鼠标离开时隐藏向前、向后翻按钮，开始滑动 
        $('.picture li, .prev, .next').hover(function () {
            stop();
        }, function () {
            start();
        });

        $('.dian li').hover(function (e) {
            stop();
            var preIndex = $(".dian li").filter(".active").index();
            currentIndex = $(this).index();
            play(preIndex, currentIndex);
        }, function () {
            start();
        });
        $('.prev').unbind('click');
        $('.prev').bind('click', function () {
            pre();
        });
        $('.next').unbind('click');
        $('.next').bind('click', function () {
            next();
        });
        /** 
         * 向前翻页 
         */
        function pre() {
            var preIndex = currentIndex;
            currentIndex = (--currentIndex + length) % length;
            play(preIndex, currentIndex);
        }
        /** 
         * 向后翻页 
         */
        function next() {
            var preIndex = currentIndex;
            currentIndex = ++currentIndex % length;
            play(preIndex, currentIndex);
        }
        /** 
         * 从preIndex页翻到currentIndex页 
         * preIndex 整数，翻页的起始页 
         * currentIndex 整数，翻到的那页 
         */
        function play(preIndex, currentIndex) {
            $('.picture li').eq(preIndex).fadeOut(500);
            $('.picture li').eq(currentIndex).fadeIn(1000);
            $('.dian li').removeClass('active');
            $('.dian li').eq(currentIndex).addClass('active');
        }
        /** 
         * 开始轮播 
         */
        function start() {
            if (!hasStarted) {
                hasStarted = true;
                interval = setInterval(next, t);
            }
        }
        /** 
         * 停止轮播 
         */
        function stop() {
            clearInterval(interval);
            hasStarted = false;
        }
        //开始轮播 
        start();
    });
</script>