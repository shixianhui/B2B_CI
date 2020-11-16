<style>
    .flower{
        display: inline;
        float: left;
    }
    .flower label {
        width: 60px;
    }
    .comment_box_right{
        background-color: #fafafa;
        height: auto;
        min-height: 170px;
        padding-top: 5px;
        position: relative;
    }
    .comment_box_right p{
        color: #666;
    }
    .content{
        float: left;
    }
    .content p {
        width: 447px;
        color: #666;
    }
    .anony{
        display: inline;
        float: right;
        position: absolute;
        top: 5px;
        right:12px;
        margin-right: 10px;
    }
    .anony p {
        color: #666;
    }
    .comment_pic{
        padding: 10px 0 0 60px;
        clear: both;
    }
    .anony1{
        display: inline;
        float: right;
        position: absolute;
        bottom: 10px;
        right:12px;
        margin-right: 10px;
    }
</style>
<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">评价产品</span></div>
        <div class="m_comment mt20">
            <?php
              if($orders_detail_list){
                  foreach($orders_detail_list as $k=>$item){
            ?>
            <div class="comment_box clearfix">
                <div class="comment_box_left">
                    <dl>
                        <dt><img src="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>" alt=""></dt>
                        <dd>
                            <h4><a href="<?php echo getBaseUrl($html, "", "product/detail/{$item['product_id']}.html", $client_index); ?>" target="_blank"><?php echo $item['product_title'];?></a></h4>
<!--                            <p>--><?php //echo $item['product_color_name'].'：'.$item['color_name'].'<br>'.$item['product_size_name'].'：'.$item['size_name'];?><!--</p>-->
                            <input type="hidden" name="orders_detail_id[]" value="<?php echo $item['id'];?>">
                        </dd>
                    </dl>
                </div>
                <?php if ($item['comment_info']){ ?>
                <div class="comment_box_right">
                    <div class="flower">
                        <?php if ($item['comment_info']['evaluate'] == 1){ ?>
                            <label><span class="red">好评</span></label>
                        <?php }elseif($item['comment_info']['evaluate'] == 2){ ?>
                        <label><span class="yellow">中评</span></label>
                              <?php }else{ ?>
                        <label><span>差评</span></label>
                        <?php } ?>
                    </div>
                    <div class="content">
                        <p><?php if ($item['comment_info']['content']) { echo str_replace(array("\r\n", "\n", "\r"), '<br/>', $item['comment_info']['content']);}else{ echo "此用户未填写评论";} ?></p>
                    </div>
                    <div class="anony">
                        <p>是否匿名：
                            <?php if ($item['comment_info']['is_anonymous']){ ?>
                                <em>匿名</em>
                            <?php }else{ ?>
                                <em>公开</em>
                            <?php } ?>
                        </p>
                    </div>
                    <div class="comment_pic">
                        <?php if ($item['attachment_list']){
                            foreach ($item['attachment_list'] as $key=>$value){
                        ?>
                        <a data-lightbox="image_list_group_<?php echo $k; ?>" data-title="" href="<?php echo $value['path']; ?>" style="padding-right: 3px;"><img src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>" width="80px" height="80px"></a>
                    <?php }} ?>
                    </div>
                    <?php if ($item['comment_info']['is_reply']){ ?>
                        <p style="padding-top: 5px;">商家回复：</p>
                    <div style="padding: 5px 0 10px;position: relative">
                        <div class="flower">
                            <?php if ($item['comment_info']['reply_evaluate'] == 1){ ?>
                                <label><span class="red">好评</span></label>
                            <?php }elseif($item['comment_info']['reply_evaluate'] == 2){ ?>
                                <label><span class="yellow">中评</span></label>
                            <?php }else{ ?>
                                <label><span>差评</span></label>
                            <?php } ?>
                        </div>
                        <div style="float:left;"><p style="color: #B28500;width: 447px"><?php if ($item['comment_info']['reply_content']){echo str_replace(array("\r\n", "\n", "\r"), '<br/>', $item['comment_info']['reply_content']); }else{echo '未填写回复'; }?></p></div>
                        <div style="clear: both;margin-left: 60px;margin-top: 5px"><p>[<?php echo date('Y-m-d H:i:s', $item['comment_info']['reply_time']); ?>]</p></div>
                    </div>
                    <?php } ?>
                </div>
                          <?php } ?>
            </div>
                  <?php }}?>
            <?php if ($comment_store_info){ ?>
            <div class="from" style="width:540px;margin-left:300px;clear:both;padding-top: 20px;">
                    <ul>
                        <Li class="clearfix" style="overflow:hidden;"><span style="width:115px;color:#666;">宝贝与描述相符：</span>  
                            <div class="start">
                                <dl>
                                    <?php for ($i = 0; $i < $comment_store_info['des_grade']; $i++){ ?>
                                    <dd class="on"><a href="javascript:;">1</a></dd>
                                    <?php } ?>
                                </dl>
                            </div>
                        </Li>
                        <Li class="clearfix" style="overflow:hidden;"><span style="width:115px;color:#666;">卖家的服务态度：</span>  <div class="start">
                                <dl>
                                    <?php for ($i = 0; $i < $comment_store_info['serve_grade']; $i++){ ?>
                                        <dd class="on"><a href="javascript:;">1</a></dd>
                                    <?php } ?>
                                </dl>
                            </div>
                        </Li>
                         <Li class="clearfix" style="overflow:hidden;"><span style="width:115px;color:#666;">卖家发货的速度：</span>  <div class="start">
                                <dl>
                                    <?php for ($i = 0; $i < $comment_store_info['express_grade']; $i++){ ?>
                                        <dd class="on"><a href="javascript:;">1</a></dd>
                                    <?php } ?>
                                </dl>
                            </div>
                        </Li>
                    </ul>
                </div>
            <?php } ?>
    </div>
</div>
    <link rel="stylesheet" href="js/admin/lightbox2-master/src/css/lightbox.css">
    <script src="js/admin/lightbox2-master/src/js/lightbox.js"></script>
    <script>
        lightbox.option({
            'resizeDuration': 300,
            'wrapAround': true,
            'positionFromTop': 200,
            showImageNumberLabel: false
        });
    </script>