<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">申请退换货</span></div>
            <div class="member_tab mt20">
                <div class="hd">
                    <ul>
                        <li class="on">全部</li>
                    </ul>
                </div>
                <div class="bd">
                    <div class="clearfix">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
                            <thead>
                                <tr>
                                    <th width="13%">问题图片</th>
                                    <th width="35%">详细原因描述</th>
                                    <th width="13%">申请时间</th>
                                    <th width="9%">申请状态</th>
                                    <th width="14%">操作</th>
                                </tr>
                                <tr>
                                    <td colspan="6" class="bj">&nbsp;</td>
                                </tr>
                            </thead>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table">
                            <tbody>
                                  <?php if ($item_list) { ?>
		<?php foreach ($item_list as $key=>$value) {
                       $url = getBaseUrl(false,'','user/my_save_exchange/'.$value['id'].'?order_number='.$value['order_number'],$client_index);
                    ?>
                                <tr>
                                    <th colspan="6" align="left"><font class="c9">下单时间：</font>2016-09-13&nbsp;&nbsp;&nbsp;订单编号：<?php echo $value['order_number'];?></th>
                                </tr>
                                <tr>
                                    <td width="13%" align="center"><img src="<?php echo preg_replace('/\./',"_thumb.",$value['path']);?>"></td>
                                    <td width="35%" align="center"><?php echo $value['content'];?></td>
                                    <td width="13%" align="center"><?php echo date('Y-m-d H:i:s',$value['add_time']);?></td>
                                    <td width="9%" align="center" >
                                        <font class="purple">
                                        <?php echo $status[$value['status']]; ?>
                                        </font><br>
                                    </td>
                                    <td width="14%" align="center"><a href="<?php echo ($value['status']==1 || $value['status']==2) ? 'javascript:;' : $url; ;?>" class="m_btn <?php echo ($value['status']==1 || $value['status']==2) ? 'gray' : ''; ;?>">编辑</a><br><a href="javascript:void(0);" class="m_btn gray mt5" onclick="deleteExchange(<?php echo $value['id'];?>);">取消</a></td>
                                </tr>
        <?php }} ?> 
                            </tbody>
                        </table>
                        <div class="delete_cuont mt20"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
</script>
<script type="text/javascript">
function deleteExchange(id) {
	$.post(base_url+"index.php/user/my_delete_exchange", 
			{	
				"id": id
			},
			function(res){
				if(res.success){		
                                        location.reload();
					return false;
				}else{
					var d = dialog({
					    title: '提示',
					    fixed: true,
					    content: res.message
					});
					d.show();
					setTimeout(function () {
					    d.close().remove();
					}, 2000);
					return false;
				}
			},
			"json"
    );
}
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>

