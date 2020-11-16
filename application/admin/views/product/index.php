<?php echo $tool; ?>
<form name="search" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>信息查询</caption>
<tbody>
<tr>
<td class="align_c">
产品ID <input class="input_blur" name="id" id="id" size="10" type="text">&nbsp;
标题  <input class="input_blur" name="title" id="title" size="20" type="text">&nbsp;
产品编号  <input class="input_blur" name="product_num" id="product_num" size="20" type="text">&nbsp;
    <select class="input_blur" name="select_category_id">
        <option value="">--选择平台产品分类--</option>
        <!-- 一级 -->
        <?php
        if($product_category){
            foreach($product_category as $menu){
                ?>
                <option value="<?php echo $menu['id'];?>"><?php echo $menu['product_category_name'];?></option>
                <!-- 二级 -->
                <?php
                foreach($menu['subMenuList'] as $subMenu){
                    ?>
                    <option value="<?php echo $menu['id'].','.$subMenu['id'];?>">&nbsp;&nbsp;┣<?php echo $subMenu['product_category_name'];?></option>
                <?php }?>
            <?php }}?>
    </select>&nbsp;
<select class="input_blur" name="display">
    <?php if ($display_arr) { ?>
        <?php foreach ($display_arr as $key=>$value) { ?>
            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
        <?php }} ?>
</select>&nbsp;
<select name="custom_attribute">
<option value="">选择属性</option>
<?php if ($attribute_arr) { ?>
<?php foreach ($attribute_arr as $key=>$value) { ?>
<option value="<?php echo $key; ?>"><?php echo $value; ?>[<?php echo $key; ?>]</option>
<?php }} ?>
</select>
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
</tbody></table>
</form>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="70">选中</th>
<th width="50">排序</th>
<th>产品名称</th>
<th width="80">产品编号</th>
<th width="150">平台产品分类</th>
<th width="200">店铺产品分类</th>
<th width="60">销售量</th>
<th width="60">库存</th>
<th width="60">状态</th>
<th width="50">浏览量</th>
<th width="60">发布时间</th>
<th width="70">管理操作</th>
</tr>
<?php if (! empty($item_list)): ?>
<?php foreach ($item_list as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background=''">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"> <?php echo $value['id']; ?></td>
<td class="align_c"><input class="input_blur" name="sort[]" id="sort_<?php echo $value['id']; ?>" value="<?php echo $value['sort']; ?>" size="4" type="text"></td>
<td><?php echo $value['title']; ?><?php if($value['path']){ ?>[<font color="#FF0000">图片</font>]<?php } ?></td>
<td class="align_c"><?php echo $value['product_num']; ?></td>
<td class="align_c"><?php echo $value['category_str']; ?></td>
<td class="align_c"><?php echo $value['product_category_str']; ?></td>
<td class="align_c"><?php echo $value['sales']; ?></td>
<td class="align_c"><?php echo $value['stock']; ?></td>
<td class="align_c"><?php echo $display_arr[$value['display']]; ?></td>
    <td class="align_c"><?php echo $value['hits']; ?></td>
<td class="align_c"><?php echo date("Y-m-d H:i", $value['add_time']); ?></td>
<td class="align_c"><a href="admincp.php/<?php echo $table; ?>/save/<?php echo $value['id']; ?>">修改</a></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div class="button_box">
<span style="width: 60px;"><a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
<a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a></span>
<input class="button_style" name="list_order" id="list_order" value=" 排序 "  type="button">
<input class="button_style" name="delete" id="delete" value=" 删除 "  type="button">
<select class="input_blur" name="select_display" id="select_display" onchange="#">
<option value="">选择状态</option>
<?php if ($display_arr) { ?>
<?php foreach ($display_arr as $key=>$value) { ?>
<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php }} ?>
</select>
<select name="custom_attribute" id="custom_attribute" onchange="#">
<option value="">选择属性</option>
<option value="clear">去除属性</option>
<?php if ($attribute_arr) { ?>
<?php foreach ($attribute_arr as $key=>$value) { ?>
<option value="<?php echo $key; ?>"><?php echo $value; ?>[<?php echo $key; ?>]</option>
<?php }} ?>
</select>
</div>
<div id="pages" style="margin-top: 5px;">
<?php echo $pagination; ?>
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
</div>
<br/>
<br/>