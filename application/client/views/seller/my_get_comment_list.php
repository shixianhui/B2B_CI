<style type="text/css">
	.product_search span{font-size:13px;line-height:30px;}
	.product_search input{line-height:30px;border:1px solid #eaebeb;padding:0 5px;color:#666;}
	.product_search label{position: relative;vertical-align:middle;font-size:13px;color:#333;line-height:30px;padding-left: 3px}
	.product_search label div{display:inline-block;position: relative;
    overflow: hidden;
    height: 30px;
    border: 1px solid #eaebeb;
    background: #fff;
    color: #666;
    -webkit-transition: border-color 0.2s linear;
    transition: border-color 0.2s linear;
    vertical-align:top; padding:0; line-height:20px;}

	.product_search select{-webkit-box-sizing: border-box;
    box-sizing: border-box;
    height: 30px;
    margin: 0;
    border: 0;
    padding: 0 20px 0 5px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    font-size: 12px;
    font-weight: 400;
    line-height: 29px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    vertical-align: middle;
    background: none;
    color: #666;
    outline: none;
    cursor: pointer;}
    .down{    position: absolute;
    right: 5px;
    top: 10px;
    z-index: 1;
    width: 16px;
    height: 16px;
    color: #b0b0b0;
    cursor: pointer;
    pointer-events: none;
    background: url(images/default/icon.png) no-repeat -402px -96px;
}
</style>
<div class="member_right mt20">

    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">评价管理</span></div>
        <form class="product_search" id="product_search" method="post" action="index.php/<?php echo $template; ?>/my_get_comment_list/1.html">
            <div style="padding-top: 20px;">
            <span>订单号：</span><input style="width:100px;" type="text" name="order_num">
            <span style="padding-left: 3px">评价者：</span><input style="width:100px;" type="text" name="username">
            <label>
                <div><span class="down"></span>
                <select class="" name="evaluate">
                    <option value="">选择类型</option>
                    <?php if ($evaluate_arr) { ?>
                        <?php foreach ($evaluate_arr as $k=>$evaluate) { ?>
                            <option value="<?php echo $k; ?>"><?php echo $evaluate; ?></option>
                        <?php }} ?>
                </select>
                </div>
            </label>
                <label>
                <div><span class="down"></span>
                <select class="" name="is_reply">
                    <option value="">选择状态</option>
                    <?php if ($comment_status_arr) { ?>
                        <?php foreach ($comment_status_arr as $key=>$value) { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php }} ?>
                </select>
                </div>
            </label>
                <span>评价时间：</span><input type="text" name="add_time_start" id="add_time_start" style="width: 80px;" readonly="readonly">--<input type="text" name="add_time_end" id="add_time_end" style="width: 80px" readonly="readonly">
                <input type="submit" value="查询" style="width: 70px;color: #000;margin-left: 5px">
            </div>
        </form>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="b_shop_table">
            <tr>
                <th width="15%">订单号</th>
                <th width="30%">商品名称</th>
                <th width="15%">评价类型</th>
                <th width="10%">评价时间</th>
                <th width="10%">评价者</th>
                <th width="8%">状态</th>
                <th width="8%">操作</th>
            </tr>
            <?php
               if($item_list){
                   foreach($item_list as $item){
            ?>
            <tr id="id_<?php echo $item['id'];?>">
                <td align="center"><?php echo $item['order_number']; ?></td>
                <td align="center"><a href="<?php echo getBaseUrl($html, "", "product/detail/{$item['product_id']}.html", $client_index); ?>" target="_blank"><?php echo $item['product_title'];?></a></td>
                <td align="center"><?php echo $evaluate_arr[$item['evaluate']];?></td>
                <td align="center"><?php echo date("Y-m-d H:i:s", $item['add_time']); ?></td>
                <td align="center"><?php echo $item['username']; ?>
                    <br/>
                    （ID:<?php echo $item['user_id']; ?>）</span></td>
                <td align="center"><font color="#cc3333"><?php echo $comment_status_arr[$item['is_reply']]; ?></font></td>
                <td align="center"><a href="<?php echo getBaseUrl(false,'','seller/my_save_comment/'.$item['id'],$client_index)?>"><?php if ($item['is_reply']){ ?>查看<?php }else{ ?>处理 <?php } ?></a></td>
            </tr>
                   <?php }}?>
        </table>
         <div class="clear"></div>
	<div class="pagination">
		<ul>
		<?php echo $pagination; ?>
		</ul>
	</div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#add_time_start').calendar({ maxDate:'#add_time_end', btnBar:false });
        $('#add_time_end').calendar({ minDate:'#add_time_start', btnBar:false });
    });
</script>