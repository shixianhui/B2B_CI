<style type="text/css">
	.menu>li{position: static !important;}
	.menu>li.hover .second-level-menu{display:block;}
	.menu .second-level-menu{position:absolute;left:210px;background:rgba(73, 74, 69, 0.9); top:0;display:none;width:440px;height: 470px}
	.menu .second-level-menu-list{display:flex;padding:15px;}
	.menu .second-level-menu-list:last-of-type{border-bottom:none;}
	.menu .second-level-menu-list h3{font-size:20px;width:30%;}
	.menu .second-level-menu-list ul{width:70%;float:right;border-bottom:1px dashed #fff;padding-bottom: 20px}
	.menu .second-level-menu-list li{display:inline-block;width:auto;margin-right:15px;height:2em;line-height:2em;}
	.menu .second-level-menu-list li a{font-size:15px;color:#eee;display:block;}
	.menu .second-level-menu-list li a:hover{color:#c81624;}
</style>
<div class="menu">
	<nav class="nav">
		<div class="all-category">
			<div class="title">
				<a href="javascript:void(0);">主题市场分类</a>
			</div>
			<div class="category" <?php if ($this->uri->segment(1) == 'main' || !$this->uri->segment(1)) { ?> style="display:block"<?php } ?>>
				<ul class="menu" style="height: auto;min-height: 470px">
<!--				<li cat_id="1">-->
<!--						<div class="class">-->
<!--							<a href="--><?php //echo getBaseUrl(false, "", "store/index/282/1.html", $client_index); ?><!--"><i class="menu_1"></i>本地实体商家</a>-->
<!--						</div>-->
<!---->
<!--					</li>-->
				<?php $product_category_list = $this->advdbclass->get_product_category_list(0);
                if ($product_category_list) {
                    foreach ($product_category_list as $key => $item) {
				?>
					<li cat_id="<?php echo $item['id']; ?>">
						<div class="class">
							<a href="<?php echo getBaseUrl(false, "", "product/index/80-0-{$item['id']}-0-0-0-0.html", $client_index); ?>"><i class="menu_<?php echo $key+2; ?>"></i><?php echo $item['product_category_name']; ?></a>
						</div>
                        <?php if ($item['subMenuList']) { ?>
                        <div class="second-level-menu">

                            <div class="second-level-menu-list">
                                <h3><?php echo $item['product_category_name']; ?></h3>
                                <ul>
                                    <?php foreach ($item['subMenuList'] as $sub_key => $sub_value){ ?>
                                    <li><a href="<?php echo getBaseUrl(false, "", "product/index/80-0-{$item['id']}-{$sub_value['id']}-0-0-0.html", $client_index); ?>"><?php echo $sub_value['product_category_name']; ?></a></li>
                                <?php } ?>
                                </ul>
                            </div>
                            <?php $product_style_list = $this->advdbclass->get_style_list();
                            if ($product_style_list) { ?>

                            <div class="second-level-menu-list">
                                <h3>推荐风格</h3>
                                <ul>
                                    <?php foreach ($product_style_list as $value) {
                                        ?>
                                        <li><a href="<?php echo getBaseUrl(false, "", "product/index/80-0-0-0-{$value['id']}-0-0.html", $client_index); ?>"><?php echo $value['style_name']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                                <?php } ?>

                        </div>
                            <?php } ?>
					</li>
				<?php }} ?>
				</ul>
			</div>
		</div>
		<ul class="site-menu">
		    <li>
				<a href="<?php echo getBaseUrl($html, " ", "store/index/1/282.html ", $client_index); ?>" <?php if ($this->uri->segment(3) == 1) {echo 'class="current"';} ?>>本地实体商家</a>
			</li>
			<li>
				<a href="<?php echo getBaseUrl($html, " ", "store/index/2/282.html ", $client_index); ?>" <?php if ($this->uri->segment(3) == 2) {echo 'class="current"';} ?>>招商采购频道</a>
			</li>
			<li class="activity" id="activity">
				<a href="javascript:void(0);" class="tit">城市搜索</a>
				<div class="subnav">
					<div class="hot-city">
						<span>热门城市入口</span>
						<?php $site_list = $this->advdbclass->get_site_list(10); ?>
						<?php if ($site_list) { ?>
						<?php foreach ($site_list as $key=>$value) { ?>
						<a onclick="javascript:set_city('<?php echo $value['name']; ?>');" href="javascript:void(0);"><?php echo $value['name']; ?></a>
						<?php }} ?>
					</div>
					<div class="hot-city" style="padding-bottom:5px;">
						<span>按照省份选择</span>
						<dl class="select mt10">
							<dt>请选择省份</dt>
							<dd>
								<div class="select-txt">
                                    <?php if ($area_list){
                                        foreach ($area_list as $key=>$value){ ?>
									<P>
										<a href="javascript:void(0);" onclick="get_city(<?php echo $value['id']; ?>)"><?php echo $value['name']; ?></a>
									</P>
                                    <?php }} ?>
								</div>
							</dd>
						</dl>
						<dl class="select mt10 ml15">
							<dt>请选择城市</dt>
							<dd>
								<div class="select-txt" id="city_select">
<!--									<P>-->
<!--										<a onclick="$('#city_name').val()">杭州</a>-->
<!--									</P>-->
								</div>
							</dd>
                            <input type="hidden" id="city_name">
						</dl>
						<button type="button" class="btn mt10 ml15" onclick="set_city($('#city_name').val());">确定</button>
						<input type="text" class="input-txt fl mt10" placeholder="城市名、拼音、区号"><button type="button" class="btn mt10 ml15">进入城市</button>
					</div>
					<ul class="city-ad">
<?php $adList = $this->advdbclass->getAd(4, 10);
if ($adList) {
foreach ($adList as $key=>$value) {
	?>

						<li>
							<a href="<?php echo $value['url']; ?>" target="_blank"><img alt="<?php echo clearstring($value['ad_text']); ?>" src="<?php echo $value['path']; ?>"></a>
						</li>
<?php }} ?>
					</ul>
				</div>
			</li>
			<li>
				<a href="<?php echo getBaseUrl($html, " ", "live/index/281.html ", $client_index); ?>" <?php if ($this->uri->segment(1) == 'live') {echo 'class="current"';} ?>>购物直播<i class="icon live_icon"></i></a>
			</li>
            <li>
                <a href="<?php echo getBaseUrl($html, " ", "edu_tourism/index.html ", $client_index); ?>" <?php if ($this->uri->segment(1) == 'edu_tourism') {echo 'class="current"';} ?>>教育旅游平台</a>
            </li>
		</ul>
		<div class="txtScroll-top">
			<div class="bd">
				<ul class="infoList">
<?php
            $cus_list = $this->advdbclass->get_cus_list('page', 173, '', 0, 5);
            if ($cus_list) {
            	foreach ($cus_list as $item) {
				$url = getBaseUrl($html, "{$item['html_path']}/{$item['id']}.html", "page/index/{$item['category_id']}/{$item['id']}.html", $client_index);
			?>
					<li><span class="date">【<?php echo $item['menu_name']; ?>】</span>
						<a href="<?php echo $url; ?>" target="_blank"><?php echo $item['title']; ?></a>
					</li>
<?php }} ?>

				</ul>
			</div>
		</div>
	</nav>
</div>
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

function get_city(cur_id) {
    $.post("<?php echo base_url(); ?>index.php/cart/get_city",
        {	"parent_id": cur_id
        },
        function(res){
            if(res.success){
                var html = '';
                for (var i = 0, data = res.data, len = data.length; i < len; i++){
                    html += '<P><a href="javascript:void(0);" onclick="select_city(this)">'+data[i]['name']+'</a></P>';
                }
                $("#city_select").html(html);
                return false;
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

function select_city(obj) {
    var city = $(obj).html();
    $(obj).parents('dl').find('dt').html(''+city+'');
    $('#city_name').val(''+city+'');
}
</script>