<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <table class="table_form" cellpadding="0" cellspacing="1">
        <caption>信息查询</caption>
        <tbody>
        <tr>
            <td class="align_c">
                订单号 <input class="input_blur" name="order_num" id="order_num" size="20" type="text">&nbsp;
                申请人会员名 <input class="input_blur" name="username" id="username" size="20" type="text">&nbsp;
                <select class="input_blur" name="status">
                    <option value="">选择状态</option>
                    <?php if ($status_arr) { ?>
                        <?php foreach ($status_arr as $key=>$value) { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php }} ?>
                </select>&nbsp;
                发布时间 <input class="input_blur" name="inputdate_start" id="inputdate_start" size="10" readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
                    date = new Date();
                    Calendar.setup({
                        inputField     :    "inputdate_start",
                        ifFormat       :    "%Y-%m-%d",
                        showsTime      :    false,
                        timeFormat     :    "24"
                    });
                </script> - <input class="input_blur" name="inputdate_end"
                                   id="inputdate_end" size="10"  readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
                    date = new Date();
                    Calendar.setup({
                        inputField     :    "inputdate_end",
                        ifFormat       :    "%Y-%m-%d",
                        showsTime      :    false,
                        timeFormat     :    "24"
                    });
                </script>&nbsp;
                <input class="button_style" name="dosubmit" value=" 查询 " type="submit">
            </td>
        </tr>
        </tbody>
    </table>
</form>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
    <caption>信息管理</caption>
    <tbody>
    <tr class="mouseover">
        <th width="70">选中</th>
        <th width="120">退款订单号</th>
        <th width="80">退款金额</th>
        <th width="150">退款原因</th>
        <th>退款说明</th>
        <th width="80">申请时间</th>
        <th width="80">申请人</th>
        <th width="120">状态</th>
        <th width="70">管理操作</th>
    </tr>
    <?php if (! empty($item_list)): ?>
        <?php foreach ($item_list as $key=>$value): ?>
            <tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background='#FFFFFF'">
                <td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"> <?php echo $value['id']; ?></td>
                <td class="align_c"><?php echo $value['order_num']; ?></td>
                <td class="align_c"><?php echo $value['price']; ?></td>
                <td class="align_c"><?php echo $exchange_reason_arr[$value['exchange_reason_id']]; ?></td>
                <td class="align_c"><?php echo $value['content']; ?></td>
                <td class="align_c"><?php echo date("Y-m-d H:i:s", $value['add_time']); ?></td>
                <td class="align_c">
                    <?php echo $value['username']; ?>
                    <br/>
                    （ID:<?php echo $value['user_id']; ?>）
                </td>
                <td class="align_c"><?php echo $status_arr[$value['status']]; ?></td>
                <td class="align_c"><a href="admincp.php/<?php echo $table; ?>/save/<?php echo $value['id']; ?>">处理</a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
<div class="button_box">
<span style="width: 60px;"><a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
<a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a></span>
    <input class="button_style" name="delete" id="delete" value=" 删除 "  type="button">
</div>
<div id="pages" style="margin-top: 5px;">
    <?php echo $pagination; ?>
    <a>总条数：<?php echo $paginationCount; ?></a>
    <a>总页数：<?php echo $pageCount; ?></a>
</div>
<br/><br/>