<?php echo $tool; ?>
<form name="search" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>信息查询</caption>
<tbody>
<tr>
<td class="align_c">
<select name="condition" id="condition">
<option value="username" <?php if ($condition == "username"){echo 'selected="selected"';} ?>>用户名</option>
<option value="nickname" <?php if ($condition == "nickname"){echo 'selected="selected"';} ?>>昵称</option>
<option value="real_name" <?php if ($condition == "real_name"){echo 'selected="selected"';} ?>>真实姓名</option>
</select>
<input class="input_blur" name="fields" id="fields" value="<?php echo $fields; ?>" size="20" type="text">&nbsp;
<input class="button_style" name="dosubmit" value=" 查询 " type="submit">
</td>
</tr>
</tbody></table>
</form>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="70">选中</th>
<th>用户名</th>
<th width="150">所属部门</th>
<th width="100">身份</th>
<th width="100">昵称</th>
<th width="100">真实姓名</th>
<th width="100">QQ</th>
<th width="200">邮件</th>
<th width="70">管理操作</th>
</tr>
<?php if (! empty($item_list)): ?>
<?php foreach ($item_list as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background='#FFFFFF'">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"> <?php echo $value['id']; ?></td>
<td><?php echo $value['username']; ?></td>
<td class="align_c"><?php echo $value['group_name']; ?></td>
<td class="align_c"><?php echo $value['is_boss']?'部门经理':'员工'; ?></td>
<td class="align_c"><?php echo $value['nickname']; ?></td>
<td class="align_c"><?php echo $value['real_name']; ?></td>
<td class="align_c"><?php echo $value['qq_number']; ?></td>
<td class="align_c"><?php echo $value['email']; ?></td>
<td class="align_c"><a href="admincp.php/<?php echo $table; ?>/save/<?php echo $value['id']; ?>">修改</a></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div class="button_box">
<span style="width: 60px;"><a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
<a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a></span>
<input class="button_style" name="delete" id="delete" value=" 删除 "  type="button">
批量移动至：
<select class="input_blur" name="category_id" id="category_id" onchange="#">
<option value="">--选择管理组--</option>
<?php if (! empty($admingroup_list)): ?>
<?php foreach ($admingroup_list as $admingroup): ?>
<option value="<?php echo $admingroup['id'] ?>" ><?php echo $admingroup['group_name'] ?></option>
<?php endforeach; ?>
<?php endif; ?>
</select>
</div>
<div id="pages" style="margin-top: 5px;">
<?php echo $pagination; ?>
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
</div>