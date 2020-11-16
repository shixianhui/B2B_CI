<style>
    .b_form li {
        margin-top:15px;
    }
</style>
<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="b_title">
            <div class="hd">
                <ul>
                    <li <?php if ($item_info && $item_info['store_type'] == 1) {echo 'on';} ?> onclick="change_store_type(1);" name="store_type">入驻实体商家</li>
                    <li <?php if ($item_info && $item_info['store_type'] == 2) {echo 'on';} ?> onclick="change_store_type(2);" name="store_type">入驻实体厂家</li>
                    <Li <?php if ($item_info && $item_info['store_type'] == 3) {echo 'on';} ?> onclick="change_store_type(3);" name="store_type">入驻实力电商</Li>
                </ul>
            </div>
            <div class="bd">
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="jsonForm" id="jsonForm">
                <ul class="b_form">
                    <Li><span>店铺名称：</span><input value="<?php if ($item_info) {echo $item_info['store_name'];} ?>" type="text" id="store_name" name="store_name" class="input_1" valid="required" errmsg="店铺名称不能为空" maxlength="100">
                        <font>*</font>
                    </Li>
                    <Li><span>所在地区：</span>
                        <div class="b_select">
                                   <div class="dropdown">
                                            <select id="province_id" name="province_id" onchange="javascript:get_city('province_id','city_id',0,0,1);" valid="required" errmsg="请选择省">
                                                <option value="">-省份-</option>
							                  <?php if ($province_list) { ?>
								              <?php foreach ($province_list as $province) {
									              	$selector = '';
									              	if ($item_info) {
									              		if ($item_info['province_id'] == $province['id']) {
									              			$selector = 'selected="selected"';
									              		}
									              	}
								              	?>
								              <option <?php echo $selector; ?> value="<?php echo $province['id']; ?>"><?php echo $province['name']; ?></option>
								              <?php }} ?>
                                            </select>
                                        </div>
                        </div>
                        <div class="b_select">
                                    <div class="dropdown">
                                            <select id="city_id" name="city_id"  valid="required" errmsg="请选择市" onchange="javascript:get_city('city_id','area_id',0,0,0);">
                                                <option value="">-市/县-</option>
                                            </select>
                                        </div>
                        </div>
                        <div class="b_select">
                            <div class="dropdown">
                                            <select id="area_id" name="area_id" valid="required" errmsg="请选择区">
                                                <option value="">-区-</option>
                                            </select>
                              </div>
                        </div>
                        <font>*</font>
                        <div style="margin-top:20px;"><span>详细地址：</span><input value="<?php if ($item_info) {echo $item_info['address'];} ?>" type="text" class="input_1" id="address" name="address" style="width:560px;" maxlength="255"></div>
                    </Li>
                    <Li><span>店主姓名：</span><input value="<?php if ($item_info) {echo $item_info['owner_name'];} ?>" type="text" id="owner_name" name="owner_name" valid="required|isChinese" errmsg="店主姓名不能为空|店主姓名只能包含中文" class="input_1">
                        <font>*</font>
                    </Li>
                    <Li><span>身份证号：</span><input value="<?php if ($item_info) {echo $item_info['owner_card'];} ?>" type="text" id="owner_card" name="owner_card" valid="required|isIdCard" errmsg="身份证号不能为空|身份证号格式不正确" class="input_1">
                        <font>*</font>
                    </Li>
                    <Li><span>手机号：</span><input value="<?php if ($item_info) {echo $item_info['mobile'];} ?>" type="text" id="mobile" name="mobile" valid="required|isMobile" errmsg="手机号不能为空|手机号格式不正确" class="input_1">
                        <font>*</font>
                    </Li>
                    <Li><span>联系QQ：</span><input value="<?php if ($item_info) {echo $item_info['im_qq'];} ?>" id="im_qq" name="im_qq" type="text" class="input_1" valid="isQQ" errmsg="qq号格式有误"></Li>
                    <Li><span>微信号：</span><input value="<?php if ($item_info) {echo $item_info['im_weixin'];} ?>" id="im_weixin" name="im_weixin" type="text" valid="isWeixin" errmsg="微信号格式有误" class="input_1"></Li>
                    <Li><span>旺旺号：</span><input value="<?php if ($item_info) {echo $item_info['im_ww'];} ?>" id="im_ww" name="im_ww" type="text" class="input_1" maxlength="40"></Li>
                    <div id="license">
                    <li><span style="font-weight: bold;width: 160px">个体户营业执照登记</span></li>
                    <li><span>注册号：</span><input value="<?php if ($item_info) {echo $item_info['reg_num'];} ?>" type="text" id="reg_num" name="reg_num" valid="required|isRegnum" errmsg="注册号不能为空|注册号为15位数字" class="input_1">
                        <font>*</font>
                    </li>
                    <li><span>名称：</span><input value="<?php if ($item_info) {echo $item_info['license_store_name'];} ?>" type="text" id="license_store_name" name="license_store_name" valid="required" errmsg="名称不能为空" class="input_1">
                        <font>*</font>
                    </li>
                        <li><span>经营者姓名：</span><input value="<?php if ($item_info) {echo $item_info['license_username'];} ?>" type="text" id="license_username" name="license_username" valid="required|isChinese" errmsg="经营者姓名不能为空|经营者姓名只能包含中文" class="input_1">
                            <font>*</font>
                        </li>
                        <li><span>组成形式：</span><input value="<?php if ($item_info) {echo $item_info['license_form'];} ?>" type="text" id="license_form" name="license_form" class="input_1">
                        </li>
                        <li><span>经营场所：</span><input value="<?php if ($item_info) {echo $item_info['license_place'];} ?>" type="text" id="license_place" name="license_place" class="input_1">
                        </li>
                        <li><span>经营范围：</span><input value="<?php if ($item_info) {echo $item_info['license_business_scope'];} ?>" type="text" id="license_business_scope" name="license_business_scope" class="input_1">
                        </li>
                    </div>



                    <input type="hidden" name="auth_store_type" value="1">
                    <li class="upload">
                        <span>请上传认证：</span>
                        <p>
                            请下载<a href="uploads/实体商家认证.doc" id="downloadAuth">《蚁立网家居平台认证申请信息表》</a>填写并上传
                        </p>
                    </li>
                    <li>
                        <span></span>
                        <div class="select_file" onclick="$('input[name=auth_file]').click();">选择文件</div>
                        <p style="line-height:32px;" id="clientName"><?php if ($item_info) { echo $item_info['auth_file_path'];} ?></p>
                        <input type="file" accept=".docx,.doc" name="auth_file" model="upload_auth" class="auth_file_path" style="display:none;">
                        <input type="hidden" name="auth_file_path" value="<?php if ($item_info) { echo $item_info['auth_file_path'];} ?>">
                    </li>
                    <Li><span></span>
                        <input type="hidden" name="store_type" value="<?php if ($item_info) {echo $item_info['store_type'];}else{echo '1';} ?>" valid="required" errmsg="请选择店铺类型">
                        <a href="javascript:void(0)" onclick="$('#jsonForm').submit();" class="b_btn"><?php if ($item_info && $item_info['display'] == 2 && $store_id) {echo '重新提交店铺申请';}else{echo '提交店铺申请';} ?></a>
                    </Li>
                </ul>
                 </form>
            </div>
        </div>
    </div>
