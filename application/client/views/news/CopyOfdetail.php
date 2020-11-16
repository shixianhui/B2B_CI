<!--搜索input-->
<link href="css/default/global_cms_top.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/default/global_cms_top.js"></script>
<div id="index_header"> 
       <ul class="topnav">
       <li class="welcome">
       <?php $keywordInfo = $this->advdbclass->getKeyword();?>
	     <?php if (get_cookie('user_username')){ ?>
	     <span id="user_name"><?php echo get_cookie('user_username'); ?></span>，欢迎来到<?php echo html($keywordInfo['web_site']) ?>！
	     <span id="logout"><span class="color_blue"><a class="logout" href="index.php/user/logout.html">退出</a></span></span>
	     <?php } else { ?>
	     <span id="user_name">您好</span>，欢迎来到<?php echo html($keywordInfo['web_site']) ?>！
		 <span id="login"><a href="index.php/user/login.html">请登录</a> <span class="gray">|</span> <a href="index.php/user/register.html">免费注册</a></span>
	     <?php } ?>
		 </li>
	     <?php
		    $headerMenuList = $this->advdbclass->getHeadMenu();    
		    if ($headerMenuList) {
		    foreach ($headerMenuList as $key=>$menu) {
		    	if ($menu['menu_type'] == '3') {
		    		$url = $menu['url'];
		    	} else {
		    		$url = getBaseUrl($html, "{$menu['html_path']}", "{$menu['template']}/index/{$menu['id']}.html", $client_index);
		    	}
         ?>
	     <li class="rbor"><a href="<?php echo $url; ?>"><?php echo $menu['menu_name']; ?></a></li>
	     <?php }} ?>	     
		</ul>
	  <div class="clear"></div>
  <div class="dcenter">
   	<a class="fl" href="<?php echo base_url(); ?>" >
      <img src="images/default/logo.jpg">
    </a>
 <div class="dnav fr" id="global_menu">
 <?php $menuList = $this->advdbclass->getNavigationMenu();
        $count = 0;
        if ($menuList) {
		    foreach ($menuList as $menu) {
		        if ($menu['id'] == $parentId) {
		    		$count++;
		    	}
		    }		    
        }
        $indexClass = 'select';
        if ($count) {
        	$indexClass = '';
        }
 ?>
	     <span class="<?php echo $indexClass; ?>"><a href="<?php if ($html){echo '/index.html';} else {echo '/'.$client_index;} ?>"><?php echo $index_name; ?> </a></span>
	     <?php
		    if ($menuList) {
		    foreach ($menuList as $key=>$menu) {
		    	if ($menu['menu_type'] == '3') {
		    		$url = $menu['url'];
		    	} else {
		    		$url = getBaseUrl($html, "{$menu['html_path']}", "{$menu['template']}/index/{$menu['id']}.html", $client_index);
		    	}
		        $strClass = '';
		    	if ($menu['id'] == $parentId) {
		    		$strClass = 'select';
		    	}
		?>
	     <span class="<?php echo $strClass; ?>"><a href="<?php echo $url; ?>"><?php echo $menu['menu_name']; ?> </a></span>
		<?php }} ?>
      </div>
  <span class="clear"></span>
  </div>
        <div class="bottom">
           <div class="category fl color_white_none" id="allCategoryHeader">
           <h2><a href="javascript:void(0);" onmouseover="javascript:showClass();" onmouseout="javascript:hiddenClass();" target="_blank">所有商品分类</a></h2>
           <div id="allCategoryHeadert" class="allsort_out_box" style="display:none;" onmouseover="javascript:showClass();" onmouseout="javascript:hiddenClass();">
		    <div class="allsort_out">
		      <ul class="allsort">
		        <?php $itemMenuList = $this->advdbclass->getLeftProductClass(); ?>
				<?php if ($itemMenuList) {
					foreach ($itemMenuList as $key=>$itemMenu) {
					$url = getBaseUrl($html, "{$itemMenu['html_path']}", "{$itemMenu['template']}/index/{$itemMenu['id']}.html", $client_index);
				?>
			     <li>             
		          <h3><a target="_blank" href="<?php echo $url; ?>" title="<?php echo clearstring($itemMenu['menu_name']); ?>"><?php echo $itemMenu['menu_name']; ?></a></h3>
			      <div style="min-height: 480px; height: 481px;" class="show_sort"></div>
			     </li>
			    <?php }} ?>
		       </ul>
		    </div>
			</div>
			<script type="text/javascript">
			function showClass() {
			    $('#allCategoryHeadert').show();
			}
			function hiddenClass() {
				$('#allCategoryHeadert').hide();
			}
			</script>
           </div>
           <?php echo $this->load->view('element/page_search_tool', '', TRUE); ?>
       </div>
