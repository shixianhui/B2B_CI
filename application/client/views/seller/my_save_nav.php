<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">新增导航</span><span style="float: right;font-size:16px;"><a href="<?php echo getBaseUrl(false, '', 'seller/my_get_nav_list.html', $client_index) ?>" style="color:#333;">返回</a></span></div>
        <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" name="jsonForm" id="jsonForm">
            <div class="b_shop_update">
                <ul class="m_form fl">
                    <li class="clearfix"><span>导航名称：</span><input type="text" name="title" value="<?php if($item_info){ echo $item_info['title'];}?>" id="title" valid="required" errmsg="导航名称不能为空" maxlength="20" class="input_txt">
                        <font color="#cc0011">*</font>
                    </li>
                    <li class="clearfix"><span>链接地址：</span><input type="text" name="url" value="<?php if($item_info){ echo $item_info['url'];}?>" id="url" valid="isUrl" errmsg="链接地址格式错误！" class="input_txt"><font color="#cc0011" style="font-size:14px;">注：不做超链接不用填写</font></li>
                    <li class="clearfix"><span>排序：</span><input type="text" name="sort" value="<?php if($item_info){ echo $item_info['sort'];}?>" id="sort" valid="isInt" errmsg="排序值必须是数值" class="input_txt"><font color="#cc0011" style="font-size:14px;">数值越小排序越靠前</font></li>
                    <li class="clearfix">
                        <span>是否显示：</span>
                        <p style="display:inline-block;width:100px;">
                        <label class="fl"><input type="radio" name="display" value="1" <?php if($item_info){ echo $item_info['display']==1 ? 'checked="checked"' : '';}else{ echo 'checked="checked"';}?>> 显示</label>
                        <label class="fr"><input type="radio" name="display" value="0"  <?php if($item_info){ echo $item_info['display']==0 ? 'checked="checked"' : '';} ?>> 隐藏</label>
                        </p>
                    </li>
                    <li class="clearfix"><span>描述：</span><font color="#cc0011" style="font-size:14px;">内容最大宽904px</font></li>
                </ul>
                <div class="clear"></div>
                <div style="clear:both;padding-left:10px;">
                        <?php echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
                            <script id="content" name="content" type="text/plain"><?php if($item_info){ echo html($item_info['content']);} ?></script>
                            <script type="text/javascript">
                                var ue = UE.getEditor('content', {
                                    toolbars: [
                                        [ 'source','bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc','simpleupload','insertimage','template','link', 'unlink', '|' ,'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts','fullscreen']
                                    ],
                                    initialFrameWidth : 910,
                                    initialFrameHeight : 450
                                });
                            </script>
                </div>
            </div>
            <div class="clear"></div>
            <div style="margin:20px 0px 20px 200px; clear:both; display:block;">
                <a href="javascript:void(0);" onclick="$('#jsonForm').submit();" class="b_btn">确认提交</a>
            </div>
        </form>
    </div>
</div>