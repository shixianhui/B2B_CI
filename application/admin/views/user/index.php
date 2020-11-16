<?php echo $tool; ?>
<form name="search" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>信息查询</caption>
<tbody>
<tr>
<td class="align_c">
编号 <input class="input_blur" name="id" id="id" size="10" type="text">
用户名 <input class="input_blur" name="username" id="username" size="10" type="text">
昵称 <input class="input_blur" name="nickname" id="nickname" size="10" type="text">
姓名 <input class="input_blur" name="real_name" id="real_name" size="10" type="text">
<select name="category_id">
<option value="">--选择管理组--</option>
<?php if (! empty($user_group_list)): ?>
<?php foreach ($user_group_list as $item): ?>
<option value="<?php echo $item['id'] ?>" ><?php echo $item['group_name'] ?></option>
<?php endforeach; ?>
<?php endif; ?>
</select>
<select class="input_blur" name="display">
<option value="">选择状态</option>
<option value="1">开启</option>
<option value="0">禁用</option>
</select>&nbsp;
添加时间 <input class="input_blur" name="inputdate_start" id="inputdate_start" size="10" readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
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
<th>用户名</th>
<th width="100">会员级别</th>
<th width="120">会员信息</th>
<th width="80">积分</th>
<th width="80">余额</th>
<th width="80">添加时间</th>
<th width="80">状态</th>
<th width="120">管理操作</th>
</tr>
<?php if (! empty($user_list)): ?>
<?php foreach ($user_list as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background=''">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"> <?php echo $value['id']; ?></td>
<td><a title="查看详情" href="admincp.php/user/view/<?php echo $value['id']; ?>" ><?php echo $value['username']; ?> [查看]</a></td>
<td class="align_c"><?php echo $value['group_name']; ?></td>
<td>
姓名：<?php echo $value['real_name']; ?><br/>
昵称：<?php echo $value['nickname']; ?><br/>
手机：<?php echo $value['mobile']; ?>
</td>
<td class="align_c"><?php echo $value['score']; ?></td>
<td class="align_c"><?php echo number_format($value['total'], 2, '.', ''); ?></td>
<td class="align_c"><?php echo date('Y-m-d H:i:s', $value['add_time']); ?></td>
<td class="align_c"><?php echo $value['display']?'开启':'<font color="#FF0000">禁用</font>'; ?></td>
<td class="align_c">
<a href="admincp.php/financial/recharge/<?php echo $value['id']; ?>">充值</a>
<a href="admincp.php/financial/debit/<?php echo $value['id']; ?>">扣款</a><br/>
<a href="admincp.php/financial/index/<?php echo $value['id']; ?>">财务记录</a>
<a href="admincp.php/user/save/<?php echo $value['id']; ?>">修改</a>
</td>
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
<select name="category_id" id="category_id" onchange="#">
<option value="">--选择管理组--</option>
<?php if (! empty($user_group_list)): ?>
<?php foreach ($user_group_list as $item): ?>
<option value="<?php echo $item['id'] ?>" ><?php echo $item['group_name'] ?></option>
<?php endforeach; ?>
<?php endif; ?>
</select>
<select class="input_blur" name="select_display" id="select_display" onchange="#">
<option value="">选择状态</option>
<option value="1">开启</option>
<option value="0">禁用</option>
</select>
</div>
<div id="pages" style="margin-top: 5px;">
<?php echo $pagination; ?>
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
</div>
<br/><br/>