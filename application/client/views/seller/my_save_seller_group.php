<div class="member_right mt20">
    <div class="box_shadow clearfix m_border">
        <div class="member_title"><span class="bt">新增部门</span><span style="float: right;font-size:16px;"><a href="<?php echo getBaseUrl(false, '', 'seller/my_seller_group_list.html', $client_index) ?>" style="color:#333;">返回</a></span></div>
<!--       <form action="--><?php //echo $_SERVER['REQUEST_URI'];?><!--" method="post" name="jsonForm" id="jsonForm">-->
        <div class="b_shop_update">
            <ul class="m_form fl">
                <input name="id" id="id" value="<?php if(! empty($item_info)){ echo $item_info['id'];} ?>" type="hidden">
                <li class="clearfix"><span>部门名称：</span><input type="text" name="group_name" id="group_name" value="<?php if($item_info){ echo $item_info['group_name'];}?>" valid="required" maxlength="100" errmsg="部门名称不能为空" class="input_txt">

                </li>
                <li class="clearfix"><span>权限设置：</span>
                    <font color="red" style="font-size: 14px">注：查看权限优先；删除，修改等权限一般在列表上才能看到</font><br/>
                    <div id="permissions_tree" style="margin-left: 100px;"></div>
                </li>

            </ul>
        </div>
        <div class="clear"></div>
        <div style="margin:20px 0px 20px 200px; clear:both; display:block;">
            <a href="javascript:void(0);" class="b_btn" id="btn_admin_group_save">确认提交</a>
        </div>
<!--        </form>-->
    </div>
