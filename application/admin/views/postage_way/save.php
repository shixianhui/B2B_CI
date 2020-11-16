<?php echo $tool; ?>
<style>
.charging_mode {
	font-size:14px;
	color:red;
}
</style>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>店铺ID</strong>
	  </th>
      <td>
      <input name="store_id" id="store_id" value="<?php if(! empty($item_info)){ echo $item_info['store_id'];} ?>" valid="required" errmsg="店铺ID不能为空!" class="input_blur" type="text">
	</td>
    </tr>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>配送方式名称</strong>
	  </th>
      <td>
      <input name="title" id="title_t" value="<?php if(! empty($item_info)){ echo $item_info['title'];} ?>" size="80" maxlength="100" valid="required" errmsg="配送方式名称不能为空!" class="input_blur" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>发货地</strong> <br/>
	  </th>
      <td>
      <input id="txt_address" name="txt_address" type="hidden" value="<?php if(! empty($item_info)){ echo $item_info['txt_address'];} ?>" />
    <select valid="required" errmsg="请选择省" class="input_blur" id="province_id" name="province_id" onchange="javascript:get_city('province_id','city_id',0,0,1);">
    <option value="">选择省</option>
    <?php if ($area_list) { ?>
    <?php foreach ($area_list as $key=>$value) {
	    	$selector = '';
	    	if ($item_info) {
	    		if ($item_info['province_id'] == $value['id']) {
	    			$selector = 'selected="selected"';
	    		}
	    	}
    	?>
    <option <?php echo $selector; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
    <?php }} ?>
    </select>
    <select class="input_blur" id="city_id" name="city_id" onchange="javascript:get_city('city_id','area_id',0,0,2);">
    <option>选择市</option>
    </select>
    <select onchange="javascript:change_area();" class="input_blur" id="area_id" name="area_id">
    <option>选择区/县</option>
    </select>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>是否包邮</strong> <br/>
	  </th>
      <td>
      <input onclick="change_payer(1);" type="radio" value="1" name="payer" class="radio_style" <?php if($item_info){if($item_info['payer']=='1'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 自定义运费
      <input onclick="change_payer(2);" type="radio" value="2" name="payer" class="radio_style" <?php if($item_info){if($item_info['payer']=='2'){echo 'checked="checked"';}} ?> > 卖家承担运费
	</td>
	</tr>
	<tr id="mode_list">
      <th width="20%">
      <strong>计价方式</strong> <br/>
	  </th>
      <td>
      <input type="radio" onclick="javascript:change_unit();" value="1" name="charging_mode" class="radio_style" <?php if($item_info){if($item_info['charging_mode']=='1'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 按件数
      <input type="radio" onclick="javascript:change_unit();" value="2" name="charging_mode" class="radio_style" <?php if($item_info){if($item_info['charging_mode']=='2'){echo 'checked="checked"';}} ?> > 按重量
      <input type="radio" onclick="javascript:change_unit();" value="3" name="charging_mode" class="radio_style" <?php if($item_info){if($item_info['charging_mode']=='3'){echo 'checked="checked"';}} ?> > 按体积
	</td>
	</tr>
    <tr id="detail_list">
      <th width="20%">
      <strong>配送范围及价格</strong>
	  </th>
      <td>
      <font color="red">&nbsp;除指定地区外，其余地区的运费采用“默认运费”</font><br/>
      <table class="table_form" cellpadding="0" cellspacing="1">
      <?php if ($item_info && $item_info['postagepriceList']) { ?>
      <?php foreach ($item_info['postagepriceList'] as $postagePrice) { ?>
      <?php if ($postagePrice['area'] == '其它地区') { ?>
      <tr>
      <td>
      <input type="hidden" name="area_name[]" value="<?php echo $postagePrice['area'] ?>" size="6" />
       默认运费：<input type="text" name="start_val[]" value="<?php echo $postagePrice['start_val'] ?>" size="6" /> <span class="charging_mode">件</span>内，
       <input type="text" name="start_price[]" value="<?php echo $postagePrice['start_price'] ?>" size="6" /> 元，
      每增加 <input type="text" name="add_val[]" value="<?php echo $postagePrice['add_val'] ?>" size="6" /> <span class="charging_mode">件</span>，
      增加运费 <input type="text" name="add_price[]" size="6" value="<?php echo $postagePrice['add_price'] ?>" /> 元
      </td>
      </tr>
      <?php } else { ?>
      <tr>
       <td>
       至 <input type="text" name="area_name[]" size="40" value="<?php echo $postagePrice['area'] ?>" /> 的运费：
       首件<input type="text" name="start_val[]" value="<?php echo $postagePrice['start_val'] ?>" size="6" /> <span class="charging_mode">件</span>内，
       首费<input type="text" name="start_price[]" value="<?php echo $postagePrice['start_price'] ?>" size="6" /> 元，
        续件 <input type="text" name="add_val[]" value="<?php echo $postagePrice['add_val'] ?>" size="6" /> <span class="charging_mode">件</span>，
      续费 <input type="text" name="add_price[]" value="<?php echo $postagePrice['add_price'] ?>" size="6" /> 元
      <a onclick="javascript:deleteL(this);" href="javascript:void(0);"> 删除</a>
      </td>
      </tr>
      <?php } ?>
      <?php } ?>
      <?php } else { ?>
      <tr>
      <td>
      <input type="hidden" name="area_name[]" value="其它地区" />
 默认运费：<input type="text" name="start_val[]" size="6" /> <span class="charging_mode">件</span>内，
      <input type="text" name="start_price[]" size="6" /> 元，
  每增加 <input type="text" name="add_val[]" size="6" /> <span class="charging_mode">件</span>，
增加运费 <input type="text" name="add_price[]" size="6" value="0.0" /> 元</td>
      </tr>
      <?php } ?>
      <tr class="postage_add" id="1">
          <td><a href="javascript:void(0);" class="postage_table" ><img src="images/admin/add.gif"> 为指定地区设置快递费 <font color="red">注：最好不要手动填地区</font></a>

       <div id="area_id_div" style="width:464px; height:260px; border:2px solid #9EBEEC;display:none;" >
       <table cellpadding="0" cellspacing="0">
       <tr>
       <?php if($areaList): ?>
       <?php foreach ($areaList as $key=>$value): ?>
       <?php if (($key+1)%5 == 0) { ?>
       <td width="100px"><label><input  name="area" value="<?php echo $value['name']; ?>" type="checkbox" /> <?php echo $value['name']; ?></label></td>
       </tr>
       <tr>
       <?php } else { ?>
        <td  width="100px"><label><input  name="area" value="<?php echo $value['name']; ?>" type="checkbox" /> <?php echo $value['name']; ?></label></td>
       <?php } ?>
       <?php endforeach; ?>
       <?php endif; ?>
        </tr>
       </table>
       <input type="button" name="div_submit" value="确定" class="submit_div button_style"  /> <input class="reset_div button_style" type="button" name="div_reset" value="取消" />
	   </div>
       </td>
      </tr>
      </table>
	  </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>排序</strong> <br/>
	  </th>
      <td>
      <input name="sort" id="sort" value="<?php if(! empty($item_info)){ echo $item_info['sort'];}else{echo '0';} ?>" size="5" class="input_blur" type="text">
	</td>
    </tr>
     <tr>
      <th width="20%"><font color="red">*</font> <strong>配送方式介绍</strong> <br/>
	  </th>
      <td>
      <textarea name="content" id="content" rows="4" cols="80" valid="required" errmsg="配送方式介绍不能为空!"  class="textarea_style" ><?php if(! empty($item_info)){ echo $item_info['content'];} ?></textarea>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>
<br/><br/>
<script language="javascript" type="text/javascript">
function change_unit() {
    var charging_mode = $('input[name="charging_mode"]:checked').val();
    if (charging_mode == 1) {
        $('.charging_mode').html('件');
    } else if (charging_mode == 2) {
    	$('.charging_mode').html('kg');
    } else if (charging_mode == 3) {
    	$('.charging_mode').html('m³');
    }
}
change_unit();
$(document).ready(function(){
	$('.postage_table').click(function(){
		$('#area_id_div').show();
	});
    $('.reset_div').click(function(){
    	$(this).parents('div').hide();
    });
    var index = 0;
    $('.submit_div').click(function(){
        var area = '';
    	$("input[name='area']:checked").each(function(i,n){
    		area += $(this).val() + ",";
    	});
    	if (! area) {
			alert('请选择配送地区!');
			return false;
        }
        //添加配送区
        var html = '<tr>';
        html += '<td>';
        html += ' 至 <input type="text" name="area_name[]" size="40" value="'+area.substr(0, area.length - 1)+'" /> 的运费：';
        html += ' 首件<input type="text" name="start_val[]" size="6" /> <span class="charging_mode">件</span>内，';
        html += ' 首费<input type="text" name="start_price[]" size="6" /> 元，';
        html += ' 续件 <input type="text" name="add_val[]" size="6" /> <span class="charging_mode">件</span>，';
        html += ' 续费 <input type="text" name="add_price[]" size="6" /> 元';
        html += '<a onclick="javascript:deleteL(this);" href="javascript:void(0);"> 删除</a>';
        html += '</td>';
        html += '</tr>';
    	$(this).parents('.postage_add').before(html);
    	index = index + 1;
        //重置选定项
    	$("input[name='area']").each(function(i,n){
    		$("input[name='area']").get(i).checked = false;
    	});
    	//隐藏div
    	$(this).parents('div').hide();
    	return false;
    });
});
//删除行
function deleteL(obj) {
	$(obj).parent().parent().remove();
}
</script>
<script type="text/javascript">
function change_area() {
	//国 省 市 县
	var province_id = $("#province_id").val();
	var province_id_txt = $("#province_id").find("option:selected").text();
	var city_id = $("#city_id").val();
	var city_id_txt = $("#city_id").find("option:selected").text();
	var area_id = $("#area_id").val();
	var area_id_txt = $("#area_id").find("option:selected").text();

	var txt_address = '';
	if (province_id) {
		txt_address = province_id_txt;
		if (city_id) {
			txt_address += ' ' + city_id_txt;
			if (area_id) {
				txt_address += ' ' + area_id_txt;
			}
		}
	}
	$("#txt_address").val(txt_address);
}

function get_city(cur_id, next_id, next_select_val, prev_select_val, is_city) {
	var parent_id = $("#"+cur_id).val();
	if (prev_select_val) {
		parent_id = prev_select_val;
	}
	$.post(base_url+"admincp.php/store/get_city",
			{	"parent_id": parent_id
			},
			function(res){
				if(res.success){
					change_area();
					var html = '';
					if (is_city == 1) {
						html = '<option value="">--选择市--</option>';
					} else if (is_city == 2) {
						html = '<option value="">--选择区/县--</option>';
					}
					for (var i = 0, data = res.data, len = data.length; i < len; i++){
						if (data[i]['id'] == next_select_val) {
							html += '<option selected="selected" value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
						} else {
							html += '<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
						}
					}
					$("#"+next_id).html(html);
					return false;
				}else{
					alert(res.message);
					return false;
				}
			},
			"json"
	);
}
<?php if ($item_info) { ?>
get_city('province_id','city_id',<?php echo $item_info['city_id']; ?>,<?php echo $item_info['province_id']; ?>,1);
get_city('city_id','area_id',<?php echo $item_info['area_id']; ?>,<?php echo $item_info['city_id']; ?>,2);
<?php } ?>

function change_payer(type) {
    if(type == 2){
        $('#detail_list input').val('');
        $('#mode_list').hide();
        $('#detail_list').hide();
    }else{
        $('#mode_list').show();
        $('#detail_list').show();
    }
}
</script>