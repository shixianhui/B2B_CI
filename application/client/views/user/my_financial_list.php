<div class="member_right mt20">

    <div class="member_headline box_shadow clearfix">

        <ul class="short1">
            <Li><b>账户余额</b>
                <span class="red"><small>￥</small><?php echo $user_info['total'];?></span>
            </Li>
            <Li><b>冻结资金</b>
                <span class="red"><small>￥</small>0.00</span>
            </Li>
            <Li><b>可提现金额</b>
                <span class="red"><small>￥</small>0.00</span>
            </Li>
            <Li style="margin-top:15px;"><a href="<?php echo getBaseUrl(false, "", "user/my_recharge.html", $client_index); ?>" class="m_btn purple mr20">充值</a><a href="<?php echo getBaseUrl(false, "", "user/my_draw.html", $client_index); ?>" class="m_btn">提现</a></Li>
        </ul>
    </div>
    <div class="box_shadow clearfix mt20 m_border">
        <div class="member_title"><span class="bt">账户记录</span></div>

        <div class="member_tab mt20">
            <div class="hd">
                <ul>
                    <li <?php if ($select_status == 'all') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "user/my_financial_list/all.html", $client_index); ?>'">全部</li>
                    <Li <?php if ($select_status == 'order_in') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "user/my_financial_list/order_in.html", $client_index); ?>'">退款记录</Li>
                    <Li <?php if ($select_status == 'order_out') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "user/my_financial_list/order_out.html", $client_index); ?>'">消费记录</Li>
                    <Li <?php if ($select_status == 'recharge_in') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "user/my_financial_list/recharge_in.html", $client_index); ?>'">充值记录</Li>
                    <Li <?php if ($select_status == 'recharge_out') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "user/my_financial_list/recharge_out.html", $client_index); ?>'">提现记录</Li>
                </ul>
            </div>
            <div class="bd">
                <div class="clearfix">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
                        <tbody>
                            <tr>
                                <th class="tal"><strong>操作时间</strong></th>
                                <th ><strong>类型</strong></th>
                                <th ><strong>金额（元）</strong></th>
                                <th ><strong>备注</strong></th>
                            </tr>
                           <?php
                                if($item_list){
                                    foreach($item_list as $item){
                                ?>
                                <tr>
                                    <td width="22%" align="left"><?php echo date('Y-m-d H:i:s',$item['add_time']);?></td>
                                    <td width="19%" align="center">
                                        <?php
                                        if($item['type']=='recharge_in'){
                                            echo '充值';
                                        }
                                       if($item['type']=='order_out'){
                                            echo '订单支付';
                                        }
                                        if($item['type']=='recharge_out'){
                                            echo '扣款';
                                        }
                                         if($item['type']=='order_in'){
                                            echo '订单退款';
                                        }
                                        ?>
                                    </td>
                                    <td width="14%" align="center"><b class="purple f14"><?php echo $item['price'];?></b></td>
                                    <td width="45%" align="center" ><?php echo $item['cause'];?></td>
                                </tr>
                                <?php }}?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
               <div class="clear"></div>
            <div class="pagination">
                <ul><?php echo $pagination; ?></ul>
            </div>
    </div>
</div>