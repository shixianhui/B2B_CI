<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">添加物流</span><span style="float: right;font-size:16px;"><a href="<?php echo getBaseUrl(false, '', 'seller/my_get_postage_way_list.html', $client_index) ?>" style="color:#333;">返回</a></span></div>
        <div class="add_model active">
            <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" id="jsonForm">
                <div class="mode">
                    <label>配送方式：</label>
                    <input  type="text" name="title" id="title" value="<?php if(! empty($item_info)){ echo $item_info['title'];} ?>" maxlength="100" valid="required" errmsg="配送方式名称不能为空!" class="input-txt"  placeholder="请输入物流名称">
                </div>
                <div class="content">
                    <h4>配送范围及价格</h4>
                    <div class="delivery_address">
                        <label for="">发货地址：</label>
                        <ul>
                            <li>
                                <select valid="required" errmsg="请选择省" class="input_blur" id="province_id" name="province_id" onchange="javascript:get_city('province_id','city_id',0,0,1);">
                                    <option value="">请选择省/直辖市</option>
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
                            </li>
                            <li>
                                <select name="city_id" id="city_id" onchange="javascript:get_city('city_id','area_id',0,0,0);">
                                    <option value="">--选择市--</option>
                                </select>
                            </li>
                            <li>
                                <select name="area_id" id="area_id">
                                    <option value="">--选择区/县--</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <label for="">是否包邮：</label>
                        <input type="radio" name="payer" value="1" <?php if($item_info){if($item_info['payer']=='1'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> onclick="$('.caculate').show();$('.require').attr({'valid':'required','errmsg':'运送地区不能为空'});<?php echo $item_info ? "$('.cal').hide();" : ''?>"/><span>自定义运费</span>
                        <input type="radio" name="payer" value="2" <?php if($item_info){if($item_info['payer']=='2'){echo 'checked="checked"';}} ?>  onclick="$('.caculate').hide();$('.areagroup').html('');$('#calculation input').val('');$('#calculation .default').val('其它地区');$('.require').removeAttr('valid');"/><span>卖家承担运费</span>
                    </div>
                    <div class="caculate cal" <?php if($item_info){{echo 'style="display:none;"';}}?>>
                        <label for="">计价方式：</label>
                        <input type="radio" name="charging_mode" value="1" checked="checked" <?php if($item_info){if($item_info['charging_mode']=='1'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?>/><span>按件数</span>
                        <input type="radio" name="charging_mode" value="2" <?php if($item_info){if($item_info['charging_mode']=='2'){echo 'checked="checked"';}} ?>/><span>按重量</span>
                        <input type="radio" name="charging_mode" value="3" <?php if($item_info){if($item_info['charging_mode']=='3'){echo 'checked="checked"';}} ?>/><span>按体积</span>
                        <span style="color:red">切换计价方式后，所设置当前模板的运算信息将被清空</span>
                    </div>
                    <?php if($item_info){ ?>
                        <div class="caculates">
                             <label for="">计价方式：</label>
                                 <?php 
                                 if($item_info['charging_mode']=='2'){
                                     echo '按重量';  
                                 }else if($item_info['charging_mode']=='3') {
                                     echo '按体积'; 
                                 }else{
                                     echo '按件数';  
                                 }
                                 ?>
                                 
                        </div>
                    <?php }?>
                    <div style="margin-bottom: 0px;<?php if($item_info&&$item_info['payer']==2){ echo 'display:none'; }?>" class="caculate" id="calculation">
                        <label for="">运费计算：</label>
                        <div class="wrap_box">
                            <ul>
                                  <?php if ($item_info && $item_info['postagepriceList']) {
                                      ?>
                                            <?php foreach ($item_info['postagepriceList'] as $postagePrice) { ?>
                                            <?php if ($postagePrice['area'] == '其它地区') { ?>
                                <li>
                                    <span>
                                        默认运费：
                                    </span>
                                    <input type="hidden" name="area_name[]" value="其它地区" class="default"/>
                                    <input type="text" name="start_val[]" value="<?php echo $postagePrice['start_val'] ?>" valid="isMoney" errmsg="请正确填写首件" />
                                    <span style="color:red;" class="per_number">件</span>
                                    <span style="padding-right:10px;">内</span>
                                    <input type="text" name="start_price[]" value="<?php echo $postagePrice['start_price'] ?>" valid="isMoney" errmsg="请正确填写首费" />
                                    <span style="padding-right:10px;">元</span>
                                    <span>每增加</span>
                                    <input type="text" name="add_val[]" value="<?php echo $postagePrice['add_val'] ?>" valid="isMoney" errmsg="请正确填写续件"/>
                                    <span style="color:red;padding-right:10px;" class="per_number">件</span>
                                    <span>增加运费</span>
                                    <input type="text" name="add_price[]" value="<?php echo $postagePrice['add_price'] ?>"  valid="isMoney" errmsg="请正确填写续费" />
                                    <span>元</span>
                                </li>
                                    <?php }}}else{?>
                                <li>
                                    <span>
                                        默认运费：
                                    </span>
                                    <input type="hidden" name="area_name[]" value="其它地区"  class="default"/>
                                    <input type="text" name="start_val[]" value="" valid="isMoney" errmsg="请正确填写首件" />
                                    <span style="color:red;" class="per_number">件</span>
                                    <span style="padding-right:10px;">内</span>
                                    <input type="text" name="start_price[]" value="" valid="isMoney" errmsg="请正确填写首费" />
                                    <span style="padding-right:10px;">元</span>
                                    <span>每增加</span>
                                    <input type="text" name="add_val[]" value="" valid="isMoney" errmsg="请正确填写续件"/>
                                    <span style="color:red;padding-right:10px;"  class="per_number">件</span>
                                    <span>增加运费</span>
                                    <input type="text" name="add_price[]" value=""  valid="isMoney" errmsg="请正确填写续费"/>
                                    <span>元</span>
                                </li>
                                    <?php }?>
                                <li style="margin: 10px 0px;"><a href="javascript:;" onclick="$('#address').show();$('#confirm').data('eq',0);" style="color:#3366cc"><img src="images/admin/add.gif" style="vertical-align:middle;margin-right:5px;">为指定地区设置运费</a></li>
                                <li style="margin: 10px 0px;color:red;">除指定地区外，其余地区的运费采用“默认运费”</li>
                                <li style="">
                                    <table id="otherPostage">
                                        <tr>
                                            <td style="width:44%;text-align:center;">运送到</td>
                                            <td>首件(<span style="color:red;margin:0px;" class="per_number">件</span>)</td>
                                            <td>首费(元)</td>
                                            <td>续件(<span style="color:red;margin:0px;" class="per_number">件</span>)</td>
                                            <td>续费(元)</td>
                                            <td style="width:8%;">操作</td>
                                        </tr>
                                         <?php if ($item_info && $item_info['postagepriceList']) { ?>
                                            <?php foreach ($item_info['postagepriceList'] as $postagePrice) { ?>
                                            <?php if ($postagePrice['area'] != '其它地区') { ?>
                                        <tr>
                                            <td><div class="areagroup"><?php echo $postagePrice['area'] ?></div><input type="hidden" name="area_name[]" value="<?php echo $postagePrice['area'] ?>" <?php if(!($item_info&&$item_info['payer']==2)){ echo ' valid="required" errmsg="运送地区不能为空"';}?> class="require"><a href="javascript:void(0);" onclick="editArea(this);">编辑</a></td>
                                            <td><input type="text" name="start_val[]" value="<?php echo $postagePrice['start_val'] ?>" valid="isMoney" errmsg="请正确填写首件"/></td>
                                            <td><input type="text" name="start_price[]" value="<?php echo $postagePrice['start_price'] ?>"  valid="isMoney" errmsg="金钱格式错误!" /></td>
                                            <td><input type="text" name="add_val[]" value="<?php echo $postagePrice['add_val'] ?>"  valid="isMoney" errmsg="请正确填写续件" /></td>
                                            <td><input type="text" name="add_price[]" value="<?php echo $postagePrice['add_price'] ?>" valid="isMoney" errmsg="金钱格式错误!"/></td>
                                            <td><a href="javascript:void(0);" onclick="$(this).parent().parent().remove();">删除</a></td>
                                      </tr>
                                         <?php }}}?>
                                    </table>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <div class="address" id="address">
                <h4>选择区域<a href="javascript:;" onclick="$('#address').hide();$('input[name=area]').prop('checked',false);">关闭</a></h4>
                <ul style="padding-bottom: 0px;">
                    <li style="margin:0px;">
                        <dl>
                            <?php if ($areaList) { ?>
	              <?php foreach ($areaList as $area) {
	              	?>
                            <dd><input type="checkbox" name="area" value="<?php echo $area['name'];?>"/><?php echo $area['name']?></dd>
                             <?php }} ?>
                        </dl>
                    </li>
                </ul>
                <div class="btn_box">
                    <a href="javascript:;" class="address_sub" id="confirm" data-eq="0">确认</a>
                    <a href="javascript:;" class="address_del"  onclick="$('#address').hide();$('input[name=area]').prop('checked',false);">取消</a>
                </div>
            </div>
                <div class="mode">
                    <label>配送方式介绍：</label>
                    <textarea name="content" id="content" rows="4" cols="80" valid="required" errmsg="配送方式介绍不能为空!" class="textarea_style"><?php if(! empty($item_info)){ echo $item_info['content'];} ?></textarea>
                </div>
                <input type="submit" value="确定" class="confirm_btn">
            </form>
        </div>

    </div>
</div>
<script>
    $("#confirm").click(function(){
       if($('input[name=area]:checked').length == 0){
           alert('请选择配送地区！');
           return;
       };
       var region = '';
       $('input[name=area]:checked').each(function(){
           region += $(this).val()+','; 
       });
       region = region.replace(/,$/,'');
       $("#address").hide();
       $('input[name=area]').prop('checked',false);
       var eq = $(this).data('eq');
       if(eq != 0){
           $('#otherPostage tr').eq(eq).find('.areagroup').html(region);
           $('#otherPostage tr').eq(eq).find('td input[type=hidden]').val(region);
           return;
       }
       var html = '<tr>\
                        <td><div class="areagroup">'+region+'</div><input type="hidden" name="area_name[]" value="'+region+'" valid="required" errmsg="运送地区不能为空"><a href="javascript:void(0);" onclick="editArea(this);">编辑</a></td>\
                        <td><input type="text" name="start_val[]" value=""  valid="isMoney" errmsg="请正确填写首件" /></td>\
                        <td><input type="text" name="start_price[]" value=""  valid="isMoney" errmsg="金钱格式错误!"/></td>\
                        <td><input type="text" name="add_val[]" value=""  valid="isMoney" errmsg="请正确填写续件" /></td>\
                        <td><input type="text" name="add_price[]" value="" valid="isMoney" errmsg="金钱格式错误!"/></td>\
                        <td><a href="javascript:void(0);" onclick="$(this).parent().parent().remove();">删除</a></td>\
                    </tr>';
         $('#otherPostage').append(html);
         
    });
    function editArea(obj){
        var region = $(obj).siblings('input').val();
        var arr = region.split(",");
          $.each(arr,function(i,value){
              $('input[name=area]').each(function(){
                    if($(this).val()==value){
                        $(this).prop('checked',true);
                         return false;
                    } 
                });
          });
          $("#confirm").data('eq',$(obj).parents('tr').index());
          $("#address").show();
    }
    
    $("input[name=charging_mode]").click(function(){
                <?php if($item_info){ ?>
                        if($(this).val() != <?php echo $item_info['charging_mode'];?>){
                            return false;
                        }
                <?php } ?>
        if($(this).val()==1){
            $('.per_number').html('件'); 
        }else if($(this).val()==2){
            $('.per_number').html('kg');
        }else{
            $('.per_number').html('m³');
        }
        $("#calculation input").val('');
        $("#calculation .default").val('其它地区');
        $(".areagroup").html('');
    });
       <?php if($item_info){ ?>
                       <?php if($item_info['charging_mode']==1){?>
                             $('.per_number').html('件'); 
                       <?php }?>
                        <?php if($item_info['charging_mode']==2){?>
                             $('.per_number').html('kg');
                       <?php }?>
                        <?php if($item_info['charging_mode']==3){?>
                             $('.per_number').html('m³'); 
                       <?php }?>
       <?php }?>
    <?php if ($item_info) { ?>
        get_city('province_id','city_id',<?php echo $item_info['city_id']; ?>,<?php echo $item_info['province_id']; ?>,1);
        get_city('city_id','area_id',<?php echo $item_info['area_id']; ?>,<?php echo $item_info['city_id']; ?>,2);
<?php } ?>

</script>