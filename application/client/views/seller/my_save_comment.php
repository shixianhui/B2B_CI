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
        min-height: 170px;
        height: auto;
        padding-top: 5px;
        position: relative;
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
</style>
<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">处理评价</span></div>
        <div class="m_comment mt20">
            <?php if ($item_info){ ?>
            <div class="comment_box clearfix">
                <input type="hidden" name="comment_id" value="<?php echo $item_info['id'];?>">
                <div class="comment_box_left">
                    <dl>
                        <dt><img src="<?php echo preg_replace('/\./', '_thumb.', $item_info['path']); ?>" alt=""></dt>
                        <dd>
                            <h4><a href="<?php echo getBaseUrl($html, "", "product/detail/{$item_info['product_id']}.html", $client_index); ?>" target="_blank"><?php echo $item_info['product_title'];?></a></h4>
                        </dd>
                    </dl>
                </div>
                <div class="comment_box_right">
                    <div class="flower">
                        <?php if ($item_info['evaluate'] == 1){ ?>
                            <label><span class="red">好评</span></label>
                        <?php }elseif($item_info['evaluate'] == 2){ ?>
                        <label><span class="yellow">中评</span></label>
                              <?php }else{ ?>
                        <label><span>差评</span></label>
                        <?php } ?>
                    </div>
                    <div class="content">

                        <p><?php if ($item_info['content']) { echo str_replace(array("\r\n", "\n", "\r"), '<br/>', $item_info['content']);}else{ echo "此用户未填写评论";} ?></p>
                    </div>
                    <div class="anony">
                        <p>
                            <?php if ($item_info['is_anonymous']){ ?>
                                <em>匿名</em>
                            <?php }else{ ?>
                                <em><?php echo $item_info['username'];?></em>
                            <?php } ?>
                        </p>
                    </div>
                    <div class="comment_pic">
                        <?php if ($attachment_list){
                            foreach ($attachment_list as $key=>$value){
                        ?>
                        <a data-lightbox="image_list_group_0" data-title="" href="<?php echo $value['path']; ?>" style="padding-right: 3px;"><img src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>" width="80px" height="80px"></a>
                    <?php }} ?>
                    </div>
                </div>
            </div>
            <?php } ?>
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
        <p style="color: #666;font-size: 14px;margin-left: 195px">对用户进行评价：</p>
        <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" name="jsonForm" id="jsonForm">
            <div style="margin-left: 300px">
            <div class="flower">
                <?php if ($store_reply_info){
                    if ($store_reply_info['evaluate'] == 1){ ?>
                        <label><span class="red">好评</span></label>
                    <?php }elseif($store_reply_info['evaluate'] == 2){ ?>
                        <label><span class="yellow">中评</span></label>
                    <?php }else{ ?>
                        <label><span>差评</span></label>
                    <?php }
                }else{ ?>
                <label><input type="radio" name="evaluate" value="1"><span class="red">好评</span></label>
                <label><input type="radio" name="evaluate" value="2"><span class="yellow">中评</span></label>
                <label><input type="radio" name="evaluate" value="3"><span>差评</span></label>
                <?php } ?>
            </div>
            <div class="comment_content">
                <textarea name="content" <?php if ($item_info['is_reply'] == 1){ ?>readonly <?php }else{ ?>placeholder="亲，写点对客户的回复吧"<?php } ?> style="padding: 0"><?php if ($item_info['is_reply'] == 1){if (!empty($store_reply_info['content'])){ echo str_replace(array("\r\n", "\n", "\r"), '<br/>', $store_reply_info['content']); }}?></textarea>
            </div>
                <?php if($item_info['is_reply'] == 0){ ?>
            <input type="submit" value="回复" class="btn_r" style="border:none;margin-top:10px;">
                <?php } ?>
            </div>
        </form>
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