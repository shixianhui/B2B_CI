<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
    <table class="table_form" cellpadding="0" cellspacing="1">
        <caption>搜索关键词</caption>
        <tbody>
            <tr>
                <th width="20%">
                    <strong>普通订单有效时间</strong> <br/>
                </th>
                <td>
                    <input name="" valid="required|isMoney" errmsg="不能为空|金钱格式有误" value="<?php if ($itemInfo) {echo $itemInfo['free_postage'];} ?>" size="20"  class="input_blur" type="text"> 元
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
                    &nbsp;&nbsp; <input class="button_style" name="reset" value=" 重置 " type="reset">
                </td>
            </tr>
        </tbody>
    </table>
</form>
<br/><br/>