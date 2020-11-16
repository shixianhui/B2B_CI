<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">首页装修</span></div>
        <h3 class="mt20">店铺首页导航下方广告位</h3>
        <div class="b_new_ad" id="adver1">
            <div class="tip"><a href="javascript:void(0)" class="btn_upload">上传图片 <input style="filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="path_file1" multiple="multiple" name="path_file1[]"></a>旺铺旗舰版原图尺寸大小1920px*700px旺铺标准版原图尺寸大小1200px*500px,图片大小 <2M，最多上传5张图片，支持批量上传。</div>
            <?php
            if ($ad_store_list_1) {
                foreach ($ad_store_list_1 as $item) {
                    ?>
                    <dl data-id="<?php echo $item['id']; ?>" data-sort="<?php echo $item['sort']; ?>">
                        <dt><a href="javascript:void(0)" class="icon move_up1"></a><a data-lightbox="image_list_group_1" data-title="广告图片效果" href="<?php echo $item['path']; ?>"><img src="<?php echo str_replace('.', '_thumb.', $item['path']); ?>" class="picture"></a></dt>
                        <dd>
                            <p>
                                <label><span>广告内容：</span><input type="text" value="<?php echo $item['ad_text']; ?>" class="ad_text"></label>
                                <label><span>链接地址：</span><input type="text" value="<?php echo $item['url']; ?>" class="ad_url"></label>
                            </p>
                            <a href="javascript:void(0)" class="icon delete_ad"></a>
                        </dd>
                    </dl>
                <?php
                }
            }
            ?>
        </div>
        <h3 class="mt20">店铺首页产品展示广告位</h3>
        <div class="b_new_ad"  id="adver2">
            <div class="tip"><a href="javascript:void(0)" class="btn_upload">上传图片<input style="filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="path_file2" multiple="multiple" name="path_file2[]"></a>旺铺旗舰版原图尺寸大小1200px*500px旺铺标准版原图尺寸大小580px*580px,图片大小 <2M，最多上传5张图片，支持批量上传。</div>
             <?php
            if ($ad_store_list_2) {
                foreach ($ad_store_list_2 as $item) {
                    ?>
            <dl data-id="<?php echo $item['id']; ?>" data-sort="<?php echo $item['sort']; ?>"><dt><a href="javascript:;" class="icon move_up2"></a><a data-lightbox="image_list_group_2" data-title="广告图片效果" href="<?php echo $item['path']; ?>"><img src="<?php echo str_replace('.', '_thumb.', $item['path']); ?>" class="picture1"></a></dt>
                <dd>
                    <p>
                                <label><span>广告内容：</span><input type="text" value="<?php echo $item['ad_text']; ?>" class="ad_text"></label>
                                <label><span>链接地址：</span><input type="text" value="<?php echo $item['url']; ?>" class="ad_url"></label>
                     </p>
                    <a href="javascript:void(0)" class="icon delete_ad"></a>
                </dd>
            </dl>
                   <?php
                }
            }
            ?>
        </div>
        <div class="clear"></div>
        <div style="text-align:center; margin:20px 0px; clear:both; display:block;">
            <a href="javascript:;" class="b_btn" id="b_btn">保存</a>
        </div>
    </div>
</div>
<link rel="stylesheet" href="js/admin/lightbox2-master/src/css/lightbox.css">
<script src="js/admin/lightbox2-master/src/js/lightbox.js"></script>
<script>
    lightbox.option({
      'resizeDuration': 500,
      'wrapAround': true
    })
