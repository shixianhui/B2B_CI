<?php echo $this->load->view("element/header_{$style}_tool", '', TRUE); ?>
<div class="warp">
	<div class="shop-site">
		<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}.html", $client_index); ?>">所有商品</a><span>&gt;</span>
		<?php if ($category_id) { ?>
		<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-0.html", $client_index); ?>"><?php echo $category_name; ?></a><span>&gt;</span>
		<?php } ?>
		<?php if ($category_id_sub) { ?>
		<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}.html", $client_index); ?>"><?php echo $category_name_sub; ?></a><span>&gt;</span>
		<?php } ?>
		<div class="site-seach">
		<form method="get" action="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}.html", $client_index); ?>" id="store_search">
		<input value="<?php if (isset($search_keyword)) {echo $search_keyword;} ?>" name="search_keyword" type="text">
			<a onclick="javascript:$('#store_search').submit();" href="javascript:void(0);" class="btn">搜索</a>
		</form>
		</div>
	</div>
	<?php if ($brand_id || $style_id || $material_id || $price_id) { ?>
	<div class=" condition1 solid">
		<div class="ct fl">已选条件：</div>
		<div class="site fl">
			<ul>
			<?php if ($brand_id) { ?>
				<li>
				<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-0-{$style_id}-{$material_id}-{$price_id}.html", $client_index); ?>">品牌：<span><?php echo $brand_name; ?></span><b class="icon"></b></a>
				</li>
			<?php } ?>
			<?php if ($style_id) { ?>
				<li>
				<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-{$brand_id}-0-{$material_id}-{$price_id}.html", $client_index); ?>">风格：<span><?php echo $style_name; ?></span><b class="icon"></b></a>
				</li>
			<?php } ?>
			<?php if ($material_id) { ?>
				<li>
				<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-{$brand_id}-{$style_id}-0-{$price_id}.html", $client_index); ?>">材质：<span><?php echo $material_name; ?></span><b class="icon"></b></a>
				</li>
			<?php } ?>
			<?php if ($price_id) { ?>
				<li>
				<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-{$brand_id}-{$style_id}-{$material_id}-0.html", $client_index); ?>">价格：<span><?php echo $price_name; ?></span><b class="icon"></b></a>
				</li>
			<?php } ?>
			</ul>
		</div>
	</div>
	<?php } ?>
	<div class="shop-sorf">
	<?php if ($brand_list) { ?>
		<dl><dt>品牌</dt>
			<dd>
			<?php foreach ($brand_list as $key=>$item) { ?>
				<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-{$item['id']}-{$style_id}-{$material_id}-{$price_id}.html", $client_index); ?>"><?php echo $item['brand_name']; ?></a>
			<?php } ?>
			</dd>
		</dl>
	<?php } ?>
	<?php if ($style_list) { ?>
		<dl><dt>风格</dt>
			<dd>
			<?php foreach ($style_list as $key=>$item) { ?>
				<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-{$brand_id}-{$item['id']}-{$material_id}-{$price_id}.html", $client_index); ?>"><?php echo $item['style_name']; ?></a>
			<?php } ?>
			</dd>
		</dl>
	<?php } ?>
	<?php if ($material_list) { ?>
		<dl><dt>材质</dt>
			<dd>
			<?php foreach ($material_list as $key=>$item) { ?>
				<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-{$brand_id}-{$style_id}-{$item['id']}-{$price_id}.html", $client_index); ?>"><?php echo $item['material_name']; ?></a>
			<?php } ?>
			</dd>
		</dl>
	<?php } ?>
		<dl><dt>价格</dt>
			<dd style=" width:845px;">
		   <?php if ($price_arr) { ?>
		   <?php foreach ($price_arr as $key=>$item) { ?>
				<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-{$brand_id}-{$style_id}-{$material_id}-{$key}.html", $client_index); ?>"><?php echo $item[1]; ?></a>
		   <?php }} ?>
			</dd>
		</dl>
	</div>
	<div class="sort-bar mt10">
		<div class="array">
			<ul>
				<li <?php if ($by == 'id') {echo 'class="selected"';} ?>>
					<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-{$brand_id}-{$style_id}-{$material_id}-{$price_id}-id-desc.html", $client_index); ?>" title="综合排序">综合排序</a>
				</li>
				<li <?php if ($by == 'sales') {echo 'class="selected"';} ?>>
					<a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-{$brand_id}-{$style_id}-{$material_id}-{$price_id}-sales-desc.html", $client_index); ?>" title="销量">销量</a>
				</li>
				<li class="price-down">
				    <?php if ($by == 'sell_price') { ?>
				    <?php if (strtolower($order) == 'asc') { ?>
				    <a style="color:#c81624;" href="javascript:void(0);" title="价格从低到高">价格从低到高</a>
				    <?php } else if (strtolower($order) == 'desc') { ?>
				    <a style="color:#c81624;" href="javascript:void(0);" title="价格从高到低">价格从高到低</a>
				    <?php } ?>
				    <?php } else { ?>
				    <a href="javascript:void(0);" title="价格">价格<i></i></a>
				    <?php } ?>
					<ul class="down-menu">
						<li class="down-list"><a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-{$brand_id}-{$style_id}-{$material_id}-{$price_id}-sell_price-asc.html", $client_index); ?>">价格从低到高</a></li>
						<li class="down-list"><a href="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-{$brand_id}-{$style_id}-{$material_id}-{$price_id}-sell_price-desc.html", $client_index); ?>">价格从高到低</a></li>
					</ul>
				</li>
				<li class="sure search_price">
				<form method="get" action="<?php echo getBaseUrl(false, '', "store/product/{$store_id}-{$category_id}-{$category_id_sub}-{$brand_id}-{$style_id}-{$material_id}-0.html", $client_index); ?>" id="store_search_2">
				<input name="start_price" type="text" class="sort-input" placeholder="￥"><span>-</span><input name="end_price" type="text" class="sort-input" placeholder="￥"><em onclick="javascript:$('#store_search_2').submit();" class="sure-btn">确定</em>
				</form>
				</li>
			</ul>
		</div>
		<div class="pagination">
			<ul>
				<Li class="toail">共<strong class="red"><?php echo $paginationCount; ?></strong>件商品 <?php echo $curPage; ?>/<?php echo $pageCount; ?></Li>
				<li>
					<a href="<?php echo getBaseUrl($html, "", "{$template}/product/{$store_id_str}/{$prv_page}.html", $client_index); ?>">‹</a>
				</li>
				<li>
					<a href="<?php echo getBaseUrl($html, "", "{$template}/product/{$store_id_str}/{$next_page}.html", $client_index); ?>">›</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="porduct-item clearfix">
		<ul>
          <?php
               if($item_list){
                   foreach($item_list as $item){
                       $url = getBaseUrl(false,'','product/detail/'.$item['id'].'.html',$client_index);
            ?>
			<Li>
				<div class="picture">
					<a href="<?php echo $url;?>" target="_blank"><img alt="<?php echo clearstring($item['title']);?>" class="lazy" data-original="<?php echo str_replace('.','_thumb.',$item['path']);?>"></a>
				</div>
				<div class="property">
					<p><span class="price"><small>￥</small><?php echo $item['sell_price'];?></span></p>
					<P class="nowrap">
						<a href="<?php echo $url;?>" target="_blank"><?php echo $item['title'];?></a>
					</P>
				</div>
			</Li>
            <?php }}?>
		</ul>
	</div>
	<div class="clear"></div>
	<div class="pagination">
		<ul>
<?php echo $pagination; ?>
		</ul>
	</div>
</div>
<script type="text/javascript">
	jQuery(".shop-Slide").find(function() {
		jQuery(this).find(".prev,.next").stop(true, true).fadeTo("show", 1)
	}, function() {
		jQuery(this).find(".prev,.next").fadeOut()
	});
	jQuery(".shop-Slide").slide({
		titCell: ".hd ul",
		mainCell: ".bd ul",
		effect: "fold",
		autoPlay: true,
		autoPage: true,
		trigger: "click",
		startFun: function(i) {
			var curLi = jQuery(".shop-Slide .bd li").eq(i);
			if(!!curLi.attr("_src")) {
				curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")
			}
		}
	});
</script>