</div>
<div id="container">
   <div class="banner980x60 mt5">
	<u>
	<?php
		$adList = $this->advdbclass->getOthorAd(8);
		if ($adList) {
		foreach ($adList as $ad) {
    ?>
		<li style="margin-top:5px;">
		<a title="<?php echo $ad['ad_text']; ?>" href="<?php echo $ad['url']; ?>" target="_blank"><img title="<?php echo $ad['ad_text']; ?>" src="<?php echo $ad['path']; ?>"></a>
		</li>
    <?php }} ?>
	  </u>
	</div>
    <div class="clearfix mt10">
         <div class="left_menu">
   <ul class="column" id="help_list">
    <?php $parentMenuInfo = $this->advdbclass->getMenuInfo($parentId); ?>
        <li><h2><?php echo $parentMenuInfo['menu_name']; ?></h2>
            <ul>
         <?php $itemMenuList = $this->advdbclass->getMenuClass($parentId); ?>
         <?php if ($itemMenuList) {
			foreach ($itemMenuList as $key=>$itemMenu) {
			$url = getBaseUrl($html, "{$itemMenu['html_path']}", "{$itemMenu['template']}/index/{$itemMenu['id']}.html", $client_index);
		 ?>
                <li onclick="javascript:window.location.href='<?php echo $url; ?>';"><h3><?php echo $itemMenu['menu_name']; ?></h3>
                 <?php
                 if ($itemMenu['subMenuList']) {
                 ?>
                    <ul>
                    <?php
				     foreach ($itemMenu['subMenuList'] as $skey=>$subMenu) {
				         $url = getBaseUrl($html, "{$subMenu['html_path']}", "{$subMenu['template']}/index/{$subMenu['id']}.html", $client_index);
			    ?>
                        <li><a href="<?php echo $url; ?>"><?php echo $subMenu['menu_name']; ?></a></li>
                    <?php } ?>
                    </ul>
                   <?php } ?>
                </li>
           <?php }} ?>
            </ul>
        </li>
    </ul>
    <?php echo $this->load->view('element/service_left_tool', '', TRUE); ?>
</div>  
        <div class="right_content">
        	<div class="crumb">
        	<?php if ($location){echo $location;} ?>
        	</div>
            <div class="help_box">
            	<h3><?php if($newsInfo){ echo $newsInfo['title'];} ?></h3>
                <div class="help_detail">
                <?php if($newsInfo){ echo html($newsInfo['content']);} ?>					
		    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="linktable" style="margin-top:10px;">
            <tbody>
           <?php if($prvInfo) {
						$url = getBaseUrl($html, "{$prvInfo['html_path']}/{$prvInfo['id']}.html", "news/detail/{$prvInfo['id']}.html", $client_index);
		   ?>
           <tr>
              <td> 
               <strong>上一条: </strong><a title="<?php echo $prvInfo['title']; ?>" href="<?php echo $url; ?>"><?php echo $prvInfo['title']; ?></a>
			 </td>
            </tr>
            <?php } ?>
            <?php if($nextInfo){
						$url = getBaseUrl($html, "{$nextInfo['html_path']}/{$nextInfo['id']}.html", "news/detail/{$nextInfo['id']}.html", $client_index);
			?>
           <tr>
              <td height="25">  
                <strong>下一条: </strong><a title="<?php echo $nextInfo['title']; ?>" href="<?php echo $url; ?>"><?php echo $nextInfo['title']; ?></a>
			  </td>
            </tr>
            <?php } ?>
          </tbody>
          </table>
          
          </div>
         </div>
        </div>
    </div>
</div>
<?php echo $this->load->view('element/footer_tool', '', TRUE); ?>
<script type="text/javascript">
/*左侧菜单*/
jQuery(function(){
	jQuery("#help_list").find("h3").next("ul").hide();
	jQuery("#help_list").find("h3").eq(0).addClass("on")
	jQuery("#help_list").find("h3").eq(0).next("ul").show();
	jQuery("#help_list").find("h3").click(function(){
		var sub_list2 = jQuery(this).next("ul");
		if(sub_list2.is( ":visible")){
			sub_list2.slideUp();
			jQuery(this).removeClass("on");
		}else{
			jQuery("#help_list").find("h3").removeClass("on");
			jQuery("#help_list").find("h3").next().slideUp();
			sub_list2.slideDown();
			jQuery(this).addClass("on");
		}
	})
})
</script>