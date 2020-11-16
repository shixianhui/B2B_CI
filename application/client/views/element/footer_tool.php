<div class="clear"></div>
<footer class="mt20">
    <div class="cti clearfix">
        <dl><dt class="c_ico1"></dt><dd>正品保证  优质服务</dd></dl>
        <dl><dt class="c_ico2"></dt><dd>多仓直发  快速配送</dd></dl>
        <dl><dt class="c_ico3"></dt><dd>品质护航  轻松购物</dd></dl>
        <dl><dt class="c_ico4"></dt><dd>天天低价  畅选无忧</dd></dl>
    </div>
    <div class="faq">
                     <?php $menuTreeList = $this->advdbclass->getMenuClass(173, 5);?>
    <?php if ($menuTreeList) { ?>
	<?php foreach ($menuTreeList as $menuTree) { ?>
        <dl>
            <dt><?php echo $menuTree['menu_name']; ?></dt>
            <dd>
                    <?php
          $pageList = $this->advdbclass->getPages($menuTree['id'], 5);
          if($pageList) {
          	  foreach ($pageList as $item) {
				if ($item['url']) {
					$url = $item['url'];
				} else {
					$url = getBaseUrl($html, "{$item['html_path']}/{$item['id']}.html", "{$item['template']}/index/{$item['category_id']}/{$item['id']}.html", $client_index);
				}
       ?>
                <a href="<?php echo $url;?>"><?php echo $item['title']; ?></a>
      <?php }} ?>
            </dd>
        </dl>
 <?php }} ?>
        <dl class="service"><dt><i class="icon"></i><p class="tel">400-101-4666<span>24小时在线客服</span></p></dt>
            <dd>
                <div class="wx"><img src="images/default/wechat.png"></div>下载APP
            </dd>
            <dd>
            </dd>
        </dl>
    </div>
    <div class="clear"></div>
    <div class="copyright">
        <P>
            <a href="<?php echo base_url(); ?>">首页</a>
            <?php
            $footerMenuList = $this->advdbclass->getFooterMenu();
            if ($footerMenuList) {
                foreach ($footerMenuList as $footerMenu) {
                    if ($footerMenu['menu_type'] == '3') {
                        $url = $footerMenu['url'];
                    } else {
                    	if ($footerMenu['menu_type'] == 1 && $footerMenu['cover_function']) {
                    		$url = getBaseUrl($html, "{$footerMenu['html_path']}/{$footerMenu['cover_function']}{$footerMenu['id']}.html", "{$footerMenu['template']}/{$footerMenu['cover_function']}/{$footerMenu['id']}.html", $client_index);
                    	} else {
                    		$url = getBaseUrl($html, "{$footerMenu['html_path']}/index{$footerMenu['id']}.html", "{$footerMenu['template']}/index/{$footerMenu['id']}.html", $client_index);
                    	}
                    }
                    ?>
                    |<a href="<?php echo $url; ?>"><?php echo $footerMenu['menu_name'] ?></a>
                <?php }
            } ?>
        </P>
        <P><?php echo $site_copyright; ?><?php echo $icp_code; ?></P>
    </div>
</footer>