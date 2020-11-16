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
<link rel="stylesheet" href="js/default/aui-artDialog/css/ui-dialog.css">
<script src="js/default/aui-artDialog/dist/dialog-plus-min.js"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="js/default/html5.js"></script>
<![endif]-->
<script type="text/javascript" language="javascript" src="js/default/jquery.lazyload.min.js"></script>
<script src="js/default/jquery.form.js"></script>
<script src="js/default/formvalid.js?v=1.1" type="text/javascript"></script>
<script src="js/default/index.js?v=1.1" type="text/javascript"></script>
<link href="css/default/member.css?v=1.1" type="text/css" rel="stylesheet">
</head>
<body>
<?php echo $this->load->view('element/topbar_tool', '', TRUE); ?>
<div class="member_head">
 <div class="warp">
  <a href="<?php echo base_url(); ?>" class="logo"><img src="images/default/m_logo.png"></a>
  <ul>
  <Li><a href="<?php echo getBaseUrl($html,'user.html','user.html',$client_index);?>" class="current">会员中心</a></Li>
  <Li><a href="<?php echo getBaseUrl($html,'user/my_message_list.html','user/my_message_list.html',$client_index);?>" >消息</a></Li>
  </ul>
 </div>
</div>
<section class="warp">
 <div class="member_left mt20">
  <div class="member_nav box_shadow">
   <dl><dt>订单中心<em class="icon"></em></dt>
   <dd>
   <a href="<?php echo getBaseUrl($html,'order/my_order_index.html','order/my_order_index.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_order_index' || $this->uri->segment(2)=='my_view') ? 'class="current"' : '';?>>我的订单</a>
   <a href="<?php echo getBaseUrl($html,'user/my_get_exchange_list.html','user/my_get_exchange_list.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_exchange_list') ? 'class="current"' : '';?>>申请退换货</a>
       <a href="<?php echo getBaseUrl($html,'','groupon/my_ptkj_record.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_ptkj_record') ? 'class="current"' : '';?>>我的团预购</a>
   </dd>
   </dl>
   <dl><dt>我的关注<em class="icon"></em></dt>
   <dd>
    <a href="<?php echo getBaseUrl($html,'user/my_favorite_store_list.html','user/my_favorite_store_list.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_favorite_store_list') ? 'class="current"' : '';?>>收藏店铺</a>
    <a href="<?php echo getBaseUrl($html,'user/my_get_favorite_list.html','user/my_get_favorite_list.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_favorite_list') ? 'class="current"' : '';?>>收藏产品</a>
    <a href="<?php echo getBaseUrl($html,'user/my_get_comment_list.html','user/my_get_comment_list.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_comment_list') ? 'class="current"' : '';?>>评价产品</a>
   </dd>
   </dl>
   <dl><dt>我的资产<em class="icon"></em></dt>
   <dd>
   <a href="<?php echo getBaseUrl($html,'user/my_financial_list.html','user/my_financial_list.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_financial_list') ? 'class="current"' : '';?>>我的财务</a>
   <a href="<?php echo getBaseUrl($html,'user/my_score_list.html','user/my_score_list.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_score_list') ? 'class="current"' : '';?>>我的积分</a>
   <a href="<?php echo getBaseUrl($html,'user/my_coupon_list.html','user/my_coupon_list.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_coupon_list') ? 'class="current"' : '';?>>我的优惠券</a>
   </dd>
   </dl>
   <dl><dt>账号中心<em class="icon"></em></dt>
   <dd>
   <a href="<?php echo getBaseUrl($html,'user/my_change_user_info.html','user/my_change_user_info.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_change_user_info') ? 'class="current"' : '';?>>资料信息</a>
   <a href="<?php echo getBaseUrl($html,'user/my_get_user_address.html','user/my_get_user_address.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_get_user_address' || $this->uri->segment(2)=='my_save_address') ? 'class="current"' : '';?>>收货地址</a>
   <a href="<?php echo getBaseUrl($html,'user/my_change_pass.html','user/my_change_pass.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_change_pass') ? 'class="current"' : '';?>>修改登录密码</a>
   <a href="<?php echo getBaseUrl($html,'user/my_change_pay_pass.html','user/my_change_pay_pass.html',$client_index);?>" <?php echo ($this->uri->segment(2)=='my_change_pay_pass') ? 'class="current"' : '';?>>修改支付密码</a>
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
<script>
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
</script>

<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });



    });
</script>