<?php echo $tool; ?>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="70">选中</th>
<th width="60">首字母</th>
<th>品牌名称</th>
<th width="150">类别</th>
<th width="100">品牌Logo</th>
</tr>
<?php if (! empty($item_list)): ?>
<?php foreach ($item_list as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background=''">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"> <?php echo $value['id']; ?></td>
<td class="align_c"><?php echo strtoupper($value['first_letter']); ?></td>
<td class="align_c"><?php echo $value['brand_name']; ?></td>
<td class="align_c"><?php echo $value['tag']; ?></td>
<td class="align_c"><img src="<?php if ($value['path']){echo preg_replace('/\./', '_thumb.', $value['path']);} ?>" onerror="javascript:this.src='images/admin/no_pic.png';" width="20" height="20" /></td>
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