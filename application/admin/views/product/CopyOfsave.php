<?php echo $tool; ?>
<style type="text/css">
#size_color_list th {
    background-color: #EDEDED;
    border: 1px solid #D7D7D7;
    font-weight: 400;
    height: 25px;
    text-align: center;
    vertical-align: middle;
    min-width:60px;
}
#size_color_list td {
    border: 1px solid #D7D7D7;
    height: 25px;
    max-width: 200px;
    min-width: 60px;
    padding: 3px 5px;
    text-align: center;
    vertical-align: middle;
}
    </style>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<div class="tag_menu" style="width: 99%; margin-top: 10px;">
<ul>
  <li><a href="javascript:void(0);" id="basic" class="selected">产品信息</a></li>
  <li><a href="javascript:void(0);" id="advanced" >产品描述</a></li>
  <li><a href="javascript:void(0);" id="appAdvanced" >App产品描述</a></li>
  <li><a href="javascript:void(0);" id="kefu" >营销选项</a></li>
  <li><a href="javascript:void(0);" id="chouzhi" >备注说明</a></li>
</ul>
</div>
<div id="basics" style="border-top:2px solid #99d3fb;" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>产品名称</strong> <br/>
	  </th>
      <td>
      <input name="title" id="title" value="<?php if(! empty($productInfo)){ echo $productInfo['title'];} ?>" size="80" maxlength="100" valid="required" errmsg="产品名称不能为空!" class="inputtitle input_blur" type="text">
	</td>
    </tr>
 	<tr>
      <th width="20%"> <strong>品牌</strong> <br/></th>
      <td>
      <input name="brand_name" id="brand_name" value="<?php if(! empty($productInfo)){ echo $productInfo['brand_name'];} ?>" size="30" maxlength="50" class="input_blur" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%"><font color="red">*</font> <strong>市场价</strong> <br/>
	  </th>
      <td>
      <input name="market_price" id="market_price" value="<?php if(! empty($productInfo)){ echo $productInfo['market_price'];} ?>"  type="text" valid="required|isMoney" errmsg="市场价不能为空!|市场价必须为数字!"/> <font color="red">元</font>
      </td>
    </tr>
    <tr>
      <th width="20%"><font color="red">*</font> <strong>出售价</strong> <br/>
	  </th>
      <td>
      <input name="sell_price" id="sell_price" value="<?php if(! empty($productInfo)){ echo $productInfo['sell_price'];} ?>"  type="text" valid="required|isMoney" errmsg="出售价不能为空!|请填写正确的出售价格!"/> <font color="red">元</font>
      </td>
    </tr>
    <tr>
      <th width="20%"><font color="red">*</font> <strong>库存数量</strong> <br/>
	  </th>
      <td>
      <input name="stock" id="stock" value="<?php if(! empty($productInfo)){ echo $productInfo['stock'];} ?>"  type="text" valid="required|isNumber" errmsg="库存不能为空!|库存必须为数字!"/>
      </td>
    </tr>
    <tr>
      <th width="20%"><font color="red">*</font> <strong>产品编号</strong> <br/>
	  </th>
      <td>
      <input name="product_num" id="product_num" value="<?php if(! empty($productInfo)){ echo $productInfo['product_num'];}else{echo $tmp_product_num;} ?>" valid="required" errmsg="产品编号不能为空!" type="text"/>
      </td>
    </tr>
    <tr>
      <th width="20%"><strong>规格</strong> </th>
      <td>
      <button type="button" class="button_style">开启规格</button>
      <div id="size_color_list" style="height: auto; width: auto; overflow: auto;margin-top: 5px;">
      <table width="700px" id="table_size_color" cellspacing="0" border="0">
	  <tr>
		 <th>颜色</th>
		 <th>尺码</th>
		 <th>价格</th>
		 <th>库存</th>
		 <th>货号</th>
		 <th width="90px">操作</th>
	   </tr>
	   <tr align="center" class="previewTemplate">
		<td>
		<input size="10" type="text" name="attribute_color_name[]">
		</td>
		<td>
		<input size="10" type="text" name="attribute_size_name[]">
		</td>
		<td>
		<input onchange="javascript:change_price(this);" size="10" type="text" name="attribute_price[]">
		</td>
		<td>
		<input onchange="javascript:change_stock(this);" size="10" type="text" name="attribute_stock[]">
		</td>
		<td>
		<input size="10" type="text" name="attribute_product_num[]">
		</td>
		<td style="text-align: left;">
		<a style="margin-left: 15px;" href="javascript:void(0);" onclick="javascript:to_top(this);" class="sort_asc"></a>
		<a style="margin-left: 0px;" href="javascript:void(0);" onclick="javascript:to_down(this);" class="sort_desc"></a>
		</td>
	    </tr>
      </table>
      <button type="button" onclick="javascript:add_attribute();" class="button_style" style="margin-top: 5px;margin-right: 20px;">添加新的规格属性</button>
      <button type="button" class="button_style" style="margin-top: 5px;">关闭规格</button>
      </div>
      </td>
    </tr>
    <tr>
      <th width="20%"><strong>产品重量</strong> <br/>
	  </th>
      <td>
      <input name="weight" id="weight" value="<?php if(! empty($productInfo)){ echo $productInfo['weight'];}else{echo '0';} ?>"  type="text" valid="isMoney" errmsg="请输入正确的商品重量!"/> <font color="red">千克(KG)</font>
      </td>
    </tr>
      <tr>
      <th width="20%"><strong>送积分</strong> <br/>
	  </th>
      <td>
      <input name="give_score" id="give_score" value="<?php if(! empty($productInfo)){ echo $productInfo['give_score'];}else{echo '0';} ?>"  type="text" valid="isNumber" errmsg="请输入正确的积分数量"/> <font color="red">个</font>
      </td>
    </tr>
     <tr>
      <th width="20%"><strong>最大抵现积分</strong> <br/>
	  </th>
      <td>
      <input name="consume_score" id="consume_score" value="<?php if(! empty($productInfo)){ echo $productInfo['consume_score'];}else{echo '0';} ?>"  type="text" valid="isNumber" errmsg="请输入正确的最大抵现积分"/> <font color="red">个</font>
      </td>
    </tr>
 	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>产品分类</strong> <br/>
	</th>
      <td>
