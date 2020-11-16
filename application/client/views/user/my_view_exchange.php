
<style>
    .m_form {
        background: #fafafa;
    }
    .m_form li span{
        width:130px;
    }
    .m_good_picdif img {
        width: 88px;
        height: 88px;
    }
    .m_buyermess {
        width: 100%;
    }
    .m_buyermess thead {
         height: 38px;
         line-height: 38px;
         background: #f5f5f5;
         border-bottom: 1px solid #e0e0e0;
     }
    .m_buyermess td {
        text-align: center;
    }
    .m_goodlist {
         padding: 20px 0 0 0;
     }
    .m_goodlist p {
        width: 220px;
        line-height: 25px;
        height: 38px;
        font-size: 14px;
        color: #338cc4;
    }
    .m_good_pic {
        width: 73px;
        height: 73px;
        border: 1px solid #e0e0e0;
        display: inline-block;
        margin-left: 20px;
        margin-right: 20px;
    }
</style>
<div class="warp">
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">退款进度</span></div>
            <div class="member_tab mt20">
                <table class="m_buyermess">
                    <thead>
                    <tr>
                        <td width="40%">退款商品信息</td>
                        <td width="10%">价格（元）</td>
                        <td width="10%">数量</td>
                        <td width="10%">交易金额</td>
                        <td width="20%">订单编号</td>
                        <td width="10%">订单状态</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($orders_detail_info){
                            $url = getBaseUrl($html, "", "product/detail/{$orders_detail_info['product_id']}.html", $client_index);
                            ?>
                            <tr>
                                <td width="40%">
                                    <div class="m_goodlist clearfix">
                                        <a href="<?php echo $url; ?>"  target="_blank" class="m_good_pic m_good_picdif fl"><img src="<?php if ($orders_detail_info['path']) { echo preg_replace('/\./', '_thumb.', $orders_detail_info['path']);}else{echo 'images/default/load.jpg';} ?>" /></a>
                                        <p class="fl">
                                            <a href="<?php echo $url; ?>" target="_blank"><?php echo $orders_detail_info['product_title']; ?></a>
                                        </p>
                                    </div>
                                </td>
                                <td width="10%">
                                    <div class="m_money">
                                        <em>￥<?php echo $orders_detail_info['buy_price'];  ?></em>
                                    </div>
                                </td>
                                <td width="10%">
                                    <div class="m_price">
                                        <p><?php echo $orders_detail_info['buy_number']; ?></p>
                                    </div>
                                </td>
                                    <td width="10%">
                                        <div class="m_no">
                                            <em><?php echo $orders_detail_info['price_total']; ?></em>
                                        </div>
                                    </td>
                                    <td width="20%">
                                        <div class="m_no">
                                            <em><?php if ($item_info) { echo $item_info['order_number']; } ?></em>
                                        </div>
                                    </td>
                                    <td width="10%">
                                        <div class="m_price">
                                            <p><?php if ($item_info) { echo $status_arr[$item_info['status']]; } ?></p>
                                        </div>
                                    </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                    <ul class="m_form" >
                        <li class="clearfix">
                            <span>退款原因：</span><?php if($exchange_info){ echo $exchange_reason_arr[$exchange_info['exchange_reason_id']];} ?>
                        </li>
                        <li class="clearfix"><span>退款金额：</span><?php if ($exchange_info) {echo $exchange_info['price'];}else{ if ($orders_detail_info_info) {echo $orders_detail_info_info['total'];}} ?> 元</li>
                        <li class="clearfix">
                            <span>详细原因描述：</span><?php if ($exchange_info) {echo $exchange_info['content'];} ?>
                        </li>
                        <li class="clearfix">
                            <span>凭证图片：</span>
                            <div id="pic_list">
                                <?php if ($attachment_list) { ?>
                                    <?php foreach ($attachment_list as $key=>$value) { ?>
                                        <div style="float: left;width:70px;">
                                            <a data-lightbox="image_list_group_0" data-title="" href="<?php if ($value['path']) {echo $value['path'];}else{echo 'images/default/load.jpg';} ?>"><img style="padding: 2px; border:1px solid #CCC;float:left;" id="path_src" width="60px" height="60px" src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>" onerror="javascript:this.src='images/default/load.jpg';"></a>
                                        </div>
                                    <?php }} ?>
                            </div>
                        </li>
                        <li class="clearfix">
                            <span>申请时间：</span><?php if ($exchange_info) {echo date('Y-m-d H:i:s', $exchange_info['add_time']);} ?>
                        </li>
                        <li class="clearfix">
                            <span>审核时间：</span><?php if ($exchange_info) {echo date('Y-m-d H:i:s', $exchange_info['update_time']);} ?>
                        </li>
                        <li class="clearfix">
                            <span>退款进度：</span><?php if ($exchange_info) {echo $exchange_status_arr[$exchange_info['status']];} ?>
                        </li>
                        <?php if ($exchange_info['client_remark']){ ?>
                        <li class="clearfix">
                            <span>商家备注：</span><?php echo $exchange_info['client_remark']; ?>
                        </li>
                        <?php } ?>
                        <li class="clearfix" style="left: 60px">
                        <input type="button" onclick="history.go(-1);" value="返回" style="width: 50px">
                        </li>
                    </ul>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="js/admin/lightbox2-master/src/css/lightbox.css">
<script src="js/admin/lightbox2-master/src/js/lightbox.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 300,
        'wrapAround': true,
        'positionFromTop': 200
    })
</script>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
</script>