</div>
<script type="text/javascript" src="js/admin/jquery.tree.js"></script>
<script type="text/javascript" src="js/admin/jquery.tree.checkbox.js"></script>
<script>
    //==================================管理员组权限====================================
    var permissions = "<?php if(! empty($item_info)){ echo $item_info['permissions'];} ?>".split(',');
    var permissionsList = [{
        data: '店铺管理 ',
        attributes:{'permission':'seller_g'},
        state: "close",
        children:[{
            data: '我的店铺',
            attributes:{'permission':'seller'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'seller_index'}},
                {data: '添加',attributes:{'permission':'seller_add'}},
                {data: '修改',attributes:{'permission':'useller_edit'}},
                {data: '删除',attributes:{'permission':'seller_delete'}}]
        },{
            data: '首页装修',
            attributes:{'permission':'ad_store'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'ad_store_index'}},
                {data: '添加',attributes:{'permission':'ad_store_add'}},
                {data: '修改',attributes:{'permission':'ad_store_edit'}},
                {data: '删除',attributes:{'permission':'ad_store_delete'}}]
        },{
            data: '店铺模版',
            attributes:{'permission':'theme'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'theme_index'}},
                {data: '添加',attributes:{'permission':'theme_add'}},
                {data: '修改',attributes:{'permission':'theme_edit'}},
                {data: '删除',attributes:{'permission':'theme_delete'}}]
        },{
            data: '导航设置',
            attributes:{'permission':'navigation'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'navigation_index'}},
                {data: '添加',attributes:{'permission':'navigation_add'}},
                {data: '修改',attributes:{'permission':'navigation_edit'}},
                {data: '删除',attributes:{'permission':'navigation_delete'}}]
        }]
    },{
        data: '交易管理 ',
        attributes:{'permission':'order_g'},
        state: "close",
        children:[{
            data: '已卖出的宝贝',
            attributes:{'permission':'order'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'order_index'}},
                {data: '添加',attributes:{'permission':'order_add'}},
                {data: '修改',attributes:{'permission':'order_edit'}},
                {data: '删除',attributes:{'permission':'order_delete'}}]
        },{
            data: '评价管理',
            attributes:{'permission':'comment'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'comment_index'}},
                {data: '添加',attributes:{'permission':'comment_add'}},
                {data: '修改',attributes:{'permission':'comment_edit'}},
                {data: '删除',attributes:{'permission':'comment_delete'}}]
        },{
            data: '退换货管理',
            attributes:{'permission':'exchange'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'exchange_index'}},
                {data: '添加',attributes:{'permission':'exchange_add'}},
                {data: '修改',attributes:{'permission':'exchange_edit'}},
                {data: '删除',attributes:{'permission':'exchange_delete'}}]
        }]
    },{
        data: '商品管理 ',
        attributes:{'permission':'product_g'},
        state: "close",
        children:[{
            data: '商品列表',
            attributes:{'permission':'product'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'product_index'}},
                {data: '添加',attributes:{'permission':'product_add'}},
                {data: '修改',attributes:{'permission':'product_edit'}},
                {data: '删除',attributes:{'permission':'product_delete'}}]
        },{
            data: '分类设置',
            attributes:{'permission':'product_category'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'product_category_index'}},
                {data: '添加',attributes:{'permission':'product_category_add'}},
                {data: '修改',attributes:{'permission':'product_category_edit'}},
                {data: '删除',attributes:{'permission':'product_category_delete'}}]
        },{
            data: '品牌设置',
            attributes:{'permission':'brand'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'brand_index'}},
                {data: '添加',attributes:{'permission':'brand_add'}},
                {data: '修改',attributes:{'permission':'brand_edit'}},
                {data: '删除',attributes:{'permission':'brand_delete'}}]
        },{
            data: '风格设置',
            attributes:{'permission':'style'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'style_index'}},
                {data: '添加',attributes:{'permission':'style_add'}},
                {data: '修改',attributes:{'permission':'style_edit'}},
                {data: '删除',attributes:{'permission':'style_delete'}}]
        },{
            data: '材质设置',
            attributes:{'permission':'material'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'material_index'}},
                {data: '添加',attributes:{'permission':'material_add'}},
                {data: '修改',attributes:{'permission':'material_edit'}},
                {data: '删除',attributes:{'permission':'material_delete'}}]
        },{
            data: '面料设置',
            attributes:{'permission':'fabric'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'fabric_index'}},
                {data: '添加',attributes:{'permission':'fabric_add'}},
                {data: '修改',attributes:{'permission':'fabric_edit'}},
                {data: '删除',attributes:{'permission':'fabric_delete'}}]
        },{
            data: '皮革设置',
            attributes:{'permission':'leather'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'leather_index'}},
                {data: '添加',attributes:{'permission':'leather_add'}},
                {data: '修改',attributes:{'permission':'leather_edit'}},
                {data: '删除',attributes:{'permission':'leather_delete'}}]
        },{
            data: '填充物设置',
            attributes:{'permission':'filler'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'filler_index'}},
                {data: '添加',attributes:{'permission':'filler_add'}},
                {data: '修改',attributes:{'permission':'filler_edit'}},
                {data: '删除',attributes:{'permission':'filler_delete'}}]
        }]
    },{
        data: '营销活动管理 ',
        attributes:{'permission':'groupon_g'},
        state: "close",
        children:[{
            data: '团预购活动',
            attributes:{'permission':'groupon'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'groupon_index'}},
                {data: '添加',attributes:{'permission':'groupon_add'}},
                {data: '修改',attributes:{'permission':'groupon_edit'}},
                {data: '删除',attributes:{'permission':'pgroupon_delete'}}]
        }]
    },{
        data: '物流管理 ',
        attributes:{'permission':'postage_way_g'},
        state: "close",
        children:[{
            data: '物流设置',
            attributes:{'permission':'postage_way'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'postage_way_index'}},
                {data: '添加',attributes:{'permission':'postage_way_add'}},
                {data: '修改',attributes:{'permission':'postage_way_edit'}},
                {data: '删除',attributes:{'permission':'postage_way_delete'}}]
        }]
    },{
        data: '子账号管理 ',
        attributes:{'permission':'seller_group_g'},
        state: "close",
        children:[{
            data: '部门设置',
            attributes:{'permission':'seller_group'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'seller_group_index'}},
                {data: '添加',attributes:{'permission':'seller_group_add'}},
                {data: '修改',attributes:{'permission':'seller_group_edit'}},
                {data: '删除',attributes:{'permission':'seller_group_delete'}}]
        },{
            data: '账号管理',
            attributes:{'permission':'user'},
            state: "open",
            children:[{data: '查看',attributes:{'permission':'user_index'}},
                {data: '添加',attributes:{'permission':'user_add'}},
                {data: '修改',attributes:{'permission':'user_edit'}},
                {data: '删除',attributes:{'permission':'user_delete'}}]
        }]
    }];
    if ($("#permissions_tree").size()) {
        $("#permissions_tree").tree({
            data: {
                'type': "json",
                opts: {
                    'static': {
                        data: "所有权限",
                        children: permissionsList,
                        state: "open"
                    }
                }
            },
            ui: {
                theme_name: "checkbox"
            },
            plugins: {
                checkbox: {}
            },
            types: {
                'default':{
                    draggable	: false,
                }
            }
        });
        if(permissions){
            $.each($("#permissions_tree li"),function(i,n){
                if(jQuery.inArray($(n).attr('permission'),permissions)!=-1){
                    $(n).children('a')[0].className = 'checked';
                }
            });

        }
    }
    $(document).ready(function() {
        $("#btn_admin_group_save").click(function(){
            var $id = $("#id").val();
            var $group_name = $("#group_name").val();
            var $permission = '';
            $.each($("#permissions_tree a.checked"),function(i,n){
                if($(n).parent().attr('permission')){
                    $permission += $(n).parent().attr('permission')+',';
                }
            })
            if (! $group_name) {
                alert('部门名称不能为空！');
                $("#group_name").focus();
                return false;
            }
            if (! $permission) {
                alert('权限设置不能为空！');
                return false;
            }
            $.post(base_url+"index.php/"+controller+"/my_save_seller_group/"+$id,
                {	"group_name": $group_name,
                    "permissions": $permission.substr(0, $permission.length-1)
                },
                function(res){
                    if(res.success){
                        window.location.href = res.field;
                        return false;
                    }else{
                        alert(res.message);
                        return false;
                    }
                },
                "json"
            );
        });
    });
</script>
