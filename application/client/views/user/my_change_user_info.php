<div class="member_right">
    <div class="box_shadow clearfix mt20 m_border">
        <div class="member_title"><span class="bt">资料信息</span></div>
        <div class="member_tab mt20">
              <form action="<?php echo getBaseUrl(false, "", "user/my_change_user_info.html", $client_index); ?>" id="jsonForm" name="jsonForm" method="post">
            <ul class="m_form" style="float:left; width:640px; border-right:#e8e8e8 1px solid;">
                <li class="clearfix"><span>手机号码：</span>
                    <?php 
                      $mstr_1 = '未验证';
                      $mstr_2 = 'style="background-position:-418px -98px"';
                      $mstr_3 = '';
                    if($item_info){
                        if($item_info['mobile']){
                            $mstr_1 = '已验证';
                            $mstr_2 = '';
                            $mstr_3 = 'red';
                            echo $item_info['mobile'];
                        }
                    }
                        ?>
                    &nbsp;&nbsp;<em class="<?php echo $mstr_3;?>"><i class="moblie_icon_y icon" <?php echo $mstr_2;?>></i>[<?php echo $mstr_1;?>]</em>&nbsp;&nbsp;<a href="<?php echo getBaseUrl(false, "", "user/my_change_mobile.html", $client_index);?>"><font class="blue">修改</font></a></li>
                <li class="clearfix">
                    <span>邮箱：</span>
                        <?php 
                            $str1 = '未认证';
                            $str2 = '';
                            $str3 = '';
                            $str4 = '去认证';
                        if($item_info){ 
                                 if($item_info['email']){
                                     $str1 = '已认证';
                                     $str2 = 'style="background-position:-243px -98px"';
                                     $str3 = 'red';
                                     $str4= '修改';
                                     echo $item_info['email'];
                                 }
                            
                        }?>
                    &nbsp;&nbsp;<em class="c9 <?php echo $str3;?>"><i class="mail_icon icon" <?php echo $str2 ?>></i>[<?php echo $str1;?>]</em>&nbsp;&nbsp;<a href="<?php echo getBaseUrl(false, "", "user/my_change_email.html", $client_index);?>"><font class="blue"><?php echo $str4;?></font></a>
                </li>
                <li class="clearfix"><span>昵称：</span><input type="text" value="<?php if ($item_info){echo $item_info['nickname'];} ?>" id="nickname" name="nickname" valid="isNickname" errmsg="请填写正确的昵称" class="input_txt"></li>
                <li class="clearfix"><span>真实姓名：</span><input type="text" value="<?php if ($item_info){echo $item_info['real_name'];} ?>" id="real_name" name="real_name" valid="isChinese" errmsg="请填写正确的姓名" class="input_txt"></li>
                <li class="clearfix"><span>居住城市：</span>
                    <div class="xm-select" >
                        <div class="dropdown">
                            <label class="iconfont" for="province_id"></label>
                                <select id="province_id" name="province_id"  valid="required" errmsg="请选择省" onchange="javascript:get_city('province_id','city_id',0,0,1);">
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
                            <label class="iconfont" for="city_id"></label>
                            <select id="city_id" name="city_id"  valid="required" errmsg="请选择市" onchange="javascript:get_city('city_id','area_id',0,0,0);">
                                 <option value="">--选择市--</option>
                            </select>
                        </div>
                    </div>
                    <div class="xm-select" >
                        <div class="dropdown">
                            <label class="iconfont" for="area_id"></label>
                            <select id="area_id" name="area_id" valid="required" errmsg="请选择区/县">
                                 <option value="">--选择区/县--</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="clearfix"><span>性别：</span>
                    <div class="xm-select" >
                        <div class="dropdown">
                            <label class="iconfont" for="sex"></label>
                            <select id="sex" name="sex" valid="required" errmsg="请选择性别">
                                 <?php
                                               foreach($sex_arr as $key=>$val){
                                                   $selected = $item_info&&$item_info['sex']==$key ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $key?>" <?php echo $selected;?>><?php echo $val;?></option>
                                               <?php }?>
                            </select>
                        </div>
                    </div>
                </li>
                <input type="hidden" id="path" name="path">
                <li class="clearfix"><span>&nbsp;</span><a href="javascript:void(0)" onclick="$('#jsonForm').submit();" class="btn_r">提 交</a></li>
            </ul>
              </form>
             <div class="m_picture">
                    <h5>头像</h5>
                    <a href="javascript:void(0);" class="file_input">
                        <img src="<?php if ($item_info){echo preg_match('/^http/',$item_info['path']) ? $item_info['path'] : preg_replace("/\./","_thumb.",$item_info['path']);} ?>" id="path_src" onerror="this.src='images/default/load.jpg'">
                        <span>上传新图像<i class="m_icon"></i></span>
                        <input style="left:0px;top:0px; background:#000; width:120px;height:120px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="path_file" name="path_file" >
                        <i class="load" id="path_load" style="cursor:pointer;display:none;width:130px;padding-left:0px;position: absolute;top:0px;left:0px;"><img src="images/default/loading_2.gif" style="width:45px;height:45px;margin-top:30px;"></i>
                    </a>
             </div>
        </div>
    </div>
</div>
<script>
<?php if ($item_info) { ?>
get_city('province_id','city_id','<?php echo $item_info['city_id']; ?>','<?php echo $item_info['province_id']; ?>',1);
get_city('city_id','area_id','<?php echo $item_info['area_id']; ?>','<?php echo $item_info['city_id']; ?>',0);
<?php } ?>
    //形象照片
    $("#path_file").wrap("<form id='path_upload' action='"+base_url+"index.php/upload/uploadImage' method='post' enctype='multipart/form-data'></form>");
    $("#path_file").change(function(){ //选择文件
		$("#path_upload").ajaxSubmit({
			dataType:  'json',
			data: {
                                'model': 'user',
                                'field': 'path_file'
                            },
			beforeSend: function() {
                                            $("#path_load").show();
                                },
                        uploadProgress: function(event, position, total, percentComplete) {},
			success: function(res) {
    			$("#path_load").hide();
    			if (res.success) {
      			    $("#path_src").attr("src", res.data.file_path.replace('.', '_thumb.')+"?"+res.data.field);
      			    $('input[name="path"]').val(res.data.file_path);
        		} else {
        			var d = dialog({
        				fixed: true,
                                        title: '提示',
                                        content: res.message
    				});
                                    d.show();
                                    setTimeout(function () {
                                        d.close().remove();
                                    }, 2000);
                                }
			},
			error:function(xhr){
			}
		});
	});
</script>