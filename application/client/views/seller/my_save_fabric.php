<div class="member_right mt20">
	<div class="box_shadow clearfix m_border">
		<div class="member_title"><span class="bt">新增面料</span><span style="float: right;font-size:16px;"><a href="<?php echo getBaseUrl(false, '', 'seller/my_get_fabric_list.html', $client_index) ?>" style="color:#333;">返回</a></span></div>
		<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" name="jsonForm" id="jsonForm">
			<div class="b_shop_update">
				<ul class="m_form fl">
					<li class="clearfix"><span>面料名称：</span><input type="text" name="fabric_name" id="fabric_name" value="<?php if($item_info){ echo $item_info['fabric_name'];}?>" valid="required" errmsg="面料名称不能为空" class="input_txt">
						<font color="#cc0011">*</font>
						<font color="red" style="font-size: 14px;">注：以"|"分隔可以批量添加</font>
					</li>
					<li class="clearfix"><span>分类：</span><input type="text" name="tag" id="tag" value="<?php if($item_info){ echo $item_info['tag'];}?>" maxlength="20" class="input_txt"></li>
				</ul>
			</div>
			<div class="clear"></div>
			<div style="margin:20px 0px 20px 200px; clear:both; display:block;">
				<a href="javascript:void(0);" onclick="$('#jsonForm').submit();" class="b_btn">确认提交</a>
			</div>
		</form>
	</div>
</div>