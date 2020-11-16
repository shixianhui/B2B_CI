<section class="warp">
	<div class="w920 fl">
		<div class="filter mt20">
		<?php if ($style_id || $store_category_id || $market_id || $brand_id) { ?>
			<div class="condition dashed">
				<div class="ct fl">已选条件：</div>
				<div class="site fl">
					<ul>
                        <?php if ($brand_id) { ?>
                            <li>
                                <a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$auth_type}/{$parent_id}-{$style_id}-{$store_category_id}-{$market_id}-0.html", $client_index); ?>">品牌：<span><?php echo $brand_name; ?></span><b class="icon"></b></a>
                            </li>
                        <?php } ?>
					<?php if ($style_id) { ?>
						<li>
							<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$auth_type}/{$parent_id}-0-{$store_category_id}-{$market_id}-{$brand_id}.html", $client_index); ?>">风格：<span><?php echo $style_name; ?></span><b class="icon"></b></a>
						</li>
					<?php } ?>
					<?php if ($store_category_id) { ?>
						<li>
							<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$auth_type}/{$parent_id}-{$style_id}-0-{$market_id}-{$brand_id}.html", $client_index); ?>">分类：<span><?php echo $store_category_name; ?></span><b class="icon"></b></a>
						</li>
					<?php } ?>
					<?php if ($market_id) { ?>
						<li>
							<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$auth_type}/{$parent_id}-{$style_id}-{$store_category_id}-0-{$brand_id}.html", $client_index); ?>">商场：<span><?php echo $market_name; ?></span><b class="icon"></b></a>
						</li>
					<?php } ?>
					</ul>
				</div>
			</div>
			<?php } ?>

            <div class="condition dashed">
                <div class="ct fl">品牌：</div>
                <div class="clist fl">
                    <ul>
                        <?php if ($brand_list) { ?>
                            <?php foreach ($brand_list as $key=>$item) { ?>
                                <li>
                                    <a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$auth_type}/{$parent_id}-{$style_id}-{$store_category_id}-{$market_id}-{$item['id']}.html", $client_index); ?>"><?php echo $item['brand_name']; ?></a>
                                </li>
                            <?php }} ?>
                    </ul>
                </div>
                <div class="option">
                    <span class="o-more"></span>
                </div>
            </div>

			<div class="condition dashed">
				<div class="ct fl">风格：</div>
				<div class="clist fl">
					<ul>
						<?php if ($style_list) { ?>
						<?php foreach ($style_list as $key=>$item) { ?>
						<li>
							<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$auth_type}/{$parent_id}-{$item['id']}-{$store_category_id}-{$market_id}-{$brand_id}.html", $client_index); ?>"><?php echo $item['style_name']; ?></a>
						</li>
						<?php }} ?>
					</ul>
				</div>
				<div class="option">
					<span class="o-more"></span>
				</div>
			</div>

			<div class="condition dashed" style="display: none">
				<div class="ct fl">分类：</div>
				<div class="clist fl">
					<ul>
						<?php if ($store_category_list) { ?>
						<?php foreach ($store_category_list as $key=>$item) { ?>
						<li>
							<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$auth_type}/{$parent_id}-{$style_id}-{$item['id']}-{$market_id}-{$brand_id}.html", $client_index); ?>"><?php echo $item['store_category_name']; ?></a>
						</li>
						<?php }} ?>
					</ul>
				</div>
				<div class="option">
					<span class="o-more"></span>
				</div>
			</div>
			<div class="condition" style="padding-bottom:17px;">
				<div class="ct fl">商场：</div>
				<div class="clist fl">
					<ul class="brand_logo">
					<?php if ($market_list) { ?>
					<?php foreach ($market_list as $key=>$item) { ?>
						<li>
							<a href="<?php echo getBaseUrl($html, "", "{$template}/index/{$auth_type}/{$parent_id}-{$style_id}-{$store_category_id}-{$item['id']}-{$brand_id}.html", $client_index); ?>"><img src="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"></a>
						</li>
					<?php }} ?>
					</ul>
				</div>
				<div class="option">
					<span class="o-more"></span>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<div class="business-list" id="content">
		<?php if ($market_info) {
			$url = getBaseUrl($html, "", "market/index/{$market_info['id']}.html", $client_index);
			?>
		<dl><dt><a href="<?php echo $url; ?>"><img alt="<?php if ($market_info) { echo clearstring($market_info['title']);} ?>" width="138px" height="138px" src="<?php if ($market_info) { echo $market_info['path'];} ?>" ></a></dt>
				<dd>
					<h5><a href="<?php echo $url; ?>"><?php if ($market_info) { echo $market_info['title'];} ?></a></h5>
					<p>商场介绍：<?php if ($market_info) {echo my_substr($market_info['introduce'], 80);}  ?></p>
					<P class="mt15">
						<a href="<?php echo $url; ?>" class="btn o-btn">进入商场</a>
					</P>
				</dd>
			</dl>
		<?php } ?>
