<?php echo $tool; ?>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="70">选中</th>
<th>皮革名称</th>
<th width="150">类别</th>
</tr>
<?php if (! empty($item_list)): ?>
<?php foreach ($item_list as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background=''">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"> <?php echo $value['id']; ?></td>
<td class="align_c"><?php echo $value['leather_name']; ?></td>
<td class="align_c"><?php echo $value['tag']; ?></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div class="button_box">
<span style="width: 60px;"><a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
<a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a></span>
<select class="input_blur" name="select_display" id="select_display" onchange="#">
<option value="">选择状态</option>
<option value="1">通过</option>
<option value="0">拒绝</option>
</select>
</div>
<br/><br/>