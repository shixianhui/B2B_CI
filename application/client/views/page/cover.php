<section class="warp">
	<div class="help_left box_shadow mt20 clearfix">
    <?php echo $this->load->view('element/help_menu_left_tool', '', TRUE); ?>
	</div>
	<div class="help_right mt20 clearfix">
		<div class="help_tit">新手指南</div>
		<div class=" mt20">
			<p align="center"><img src="images/default/lc.png"></p>
		</div>
		<div class="help_tit mt30">常见问题</div>
		<ul class="help_common clearfix">
 <?php
            $cus_list = $this->advdbclass->get_cus_list($template, $parent_id, '', 0, 10);
            if ($cus_list) {
            	foreach ($cus_list as $item) {
				$url = getBaseUrl($html, "{$item['html_path']}/{$item['id']}.html", "{$template}/index/{$item['category_id']}/{$item['id']}.html", $client_index);
			?>
			<Li><span>[<?php echo $item['menu_name']; ?>]</span>
				<a href="<?php echo $url; ?>"><?php echo $item['title']; ?></a>
			</Li>
<?php }} ?>
		</ul>
		<div class="help_tit mt30">联系我们</div>
		<ul class="help_contact clearfix">
			<LI><span>电话客服</span>预约客服，主动回电
				<a href="" class="btn">立即预约</a>
			</LI>
			<LI><span>在线客服</span>在线解答您的咨询，高效、便捷
				<a href="" class="btn" style="background:#4cb0e2">立即咨询</a>
			</LI>
			<LI><span>提建议</span>对帮助中心提建议 | 邮件留言
				<font class="blue">service@yzj.com</font>
				<a href="" class="btn" style="background:#6abb77">我要留言</a>
			</LI>
		</ul>
	</div>
</section>