<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?></title>
<base href="<?php echo base_url(); ?>" />
<meta name="title" content="<?php echo clearstring($title); ?>" />
<meta name="keywords" content="<?php echo clearstring($keywords); ?>" />
<meta name="description" content="<?php echo clearstring($description); ?>" />
<script>
var controller = '<?php echo $this->uri->segment(1); ?>';
var method = '<?php echo $this->uri->segment(2); ?>';
var base_url = '<?php echo base_url(); ?>';
</script>
<link href="css/default/rest.css?v=1.1" type="text/css" rel="stylesheet">
<link href="css/default/base.css?v=1.1" type="text/css" rel="stylesheet">
<script type="text/javascript" language="javascript" src="js/default/jquery.js"></script>
<link rel="stylesheet" href="js/default/aui-artDialog/css/ui-dialog.css">
<script src="js/default/aui-artDialog/dist/dialog-plus-min.js"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="js/default/html5.js"></script>
<![endif]-->
<script type="text/javascript" language="javascript" src="js/default/jquery.SuperSlide.js"></script>
<script type="text/javascript" language="javascript" src="js/default/jquery.lazyload.min.js"></script>
<link href="css/default/member.css?v=1.1" type="text/css" rel="stylesheet">

	</head>

	<body>
<?php echo $this->load->view('element/topbar_tool', '', TRUE); ?>
		<header class="header clearfix">
			<div class="warp">
				<a href="<?php echo base_url(); ?>" class="logo"><img src="images/default/logo.png" style="width: 160px"></a>
				<div class="chageCity">
					<div class="clickCity">
						<em class="icon"></em><span id="span_city">龙岩</span>
						<a class="tigCity" href="javascript:void(0);" style="color:#c81624">[切换城市]</a>
					</div>
					<div class="tabCityBox">
						<div class="tabCity">
							<div class="hotcity">
								<p>热门城市</p>
							</div>
							<div class="hotcityBox">
								<div class="city clearfix">
									<a title="杭州" href="javascript:void(0);">杭州</a>
									<a title="沈阳" href="javascript:void(0);">沈阳</a>
									<a title="上海" href="javascript:void(0);">上海</a>
									<a title="成都" href="javascript:void(0);">成都</a>
									<a title="武汉" href="javascript:void(0);">武汉</a>
									<a title="深圳" href="javascript:void(0);">深圳</a>
									<a title="济南" href="javascript:void(0);">济南</a>
									<a title="石家庄" href="javascript:void(0);">石家庄</a>
									<a title="哈尔滨" href="javascript:void(0);">哈尔滨</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<ul class="cart_step">
					<li <?php if ($this->uri->segment(1) == 'cart' && (!$this->uri->segment(2) || $this->uri->segment(2) == 'index')) {echo 'class="current"';} ?>>
						<p>我的购物车</p>
						<sub></sub>
						<div class="hr"></div>
					</li>
					<li <?php if ($this->uri->segment(1) == 'cart' && $this->uri->segment(2) == 'confirm') {echo 'class="current"';} ?>>
						<p>填写订单信息</p>
						<sub></sub>
						<div class="hr"></div>
					</li>
					<li <?php if ($this->uri->segment(1) == 'order' && ($this->uri->segment(2) == 'my_pay' || $this->uri->segment(2) == 'my_go_to_pay' || $this->uri->segment(2) == 'my_pay_weixin')) {echo 'class="current"';} ?>>
						<p>确认订单付款</p>
						<sub></sub>
						<div class="hr"></div>
					</li>
					<li <?php if ($this->uri->segment(1) == 'order' && $this->uri->segment(2) == 'pay_result') {echo 'class="current"';} ?>>
						<p>订单提交成功</p>
						<sub></sub>
						<div class="hr"></div>
					</li>
				</ul>

			</div>

		</header>
		<?php echo $content; ?>
<?php echo $this->load->view('element/footer_tool', '', TRUE); ?>
	</body>
</html>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>
<script type="text/javascript">
	$(function() {
		$("img.lazy").lazyload({
			placeholder: "images/default/load.jpg", //加载图片前的占位图片
			effect: "fadeIn" //加载图片使用的效果(淡入)
		});

	});
</script>