</script>
<script language="javascript" type="text/javascript">
	$("#path_file1").wrap("<form id='path_upload1' action='" + base_url + "index.php/upload/upload_ad_store' method='post' enctype='multipart/form-data'></form>");
	$("#path_file1").change(function() { //选择文件
		$("#path_upload1").ajaxSubmit({
			dataType: 'json',
			data: {
				'model': 'ad_store1',
				'field': 'path_file1'
			},
			beforeSend: function() {
				$('body').append($('<div id="loading"></div>'));
			},
			uploadProgress: function(event, position, total, percentComplete) {},
			success: function(res) {
				$("#loading").remove();
				if(res.success == true) {
					$(res.data).each(function(index, obj) {
						var html = '<dl data-id="' + obj.id + '" data-sort="' + obj.sort + '"><dt><a href="javascript:void(0)" class="icon move_up1"></a><a data-lightbox="image_list_group_1" data-title="广告图片效果" href="' + obj.file_path + '"><img src="' + obj.file_path.replace(/\./, '_thumb.') + '" class="picture"></a></dt>\
                                                <dd>\
                                                         <p>\
                                                            <label><span>广告内容：</span><input type="text" value="" class="ad_text"></label>\
                                                            <label><span>链接地址：</span><input type="text" value="" class="ad_url"></label>\
                                                         </p>\
                                                        <a href="javascript:void(0)" class="icon delete_ad"></a>\
                                                </dd>\
                                                </dl>';
						$("#adver1").append(html);
					});
				} else {
					var d = dialog({
						fixed: true,
						title: '提示',
						content: res.message
					});
					d.show();
					setTimeout(function() {
						d.close().remove();
					}, 2000);
				}
			},
			error: function(xhr) {}
		});
	});
	$("#path_file2").wrap("<form id='path_upload2' action='" + base_url + "index.php/upload/upload_ad_store' method='post' enctype='multipart/form-data'></form>");
	$("#path_file2").change(function() { //选择文件
		$("#path_upload2").ajaxSubmit({
			dataType: 'json',
			data: {
				'model': 'ad_store2',
				'field': 'path_file2'
			},
			beforeSend: function() {
				$('body').append($('<div id="loading"></div>'));
			},
			uploadProgress: function(event, position, total, percentComplete) {},
			success: function(res) {
				$("#loading").remove();
				if(res.success == true) {
					$(res.data).each(function(index, obj) {
						var html = '<dl data-id="' + obj.id + '" data-sort="' + obj.sort + '"><dt><a href="javascript:void(0)" class="icon move_up2"></a><a data-lightbox="image_list_group_2" data-title="广告图片效果" href="' + obj.file_path + '"><img src="' + obj.file_path.replace(/\./, '_thumb.') + '" class="picture1"></a></dt>\
                                                <dd>\
                                                          <p>\
                                                            <label><span>广告内容：</span><input type="text" value="" class="ad_text"></label>\
                                                            <label><span>链接地址：</span><input type="text" value="" class="ad_url"></label>\
                                                         </p>\
                                                        <a href="javascript:void(0)" class="icon delete_ad"></a>\
                                                </dd>\
                                    </dl>';
						$("#adver2").append(html);
					});
				} else {
					var d = dialog({
						fixed: true,
						title: '提示',
						content: res.message
					});
					d.show();
					setTimeout(function() {
						d.close().remove();
					}, 2000);
				}
			},
			error: function(xhr) {}
		});
	});
	$("#adver1,#adver2").delegate('.delete_ad', 'click', function() {
		var dl = $(this).parents('dl');
		var id = dl.data('id');
		$.post(base_url + 'index.php/seller/my_delete_ad_store', {
			'id': id
		}, function(data) {
			if(data.success == true) {
				dl.remove();
			} else {
				var d = dialog({
					fixed: true,
					title: '提示',
					content: data.message
				});
				d.show();
				setTimeout(function() {
					d.close().remove();
				}, 2000);
			}
		}, 'json');
	});
	$("#adver1").delegate('.move_up1', 'click', function() {
		var eq = $("#adver1 dl").index($(this).parents('dl'));
		if(eq > 0) {
			var current_sort = $(this).parents('dl').data('sort');
			var last_sort = $("#adver1 dl").eq(eq - 1).data('sort');
			$(this).parents('dl').data('sort', last_sort);
			$("#adver1 dl").eq(eq - 1).data('sort', current_sort);
			$(this).parents('dl').after($("#adver1 dl").eq(eq - 1));
		}
	});
	$("#adver2").delegate('.move_up2', 'click', function() {
		var eq = $("#adver2 dl").index($(this).parents('dl'));
		if(eq > 0) {
			var current_sort = $(this).parents('dl').data('sort');
			var last_sort = $("#adver2 dl").eq(eq - 1).data('sort');
			$(this).parents('dl').data('sort', last_sort);
			$("#adver2 dl").eq(eq - 1).data('sort', current_sort);
			$(this).parents('dl').after($("#adver2 dl").eq(eq - 1));
		}
	});
	$("body").delegate('#b_btn', 'click', function() {
		var arr = [];
		$($(".b_new_ad dl")).each(function(index, obj) {
			var json = {};
			json.id = $(obj).data('id');
			json.sort = $(obj).data('sort');
			json.ad_text = $(obj).find('.ad_text').val();
			json.url = $(obj).find('.ad_url').val();
			arr.push(json);
		});
		$.ajax({
			type: "POST",
			url: base_url + 'index.php/seller/my_ad_store_save',
			contentType: "application/json; charset=utf-8",
			data: JSON.stringify(arr),
			dataType: "json",
			success: function(data) {
				if(data.success) {
					var d = dialog({
						title: '提示',
						width: 300,
						fixed: true,
						content: '保存成功',
						okValue: '确定',
						ok: function() {
							location.reload();
						}
					});
					d.show();
				} else {
					var d = dialog({
						fixed: true,
						title: '提示',
						content: data.message
					});
					d.show();
					setTimeout(function() {
						d.close().remove();
					}, 2000);
				}
			},
			error: function(message) {
				alert("提交数据失败！");
			}
		});
	})
</script>