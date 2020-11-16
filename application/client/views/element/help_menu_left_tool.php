<div class="helpmenu">
	<div class="tit">帮助中心</div>
<?php
    $item_menu_list = $this->advdbclass->getMenuClass($parent_id);
	if ($item_menu_list) {
	    foreach ($item_menu_list as $key=>$menu) { ?>
	<h3 <?php echo $this->uri->segment(3)==$menu['id'] ? 'class="on"' : '';?>><em></em><?php echo $menu['menu_name']; ?></h3>
    <ul>
	<?php
            $cus_list = $this->advdbclass->get_cus_list($template, $menu['id'], '', 0, 5);
            if ($cus_list) {
            foreach ($cus_list as $item) {
            		if ($item['url']) {
            			$url = $item['url'];
            		} else {
            			$url = getBaseUrl($html, "{$item['html_path']}/{$item['id']}.html", "{$template}/index/{$item['category_id']}/{$item['id']}.html", $client_index);
            		}
            		$selector = '';
            		if (isset($item_info)) {
	            		if ($item['id'] == $item_info['id']) {
	            			$selector = 'class="current"';
	            		}
            		}
			?>
		<li>
			<a href="<?php echo $url; ?>" <?php echo $selector; ?>><?php echo $item['title'];?></a>
		</li>
		<?php }} ?>
	</ul>
<?php }} ?>
</div>