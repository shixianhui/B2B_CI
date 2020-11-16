<section class="warp">
	<div class="help_left box_shadow mt20 clearfix">
		<?php echo $this->load->view('element/help_menu_left_tool', '', TRUE); ?>
	</div>
	<div class="help_right mt20 clearfix">
		<div class="help_tit"><?php if ($item_info) {echo $item_info['title'];} ?></div>
		<div class="helpmian">
		<?php if ($item_info){echo html($item_info['content']);} ?>
		</div>
	</div>
</section>