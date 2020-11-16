<?php

class Seller extends CI_Controller {

    private $_status = array(
        '0' => '<font color="#ff4200">未付款</font>',
        '1' => '<font color="#cc3333">已付款</font>',
        '2' => '<font color="#ff811f">待收货</font>',
        '3' => '<font color="#066601">交易成功</font>',
        '4' => '<font color="#a0a0a0">交易关闭</font>',
    );
    private $_measurement = array(
        '1' => '件',
        '2' => 'kg',
        '3' => 'm³',
    );
    private $_hideValue = array(
        'a' => 0,
        'b' => 1,
        'c' => 2,
        'd' => 3,
        'e' => 4
    );
    private $_exchange_reason_arr = array(
        '0'=>'无理由退货',
        '1'=>'不需要/不想的商品',
        '2'=>'其它'
    );
    private $_exchange_status_arr = array(
        '0'=>'<font color="red">待审核</font>',
        '1'=>'审核未通过',
        '2'=>'审核通过',
        '3'=>'退款到余额成功',
//        '4'=>'原路返回退款成功'
    );

    private $_exchange_status2_arr = array(
        '0'=>'(退款审核中)',
        '1'=>'(退款审核拒绝)',
        '2'=>'(退款审核通过)',
        '3'=>'(退款成功)',
//        '4'=>'(退款成功)'
    );
    private $_comment_status_arr = array(
        '0'=>'未回复',
        '1'=>'已回复'
    );
    private $_evaluate_arr = array(
        '1'=>'好评',
        '2'=>'中评',
        '3'=>'差评',
    );
    private $_table = 'user';
    private $_template = 'seller';
    private $_auth_type = array('1'=>'实体商家认证','2'=>'实体厂家认证','3'=>'实力电商认证','4'=>'个人实名认证');
    private $_options_arr = array('1'=>'7天无理由退换','2'=>'45天无理由退换','3'=>'包物流','4'=>'送货入户并安装','5'=>'一年质保');
    public function __construct() {
        parent::__construct();
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Store_model', '', TRUE);
        $this->load->model('Navigation_model', '', TRUE);
        $this->load->model('Material_model', '', TRUE);
        $this->load->model('Fabric_model', '', TRUE);
        $this->load->model('Leather_model', '', TRUE);
        $this->load->model('Filler_model', '', TRUE);
        $this->load->model('Brand_model', '', TRUE);
        $this->load->model('Style_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Postage_way_model', '', TRUE);
        $this->load->model('Postage_price_model', '', TRUE);
        $this->load->model('Product_category_model', '', TRUE);
        $this->load->model('Product_category_ids_model', '', TRUE);
        $this->load->model('Theme_model', '', TRUE);
        $this->load->model('Orders_model', '', TRUE);
        $this->load->model('Ad_store_model', '', TRUE);
        $this->load->model('Area_model', '', TRUE);
        $this->load->model('Browse_model', '', TRUE);
        $this->load->model('Favorite_model', '', TRUE);
        $this->load->model('Product_size_color_model', '', TRUE);
        $this->load->model('Orders_detail_model', '', TRUE);
        $this->load->model('Attachment_model', '', TRUE);
        $this->load->model('Pay_log_model', '', TRUE);
        $this->load->model('Orders_process_model', '', TRUE);
        $this->load->model('Financial_model', '', TRUE);
        $this->load->model('Exchange_model', '', TRUE);
        $this->load->model('Comment_model', '', TRUE);
        $this->load->model('Comment_store_model', '', TRUE);
        $this->load->model('Store_reply_comment_model', '', TRUE);
        $this->load->model('Seller_group_model', '', TRUE);
        $this->load->model('Promotion_ptkj_model', '', TRUE);
        $this->load->model('Pintuan_model', '', TRUE);
        $this->load->model('Ptkj_record_model', '', TRUE);
        $this->load->library('Form_validation');
    }

