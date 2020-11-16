<!DOCTYPE html>
<html >
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
    <script type="text/javascript" src="js/default/lhgcalendar.min.js"></script>
<link rel="stylesheet" href="js/default/aui-artDialog/css/ui-dialog.css">
<script src="js/default/aui-artDialog/dist/dialog-plus-min.js"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="js/default/html5.js"></script>
<![endif]-->
<script type="text/javascript" language="javascript" src="js/default/jquery.SuperSlide.js"></script>
<script type="text/javascript" language="javascript" src="js/default/jquery.lazyload.min.js"></script>
<script src="js/default/jquery.form.js"></script>
<script src="js/default/formvalid.js?v=1.1" type="text/javascript"></script>
<script src="js/default/index.js?v=1.1" type="text/javascript"></script>
<link href="css/default/member.css?v=1.1" type="text/css" rel="stylesheet">
</head>
<body>
<?php echo $this->load->view('element/topbar_tool', '', TRUE); ?>
<header class="header clearfix b_header">
<div class="warp">
 <a href="<?php echo base_url(); ?>" class="logo"><img src="images/default/logo.png" style="width: 160px"></a>
 <div class="name">商家中心</div>
</div>
<div class="clear"></div>
<div class="b_head_menu">
<ul>
 <Li><a href="<?php echo getBaseUrl(false,'','seller.html',$client_index);?>" class="current">商家中心</a></Li>
