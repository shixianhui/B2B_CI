<style>
    .comment_pic{
        float: left;
        display:block;
        position: relative;
    }
    .comment_content p{
        width:auto;
    }
</style>
<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">评价产品</span></div>
        <div class="m_comment mt20">
            <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" name="jsonForm" id="jsonForm">
            <?php
              if($orders_detail){
                  foreach($orders_detail as $item){
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
                <div class="comment_box_right">
                    <div class="flower">
                        <label><input type="radio" name="evaluate_<?php echo $item['id'];?>" value="1"><span class="red">好评</span></label>
                        <label><input type="radio" name="evaluate_<?php echo $item['id'];?>" value="2"><span class="yellow">中评</span></label>
                        <label><input type="radio" name="evaluate_<?php echo $item['id'];?>" value="3"><span>差评</span></label>
                    </div>
                    <div class="comment_content">
                        <textarea name="content_<?php echo $item['id'];?>" placeholder="亲，写点评价吧，您的评价对其他买家有很大的帮助的"></textarea>
                        <div class="clearfix" id="pic_list">
                            <p style="position: relative">
                                <span class="pcshare">晒照片</span>
                                <input onchange="fileChange(this)" style="position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;left: 0px;bottom: 0px;cursor: pointer;width: 90px;" type="file" accept=".gif,.jpg,.jpeg,.png" multiple="multiple" id="<?php echo $item['id'];?>" name="path_file[]">
                                <em>限5张</em></p>
                            <p class="privacy">
                                <label><input type="radio" name="is_anonymous_<?php echo $item['id'];?>" checked="checked" value="0"><em>公开</em></label>
                                <label><input type="radio" name="is_anonymous_<?php echo $item['id'];?>" value="1"><em>匿名</em></label>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
                  <?php }}?>
            <div class="from" style="width:540px;margin-left:300px;clear:both;padding-top: 20px;">
                    <ul>
                        <Li class="clearfix" style="overflow:hidden;"><span style="width:115px;color:#666;">宝贝与描述相符：</span>  
                            <div class="start">
                                <dl>
                                    <dd><a href="javascript:;">1</a></dd>
                                    <dd><a href="javascript:;">2</a></dd>
                                    <dd><a href="javascript:;">3</a></dd>
                                    <dd><a href="javascript:;">4</a></dd>
                                    <dd><a href="javascript:;">5</a></dd>
                                </dl>
                                <input type="hidden" name="des_grade">
                            </div>
                        </Li>
                        <Li class="clearfix" style="overflow:hidden;"><span style="width:115px;color:#666;">卖家的服务态度：</span>  <div class="start">
                                <dl>
                                    <dd><a href="javascript:;">1</a></dd>
                                    <dd><a href="javascript:;">2</a></dd>
                                    <dd><a href="javascript:;">3</a></dd>
                                    <dd><a href="javascript:;">4</a></dd>
                                    <dd><a href="javascript:;">5</a></dd>
                                </dl>
                                <input type="hidden" name="serve_grade">
                            </div>
                        </Li>
                         <Li class="clearfix" style="overflow:hidden;"><span style="width:115px;color:#666;">卖家发货的速度：</span>  <div class="start">
                                <dl>
                                    <dd><a href="javascript:;">1</a></dd>
                                    <dd><a href="javascript:;">2</a></dd>
                                    <dd><a href="javascript:;">3</a></dd>
                                    <dd><a href="javascript:;">4</a></dd>
                                    <dd><a href="javascript:;">5</a></dd>
                                </dl>
                                 <input type="hidden" name="express_grade">
                            </div>
                        </Li>
                        <li class="clearfix" style="overflow:hidden;"><input type="submit" value="评价" class="btn_r" style="border:none;margin-top:10px;"></li>
                    </ul>
                </div>
                  </form>
    </div>
</div>
<script type="text/javascript" language="javascript" src="js/default/score.js?v=1.1"></script>
<script>
    $(function () {
        var score = new Score({
            callback: function (cfg) {
                $(cfg.element).parent().siblings('input').val(cfg.starAmount);
            }
        });
    });
</script>
    <link rel="stylesheet" href="js/admin/lightbox2-master/src/css/lightbox.css">
    <script src="js/admin/lightbox2-master/src/js/lightbox.js"></script>
    <script>
        lightbox.option({
            'resizeDuration': 300,
            'wrapAround': true,
            'positionFromTop': 200
        });

        function del_pice(obj) {
            $(obj).parent().remove();
        }

        function enter_pic(obj) {
            $(obj).find('#close').fadeIn('slow');
        }
        function leave_pic(obj) {
            $(obj).find('#close').fadeOut('slow');
        }

        $(function () {
            //形象照片
            $("input[name='path_file[]']").wrap("<form id='path_upload' action='<?php echo base_url(); ?>index.php/upload/batch_uploadImage' method='post' enctype='multipart/form-data' style='position: absolute;'></form>");

        });

        function fileChange(obj) {
            var id = $(obj).attr('id');
            var pic_num = $("#pic_list").find('.comment_pic').length;
            $(obj).parent("#path_upload").ajaxSubmit({
                dataType: 'json',
                data: {
                    'model': 'comment',
                    'field': 'path_file',
                    'pic_num': pic_num
                },
                uploadProgress: function (event, position, total, percentComplete) {
                },
                success: function (res) {
                    $("#path_load").hide();
                    if (res.success) {
                        var html = '';
                        for (var i = 0; i < res.data.length; i++) {
                            html += '<p class="comment_pic" onmouseenter="enter_pic(this)" onmouseleave="leave_pic(this)">';
                            html += '<a data-lightbox="image_list_group_'+id+'" data-title="" href="' + res.data[i].file_path + '">';
                            html += '<img src="' + res.data[i].file_path.replace('.', '_thumb.') + '" width="22px" height="22px">';
                            html += '</a>';
                            html += '<input type="hidden" name="batch_path_ids_'+id+'[]" value="' + res.data[i].id + '" />';
                            html += '<img id="close" onclick="del_pice(this);" src="images/default/close.png" width="10px" height="10px" style="position: absolute;right: 0px;bottom: 12px;cursor: pointer;display: none">';
                            html += '</p>';
                        }
                        $(obj).parents("#pic_list").prepend(html);
                    } else {
                        return my_alert('fail', 0, res.message);
                    }
                },
                error: function (xhr) {
                }
            });
        }
    </script>