<?php if ($item_list) { ?>
<?php foreach ($item_list as $item) {
	$url = getBaseUrl($html, "", "{$template}/home/{$item['id']}.html", $client_index);
?>
			<dl class="clearfix"><dt><a href="<?php echo $url; ?>"><img alt="<?php echo clearstring($item['store_name']); ?>" width="138px" height="138px" src="images/default/load.jpg" class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"></a></dt>
				<dd>
					<h5><a href="<?php echo $url; ?>"><?php echo $item['store_name']; ?></a></h5>
					<p>经营范围：<?php echo my_substr($item['business_scope'], 40); ?></p>
					<P><i class="icon adder_icon"></i><?php echo str_replace(' ', '', $item['txt_address']).$item['address']; ?><span class="ml30">直播时间：9:00~16:00</span></P>
					<P class="mt15">
						<a href="<?php echo $url; ?>" class="btn o-btn">进入店铺</a>
						<a href="zhibo-detail.html" class="btn ml15">蚁立直播<i class="icon"></i></a>
					</P>
				</dd>
			</dl>
<?php }} ?>
		</div>
		<div class="clear"></div>
        <script type="text/javascript">
            $(document).ready(function(){
                var show_per_page = 10;
                var number_of_items = $('#content').children('.clearfix').size();
                var number_of_pages = Math.ceil(number_of_items/show_per_page);

                $('#current_page').val(0);
                $('#show_per_page').val(show_per_page);
                var navigation_html = '<ul><li class="previous_link"><a href="javascript:previous();">上一页</a></li>';
                var current_link = 0;
                while(number_of_pages > current_link){
                    navigation_html += '<li class="page_link" longdesc="' + current_link +'"><a href="javascript:go_to_page(' + current_link +')">'+ (current_link + 1) +'</a></li>';
                    current_link++;
                }
                navigation_html += '<li class="next_link"><a href="javascript:next();">下一页</a></li></ul>';
                $('#page_navigation').html(navigation_html);
                $('#page_navigation .page_link:first').addClass('currentpage');
                $('#content').children('.clearfix').css('display', 'none');
                $('#content').children('.clearfix').slice(0, show_per_page).css('display', 'block');
            });
            function previous(){
                new_page = parseInt($('#current_page').val()) - 1;
                if($('.currentpage').prev('.page_link').length==true){
                    go_to_page(new_page);
                }
            }
            function next(){
                new_page = parseInt($('#current_page').val()) + 1;
                //if there is an item after the current active link run the function
                if($('.currentpage').next('.page_link').length==true){
                    go_to_page(new_page);
                }
            }
            function go_to_page(page_num){
                var show_per_page = parseInt($('#show_per_page').val());
                start_from = page_num * show_per_page;
                end_on = start_from + show_per_page;
                $('#content').children('.clearfix').css('display', 'none').slice(start_from, end_on).css('display', 'block');
                $('.page_link[longdesc=' + page_num +']').addClass('currentpage').siblings('.currentpage').removeClass('currentpage');
                $('#current_page').val(page_num);
            }

        </script>
<!--		<div class="pagination">-->
<!--			<ul>-->
<!--				--><?php //echo $pagination; ?>
<!--			</ul>-->
<!--		</div>-->
        <input type='hidden' id='current_page' />
        <input type='hidden' id='show_per_page' />
        <div id='page_navigation' class="pagination"></div>
	</div>
    <?php if ($auth_type == 2){?>
        <div class="w260 fr">
            <div class="live-business clearfix mt20">
                <span class="tit">热门厂家推荐</span>
                <ul>
                    <?php
                    $store_list = $this->advdbclass->get_cus_store_list('h', 10, 1);
                    if ($store_list) {
                        foreach ($store_list as $item) {
                            $url = getBaseUrl(false, "", "store/home/{$item['id']}.html", $client_index);
                            ?>
                            <Li>
                                <div class="picture"><a href="<?php echo $url; ?>" style="color: #0968b7;" target="_blank;"><img src="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>" onerror="javascript:this.src='images/default/load.jpg';"></a></div>
                                <div class="property">
                                    <h4 class="nowrap"><a href="<?php echo $url; ?>" style="color: #0968b7;" target="_blank;"><?php echo $item['store_name']; ?></a></h4>
                                    <P class="nowrap">主 营：<?php echo $item['business_scope']; ?></P>
                                    <P>好评率：
                                        <font class="orange">99%</font>
                                    </P>
                                    <P class="mt5">
                                        <a href="" class="btn"><i class="icon"></i>联系我</a><span class="fr c3"><?php echo filter_address($item['txt_address']); ?></span></P>
                                </div>
                            </Li>
                        <?php }} ?>
                </ul>
            </div>
        </div>
    <?php }else{ ?>
	<div class="w260 fr">
		<div class="live-business clearfix mt20">
			<span class="tit">热门商家推荐</span>
			<ul>
<?php
$store_list = $this->advdbclass->get_cus_store_list('h', 10);
if ($store_list) {
	foreach ($store_list as $item) {
			$url = getBaseUrl(false, "", "store/home/{$item['id']}.html", $client_index);
	?>
				<Li>
					<div class="picture"><a href="<?php echo $url; ?>" style="color: #0968b7;" target="_blank;"><img src="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>" onerror="javascript:this.src='images/default/load.jpg';"></a></div>
					<div class="property">
						<h4 class="nowrap"><a href="<?php echo $url; ?>" style="color: #0968b7;" target="_blank;"><?php echo $item['store_name']; ?></a></h4>
						<P class="nowrap">主 营：<?php echo $item['business_scope']; ?></P>
						<P>好评率：
							<font class="orange">99%</font>
						</P>
						<P class="mt5">
							<a href="" class="btn"><i class="icon"></i>联系我</a><span class="fr c3"><?php echo filter_address($item['txt_address']); ?></span></P>
					</div>
				</Li>
<?php }} ?>
			</ul>
		</div>
	</div>
    <?php } ?>
</section>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
</script>