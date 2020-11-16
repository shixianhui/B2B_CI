<section class="topbar">
<div class="warp">
<?php if (get_cookie('user_id')) { ?>
<div class="wel">您好<?php if (get_cookie('user_username')) { ?><a style="color: #c81624;" href="<?php echo getBaseUrl($html,'user.html','user.html',$client_index);?>"><?php echo get_cookie('user_username'); ?></a><?php } ?>，欢迎来到蚁立网！<a href="<?php echo getBaseUrl($html,'user/logout.html','user/logout.html',$client_index);?>">退出</a></div>
<?php } else { ?>
<div class="wel">您好，欢迎来到蚁立网！<a href="<?php echo getBaseUrl($html,'user/login.html','user/login.html',$client_index);?>">请登录</a><span>|</span><a href="<?php echo getBaseUrl($html,'user/reg.html','user/reg.html',$client_index);?>">快速注册</a></div>
<?php } ?>
 <div class="smlink">
 <ul>
 <?php if (get_cookie('user_id')) { ?>
 <?php
 $cart_sum = 0;
 if (get_cookie('user_id')) {
 	$cart_sum = $this->advdbclass->getCartSum(get_cookie('user_id'));
 } ?>
  <li><a href="<?php echo getBaseUrl(false,'','cart.html',$client_index);?>" class="p10"><span class="cart_icon icon"></span>购物车(<span id="cart_sum"><?php echo $cart_sum; ?></span>)</a></li>
  <li>|</li>
  <li class="pop-box" id="link1"><a href="<?php echo getBaseUrl(false,'','user.html',$client_index);?>" class="tit">我的蚁立<i class="arrow icon"></i></a>
  <ul class="subnav">
   <Li><a href="<?php echo getBaseUrl(false,'','order/my_order_index/a.html',$client_index);?>">待付款</a></Li>
   <Li><a href="<?php echo getBaseUrl(false,'','order/my_order_index/b.html',$client_index);?>">待发货</a></Li>
   <Li><a href="<?php echo getBaseUrl(false,'','order/my_order_index/c.html',$client_index);?>">待收货</a></Li>
   <Li><a href="<?php echo getBaseUrl(false,'','order/my_order_index/d.html',$client_index);?>">待评价</a></Li>
  </ul>
 </li>
 <?php if (check_store()) { ?>
 <li>|</li>
 <li class="pop-box" id="link2"><a href="<?php echo getBaseUrl($html,'seller.html','seller.html',$client_index);?>" class="tit">商家中心<i class="arrow icon"></i></a>
  <ul class="subnav">
   <Li><a href="<?php echo getBaseUrl(false,'','seller/my_get_order_list.html',$client_index);?>">已卖出的宝贝</a></Li>
   <Li><a href="<?php echo getBaseUrl(false,'','seller/my_get_product_list.html',$client_index);?>">出售中的宝贝</a></Li>
  </ul>
 </li>
 <?php } ?>
 <?php } ?>
 <?php if (!check_store() || !get_cookie('user_id')) { ?>
 <li>|</li>
 <li><a href="<?php echo getBaseUrl(false,'','seller/my_join.html',$client_index);?>" class="p10">实体入驻</a></li>
 <li>|</li>
 <li><a href="<?php echo getBaseUrl(false,'','seller/my_join.html',$client_index);?>" class="p10">电商入驻</a></li>
 <?php } ?>
     <li>|</li>
     <li class="pop-box"><a href="<?php echo getBaseUrl($html, " ", "store/index/2/282.html ", $client_index); ?>" class="tit">招商采购频道<i class="arrow icon"></i></a></li>
<?php
    $headMenuList = $this->advdbclass->getHeadMenu();
    if ($headMenuList) {
	foreach ($headMenuList as $headMenu) {
		if ($headMenu['menu_type'] == '3') {
			$url = $headMenu['url'];
		} else {
			if ($headMenu['menu_type'] == 1 && $headMenu['cover_function']) {
				$url = getBaseUrl($html, "{$headMenu['html_path']}/{$headMenu['cover_function']}{$headMenu['id']}.html", "{$headMenu['template']}/{$headMenu['cover_function']}/{$headMenu['id']}.html", $client_index);
			} else {
				$url = getBaseUrl($html, "{$headMenu['html_path']}/index{$headMenu['id']}.html", "{$headMenu['template']}/index/{$headMenu['id']}.html", $client_index);
			}
		}
	?>
 <li>|</li>
 <li class="pop-box"><a href="<?php echo $url; ?>" class="tit"><?php echo $headMenu['menu_name'] ?><i class="arrow icon"></i></a></li>
<?php }} ?>
 <li>|</li>
 <li class="pop-box" id="link3"><a href="javascript:void(0);" class="tit">联系客服<i class="arrow icon"></i></a>
  <ul class="subnav">
   <Li><a href="<?php echo get_cookie('user_id') ? 'javascript:void(0)' : base_url().getBaseUrl($html, "user/login.html", "user/login.html", $client_index);?>" class="zhiCustomBtn">消费者客服</a></Li>
   <Li><a href="<?php echo get_cookie('user_id') ? 'javascript:void(0)' : base_url().getBaseUrl($html, "user/login.html", "user/login.html", $client_index);?>" class="zhiCustomBtn">商家客服</a></Li>
  </ul>
 </li>
 </ul>
 </div>
</div>
</section>