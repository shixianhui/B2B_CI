<style>
    .m_form .input_txt{ width: 160px}
    .table_form th{border: 1px solid #D7D7D7}
    .table_form td{border: 1px solid #D7D7D7}
    td.align_c, th.align_c {
        text-align: center;
    }
</style>
<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">新增团预购</span><span style="float: right;font-size:16px;"><a href="javascript:history.go(-1)" style="color:#333;">返回</a></span></div>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" name="jsonForm">
    <ul class="m_form fl">
        <li class="clearfix">
            <span>设置团购商品：</span>
            <table class="table_form" cellpadding="0" cellspacing="1" style="width:700px;margin-left:0px;">
                <tr>
                    <th width="150px" class="align_c"><span>产品图片</span></th>
                    <th class="align_c"><span>产品标题</span></th>
                    <th width="90px" class="align_c"><span>原价（元）</span></th>
                    <!--                            <th width="90px" class="align_c"><span>底价（元）</span></th>-->
                </tr>
                <tr>
                    <td class="align_c"><img src="<?php if($itemInfo){echo $productInfo['path'];}?>" style="max-width:120px;" id="productImg" onerror="this.src='images/default/no_pic.jpg'"></td>
                    <td class="align_c"><span id="productTitle"><?php if($itemInfo){echo $productInfo['title'];}?></span></td>
                    <td class="align_c" id="price"><?php if($itemInfo){echo $productInfo['sell_price'];}?></td>
                    <!--                            <td class="align_c"><input type="text" name="low_price" size="6" value="--><?php //if($itemInfo){echo $itemInfo['low_price'];}?><!--" valid="required|isMoney" errmsg="最低价不能空|价格格式有误"></td>-->
                </tr>
                <td colspan="4">
                    <button class="button_style" type="button" onclick="javascript:window.open('index.php/seller/my_get_product_selector', 'add', 'top=100, left=200, width=900, height=400, scrollbars=1, resizable=yes');"><span>请选择活动商品</span></button>
                    <label style="color:red;">注： 请选择团购活动商品，每次仅能设置一种商品</label>
                    <input type="hidden" name="product_id" value="<?php if($itemInfo){echo $itemInfo['product_id'];}?>" id="productId" onchange="selectProduct()" valid="required" errmsg="请选择商品">
                </td>
            </table>
        </li>
        <li class="clearfix">
            <span>团购活动方式：</span>
            <input onclick="$('#type_0').show();$('#type_1').hide();" type="radio" value="0" name="type" class="radio_style" <?php if($itemInfo){ echo $itemInfo['type']==0 ? 'checked' : '';}else{ echo "checked";} ?>> 叠加优惠金额
            <input onclick="$('#type_1').show();$('#type_0').hide();" type="radio" value="1" name="type" class="radio_style" <?php if($itemInfo){ echo $itemInfo['type']==1 ? 'checked' : '';} ?>> 固定优惠金额
        </li>
        <li class="clearfix" id="type_0"  <?php if ($itemInfo && $itemInfo['type']){ ?>style="display: none" <?php } ?>>
            <span>团购规则：</span>
            <table class="table_form" cellpadding="0" cellspacing="1" style="width:400px;margin-left:0px;">
                <tr>
                    <th class="align_c"><span>区间</span></th>
                    <th width="80px" class="align_c"><span>价格(元)</span></th>
                    <th width="60px" class="align_c"><span>操作</span></th>
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
                                <a href="javascript:void(0);" onclick="$(this).parent().parent().remove();" style="color: red">删除</a>
                            </td>
                        </tr>
                    <?php }}?>
                <tr  id="firstRow">
                    <td colspan="3"><button type="button" class="button_style" id="addPtrule" style="margin-top:10px;"><span style="width: 37px">添加</span></button></td>
                </tr>
            </table>
        </li>
        <li class="clearfix" id="type_1" <?php if (empty($itemInfo) || !$itemInfo['type']){ ?>style="display: none" <?php } ?>>
            <span>固定团购价格：</span>
            <input type="text" size="10" name="sale_price" value="<?php if($itemInfo){echo $itemInfo['sale_price'];}?>" valid="isMoney" errmsg="固定团购价格格式有误" class="input_txt">&nbsp;元
        </li>
        <li class="clearfix">
            <span>定金：</span>
            <input type="text" size="10" name="deposit" value="<?php if($itemInfo){echo $itemInfo['deposit'];}?>" valid="required|isMoney" errmsg="请输入定金|定金格式有误" class="input_txt">&nbsp;元
        </li>
        <li class="clearfix">
            <span>最少团购人数：</span>
            <input type="text" size="10" name="min_number" value="<?php if($itemInfo){echo $itemInfo['min_number'];}?>" valid="required|isInt" errmsg="请输入最少团购人数|最少团购人数格式有误" class="input_txt">
            <font style="font-size: 14px"> 满足最少人数即可成团,否则团购失败</font>
        </li>
        <li class="clearfix">
            <span>最多团购人数：</span>
            <input type="text" size="10"  name="max_number" value="<?php if($itemInfo){echo $itemInfo['max_number'];}?>" valid="required|isInt" errmsg="请输入最多团购人数|最多团购人数格式有误" class="input_txt">
            <font style="font-size: 14px">  达到此数量，团购活动自动结束。0表示没有数量限制。</font>
        </li>
        <li class="clearfix">
            <span>活动时间：</span>
            <input name="start_time" value="<?php if($itemInfo){echo date('Y-m-d H:i:s',$itemInfo['start_time']);}?>" id="start_time" size="20"  class="input_txt" type="text" valid="required" errmsg="团购活动开始时间不能为空" readonly="readonly">
            <font style="font-size: 14px;float: left;margin-right: 20px">至</font>
            <input name="end_time" id="end_time" size="20" value="<?php if($itemInfo){echo date('Y-m-d H:i:s',$itemInfo['end_time']);}?>" class="input_txt" type="text" valid="required" errmsg="团购活动结束时间不能为空" readonly="readonly">
        </li>
        <li class="clearfix">
            <span>是否开启团购：</span>
            <input type="radio" value="0" name="is_open" class="radio_style" <?php if($itemInfo){ echo $itemInfo['is_open']==0 ? 'checked' : '';}else{ echo "checked";} ?>> 关闭
            <input type="radio" value="1" name="is_open" class="radio_style" <?php if($itemInfo){ echo $itemInfo['is_open']==1 ? 'checked' : '';} ?>> 开启
        </li>
    </ul>
    <div class="clear"></div>
    <div style="margin:20px 0px 20px 200px; clear:both; display:block;">
        <a href="javascript:void(0);" class="b_btn" onclick="$('#jsonForm').submit();">确认提交</a>
    </div>
</form>
<br/><br/>
<script>
    $(function(){
        $('#start_time').calendar({ maxDate:'#end_time', format:'yyyy-MM-dd HH:mm:ss' });
        $('#end_time').calendar({ minDate:'#start_time', format:'yyyy-MM-dd HH:mm:ss' });
    });

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
                       <a href="javascript:void(0);" onclick="$(this).parent().parent().remove();" style="color: red">删除</a>\
                  </td></tr>';
        $("#firstRow").before(html);
    });
</script>