<Li><a href="<?php echo getBaseUrl(false,'','page/index/292.html',$client_index);?>" target="_blank">入驻规则</a></Li>
<Li><a href="<?php echo getBaseUrl(false,'','page/index/293.html',$client_index);?>" target="_blank">安全中心</a></Li>
</ul>
</div>
</header>
<section class="warp">
 <div class="member_left mt20">
  <div class="member_nav box_shadow">
   <dl><dt>店铺管理<em class="icon icon_arrow"></em></dt>
   <dd>
   <?php if (!check_store(get_cookie('user_id'))) { ?>
   <a href="<?php echo getBaseUrl($html,"{$template}/my_join.html","{$template}/my_join.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_join') ? 'class="current"' : '';?>>我要入驻</a>
   <?php } else { ?>
   <a href="<?php echo getBaseUrl($html,"{$template}/index.html","{$template}/index.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='index' || !$this->uri->segment(2)) ? 'class="current"' : '';?>>我的店铺</a>
   <?php } ?>
   <!--<a href="<?php echo getBaseUrl($html,"{$template}/my_get_ad_list.html","{$template}/my_get_ad_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_ad_list') ? 'class="current"' : '';?>>首页装修</a>-->
   <a href="<?php echo getBaseUrl($html,"{$template}/my_set_theme.html","{$template}/my_set_theme.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_set_theme') ? 'class="current"' : '';?>>店铺装修</a>
   <a href="<?php echo getBaseUrl($html,"{$template}/my_get_nav_list.html","{$template}/my_get_nav_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_nav_list' || $this->uri->segment(2)=='my_save_nav') ? 'class="current"' : '';?>>导航设置</a>
   </dd>
   </dl>
   <dl><dt>交易管理<em class="icon icon_arrow"></em></dt>
   <dd>
   <a href="<?php echo getBaseUrl($html,"{$template}/my_get_order_list.html","{$template}/my_get_order_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_order_list') ? 'class="current"' : '';?>>已卖出的宝贝</a>
   <a href="<?php echo getBaseUrl($html,"{$template}/my_get_comment_list.html","{$template}/my_get_comment_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_comment_list') ? 'class="current"' : '';?>>评价管理</a>
   <a href="<?php echo getBaseUrl($html,"{$template}/my_get_exchange_list.html","{$template}/my_get_exchange_list/1.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_exchange_list') ? 'class="current"' : '';?>">退换货管理</a>
   </dd>
   </dl>

   <dl><dt>商品管理<em class="icon icon_arrow"></em></dt>
   <dd>
    <a href="<?php echo getBaseUrl($html,"{$template}/my_save_product.html","{$template}/my_save_product.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_save_product') ? 'class="current"' : '';?>>发布商品</a>
    <a href="<?php echo getBaseUrl($html,"{$template}/my_get_product_list.html","{$template}/my_get_product_list/1.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_product_list') ? 'class="current"' : '';?>>商品列表</a>
    <a href="<?php echo getBaseUrl($html,"{$template}/my_get_product_category_list.html","{$template}/my_get_product_category_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_product_category_list' || $this->uri->segment(2)=='my_save_product_category') ? 'class="current"' : '';?>>分类设置</a>
    <a href="<?php echo getBaseUrl($html,"{$template}/my_get_brand_list.html","{$template}/my_get_brand_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_brand_list' || $this->uri->segment(2)=='my_save_brand') ? 'class="current"' : '';?>>品牌设置</a>
    <a href="<?php echo getBaseUrl($html,"{$template}/my_get_brand_list.html","{$template}/my_get_style_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_style_list' || $this->uri->segment(2)=='my_save_style') ? 'class="current"' : '';?>>风格设置</a>
    <a href="<?php echo getBaseUrl($html,"{$template}/my_get_brand_list.html","{$template}/my_get_material_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_material_list' || $this->uri->segment(2)=='my_save_material') ? 'class="current"' : '';?>>材质设置</a>
    <a href="<?php echo getBaseUrl($html,"{$template}/my_get_brand_list.html","{$template}/my_get_fabric_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_fabric_list' || $this->uri->segment(2)=='my_save_fabric') ? 'class="current"' : '';?>>面料设置</a>
    <a href="<?php echo getBaseUrl($html,"{$template}/my_get_brand_list.html","{$template}/my_get_leather_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_leather_list' || $this->uri->segment(2)=='my_save_leather') ? 'class="current"' : '';?>>皮革设置</a>
    <a href="<?php echo getBaseUrl($html,"{$template}/my_get_brand_list.html","{$template}/my_get_filler_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_filler_list' || $this->uri->segment(2)=='my_save_filler') ? 'class="current"' : '';?>>填充物设置</a>
   </dd>
   </dl>
      <dl><dt>营销活动管理<em class="icon icon_arrow"></em></dt>
          <dd>
              <a href="<?php echo getBaseUrl($html,"{$template}/promotion_ptkj_list.html","{$template}/promotion_ptkj_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='promotion_ptkj_list') ? 'class="current"' : '';?>>团预购活动管理</a>
          </dd>
      </dl>
   <dl><dt><a href="<?php echo getBaseUrl($html,"{$template}/my_get_postage_way_list.html","{$template}/my_get_postage_way_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_postage_way_list' || $this->uri->segment(2)=='my_save_postage_way') ? 'class="current"' : '';?>>物流管理<em class="icon icon_arrow"></em></a></dt></dl>

      <dl><dt>子账号管理<em class="icon icon_arrow"></em></dt>
          <dd>
              <a href="<?php echo getBaseUrl($html,"{$template}/my_seller_group_list.html","{$template}/my_seller_group_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_seller_group_list') ? 'class="current"' : '';?>>部门设置</a>
              <a href="<?php echo getBaseUrl($html,"{$template}/my_get_seller_list.html","{$template}/my_get_seller_list.html",$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_seller_list') ? 'class="current"' : '';?>>账号管理</a>

          </dd>
      </dl>
  </div>
 </div>
 <?php echo $content; ?>
</section>
<div class="clear"></div>
<footer class="mt20">
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
<script type="text/javascript">
(function(a){
	a.fn.hoverClass=function(b){
		var a=this;
		a.each(function(c){
			a.eq(c).hover(function(){
				$(this).addClass(b)
			},function(){
				$(this).removeClass(b)
			})
		});
		return a
	};
})(jQuery);

$(function(){
	$("#link1").hoverClass("current");
	$("#link2").hoverClass("current");
	$("#link3").hoverClass("current");
	$("#link4").hoverClass("current");
	$("#activity").hoverClass("current");
});

$(function () {
   $("img.lazy").lazyload({
      placeholder: "images/default/load.jpg", //加载图片前的占位图片
      effect: "fadeIn" //加载图片使用的效果(淡入)
   });
});

jQuery(".b_title").slide({trigger:"click"});
    </script>