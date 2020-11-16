<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <base href="<?php echo base_url(); ?>" />
    <title>招商加盟</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <link rel="stylesheet" type="text/css" href="js/weixin/mui/css/mui.min.css"/>
    <style type="text/css">
    	header.mui-bar{height:44px;-webkit-box-shadow:none;box-shadow:none;}
    	header.mui-bar .mui-title{font-weight:bold;}
    	div.mui-content{margin-top:0;padding-top:0px;top: 0px;}
    	.jm-merchants{background:#fff; padding:25px 0px 20px; border-top:1px solid #cbcecf;margin-top:0px;}
    	.jm-merchants h2{font-size:14px; text-align: center; margin-bottom:10px;font-weight:normal;}
    	.jm-merchants .box{border:1px solid #d8d8d8; height:115px; margin:0px 15px;height:300px;}
    	.jm-join{background:#fff; padding:7px 0px 20px; border-top:1px solid #cbcecf;margin-top:10px;}
    	.jm-join h2{color:#323232;font-size:14px;border-left:3px solid #f02387;padding-left:10px; margin:0px 0px 20px; line-height:20px;}
    	.jm-join .mui-input-group{padding:0px 40px;}
    	.jm-join .mui-input-group:before,.ac-register .mui-input-group:after{height:0;}
    	.jm-join .mui-input-group .mui-input-row{margin:0px 0px 15px; padding:0;}
    	.jm-join .mui-input-group .mui-input-row:after{height:0;}
    	.jm-join .mui-input-group .mui-input-row .mui-input-clear ~ .mui-icon-clear{right:32%; top:5px;}
    	.jm-join .mui-input-group label{ font-size:14px;margin:0px 5px 0px 0px; padding-right:0px;padding-left:0px;width:50px;}
    	.jm-join .mui-input-group input{font-size:12px;border:1px solid #f0f0f6;height:31px; width:46%; float:left;padding:0px 25px 0px 5px;}
    	.jm-join .mui-input-group .mui-input-row button{float: left;height:31px;margin-left:2px; padding:0; width:70px; border-radius:0px;font-size: 13px;}
    	.mui-input-group p{margin:0px 14px; padding:15px 0px 30px;}
    	.mui-input-group p .mui-btn-red{ background:#f02387; border-color:#f02387;height:41px; padding:0px;}
    	.mui-btn-red:enabled:active,.mui-btn-red.mui-active:enabled{color: #fff;border: 1px solid #e11377;background-color: #e11377;}
        .jm-join .box{padding:0px 15px;}
    	.jm-join .box p{color:#323232; font-size:14px; margin:0px;}
    	.jm-join .box p span{color:#f02387; font-size:14px;}
    	.jm-join .box label{margin:21px 10px 88px 30px;padding:15px 17px; display:inline-block;background:#e6e6e6;}
    	.jm-join .box .mui-btn-red{ background:#f02387; border-color:#f02387; border-radius:0px;padding:15px 10px;margin:21px 10px 88px 0px;}
    </style>
</head>
<body style="background:#eaeeef;">
    <header class="mui-bar mui-bar-nav" style="background:#fff;">
        <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="color:#000;display: none;"></a>
        <h1 class="mui-title">招商加盟</h1>
    </header>
    <div class="mui-content">
        <div class="jm-merchants">
        	<?php if ($systemInfo){echo html($systemInfo['presenter_city_text']);} ?>
        </div>
        <div class="jm-join">
        	<h2>我要加盟</h2>
        	<form class="mui-input-group">
        		<div class="mui-input-row">
        		    <label for="user">手机号:</label>
        		    <input id="username" type="text" class="mui-input-clear" placeholder="请输入手机号码">
        		    <button id="code_btn" type="button" class="mui-btn mui-btn-blue">获取验证码</button>
        		</div>
        		<div class="mui-input-row">
        			<label for="pwd">验证码:</label>
        		    <input id="code" type="text" class="mui-input-clear" placeholder="请输入短信验证码">
        		</div>
        		<p><button id="reg_btn" type="button" class="mui-btn mui-btn-red mui-btn-block">确认提交</button></p>
        	</form>
        	<div class="box">
        		<p><span>注:</span>可直接下载一折街APP，在注册界面填写下面的邀请码，也可加盟成为“店面分销商”</p>
        		<label id="invitation"><?php echo $pop_code; ?></label><button id="download_btn" type="button" class="mui-btn mui-btn-red">下载一折街APP</button>
        	</div>
        </div>

    </div>
<script src="js/weixin/mui/js/mui.js" type="text/javascript" charset="utf-8"></script>
<script src="js/weixin/mui/js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="js/weixin/mui/js/index.js?v=1.0" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var times = 60,
		cuttime;

	function code(idn) {
		times--;
		if(times > 0 && times < 60) {
			$(idn).text(times + "秒后获取");
			$(idn).attr('class', 'mui-btn mui-btn-grey');
			cuttime = setTimeout(function() {
				code(idn)
			}, 1000);
		} else {
			$(idn).text("获取验证码");
			times = 60;
			$(idn).attr('class', 'mui-btn mui-btn-blue');
			clearTimeout(cuttime);
		}
	}

	//获取验证码
	document.getElementById('code_btn').addEventListener('tap', function() {
		if(times == 60) {
			var username = document.getElementById("username").value;
			if(!username) {
				mui.toast('请输入您的手机号');
				return;
			}
			var reg = /^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/;
			if(!reg.test(username)) {
				mui.toast('请输入正确的手机号');
				return;
			}
			var url = base_url + 'join/get_reg_sms_code';
			mui.ajax(url, {
				data: {
					type: "reg",
					mobile: username
				},
				dataType: "json",
				type: "post",
				timeout: 10000, //超时时间设置为10秒；
				success: function(res) {
					if(res.success) {
						code("#code_btn");
						mui.toast(res.message);
					} else {
						mui.toast(res.message);
					}
				},
				error: error
			});
		}
		return false;
	});

    document.getElementById('reg_btn').addEventListener('tap',function () {
        var username = $('#username').val();
        var code = $('#code').val();

        if(!username) {
			mui.toast('请输入您的手机号');
			return;
		}
		var reg = /^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/;
		if(!reg.test(username)) {
			mui.toast('请输入正确的手机号');
			return;
		}
		if (!code) {
			mui.toast('请输入短信验证码');
			return;
		}

		var url = base_url + 'join/reg';
		mui.ajax(url, {
			data: {
				username: username,
				type: '2',
				code: code,
				pop_code:'<?php echo $pop_code; ?>'
			},
			dataType: "json",
			type: "post",
			timeout: 10000, //超时时间设置为10秒；
			success: function(res) {
				if(res.success) {
					var btnArray = ['取消', '下载一折街APP'];
					mui.confirm(res.message, '提示：', btnArray, function(e) {
						if(e.index == 1) {
							if (mui.os.android) {
								window.location.href = '<?php echo $systemInfo['android_full_update_url']; ?>';
							} else if (mui.os.ios) {
								window.location.href = '<?php echo $systemInfo['ios_full_update_url']; ?>';
							} else {
								window.location.href = '<?php echo base_url(); ?>';
							}
						}
					});
				} else {
					mui.toast(res.message);
				}
			},
			error: error
		});
    });

    document.getElementById('download_btn').addEventListener('tap',function () {
        if (mui.os.android) {
			window.location.href = '<?php echo $systemInfo['android_full_update_url']; ?>';
		} else if (mui.os.ios) {
			window.location.href = '<?php echo $systemInfo['ios_full_update_url']; ?>';
		} else {
			window.location.href = '<?php echo base_url(); ?>';
		}
    });
    </script>
</body>
</html>