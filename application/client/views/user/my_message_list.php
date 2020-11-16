<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">我的消息</span></div>
        <div class="m_notice clearfix">
            <?php
            if ($item_list) {
                foreach ($item_list as $item) {
                    ?>
                    <dl class="clearfix <?php echo $item['is_read'] == 1 ? 'read' : ''; ?>"><dt><i></i><span name="checkWeek" class="CheckBoxNoSel fl checkbox" data-id="<?php echo $item['id']; ?>" style="margin-top:3px; margin-right:5px;"></span>来自<a href="javascript:;"><?php echo $item['from_name']; ?></a>类型: <?php echo $message_type[$item['message_type']]; ?></dt>
                        <dd><span class="time"><?php echo date('Y-m-d H:i', $item['add_time']); ?></span><?php echo $item['content']; ?>
                            <em class="all" data-id="<?php echo $item['id']; ?>">详情<i class="icon_zhankai icon"></i></em>
                        </dd>
                    </dl>
                <?php }
            } ?>
            <div class="delete_cuont mt20" style="padding-left:0px;"><span name="checkWeek" class="CheckBoxNoSel fl checkbox" style="margin-top:4px; margin-right:5px;" id="selectAll"></span>全选
                <a href="javascript:void(0)" id="delete">×删除</a>
            </div>
        </div>
        <div class="clear"></div>
        <div class="pagination">
            <ul><?php echo $pagination; ?></ul>
        </div>
    </div>
</div>
<script>
    $("dl .checkbox").click(function () {
        if (!$(this).hasClass('CheckBoxSel')) {
            $(this).addClass('CheckBoxSel');
        } else {
            $(this).removeClass('CheckBoxSel');
        }
        ;
    });
    
    $('.m_notice dl dd em').on('click', function () {
        var parent = $(this).parent();
        if (!parent.hasClass('hover')) {
            parent.addClass('hover');
            $(this).html($(this).html().replace('收起', '详情').replace('icon_shouqi', 'icon_zhankai'));
        } else {
            parent.removeClass('hover');
            $(this).html($(this).html().replace('详情', '收起').replace('icon_zhankai', 'icon_shouqi'));
            if (!parent.parent().hasClass('read')) {
                read_message($(this).data('id'), parent.parent());
            }
            ;

        }
    });
    
    $(function () {
        $('.m_notice dl dd em').each(function () {
            var dd = $(this).parent();
            if (dd.height() > 26) {
                $(this).show();
                dd.addClass('hover');
            } else {
                if (!dd.parent().hasClass('read')) {
                    read_message($(this).data('id'), dd.parent());
                }
                ;
                $(this).hide()
            }
        });
    });
    
    $("#selectAll").click(function () {
        if (!$(this).hasClass('CheckBoxSel')) {
            $(".checkbox").addClass('CheckBoxSel');

        } else {
            $(".checkbox").removeClass('CheckBoxSel');
        }
        ;
    });
    
    $("#delete").click(function () {
        var ids = '';
        $(".checkbox").each(function () {
            if ($(this).hasClass('CheckBoxSel')) {
                ids += $(this).data('id') + ',';
            }
        });
        if (!ids) {
            var d = dialog({
                title: '提示',
                fixed: true,
                content: '请选择您要删除的消息'
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
            }, 2000);
            return;
        }
        $.post(base_url + "index.php/user/my_delete_message",
                {
                    "ids": ids,
                },
                function (res) {
                    if (res.success) {
                        var d = dialog({
                            title: '提示',
                            fixed: true,
                            content: res.message
                        });
                        d.show();
                        setTimeout(function () {
                            window.location.reload();
                            d.close().remove();
                        }, 2000);
                        return false;
                    } else {
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
    });
    
    function read_message(id, obj) {
        $.post(base_url + "index.php/user/my_read_message",
                {
                    "id": id,
                },
                function (res) {
                    if (res.success) {
                        obj.addClass('read');
                    } else {
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
