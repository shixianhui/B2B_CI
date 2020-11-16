<style>

    .in {
        width: 60px;
        height: 60px;
    }
</style>
<?php echo $tool; ?>
<table class="table_form" cellpadding="0" cellspacing="1">
    <caption>基本信息</caption>
    <tbody>
    <tr>
        <th width="20%"><strong>退款订单号</strong> <br/>
        </th>
        <td>
            <?php if(! empty($item_info)){ echo $item_info['order_num'];} ?>
            <?php if ($item_info) { ?>
                <a href="admincp.php/orders/view/<?php echo $item_info['orders_id']; ?>">查看</a>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <th width="20%"><strong>订单付款方式</strong> <br/>
        </th>
        <td>
            <?php if ($item_info) {echo $item_info['payment_title'];} ?>
        </td>
    </tr>
    <tr>
        <th width="20%"><strong>申请人</strong> <br/>
        </th>
        <td>
            <?php if(! empty($item_info)){ echo $item_info['username'];} ?>
            <?php if ($item_info) { ?>
                <a href="admincp.php/user/save/<?php echo $item_info['user_id']; ?>">查看</a>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <th width="20%"><strong>退款金额</strong> <br/>
        </th>
        <td>
            <?php if(! empty($item_info)){ echo $item_info['price'];} ?> 元
        </td>
    </tr>
    <tr>
        <th width="20%"><strong>退款原因</strong> <br/>
        </th>
        <td>
            <?php if(! empty($item_info)){ echo $exchange_reason_arr[$item_info['exchange_reason_id']];} ?>
        </td>
    </tr>
    <tr>
        <th width="20%"> <strong>退款说明</strong> <br/>
        </th>
        <td>
            <?php if(! empty($item_info)){ echo str_replace(array("\r\n", "\n", "\r"), '<br/>', $item_info['content']);} ?>
        </td>
    </tr>
    <tr>
        <th width="20%"> <strong>凭证图片</strong> <br/>
        </th>
        <td>
            <?php if ($attachment_list) { foreach ($attachment_list as $key=>$value) { ?>
                <a data-lightbox="image_list_group_0" data-title="" href="<?php if ($value['path']) {echo $value['path'];}else{echo 'images/admin/no_pic.png';} ?>"><img src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>" class="in"></a>
            <?php }} ?>
        </td>
    </tr>
    <tr>
        <th width="20%">
            <strong>申请时间</strong> <br/>
        </th>
        <td>
            <?php if(! empty($item_info)){ echo date('Y-m-d H:i:s', $item_info['add_time']);} ?>
        </td>
    </tr>
    <?php if ($item_info && $item_info['update_time'] > 0) { ?>
        <tr>
            <th width="20%">
                <strong>最后处理时间</strong> <br/>
            </th>
            <td>
                <?php echo date('Y-m-d H:i:s', $item_info['update_time']); ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($item_info['admin_remark']){ ?>
    <tr>
        <th width="20%"><strong>商家备注</strong> <br/>
        </th>
        <td>
            <?php echo $item_info['admin_remark']; ?>
        </td>
    </tr>
    <?php } ?>
    <?php if ($item_info['client_remark']){ ?>
    <tr>
        <th width="20%"><strong>对用户备注</strong> <br/>
        </th>
        <td>
            <?php echo $item_info['client_remark']; ?>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <th width="20%">
            <strong>当前处理状态</strong> <br/>
        </th>
        <td>
            <?php if(! empty($item_info)){ echo $status_arr[$item_info['status']];} ?>
            <?php if ($item_info) { ?>
                <?php if ($item_info['status'] == 0 || $item_info['status'] == 1) { ?>
                    <input onclick="javascript:change_check('<?php echo $item_info['id']; ?>','<?php echo $item_info['order_num']; ?>','<?php echo date('Y-m-d H:i:s', $item_info['add_time']); ?>','<?php echo $item_info['price']; ?>');" style="margin-left: 20px;" class="button_style" value="强制审核" type="button">
                <?php } else if ($item_info['status'] == 2) { ?>
                    <input onclick="javascript:refund_to_balance('<?php echo $item_info['id']; ?>','<?php echo $item_info['order_num']; ?>','<?php echo date('Y-m-d H:i:s', $item_info['add_time']); ?>','<?php echo $item_info['price']; ?>','<?php echo $item_info['username']; ?>');" style="margin-left: 20px;" class="button_style" value="强制退款到余额" type="button">
                <?php } ?>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <input onclick="javascrpt:window.location.reload();" class="button_style" name="dosubmit" value=" 刷新 " type="button">
            <input style="margin-left: 20px;" onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
        </td>
    </tr>
    </tbody>
</table>
<br/><br/>
<script src="js/admin/index.js" type="text/javascript"></script>
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
                $.post(base_url+"admincp.php/"+controller+"/change_check",
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
                $.post(base_url+"admincp.php/"+controller+"/refund_to_balance",
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
                $.post(base_url+"admincp.php/"+controller+"/refund_to_third",
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
        'resizeDuration': 500,
        'wrapAround': true,
        'positionFromTop': 200
    })
</script>