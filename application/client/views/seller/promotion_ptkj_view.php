<style>
    .m_form .input_txt{ width: 160px}
    .table_form th{border: 1px solid #D7D7D7}
    .table_form td{border: 1px solid #D7D7D7}
    td.align_c, th.align_c {
        text-align: center;
    }
</style>
<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">新增团预购</span><span style="float: right;font-size:16px;"><a href="javascript:history.go(-1)" style="color:#333;">返回</a></span></div>
            <ul class="m_form fl">
                <li class="clearfix">
                    <span>设置团购商品：</span>
                    <table class="table_form" cellpadding="0" cellspacing="1" style="width:700px;margin-left:0px;">
                        <tr>
                            <th width="150px" class="align_c"><span>产品图片</span></th>
                            <th class="align_c"><span>产品标题</span></th>
                            <th width="90px" class="align_c"><span>原价（元）</span></th>
                            <!--                            <th width="90px" class="align_c"><span>底价（元）</span></th>-->
                        </tr>
                        <tr>
                            <td class="align_c"><img src="<?php if($itemInfo){echo $productInfo['path'];}?>" style="max-width:120px;" id="productImg" onerror="this.src='images/default/no_pic.jpg'"></td>
                            <td class="align_c"><span id="productTitle"><?php if($itemInfo){echo $productInfo['title'];}?></span></td>
                            <td class="align_c" id="price"><?php if($itemInfo){echo $productInfo['sell_price'];}?></td>
                            <!--                            <td class="align_c"><input type="text" name="low_price" size="6" value="--><?php //if($itemInfo){echo $itemInfo['low_price'];}?><!--" valid="required|isMoney" errmsg="最低价不能空|价格格式有误"></td>-->
                        </tr>

                    </table>
                </li>
                <li class="clearfix">
                    <span>团购活动方式：</span>
                    <?php if($itemInfo){ echo $itemInfo['type']==0 ? '叠加优惠金额' : '固定优惠金额';} ?>
                </li>
                <li class="clearfix" id="type_0"  <?php if ($itemInfo && $itemInfo['type']){ ?>style="display: none" <?php } ?>>
                    <span>团购规则：</span>
                    <table class="table_form" cellpadding="0" cellspacing="1" style="width:400px;margin-left:0px;">
                        <tr>
                            <th class="align_c"><strong>区间</strong></th>
                            <th width="80px" class="align_c"><strong>价格(元)</strong></th>
                        </tr>
                        <?php
                        if($itemInfo){
                            foreach($pintuan_arr as $ls){
                                ?>
                                <tr>
                                    <td class="align_c">
                                        <?php echo $ls['low'];?> 人 ～ <?php echo $ls['high'];?> 人
                                    </td>
                                    <td class="align_c">
                                        <?php echo $ls['money'];?>
                                    </td>
                                </tr>
                            <?php }}?>
                    </table>
                </li>
                <li class="clearfix" id="type_1" <?php if (empty($itemInfo) || !$itemInfo['type']){ ?>style="display: none" <?php } ?>>
                    <span>固定团购价格：</span>
                    <?php if($itemInfo){echo $itemInfo['sale_price'];}?>&nbsp;元
                </li>
                <li class="clearfix">
                    <span>定金：</span>
                    <?php if($itemInfo){echo $itemInfo['deposit'];}?>&nbsp;元
                </li>
                <li class="clearfix">
                    <span>最少团购人数：</span>
                    <?php if($itemInfo){echo $itemInfo['min_number'];}?>
                </li>
                <li class="clearfix">
                    <span>最多团购人数：</span>
                    <?php if($itemInfo){echo $itemInfo['max_number'];}?>
                </li>
                <li class="clearfix">
                    <span>活动时间：</span>
                    <?php if($itemInfo){echo date('Y-m-d H:i:s',$itemInfo['start_time']);}?>
                    <font style="font-size: 14px;margin-right: 20px;color: black">至</font>
                    <?php if($itemInfo){echo date('Y-m-d H:i:s',$itemInfo['end_time']);}?>
                </li>
                <li class="clearfix">
                    <span>是否开启团购：</span>
                    <?php if($itemInfo){ echo $itemInfo['is_open']==0 ? '关闭' : '开启';} ?>
                </li>
            </ul>
            <div class="clear"></div>
        <br/><br/>
