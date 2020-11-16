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
</style>
<div class="warp">
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">退款进度</span></div>
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
                                    <div class="m_goodlist clearfix">
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
                                            <em><?php echo $orders_detail_info['price_total']; ?></em>
                                        </div>
                                    </td>
                                    <td width="20%">
                                        <div class="m_no">
                                            <em><?php if ($item_info) { echo $item_info['order_num']; } ?></em>
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
                <ul class="m_form" >
                    <li class="clearfix">
                        <span>退款原因：</span><?php if($item_info){ echo $exchange_reason_arr[$item_info['exchange_reason_id']];} ?>
                    </li>
                    <li class="clearfix"><span>退款金额：</span><?php if ($item_info) {echo $item_info['price'];}else{ if ($orders_info) {echo $orders_info['total'];}} ?> 元</li>
                    <li class="clearfix"><span>订单付款方式：</span><?php if ($item_info) {echo $item_info['payment_title'];} ?></li>
                    <li class="clearfix">
                        <span>详细原因描述：</span><?php if ($item_info) {echo $item_info['content'];} ?>
                    </li>
                    <li class="clearfix">
                        <span>凭证图片：</span>
                        <div id="pic_list">
                            <?php if ($attachment_list) { ?>
                                <?php foreach ($attachment_list as $key=>$value) { ?>
                                    <div style="float: left;width:70px;">
                                        <a data-lightbox="image_list_group_0" data-title="" href="<?php if ($value['path']) {echo $value['path'];}else{echo 'images/default/load.jpg';} ?>">
                                            <img style="padding: 2px; border:1px solid #CCC;float:left;" id="path_src" width="60px" height="60px" src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>">
                                        </a>
                                    </div>
                                <?php }} ?>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span>申请时间：</span><?php if ($item_info) {echo date('Y-m-d H:i:s', $item_info['add_time']);} ?>
                    </li>
                    <li class="clearfix">
                        <span>审核时间：</span><?php if ($item_info) {echo date('Y-m-d H:i:s', $item_info['update_time']);} ?>
                    </li>
                    <?php if ($item_info['admin_remark']){ ?>
                    <li class="clearfix">
                        <span>商家备注：</span><?php echo $item_info['admin_remark']; ?>
                    </li>
                    <?php } ?>
                    <?php if ($item_info['client_remark']){ ?>
                    <li class="clearfix">
                        <span>对用户备注：</span><?php echo $item_info['client_remark']; ?>
                    </li>
                    <?php } ?>
                    <li class="clearfix">
                        <span>退款进度：</span>
                        <?php if ($item_info) {echo $exchange_status_arr[$item_info['status']];} ?>
                        <?php if ($item_info) { ?>
                            <?php if ($item_info['status'] == 0) { ?>
                                <input onclick="javascript:change_check('<?php echo $item_info['id']; ?>','<?php echo $item_info['order_num']; ?>','<?php echo date('Y-m-d H:i:s', $item_info['add_time']); ?>','<?php echo $item_info['price']; ?>');" style="margin-left: 20px;" class="button_style" value="审核" type="button">
                            <?php } else if ($item_info['status'] == 2) { ?>
                                <input onclick="javascript:refund_to_balance('<?php echo $item_info['id']; ?>','<?php echo $item_info['order_num']; ?>','<?php echo date('Y-m-d H:i:s', $item_info['add_time']); ?>','<?php echo $item_info['price']; ?>','<?php echo $item_info['username']; ?>');" style="margin-left: 20px;" class="button_style" value="退款到余额" type="button">
                            <?php } ?>
                        <?php } ?>
                    </li>
                    <li class="clearfix" style="left: 60px">
                        <input type="button" onclick="window.location.reload();" value="刷新" style="width: 50px">
                        <input type="button" onclick="history.go(-1);" value="返回" style="width: 50px">
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="js/default/index.js" type="text/javascript"></script>
<script  type="text/javascript">
    function change_check(id, order_num, add_time, total) {
        var html = '<table class="table_form" cellpadding="0" cellspacing="1">';
        html += '<tr><th width="30%"><strong>退款订单编号</strong> <br/></th>';
        html += '<td>'+order_num+'</td></tr>';
        html += '<tr><th width="30%"><strong>申请时间</strong> <br/></th>';
        html += '<td>'+add_time+'</td></tr>';
        html += '<tr><th width="30%"><strong>退款金额</strong> <br/></th>';
        html += '<td>'+total+' 元</td></tr>';
        html += '<tr><th width="30%"><font color="red">*</font> <strong>审核状态</strong><br/></th>';
        html += '<td>';
        html += '<label><input type="radio" value="2" name="status" class="radio_style"> 审核通过</label>';
        html += '&nbsp;<label><input type="radio" value="1" name="status" class="radio_style"> 审核未通过</label>';
        html += '</td>';
        html += '</tr>';
        html += '<tr><th width="30%"><strong>备注</strong><br/><font color="red">[会员看的]</font></th>';
        html += '<td>';
        html += '<textarea maxlength="140" id="client_remark" rows="4" cols="30"  class="textarea_style"></textarea>';
        html += '</td>';
        html += '</tr>';
        html += '<tr><th width="30%"> <strong>备注</strong><br/><font color="red">[管理员看的]</font></th>';
        html += '<td>';
        html += '<textarea maxlength="140" id="admin_remark" rows="4" cols="30"  class="textarea_style"></textarea>';
        html += '</td>';
        html += '</tr>';
        html += '</table>';
        var d = dialog({
            width:350,
            fixed: true,
            title: '退款审核提示',
            content: html,
            okValue: '确认',
            ok: function () {
                var status = $('input[name="status"]:checked').val();
                var client_remark = $('#client_remark').val();
                var admin_remark = $('#admin_remark').val();
                if (!status) {
                    return my_alert('fail', 0, '请选择状态');
                }
                if (status == 1) {
                    if (!client_remark) {
                        return my_alert('client_remark', 1, '备注不能为空');
                    }
                    if (!admin_remark) {
                        return my_alert('admin_remark', 1, '备注不能为空');
                    }
                }
                $.post(base_url+"index.php/"+controller+"/change_check",
                    {	"id": id,
                        "status":status,
                        "client_remark":client_remark,
                        "admin_remark":admin_remark
                    },
                    function(res){
                        if(res.success){
                            return my_alert_flush('fail', 0, res.message);
                        } else {
                            if (res.field == 'fail') {
                                return my_alert('fail', 0, res.message);
                            } else {
                                return my_alert(res.field, 1, res.message);
                            }
                        }
                    },
                    "json"
                );
                return false;
            },
            cancelValue: '取消',
            cancel: function () {
            }
        });
        d.show();
    }

    function refund_to_balance(id, order_num, add_time, total, username) {
//        var html = '<font color="red">注：尽量使用【原路返回退款】进行退款，【退款到余额】只在第三方支付过了退款期了，才用这个方法</font>';
        var html = '';
        html += '<table class="table_form" cellpadding="0" cellspacing="1">';
        html += '<tr><th width="30%"><strong>退款订单编号</strong> <br/></th>';
        html += '<td>'+order_num+'</td></tr>';
        html += '<tr><th width="30%"><strong>申请时间</strong> <br/></th>';
        html += '<td>'+add_time+'</td></tr>';
        html += '<tr><th width="30%"><strong>退款金额</strong> <br/></th>';
        html += '<td>'+total+' 元</td></tr>';
        html += '<tr><th width="30%"><strong>申请人</strong> <br/></th>';
        html += '<td>'+username+'</td></tr>';
        html += '</table>';
        var d = dialog({
            width:350,
            fixed: true,
            title: '退款到余额提示',
            content: html,
            okValue: '确认退款到余额',
            ok: function () {
                $.post(base_url+"index.php/"+controller+"/refund_to_balance",
                    {	"id": id
                    },
                    function(res){
                        if(res.success){
                            return my_alert_flush('fail', 0, res.message);
                        } else {
                            if (res.field == 'fail') {
                                return my_alert('fail', 0, res.message);
                            } else {
                                return my_alert(res.field, 1, res.message);
                            }
                        }
                    },
                    "json"
                );
                return false;
            },
            cancelValue: '取消',
            cancel: function () {
            }
        });
        d.show();
    }

    function refund_to_third(id, order_num, add_time, total, username) {
        var html = '<table class="table_form" cellpadding="0" cellspacing="1">';
        html += '<tr><th width="30%"><strong>退款订单编号</strong> <br/></th>';
        html += '<td>'+order_num+'</td></tr>';
        html += '<tr><th width="30%"><strong>申请时间</strong> <br/></th>';
        html += '<td>'+add_time+'</td></tr>';
        html += '<tr><th width="30%"><strong>退款金额</strong> <br/></th>';
        html += '<td>'+total+' 元</td></tr>';
        html += '<tr><th width="30%"><strong>申请人</strong> <br/></th>';
        html += '<td>'+username+'</td></tr>';
        html += '</table>';
        var d = dialog({
            width:350,
            fixed: true,
            title: '原路返回退款提示',
            content: html,
            okValue: '确认原路返回退款',
            ok: function () {
                $.post(base_url+"index.php/"+controller+"/refund_to_third",
                    {	"id": id
                    },
                    function(res){
                        if(res.success){
                            return my_alert_flush('fail', 0, res.message);
                        } else {
                            if (res.field == 'fail') {
                                return my_alert('fail', 0, res.message);
                            } else {
                                return my_alert(res.field, 1, res.message);
                            }
                        }
                    },
                    "json"
                );
                return false;
            },
            cancelValue: '取消',
            cancel: function () {
            }
        });
        d.show();
    }
</script>

<link rel="stylesheet" href="js/admin/lightbox2-master/src/css/lightbox.css">
<script src="js/admin/lightbox2-master/src/js/lightbox.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 300,
        'wrapAround': true,
        'positionFromTop': 200
    })
</script>