    public function index() {
        //判断是否登录
        checkLogin(true);
        checkPermission("seller_index");
        $systemInfo = $this->System_model->get('*', array('id' => 1));
//        $user_id = get_cookie('user_id');
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $item_info = $this->Store_model->get('*', array('user_id' => $seller_group_info['user_id']));
        $province_list = $this->Area_model->gets('*', array('parent_id' => 0));
        if ($_POST) {
            $path = $this->input->post('path', TRUE);
            $list_path_logo = $this->input->post('list_path_logo', TRUE);
            $store_banner = $this->input->post('store_banner', TRUE);
            $app_banner = $this->input->post('app_banner', TRUE);
            $store_name = trim($this->input->post('store_name', TRUE));
            $description = $this->input->post('description', TRUE);
            $business_scope = $this->input->post('business_scope', TRUE);
            $province_id = intval($this->input->post('province_id', TRUE));
            $city_id = intval($this->input->post('city_id', TRUE));
            $area_id = intval($this->input->post('area_id', TRUE));
            $address = $this->input->post('address', TRUE);
            $mobile = trim($this->input->post('mobile', TRUE));
            $contact_num = trim($this->input->post('contact_num', TRUE));
            $im_qq = $this->input->post('im_qq', TRUE);
            $im_weixin = $this->input->post('im_weixin', TRUE);
            $im_ww = $this->input->post('im_ww', TRUE);
            $work_time = trim($this->input->post('work_time', TRUE));
            $auth_store_type = $this->input->post('auth_store_type', TRUE);
            $auth_file_path = $this->input->post('auth_file_path', TRUE);
            $id_card_path_1 = $this->input->post('id_card_path_1', TRUE);
            $id_card_path_2 = $this->input->post('id_card_path_2', TRUE);
            $license_path = $this->input->post('license_path', TRUE);
            if (!$this->form_validation->required($store_name)) {
                printAjaxError('store_name', '店铺名称不能为空');
            }
            if (!$province_id || !$city_id || !$area_id) {
                printAjaxError('area', '省市区不能为空');
            }
            if (!$this->form_validation->required($mobile)) {
                printAjaxError('mobile', '手机号不能为空');
            }
            if (!preg_match('/^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/', $mobile)) {
                printAjaxError('mobile', '请填写正确手机号');
            }
            if ($im_qq && !preg_match('/^[1-9]\d{4,10}$/', $im_qq)) {
                printAjaxError('im_qq', '请填写正确qq号');
            }
            if ($im_weixin && !preg_match('/^[a-zA-Z\d_]{5,}$/', $im_weixin)) {
                printAjaxError('im_weixin', '请填写正确微信号');
            }
            if (!$this->form_validation->required($auth_store_type)) {
                printAjaxError('auth_store_type', '请选择认证类型');
            }
            if (!$this->form_validation->required($auth_file_path)) {
                printAjaxError('auth_file_path', '请上传认证');
            }
            if ($auth_store_type != 4 && empty($license_path)){
                printAjaxError('auth_file_path', '请上传营业执照照片');
            }
            $txt_address_str = '';
            $area_info = $this->Area_model->get('name', array('id' => $province_id));
            if ($area_info) {
                $txt_address_str .= $area_info['name'];
            }
            $area_info = $this->Area_model->get('name', array('id' => $city_id));
            if ($area_info) {
                $txt_address_str .= ' ' . $area_info['name'];
            }
            $area_info = $this->Area_model->get('name', array('id' => $area_id));
            if ($area_info) {
                $txt_address_str .= ' ' . $area_info['name'];
            }
            $fields = array(
                'path' => $path,
                'list_path_logo' => $list_path_logo,
                'store_banner' => $store_banner,
                'app_banner' => $app_banner,
                'description' => $description,
                'business_scope' => $business_scope,
                'province_id' => $province_id,
                'city_id' => $city_id,
                'area_id' => $area_id,
                'address' => $address,
                'mobile' => $mobile,
                'contact_num' => $contact_num,
                'im_qq' => $im_qq,
                'im_weixin' => $im_weixin,
                'im_ww' => $im_ww,
                'work_time' => $work_time,
                'txt_address' => $txt_address_str,
                'auth_file_path' => $auth_file_path,
                'auth_store_type' => $auth_store_type,
                'id_card_path_1' => $id_card_path_1,
                'id_card_path_2' => $id_card_path_2,
                'license_path' => $license_path,
            );
            $result = $this->Store_model->save($fields, array('id' => $item_info['id']));
            if ($result) {
                printAjaxSuccess($_SERVER['REQUEST_URI'], '保存成功');
            } else {
                printAjaxError('fail', '保存失败');
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '我的店铺_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info' => $item_info,
            'province_list' => $province_list,
            'auth_type' => $this->_auth_type,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/index", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //我要入驻
    public function my_join($store_id = NULL) {
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $user_id = get_cookie('user_id');
        $province_list = $this->Area_model->gets('*', array('parent_id' => 0));
        $item_info = NULL;
        $item_info = $this->Store_model->get('*', array('user_id' => $user_id));
        if ($store_id) {
            if ($item_info) {
                if ($item_info['display'] == 2 && $item_info['id'] != $store_id) {
                    $data = array(
                        'user_msg' => '操作异常',
                        'user_url' => base_url()
                    );
                    $this->session->set_userdata($data);
                    redirect(base_url() . 'index.php/message/index');
                    exit;
                }
            }
        }
        if ($_POST) {
            $store_type = intval($this->input->post('store_type', TRUE));
            $store_name = trim($this->input->post('store_name', TRUE));
            $province_id = intval($this->input->post('province_id', TRUE));
            $city_id = intval($this->input->post('city_id', TRUE));
            $area_id = intval($this->input->post('area_id', TRUE));
            $address = $this->input->post('address', TRUE);
            $owner_name = $this->input->post('owner_name', TRUE);
            $owner_card = $this->input->post('owner_card', TRUE);
            $mobile = $this->input->post('mobile', TRUE);
            $im_qq = $this->input->post('im_qq', TRUE);
            $im_weixin = $this->input->post('im_weixin', TRUE);
            $im_ww = $this->input->post('im_ww', TRUE);
            $auth_store_type = $this->input->post('auth_store_type', TRUE);
            $auth_file_path = $this->input->post('auth_file_path', TRUE);
            $user_id = get_cookie('user_id');
            //检测用户是否已经入住店铺
            $store_info = $this->Store_model->get('display, close_reason', array('user_id' => $user_id));
            if ($store_info) {
                if ($store_info['display'] == 0) {
                    printAjaxError('fail', '您已提交店铺申请，正在审核中...');
                } else if ($store_info['display'] == 1) {
                    printAjaxError('fail', '您已入驻，不用重复申请');
                } else if ($store_info['display'] == 3) {
                    printAjaxError('fail', '您的店铺已被关闭，请联系网站客服');
                }
            }
            $store_info = $this->Store_model->get('id', "store_name = '{$store_name}' and user_id <> {$user_id} ");
            if ($store_info) {
                printAjaxError('fail', '此店铺名称已被使用，请换个试试');
            }
            if ($store_type < 1 || $store_type > 3) {
                printAjaxError('store_type', '请选择店铺类型');
            }
            if (!$this->form_validation->required($store_name)) {
                printAjaxError('store_name', '店铺名称不能为空');
            }
            if (!$province_id || !$city_id || !$area_id) {
                printAjaxError('area', '省市区不能为空');
            }
            if (!$this->form_validation->required($owner_name)) {
                printAjaxError('owner_name', '店主姓名不能为空');
            }
            if (!$this->form_validation->required($owner_card)) {
                printAjaxError('owner_card', '店主身份证号不能为空');
            }
            if (!preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/', $owner_name)) {
                printAjaxError('owner_name', '店主姓名只包含中文名，2-4位');
            }
            if (!$this->_checkIdentity($owner_card)) {
                printAjaxError('owner_card', '请填写正确的身份证号');
            }
            if (!$this->form_validation->required($mobile)) {
                printAjaxError('mobile', '手机号不能为空');
            }
            if (!preg_match('/^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/', $mobile)) {
                printAjaxError('mobile', '请填写正确手机号');
            }
            if ($im_qq && !preg_match('/^[1-9]\d{4,10}$/', $im_qq)) {
                printAjaxError('im_qq', '请填写正确qq号');
            }
            if ($im_weixin && !preg_match('/^[a-zA-Z\d_]{5,}$/', $im_weixin)) {
                printAjaxError('im_weixin', '请填写正确微信号');
            }
            if (!$this->form_validation->required($auth_store_type)) {
                printAjaxError('auth_store_type', '请选择认证类型');
            }
            if (!$this->form_validation->required($auth_file_path)) {
                printAjaxError('auth_file_path', '请上传认证');
            }
            $txt_address_str = '';
            $area_info = $this->Area_model->get('name', array('id' => $province_id));
            if ($area_info) {
                $txt_address_str .= $area_info['name'];
            }
            $area_info = $this->Area_model->get('name', array('id' => $city_id));
            if ($area_info) {
                $txt_address_str .= ' ' . $area_info['name'];
            }
            $area_info = $this->Area_model->get('name', array('id' => $area_id));
            if ($area_info) {
                $txt_address_str .= ' ' . $area_info['name'];
            }

            $fields = array(
                'store_type' => $store_type,
                'store_name' => $store_name,
                'province_id' => $province_id,
                'city_id' => $city_id,
                'area_id' => $area_id,
                'address' => unhtml($address),
                'owner_name' => $owner_name,
                'owner_card' => $owner_card,
                'mobile' => $mobile,
                'im_qq' => $im_qq,
                'im_weixin' => $im_weixin,
                'im_ww' => unhtml($im_ww),
                'txt_address' => $txt_address_str,
                'user_id' => get_cookie('user_id'),
                'display' => 0,
                'store_category_id' => 1,
                'store_grade_id' => 1,
                'add_time' => time(),
                'auth_file_path' => $auth_file_path,
                'auth_store_type' => $auth_store_type,
                'reg_num' => trim($this->input->post('reg_num', TRUE)),
                'license_store_name' => trim($this->input->post('license_store_name', TRUE)),
                'license_username' => trim($this->input->post('license_username', TRUE)),
                'license_form' => trim($this->input->post('license_form', TRUE)),
                'license_place' => trim($this->input->post('license_place', TRUE)),
                'license_credit_code' => trim($this->input->post('license_credit_code', TRUE)),
                'license_store_type' => trim($this->input->post('license_store_type', TRUE)),
                'license_residence' => trim($this->input->post('license_residence', TRUE)),
                'license_representative' => trim($this->input->post('license_representative', TRUE)),
                'license_capital' => trim($this->input->post('license_capital', TRUE)),
                'license_made_time' => trim($this->input->post('license_made_time', TRUE)),
                'license_time_limit' => trim($this->input->post('license_time_limit', TRUE)),
                'license_business_scope' => trim($this->input->post('license_business_scope', TRUE)),
            );
            $result = $this->Store_model->save($fields, $store_id ? array('id' => $store_id, 'user_id' => $user_id) : NULL);
            if ($result) {
                printAjaxSuccess('success_store', '您的资料提交成功，我们会尽快处理您的申请');
            } else {
                printAjaxError('fail', '保存失败');
            }
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '我要入驻_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info' => $item_info,
            'store_id' => $store_id,
            'province_list' => $province_list,
            'auth_type' => $this->_auth_type,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_join", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //发布商品
    public function my_save_product($id = NULL) {
        //判断是否登录
        checkLogin(true);
        if ($id) {
            checkPermission("product_edit");
        } else {
            checkPermission("product_add");
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        //产品分类
        $product_category_list = $this->Product_category_model->menuTree();
        $my_product_category_list = $this->Product_category_model->menuTree($store_info['id']);
        //产品详细
        $item_info = $this->Product_model->get('*', array("product.id" => $id, 'store_id' => $store_info['id']));
        $color_size_list = NULL;
        $color_list = NULL;
        $size_list = NULL;
        if ($item_info) {
            //颜色与尺寸
            $color_list = $this->Product_size_color_model->gets('color_name, color_id, color_name_hint, path', array('product_id' => $item_info['id']), 'color_id');
            $size_list = $this->Product_size_color_model->gets('size_name, size_id, size_name_hint', array('product_id' => $item_info['id']), 'size_id');
            $color_size_list = $color_list;
            foreach ($color_size_list as $key => $value) {
                $color_size_list[$key]['size_list'] = $this->Product_size_color_model->gets('*', array('product_id' => $item_info['id'], 'color_id' => $value['color_id']), 'size_id');
            }
        }
        $tmp_product_num = '';
        $tmp_product_info = $this->Product_model->get("max(id) as 'max_id'");
        if ($tmp_product_info) {
            $tmp_product_num = sprintf("C%06d", $tmp_product_info['max_id'] + 1);
        }

        $attachment_list = array();
        if($item_info && $item_info['batch_path_ids']){
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }
        $pci_info = $this->Product_category_ids_model->gets('product_category_id', array('product_id' => $id));
        $style_list = $this->Style_model->gets("store_id = {$store_info['id']} or store_id = 0");
        $brand_list = $this->Brand_model->gets('*', "store_id = {$store_info['id']} or store_id = 0");
        $material_list = $this->Material_model->gets("store_id = {$store_info['id']} or store_id = 0");
        $fabric_list = $this->Fabric_model->gets("store_id = {$store_info['id']} or store_id = 0");
        $leather_list = $this->Leather_model->gets("store_id = {$store_info['id']} or store_id = 0");
        $filler_list = $this->Filler_model->gets("store_id = {$store_info['id']} or store_id = 0");
        if ($_POST) {
            $category_ids = $this->input->post('category_ids', TRUE);
            $product_category_id_arr = $this->input->post('product_category_id', TRUE);
            $title = $this->input->post('title', TRUE);
            $brand_name = $this->input->post('brand_name', TRUE);
            $style_name = $this->input->post('style_name', TRUE);
            $material_name = $this->input->post('material_name', TRUE);
            $fabric_name = $this->input->post('fabric_name', TRUE);
            $leather_name = $this->input->post('leather_name', TRUE);
            $filler_name = $this->input->post('filler_name', TRUE);
            $path = $this->input->post('path', TRUE);
            $batch_path_ids = $this->input->post('batch_path_ids', TRUE);
            $product_num = $this->input->post('product_num', TRUE);
            $market_price = $this->input->post('market_price', TRUE);
            $sell_price = $this->input->post('sell_price', TRUE);
            $unclear_price = $this->input->post('unclear_price', TRUE);
            $stock = $this->input->post('stock', TRUE);
            $recommend_to_store_index = $this->input->post('recommend_to_store_index', TRUE);
            $is_promise = $this->input->post('is_promise', TRUE);
            $service_options = $this->input->post('service_options', TRUE);
            $reduced_price = $this->input->post('reduced_price', TRUE);
            $content = $this->input->post('content');
            $app_content = $this->input->post('app_content');
            /**************************规格开始**************************/
            $product_color_name = $this->input->post('product_color_name', TRUE);
            $product_size_name = $this->input->post('product_size_name', TRUE);
            $color_size_open = $this->input->post('color_size_open', TRUE);
            //颜色
            $attribute_color_ids = $this->input->post('attribute_color_ids', TRUE);
            $attribute_color_name = $this->input->post('attribute_color_name', TRUE);
            $attribute_color_hint = $this->input->post('attribute_color_hint', TRUE);
            $attribute_path = $this->input->post('attribute_path', TRUE);
            //尺码
            $attribute_size_ids = $this->input->post('attribute_size_ids', TRUE);
            $attribute_size_name = $this->input->post('attribute_size_name', TRUE);
            $attribute_size_hint = $this->input->post('attribute_size_hint', TRUE);
            //属性价格
            $attribute_price = $this->input->post('attribute_price', TRUE);
            //属性数量
            $attribute_stock = $this->input->post('attribute_stock', TRUE);
            //属性编号
            $attribute_product_num = $this->input->post('attribute_product_num', TRUE);
            /**************************规格结束**************************/
            //开启了规格
            if ($color_size_open) {
                if (!$product_color_name || !$product_size_name) {
                    printAjaxError('fail', '请填写规格名称');
                }
                if (!$attribute_color_ids) {
                    printAjaxError('fail', "请选择{$product_color_name}");
                }
                if (!$attribute_size_ids) {
                    printAjaxError('fail', "请选择{$product_size_name}");
                }
                //颜色名称
                foreach ($attribute_color_ids as $key=>$value) {
                    if (!$attribute_color_name[$key]) {
                        printAjaxError('fail', "{$product_color_name}主属性存在没有填写项");
                    }
                }
                $attribute_color_name_filter = array_unique($attribute_color_name);
                if (count($attribute_color_name) != count($attribute_color_name_filter)) {
                    printAjaxError('fail', "{$product_color_name}主属性存在重复项");
                }
                //尺码名称
                foreach ($attribute_size_ids as $key=>$value) {
                    if (!$attribute_size_name[$key]) {
                        printAjaxError('fail', "{$product_size_name}主属性存在没有填写项");
                    }
                }
                $attribute_size_name_filter = array_unique($attribute_size_name);
                if (count($attribute_size_name) != count($attribute_size_name_filter)) {
                    printAjaxError('fail', "{$product_size_name}主属性存在重复项");
                }
                //价格
                foreach ($attribute_price as $value) {
                    if (!$value) {
                        printAjaxError('fail', '属性价格存在没有填写的项!');
                    }
                    if (!$this->form_validation->numeric($value)) {
                        printAjaxError('fail', '请填写正确的属性价格!');
                    }
                }
                //库存
                foreach ($attribute_stock as $value) {
                    if (!$this->form_validation->required($value)) {
                        printAjaxError('fail', '属性库存存在没有填写的项!');
                    }
                    if (!$this->form_validation->integer($value)) {
                        printAjaxError('fail', '请填写正确的属性库存!');
                    }
                }
            }

            if (!$category_ids) {
                printAjaxError('fail', '请选择商品分类');
            }
            if (!$this->form_validation->required($title)) {
                printAjaxError('title', '商品标题不能为空');
            }
            $store_product_category =  $this->Product_category_model->menuTree($store_info['id']);
            if($store_product_category){
                if(!$product_category_id_arr){
                    printAjaxError('product_category_id', '请选择本店分类!');
                }
            }
            if (!$this->form_validation->required($path)) {
                if (!$this->form_validation->required($batch_path_ids)){
                    printAjaxError('path', '请上传封面图');
                }
                $path_info = $this->Attachment_model->get('path',array('id'=>$batch_path_ids[0]));
                if (!$path_info){
                    printAjaxError('path', '请上传封面图');
                }
                $path = $path_info['path'];
            }
            if (!$this->form_validation->required($stock)) {
                printAjaxError('stock', '库存不能为空');
            }
            if (intval($stock) <= 0) {
                printAjaxError('stock', '库存不能小于等于0');
            }
            $category_id_1 = 0;
            $category_id_2 = 0;
            $category_ids_arr = explode(',', $category_ids);
            if ($category_ids_arr) {
                if (count($category_ids_arr) >= 1) {
                    $category_id_1 = $category_ids_arr[0];
                }
                if (count($category_ids_arr) >= 2) {
                    $category_id_2 = $category_ids_arr[1];
                }
            }
            if($batch_path_ids){
                $batch_path_ids = implode('_', $batch_path_ids);
                $batch_path_ids .= '_';
            }
            if ($service_options){
                $service_options = implode(',',$service_options);
            }
            $fields = array(
                'store_id' => $store_info['id'],
                'category_id_1' => $category_id_1,
                'category_id_2' => $category_id_2,
                'brand_name' => $brand_name,
                'style_name' => $style_name,
                'material_name' => $material_name,
                'fabric_name' => $fabric_name,
                'leather_name' => $leather_name,
                'filler_name' => $filler_name,
                'product_color_name'=>$product_color_name,
                'product_size_name'=> $product_size_name,
                'color_size_open'=>   $color_size_open,
                'product_num' => $product_num,
                'market_price' => $market_price,
                'sell_price' => $sell_price,
                'unclear_price' => $unclear_price ? $unclear_price : 0,
                'stock' => intval($stock),
                'title' => $title,
                'content' => unhtml($content),
                'app_content' => unhtml($app_content),
                'path' => $path,
                'batch_path_ids' => $batch_path_ids,
                'display' => 1,
                'add_time' => time(),
                'display_time' => time(),
                'recommend_to_store_index' => $recommend_to_store_index,
                'is_promise' => $is_promise,
                'service_options' => $service_options,
                'reduced_price' => $reduced_price,
            );
            $retId = $this->Product_model->save($fields, $id ? array('id' => $id) : $id);
            if ($retId) {
                $retId = $id ? $id : $retId;
                /** **********************尺寸颜色属性****************************** */
                $this->Product_size_color_model->delete(array('product_id'=> $retId));
                if ($color_size_open) {
                    if ($attribute_color_ids && $attribute_size_ids) {
                        foreach ($attribute_color_ids as $key => $value) {
                            foreach ($attribute_size_ids as $s_key=>$s_value) {
                                $color_size_fields = array(
                                    'color_name' =>    $attribute_color_name[$key],
                                    'color_name_hint'=>$attribute_color_hint[$key],
                                    'color_id'=>       $key+1,
                                    'path' =>          $attribute_path[$key],
                                    'size_name' =>     $attribute_size_name[$s_key],
                                    'size_name_hint'=> $attribute_size_hint[$s_key],
                                    'size_id'=>        $s_key+1,
                                    'price' =>         $attribute_price[$key*count($attribute_size_ids) + $s_key],
                                    'stock' =>         $attribute_stock[$key*count($attribute_size_ids) + $s_key],
                                    'product_num' =>   $attribute_product_num[$key*count($attribute_size_ids) + $s_key],
                                    'product_id' =>    $retId
                                );
                                $this->Product_size_color_model->save($color_size_fields);
                            }
                        }
                    }
                }
                /*                 * ****************添加本店分类ID******************** */
                $this->Product_category_ids_model->delete(array('product_id' => $retId));
                if ($product_category_id_arr) {
                    foreach ($product_category_id_arr as $key => $value) {
                        $id_arr = explode(",", $value);
                        if($id_arr){
                            $pc_fields = array(
                                'parent_id' => count($id_arr)==1 ? 0 : $id_arr[0],
                                'product_category_id' => count($id_arr)>1 ? $id_arr[1] : $id_arr[0] ,
                                'product_id' => $retId
                            );
                              $this->Product_category_ids_model->save($pc_fields);
                        }
                    }
                }
                printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_product_list.html', $systemInfo['client_index']), '保存成功');
            } else {
                printAjaxError('fail', '保存失败');
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '发布商品_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'options_arr' => $this->_options_arr,
            'product_category_list' => $product_category_list,
            'my_product_category_list' => $my_product_category_list,
            'item_info' => $item_info,
            'pci_info' => $pci_info,
            'brand_list' => $brand_list,
            'material_list' => $material_list,
            'fabric_list' => $fabric_list,
            'leather_list' => $leather_list,
            'filler_list' => $filler_list,
            'style_list' => $style_list,
            'color_size_list' => $color_size_list,
            'color_list'=>$color_list,
            'size_list'=>$size_list,
            'attachment_list' => $attachment_list,
            'tmp_product_num' => $tmp_product_num,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_product", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //设置封面图片
    public function my_select_path(){
        if ($_POST){
            $id = $this->input->post('id',TRUE);

        }
    }

    //商品列表
    public function my_get_product_list($clear = '1', $page = 0) {
        //判断是否登录
        checkLogin(true);
        checkPermission("product_index");
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $my_product_category_list = $this->Product_category_model->menuTree($store_info['id']);
        $style_list = $this->Style_model->gets(array('store_id' => $store_info['id']));
        $brand_list = $this->Brand_model->gets('*', array('store_id' => $store_info['id']));
        if ($clear) {
            $clear = 0;
            $this->session->unset_userdata(array('search' => ''));
        }
        $condition = "store_id = {$store_info['id']}";
        $strWhere = $this->session->userdata('search') ? $this->session->userdata('search') : $condition;
        if($_POST){
        	$strWhere = $condition;
            $title = trim($this->input->post('title',TRUE));
            $product_num = trim($this->input->post('product_num',TRUE));
            $brand_name = $this->input->post('brand_name',TRUE);
            $style_name = $this->input->post('style_name',TRUE);
            $product_category_ids = $this->input->post('product_category_id', TRUE);
            $recommend_to_store_index = $this->input->post('recommend_to_store_index', TRUE);
            $sell_price_start = $this->input->post('sell_price_start',TRUE);
            $sell_price_end = $this->input->post('sell_price_end',TRUE);

            if($title){
                $strWhere .= " and title regexp '{$title}' ";
            }
            if($product_num){
            	$strWhere .= " and product_num = '{$product_num}' ";
            }
            if($brand_name){
                $strWhere .= " and brand_name = '{$brand_name}' ";
            }
            if(!empty($style_name)){
                $strWhere .= " and style_name = '{$style_name}' ";
            }
            if(!empty($recommend_to_store_index)){
                $strWhere .= " and recommend_to_store_index = '{$recommend_to_store_index}' ";
            }
            if(!empty($sell_price_start) && !empty($sell_price_end)){
                $strWhere .= " and (sell_price >= '{$sell_price_start}' and sell_price <= '{$sell_price_end}') ";
            }
            if (!empty($product_category_ids)){
                $parent_id = 0;
                $product_category_id = 0;
                $product_category_ids_arr = explode(',', $product_category_ids);
                if ($product_category_ids_arr) {
                    if (count($product_category_ids_arr) >= 1) {
                        $parent_id = $product_category_ids_arr[0];
                    }
                    if (count($product_category_ids_arr) >= 2) {
                        $product_category_id = $product_category_ids_arr[1];
                    }
                }
                $product_id_arr = $this->Product_category_ids_model->gets('product_id', array('parent_id' => $parent_id, 'product_category_id' => $product_category_id));
                $ids = -1;
                if ($product_id_arr) {
                    foreach ($product_id_arr as $value) {
                        $product_ids[] = $value['product_id'];
                    }
                    $ids = implode(',', $product_ids);
                }
                $strWhere .= " and id IN ({$ids})";
            }
            $this->session->set_userdata('search', $strWhere);
        }
        //分页
        $paginationCount = $this->Product_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/seller/my_get_product_list/{$clear}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $paginationConfig['per_page'] = 10;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();
        $product_list = $this->Product_model->gets('id,path,title,brand_name,style_name,unclear_price,sell_price,stock,product_num,recommend_to_store_index', $strWhere, $paginationConfig['per_page'], $page);
        foreach ($product_list as $key => $value) {
            //分类
            $product_category_str = '';
            $p_c_i_list = $this->Product_category_ids_model->gets('*', array('product_id' => $value['id']));
            if ($p_c_i_list) {
                foreach ($p_c_i_list as $p_c_i_key => $p_c_i_value) {
                    $product_category_str .= $this->Product_category_model->getLocation($p_c_i_value['product_category_id']) . '<br/>';
                }
                if ($product_category_str) {
                    $product_category_str = substr($product_category_str, 0, -1);
                }
            }
            $product_list[$key]['product_category_str'] = $product_category_str;
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '商品管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'product_list' => $product_list,
            'pagination' => $pagination,
            'my_product_category_list' => $my_product_category_list,
            'style_list' => $style_list,
            'brand_list' => $brand_list,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_product_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_get_product_selector($clear = '1', $page = 0) {
        //判断是否登录
        checkLogin(true);
        checkPermission("product_index");
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $my_product_category_list = $this->Product_category_model->menuTree($store_info['id']);
        $style_list = $this->Style_model->gets(array('store_id' => $store_info['id']));
        $brand_list = $this->Brand_model->gets('*', array('store_id' => $store_info['id']));
        if ($clear) {
            $clear = 0;
            $this->session->unset_userdata(array('search' => ''));
        }
        $condition = "store_id = {$store_info['id']}";
        $strWhere = $this->session->userdata('search') ? $this->session->userdata('search') : $condition;
        if($_POST){
            $strWhere = $condition;
            $title = trim($this->input->post('title',TRUE));
            $product_num = trim($this->input->post('product_num',TRUE));
            $brand_name = $this->input->post('brand_name',TRUE);
            $style_name = $this->input->post('style_name',TRUE);
            $product_category_ids = $this->input->post('product_category_id', TRUE);
            $recommend_to_store_index = $this->input->post('recommend_to_store_index', TRUE);
            $sell_price_start = $this->input->post('sell_price_start',TRUE);
            $sell_price_end = $this->input->post('sell_price_end',TRUE);

            if($title){
                $strWhere .= " and title regexp '{$title}' ";
            }
            if($product_num){
                $strWhere .= " and product_num = '{$product_num}' ";
            }
            if($brand_name){
                $strWhere .= " and brand_name = '{$brand_name}' ";
            }
            if(!empty($style_name)){
                $strWhere .= " and style_name = '{$style_name}' ";
            }
            if(!empty($recommend_to_store_index)){
                $strWhere .= " and recommend_to_store_index = '{$recommend_to_store_index}' ";
            }
            if(!empty($sell_price_start) && !empty($sell_price_end)){
                $strWhere .= " and (sell_price >= '{$sell_price_start}' and sell_price <= '{$sell_price_end}') ";
            }
            if (!empty($product_category_ids)){
                $parent_id = 0;
                $product_category_id = 0;
                $product_category_ids_arr = explode(',', $product_category_ids);
                if ($product_category_ids_arr) {
                    if (count($product_category_ids_arr) >= 1) {
                        $parent_id = $product_category_ids_arr[0];
                    }
                    if (count($product_category_ids_arr) >= 2) {
                        $product_category_id = $product_category_ids_arr[1];
                    }
                }
                $product_id_arr = $this->Product_category_ids_model->gets('product_id', array('parent_id' => $parent_id, 'product_category_id' => $product_category_id));
                $ids = -1;
                if ($product_id_arr) {
                    foreach ($product_id_arr as $value) {
                        $product_ids[] = $value['product_id'];
                    }
                    $ids = implode(',', $product_ids);
                }
                $strWhere .= " and id IN ({$ids})";
            }
            $this->session->set_userdata('search', $strWhere);
        }
        //分页
        $paginationCount = $this->Product_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/seller/my_get_product_selector/{$clear}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $paginationConfig['per_page'] = 10;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();
        $product_list = $this->Product_model->gets('id,path,title,brand_name,style_name,unclear_price,sell_price,stock,product_num,recommend_to_store_index', $strWhere, $paginationConfig['per_page'], $page);
        foreach ($product_list as $key => $value) {
            //分类
            $product_category_str = '';
            $p_c_i_list = $this->Product_category_ids_model->gets('*', array('product_id' => $value['id']));
            if ($p_c_i_list) {
                foreach ($p_c_i_list as $p_c_i_key => $p_c_i_value) {
                    $product_category_str .= $this->Product_category_model->getLocation($p_c_i_value['product_category_id']) . '<br/>';
                }
                if ($product_category_str) {
                    $product_category_str = substr($product_category_str, 0, -1);
                }
            }
            $product_list[$key]['product_category_str'] = $product_category_str;
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '商品管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'product_list' => $product_list,
            'pagination' => $pagination,
            'my_product_category_list' => $my_product_category_list,
            'style_list' => $style_list,
            'brand_list' => $brand_list,
        );
        $this->load->view("{$this->_template}/my_get_product_selector", $data);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_delete_product() {
        checkPermission('product_delete');
        $ids = $this->input->post('ids', TRUE);
        if (!$this->form_validation->required($ids)) {
            printAjaxError('title', '请选择您要删除的项');
        }
        //购物车
        $this->load->model('Cart_model', '', TRUE);
        if ($this->Cart_model->rowCount("product_id in ({$ids})")) {
            printAjaxError('购物车存在关联数据，删除失败！');
        }
        //订单详细
        $this->load->model('Orders_detail_model', '', TRUE);
        if ($this->Orders_detail_model->rowCount("product_id in ({$ids})")) {
            printAjaxError('订单详细存在关联数据，删除失败！');
        }
        if (!empty($ids)) {
            if ($this->Product_model->delete('id in (' . $ids . ')')) {
                //删除浏览记录
                $this->Browse_model->delete("item_id in ({$ids}) and type = 'product'");
                //删除收藏记录
                $this->Favorite_model->delete("item_id in ({$ids}) and type = 'product'");
                //删除属性
                $this->Product_size_color_model->delete("product_id in ({$ids})");
                //删除分类信息
                $this->Product_category_ids_model->delete("product_id in ({$ids})");
                printAjaxData(array('ids' => explode(',', $ids)));
            }
        }
        printAjaxError('','删除失败！');
    }
    //推荐商品
    public function my_cus_product() {
        $ids = $this->input->post('ids', TRUE);
        if (!$this->form_validation->required($ids)) {
            printAjaxError('title', '请选择您要推荐的项');
        }
        if(!empty($ids)){
            $str_where = "id in ({$ids})";
            $data = array('recommend_to_store_index'=>1);
            if($this->Product_model->save($data, $str_where)){
                printAjaxSuccess('','成功推荐到店铺首页');
            }
        }
        printAjaxError('','推荐失败！');
    }

    //商品分类列表
    public function my_get_product_category_list() {
        //判断是否登录
        checkLogin(true);
        checkPermission('product_category_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_list = $this->Product_category_model->menuTree($store_info['id']);
        if ($item_list){
            foreach ($item_list as $key=>$item){
                $item_list[$key]['count_1'] = $this->Product_category_ids_model->rowCount(array('parent_id'=>0,'product_category_id'=>$item['id']));
                if ($item['subMenuList']){
                    foreach ($item['subMenuList'] as $sub_key=>$sub_value){
                        $item_list[$key]['subMenuList'][$sub_key]['count_2'] = $this->Product_category_ids_model->rowCount(array('parent_id'=>$item['id'],'product_category_id'=>$sub_value['id']));
                    }
                }
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '商品分类管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list' => $item_list,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_product_category_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //添加商品分类
    public function my_save_product_category($tmp_parent_id = 0, $id = NULL) {
        //判断是否登录
        checkLogin(true);
        if ($id){
            checkPermission('product_category_edit');
        }else{
            checkPermission('product_category_add');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $parent_category_list = $this->Product_category_model->gets(array('store_id' => $store_info['id'], 'parent_id' => 0));
        $item_info = $this->Product_category_model->get('*', array('store_id' => $store_info['id'], 'id' => $id));
        if ($_POST) {
            $parent_id = $this->input->post('parent_id', TRUE);
            $product_category_name = $this->input->post('product_category_name', TRUE);
            $sort = $this->input->post('sort', TRUE);
            $path = $this->input->post('path', TRUE);
            if (!$this->form_validation->required($product_category_name)) {
                printAjaxError('product_category_name', '分类名称不能为空');
            }
            if ($id) {
                if ($parent_id == $id) {
                    printAjaxError('parent_id', '自己不能是自己的上级分类');
                }
            }
            if ($id) {
                $fields = array(
                    'parent_id' => $parent_id,
                    'product_category_name' => $this->input->post('product_category_name', TRUE),
                    'sort' => intval($sort),
                    'path' => $path,
                    'store_id' => $store_info['id'],
                );
                if ($this->Product_category_model->save($fields, array('id' => $id))) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_product_category_list.html', $systemInfo['client_index']), '提交成功');
                } else {
                    printAjaxError("操作失败！");
                }
            } else {
                $i = 0;
                $title = preg_replace(array('/^\|+/', '/\|+$/', '/｜/'), array('', '', '|'), $product_category_name);
                $titleArr = explode("|", $title);
                foreach ($titleArr as $key => $title) {
                    $fields = array(
                        'parent_id' => $parent_id,
                        'sort' => $sort + $key,
                        'product_category_name' => trim($title),
                        'path' => $path,
                        'store_id' => $store_info['id'],
                    );
                    if ($this->Product_category_model->save($fields)) {
                        $i++;
                    }
                }
                if (count($titleArr) == $i) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_product_category_list.html', $systemInfo['client_index']), '提交成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '添加商品分类_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'parent_category_list' => $parent_category_list,
            'item_info' => $item_info,
            'tmp_parent_id' => $tmp_parent_id,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_product_category", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_sort_product_category() {
        checkLogin(true);
        checkPermission('product_category_edit');
        if ($_POST) {
            $ids = $this->input->post('ids', TRUE);
            $sorts = $this->input->post('sorts', TRUE);
            if (!empty($ids) && !empty($sorts)) {
                $ids = explode(',', $ids);
                $sorts = explode(',', $sorts);
                foreach ($ids as $key => $value) {
                    $this->Product_category_model->save(array('sort' => $sorts[$key]), array('id' => $value));
                }
                printAjaxSuccess('success', '排序成功！');
            }
            printAjaxError('fail', '排序失败！');
        }
    }

    public function my_change_product_category_sort() {
        checkLoginAjax(true);
        checkPermissionAjax('product_category_edit');
        if ($_POST) {
            $id = $this->input->post('id', TRUE);
            $sort = $this->input->post('sort', TRUE);
            $result = $this->Product_category_model->save(array('sort' => intval($sort)), array('id' => intval($id)));
            if ($result) {
                printAjaxSuccess('success', '保存成功');
            } else {
                printAjaxError('fail', '保存失败');
            }
        }
    }

    public function my_delete_product_category() {
        checkLogin(true);
        checkPermission('product_category_delete');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
            $id = $this->input->post('id', TRUE);
            if (!empty($id)) {
                $ids = $this->Product_category_model->getChildIds($id);
                if ($ids != $id) {
                    printAjaxError('fail', '删除失败，请先删除下级分类！');
                }
                $parent_id = $this->Product_category_model->get('parent_id', array('id'=>$id,'store_id'=>$store_info['id']));
                if($parent_id){
                    $product_info = $this->Product_category_ids_model->get('product_id',array('parent_id'=>$parent_id['parent_id'],'product_category_id'=>$id));
                    if($product_info){
                        printAjaxError('fail', '删除失败，此分类下还有商品未删除！');
                    }
                }
                if ($this->Product_category_model->delete("product_category.id in ({$id}) and store_id = {$store_info['id']}")) {
                    printAjaxData(array('id' => $id));
                }
            }
            printAjaxError('fail', '删除失败！');
        }
    }

    //品牌列表
    public function my_get_brand_list() {
        //判断是否登录
        checkLogin(true);
        checkPermission('brand_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_list = $this->Brand_model->gets('*', "store_id = {$store_info['id']} or store_id = 0");
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '品牌管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list' => $item_list,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_brand_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //添加品牌
    public function my_save_brand($id = NULL) {
        //判断是否登录
        checkLogin(true);
        if ($id){
            checkPermission('brand_edit');
        }else{
            checkPermission('brand_add');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_info = $this->Brand_model->get('*', array('id' => $id, 'store_id' => $store_info['id']));
        if ($_POST) {
            $brand_name = $this->input->post('brand_name', TRUE);
            $tag = $this->input->post('tag', TRUE);
            $path = $this->input->post('path', TRUE);
            if (!$this->form_validation->required($brand_name)) {
                printAjaxError('brand_name', '品牌名称不能为空');
            }
            if (!$this->form_validation->max_length($brand_name, 100)) {
                printAjaxError('title', '品牌名称字数不能超过100字');
            }
            if ($id) {
                $fields = array(
                    'brand_name' => $brand_name,
                    'tag' => $tag,
                    'path' => $path,
                    'store_id' => $store_info['id'],
                );
                if ($this->Brand_model->save($fields, array('id' => $id))) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_brand_list.html', $systemInfo['client_index']), '修改成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            } else {
                $i = 0;
                $brand_name = preg_replace(array('/^\|+/', '/\|+$/', '/｜/'), array('', '', '|'), $brand_name);
                $titleArr = explode("|", $brand_name);
                foreach ($titleArr as $key => $title) {
                    $fields = array(
                        'brand_name' => $title,
                        'tag' => $tag,
                        'path' => $path,
                        'display' => 0,
                        'store_id' => $store_info['id'],
                    );
                    if ($this->Brand_model->save($fields)) {
                        $i++;
                    }
                }
                if (count($titleArr) == $i) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_brand_list.html', $systemInfo['client_index']), '添加成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '添加品牌_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info' => $item_info
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_brand", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_delete_brand() {
        checkLoginAjax(true);
        checkPermissionAjax('brand_delete');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
            $id = $this->input->post('id', TRUE);
            if (!$this->form_validation->required($id)) {
                printAjaxError('title', 'id不能为空');
            }
            $result = $this->Brand_model->delete(array('id' => intval($id), 'store_id' => $store_info['id']));
            if ($result) {
                printAjaxSuccess('success', '删除成功');
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }

    //风格列表
    public function my_get_style_list() {
        //判断是否登录
        checkLogin(true);
        checkPermission('style_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_list = $this->Style_model->gets("store_id = {$store_info['id']} or store_id = 0");
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '风格管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list' => $item_list
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_style_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //编辑风格
    public function my_save_style($id = NULL) {
        //判断是否登录
        checkLogin(true);
        if ($id){
            checkPermission('style_edit');
        }else{
            checkPermission('style_add');
        }

        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_info = $this->Style_model->get('*', array('id' => $id, 'store_id' => $store_info['id']));
        if ($_POST) {
            $style_name = $this->input->post('style_name', TRUE);
            $tag = $this->input->post('tag', TRUE);
            if (!$this->form_validation->required($style_name)) {
                printAjaxError('style_name', '风格名称不能为空');
            }
            if (!$this->form_validation->max_length($style_name, 100)) {
                printAjaxError('style_name', '风格名称字数不能超过100字');
            }
            if ($id) {
                $fields = array(
                    'style_name' => $style_name,
                    'tag' => $tag,
                    'store_id' => $store_info['id'],
                );
                if ($this->Style_model->save($fields, array('id' => $id))) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_style_list.html', $systemInfo['client_index']), '修改成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            } else {
                $i = 0;
                $style_name = preg_replace(array('/^\|+/', '/\|+$/', '/｜/'), array('', '', '|'), $style_name);
                $titleArr = explode("|", $style_name);
                foreach ($titleArr as $key => $title) {
                    $fields = array(
                        'style_name' => $title,
                        'tag' => $tag,
                        'display' => 0,
                        'store_id' => $store_info['id'],
                    );
                    if ($this->Style_model->save($fields)) {
                        $i++;
                    }
                }
                if (count($titleArr) == $i) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_style_list.html', $systemInfo['client_index']), '添加成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '添加风格_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info' => $item_info,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_style", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_delete_style() {
        checkLoginAjax(true);
        checkPermissionAjax('style_delete');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
            $id = $this->input->post('id', TRUE);
            if (!$this->form_validation->required($id)) {
                printAjaxError('title', 'id不能为空');
            }
            $result = $this->Style_model->delete(array('id' => intval($id), 'store_id' => $store_info['id']));
            if ($result) {
                printAjaxSuccess('success', '删除成功');
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }

    //材质列表
    public function my_get_material_list() {
        //判断是否登录
        checkLogin(true);
        checkPermission('material_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_list = $this->Material_model->gets("store_id = {$store_info['id']} or store_id = 0");
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '材质管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list' => $item_list
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_material_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //编辑材质
    public function my_save_material($id = NULL) {
        //判断是否登录
        checkLogin(true);
        if ($id){
            checkPermission('material_edit');
        }else{
            checkPermission('material_add');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_info = $this->Material_model->get('*', array('id' => $id, 'store_id' => $store_info['id']));
        if ($_POST) {
            $material_name = $this->input->post('material_name', TRUE);
            $tag = $this->input->post('tag', TRUE);
            if (!$this->form_validation->required($material_name)) {
                printAjaxError('brand_name', '材质名称不能为空');
            }
            if (!$this->form_validation->max_length($material_name, 100)) {
                printAjaxError('title', '材质名称字数不能超过100字');
            }

            if ($id) {
                $fields = array(
                    'material_name' => $material_name,
                    'tag' => $tag,
                    'store_id' => $store_info['id'],
                );
                if ($this->Material_model->save($fields, array('id' => $id))) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_material_list.html', $systemInfo['client_index']), '修改成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            } else {
                $i = 0;
                $material_name = preg_replace(array('/^\|+/', '/\|+$/', '/｜/'), array('', '', '|'), $material_name);
                $titleArr = explode("|", $material_name);
                foreach ($titleArr as $key => $title) {
                    $fields = array(
                        'material_name' => $title,
                        'tag' => $tag,
                        'display' => 0,
                        'store_id' => $store_info['id'],
                    );
                    if ($this->Material_model->save($fields)) {
                        $i++;
                    }
                }
                if (count($titleArr) == $i) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_material_list.html', $systemInfo['client_index']), '添加成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '添加材质_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info' => $item_info,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_material", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_delete_material() {
        checkLoginAjax(true);
        checkPermissionAjax('material_delete');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
            $id = $this->input->post('id', TRUE);
            if (!$this->form_validation->required($id)) {
                printAjaxError('fail', '请选择删除项');
            }
            $result = $this->Material_model->delete(array('id' => intval($id), 'store_id' => $store_info['id']));
            if ($result) {
                printAjaxSuccess('success', '删除成功');
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }
    //面料列表
    public function my_get_fabric_list() {
        //判断是否登录
        checkLogin(true);
        checkPermission('fabric_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_list = $this->Fabric_model->gets("store_id = {$store_info['id']} or store_id = 0");
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '面料管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list' => $item_list
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_fabric_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //编辑面料
    public function my_save_fabric($id = NULL) {
        //判断是否登录
        checkLogin(true);
        if ($id){
            checkPermission('fabric_edit');
        }else{
            checkPermission('fabric_add');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_info = $this->Fabric_model->get('*', array('id' => $id, 'store_id' => $store_info['id']));
        if ($_POST) {
            $fabric_name = $this->input->post('fabric_name', TRUE);
            $tag = $this->input->post('tag', TRUE);
            if (!$this->form_validation->required($fabric_name)) {
                printAjaxError('brand_name', '面料名称不能为空');
            }
            if (!$this->form_validation->max_length($fabric_name, 100)) {
                printAjaxError('title', '面料名称字数不能超过100字');
            }

            if ($id) {
                $fields = array(
                    'fabric_name' => $fabric_name,
                    'tag' => $tag,
                    'store_id' => $store_info['id'],
                );
                if ($this->abric_model->save($fields, array('id' => $id))) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_fabric_list.html', $systemInfo['client_index']), '修改成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            } else {
                $i = 0;
                $fabric_name = preg_replace(array('/^\|+/', '/\|+$/', '/｜/'), array('', '', '|'), $fabric_name);
                $titleArr = explode("|", $fabric_name);
                foreach ($titleArr as $key => $title) {
                    $fields = array(
                        'fabric_name' => $title,
                        'tag' => $tag,
                        'display' => 0,
                        'store_id' => $store_info['id'],
                    );
                    if ($this->Fabric_model->save($fields)) {
                        $i++;
                    }
                }
                if (count($titleArr) == $i) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_fabric_list.html', $systemInfo['client_index']), '添加成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '添加材质_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info' => $item_info,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_fabric", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_delete_fabric() {
        checkLoginAjax(true);
        checkPermissionAjax('fabric_delete');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
            $id = $this->input->post('id', TRUE);
            if (!$this->form_validation->required($id)) {
                printAjaxError('fail', '请选择删除项');
            }
            $result = $this->abric_model->delete(array('id' => intval($id), 'store_id' => $store_info['id']));
            if ($result) {
                printAjaxSuccess('success', '删除成功');
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }
    //皮革列表
    public function my_get_leather_list() {
        //判断是否登录
        checkLogin(true);
        checkPermission('leather_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_list = $this->Leather_model->gets("store_id = {$store_info['id']} or store_id = 0");
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '材质管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list' => $item_list
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_leather_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //编辑皮革
    public function my_save_leather($id = NULL) {
        //判断是否登录
        checkLogin(true);
        if ($id){
            checkPermission('leather_edit');
        }else{
            checkPermission('leather_add');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_info = $this->Leather_model->get('*', array('id' => $id, 'store_id' => $store_info['id']));
        if ($_POST) {
            $leather_name = $this->input->post('leather_name', TRUE);
            $tag = $this->input->post('tag', TRUE);
            if (!$this->form_validation->required($leather_name)) {
                printAjaxError('brand_name', '皮革名称不能为空');
            }
            if (!$this->form_validation->max_length($leather_name, 100)) {
                printAjaxError('title', '皮革名称字数不能超过100字');
            }

            if ($id) {
                $fields = array(
                    'leather_name' => $leather_name,
                    'tag' => $tag,
                    'store_id' => $store_info['id'],
                );
                if ($this->Leather_model->save($fields, array('id' => $id))) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_leather_list.html', $systemInfo['client_index']), '修改成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            } else {
                $i = 0;
                $leather_name = preg_replace(array('/^\|+/', '/\|+$/', '/｜/'), array('', '', '|'), $leather_name);
                $titleArr = explode("|", $leather_name);
                foreach ($titleArr as $key => $title) {
                    $fields = array(
                        'leather_name' => $title,
                        'tag' => $tag,
                        'display' => 0,
                        'store_id' => $store_info['id'],
                    );
                    if ($this->Leather_model->save($fields)) {
                        $i++;
                    }
                }
                if (count($titleArr) == $i) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_leather_list.html', $systemInfo['client_index']), '添加成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '添加材质_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info' => $item_info,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_leather", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_delete_leather() {
        checkLoginAjax(true);
        checkPermissionAjax('leather_delete');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
            $id = $this->input->post('id', TRUE);
            if (!$this->form_validation->required($id)) {
                printAjaxError('fail', '请选择删除项');
            }
            $result = $this->Leather_model->delete(array('id' => intval($id), 'store_id' => $store_info['id']));
            if ($result) {
                printAjaxSuccess('success', '删除成功');
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }
    //填充物列表
    public function my_get_filler_list() {
        //判断是否登录
        checkLogin(true);
        checkPermission('filler_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_list = $this->Filler_model->gets("store_id = {$store_info['id']} or store_id = 0");
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '材质管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list' => $item_list
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_filler_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //编辑填充物
    public function my_save_filler($id = NULL) {
        //判断是否登录
        checkLogin(true);
        if ($id){
            checkPermission('filler_edit');
        }else{
            checkPermission('filler_add');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_info = $this->Filler_model->get('*', array('id' => $id, 'store_id' => $store_info['id']));
        if ($_POST) {
            $filler_name = $this->input->post('filler_name', TRUE);
            $tag = $this->input->post('tag', TRUE);
            if (!$this->form_validation->required($filler_name)) {
                printAjaxError('brand_name', '填充物名称不能为空');
            }
            if (!$this->form_validation->max_length($filler_name, 100)) {
                printAjaxError('title', '填充物名称字数不能超过100字');
            }

            if ($id) {
                $fields = array(
                    'filler_name' => $filler_name,
                    'tag' => $tag,
                    'store_id' => $store_info['id'],
                );
                if ($this->Filler_model->save($fields, array('id' => $id))) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_filler_list.html', $systemInfo['client_index']), '修改成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            } else {
                $i = 0;
                $filler_name = preg_replace(array('/^\|+/', '/\|+$/', '/｜/'), array('', '', '|'), $filler_name);
                $titleArr = explode("|", $filler_name);
                foreach ($titleArr as $key => $title) {
                    $fields = array(
                        'filler_name' => $title,
                        'tag' => $tag,
                        'display' => 0,
                        'store_id' => $store_info['id'],
                    );
                    if ($this->Filler_model->save($fields)) {
                        $i++;
                    }
                }
                if (count($titleArr) == $i) {
                    printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_filler_list.html', $systemInfo['client_index']), '添加成功');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '添加材质_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info' => $item_info,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_filler", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_delete_filler() {
        checkLoginAjax(true);
        checkPermissionAjax('filler_delete');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
            $id = $this->input->post('id', TRUE);
            if (!$this->form_validation->required($id)) {
                printAjaxError('fail', '请选择删除项');
            }
            $result = $this->Filler_model->delete(array('id' => intval($id), 'store_id' => $store_info['id']));
            if ($result) {
                printAjaxSuccess('success', '删除成功');
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }

    //广告列表
    public function my_get_ad_list() {
        //判断是否登录
        checkLogin(true);
        checkPermission('ad_store_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $ad_store_list_1 = $this->Ad_store_model->gets('*', array('position' => 1, 'store_id' => $store_info['id']));
        $ad_store_list_2 = $this->Ad_store_model->gets('*', array('position' => 2, 'store_id' => $store_info['id']));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '广告管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'ad_store_list_1' => $ad_store_list_1,
            'ad_store_list_2' => $ad_store_list_2,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_ad_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_ad_store_save() {
        checkLogin(true);
        checkPermission('ad_store_add');
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $json = file_get_contents('php://input');
//        var_dump($json);
        if (empty($json)) {
            printAjaxError('fail', '提交的数据为空');
        }
        $item_list = json_decode($json, true);
        if (empty($item_list)) {
            printAjaxError('fail', '提交的数据为空');
        }

        foreach ($item_list as $ls) {
            if ($ls['url'] && strpos($ls['url'], preg_replace('/\/$/', '', base_url()), 0) === false) {
                printAjaxError('fail', '其中有一项不是本站地址');
            }
        }
        foreach ($item_list as $item) {
            $this->Ad_store_model->save(array('sort' => intval($item['sort']), 'ad_text' => $item['ad_text'], 'url' => $item['url'], 'xcx_url' => $item['xcx_url'] ,'app_url' => $item['app_url']), array('id' => $item['id'], 'store_id' => $store_info['id']));
        }
        printAjaxSuccess('success', '保存成功');
    }

    public function my_delete_ad_store() {
        checkLogin(true);
        checkPermission('ad_store_delete');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
            $id = $this->input->post('id');
            if (!$this->form_validation->required($id)) {
                printAjaxError('fail', '请选定删除项');
            }
            $item_info = $this->Ad_store_model->get('*', array('id' => intval($id), 'store_id' => $store_info['id']));
            if (empty($item_info)) {
                printAjaxError('fail', '不存在此项');
            }
            unlink($item_info['path']);
            unlink(str_replace('.', '_thumb.', $item_info['path']));
            $result = $this->Ad_store_model->delete(array('id' => intval($id), 'store_id' => $store_info['id']));
            if ($result) {
                printAjaxSuccess('success', '删除成功');
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }

    //添加主题
    public function my_set_theme() {
        //判断是否登录
        checkLogin(true);
        checkPermission('theme_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $user_id = $seller_group_info['user_id'];
        $store_info = $this->Store_model->get2(array('user_id' => $user_id));
        $cur_theme_info = NULL;
        $item_list = NULL;
        if ($store_info && $store_info['theme_ids']) {
            $item_list = $this->Theme_model->gets("id in ({$store_info['theme_ids']}) and display = 1");
            if ($item_list) {
                foreach ($item_list as $key => $value) {
                    if ($value['alias'] == $store_info['theme']) {
                        $cur_theme_info = $value;
                        break;
                    }
                }
            }
        }


        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
//        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $ad_store_list_1 = $this->Ad_store_model->gets('*', array('position' => 1, 'store_id' => $store_info['id']));
        $ad_store_list_2 = $this->Ad_store_model->gets('*', array('position' => 2, 'store_id' => $store_info['id']));


        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '添加主题_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_list' => $item_list,
            'cur_theme_info' => $cur_theme_info,
            'store_info' => $store_info,
            'template' => $this->_template,
            'ad_store_list_1' => $ad_store_list_1,
            'ad_store_list_2' => $ad_store_list_2,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_set_theme", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_set_store_theme() {
        //判断是否登录
        checkLoginAjax(true);
        checkPermissionAjax('theme_add');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $user_id = $seller_group_info['user_id'];
            $theme = $this->input->post('theme', TRUE);
            if (!$theme) {
                printAjaxError('fail', '请选择设置的主题');
            }
            $is_yes = false;
            $store_info = $this->Store_model->get2(array('user_id' => $user_id));
            if ($store_info && $store_info['theme_ids']) {
                $item_list = $this->Theme_model->gets("id in ({$store_info['theme_ids']}) and display = 1");
                if ($item_list) {
                    foreach ($item_list as $key => $value) {
                        if ($value['alias'] == $theme) {
                            $is_yes = true;
                            break;
                        }
                    }
                }
            }
            if (!$is_yes) {
                printAjaxError('fali', '主题设置异常');
            }
            if (!$this->Store_model->save(array('theme' => $theme), array('user_id' => $user_id, 'id' => $store_info['id']))) {
                printAjaxError('fali', '主题设置失败，刷新重试');
            }
            printAjaxSuccess('success', '主题设置成功');
        }
    }

    //导航管理
    public function my_get_nav_list() {
        //判断是否登录
        checkLogin(true);
        checkPermission('navigation_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_list = $this->Navigation_model->gets(array('store_id' => $store_info['id']));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '导航管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list' => $item_list
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_nav_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //添加导航
    public function my_save_nav($id = null) {
        //判断是否登录
        checkLogin(true);
        if ($id){
            checkPermission('navigation_edit');
        }else{
            checkPermission('navigation_add');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_info = $this->Navigation_model->get('*', array('id' => $id, 'store_id' => $store_info['id']));
        if ($_POST) {
            $title = $this->input->post('title', TRUE);
            $url = $this->input->post('url', TRUE);
            $sort = $this->input->post('sort', TRUE);
            $display = $this->input->post('display', TRUE);
            $content = $this->input->post('content');

            if (!$this->form_validation->required($title)) {
                printAjaxError('title', '导航名称不能为空');
            }
            if (!$this->form_validation->max_length($title, 20)) {
                printAjaxError('title', '导航名称字数不能超过20字');
            }
            if ($url && !preg_match('/^http[s]?:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/', $url)) {
                printAjaxError('url', '导航链接格式错误');
            }
            if (!$this->form_validation->required($content)) {
                printAjaxError('content', '描述不能为空');
            }

            $fields = array(
                'title' => $title,
                'url' => $url,
                'sort' => intval($sort),
                'display' => $display ? 1 : 0,
                'content' => unhtml($content),
                'store_id' => $store_info['id']
            );
            $result = $this->Navigation_model->save($fields, $id ? array('id' => $id) : NULL);
            if ($result) {
                printAjaxSuccess(getBaseUrl(false, '', 'seller/my_get_nav_list.html', $systemInfo['client_index']), '提交成功');
            } else {
                printAjaxError('fail', '提交失败');
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '添加导航_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info' => $item_info,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_nav", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_change_nav_sort() {
        checkLoginAjax(true);
        checkPermissionAjax('navigation_edit');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
            $id = $this->input->post('id', TRUE);
            $sort = $this->input->post('sort', TRUE);
            if (!$this->form_validation->required($id)) {
                printAjaxError('fail', '操作异常');
            }

            $result = $this->Navigation_model->save(array('sort' => intval($sort)), array('id' => intval($id), 'store_id' => $store_info['id']));
            if ($result) {
                $item_list = $this->Navigation_model->gets(array('store_id' => $store_info['id']));
                printAjaxData($item_list);
            } else {
                printAjaxError('fail', '保存失败');
            }
        }
    }

    public function my_change_nav_display() {
        checkLoginAjax(true);
        checkPermissionAjax('navigation_edit');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
            $id = $this->input->post('id', TRUE);
            $display = $this->input->post('display', TRUE);
            if (!$this->form_validation->required($id)) {
                printAjaxError('fail', '操作异常');
            }

            $result = $this->Navigation_model->save(array('display' => $display ? 1 : 0), array('id' => intval($id), 'store_id' => $store_info['id']));
            if ($result) {
                printAjaxSuccess('success', '保存成功');
            } else {
                printAjaxError('fail', '保存失败');
            }
        }
    }

    public function my_delete_navigation() {
        checkLoginAjax(true);
        checkPermissionAjax('navigation_delete');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
            $id = $this->input->post('id', TRUE);
            if (!$this->form_validation->required($id)) {
                printAjaxError('fail', '请选定删除项');
            }

            $result = $this->Navigation_model->delete(array('id' => intval($id), 'store_id' => $store_info['id']));
            if ($result) {
                printAjaxSuccess('success', '删除成功');
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }

    //订单列表
    public function my_get_order_list($s = 'all', $clear = 1, $page = 0) {
        //判断是否登录
        checkLogin(true);
        checkPermission('order_index');
        //超过24小时关闭订单
        $time = time();
        $order_list = $this->Orders_model->gets('id',"add_time <= {$time} - (24*60*60) and status = 0");
        if ($order_list){
            foreach ($order_list as $value){
                $fields = array(
                    'cancel_cause'=>'超时自动关闭',
                    'status'=>4
                );
                if ($this->Orders_model->save($fields, array('id'=>$value['id']))) {
                    $fields = array(
                        'add_time' => $time,
                        'content' => '超时交易自动关闭',
                        'order_id' => $value['id']
                    );
                    $this->Orders_process_model->save($fields);
                }
            }
        }

        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $user_id =$seller_group_info['user_id'];
        $condition = "seller_id = {$user_id} ";
        $store_info = $this->Store_model->get('id',array('user_id'=>$user_id));
        $condition .= " and store_id = {$store_info['id']} ";
        if ($s != 'all') {
            $condition .= " and status in ({$this->_hideValue[$s]}) ";
        }
        if($clear) {
            $clear = 0;
            $this->session->unset_userdata(array('search' => ''));
        }
        $strWhere = $this->session->userdata('search') ? $this->session->userdata('search') : $condition;

        if ($_POST) {
            $strWhere = $condition;
            $order_number = $this->input->post('order_number');
            $username = $this->input->post('username');
            $status = $this->input->post('status');
            $startTime = $this->input->post('add_time_start');
            $endTime = $this->input->post('add_time_end');

            if (! empty($order_number) ) {
                $strWhere .= " and order_number = '{$order_number}' ";
            }
            if (! empty($username) ) {
                $strWhere .= " and username REGEXP '{$username}'";
            }
            if ($status != "") {
                $strWhere .= " and status = {$status} ";
            }
            if (! empty($startTime) && ! empty($endTime)) {
                $strWhere .= ' and add_time > '.strtotime($startTime.' 00:00:00').' and add_time < '.strtotime($endTime.' 23:59:59').' ';
            }
            $this->session->set_userdata('search', $strWhere);
        }
        //分页
        $paginationCount = $this->Orders_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/{$this->_template}/my_get_order_list/{$s}/{$clear}";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 5;
        $paginationConfig['per_page'] = 5;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->Orders_model->gets('*', $strWhere, $paginationConfig['per_page'], $page);
        if ($item_list) {
            foreach ($item_list as $key => $order) {
                $order_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $order['id']));
                $item_list[$key]['order_detail_list'] = $order_detail_list;

                $exchange_info = $this->Exchange_model->get('status',array('orders_id' => $order['id']));
                if($exchange_info){
                    $item_list[$key]['exchange_status'] = $exchange_info['status'];
                }else{
                    $item_list[$key]['exchange_status'] = '';
                }
            }
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '已卖出的宝贝_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_list' => $item_list,
            'pagination' => $pagination,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
            'perPage' => $paginationConfig['per_page'],
            'status' => $this->_status,
            'exchange_status_arr' => $this->_exchange_status2_arr,
            'select_status' => $s,
            'template' => $this->_template
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_order_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //修改价格
    public function seller_change_price(){
        //判断是否登录
        checkLoginAjax(true);
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        if ($_POST) {
            $id = $this->input->post('id', TRUE);
            $total = $this->input->post('total', TRUE);
            if (! $this->form_validation->required($total)) {
                printAjaxError('fail','修改价格不能为空！');
            }
            if (! $this->form_validation->numeric($total)) {
                printAjaxError('fail','修改价格必须为正确的金额！');
            }
            $count = $this->Orders_model->rowCount(array('id'=>$id,'store_id'=>$store_info['id']));
            if (!$count) {
                printAjaxError('fail','此订单不存在，修改价格失败！');
            }
            $fields = array(
                'total'=>$total
            );
            if ($this->Orders_model->save($fields, array('id'=>$id,'store_id'=>$store_info['id']))) {
                $fields = array(
                    'add_time'=>time(),
                    'content'=>'修改价格成功',
                    'order_id'=>$id
                );
                $this->Orders_process_model->save($fields);
                printAjaxSuccess('success', '修改价格成功！');
            } else {
                printAjaxError('fail',"修改价格失败！");
            }
        }
    }

    //交易关闭
    public function seller_close_order(){
        //判断是否登录
        checkLoginAjax(true);
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        if ($_POST) {
            $id = $this->input->post('id', TRUE);
            $cancelCause = $this->input->post('cancel_cause', TRUE);
            if (! $this->form_validation->required($cancelCause)) {
                printAjaxError('fail','请填写交易关闭的原因！');
            }
            $count = $this->Orders_model->rowCount(array('id'=>$id,'store_id'=>$store_info['id']));
            if (!$count) {
                printAjaxError('fail','此订单不存在，交易关闭失败！');
            }
            $fields = array(
                'cancel_cause'=>$cancelCause,
                'status'=>4
            );
            if ($this->Orders_model->save($fields, array('id'=>$id,'store_id'=>$store_info['id']))) {
                $fields = array(
                    'add_time'=>time(),
                    'content'=>'交易关闭',
                    'order_id'=>$id
                );
                $this->Orders_process_model->save($fields);
                printAjaxSuccess('success', '交易关闭成功！');
            } else {
                printAjaxError('fail',"交易关闭失败！");
            }
        }
    }

    //修改已付款
    public function seller_change_status_2(){
        //判断是否登录
        checkLoginAjax(true);

        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        if ($_POST) {
            $id = $this->input->post('id', TRUE);
            $remark = $this->input->post('remark', TRUE);
            if (!$remark) {
                printAjaxError('remark', '备注不能为空');
            }
            $ordersInfo = $this->Orders_model->get('user_id, total, order_number', array('id' => $id, 'store_id' => $store_info['id']));
            if (!$ordersInfo) {
                printAjaxError('fail', "操作异常！");
            }
            $fields = array(
                'status' => 1
            );
            if ($this->Orders_model->save($fields, array('id' => $id))) {
                //财务记录

                $userInfo = $this->User_model->getInfo('username', array('id' => $ordersInfo['user_id']));
                if (!$userInfo) {
                    printAjaxError('fail', "操作异常！");
                }
                $this->load->model('Financial_model', '', TRUE);
                $fFields = array(
                    'cause' => "付款成功--{$ordersInfo['order_number']}",
                    'price' => -$ordersInfo['total'],
                    'add_time' => time(),
                    'username' => $userInfo['username']
                );
                $this->Financial_model->save($fFields);
                //订单跟踪记录
                $fields = array(
                    'add_time' => time(),
                    'content' => "已付款状态修改成功[{$remark}]",
                    'order_id' => $id
                );
                $this->Orders_process_model->save($fields);
                printAjaxSuccess('success', '操作成功！');
            } else {
                printAjaxError('fail', "操作失败！");
            }
        }
    }

    //发货
    public function seller_delivery() {
        //判断是否登录
        checkLoginAjax(true);
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        if ($_POST) {
            $id = $this->input->post('id', TRUE);
            $deliveryName = $this->input->post('delivery_name', TRUE);
            $expressNumber = $this->input->post('express_number', TRUE);
            $remark = $this->input->post('remark', TRUE);
            if (! $this->form_validation->required($deliveryName)) {
                printAjaxError('fail','快递名称不能为空！');
            }
            if (! $this->form_validation->numeric($expressNumber)) {
                printAjaxError('fail','快递单号不能为空！');
            }
            $item_info = $this->Orders_model->get('user_id',array('id'=>$id, 'store_id' => $store_info['id']));
            if (!$item_info) {
                printAjaxError('fail','此订单不存在，发货失败！');
            }
            $exchange_info = $this->Exchange_model->get('*', array('orders_id'=>$id, 'user_id'=>$item_info['user_id']));
            if ($exchange_info) {
                if ($exchange_info['status'] >= 3) {
                    printAjaxError('fail', "此订单退款申请成功，不能完成下面的操作");
                } else {
                    if ($exchange_info['status'] != 1) {
                        printAjaxError('fail', "此订单退款申请审核中，不能完成下面的操作");
                    }
                }
            }
            $fields = array(
                'delivery_name'=>$deliveryName,
                'express_number'=>$expressNumber,
                'status'=>2
            );
            if ($this->Orders_model->save($fields, array('id'=>$id))) {
                $fields = array(
                    'add_time'=>time(),
                    'content'=>"发货成功[{$remark}]",
                    'order_id'=>$id,
                    'change_status'=> 2
                );
                $this->Orders_process_model->save($fields);
                printAjaxSuccess('success', '发货成功！');
            } else {
                printAjaxError('fail',"发货失败！");
            }
        }

    }

    //确认收货
    public function seller_receiving() {
        //判断是否登录
        checkLoginAjax(true);
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        if ($_POST) {
            $id = $this->input->post('id', TRUE);

            if (!$id) {
                printAjaxError('fail', "操作异常，刷新重试");
            }
            $ordersInfo = $this->Orders_model->get('id, user_id,status,score, order_number, divide_total, divide_store_price', array('id' =>$id, 'store_id' => $store_info['id']));
            if (!$ordersInfo) {
                printAjaxError('fail', "不存在此订单");
            }
            if ($ordersInfo['status'] != 2) {
                printAjaxError('fail', "此订单状态异常，确认收货失败");
            }
            $exchange_info = $this->Exchange_model->get('*', array('orders_id'=>$id, 'user_id'=>$ordersInfo['user_id']));
            if ($exchange_info) {
                if ($exchange_info['status'] >= 3) {
                    printAjaxError('fail', "此订单退款申请成功，不能完成下面的操作");
                } else {
                    if ($exchange_info['status'] != 1) {
                        printAjaxError('fail', "此订单退款申请审核中，不能完成下面的操作");
                    }
                }
            }
            $fields = array(
                'status'=>3
            );
            if ($this->Orders_model->save($fields, array('id'=>$id))) {
                //订单记录跟踪(只修改状态，扣钱，是下线交易的)
                $fields = array(
                    'add_time'=>time(),
                    'content'=>'确认收货，交易成功',
                    'order_id'=>$id,
                    'change_status'=> 3
                );
                $this->Orders_process_model->save($fields);
                //积分记录操作
                if ($ordersInfo && $ordersInfo['score']) {
                    $userInfo = $this->User_model->getInfo('id, username, score', array('id'=>$ordersInfo['user_id']));
                    if ($userInfo) {
                        if ($this->User_model->save(array('score'=>$ordersInfo['score'] + $userInfo['score']), array('id'=>$ordersInfo['user_id']))) {
                            $sFields = array(
                                'cause' =>   "订单交易成功--{$ordersInfo['order_number']}",
                                'score' =>   $ordersInfo['score'],
                                'balance'=>  $ordersInfo['score'] + $userInfo['score'],
                                'type'=>     'product_in',
                                'add_time'=> time(),
                                'username' =>$userInfo['username'],
                                'user_id'=>  $userInfo['id'],
                                'ret_id'=>   $ordersInfo['id']
                            );
                            $this->Score_model->save($sFields);
                        }
                    }
                }
                //减库存与加销售量
                $orderdetailInfo = $this->Orders_detail_model->get('product_id, buy_number', array('order_id'=>$id));
                if ($orderdetailInfo) {
                    $productInfo = $this->Product_model->get('stock, sales', array('id'=>$orderdetailInfo['product_id']));
                    $stock = 0;
                    if ($productInfo['stock'] - $orderdetailInfo['buy_number'] > 0) {
                        $stock = $productInfo['stock'] - $orderdetailInfo['buy_number'];
                    }
                    $pFields = array(
                        'stock'=>$stock,
                        'sales'=>$productInfo['sales']+$orderdetailInfo['buy_number']
                    );
                    $this->Product_model->save($pFields, array('id'=>$orderdetailInfo['product_id']));
                }
                printAjaxSuccess('', '操作成功！');
            } else {
                printAjaxError("操作失败！");
            }
        }
    }

    //物流管理
    public function my_get_postage_way_list() {
        //判断是否登录
        checkLogin(true);
        checkPermission('postage_way_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $item_list = $this->Postage_way_model->gets('*',array('store_id'=>$store_info['id']));
		if ($item_list) {
		   foreach ($item_list as $key=>$postageway) {
		   	   $store_info = $this->Store_model->get2('store_name', array('id'=>$postageway['store_id']));
		   	   if ($store_info) {
		   	       $item_list[$key]['store_name'] = $store_info['store_name'];
		   	   } else {
		   	       $item_list[$key]['store_name'] = '';
		   	   }
		       $item_list[$key]['postagepriceList'] = $this->Postage_price_model->gets('*', array('postage_way_id'=>$postageway['id']));
		   }
		}

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '物流管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list' => $item_list,
            'measurement' => $this->_measurement
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_postage_way_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //编辑物流
    public function my_save_postage_way($id = NULL) {
        //判断是否登录
        checkLogin(true);
        if ($id){
            checkPermission('postage_way_edit');
        }else{
            checkPermission('postage_way_add');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        if ($_POST) {
            $title = $this->input->post('title', TRUE);
            $areaNames = $this->input->post('area_name');
            $start_val = $this->input->post('start_val', TRUE);
            $startPrices = $this->input->post('start_price');
            $add_val = $this->input->post('add_val', TRUE);
            $addPrices = $this->input->post('add_price');
            $payer = $this->input->post('payer', TRUE);
            $charging_mode = $this->input->post('charging_mode', TRUE);
            $province_id = $this->input->post('province_id', TRUE);
            $city_id = $this->input->post('city_id', TRUE);
            $area_id = $this->input->post('area_id', TRUE);
            $content = $this->input->post('content', TRUE);
            if (!$title) {
                printAjaxError('fail', '配送方式名称不能为空!');
            }
            if (!$payer) {
                printAjaxError('fail', '请选择是否包邮!');
            }
            if (!$charging_mode) {
                printAjaxError('fail', '请选择计价方式!');
            }
            if (!$province_id) {
                printAjaxError('fail', '请选择省');
            }
            if($payer == 1){
                    if(empty($start_val[0])){
                         printAjaxError('start_val', '首件不能为空');
                    }
                    if(empty($startPrices[0])){
                         printAjaxError('start_pric', '首费不能为空');
                    }
                    if(empty($add_val[0])){
                         printAjaxError('add_val', '续件不能为空');
                    }
                    if(empty($addPrices[0])){
                         printAjaxError('add_price', '续费不能为空');
                    }
            }
            $txt_address = '';
            $area_info = $this->Area_model->get('name', array('id' => $province_id));
            if ($area_info) {
                $txt_address .= $area_info['name'];
            }
            $area_info = $this->Area_model->get('name', array('id' => $city_id));
            if ($area_info) {
                $txt_address .= ' ' . $area_info['name'];
            }
            $area_info = $this->Area_model->get('name', array('id' => $area_id));
            if ($area_info) {
                $txt_address .= ' ' . $area_info['name'];
            }

            $fields = array(
                'title' => $title,
                'content' => $content,
                'payer' => $payer,
                'charging_mode' => $charging_mode,
                'province_id' => $province_id ? $province_id : 0,
                'city_id' => $city_id ? $city_id : 0,
                'area_id' => $area_id ? $area_id : 0,
                'txt_address' => $txt_address,
                'store_id' => $store_info['id']
            );
            $retId = $this->Postage_way_model->save($fields, $id ? array('id' => $id) : $id);
            if ($retId) {
                //修改时删除原来所有的
                if ($id) {
                    $this->Postage_price_model->delete(array('postage_way_id' => $id));
                }
                //添加数据
                if ($areaNames) {
                    foreach ($areaNames as $key => $areaName) {
                        $data = array(
                            'postage_way_id' => $id ? $id : $retId,
                            'area' => $payer==2 ? '全国' : $areaNames[$key],
                            'start_val' => $payer==2 ? 1 : $start_val[$key],
                            'start_price' => $startPrices[$key],
                            'add_val' => $payer==2 ? 1 : $add_val[$key],
                            'add_price' => $addPrices[$key]
                        );
                        $this->Postage_price_model->save($data);
                        if($payer==2){
                            break;
                        }
                    }
                }
                printAjaxSuccess(base_url() . 'index.php/seller/my_get_postage_way_list', '操作成功');
            } else {
                printAjaxError('fail', "操作失败！");
            }
        }
        $item_info = $this->Postage_way_model->get('*', array('id' => $id));
        if ($item_info) {
            $item_info['postagepriceList'] = $this->Postage_price_model->gets('*', array('postage_way_id' => $id));
        }
        $areaList = $this->Area_model->gets('*', array('parent_id' => 0));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '添加物流_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'areaList' => $areaList,
            'item_info' => $item_info
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_postage_way", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }
     public function my_delete_postage_way() {
        checkLoginAjax(true);
        checkPermissionAjax('postage_way_delete');
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
            $id = $this->input->post('id', TRUE);
            if (!$this->form_validation->required($id)) {
                printAjaxError('id', 'id不能为空');
            }
            $result = $this->Postage_way_model->delete(array('id' => intval($id), 'store_id' => $store_info['id']));
            if ($result) {
                //同时删除关联项
	        $this->Postage_price_model->delete(array('postage_way_id'=>$id));
                printAjaxSuccess('success', '删除成功');
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }


    public function my_get_exchange_list($clear = 0, $page = 0) {
        //判断是否登录
        checkLogin(true);
        checkPermission('exchange_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        if ($clear) {
            $clear = 0;
            $this->session->unset_userdata(array('search' => ''));
        }
        $condition = "store_id = {$store_info['id']}";
        $strWhere = $this->session->userdata('search') ? $this->session->userdata('search') : $condition;

        if ($_POST) {
            $strWhere = $condition;
            $order_num = $this->input->post('order_num');
            $username = $this->input->post('username');
            $status = $this->input->post('status');
            $startTime = $this->input->post('add_time_start');
            $endTime = $this->input->post('add_time_end');

            if (! empty($order_num) ) {
                $strWhere .= " and order_num = '{$order_num}' ";
            }
            if (! empty($username) ) {
                $strWhere .= " and username like '%".$username."%'";
            }
            if ($status != "") {
                $strWhere .= " and status = {$status} ";
            }
            if (! empty($startTime) && ! empty($endTime)) {
                $strWhere .= ' and add_time > '.strtotime($startTime.' 00:00:00').' and add_time < '.strtotime($endTime.' 23:59:59').' ';
            }
            $this->session->set_userdata('search', $strWhere);
        }

        //分页
        $this->config->load('pagination_config', TRUE);
        $paginationCount = $this->Exchange_model->rowCount($strWhere);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url()."index.php/{$this->_template}/my_get_exchange_list/{$clear}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->Exchange_model->gets('*', $strWhere, $paginationConfig['per_page'], $page);

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '退换货管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list'  =>$item_list,
            'pagination'=>$pagination,
            'paginationCount'=>$paginationCount,
            'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
            'exchange_reason_arr'=>$this->_exchange_reason_arr,
            'exchange_status_arr'=>$this->_exchange_status_arr,
            'clear'=>$clear
        );

        $layout = array(
            'content'=>$this->load->view("{$this->_template}/my_get_exchange_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_save_exchange($id = NULL) {
        //判断是否登录
        checkLogin(true);
        if ($id){
            checkPermission('exchange_edit');
        }else{
            checkPermission('exchange_add');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $item_info = $this->Exchange_model->get('*', array('id'=>$id));
        //凭证图片
        $attachment_list = NULL;
        if ($item_info && $item_info['batch_path_ids']) {
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }
        $payment_title = '';
        if ($item_info) {
            $orders_info = $this->Orders_model->get('payment_id, payment_title, total, status', array('id'=>$item_info['orders_id']));
            if ($orders_info) {
                $payment_title = $orders_info['payment_title'];
            }
            $item_info['payment_title'] = $payment_title;
        }
        $orders_detail_info = $this->Orders_detail_model->get('*', array('id' => $item_info['orders_detail_id']));
        $orders_detail_info['price_total'] = number_format($orders_detail_info['buy_number']*$orders_detail_info['buy_price'], 2, '.', '');
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '处理退换货申请_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info'=>$item_info,
            'orders_info'=>$orders_info,
            'orders_detail_info'=>$orders_detail_info,
            'exchange_status_arr'=>$this->_exchange_status_arr,
            'exchange_reason_arr'=>$this->_exchange_reason_arr,
            'status_arr'=>$this->_status,
            'attachment_list'=>$attachment_list,
        );
        $layout = array(
            'content'=>$this->load->view("{$this->_template}/my_save_exchange", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function change_check() {
        checkPermissionAjax('exchange_edit');
        if($_POST) {
            $id = $this->input->post('id', TRUE);
            $status = $this->input->post('status', TRUE);
            $client_remark = $this->input->post('client_remark', TRUE);
            $admin_remark = $this->input->post('admin_remark', TRUE);

            if (!$id) {
                printAjaxError('fail', '操作异常');
            }
            $item_info = $this->Exchange_model->get('*', array('id'=>$id));
            if (!$item_info) {
                printAjaxError('fail', '此退款信息不存在');
            }
            if ($item_info['status'] != 0) {
                printAjaxError('fail', '此退款状态异常');
            }
            if (!$status) {
                printAjaxError('fail', '请选择审核状态');
            }
            if ($status == 1) {
                if (!$client_remark) {
                    printAjaxError('client_remark', '备注不能为空');
                }
                if (!$admin_remark) {
                    printAjaxError('admin_remark', '备注不能为空');
                }
            }
            $fields = array(
                'status'=>$status,
                'client_remark'=>$client_remark,
                'admin_remark'=>$admin_remark,
                'update_time'=>time()
            );
            if (!$this->Exchange_model->save($fields, array('id'=>$item_info['id']))) {
                printAjaxError('fail', '操作失败');
            }
            printAjaxSuccess('success', '操作成功');
        }
    }

    public function refund_to_balance() {
        if ($_POST) {
            $id = $this->input->post('id', TRUE);
            if(!$id) {
                printAjaxError('fail', '操作异常');
            }
            $item_info = $this->Exchange_model->get('*', array('id'=>$id));
            if (!$item_info) {
                printAjaxError('fail', '此退款信息不存在');
            }
            if ($item_info['status'] != 2) {
                printAjaxError('fail', '状态异常');
            }
            $orders_info = $this->Orders_model->get('*', array('id'=>$item_info['orders_id']));
            if (!$orders_info) {
                printAjaxError('fail', '订单信息不存在');
            }
            //预存款支付
            if ($orders_info['payment_id'] == 1) {
                $financial_info = $this->Financial_model->get(array('type'=>'order_out', 'ret_id'=>$orders_info['id']));
                if (!$financial_info) {
                    printAjaxError('fail', '支付记录不存在，退款失败');
                }
                $user_info = $this->User_model->get('*',array('user.id'=>$orders_info['user_id']));
                if (!$user_info) {
                    printAjaxError('fail', '买家信息不存在，退款失败');
                }
                $this->_balance_trade_refund(NULL, $item_info, $orders_info, $user_info, 3);
            }
            //支付宝
            else if ($orders_info['payment_id'] == 2) {
                $pay_log_info = $this->Pay_log_model->get('*',array('pay_log.out_trade_no'=>$orders_info['out_trade_no'], 'pay_log.payment_type'=>'alipay', 'pay_log.order_type'=>'orders'));
                if (!$pay_log_info) {
                    printAjaxError('fail', '支付记录不存在，退款失败');
                }
                if ($pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_FINISHED') {
                    printAjaxError('fail', '订单未付款，退款失败');
                }
                $user_info = $this->User_model->get('*',array('user.id'=>$orders_info['user_id']));
                if (!$user_info) {
                    printAjaxError('fail', '买家信息不存在，退款失败');
                }
                $this->_balance_trade_refund(NULL, $item_info, $orders_info, $user_info, 3);
            }
            //微信
            else if ($orders_info['payment_id'] == 3) {
                $pay_log_info = $this->Pay_log_model->get('*',array('pay_log.out_trade_no'=>$orders_info['out_trade_no'], 'pay_log.payment_type'=>'weixin', 'pay_log.order_type'=>'orders'));
                if (!$pay_log_info) {
                    printAjaxError('fail', '支付记录不存在，退款失败');
                }
                if ($pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_FINISHED') {
                    printAjaxError('fail', '订单未付款，退款失败');
                }
                $user_info = $this->User_model->get('*',array('user.id'=>$orders_info['user_id']));
                if (!$user_info) {
                    printAjaxError('fail', '买家信息不存在，退款失败');
                }
                $this->_balance_trade_refund(NULL, $item_info, $orders_info, $user_info, 3);
            }
            //网银
            else if ($orders_info['payment_id'] == 4) {

            }
        }
    }

    public function my_get_comment_list($clear = 1, $page = 0) {
        //判断是否登录
        checkLogin(true);
        checkPermission('comment_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        if ($clear) {
            $clear = 0;
            $this->session->unset_userdata(array('search' => ''));
        }
        $condition = "store_id = {$store_info['id']}";
        $strWhere = $this->session->userdata('search') ? $this->session->userdata('search') : $condition;

        if ($_POST) {
            $strWhere = $condition;
            $order_num = $this->input->post('order_num');
            $username = $this->input->post('username');
            $evaluate = $this->input->post('evaluate');
            $is_reply = $this->input->post('is_reply');
            $startTime = $this->input->post('add_time_start');
            $endTime = $this->input->post('add_time_end');

            if (! empty($order_num) ) {
                $strWhere .= " and order_number = '{$order_num}' ";
            }
            if (! empty($username) ) {
                $strWhere .= " and username REGEXP  '$username'";
            }
            if ($is_reply != "") {
                $strWhere .= " and is_reply = {$is_reply} ";
            }
            if ($evaluate != "") {
                $strWhere .= " and evaluate = {$evaluate} ";
            }
            if (! empty($startTime) && ! empty($endTime)) {
                $strWhere .= ' and add_time > '.strtotime($startTime.' 00:00:00').' and add_time < '.strtotime($endTime.' 23:59:59').' ';
            }
            $this->session->set_userdata('search', $strWhere);
        }

        //分页
        $this->config->load('pagination_config', TRUE);
        $paginationCount = $this->Comment_model->rowCount($strWhere);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url()."index.php/{$this->_template}/my_get_comment_list/{$clear}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->Comment_model->gets('*', $strWhere, $paginationConfig['per_page'], $page);

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '评价管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list'  =>$item_list,
            'pagination'=>$pagination,
            'paginationCount'=>$paginationCount,
            'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
            'comment_status_arr'=>$this->_comment_status_arr,
            'evaluate_arr'=>$this->_evaluate_arr,
            'clear'=>$clear
        );

        $layout = array(
            'content'=>$this->load->view("{$this->_template}/my_get_comment_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_save_comment($comment_id = NULL){
        //判断是否登录
        checkLogin();
        if ($comment_id){
            checkPermission('comment_edit');
        }else{
            checkPermission('comment_add');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $comment_id = intval($comment_id);
        $item_info = $this->Comment_model->get('*',array('id'=>$comment_id));
        $order_info = $this->Orders_model->get('id', array('order_number' => $item_info['order_number']));
        $comment_store_info = $this->Comment_store_model->get('*', array('order_id' => $order_info['id'], 'store_id' => $store_info['id']));
        $attachment_list = NULL;
        if($item_info['batch_path_ids']){
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }
        $store_reply_info = $this->Store_reply_comment_model->get('*', array('comment_id'=>$item_info['id']));
        if($_POST){
            $evaluate = $this->input->post('evaluate');
            $content = $this->input->post('content');
            if (empty($evaluate)){
                printAjaxError('evaluate', '请对用户进行评价');
            }
            $datas = array(
                'comment_id'=>$item_info['id'],
                'order_id'=>$order_info['id'],
                'user_id'=>$item_info['user_id'],
                'product_id'=>$item_info['product_id'],
                'store_id'=>$store_info['id'],
                'add_time'=>time(),
                'evaluate'=>$evaluate,
                'content'=>$content,
            );
            if($this->Store_reply_comment_model->save($datas)){
                $res1 = $this->Comment_model->save(array('is_reply'=>1), array('id'=>$item_info['id']));
                if(!$res1){
                    printAjaxError('', '操作异常');
                }
                $user_info = $this->User_model->get('evaluate_a,evaluate_b,evaluate_c',array('id'=>$item_info['user_id']));
                if($evaluate == 1){
                    $this->User_model->save(array('evaluate_a'=>$user_info['evaluate_a']+1), array('id'=>$item_info['user_id']));
                }
                if($evaluate == 1){
                    $this->User_model->save(array('evaluate_b'=>$user_info['evaluate_b']+1), array('id'=>$item_info['user_id']));
                }
                if($evaluate == 1){
                    $this->User_model->save(array('evaluate_c'=>$user_info['evaluate_c']+1), array('id'=>$item_info['user_id']));
                }
                $prfUrl = base_url() . "index.php/seller/my_save_comment/{$comment_id}.html";
                printAjaxSuccess($prfUrl, '回复成功');
            }
            printAjaxError('fail', '回复失败');
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '评价处理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info' => $item_info,
            'comment_store_info' => $comment_store_info,
            'attachment_list' => $attachment_list,
            'store_reply_info' => $store_reply_info,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_comment", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //部门设置
    public function my_seller_group_list() {

        checkLogin(true);
        //判断是否权限
        checkPermission("seller_group_index");

        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $item_list = $this->Seller_group_model->gets('*',array('user_id' => $seller_group_info['user_id']));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '部门设置_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list' => $item_list
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_seller_group_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //编辑部门
    public function my_save_seller_group($id = NULL) {
        checkLogin(true);
        if ($id) {
            checkPermission("seller_group_edit");
        } else {
            checkPermission("seller_group_add");
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $item_info = $this->Seller_group_model->get('*', array('id' => $id));
        if ($_POST) {
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $fields = array(
                'group_name'=>$this->input->post('group_name', TRUE),
                'permissions'=>$this->input->post('permissions', TRUE),
                'user_id'=>$seller_group_info['user_id']
            );
            if ($this->Seller_group_model->save($fields, $id?array('id'=>$id):$id)) {
                $prfUrl = getBaseUrl(false, '', 'seller/my_seller_group_list.html', $systemInfo['client_index']);
                printAjaxSuccess($prfUrl, '操作成功');
            } else {
                printAjaxError('fail', "操作失败！");
            }


        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '编辑部门_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info' => $item_info,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_seller_group", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //删除部门
    public function my_delete_seller_group() {
        checkLoginAjax(true);
        checkPermissionAjax('seller_group_delete');
        if ($_POST) {

            $id = intval($this->input->post('id', TRUE));
            if (!$this->form_validation->required($id)) {
                printAjaxError('title', 'id不能为空');
            }
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            $user_info = $this->User_model->get('seller_group_id', array('id' => $seller_group_info['user_id']));
            if ($user_info['seller_group_id'] == $id){
                printAjaxError('fail','超级管理员不能删除！');
            }
            $result = $this->Seller_group_model->delete(array('id' => $id));
            if ($result) {
                $this->User_model->delete("seller_group_id = {$id} and id <> {$seller_group_info['user_id']}");
                printAjaxSuccess('success', '删除成功');
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }

    //账号管理
    public function my_get_seller_list($clear = 0, $page = 0) {
        //判断是否登录
        checkLogin(true);
        checkPermission('user_index');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $seller_group_list = $this->Seller_group_model->gets('id,group_name',array('user_id'=>$seller_group_info['user_id']));
        $ids = '';
        $group_name_arr = array();
        foreach ($seller_group_list as $seller){
            $ids .= $seller['id'].',';
            $group_name_arr[$seller['id']] = $seller['group_name'];
        }
        $ids = substr($ids, 0,-1);

        if (!$clear) {
            $clear = 1;
            $this->session->unset_userdata(array('search' => ''));
        }
        $condition = "seller_group_id in ({$ids})";
        $strWhere = $this->session->userdata('search') ? $this->session->userdata('search') : $condition;
        if($_POST){
            $strWhere = $condition;

            $username = $this->input->post('username');
            $seller_group = $this->input->post('seller_group');
            $startTime = $this->input->post('add_time_start');
            $endTime = $this->input->post('add_time_end');


            if (! empty($username) ) {
                $strWhere .= " and username like '%".$username."%'";
            }
            if (! empty($seller_group) ) {
                $strWhere .= " and seller_group_id = $seller_group";
            }

            if (! empty($startTime) && ! empty($endTime)) {
                $strWhere .= ' and add_time > '.strtotime($startTime.' 00:00:00').' and add_time < '.strtotime($endTime.' 23:59:59').' ';
            }
            $this->session->set_userdata('search', $strWhere);
        }
        //分页
        $paginationCount = $this->User_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/seller/my_get_seller_list/{$clear}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $paginationConfig['per_page'] = 10;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();
        $item_list = $this->User_model->gets($strWhere, $paginationConfig['per_page'], $page);

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '账号管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list' => $item_list,
            'pagination' => $pagination,
            'group_name_arr' => $group_name_arr,

        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_get_seller_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //编辑账号
    public function my_save_seller($id = NULL) {
        checkLogin(true);
        if ($id) {
            checkPermission("user_edit");
        } else {
            checkPermission("user_add");
        }
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $seller_group_list = $this->Seller_group_model->gets('id,group_name',array('user_id'=>$seller_group_info['user_id']));
        $group_name_arr = array();
        foreach ($seller_group_list as $seller){
            $group_name_arr[$seller['id']] = $seller['group_name'];
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $item_info = $this->User_model->get('*', array('id' => $id));
        if ($_POST) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);
            $ref_password = $this->input->post('ref_password', TRUE);
            $seller_group_id = $this->input->post('seller_group_id', TRUE);

            if (!$username){
                printAjaxError('fail','请填写用户名');
            }
            if (!$id){
                if (!$password){
                    printAjaxError('fail','请填写密码');
                }
                if ($password != $ref_password){
                    printAjaxError('fail','密码不一致');
                }
            }

            if (!$seller_group_id){
                printAjaxError('fail','请选择部门');
            }
            $addTime = time();
            $password = $this->createPasswordSALT($username, $addTime, $password);
            $fields = array(
                'username'=>      $username,
                'password'=>      $password,
                'user_group_id'=>      1,
                'seller_group_id'=>      $seller_group_id,
                'nickname'=>      $this->input->post('nickname', TRUE),
                'real_name'=>     $this->input->post('real_name', TRUE),
                'qq_number'=>     $this->input->post('qq_number', TRUE),
                'mobile'=>         $this->input->post('mobile', TRUE),
                'add_time' => $addTime
            );

            if (empty($id)) {
                if ($this->User_model->validateUnique($username)) {
                    printAjaxError('fail', "用户名已经存在，请换个用户名！");
                }
            }
            if ($this->User_model->save($fields, $id?array('id'=>$id):$id)) {
                $prfUrl = getBaseUrl(false, '', 'seller/my_get_seller_list.html', $systemInfo['client_index']);
                printAjaxSuccess($prfUrl, '操作成功');
            } else {
                printAjaxError('fail', "操作失败！");
            }


        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '编辑账号_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_info' => $item_info,
            'group_name_arr' => $group_name_arr,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_save_seller", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //删除账号
    public function my_delete_seller() {
        checkLoginAjax(true);
        checkPermissionAjax('user_delete');
        if ($_POST) {

            $id = intval($this->input->post('id', TRUE));
            if (!$this->form_validation->required($id)) {
                printAjaxError('title', 'id不能为空');
            }
            $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
            if ($id == $seller_group_info['user_id']){
                printAjaxError('fail','店铺主账号不能删除');
            }

            $result = $this->User_model->delete("id = {$id} and id <> {$seller_group_info['user_id']}");
            if ($result) {
                printAjaxSuccess('success', '删除成功');
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }

    //团预购
    public function promotion_ptkj_list($clear = '1', $page = 0)
    {
        //判断是否登录
        checkLogin(true);
        checkPermission("groupon_index");
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        if ($clear) {
            $clear = 0;
            $this->session->unset_userdata(array('search' => ''));
        }
        $condition = "promotion_ptkj.store_id = {$store_info['id']}";
        $strWhere = $this->session->userdata('search') ? $this->session->userdata('search') : $condition;
        //分页
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationCount = $this->Promotion_ptkj_model->rowCount($strWhere);
        $paginationConfig['base_url'] = base_url()."admincp.php/{$this->_template}/index/{$clear}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->Promotion_ptkj_model->gets($strWhere, $paginationConfig['per_page'], $page);

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '团预购活动管理_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'item_list' => $item_list,
            'pagination' => $pagination,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/promotion_ptkj_list", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function promotion_ptkj_save($id = NULL)
    {
        //判断是否登录
        checkLogin(true);
        if ($id) {
            checkPermission("groupon_edit");
        } else {
            checkPermission("groupon_add");
        }
        $prfUrl = base_url()."index.php/{$this->_template}/promotion_ptkj_list/1";
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $productInfo = array();
        $pintuan_arr = array();
        if ($id) {
            $itemInfo = $this->Promotion_ptkj_model->get('*', array('id' => $id));
            $productInfo = $this->Product_model->get('*',array('product.id' => $itemInfo['product_id']));
            $pintuan_arr = $this->Pintuan_model->gets(array('ptkj_id' => $id));
        } else {
            $itemInfo = array();
        }
        if ($_POST) {
            $product_id = $this->input->post('product_id', true);
            $type = $this->input->post('type', true);
            $sale_price = $this->input->post('sale_price', true);
            $deposit = $this->input->post('deposit', true);
            $min_number = $this->input->post('min_number', true);
            $max_number = $this->input->post('max_number', true);
            $start_time = strtotime($this->input->post('start_time', true));
            $end_time = strtotime($this->input->post('end_time', true));
            $is_open = $this->input->post('is_open', true);
            if ($end_time <= $start_time) {
                printAjaxError('error', "团预购活动结束时间必须大于团预购活动开始时间");
            }
            if ($end_time < time()) {
                printAjaxError('error', "团预购活动结束时间必须大于当前时间");
            }
            if (!empty($id) && time() > $itemInfo['start_time'] && time() < $itemInfo['end_time']) {
                $count = $this->Ptkj_record_model->rowCount(array('ptkj_id' => $id));
                if ($count > 0) {
                    printAjaxError('error', "活动正在进行,不可修改！");
                }
            }
            if (empty($id)) {
                $tmp_data = $this->Promotion_ptkj_model->get('*', array('product_id' => $product_id));
                if (!empty($tmp_data) && time() > $tmp_data['start_time'] && time() < $tmp_data['end_time']) {
                    printAjaxError('error', '该商品团预购活动未结束');
                }
            }
            $productInfo = $this->Product_model->get('*',array('product.id' => $product_id));
            $fields = array(
                'product_id' => $product_id,
                'type' => $type,
                'sale_price' => $sale_price,
                'deposit' => $deposit,
                'min_number' => $min_number,
                'max_number' => $max_number,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'is_open' => $is_open,
                'add_time' => time(),
//                'path' => $productInfo['path'],
                'high_price' => $productInfo['sell_price'],
                'store_id' => $store_info['id']
            );
            $retId = $this->Promotion_ptkj_model->save($fields, $id ? array('id' => $id) : $id);

            if ($retId) {
                if ($type == 0){
                    $retId = $id ? $id : $retId;
                    $this->Pintuan_model->delete(array('ptkj_id' => $retId));
                    $low_arr = $this->input->post('low', TRUE);
                    $high_arr = $this->input->post('high', TRUE);
                    $money_arr = $this->input->post('money', TRUE);
                    if (empty($low_arr)) {
                        printAjaxError('error', "团预购规则不能为空!");
                    }
                    $low_str = implode(',', $low_arr);
                    $high_str = implode(',', $high_arr);
                    $money_str = implode(',', $money_arr);
                    if (!empty($low_str) && !empty($high_str) && !empty($money_str)) {
                        foreach ($low_arr as $key => $ls) {
                            if (!is_numeric($ls) || !is_numeric($high_arr[$key]) || empty($money_arr[$key])) {
                                printAjaxError('error', "团预购规则有一项为空!");
                            }
                            $fields_data = array(
                                'low' => $ls,
                                'high' => $high_arr[$key],
                                'money' => $money_arr[$key],
                                'ptkj_id' => $retId,
                                'add_time' => time(),
                            );
                            $this->Pintuan_model->save($fields_data);
                        }
                    } else {
                        printAjaxError('error', "团预购规则有一项为空!");
                    }
                }

                printAjaxSuccess($prfUrl, "保存成功");
            } else {
                printAjaxError('fail', "保存失败");
            }
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '添加团预购活动_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'itemInfo' => $itemInfo,
            'productInfo' => $productInfo,
            'pintuan_arr' => $pintuan_arr,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/promotion_ptkj_save", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }


    public function promotion_ptkj_view($id = NULL)
    {
        //判断是否登录
        checkLogin(true);
        if ($id) {
            checkPermission("groupon_edit");
        } else {
            checkPermission("groupon_add");
        }
        $prfUrl = base_url()."index.php/{$this->_template}/promotion_ptkj_list/1";
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $seller_group_info = $this->Seller_group_model->get('user_id',array('id' => get_cookie('seller_group_id')));
        $store_info = $this->Store_model->get('id', array('user_id' => $seller_group_info['user_id']));
        $productInfo = array();
        $pintuan_arr = array();
        if ($id) {
            $itemInfo = $this->Promotion_ptkj_model->get('*', array('id' => $id));
            $productInfo = $this->Product_model->get('*',array('product.id' => $itemInfo['product_id']));
            $pintuan_arr = $this->Pintuan_model->gets(array('ptkj_id' => $id));
        } else {
            $itemInfo = array();
        }


        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '查看团预购活动_商家中心' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'template' => $this->_template,
            'itemInfo' => $itemInfo,
            'productInfo' => $productInfo,
            'pintuan_arr' => $pintuan_arr,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/promotion_ptkj_view", $data, TRUE)
        );
        $this->load->view('layout/seller_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_delete_promotion_ptkj() {
        if ($_POST) {
            $id = $this->input->post('id', TRUE);

            if (!$id) {
                printAjaxError('fail', '请选择删除项');
            }
            $itemInfo = $this->Promotion_ptkj_model->get('*', array('id' => $id));
            if (!$itemInfo){
                printAjaxError('fail', '参数异常，活动信息不存在');
            }
            if ($itemInfo['is_open'] && $itemInfo['end_time'] > time()){
                printAjaxError('fail', '活动进行中，不可删除');
            }
            $count = $this->Ptkj_record_model->rowCount("ptkj_id in ($id)");
            if ($count > 0) {
                printAjaxError('fail', '有相关记录,不可删除！');
            }
            if ($this->Promotion_ptkj_model->delete('id in (' . $id . ')')) {
                //删除拼团规则
                $this->Pintuan_model->delete("ptkj_id in ({$id})");
                printAjaxSuccess('success','删除成功！');
            }
            printAjaxError('fail', '删除失败！');
        }
    }

    //加盐算法
    public function createPasswordSALT($user, $salt, $password) {

        return md5($user.$salt.$password);
    }

    private function _balance_trade_refund($pay_log_info, $item_info, $orders_info, $user_info, $status = '4') {
        $fields = array(
            'total'=>$user_info['total'] + $item_info['price']
        );
        if (!$this->User_model->save($fields, array('id'=>$orders_info['user_id']))) {
            printAjaxError('fail', '退款操作失败');
        }
        $fields = array(
            'cause'=>"退款成功-[订单号：{$orders_info['order_number']}]",
            'price'=>$item_info['price'],
            'balance'=>$user_info['total'] + $item_info['price'],
            'add_time'=>time(),
            'user_id'=>$user_info['id'],
            'username'=>$user_info['username'],
            'type' =>  'order_in',
            'pay_way'=>'1',
            'ret_id'=>$orders_info['id'],
            'from_user_id'=>$user_info['id']
        );
        $this->Financial_model->save($fields);
        //操作订单
        $fields = array(
            'cancel_cause'=> '交易关闭-[买家申请退款成功]',
            'status'=> 4
        );
        if ($this->Orders_model->save($fields, array('id' => $orders_info['id']))) {
            $fields = array(
                'add_time' => time(),
                'content' => "交易关闭成功-[买家申请退款成功]",
                'order_id' => $orders_info['id'],
                'order_status'=>$orders_info['status'],
                'change_status'=>4
            );
            $this->Orders_process_model->save($fields);
        }
        //操作退款申请状态
        $this->Exchange_model->save(array('status'=>$status, 'update_time'=>time()), array('id'=>$item_info['id']));
        printAjaxSuccess('success', '退款成功');

    }
    private function _checkIdentity($num, $checkSex = '') {
        // 不是15位或不是18位都是无效身份证号
        if (strlen($num) != 15 && strlen($num) != 18) {
            return false;
        }
        // 是数值
        if (is_numeric($num)) {
            // 如果是15位身份证号
            if (strlen($num) == 15) {
                // 省市县（6位）
                $areaNum = substr($num, 0, 6);
                // 出生年月（6位）
                $dateNum = substr($num, 6, 6);
                // 性别（3位）
                $sexNum = substr($num, 12, 3);
            } else {
                // 如果是18位身份证号
                // 省市县（6位）
                $areaNum = substr($num, 0, 6);
                // 出生年月（8位）
                $dateNum = substr($num, 6, 8);
                // 性别（3位）
                $sexNum = substr($num, 14, 3);
                // 校验码（1位）
                $endNum = substr($num, 17, 1);
            }
        } else {
            // 不是数值
            if (strlen($num) == 15) {
                return false;
            } else {
                // 验证前17位为数值，且18位为字符x
                $check17 = substr($num, 0, 17);
                if (!is_numeric($check17)) {
                    return false;
                }
                // 省市县（6位）
                $areaNum = substr($num, 0, 6);
                // 出生年月（8位）
                $dateNum = substr($num, 6, 8);
                // 性别（3位）
                $sexNum = substr($num, 14, 3);
                // 校验码（1位）
                $endNum = substr($num, 17, 1);
                if ($endNum != 'x' && $endNum != 'X') {
                    return false;
                }
            }
        }

        if (isset($areaNum)) {
            if (!$this->checkArea($areaNum)) {
                return false;
            }
        }

        if (isset($dateNum)) {
            if (!$this->checkDate($dateNum)) {
                return false;
            }
        }

        // 性别1为男，2为女
        if ($checkSex == 1) {
            if (isset($sexNum)) {
                if (!$this->checkSex($sexNum)) {
                    return false;
                }
            }
        } else if ($checkSex == 2) {
            if (isset($sexNum)) {
                if ($this->checkSex($sexNum)) {
                    return false;
                }
            }
        }

        if (isset($endNum)) {
            if (!$this->checkEnd($endNum, $num)) {
                return false;
            }
        }
        return true;
    }

    // 验证城市
    private function checkArea($area) {
        $num1 = substr($area, 0, 2);
        $num2 = substr($area, 2, 2);
        $num3 = substr($area, 4, 2);
        // 根据GB/T2260—999，省市代码11到65
        if (10 < $num1 && $num1 < 66) {
            return true;
        } else {
            return false;
        }
        //============
        // 对市 区进行验证
        //============
    }

    // 验证出生日期
    private function checkDate($date) {
        if (strlen($date) == 6) {
            $date1 = substr($date, 0, 2);
            $date2 = substr($date, 2, 2);
            $date3 = substr($date, 4, 2);
            $statusY = $this->checkY('19' . $date1);
        } else {
            $date1 = substr($date, 0, 4);
            $date2 = substr($date, 4, 2);
            $date3 = substr($date, 6, 2);
            $nowY = date("Y", time());
            if (1900 < $date1 && $date1 <= $nowY) {
                $statusY = $this->checkY($date1);
            } else {
                return false;
            }
        }
        if (0 < $date2 && $date2 < 13) {
            if ($date2 == 2) {
                // 润年
                if ($statusY) {
                    if (0 < $date3 && $date3 <= 29) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    // 平年
                    if (0 < $date3 && $date3 <= 28) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                $maxDateNum = $this->getDateNum($date2);
                if (0 < $date3 && $date3 <= $maxDateNum) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    // 验证性别
    private function checkSex($sex) {
        if ($sex % 2 == 0) {
            return false;
        } else {
            return true;
        }
    }

    // 验证18位身份证最后一位
    private function checkEnd($end, $num) {
        $checkHou = array(1, 0, 'x', 9, 8, 7, 6, 5, 4, 3, 2);
        $checkGu = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        $sum = 0;
        for ($i = 0; $i < 17; $i++) {
            $sum += (int) $checkGu[$i] * (int) $num[$i];
        }
        $checkHouParameter = $sum % 11;
        if ($checkHou[$checkHouParameter] != $num[17]) {
            return false;
        } else {
            return true;
        }
    }

    // 验证平年润年，参数年份,返回 true为润年  false为平年
    private function checkY($Y) {
        if (getType($Y) == 'string') {
            $Y = (int) $Y;
        }
        if ($Y % 100 == 0) {
            if ($Y % 400 == 0) {
                return true;
            } else {
                return false;
            }
        } else if ($Y % 4 == 0) {
            return true;
        } else {
            return false;
        }
    }

    // 当月天数 参数月份（不包括2月）  返回天数
    private function getDateNum($month) {
        if ($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12) {
            return 31;
        } else if ($month == 2) {

        } else {
            return 30;
        }
    }

}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */