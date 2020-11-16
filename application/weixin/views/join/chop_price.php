<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <base href="<?php echo base_url(); ?>" />
    <title>全民砍价</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <link rel="stylesheet" type="text/css" href="js/weixin/mui/css/mui.min.css"/>
    <link rel="stylesheet" type="text/css" href="js/weixin/mui/css/iconfont.css"/>
    <link rel="stylesheet" href="js/weixin/mui/css/base.css" />
    <style type="text/css">
    	header.mui-bar{height:44px;-webkit-box-shadow:none;box-shadow:none;}
    	header.mui-bar .mui-title{font-weight:bold;}
    	div.mui-content{margin-top:0;padding-top:0px;top: 0px;}
    	.ct-time{background:#fff; padding:15px 0px; border-bottom:1px solid #cbcecf; border-top:1px solid #cbcecf;margin-top:0px;}
    	.ct-time h2{font-size:14px; text-align: center; margin-bottom:17px;}
    	.ct-time h2 span{background:#f02387;margin:0px 3px; padding:0px 2px;color:#fff; border-radius:2px;}
    	.ct-time h3{font-size:14px; text-align: center;}
    	.ct-time h3 span{margin:0px 3px; padding:0px 2px;color:#f02387; border-radius:2px;}

    	.cj-commodity{ margin-top:10px;background:#fff; border-bottom:1px solid #cbcecf;}
    	.cj-commodity .picture{background:#f9f9fb; text-align:center;}
    	.cj-commodity .picture img{width:50%; margin:0px; padding:0px;}
    	.cj-commodity .txt{ margin-top:-8px; padding:10px 12px; background:#fff;}
    	.cj-commodity .txt h4{font-size:16px; margin-bottom:13px;}
    	.cj-commodity .txt h5{font-size:14px; color:#f02387; font-weight: bold;}
    	.cj-commodity .txt h5 span{text-decoration: line-through;margin-right:50px;}
    	.cj-commodity .txt p{margin:0px; padding:0px; text-align: center;}
    	.cj-commodity .txt p button{margin:25px 0px 5px; padding:0;height:30px; font-size:16px;background:#be9336;border-color:#be9336; width:270px; border-radius:0px;}
    	.cj-commodity .txt h6{text-align:center;}
    	.cj-commodity .txt h6 button{margin:15px 15px 5px;padding:0; height:30px;font-size:16px; width:110px;background:#f02387;border-color:#f02387;}

    	.cj-new{margin-top:10px;border-bottom:1px solid #cbcecf;}
    	.cj-new .tit{border-left:3px solid #f02387; background:#fff; padding:10px 8px; margin-bottom:5px;}
    	.cj-new .tit h2{font-size:16px;display: inline-block;}
    	.cj-new .tit span{color:#f02387;}

    	.cj-new ul li{padding:10px 0px 10px 11px;}
    	.cj-new ul li a img{border-radius: 100%; width:55px;height:55px;margin-left:11px; margin-right:13px;}
    	.cj-new ul li .mui-media-body h4{font-size:16px; margin:4px 0px 10px ; padding:0px;}
    	.cj-new ul li .mui-media-body p{color:#000;margin:0px; padding:0px;}
    	.cj-new ul li .mui-media-body p span{ color:#f02387;}

    	.cj-active{margin-top:10px;border-bottom:1px solid #cbcecf;}
    	.cj-active .tit{border-left:3px solid #f02387; background:#fff; padding:10px 8px; margin-bottom:5px;}
    	.cj-active .tit h2{font-size:16px;}
    	.cj-active .txt{background:#fff;padding:14px 12px;}
    	.cj-active .txt h5{font-size:14px;color:#000;}
    	.cj-active .txt p{font-size:14px;color:#000; margin:4px 0px 4px 18px;}

    	#sheet{background:#fff; padding:15px 13px 36px;}
    	#sheet .mui-input-group{border-bottom:1px solid #dbdbdb; padding:0px 25px;}
    	#sheet p{color:#000;margin:0px; font-size:16px; margin-bottom:5px;}
    	#sheet .mui-input-group:before,#sheet .mui-input-group:after{height:0;}
    	#sheet .mui-input-group .mui-input-row{margin:12px 0px 0px; padding:0;}
    	#sheet .mui-input-group .mui-input-row:after{height:0;}
    	#sheet .mui-input-group .mui-input-row .mui-input-clear ~ .mui-icon-clear{right:20%; top:5px;}
    	#sheet .mui-input-group label{ font-size:14px;margin:0px 8px 0px 0px; padding-right:0px;padding-left:0px;width:35px;}
    	#sheet .mui-input-group input{font-size:14px;border:1px solid #f0f0f6;height:31px; float:left;padding:0px 25px 0px 5px;}
    	#sheet .mui-input-group .mui-input-row .yzm.mui-input-clear ~ .mui-icon-clear{right:35%; top:5px;}
    	.mui-input-group p .mui-btn-red{ background:#f02387; border-color:#f02387;height:36px; padding:0px; margin-top:10px;}
    	#sheet .mui-input-group .mui-input-row button{border-color:#f02387;color:#f02387;float:right;height:25px;margin-left:5px; padding:0; width:54px;}
    	#sheet .mui-input-group .mui-input-row .mui-btn-red:enabled:active,#sheet .mui-input-group .mui-input-row .mui-btn-red.mui-active:enabled{color: #fff;border: 1px solid #f02387;background-color: #f02387;}
    	#sheet .box{padding:50px 25px 38px;}
    	#sheet .box .login{position:absolute;background:#fff;margin-top:-60px;left:40%;}
    	#sheet .box a{color:#000; width:33%; float: left; text-align: center;}
    	#sheet .box a p.mui-icon-weixin{width:50px; height:50px; border:1px solid #35cd35; border-radius:100%;color:#35cd35;font-size:45px; text-align:center;vertical-align:bottom;}
    	#sheet .box a p.mui-icon-weibo{width:50px; height:50px; border:1px solid #e9474d; border-radius:100%;color:#e9474d;font-size:50px; text-align:center;vertical-align:bottom;}
    	#sheet .box a p.mui-icon-qq{width:50px; height:50px; border:1px solid #49a3fc; border-radius:100%;color:#49a3fc;font-size:45px;}

    	.share-pop ul li{ width:25%;}
    	.share-pop ul li a span{font-size:37px;}
    	.mui-btn-red:enabled:active, .mui-btn-red.mui-active:enabled{color: #fff;border: 1px solid #e11377;background-color: #e11377;}
    </style>
</head>
<body style="background:#eaeeef;">
    <header class="mui-bar mui-bar-nav" style="background:#fff;">
        <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="color:#000;"></a>
        <h1 class="mui-title">全民砍价</h1>
    </header>
    <div class="mui-content">
        <div class="ct-time">
        	<h2 id="countdown">距活动结束还剩<span style="margin-left:5px;">02</span>:<span>02</span>:<span>02</span></h2>
        	<h3>当前参团人数已有<span><?php echo $pintuan_info['pintuan_people'];?>人</span>,拼团价为<span><?php echo $pintuan_price;?>元</span></h3>
        </div>
        <div class="cj-commodity">
        	<div class="picture">
				<img src="<?php echo $pic;?>">
        	</div>
        	<div class="txt">
        		<h4><?php echo $item_info['title'];?></h4>
        		<h5><span>原价:<?php echo $pintuan_info['high_price'];?></span>最低价:<?php echo $pintuan_info['low_price'];?></h5>
        		<p><button type="button" class="mui-btn mui-btn-yellow">宝贝已被砍掉<?php echo $choped_price;?>元</button></p>
        		<h6>
        			<a href="#popover" id="openPopover"><button type="button" class="mui-btn mui-btn-red">帮TA砍价</button></a>
        			<a href="#sheet" id="openSheet"><button type="button" class="mui-btn mui-btn-red">帮TA分享</button></a>
        		</h6>
        	</div>
        </div>
       	<div class="cj-new">
       		<div class="tit">
       			<h2>最新砍价</h2><span class="mui-icon mui-icon-reload mui-pull-right"></span>
       		</div>
       		<ul class="mui-table-view">
                    <?php
                    if ($chop_record) {
                        foreach ($chop_record as $item) {
                            ?>
       		    <li class="mui-table-view-cell mui-media">
       		        <a href="javascript:;">
       		            <img class="mui-pull-left" src="<?php echo $item['avatar'];?>" onerror="this.src='js/weixin/mui/images/60x60.gif'">
       		            <div class="mui-media-body">
       		                <h4><?php echo $item['nickname'];?></h4>
       		                <p class="mui-ellipsis">成功帮TA砍掉了<span><?php echo $item['chop_price'];?></span>元</p>
       		            </div>
       		        </a>
       		    </li>
                    <?php }}?>
       		</ul>
       	</div>
       	<div class="cj-active">
       		<div class="tit">
       			<h2>活动说明</h2>
       		</div>
       		<div class="txt">
       			<h5>参团规则</h5>
                                 <?php
                                   foreach($pintuan_rule as $key=>$ls){
                                 ?>
                                <p><?php echo $key+1;?>、当参团人数达到<span><?php echo $ls['low'];?>~<?php echo $ls['high'];?>人</span>时可享受到<span><?php echo $ls['money'];?>元</span>的价格。</p>
                                   <?php }?>
				<h5>砍价规则</h5>
       			<p>1、可邀请<span><?php echo $pintuan_info['cut_times'];?>位</span>好友砍价</p>
				<p>2、砍价总金额为<span><?php echo $pintuan_info['cut_total_money'];?>元</span></p>
       		</div>
       	</div>
    </div>
	<div id="sheet" class="mui-popover mui-popover-bottom mui-popover-action">
	    <p>您还不是本站会员，无法参与砍价活动~ <a href="" style="color:#000;"><span class="mui-icon mui-icon-closeempty mui-pull-right"></span></a></p>
	    <p>请注册成为会员</p>
	   	<form class="mui-input-group">
	        <div class="mui-input-row">
	       	    <label>手机:</label>
	            <input type="text" class="mui-input-clear" placeholder="手机:">
       	    </div>
       	    <div class="mui-input-row">
       	        <label>密码:</label>
       	        <input type="password" class="mui-input-clear" placeholder="手机:">
       	    </div>
       	    <div class="mui-input-row">
       	        <label style="width: auto;">短信验证码:</label>
       	        <input style="width:100px;" type="text" class="mui-input-clear yzm" placeholder="手机:">
       	    </div>
       	    <p><button type="button" class="mui-btn mui-btn-red mui-btn-block">立即注册</button></p>
       	    <div class="mui-input-row" style="text-align:right;">
       	        <span style="line-height:25px;font-size:14px;">已有账号?</span>
       	       	<button type="button" class="mui-btn mui-btn-red mui-btn-outlined">登录</button>
       	    </div>
       	</form>
       	<div class="box">
       		<span class="login">第三方登录</span>
       		<a href="#"><p class="mui-icon mui-icon-weixin"></p><h5>微信登录</h5></a>
       		<a href="#"><p class="mui-icon mui-icon-weibo"></p><h5>微博登录</h5></a>
       		<a href="#"><p class="mui-icon mui-icon-qq"></p><h5>QQ登录</h5></a>
       	</div>
    </div>
    <div id="share_pop" class="mui-popover mui-popover-action mui-popover-bottom share-pop mui-clearfix">
	    <ul class="mui-clearfix"style=" border-bottom:1px solid #f0f0f6;margin:0px 15px;padding:10px 0px;">
		    <Li><a href=""style="color:#39cc42;"><span class="mui-icon mui-icon-weixin"></span><h5>微信好友</h5></a></Li>
		    <Li><a href=""><span class="mui-icon mui-icon-pengyouquan"></span><h5>朋友圈</h5></a></Li>

		    <Li><a href=""style="color:#e9474d;"><span class="mui-icon iconfont icon-sina-circle"></span><h5>新浪微博</h5></a></Li>

		    <Li><a href="" style="color:#00b3f0;"><span class="mui-icon mui-icon-qq"></span><h5>QQ好友</h5></a></Li>
		    <Li><a href=""style="color:#f5bc3f;"><span class="mui-icon iconfont icon-qzone-circle"></span><h5>QQ空间</h5></a></Li>
		    <Li><a href="" style="color:#999;"><span class="mui-icon iconfont icon-link"></span><h5>复制链接</h5></a></Li>
    	</ul>
    		<p style="text-align:center; padding:15px 0px 5px;"><a href="" id="close" >取消</a></p>
	</div>
  <style type="text/css">
  		#popover{padding:0px 12px; height:75%; position:fixed;}
  		#popover .box{background: #fff;height:250px;border-radius:15px;padding:10px 25px 35px;}
  		#popover .box h4{font-weight:normal;color:#323232;margin:35px 0px 112px;}
  		#popover .box h4 span{color:#f02387; font-size:16px;}
  		#popover .box button{background:#f02387;border-color:#f02387; border-radius:7px;height:40px; padding:0px;}

  </style>
  <div id="popover" class="mui-popover mui-popover-action">
  	<div class="box">
  		<a href="" style="color:#323232;"><span class="mui-icon mui-icon-closeempty mui-pull-right"></span></a>
  		<h4>已经成功为好友砍掉<span>10.00</span>元</h4>
  		<a href=""><button type="button" class="mui-btn mui-btn-red mui-btn-block">确定</button></a>
  	</div>
  </div>
    <script src="js/weixin/mui/js/mui.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    mui.init();
        function countdown(t) {
            var h = Math.floor(t / 60 / 60 % 1000)
            var m = Math.floor(t / 60 % 60);
            var s = Math.floor(t % 60);
            if (h < 10) {
                h = "0" + h;
            }
            if (m < 10) {
                m = "0" + m;
            }
            if (s < 10) {
                s = "0" + s;
            }
             document.getElementById("countdown").innerHTML = '距活动结束还剩<span style="margin-left:5px;">'+h+'</span>:<span>'+m+'</span>:<span>'+s+'</span>';
            var ID = setInterval(function () {
                t--;
                var h = Math.floor(t / 60 / 60 % 1000)
                var m = Math.floor(t / 60 % 60);
                var s = Math.floor(t % 60);
                if (h < 10) {
                    h = "0" + h;
                }
                if (m < 10) {
                    m = "0" + m;
                }
                if (s < 10) {
                    s = "0" + s;
                }
                document.getElementById("countdown").innerHTML = '距活动结束还剩<span style="margin-left:5px;">'+h+'</span>:<span>'+m+'</span>:<span>'+s+'</span>';
                if (t <= 0) {
                    clearInterval(ID);
                    document.getElementById("countdown").innerHTML = '此拼团活动已结束';
//                    $("#takeBtn").html('参团已结束');
//                    $("#takeBtn").addClass('buygray');
                }
            }, 1000);
        }
        countdown(<?php echo $pintuan_info['end_time'] - time();?>);
    </script>
</body>
</html>