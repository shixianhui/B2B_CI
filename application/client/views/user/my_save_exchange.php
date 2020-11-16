
<style>
    .m_form {
        background: #fafafa;
    }
    .m_form li span{
        width:130px;
    }
    .m_good_picdif img {
        width: 88px;
        height: 88px;
    }
    .m_buyermess {
        width: 100%;
    }
    .m_buyermess thead {
        height: 38px;
        line-height: 38px;
        background: #f5f5f5;
        border-bottom: 1px solid #e0e0e0;
    }
    .m_buyermess td {
        text-align: center;
    }
    .m_goodlist {
        padding: 20px 0 0 0;
    }
    .m_goodlist p {
        width: 220px;
        line-height: 25px;
        height: 38px;
        font-size: 14px;
        color: #338cc4;
    }
    .m_good_pic {
        width: 73px;
        height: 73px;
        border: 1px solid #e0e0e0;
        display: inline-block;
        margin-left: 20px;
        margin-right: 20px;
    }
    .load {
    background: #fff none repeat scroll 0 0;
    left: 0;
    margin-top: -11px;
    opacity: 0.7;
    padding-left: 0px;
    position: absolute;
    top: 0;
    width: 63px;
}
.but_4 {
    background: #cc0011 none repeat scroll 0 0;
    border-radius: 6px;
    color: #fff;
    display: inline-block;
    font: 1.2em/32px "微软雅黑";
    height: 32px;
    margin-left: 10px;
    padding: 0 10px;
    position: relative;
}
</style>
<div class="warp">
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">申请退款/退货</span></div>
            <div class="member_tab mt20">
                <table class="m_buyermess">
                    <thead>
                    <tr>
                        <td width="40%">退款商品信息</td>
                        <td width="10%">价格（元）</td>
                        <td width="10%">数量</td>
                        <td width="10%">交易金额</td>
                        <td width="20%">订单编号</td>
                        <td width="10%">订单状态</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($orders_detail_info){
                            $url = getBaseUrl($html, "", "product/detail/{$orders_detail_info['product_id']}.html", $client_index);
                            ?>
                            <tr>
                                <td width="40%">
                                    <div  class="m_goodlist clearfix">
                                        <a href="<?php echo $url; ?>"  target="_blank" class="m_good_pic m_good_picdif fl"><img src="<?php if ($orders_detail_info['path']) { echo preg_replace('/\./', '_thumb.', $orders_detail_info['path']);}else{echo 'images/default/load.jpg';} ?>" /></a>
                                        <p class="fl">
                                            <a href="<?php echo $url; ?>" target="_blank"><?php echo $orders_detail_info['product_title']; ?></a>
                                        </p>
                                    </div>
                                </td>
                                <td width="10%">
                                    <div class="m_money">
                                        <em>￥<?php echo $orders_detail_info['buy_price'];  ?></em>
                                    </div>
                                </td>
                                <td width="10%">
                                    <div class="m_price">
                                        <p><?php echo $orders_detail_info['buy_number']; ?></p>
                                    </div>
                                </td>
                                    <td width="10%">
                                        <div class="m_no">
                                            <em>￥<?php echo $orders_detail_info['price_total']; ?></em>
                                        </div>
                                    </td>
                                    <td width="20%">
                                        <div class="m_no">
                                            <em><?php if ($orders_info) { echo $orders_info['order_number']; } ?></em>
                                        </div>
                                    </td>
                                    <td width="10%">
                                        <div class="m_price">
                                            <p><?php if ($orders_info) { echo $status_arr[$orders_info['status']]; } ?></p>
                                        </div>
                                    </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                   <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="jsonForm" name="jsonForm" method="post">
                            <ul class="m_form" >
                                <li class="clearfix">
                                    <span><font color="red">*</font>退款原因：</span>
                                    <select name="exchange_reason_id" valid="required" errmsg="请选择退款原因" style="position: relative;top: 5px;">
                                        <option value="">--请选择退款原因--</option>
                                        <?php if ($exchange_reason_arr) { ?>
                                            <?php foreach ($exchange_reason_arr as $key=>$value) {
                                                $selector = '';
                                                if ($exchange_info) {
                                                    if ($exchange_info['exchange_reason_id'] == $key) {
                                                        $selector = 'selected="selected"';
                                                    }
                                                }
                                                ?>
                                                <option <?php echo $selector; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php }} ?>
                                    </select>
                                </li>
                                <li class="clearfix"><span>退款金额：</span><input value="<?php if ($exchange_info) {echo $exchange_info['price'];}else{ if ($orders_detail_info) {echo $orders_detail_info['price_total'];}} ?>" id="price" name="price" valid="required" errmsg="退款金额" type="text" style="margin-left:0px;width:80px;"/> 元</li>
                                <li class="clearfix">
                                    <span><font color="red">*</font>详细原因描述：</span>
                                    <textarea cols="36" rows="3" id="content" name="content" valid="required" errmsg="详细原因描述不能为空"><?php if ($exchange_info) {echo $exchange_info['content'];} ?></textarea>
                                </li>
                                <li class="clearfix">
                                    <span><font color="red">*</font>上传凭证图片：</span>
                                    <div id="pic_list">
                                    <?php if ($attachment_list) { ?>
                                    <?php foreach ($attachment_list as $key=>$value) { ?>
                                    <div style="float: left;width:70px;height;80px;text-align:center;position:relative;">
                                    <img style="padding: 2px; border:1px solid #CCC;float:left;" id="path_src" width="60px" height="60px" src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>">
                                    <input type="hidden" name="batch_path_ids[]" value="<?php echo $value['id']; ?>" />
                                    <img onclick="javascript:del_pice(this);" style="cursor: pointer;position:absolute;right:10px;" src="images/default/close_1.gif">
                                    </div>
                                        <?php }} ?>
                                    </div>
                                    <a style="position:relative;" >
				    <span style="cursor:pointer;text-align:center;color:#fff;" class="but_4">上传凭证图片<input style="left:0px;top:0px; background:#000; width:105px;height:35px;line-height:30px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="path_file" name="path_file[]" multiple="multiple"></span>
				    <i class="load" id="path_load" style="cursor:pointer;display:none;width:130px;position: relative;left: -87px;"><img src="images/default/loading_2.gif" width="32" height="32"></i>
				    </a>
                                </li>

                                <li class="clearfix"><span>&nbsp;</span><input type="submit" value="<?php if ($exchange_info) {echo '重新提交申请';}else{echo '提交申请';} ?>" style="border:none;" class="btn_r"></li>
                            </ul>
                    </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
</script>
<script type="text/javascript">
    function del_pice(obj) {
        $(obj).parent().remove();
    }
    //参数mulu
    $(function () {
        //形象照片
        $("input[name='path_file[]']").wrap("<form id='path_upload' action='<?php echo base_url(); ?>index.php/upload/batch_uploadImage' method='post' enctype='multipart/form-data'></form>");
        $("#path_file").change(function(){ //选择文件
            $("#path_upload").ajaxSubmit({
                dataType:  'json',
                data: {
                    'model': 'exchange',
                    'field': 'path_file'
                },
                beforeSend: function() {
                    $("#path_load").show();
                },
                uploadProgress: function(event, position, total, percentComplete) {
                },
                success: function(res) {
                    $("#path_load").hide();
                    if (res.success) {
                        var html = '';
                        for(var i = 0; i < res.data.length; i++) {
                            html += '<div style="float: left;width:70px;height;80px;text-align:center;position:relative;">';
                            html += '<img src="'+res.data[i].file_path.replace('.', '_thumb.')+'" width="60px" height="60px" style="padding: 2px; border:1px solid #CCC;float:left;"/>';
                            html += '<input type="hidden" name="batch_path_ids[]" value="'+res.data[i].id+'" />';
                            html += '<img onclick="javascript:del_pice(this);" style="cursor: pointer;position:absolute;right:10px;" src="images/default/close_1.gif">';
                            html += '</div>';
                        }
                        $("#pic_list").append(html);
                    } else {
                        return my_alert('fail', 0, res.message);
                    }
                },
                error:function(xhr){
                }
            });
        });
    });
</script>
<!--<script type="text/javascript" language="javascript" src="js/default/main.js"></script>-->

