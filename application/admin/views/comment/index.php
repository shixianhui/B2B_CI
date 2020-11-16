<?php echo $tool; ?>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
    <caption>信息管理</caption>
    <tbody>
        <tr class="mouseover">
            <th width="70">选中</th>
            <th width="150">订单号</th>
            <th width="200">商品名称</th>
            <th width="50">类型</th>
            <th>评论内容</th>
            <th width="200">评论人</th>
            <th width="50">状态</th>
            <th width="70">管理操作</th>
        </tr>
<?php if (! empty($item_list)): ?>
<?php foreach ($item_list as $key=>$value): ?>
            <tr id="id_<?php echo $value['id'] ?>"  onMouseOver="this.style.backgroundColor = '#ECF7FE'" onMouseOut="this.style.background = ''">
                <td><input  class="checkbox_style" name="ids" value="<?php echo $value['id'];?>" type="checkbox"> <?php echo $value['id']; ?></td>
                <td class="align_c"><?php echo $value['order_number'];?></td>
                <td class="align_c"><?php echo $value['product_title'];?></td>
                <td class="align_c"><?php echo $evaluate_arr[$value['evaluate']];?></td>
                <td class="align_c"><?php echo $value['content'] ? $value['content']:'此用户未填写评论';?></td>
                <td class="align_c">
                    用户名：<?php echo $value['username'];?><br>
                    用户id：<?php echo $value['user_id'];?><br>
                </td>
                <td class="align_c"><?php echo $value['display']?'显示':'<font color="#FF0000">隐藏</font>'; ?></td>
                <td class="align_c">
                   <a href="admincp.php/<?php echo $table; ?>/save/<?php echo $value['id']; ?>">查看</a>
                </td>
            </tr>
<?php endforeach; ?>
<?php endif; ?>
    </tbody>
</table>
<div class="button_box">
    <span style="width: 60px;">
        <a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
        <a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a>
    </span>
    <input class="button_style" name="delete" value=" 删除 "  type="button">
<select class="input_blur" name="select_display" id="select_display" onchange="#">
<option value="">选择状态</option>
<option value="1">显示</option>
<option value="0">隐藏</option>
</select>
</div>
<div id="pages" style="margin-top: 5px;">
    <?php echo $pagination; ?>
    <a>总条数：<?php echo $paginationCount;  ?></a>
    <a>总页数：<?php echo $pageCount;  ?></a>
</div>
<br/>
<br/>
<script>
            $("input[name=delete]").click(function () {
        var con = confirm("你确定要删除数据吗？删除后将不可恢复！");
        if (con == true) {
            $ids = "";
            $("input[name='ids']:checked").each(function (i, n) {
                $ids += $(this).val() + ",";
            });
            if (!$ids) {
                alert("请选定值!");
                return false;
            }
            $.post(base_url + "admincp.php/" + controller + "/delete",
                    {"ids": $ids.substr(0, $ids.length - 1)
                    },
            function (res) {
                if (res.success) {
                    for (var i = 0, data = res.data.ids, len = data.length; i < len; i++) {
                        $("#id_" + data[i]).remove();
                    }
                    return false;
                } else {
                    alert(res.message);
                    return false;
                }
            },
                    "json"
                    );
        }
    });
</script>