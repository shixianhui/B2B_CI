<div class="member_right mt20">
    <div class="member_headline box_shadow clearfix">
        <ul class="short1">
            <Li><b>积分余额</b>
                <span class="red"><?php if ($user_info) { echo $user_info['score'];} ?></span>
            </Li>
        </ul>
    </div>
    <div class="box_shadow clearfix mt20 m_border">
        <div class="member_title"><span class="bt">积分记录</span></div>
        <div class="member_tab mt20">
            <div class="hd">
                <ul>
                    <li class="on">全部</li>
                </ul>
            </div>
            <div class="bd">
                <div class="clearfix">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
                        <tbody>
                            <tr>
                                <th><strong>日期</strong></th>
                                <th><strong>积分</strong></th>
                                <th><strong>当前积分余额</strong></th>
                                <th><strong>备注</strong></th>
                            </tr>
<?php if ($item_list) { ?>
    <?php foreach ($item_list as $key => $value) { ?>
                                    <tr>
                                        <td width="29%" align="center"><?php echo date('Y-m-d H:i:s', $value['add_time']); ?></td>
                                        <td width="12%" align="center"><?php if ($value['score'] < 0) { ?>
                                                <span class="goods-price" style="color:#00CC00;"><?php echo $value['score']; ?></span>
                                            <?php } else { ?>
                                                <span class="goods-price">+<?php echo $value['score']; ?></span>
                                        <?php } ?></td>
                                        <td width="14%" align="center"><?php echo $value['balance']; ?></td>
                                        <td width="45%" align="center" ><?php echo $value['cause']; ?></td>
                                    </tr>
    <?php }
} ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clear"></div>
            <div class="pagination">
                <ul><?php echo $pagination; ?></ul>
            </div>
        </div>
    </div>
</div>