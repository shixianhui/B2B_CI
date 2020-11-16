<?php echo $tool; ?>
<link href="css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
<script src="js/admin/jquery.datetimepicker.js" type="text/javascript"></script>
<table class="table_form" cellpadding="0" cellspacing="1">
        <caption></caption>
        <tbody>
            <tr style="display: none">
                <th>
                    <strong>商品信息</strong>
                </th>
                <td>
                <?php
                 if ($itemInfo) {
                     if($itemInfo['start_time'] > time()){ ?>
                <input onclick="javascript:window.location.href='<?php echo base_url()."admincp.php/{$template}/save/{$itemInfo['id']}"; ?>';" class="button_style" name="reset" value=" 修改当前信息 " type="button">
                <?php }}?>
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>团购商品</strong> <br/>
                </th>
                <td>
                    <table class="table_form" cellpadding="0" cellspacing="1" style="width:700px;margin-left:0px;">
                        <tr>
                            <th width="150px" class="align_c"><strong>产品图片</strong></th>
                            <th class="align_c"><strong>产品标题</strong></th>
                            <th width="90px" class="align_c"><strong>原价（元）</strong></th>
<!--                            <th width="90px" class="align_c"><strong>底价（元）</strong></th>-->
                        </tr>
                        <tr>
                            <td class="align_c"><img src="<?php if($itemInfo){echo $productInfo['path'];}?>" style="max-width:140px;" onerror="this.src='images/default/no_pic.jpg'"></td>
                            <td class="align_c"><?php if($itemInfo){echo $productInfo['title'];}?></td>
                            <td class="align_c"><?php if($itemInfo){echo $productInfo['sell_price'];}?></td>
<!--                            <td class="align_c">--><?php //if($itemInfo){echo $itemInfo['low_price'];}?><!--</td>-->
                        </tr>
                    </table>
                </td>
            </tr>
            <?php if ($itemInfo && !$itemInfo['type']){ ?>
            <tr>
                <th width="20%">
                    <strong>团购规则</strong> <br/>
                </th>
                <td>
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
                </td>
            </tr>
            <?php }else{ ?>
            <tr id="type_1">
                <th width="20%"><strong>固定团购价格</strong> <br/></th>
                <td><?php if($itemInfo){echo $itemInfo['sale_price'];}?> 元</td>
            </tr>
            <?php } ?>
            <tr>
                <th width="20%"><strong>定金</strong> <br/></th>
                <td><?php if($itemInfo){echo $itemInfo['deposit'];}?> 元</td>
            </tr>
            <tr>
                <th width="20%"><strong>最少团购人数</strong> <br/></th>
                <td><?php if($itemInfo){echo $itemInfo['min_number'];}?></td>
            </tr>
            <tr>
                <th width="20%"><strong>最多团购人数</strong> <br/></th>
                <td><?php if($itemInfo){echo $itemInfo['max_number'];}?></td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>活动时间</strong> <br/>
                </th>
                <td>
                 <?php if($itemInfo){echo date('Y-m-d H:i:s',$itemInfo['start_time']);}?>
                 至
                 <?php if($itemInfo){echo date('Y-m-d H:i:s',$itemInfo['end_time']);}?>
                 <?php
                 if ($itemInfo) {
                     if($itemInfo['start_time'] < time() &&  $itemInfo['end_time'] > time()){
                       echo  '<font color="red">进行中...</font>';
                     }
                     if($itemInfo['end_time'] < time()){
                         echo  '<font color="red">已结束</font>';
                     }
                     if($itemInfo['start_time'] > time()){
                         echo  '<font color="red">暂未开始</font>';
                     }
                 }
                    ?>
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>是否开启团购活动</strong> <br>
                </th>
                <td>
                <?php if($itemInfo){ echo $itemInfo['is_open']==1 ? '开启' : '关闭';} ?>
                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td>
                <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
                </td>
            </tr>
        </tbody>
    </table>
<br/><br/>