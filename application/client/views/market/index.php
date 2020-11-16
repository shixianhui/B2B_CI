<div class="mall-head">
			<div class="head-content">
				<a href="javascript:void(0);"><img src="<?php if ($item_info) {echo preg_replace('/\./', '_thumb.', $item_info['path']);} ?>" class="logo"></a>
				<?php if ($top_attachment_list) { ?>
				<ul class="head-ad" style="float: left;margin-left: 165px">
				<?php foreach ($top_attachment_list as $key=>$item) {
					      $str_class = 'class="ml95"';
				          if ($key == 0) {
				          	$str_class = '';
				          }
					?>
					<Li <?php echo $str_class; ?>>
						<a href="javascript:void(0);"><img src="<?php echo $item['path']; ?>"></a>
					</Li>
				<?php } ?>
				</ul>
				<?php } ?>
			</div>
			<div class="mall-menu">
				<ul>
					<li>
						<a href="javascript:void(0);" class="current">商场首页</a>
					</li>
					<Li class="return">
						<a href="javascript:history.go(-1);">返回</a>
					</Li>
				</ul>
			</div>
</div>
<?php if ($attachment_list) { ?>
<div class="fullSlide">
	<div class="bd">
		<ul>
		<?php foreach ($attachment_list as $key=>$item) { ?>
			<li _src="url(<?php echo $item['path']; ?>)" style="background:center 0 no-repeat;">
				<a target="_blank" href="javascript:void(0);"></a>
			</li>
		<?php } ?>
		</ul>
	</div>
	<div class="hd">
		<ul></ul>
	</div>
</div>
<?php } ?>
<div class="warp">
	<div class="mall-intro mt20">
		<img src="images/default/mall_intro_bg.jpg">
		<div class="mask">
			<h2>商场介绍</h2> <?php if ($item_info) {echo str_replace(array("\r\n", "\n", "\r"), '<br/>', $item_info['introduce']);} ?>
		</div>
	</div>
	<div class="mall-flat mt20">
		<h3>商场平面图 </h3>
		<?php if ($item_info){echo html($item_info['content']);} ?>
	</div>
	<div class="mall-map clearfix mt20">
		<div class="contact">
			<li><span>商场名：</span><?php if ($item_info){echo $item_info['title'];} ?></li>
			<li><span>地址：</span><?php if ($item_info){echo $item_info['txt_address'].$item_info['address'];} ?></li>
			<li><span>联系人：</span><?php if ($item_info){echo $item_info['contacts'];} ?></li>
			<li><span>电话：</span><?php if ($item_info){echo $item_info['phone'];} ?></li>
			<li><span>传真：</span><?php if ($item_info){echo $item_info['fax'];} ?></li>
			<li><span>邮箱：</span><?php if ($item_info){echo $item_info['email'];} ?></li>
		</div>
		<div class="map">
<?php if ($item_info){echo html($item_info['location_txt']);} ?>
		</div>
	</div>
	<?php if ($bottom_attachment_list) { ?>
	<div class=" mt20">
	    <?php foreach ($bottom_attachment_list as $key=>$item) { ?>
		<a href="javascript:void(0);"><img src="<?php echo $item['path']; ?>"></a>
		<?php } ?>
	</div>
	<?php } ?>
</div>