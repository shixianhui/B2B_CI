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
<!--[if lt IE 9]>
<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
<script type="text/javascript" language="javascript" src="js/default/jquery.SuperSlide.js"></script>
<script type="text/javascript" language="javascript" src="js/default/jquery.lazyload.min.js"></script>
<link href="css/default/<?php echo $style; ?>/shop.css?v=1.1" type="text/css" rel="stylesheet">
</head>
	<body class="shop-bg">
<?php echo $this->load->view('element/topbar_tool', '', TRUE); ?>
<?php echo $this->load->view('element/header_tool', '', TRUE); ?>
		<?php echo $content; ?>
<div class="clear"></div>
<footer class="mt20">
	<div class="cti clearfix" style="border-bottom:none;">
		<dl><dt class="c_ico1"></dt>
			<dd>正品保证 优质服务</dd>
		</dl>
		<dl><dt class="c_ico2"></dt>
			<dd>多仓直发 快速配送</dd>
		</dl>
		<dl><dt class="c_ico3"></dt>
			<dd>品质护航 轻松购物</dd>
		</dl>
		<dl><dt class="c_ico4"></dt>
			<dd>天天低价 畅选无忧</dd>
		</dl>
	</div>
	<div class="clear"></div>
	<div class="copyright">
<P>
<a href="<?php echo base_url(); ?>">首页</a>
<?php
    $footerMenuList = $this->advdbclass->getFooterMenu();
    if ($footerMenuList) {
	foreach ($footerMenuList as $footerMenu) {
		if ($footerMenu['menu_type'] == '3') {
    		$url = $footerMenu['url'];
    	} else {
    		$url = getBaseUrl($html, $footerMenu['html_path'], "{$footerMenu['template']}/index/{$footerMenu['id']}.html", $client_index);
        }
	?>
|<a href="<?php echo $url; ?>"><?php echo $footerMenu['menu_name'] ?></a>
<?php }} ?>
</P>
<P><?php echo $site_copyright; ?><?php echo $icp_code; ?></P>
	</div>
</footer>
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

    //收藏
    function save_favorite(type, product_id) {
        $.post(base_url+"index.php/product/save_favorite",
            {	"item_id": product_id,
                "type": type
            },
            function(res){
                if(res.success){
                    if (type == 'product') {
                        if (res.data.action == 'add') {
                            $('#fav_product_btn_span').html('取消收藏');
                        } else if (res.data.action == 'delete') {
                            $('#fav_product_btn_span').html('收藏');
                        }
                    } else if (type == 'store') {
                        if (res.data.action == 'add') {
                            $('#fav_store_btn_span').html('取消收藏');
                        } else if (res.data.action == 'delete') {
                            $('#fav_store_btn_span').html('收藏店铺');
                        }
                    }
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