<style type="text/css">
.shop-cat-list {
    border: 1px solid #E4E4E4;
    height: 135px;
    margin-right: 10px;
	margin-bottom: 5px;
    overflow: auto;
    padding: 3px;
    width: 637px;
}
input.checkbox {
    background: none repeat scroll 0 0 transparent;
    height: 18px;
    margin: 0 4px 0 5px;
    vertical-align: middle;
}

.form li span li, .form li span .module-property li span li {
    clear: none;
    float: left;
    margin: 0 20px 0 0;
    white-space: nowrap;
}
.shop-cat-list li {
    float: none !important;
    margin: 0 !important;
}
li {
    list-style: none outside none;
}
.category2{
	margin: 0;
    padding: 0 0 0 20px;
}
.category3{
	margin: 0;
    padding: 0 0 0 40px;
}
</style>
      <div class="shop-cat-list">
		<!-- feilv 2012-03-02 店铺分类新加钩子J_ShopCatList -->
		<?php if (! empty($product_category_list)) { ?>
		<ul class="J_ShopCatList">
			<!-- 一级 -->
			<?php foreach ($product_category_list as $menu) {
			    if ($menu['subMenuList']) {
				?>
			<li>
				<?php echo $menu['product_category_name']; ?>
				<ul class="category2">
				<!-- 二级 -->
		        <?php foreach ($menu['subMenuList'] as $subMenu) { ?>
		        <li>
		        	<input <?php if(! empty($productInfo)){if(myInArray($subMenu['id'], $pci_info)){echo "checked=true";}} ?> type="checkbox" value="<?php echo $menu['parent_id'].','.$subMenu['id']; ?>" name="product_category_id[]" class="checkbox select_product_class">
		        	<label for="shopCatId285432655"><?php echo $subMenu['product_category_name']; ?></label>
		        </li>
		        <?php } ?>
				</ul>
			</li>
			<?php } else { ?>
			<li>
				<input <?php if(! empty($productInfo)){if(myInArray($menu['id'], $pci_info)){echo "checked=true";}} ?> type="checkbox" value="<?php echo $menu['parent_id'].','.$menu['id']; ?>" name="product_category_id[]" class="checkbox select_product_class">
				<label for="shopCatId411110266"><?php echo $menu['product_category_name']; ?></label>
			</li>
			<?php }} ?>
			</ul>
			<?php } ?>
		</div>
		<a href="admincp.php/product_category">点我添加产品分类</a>&nbsp;
      </td>
    </tr>
  <tr>
    <th width="20%">
    <font color="red">*</font> <strong>缩略图</strong> <br/>
	</th>
    <td>
    <input name="model" id="model"  value="product_list" type="hidden" />
    <input name="path" id="path" size="50" class="input_blur" value="<?php if(! empty($productInfo)){ echo $productInfo['path'];} ?>"  type="text" />
    <input class="button_style" name="upload_image" id="upload_image" value="上传图片" style="width: 60px;"  type="button" />  <input class="button_style" value="浏览..."
