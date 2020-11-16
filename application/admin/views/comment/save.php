<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<input name="id" value="" type="hidden">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>会员充值</caption>
 	<tbody>
    <tr>
        <th width="20%"><strong>订单号</strong> <br/>
        </th>
        <td>
            <?php if ($item_info){ echo $item_info['order_number'];} ?><a href="admincp.php/orders/view/<?php if ($order_info){ echo $order_info['id'];} ?>">查看</a>
        </td>
    </tr>
 	<tr>
      <th width="20%"><strong>商品名称</strong> <br/>
	  </th>
      <td>
      <?php if ($item_info){ echo $item_info['product_title'];} ?>
	</td>
    </tr>
    	<tr>
      <th width="20%"><strong>评论人</strong> <br/>
	  </th>
      <td>
          用户名：<?php if ($item_info){ echo $item_info['username'];} ?><a href="admincp.php/user/save/<?php if ($item_info){ echo $item_info['user_id'];} ?>">查看</a><br>
          用户id：<?php if ($item_info){ echo $item_info['user_id'];} ?><br>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>评价</strong> <br/>
	  </th>
      <td>
      <?php if ($item_info){ echo $evaluate_arr[$item_info['evaluate']];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>评论内容</strong> <br/>
	  </th>
      <td>
      <?php if ($item_info['content']){ echo $item_info['content'];}else{echo '此用户未填写评论';} ?>
    </td>
    </tr>
    <tr>
        <th width="20%"><strong>匿名</strong> <br/>
        </th>
        <td>
            <?php echo $item_info['is_anonymous']?'匿名':'公开'; ?>
        </td>
    </tr>
    <tr>
        <th width="20%"><strong>显示/隐藏</strong> <br/>
        </th>
        <td>
            <?php echo $item_info['display']?'显示':'<font color="#FF0000">隐藏</font>'; ?>
        </td>
    </tr>
    <tr>
        <th width="20%"><strong>评论时间</strong> <br/>
        </th>
        <td>
            <?php if ($item_info){ echo date('Y-m-d H:i:s', $item_info['add_time']);} ?>
        </td>
    </tr>
    <?php if ($item_info['is_reply']){ ?>
    <tr>
        <th width="20%"><strong>商家评价</strong> <br/>
        </th>
        <td>
            <?php if ($item_info){ echo $evaluate_arr[$item_info['store_evaluate']];} ?>
        </td>
    </tr>
    <tr>
        <th width="20%"><strong>回复内容</strong> <br/>
        </th>
        <td>
            <?php if ($item_info['store_reply']){ echo $item_info['store_reply'];}else{echo '未填写回复';} ?>
        </td>
    </tr>
    <tr>
        <th width="20%"><strong>回复时间</strong> <br/>
        </th>
        <td>
            <?php if ($item_info){ echo date('Y-m-d H:i:s', $item_info['reply_time']);} ?>
        </td>
    </tr>
    <?php } ?>
 	<tr>
      <td>
      &nbsp;
      </td>
      <td>
<!--      <input class="button_style" name="dosubmit" value="修改" type="submit">-->
      &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	</td>
	</tr>
</tbody>
</table>
</form>