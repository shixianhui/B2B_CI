<?php echo $tool; ?>
<link href="css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
<script src="js/admin/jquery.datetimepicker.js" type="text/javascript"></script>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
    <table class="table_form" cellpadding="0" cellspacing="1">
        <caption></caption>
        <tbody>
            <tr>
                <th width="20%">
                    <strong>设置团购商品</strong> <br/>
                </th>
                <td>
                    <table class="table_form" cellpadding="0" cellspacing="1" style="width:700px;margin-left:0px;">
                        <tr>
                            <th width="150px" class="align_c"><strong>产品图片</strong></th>
                            <th class="align_c"><strong>产品标题</strong></th>
                            <th width="90px" class="align_c"><strong>原价（元）</strong></th>
<!--                            <th width="90px" class="align_c"><strong>底价（元）</strong></th>-->
                        </tr>
                        <tr>
                            <td class="align_c"><img src="<?php if($itemInfo){echo $productInfo['path'];}?>" style="max-width:140px;" id="productImg" onerror="this.src='images/default/no_pic.jpg'"></td>
                            <td class="align_c"><span id="productTitle"><?php if($itemInfo){echo $productInfo['title'];}?></span></td>
                            <td class="align_c" id="price"><?php if($itemInfo){echo $productInfo['sell_price'];}?></td>