</div>
<script id="license_1" type="text/html">
    <li><span style="font-weight: bold;width: 160px">个体户营业执照登记</span></li>
    <li><span>注册号：</span><input value="<?php if ($item_info) {echo $item_info['reg_num'];} ?>" type="text" id="reg_num" name="reg_num" valid="required|isRegnum" errmsg="注册号不能为空|注册号为15位数字" class="input_1">
        <font>*</font>
    </li>
    <li><span>名称：</span><input value="<?php if ($item_info) {echo $item_info['license_store_name'];} ?>" type="text" id="license_store_name" name="license_store_name" valid="required" errmsg="名称不能为空" class="input_1">
        <font>*</font>
    </li>
    <li><span>经营者姓名：</span><input value="<?php if ($item_info) {echo $item_info['license_username'];} ?>" type="text" id="license_username" name="license_username" valid="required|isChinese" errmsg="经营者姓名不能为空|经营者姓名只能包含中文" class="input_1">
        <font>*</font>
    </li>
    <li><span>组成形式：</span><input value="<?php if ($item_info) {echo $item_info['license_form'];} ?>" type="text" id="license_form" name="license_form" class="input_1">
    </li>
    <li><span>经营场所：</span><input value="<?php if ($item_info) {echo $item_info['license_place'];} ?>" type="text" id="license_place" name="license_place" class="input_1">
    </li>
    <li><span>经营范围：</span><input value="<?php if ($item_info) {echo $item_info['license_business_scope'];} ?>" type="text" id="license_business_scope" name="license_business_scope" class="input_1">
    </li>
