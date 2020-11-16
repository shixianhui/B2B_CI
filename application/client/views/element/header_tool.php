<div class="clear"></div>
<header class="header clearfix">
	<div class="warp">
		<a href="<?php echo base_url(); ?>" class="logo"><img src="images/default/logo.png" style="width: 160px"></a>
		<div class="chageCity">
			<div class="clickCity">
				<em class="icon"></em><span id="span_city"><?php echo $this->session->userdata('gloab_city_name'); ?></span>
				<a class="tigCity" href="javascript:void(0);" style="color:#c81624">[切换城市]</a>
			</div>
			<div class="tabCityBox">
				<div class="tabCity">
					<div class="hotcity">
						<p>热门城市</p>
					</div>
					<div class="hotcityBox">
					<?php $site_list = $this->advdbclass->get_site_list(10); ?>
						<div class="city clearfix">
						<?php if ($site_list) { ?>
						<?php foreach ($site_list as $key=>$value) { ?>
							<a title="<?php echo $value['name']; ?>" href="javascript:set_city('<?php echo $value['name']; ?>');"><?php echo $value['name']; ?></a>
						<?php }} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="seach">
		<form method="get" action="<?php echo getBaseUrl($html,'product/index/80.html','product/index/80.html',$client_index);?>" id="product_search">
			<input value="<?php if (isset($search_keyword)) {echo $search_keyword;} ?>" name="search_keyword" type="search" placeholder="请输入关键字搜索">
			<a onclick="javascript:$('#product_search').submit();" href="javascript:void(0);" class="btn">搜索</a>
		</form>
			<div class="keyword">热销特卖：
 <?php $keycode_list = $this->advdbclass->get_keycode_list(); ?>
 <?php if ($keycode_list) { ?>
 <?php foreach ($keycode_list as $key=>$value) { ?>
 <a href="<?php echo getBaseUrl($html,'product/index/80.html','product/index/80.html',$client_index);?>?search_keyword=<?php echo $value['name']; ?>"><?php echo $value['name']; ?></a>
 <?php }} ?>
			</div>
		</div>
		<a href="<?php echo getBaseUrl($html,'seller/my_save_product.html','seller/my_save_product.html',$client_index);?>" class="release_btn">免费发布宝贝</a>
		<div class="top_wechat"><img src="images/default/wechat.png"> 手机逛蚁立
		</div>
	</div>
</header>
<script type="text/javascript">
function set_city(city) {
	$.post("<?php echo base_url(); ?>index.php/user/set_city",
			{	"city": city
			},
			function(res){
				if(res.success){
					window.location.reload();
				}else{
					var d = dialog({
					    title: '提示',
					    fixed: true,
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