<!--                            <td class="align_c"><input type="text" name="low_price" size="6" value="--><?php //if($itemInfo){echo $itemInfo['low_price'];}?><!--" valid="required|isMoney" errmsg="最低价不能空|价格格式有误"></td>-->
                        </tr>
                        <td colspan="4">
                            <button class="button_style" type="button" onclick="javascript:window.open('admincp.php/product/selector', 'add', 'top=100, left=200, width=900, height=400, scrollbars=1, resizable=yes');"><span>请选择活动商品</span></button>
                            <label style="color:red;">注： 请选择团购活动商品，每次仅能设置一种商品</label>
                            <input type="hidden" name="product_id" value="<?php if($itemInfo){echo $itemInfo['product_id'];}?>" id="productId" onchange="selectProduct()" valid="required" errmsg="请选择商品">
                        </td>
                    </table>
                </td>
            </tr>

            <tr>
                <th width="20%">
                    <strong>团购活动方式</strong> <br>
                </th>
                <td>
                    <input onclick="$('#type_0').show();$('#type_1').hide();" type="radio" value="0" name="type" class="radio_style" <?php if($itemInfo){ echo $itemInfo['type']==0 ? 'checked' : '';}else{ echo "checked";} ?>> 叠加优惠金额
                    <input onclick="$('#type_1').show();$('#type_0').hide();" type="radio" value="1" name="type" class="radio_style" <?php if($itemInfo){ echo $itemInfo['type']==1 ? 'checked' : '';} ?>> 固定优惠金额
                </td>
            </tr>
            <tr id="type_0"  <?php if ($itemInfo && $itemInfo['type']){ ?>style="display: none" <?php } ?>>
                <th width="20%">
                    <strong>团购规则</strong> <br/>
                </th>
                <td>
                    <table class="table_form" cellpadding="0" cellspacing="1" style="width:400px;margin-left:0px;">
                        <tr>
                            <th class="align_c"><strong>区间</strong></th>
                            <th width="80px" class="align_c"><strong>价格(元)</strong></th>
                            <th width="60px" class="align_c"><strong>操作</strong></th>
                        </tr>
                        <?php
                        if($itemInfo){
                            foreach($pintuan_arr as $ls){
                                ?>
                                <tr>
                                    <td>
                                        <input type="text" name="low[]" valid="isInt" errmsg="人数为正整数" size="5" value="<?php echo $ls['low'];?>"> 人 ～ <input type="text" name="high[]" valid="isInt" errmsg="人数为正整数" value="<?php echo $ls['high'];?>" size="5"> 人
                                    </td>
                                    <td class="align_c">
                                        <input type="text" name="money[]" value="<?php echo $ls['money'];?>"  valid="isMoney" errmsg="金钱格式不正确" size="8">
                                    </td>
                                    <td class="align_c">
                                        <a href="javascript:;" onclick="$(this).parent().parent().remove();">删除</a>
                                    </td>
                                </tr>
                            <?php }}?>
                        <tr  id="firstRow">
                            <td colspan="3"><button type="button" class="button_style" id="addPtrule" style="margin-top:10px;"><span>添加</span></button></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr id="type_1" <?php if (empty($itemInfo) || !$itemInfo['type']){ ?>style="display: none" <?php } ?>>
                <th width="20%"><strong>固定团购价格</strong> <br/></th>
                <td><input type="text" size="10" name="sale_price" value="<?php if($itemInfo){echo $itemInfo['sale_price'];}?>" valid="isMoney" errmsg="固定团购价格格式有误"> 元</td>
            </tr>
            <tr>
                <th width="20%"><strong>定金</strong> <br/></th>
                <td><input type="text" size="10" name="deposit" value="<?php if($itemInfo){echo $itemInfo['deposit'];}?>" valid="required|isMoney" errmsg="请输入定金|定金格式有误"> 元</td>
            </tr>
            <tr>
                <th width="20%"><strong>最少团购人数</strong> <br/></th>
                <td><input type="text" size="10" name="min_number" value="<?php if($itemInfo){echo $itemInfo['min_number'];}?>" valid="required|isInt" errmsg="请输入最少团购人数|最少团购人数格式有误">
                    <font color="red"> 满足最少人数即可成团,否则团购失败</font>
                </td>
            </tr>
            <tr>
                <th width="20%"><strong>最多团购人数</strong> <br/></th>
                <td><input type="text" size="10"  name="max_number" value="<?php if($itemInfo){echo $itemInfo['max_number'];}?>" valid="required|isInt" errmsg="请输入最多团购人数|最多团购人数格式有误">
                    <font color="red">  达到此数量，团购活动自动结束。0表示没有数量限制。</font>
                </td>
            </tr>

            <tr>
                <th width="20%">
                    <strong>活动时间</strong> <br/>
                </th>
                <td>
                    <input name="start_time" value="<?php if($itemInfo){echo date('Y-m-d H:i:s',$itemInfo['start_time']);}?>" id="start_time" size="20"  class="input_blur" type="text" valid="required" errmsg="团购活动开始时间不能为空" readonly="readonly">
                    <script language="javascript" type="text/javascript">
                        $('#start_time').datetimepicker({
                            datepicker: true,
                            format: 'Y-m-d H:i',
                            step: 10
                        });
                    </script>
                    至
                    <input name="end_time" id="end_time" size="20" value="<?php if($itemInfo){echo date('Y-m-d H:i:s',$itemInfo['end_time']);}?>" class="input_blur" type="text" valid="required" errmsg="团购活动结束时间不能为空" readonly="readonly">
                    <script language="javascript" type="text/javascript">
                        $('#end_time').datetimepicker({
                            datepicker: true,
                            format: 'Y-m-d H:i',
                            step: 10
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>是否开启团购活动</strong> <br>
                </th>
                <td>
                    <input type="radio" value="0" name="is_open" class="radio_style" <?php if($itemInfo){ echo $itemInfo['is_open']==0 ? 'checked' : '';}else{ echo "checked";} ?>> 关闭
                    <input type="radio" value="1" name="is_open" class="radio_style" <?php if($itemInfo){ echo $itemInfo['is_open']==1 ? 'checked' : '';} ?>> 开启
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
<script>
    function selectProduct() {
        if(!$("input[name=name]").val()){
            $("input[name=name]").val($("#productTitle").html());
        }
    }
    $("#addPtrule").click(function () {
        var html = '<tr><td>\
                      <input type="text" name="low[]" valid="isInt" errmsg="人数为正整数" size="5"> 人 ～ <input type="text" valid="isInt" errmsg="人数为正整数" name="high[]" size="5"> 人\
                  </td>\
                  <td>\
                      <input type="text" name="money[]" size="10" valid="isMoney" errmsg="金钱格式不正确">\
                  </td> <td>\
                       <a href="javascript:;" onclick="$(this).parent().parent().remove();">删除</a>\
                  </td></tr>';
        $("#firstRow").before(html);
    });
</script>