</script>

<script id="license_2" type="text/html">
    <li><span style="font-weight: bold;width: 160px">营业执照登记</span></li>
    <li><span style="width: 145px">统一社会信用代码：</span><input value="<?php if ($item_info) {echo $item_info['license_credit_code'];} ?>" type="text" id="license_credit_code" name="license_credit_code" valid="required|is_credit_code" errmsg="统一社会信用代码不能为空|统一社会信用代码为18位数字" class="input_1">
        <font>*</font>
    </li>
    <li><span>名称：</span><input value="<?php if ($item_info) {echo $item_info['license_store_name'];} ?>" type="text" id="license_store_name" name="license_store_name" valid="required" errmsg="名称不能为空" class="input_1">
        <font>*</font>
    </li>
    <li><span>类型：</span><input value="<?php if ($item_info) {echo $item_info['license_store_type'];} ?>" type="text" id="license_store_type" name="license_store_type" class="input_1">
    </li>
    <li><span>住所：</span><input value="<?php if ($item_info) {echo $item_info['license_residence'];} ?>" type="text" id="license_residence" name="license_residence" class="input_1">
    </li>
    <li><span>法定代表人：</span><input value="<?php if ($item_info) {echo $item_info['license_representative'];} ?>" type="text" id="license_representative" name="license_representative" class="input_1">
    </li>
    <li><span>注册资本：</span><input value="<?php if ($item_info) {echo $item_info['license_capital'];} ?>" type="text" id="license_capital" name="license_capital" class="input_1">
    </li>
    <li><span>成立日期：</span><input value="<?php if ($item_info) {echo $item_info['license_made_time'];} ?>" type="text" id="license_made_time" name="license_made_time" class="input_1">
    </li>
    <li><span>营业期限：</span><input value="<?php if ($item_info) {echo $item_info['license_time_limit'];} ?>" type="text" id="license_time_limit" name="license_time_limit" class="input_1">
    </li>
    <li><span>经营范围：</span><input value="<?php if ($item_info) {echo $item_info['license_business_scope'];} ?>" type="text" id="license_business_scope" name="license_business_scope" class="input_1">
    </li>
