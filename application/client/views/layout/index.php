<!DOCTYPE html>
<html >
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<base href="<?php echo base_url(); ?>" />
<meta name="title" content="<?php echo clearstring($title); ?>" />
<meta name="keywords" content="<?php echo clearstring($keywords); ?>" />
<meta name="description" content="<?php echo clearstring($description); ?>" />
<link href="css/default/rest.css?v=1.1" type="text/css" rel="stylesheet">
<link href="css/default/base.css?v=1.1" type="text/css" rel="stylesheet">
<script type="text/javascript" language="javascript" src="js/default/jquery.js"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="js/default/html5.js"></script>
<![endif]-->
<script type="text/javascript" language="javascript" src="js/default/jquery.SuperSlide.js"></script>
<script type="text/javascript" language="javascript" src="js/default/jquery.lazyload.min.js"></script>
<script type="text/javascript" language="javascript" src="js/default/FixedTop.js"></script>
</head>
<body>
<?php echo $this->load->view('element/topbar_tool', '', TRUE); ?>
<?php $adList = $this->advdbclass->getAd(3, 1);
if ($adList) { ?>
<div class="topad">
<?php foreach ($adList as $ad) { ?>
<a href="<?php echo $ad['url']; ?>" target="_blank" style="background:url(<?php echo $ad['path']; ?>) no-repeat center"></a>
<span style="cursor: pointer;" onclick="javascript:colose_ad();" id="close">×</span>
<?php } ?>
</div>
<?php } ?>
<?php echo $this->load->view('element/header_tool', '', TRUE); ?>
<?php echo $this->load->view('element/menu_left_tool', '', TRUE); ?>
<?php echo $content; ?>
<?php echo $this->load->view('element/footer_tool', '', TRUE); ?>
  <div class="fsFixedTopContent" >
  <div class="fsFixedTop" >
  	<a class="smooth active" href="javascript:;"> <b class="fs">1F</b> <em class="fs-name">钻石</em> <i class="fs-line"></i> </a>
    <a class="smooth" href="javascript:;"> <b class="fs">2F</b> <em class="fs-name">实体</em> <i class="fs-line"></i> </a>
    <a class="smooth" href="javascript:;"> <b class="fs">3F</b> <em class="fs-name">定制</em> <i class="fs-line"></i> </a>
    <a class="smooth" href="javascript:;"> <b class="fs">4F</b> <em class="fs-name">欧式</em> <i class="fs-line"></i> </a>
    <a class="smooth" href="javascript:;"> <b class="fs">5F</b> <em class="fs-name">美式</em> <i class="fs-line"></i> </a>
    <a class="smooth" href="javascript:;"> <b class="fs">6F</b> <em class="fs-name">中式</em> <i class="fs-line"></i> </a>
    <a class="smooth" href="javascript:;"> <b class="fs">7F</b> <em class="fs-name">红木</em> <i class="fs-line"></i> </a>
    <a class="smooth" href="javascript:;"> <b class="fs">8F</b> <em class="fs-name">现代</em> <i class="fs-line"></i> </a>
    <a class="smooth" href="javascript:;"> <b class="fs">9F</b> <em class="fs-name">儿童</em> <i class="fs-line"></i> </a>
    <a class="smooth" href="javascript:;"> <b class="fs">10F</b> <em class="fs-name">办公</em></a>
  </div>
</div>


</body>
</html>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>
<script type="text/javascript">
        $(function () {
            $("img.lazy").lazyload({
                placeholder: "images/default/load.jpg", //加载图片前的占位图片
                effect: "fadeIn" //加载图片使用的效果(淡入)
            });



        });
    </script>