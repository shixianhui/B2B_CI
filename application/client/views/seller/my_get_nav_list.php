<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">导航设置</span>
            <a href="<?php echo getBaseUrl(false, '', 'seller/my_save_nav.html', $client_index); ?>" class="add_btn">+ 新增导航</a>
        </div>
        <div class="nav_list mt15">
            <table class="form_list">
                <thead>
                    <tr>
                        <th width="15%">导航名称</th>
                        <th>链接</th>
                        <th width="15%">排序</th>
                        <th width="15%">是否显示</th>
                        <th width="15%">操作</th>
                    </tr>
                </thead>
                <tbody id="nodeBox">
                    <?php
                    if($item_list){
                        foreach($item_list as $item){
                    ?>
                    <tr class="form_tr">
                        <td width="15%"><?php echo $item['title'];?></td>
                        <td title="<?php echo $item['url'];?>"><?php echo my_substr($item['url'],40);?></td>
                        <td width="15%" class="sort"><input size="4" type="text" style="text-align: center;" name="sort" value="<?php echo $item['sort'];?>" onblur="change_nav_sort(<?php echo $item['id'];?>,this,<?php echo $item['display'];?>)" class="input_txt"></td>
                        <td width="15%"><span class="icon <?php echo $item['display']==1 ? 'icon_red' : 'icon_gray';?>" style="cursor: pointer;" onclick="change_nav_display(<?php echo $item['id'];?>,this)"></span></td>
                        <td class="link_action" width="15%">
                            <a href="<?php echo getBaseUrl(false,'','seller/my_save_nav/'.$item['id'].'.html', $client_index);?>">编辑</a>
                            <a href="javascript:void(0)" onclick="delete_navigation(<?php echo $item['id'];?>,this)">删除</a>
                        </td>
                    </tr>
                    <?php }}?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
	function change_nav_sort(id, obj) {
		$.post(base_url + 'index.php/seller/my_change_nav_sort', {
			'id': id,
			'sort': $(obj).val()
		}, function(data) {
			if(data.success == false) {
				var d = dialog({
					width: 300,
					title: '提示',
					fixed: true,
					content: data.message
				});
				d.show();
				setTimeout(function() {
					d.close().remove();
				}, 2000);
				return false;
			}
			$("#nodeBox").html('');
			$.each(data.data, function(i) {
				var short_url = data.data[i].url.substr(0, 40);
				if(short_url.length != data.data[i].url.length) {
					short_url += '...';
				}
				if(data.data[i].display == 1) {
					var icon = 'icon_red';
				} else {
					var icon = 'icon_gray';
				}
				var html = '<tr class="form_tr">\
                        <td width="15%">' + data.data[i].title + '</td>\
                        <td title="' + data.data[i].url + '">' + short_url + '</td>\
                        <td width="15%" class="sort"><input size="4" type="text" style="text-align: center;" name="sort" value="' + data.data[i].sort + '" onblur="change_nav_sort(' + data.data[i].id + ',this)" class="input_txt"></td>\
                        <td width="15%"><span class="icon ' + icon + '" style="cursor: pointer;" onclick="change_nav_display(' + data.data[i].id + ',this)"></span></td>\
                        <td class="link_action" width="15%">\
                            <a href="index.php/seller/my_save_nav/' + data.data[i].id + '.html">编辑</a>\
                            <a href="javascript:void(0)" onclick="delete_navigation(' + data.data[i].id + ',this)">删除</a>\
                        </td>\
                    </tr>';
				$("#nodeBox").append(html);
			});
		}, 'json');
	}

	function change_nav_display(id, obj) {
		if($(obj).hasClass('icon_gray')) {
			var display = 1;
		} else {
			var display = 0;
		}
		$.post(base_url + 'index.php/seller/my_change_nav_display', {
			'id': id,
			'display': display
		}, function(data) {
			if(data.success == false) {
				var d = dialog({
					width: 300,
					title: '提示',
					fixed: true,
					content: data.message
				});
				d.show();
				setTimeout(function() {
					d.close().remove();
				}, 2000);
				return false;
			}
			if(display == 1) {
				$(obj).removeClass('icon_gray');
				$(obj).addClass('icon_red');
			} else {
				$(obj).removeClass('icon_red');
				$(obj).addClass('icon_gray');
			}
		}, 'json');
	}

	function delete_navigation(id, obj) {
		var d = dialog({
			title: '提示',
			width: 300,
			fixed: true,
			content: '您确定要删除此导航吗？',
			okValue: '确定',
			ok: function() {
				$.post(base_url + 'index.php/seller/my_delete_navigation', {
					'id': id
				}, function(data) {
					if(data.success == false) {
						var d = dialog({
							width: 300,
							title: '提示',
							fixed: true,
							content: data.message
						});
						d.show();
						setTimeout(function() {
							d.close().remove();
						}, 2000);
						return false;
					}
					$(obj).parents('tr').remove();
				}, 'json');
			},
			cancelValue: '取消',
			cancel: function() {}
		});
		d.show();
	}
</script>