style="cursor: pointer;" name="select_image" id="select_image" type="button" /> <input class="button_style" style="cursor: pointer;"  name="cut_image" id="cut_image" value="裁剪图片" type="button"  />
    </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>批量上传商品图片</strong> <br/>
	  </th>
      <td>
    <input name="batch_path_ids" id="batch_path_ids" size="50" class="input_blur" value="<?php if(! empty($productInfo)){ echo $productInfo['batch_path_ids'];} ?>" type="text" />
    <input class="button_style" name="batch_upload_image" id="batch_upload_image" value="批量添加" style="width: 60px;"  type="button" />
    </td>
    </tr>
    <tr>
      <th width="20%"> <strong>状态</strong> <br/>
	  </th>
      <td><?php if(! empty($productInfo)){ echo date('Y-m-d H:i:s', $productInfo['display_time']);} ?>
      <select name="display" id="display">
      <?php if ($displayArr) { ?>
      <?php foreach ($displayArr as $key=>$value) {
            $selector = '';
            if($productInfo) {
            	if ($productInfo['display'] == $key) {
            		$selector = 'selected="selected"';
            	}
            }
      	?>
       <option <?php echo $selector; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
      <?php }} ?>
      </select>
      </td>
    </tr>
    <tr>
      <th width="20%"> <strong>销售量</strong> <br/>
	  </th>
      <td>
      <input name="sales" id="sales" value="<?php if(! empty($productInfo)){ echo $productInfo['sales'];}else{echo '0';} ?>"  type="text" valid="isNumber" errmsg="浏览次数必须为数字!"/>
      </td>
    </tr>
    <tr>
      <th width="20%"> <strong>浏览次数</strong> <br/>
	  </th>
      <td>
      <input name="hits" id="hits<?php if(! empty($productInfo)){ echo $productInfo['hits'];} ?>" value="<?php if(! empty($productInfo)){ echo $productInfo['hits'];} ?>"  type="text" valid="isNumber" errmsg="浏览次数必须为数字!"/>
      </td>
    </tr>
    <tr>
    <th width="20%">
    <strong>自定义属性</strong> <br/>
	</th>
    <td>
        <?php
           foreach($attribute_arr as $key=>$item){
        ?>
        <label><input class="checkbox_style" name="custom_attribute[]" id="<?php echo $key;?>"  value="<?php echo $key;?>" <?php if(! empty($productInfo)){if(substr_count($productInfo['custom_attribute'],$key)>0){echo "checked=true";}} ?> type="checkbox"/> <?php echo $item."[$key]";?></label>
           <?php }?>

	</td>
    </tr>
	<tr>
      <th width="20%"> <strong>发布时间</strong> <br/>
	  </th>
      <td>
	<input class="input_blur" name="add_time" id="add_time"  size="21" readonly="readonly" type="text"/>&nbsp;
	<script language="javascript" type="text/javascript">
	    datetime = "<?php if(! empty($productInfo)){ echo date('Y-m-d H:i:s', $productInfo['add_time']);} ?>";
		date = new Date();
		if (datetime == "" || datetime == null) {
			datetime = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
		}
		document.getElementById ("add_time").value =datetime;
		Calendar.setup({
			inputField     :    "add_time",
			ifFormat       :    "%Y-%m-%d %H:%M:%S",
			showsTime      :    true,
			timeFormat     :    "24",
			align          : "Tr"
		});
	</script>
	 </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</div>
<div id="advanceds" style="display: none;border-top:2px solid #99d3fb;">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="10%"><font color="red">*</font> <strong>产品描述</strong></th>
      <td>
	  <?php echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
	<script id="content" name="content" type="text/plain" style="width:980px;height:600px;">
	<?php if(! empty($productInfo)){ echo html($productInfo["content"]);}else{echo "";} ?>
	</script>
	<script type="text/javascript">
	    var ue = UE.getEditor('content');
	</script>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
 	</tbody>
