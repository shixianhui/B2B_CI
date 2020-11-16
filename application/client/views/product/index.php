<section class="warp">
	<div class="seat mt10">全部结果 > <?php echo $category_name; ?><?php if ($category_name_sub) {echo ' > '.$category_name_sub;} ?></div>
	<div class="product-filter">
<?php if ($brand_id || $category_id || $style_id || $material_id || $price_id) { ?>
		<div class=" condition1 solid">
			<div class="ct fl">已选条件：</div>
			<div class="site fl">
				<ul>
				<?php if ($brand_id) { ?>
					<li>
						<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-0-{$category_id}-{$category_id_sub}-{$style_id}-{$material_id}-{$price_id}-{$by}-{$order}.html", $client_index); ?>">品牌：<span><?php echo $brand_name; ?></span><b class="icon"></b></a>
					</li>
				<?php } ?>
				<?php if ($category_id) { ?>
					<li>
						<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-0-0-{$style_id}-{$material_id}-{$price_id}-{$by}-{$order}.html", $client_index); ?>">分类：<span><?php echo $category_name; ?><?php if ($category_name_sub) {echo '->'.$category_name_sub;} ?></span><b class="icon"></b></a>
					</li>
				<?php } ?>
				<?php if ($style_id) { ?>
					<li>
						<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$category_id}-{$category_id_sub}-0-{$material_id}-{$price_id}-{$by}-{$order}.html", $client_index); ?>">风格：<span><?php echo $style_name; ?></span><b class="icon"></b></a>
					</li>
				<?php } ?>
				<?php if ($material_id) { ?>
					<li>
						<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$category_id}-{$category_id_sub}-{$style_id}-0-{$price_id}-{$by}-{$order}.html", $client_index); ?>">材质：<span><?php echo $material_name; ?></span><b class="icon"></b></a>
					</li>
				<?php } ?>
				<?php if ($price_id) { ?>
					<li>
						<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$category_id}-{$category_id_sub}-{$style_id}-{$material_id}-0-{$by}-{$order}.html", $client_index); ?>">价格：<span><?php echo $price_name; ?></span><b class="icon"></b></a>
					</li>
				<?php } ?>
				</ul>
			</div>
		</div>