</script>
<script id="license_3" type="text/html">
    <li><span style="font-weight: bold;width: 160px">营业执照登记</span></li>
    <li><span style="width: 145px">统一社会信用代码：</span><input value="<?php if ($item_info) {echo $item_info['license_credit_code'];} ?>" type="text" id="license_credit_code" name="license_credit_code" valid="is_credit_code" errmsg="统一社会信用代码为18位数字" class="input_1">
    </li>
    <li><span>名称：</span><input value="<?php if ($item_info) {echo $item_info['license_store_name'];} ?>" type="text" id="license_store_name" name="license_store_name" class="input_1">
    </li>
    <li><span>类型：</span><input value="<?php if ($item_info) {echo $item_info['license_store_type'];} ?>" type="text" id="license_store_type" name="license_store_type" class="input_1">
    </li>
    <li><span>住所：</span><input value="<?php if ($item_info) {echo $item_info['license_residence'];} ?>" type="text" id="license_residence" name="license_residence" class="input_1">
    </li>
    <li><span>法定代表人：</span><input value="<?php if ($item_info) {echo $item_info['license_representative'];} ?>" type="text" id="license_representative" name="license_representative" class="input_1">
    </li>
    <li><span>注册资本：</span><input value="<?php if ($item_info) {echo $item_info['license_capital'];} ?>" type="text" id="license_capital" name="license_capital" class="input_1">
    </li>
    <li><span>成立日期：</span><input value="<?php if ($item_info) {echo $item_info['license_made_time'];} ?>" type="text" id="license_made_time" name="license_made_time" class="input_1">
    </li>
    <li><span>营业期限：</span><input value="<?php if ($item_info) {echo $item_info['license_time_limit'];} ?>" type="text" id="license_time_limit" name="license_time_limit" class="input_1">
    </li>
    <li><span>经营范围：</span><input value="<?php if ($item_info) {echo $item_info['license_business_scope'];} ?>" type="text" id="license_business_scope" name="license_business_scope" class="input_1">
    </li>
</script>
<script src="js/default/template-native.js"></script>
<script type="text/javascript">
	<?php if ($item_info) { ?>
	get_city('province_id', 'city_id', '<?php echo $item_info['city_id']; ?>', '<?php echo $item_info['province_id']; ?>', 1);
	get_city('city_id', 'area_id', '<?php echo $item_info['area_id']; ?>', '<?php echo $item_info['city_id']; ?>', 0);
	<?php } ?>

    $(".auth_file_path").wrap("<form class='file_path' action='" + base_url + "index.php/upload/upload_auth_file' method='post' enctype='multipart/form-data'></form>");
    $(".auth_file_path").change(function() { //选择文件
        var field = $(this).attr('name');
        $(this).parents('.file_path').ajaxSubmit({
            dataType: 'json',
            data: {
                'field': field
            },
            beforeSend: function() {
                $('body').append($('<div id="loading"></div>'));
            },
            uploadProgress: function(event, position, total, percentComplete) {},
            success: function(res) {
                $("#loading").remove();
                if(res.success) {
                    $("#clientName").html(res.data.file_path);
                    $("input[name=auth_file_path]").val(res.data.file_path);
                } else {
                    var d = dialog({
                        fixed: true,
                        title: '提示',
                        content: res.message
                    });
                    d.show();
                    setTimeout(function() {
                        d.close().remove();
                    }, 2000);
                }
            },
            error: function(xhr) {}
        });
    });
    $("li[name=store_type]").click(function(){
        var file_path = '';
        var txt = '';
        var auth_type = '';
        var store_type = $('input[name=store_type]').val();
        if(store_type==1){
            txt = '《蚁立网家居平台认证申请信息表》';
            file_path = 'uploads/实体商家认证.doc';
            auth_type = '实体商家认证';
        }
        if(store_type==2){
            txt = '《蚁立网家居平台认证申请信息表》';
            file_path = 'uploads/实体厂家认证.doc';
            auth_type = '实体厂家认证';
        }
        if(store_type==3){
            txt = '《蚁立网家居平台认证申请信息表》';
            file_path = 'uploads/实力电商认证.doc';
            auth_type = '实力电商认证';
        }
        $('#downloadAuth').html(txt).attr('href',file_path);
        $('input[name=auth_store_type]').val(store_type);
    });
    
    function change_store_type(id) {
        $('input[name=store_type]').val(id);
        var html = template('license_'+id);
        $('#license').html(html);
    }
</script>