</table>
</div>
    <div id="appAdvanceds" style="display: none;border-top:2px solid #99d3fb;">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="10%"><font color="red">*</font> <strong>App产品描述</strong></th>
      <td>
	<script id="app_content" name="app_content" type="text/plain" style="width:980px;height:600px;">
	<?php if(! empty($productInfo)){ echo html($productInfo["app_content"]);}else{echo "";} ?>
	</script>
	<script type="text/javascript">
	    var ue = UE.getEditor('app_content');
	</script>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
 	</tbody>
</table>
</div>
<div id="kefus" style="display: none;border-top:2px solid #99d3fb;">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="20%"> <strong>SEO关键词</strong> <br/>
	  多关键词之间用逗号隔开
	  </th>
      <td>
      <input name="keyword" id="keyword" size="50"  value="<?php if(! empty($productInfo)){ echo $productInfo['keyword'];} ?>"  maxlength="100" class="input_blur" type="text" />
      </td>
    </tr>
	<tr>
      <th width="20%"> <strong>SEO描述</strong> <br/>
	  </th>
      <td>还可以输入 <font id="ls_description" color="#ff0000">255</font> 个字符！<br/>
      <textarea name="abstract" id="abstract" rows="4" cols="50"  class="textarea_style" style="width: 80%;" ><?php if(! empty($productInfo)){ echo $productInfo['abstract'];} ?></textarea>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
 	</tbody>
</table>
</div>
<div id="chouzhis" style="display: none;border-top:2px solid #99d3fb;" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>备注说明</caption>
 	<tbody>
	<tr>
      <th width="20%"> <strong>备注说明</strong> <br/>
	  </th>
      <td>
      <textarea maxlength="140" name="remark" id="remark" rows="4" cols="50"  class="textarea_style" style="width: 80%;" ><?php if(! empty($productInfo)){ echo $productInfo['remark'];} ?></textarea>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
 	</tbody>
</table>
</div>
</form>
<br/>
<br/>
<script type="text/javascript">
function to_top(obj) {
	$(obj).parents('tr.previewTemplate').insertBefore($(obj).parents('tr.previewTemplate').prev('.previewTemplate'));
}

function to_down(obj) {
	$(obj).parents('tr.previewTemplate').insertAfter($(obj).parents('tr.previewTemplate').next());
}

function to_delete(obj) {
	$(obj).parents('tr.previewTemplate').remove();
}

function change_price(obj) {
    var price = $(obj).val();
    if (isNaN(price)) {
    	$(obj).val("")
    	var d = dialog({
            width: 200,
            title: '提示',
            fixed: true,
            content: '请输入正确的价格'
        });
        d.show();
        setTimeout(function () {
            d.close().remove();
        }, 2000);
        return false;
   	 }
}

function change_stock(obj) {
	var stock = $(obj).val();
    if (isNaN(stock)) {
    	$(obj).val("")
    	var d = dialog({
            width: 200,
            title: '提示',
            fixed: true,
            content: '请输入正确的库存数量'
        });
        d.show();
        setTimeout(function () {
            d.close().remove();
        }, 2000);
        return false;
   	 }
}

function add_attribute() {
    var html = '<tr align="center" class="previewTemplate">';
        html += '<td>';
        html += '<input size="10" type="text" name="attribute_color_name[]">';
        html += '</td>';
        html += '<td>';
    	html += '<input size="10" type="text" name="attribute_size_name[]">';
    	html += '</td>';
    	html += '<td>';
    	html += '<input onchange="javascript:change_price(this);" size="10" type="text" name="attribute_price[]">';
    	html += '</td>';
    	html += '<td>';
    	html += '<input onchange="javascript:change_stock(this);" size="10" type="text" name="attribute_stock[]">';
    	html += '</td>';
    	html += '<td>';
    	html += '<input size="10" type="text" name="attribute_product_num[]">';
    	html += '</td>';
    	html += '<td>';
    	html += '<a href="javascript:void(0);" onclick="javascript:to_top(this);" class="sort_asc"></a>';
    	html += '<a style="margin-left:5px;" href="javascript:void(0);" onclick="javascript:to_down(this);" class="sort_desc"></a>';
    	html += '<a style="margin-left:5px;" href="javascript:void(0);" onclick="javascript:to_delete(this);" class="sort_delete"></a>';
    	html += '</td>';
    	html += '</tr>';
    $('#table_size_color').find("tr:last").after(html);

}
</script>