<div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">新增收货地址</span></div>
            <div class="clear"></div>
             <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="jsonForm" name="jsonForm" method="post">
            <ul class="m_form" >
                <li class="clearfix"><span><font color="df0679"><strong>*</strong></font>收货人：</span><input type="text" value="<?php if ($item_info){echo $item_info['buyer_name'];} ?>" id="buyer_name" name="buyer_name" valid="required" errmsg="姓名不能为空" class="input_txt"></li>
                <li class="clearfix"><span><font color="df0679"><strong>*</strong></font>手机号码：</span><input type="text" value="<?php if ($item_info){echo $item_info['mobile'];} ?>" id="mobile" name="mobile" valid="required|isMobile" errmsg="请输入手机号|请输入正确的手机号" class="input_txt"></li>
                <li class="clearfix"><span>固定电话：</span><input type="text" value="<?php if ($item_info){echo $item_info['phone'];} ?>" id="phone" name="phone" valid="isPhone" errmsg="请输入固定电话" class="input_txt"></li>
                <li class="clearfix"><span><font color="df0679"><strong>*</strong></font>所在地区：</span>
                    <div class="xm-select" >
                        <div class="dropdown">
                            <label class="iconfont" for="feedbackType"></label>
                            <select id="province_id" name="province_id" onchange="javascript:get_city('province_id','city_id',0,0,1);">
                               <option value="">--选择省--</option>
                                <?php if ($areaList) { ?>
	              <?php foreach ($areaList as $area) {
		              	$selector = '';
		              	if ($item_info) {
		              		if ($item_info['province_id'] == $area['id']) {
		              			$selector = 'selected="selected"';
		              		}
		              	}
	              	?>
	              <option <?php echo $selector; ?> value="<?php echo $area['id']; ?>"><?php echo $area['name']; ?></option>
	              <?php }} ?>
                            </select>
                        </div>
                    </div>
                    <div class="xm-select" >
                        <div class="dropdown">
                            <label class="iconfont" for="feedbackType"></label>
                            <select id="city_id" name="city_id" onchange="javascript:get_city('city_id','area_id',0,0,0);">
                                 <option value="">--选择市--</option>
                            </select>
                        </div>
                    </div>
                    <div class="xm-select" >
                        <div class="dropdown">
                            <label class="iconfont" for="feedbackType"></label>
                            <select id="area_id" name="area_id">
                                 <option value="">--选择区/县--</option>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div style="margin-top:10px;">
                        <span><font color="df0679"><strong>*</strong></font>详细地址：</span>
                        <textarea id="address" name="address" class="textarea_txt" placeholder="详细地址" ><?php if ($item_info){echo $item_info['address'];} ?></textarea>
                    </div>
                </li>
                <li class="clearfix"><span>邮编：</span><input type="text" value="<?php if ($item_info){echo $item_info['zip'];} ?>" id="zip" name="zip" maxlength="6" valid="isZip" errmsg="请输入正确的邮编" class="input_txt"> </li>
                <li class="clearfix"><span>&nbsp;</span><dl class="m_check"><dd><span name="checkWeek" class="CheckBoxNoSel<?php if($item_info){echo $item_info['is_default']==1 ? ' CheckBoxSel' : '';}?>" onclick="selectDefault(this)"></span>设为默认地址<input type="hidden" id="is_default" name="is_default" value="<?php if ($item_info){echo $item_info['is_default'];}?>"></dd></dl> </li>
                <li class="clearfix"><span>&nbsp;</span><input type="submit" value="提交" class="btn_r" style="border:none;"></li>
            </ul>
                  </form>
        </div>
    </div>
<script type="text/javascript">
<?php if ($item_info) { ?>
get_city('province_id','city_id','<?php echo $item_info['city_id']; ?>','<?php echo $item_info['province_id']; ?>',1);
get_city('city_id','area_id','<?php echo $item_info['area_id']; ?>','<?php echo $item_info['city_id']; ?>',0);
<?php } ?>

function selectDefault(_this){
    if(!$(_this).hasClass('CheckBoxSel')){
        $('#is_default').val(1);
        $(_this).addClass('CheckBoxSel');
    }else{
        $(_this).removeClass('CheckBoxSel');
        $('#is_default').val(0);
    }
}
</script>