<?php } ?>
		<div class="condition1 solid" style="padding-bottom:17px;">
			<div class="ct fl">品牌：</div>
			<div class="clist fl">
				<ul class="brand_logo">
				<?php if ($brand_list) { ?>
				<?php foreach ($brand_list as $key=>$item) { ?>
					<li>
						<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$item['id']}-{$category_id}-{$category_id_sub}-{$style_id}-{$material_id}-{$price_id}-{$by}-{$order}.html", $client_index); ?>"><img alt="<?php echo clearstring($item['brand_name']); ?>" src="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"></a>
					</li>
				<?php }} ?>
				</ul>
			</div>
			<div class="option1">
				<span class="o-more1"></span>
			</div>
		</div>
        <?php if (!$sub_product_category_list) { ?>
		<div class="condition1 solid">
			<div class="ct fl">分类：</div>
			<div class="clist fl">
				<ul>
					<?php if ($product_category_list) { ?>
					<?php foreach ($product_category_list as $key=>$item) { ?>
					<li>
						<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$item['id']}-0-{$style_id}-{$material_id}-{$price_id}-{$by}-{$order}.html", $client_index); ?>"><?php echo $item['product_category_name']; ?></a>
					</li>
					<?php }} ?>
				</ul>
			</div>
			<div class="option1">
				<span class="o-more1"></span>
			</div>
		</div>
		<?php } ?>
		<?php if ($sub_product_category_list) { ?>
		<div class="condition1 solid">
			<div class="ct fl">分类：</div>
			<div class="clist fl">
				<ul>
					<?php foreach ($sub_product_category_list as $key=>$item) { ?>
					<li>
						<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$category_id}-{$item['id']}-{$style_id}-{$material_id}-{$price_id}-{$by}-{$order}.html", $client_index); ?>"><?php echo $item['product_category_name']; ?></a>
					</li>
					<?php } ?>
				</ul>
			</div>
			<div class="option1">
				<span class="o-more1"></span>
			</div>
		</div>
		<?php } ?>
		<div class="condition1 solid">
			<div class="ct fl">风格：</div>
			<div class="clist fl">
				<ul>
					<?php if ($style_list) { ?>
					<?php foreach ($style_list as $key=>$item) { ?>
					<li>
						<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$category_id}-{$category_id_sub}-{$item['id']}-{$material_id}-{$price_id}-{$by}-{$order}.html", $client_index); ?>"><?php echo $item['style_name']; ?></a>
					</li>
					<?php }} ?>
				</ul>
			</div>
			<div class="option1">
				<span class="o-more1"></span>
			</div>
		</div>
		<div class="condition1 solid">
			<div class="ct fl">材质：</div>
			<div class="clist fl">
				<ul>
					<?php if ($material_list) { ?>
					<?php foreach ($material_list as $key=>$item) { ?>
					<li>
						<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$category_id}-{$category_id_sub}-{$style_id}-{$item['id']}-{$price_id}-{$by}-{$order}.html", $client_index); ?>"><?php echo $item['material_name']; ?></a>
					</li>
					<?php }} ?>
				</ul>
			</div>
			<div class="option1">
				<span class="o-more1"></span>
			</div>
		</div>
		<div class="condition1">
			<div class="ct fl">价格：</div>
			<div class="clist fl">
				<ul>
					<?php if ($price_arr) { ?>
					<?php foreach ($price_arr as $key=>$item) { ?>
					<li style="min-width:70px;width:auto;max-width:140px;">
						<a style="min-width:70px;width: auto;display:block;max-width:140px;" href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$category_id}-{$category_id_sub}-{$style_id}-{$material_id}-{$key}-{$by}-{$order}.html", $client_index); ?>"><?php echo $item[1]; ?></a>
					</li>
					<?php }} ?>
				</ul>
			</div>

		</div>

	</div>
	<div class="clear"></div>
	<div class="sort-bar mt10">
		<div class="array">
			<ul>
				<li <?php if ($by == 'id') {echo 'class="selected"';} ?>>
					<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$category_id}-{$category_id_sub}-{$style_id}-{$material_id}-{$price_id}-id-desc.html", $client_index); ?>" title="综合排序">综合排序</a>
				</li>
				<li <?php if ($by == 'sales') {echo 'class="selected"';} ?>>
					<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$category_id}-{$category_id_sub}-{$style_id}-{$material_id}-{$price_id}-sales-desc.html", $client_index); ?>" title="销量">销量</a>
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
						<li class="down-list"><a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$category_id}-{$category_id_sub}-{$style_id}-{$material_id}-{$price_id}-sell_price-asc.html", $client_index); ?>">价格从低到高</a></li>
						<li class="down-list"><a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$category_id}-{$category_id_sub}-{$style_id}-{$material_id}-{$price_id}-sell_price-desc.html", $client_index); ?>">价格从高到低</a></li>
					</ul>
				</li>
				<li class="sure search_price">
				<form method="get" action="<?php echo getBaseUrl($html, "", "{$template}/index/{$parent_id}-{$brand_id}-{$category_id}-{$category_id_sub}-{$style_id}-{$material_id}-0.html", $client_index); ?>" id="store_search_2">
				<input name="start_price" type="text" class="sort-input" placeholder="￥"><span>-</span><input name="end_price" type="text" class="sort-input" placeholder="￥"><em onclick="javascript:$('#store_search_2').submit();" class="sure-btn">确定</em>
				</form>
				</li>
			</ul>
		</div>
		<div class="pagination">
			<ul>
				<Li class="toail">共<strong class="red"><?php echo $paginationCount; ?></strong>件商品 <?php echo $curPage; ?>/<?php echo $pageCount; ?></Li>
				<li>
					<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$menu_str}/{$prv_page}.html", $client_index); ?>">‹</a>
				</li>
				<li>
					<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$menu_str}/{$next_page}.html", $client_index); ?>">›</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="porduct-item clearfix">
		<ul>
<?php if ($item_list) { ?>
<?php foreach ($item_list as $item) {
	$url = getBaseUrl($html, "", "{$template}/detail/{$item['id']}.html", $client_index);
	$store_url = getBaseUrl($html, "", "store/home/{$item['store_id']}.html", $client_index);
?>
			<Li>
				<div class="picture">
					<a href="<?php echo $url; ?>"><img class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"></a></div>
				<div class="property">
					<p><span class="price"><?php if (!$item['unclear_price']){ ?><small>￥</small><?php echo $item['sell_price'];?></span><?php }else{ echo '面议';} ?></p>
					<P class="nowrap">
						<a href="<?php echo $url; ?>"><?php echo $item['title']; ?></a>
					</P>
					<P class="c6"><a style="color: #666;" href="<?php echo $store_url; ?>" target="_blank"><?php echo $item['store_name']; ?></a></P>
				</div>
			</Li>
<?php }} ?>
		</ul>
	</div>
	<div class="clear"></div>
	<div class="pagination">
		<ul>
		<?php echo $pagination; ?>
		</ul>
	</div>
</section>