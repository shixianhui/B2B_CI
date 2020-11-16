<div class="fullSlide">
<div class="bd">
<ul>
<li _src="url(images/default/banner.png)" style="background:center 0 no-repeat;"><a target="_blank" href="#"></a></li>
<li _src="url(images/default/banner.png)" style="background:center 0 no-repeat;"><a target="_blank" href="#"></a></li>
</ul>
</div>
<div class="hd"><ul></ul></div>
<span class="prev"></span><span class="next"></span>	</div>
<section class="business_introduction">
 <div class="hd">
  <ul>
  <Li>跨境仓储服务</Li>
  <Li>跨境物流服务</Li>
  <Li>跨境购电商服务</Li>
  <Li>全球华人代购服务</Li>
  <Li>一站式管家服务</Li>
  </ul>
 </div>
 <div class="bd">
  <div class="intr_cont clearfix">
  <div class="txt"><P>佳成国际拥有完善的跨境物流运营资质，包括：国家邮政总局颁发的国内、国际快递许可证；海关总署颁发的货物代理报关资格证、快递代理报关资格证；商检总局颁发的代理报检资格证；国内、国际航空代理资格证CATA、IATA；道路运输许可证。</P>
   <a href="" class="btn">了解详情</a>
  </div>
   <div class="picture"><img src="images/default/image3.png"></div>
  </div>
  <div class="intr_cont clearfix">
  <div class="txt"><P>佳成国际拥有完善的跨境物流运营资质，包括：国家邮政总局颁发的国内、国际快递许可证；海关总署颁发的货物代理报关资格证、快递代理报关资格证；商检总局颁发的代理报检资格证；国内、国际航空代理资格证CATA、IATA；道路运输许可证。</P>
   <a href="" class="btn">了解详情</a>
  </div>
   <div class="picture"><img src="images/default/image3.png"></div>
  </div>
  <div class="intr_cont clearfix">
  <div class="txt"><P>佳成国际拥有完善的跨境物流运营资质，包括：国家邮政总局颁发的国内、国际快递许可证；海关总署颁发的货物代理报关资格证、快递代理报关资格证；商检总局颁发的代理报检资格证；国内、国际航空代理资格证CATA、IATA；道路运输许可证。</P>
   <a href="" class="btn">了解详情</a>
  </div>
   <div class="picture"><img src="images/default/image3.png"></div>
  </div>
  <div class="intr_cont clearfix">
  <div class="txt"><P>佳成国际拥有完善的跨境物流运营资质，包括：国家邮政总局颁发的国内、国际快递许可证；海关总署颁发的货物代理报关资格证、快递代理报关资格证；商检总局颁发的代理报检资格证；国内、国际航空代理资格证CATA、IATA；道路运输许可证。</P>
   <a href="" class="btn">了解详情</a>
  </div>
   <div class="picture"><img src="images/default/image3.png"></div>
  </div>
  <div class="intr_cont clearfix">
  5555
  </div>

 </div>
</section>
<div class="clear"></div>
<section class="home_product">
 <div class="hd">
 <ul>
 <Li>热选商品</Li>
 <span>/</span>
  <Li>新品上市</Li>
 </ul>
 <a href="<?php echo getBaseUrl($html, "", "product/index/80.html", $client_index) ?>" class="more">更多</a>
 </div>
 <div class="bd">
  <div class="product_item clearfix">
  <ul class="clearfix">
 <?php
            $cus_list = $this->advdbclass->get_cus_product_list('c', 8);
            if ($cus_list) {
            	foreach ($cus_list as $item) {
				$url = getBaseUrl($html, "", "product/detail/{$item['id']}.html", $client_index);
?>
 <Li>
 <div class="picture"><a href="<?php echo $url; ?>" target="_blank"><img alt="<?php echo clearstring($item['title']); ?>" class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"></a></div>
<div class="txt">
<P class="introduce nowrap"><a href="<?php echo $url; ?>" class="t-c" ><?php echo $item['title']; ?></a></P>
<p class="price"><strong><small>¥</small><?php echo $item['sell_price']; ?></strong><s>¥<?php echo $item['market_price']; ?></s></p>
</div>
 </Li>
<?php }} ?>
 </ul>
  </div>
   <div class="product_item clearfix">
  <ul class="clearfix">
  <?php
            $cus_list = $this->advdbclass->get_cus_product_list('', 8);
            if ($cus_list) {
            	foreach ($cus_list as $item) {
				$url = getBaseUrl($html, "", "product/detail/{$item['id']}.html", $client_index);
?>
 <Li>
 <div class="picture"><a href="<?php echo $url; ?>" target="_blank"><img alt="<?php echo clearstring($item['title']); ?>" class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"></a></div>
<div class="txt">
<P class="introduce nowrap"><a href="<?php echo $url; ?>" class="t-c"><?php echo $item['title']; ?></a></P>
<p class="price"><strong><small>¥</small><?php echo $item['sell_price']; ?></strong><s>¥<?php echo $item['market_price']; ?></s></p>
</div>
 </Li>
 <?php }} ?>
 </ul>
  </div>
 </div>
</section>

<section class="business_brand">
 <div class="hd">
 <ul>
 <Li><span>入驻</span>商家</Li>
  <Li><span>海购</span>品牌</Li>
 </ul>
 <a href="" class="more">更多</a>
 </div>
 <div class="bd">
  <div class="brand_item">
  <ul>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  </ul>
  </div>
  <div class="brand_item">
  <ul>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  <Li><a href=""><img src="images/default/image2.png"></a></Li>
  </ul>
  </div>
 </div>
</section>
<div class="clear"></div>