<?php

class Groupon extends CI_Controller
{

    private $_table = 'promotion_ptkj';
    private $_template = 'groupon';
    private $_type_arr = array('0'=>"叠加团",'1'=>"固定团");
    private $_options_arr = array('1'=>'7天无理由退换','2'=>'45天无理由退换','3'=>'包物流','4'=>'送货入户并安装','5'=>'一年质保');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('System_model', "", TRUE);
        $this->load->model('Menu_model', "", TRUE);
        $this->load->model('Product_model', "", TRUE);
        $this->load->model('Promotion_ptkj_model', "", TRUE);
        $this->load->model('Attachment_model', "", TRUE);
        $this->load->model('Product_size_color_model', "", TRUE);
        $this->load->model('Comment_model', "", TRUE);
        $this->load->model('Pintuan_model', "", TRUE);
        $this->load->model('Ptkj_record_model', "", TRUE);
        $this->load->model('Postage_way_model', "", TRUE);
        $this->load->model('User_address_model', "", TRUE);
        $this->load->model('User_model', "", TRUE);
        $this->load->model('Store_model', "", TRUE);
        $this->load->model('Store_reply_comment_model', "", TRUE);
        $this->load->model('Orders_model', "", TRUE);
        $this->load->model('Orders_detail_model', "", TRUE);
        $this->load->model('Orders_process_model', "", TRUE);
        $this->load->model('Favorite_model', "", TRUE);
        $this->load->model('Financial_model', "", TRUE);
        $this->load->model('Pay_log_model', "", TRUE);
        $this->load->library('Form_validation');
    }

    public function index()
    {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $current_time = time();
        $item_list = $this->Promotion_ptkj_model->gets("{$this->_table}.is_open = 1 and {$this->_table}.start_time <= $current_time and {$this->_table}.end_time > $current_time and {$this->_table}.is_success = 0");

        foreach ($item_list as $key => $item) {
            if ($item['type']){
                $item_list[$key]['pintuan_price'] = $item['sale_price'];
            }else{
                $pintuan_rule = $this->Pintuan_model->gets("ptkj_id = {$item['id']}");
                $max = 0;
                foreach ($pintuan_rule as $ls) {
                    if ($item['pintuan_people'] >= $ls['low'] && $item['pintuan_people'] <= $ls['high']) {
                        $max = $ls['money'];
                        break;
                    }else{
                        $max = max($max,$ls['money']);
                    }
                }
                $item_list[$key]['pintuan_price'] = $max;
            }

        }
        //当前位置
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title'=>'团预购'.$systemInfo['site_name'],
            'keywords' => '团预购',
            'description' => '蚁立网团预购',
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_list' => $item_list,
            'type_arr' => $this->_type_arr,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/index", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function detail($id = null)
    {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $pintuan_info = $this->Promotion_ptkj_model->get('*', array('id' => $id,'is_open'=>1));
        if (empty($pintuan_info)) {
            $data = array(
                'user_msg' => '不存在该团预购活动',
                'user_url' => 'index.php'
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $timestamp = time();
        if ($timestamp < $pintuan_info['start_time']) {
            $data = array(
                'user_msg' => '该团预购活动暂未开始',
                'user_url' => 'index.php'
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $item_info = array();
        if ($pintuan_info) {
            $item_info = $this->Product_model->get("*", array('id' => $pintuan_info['product_id']));
        }
        if (!$item_info) {
            $data = array(
                'user_msg' => '此商品不存在或被删除',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        //记录浏览次数
        $this->Product_model->save(array('hits' => $item_info['hits'] + 1), array('id' => $id));
        //主图
        $attachment_list = NULL;
        if ($item_info && $item_info['batch_path_ids']) {
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }

        //当前位置
        if ($systemInfo['html']) {
            $location = "<a href='index.html'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
        } else {
            $location = "<a href='{$systemInfo['client_index']}'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
        }
        $url = $systemInfo['client_index'];
        $url .= $systemInfo['client_index'] ? '/' : '';
        $url = $this->Menu_model->getLocation(80, $systemInfo['html'], $url);
        $location .= $url;
        //评论列表
        $comment_count = $this->Comment_model->rowCount(array('product_id'=>$item_info['id']));
        $evaluate_a_count = $this->Comment_model->rowCount(array('product_id'=>$item_info['id'],'evaluate'=>1));
        $evaluate_b_count = $this->Comment_model->rowCount(array('product_id'=>$item_info['id'],'evaluate'=>2));
        $evaluate_c_count = $this->Comment_model->rowCount(array('product_id'=>$item_info['id'],'evaluate'=>3));
        $comment_list = $this->Comment_model->gets('*',array('product_id'=>$item_info['id']));
        if ($comment_list){
            foreach ($comment_list as $key=>$item){
                $user_info = $this->User_model->get('path', array('id'=>$item['user_id']));
                $comment_list[$key]['user_logo'] = $user_info['path'];
                $store_reply = array();
                if ($item['is_reply']){
                    $store_reply_info = $this->Store_reply_comment_model->get('content',array('comment_id'=>$item['id']));
                    if($store_reply_info){
                        $store_reply = $store_reply_info['content'];
                    }
                }
                $comment_list[$key]['store_reply'] = $store_reply;
                $comment_attachment_list = NULL;
                if($item['batch_path_ids']){
                    $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item['batch_path_ids']);
                    $comment_attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
                }
                $comment_list[$key]['attachment_list'] = $comment_attachment_list;
            }
        }
        //颜色
        $color_list = $this->Product_size_color_model->gets('id, color_id, color_name, color_name_hint, path', array('product_id'=>$item_info['id']), 'color_id');
        //尺码
        $size_list = $this->Product_size_color_model->gets('id, size_id, size_name, size_name_hint', array('product_id'=>$item_info['id']), 'size_id');
        //店铺信息
        $store_info = $this->Store_model->get('id, store_name', array('id'=>$item_info['store_id']));

        $class_str = '';

        $bond_record_info = $this->Ptkj_record_model->get(array('ptkj_record.ptkj_id' => $pintuan_info['id'], 'ptkj_record.user_id' => get_cookie('user_id'), 'ptkj_record.is_bond' => 1));
        if ($bond_record_info) {
            if ($bond_record_info['end_time'] < time() || $bond_record_info['is_success']){
                if ($pintuan_info['min_number'] > $pintuan_info['pintuan_people']){
                    $button_str = '活动未成功';
                    $class_str = 'add_gray';
                    $gourl = 'javascript:void(0);';
                }else{
                    //是否逾期
                    $success_time = $bond_record_info['is_success'] ? $pintuan_info['success_time'] : $pintuan_info['end_time'];
                    if (strtotime('+24hours',$success_time) < time()){
                        $button_str = '活动已结束';
                        $class_str = 'add_gray';
                        $gourl = 'javascript:void(0);';
                    }else{
                        if ($this->Orders_model->rowCount(array('user_id'=>get_cookie('user_id'),'groupon_id'=>$id,'order_type'=>1))){
                            $button_str = '活动已结束';
                            $class_str = 'add_gray';
                            $gourl = 'javascript:void(0);';
                        }else{
                            $button_str = '支付尾款';
                            $gourl = 'javascript:alertMask();';
                        }

                    }

                }

            }else{
                $button_str = '已参团';
                $gourl = 'javascript:void(0);';
            }

        }else{
            if ($timestamp > $pintuan_info['end_time'] || $pintuan_info['is_success']){
                $button_str = '活动已结束';
                $class_str = 'add_gray';
                $gourl = 'javascript:void(0);';
            }else{
                $button_str = '参团交定金';
                $gourl = base_url() . 'index.php/groupon/add_groupon_pay/' . $pintuan_info['id'];

            }
        }


        //配送方式
//        $postage_way = $this->Postage_way_model->gets('*', array('display' => 1));
        //用户收货地址
        $user_address_list = $this->User_address_model->gets('*', array('user_id' => get_cookie('user_id')));

        //当前价格
        $pintuan_rule = $this->Pintuan_model->gets(array('ptkj_id' => $pintuan_info['id']));
        $pintuan_price = $item_info['sell_price'];
        $min = $item_info['sell_price'];
//        $max = 0;
        if ($pintuan_info['type']){
            $pintuan_price = $pintuan_info['sale_price'];
            $min = $pintuan_info['sale_price'];
        }else{
            foreach ($pintuan_rule as $ls) {
                if ($pintuan_info['pintuan_people'] >= $ls['low'] && $pintuan_info['pintuan_people'] <= $ls['high']) {
                    $pintuan_price = number_format($ls['money'], 2,'.','');
                }
                $min = min($min,$ls['money']);
//            $max = max($max,$ls['money']);
            }
        }

        $pintuan_info['low_price'] = $min;
//        $pintuan_info['high_price'] = $max;

        //用户是否收藏店铺
        $favorite_store_count = $this->Favorite_model->rowCount('store', array('favorite.type'=>'store','favorite.user_id'=>get_cookie('user_id'),'favorite.item_id'=>$item_info['store_id']));

        //当前位置
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $item_info['title'] . $systemInfo['site_name'],
            'keywords' => $item_info['keyword'],
            'description' => $item_info['abstract'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'systemInfo' => $systemInfo,
            'item_info' => $item_info,
            'store_info'=> $store_info,
            'attachment_list' => $attachment_list,
            'location' => $location,
            'parent_id' => '80',
            'color_list'=>$color_list,
            'size_list'=>$size_list,
            'comment_count'=>$comment_count,
            'evaluate_a_count'=>$evaluate_a_count,
            'evaluate_b_count'=>$evaluate_b_count,
            'evaluate_c_count'=>$evaluate_c_count,
            'comment_list'=>$comment_list,
            'options_arr' => $this->_options_arr,
            'pintuan_info' => $pintuan_info,
            'pintuan_rule' => $pintuan_rule,
            'button_str' => $button_str,
            'class_str' => $class_str,
            'gourl' => $gourl,
//            'postage_way' => $postage_way,
            'user_address_list' => $user_address_list,
            'favorite_store_count' => $favorite_store_count,
            'pintuan_price' => $pintuan_price
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/detail", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //获取价格、库存
    public function get_stock() {
        if ($_POST) {
            $product_id = $this->input->post('product_id');
            $color_id = $this->input->post('color_id', TRUE);
            $size_id = $this->input->post('size_id', TRUE);
            $ptkj_id = $this->input->post('ptkj_id', TRUE);

            if (!$product_id || !$color_id || !$size_id || !$ptkj_id) {
                printAjaxError('fail', '操作异常');
            }
            $pintuan_info = $this->Promotion_ptkj_model->get('*', array('id' => $ptkj_id));
            $product_info = $this->Product_model->get('sell_price', array('id' => $product_id));
            //当前价格
            $pintuan_rule = $this->Pintuan_model->gets(array('ptkj_id' => $ptkj_id));
            $pintuan_price = $product_info['sell_price'];
            if ($pintuan_info['type']){
                $pintuan_price = $pintuan_info['sale_price'];
            }else{
                foreach ($pintuan_rule as $ls) {
                    if ($pintuan_info['pintuan_people'] >= $ls['low'] && $pintuan_info['pintuan_people'] <= $ls['high']) {
                        $pintuan_price = $ls['money'];
                    }
                }
            }



            $item_info = $this->Product_model->getProductStock($product_id, $color_id, $size_id);

            $item_info['price'] = number_format($item_info['price'] - $product_info['sell_price'] + $pintuan_price,2,'.','');

            if ($item_info) {
                printAjaxData($item_info);
            } else {
                printAjaxError('fail', '获取失败');
            }
        }
    }

    public function add_groupon_pay($ptkj_id = null)
    {
        $pre_url = $this->session->userdata("gloabPreUrl") ? $this->session->userdata("gloabPreUrl") : base_url();
        //判断是否登录
        checkLogin();
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $user_info = $this->User_model->get('total', array('id' => $user_id));

        $pintuan_info = $this->Promotion_ptkj_model->get('*', array('id' => $ptkj_id,'is_open'=>1));
        if (empty($pintuan_info)) {
            $data = array(
                'user_msg' => '该团预购活动不存在',
                'user_url' => $pre_url
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $timestamp = time();
        if ($timestamp < $pintuan_info['start_time'] || $timestamp > $pintuan_info['end_time'] || $pintuan_info['is_success']) {
            $data = array(
                'user_msg' => '该团预购活动暂未开始或已结束',
                'user_url' => $pre_url
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }

        $product_info = $this->Product_model->get('title, store_id', array('id' => $pintuan_info['product_id'], 'display' => 1));
        if (!$product_info) {
            $data = array(
                'user_msg' => '此产品不存在或被删除',
                'user_url' => $pre_url
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $store_info = $this->Store_model->get('user_id',array('id'=>$product_info['store_id']));

        $record_info = $this->Ptkj_record_model->get(array('ptkj_record.ptkj_id' => $pintuan_info['id'], 'ptkj_record.user_id' => get_cookie('user_id')));
        if ($record_info){
            if ($record_info['is_bond']){
                $data = array(
                    'user_msg' => '已参团成功，请勿重新提交！',
                    'user_url' => $pre_url
                );
                $this->session->set_userdata($data);
                redirect('/message/index');
            }else{
                $this->Ptkj_record_model->save(array('add_time'=>$timestamp),array('id'=>$record_info['id']));
            }

            $record_id = $record_info['id'];

        }else{
            $datas = array(
                'user_id' => $user_id,
                'ptkj_id' => $ptkj_id,
                'product_title' => $product_info['title'],
                'product_id' => $pintuan_info['product_id'],
                'store_id' => $product_info['store_id'],
                'seller_id' => $store_info['user_id'],
                'buy_number' => 1,
                'add_time' => $timestamp,
            );
            $bond_number = $this->_getUniqueBondNumber();
            $datas['bond_number'] = $bond_number;
            $record_id = $this->Ptkj_record_model->save($datas);
        }



        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '付定金',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'user_info'=>$user_info,
            'pintuan_info'=>$pintuan_info,
            'product_info'=>$product_info,
            'record_id'=>$record_id,
        );
        $layout = array(
            'content' => $this->load->view('groupon/add_groupon_pay', $data, TRUE)
        );
        $this->load->view('layout/cart_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function add_now_order()
    {
        $pre_url = $this->session->userdata("gloabPreUrl") ? $this->session->userdata("gloabPreUrl") : base_url();
        //判断是否登录
        checkLoginAjax();
        $user_id = get_cookie('user_id');
        $user_info = $this->User_model->get('total,username', array('id' => $user_id));

        $ptkj_id = $this->input->post('ptkj_id',TRUE);
        $color_id = $this->input->post('color_id',TRUE);
        $size_id = $this->input->post('size_id',TRUE);
        $address_id = $this->input->post('address_id',TRUE);
        //用已经存在的收货地址
        $user_address_info = $this->User_address_model->get('*', array('id' => $address_id));
        if (!$user_address_info) {
            printAjaxError('fail', '此收货地址信息不存在，下单失败');
        }

        $pintuan_info = $this->Promotion_ptkj_model->get('*', array('id' => $ptkj_id));
        if (empty($pintuan_info)) {
            printAjaxError('fail','该团预购活动不存在');
        }
        $timestamp = time();
        if ($timestamp < $pintuan_info['end_time'] && !$pintuan_info['is_success']){
            printAjaxError('fail','活动未成团，稍后再试');
        }
        if ($pintuan_info['min_number'] > $pintuan_info['pintuan_people']){
            printAjaxError('fail','活动未成团，将会退还定金');
        }
        //是否逾期
        $success_time = $pintuan_info['is_success'] ? $pintuan_info['success_time'] : $pintuan_info['end_time'];
        if (strtotime('+24hours',$success_time) < time()){
            printAjaxError('fail','逾期未支付，活动已结束');
        }

        $product_info = $this->Product_model->get('*', array('id' => $pintuan_info['product_id'], 'display' => 1));
        if (!$product_info) {
            printAjaxError('fail','此产品不存在或被删除');
        }
        $store_info = $this->Store_model->get('user_id,store_name',array('id'=>$product_info['store_id']));
        $record_info = $this->Ptkj_record_model->get(array('ptkj_record.ptkj_id' => $pintuan_info['id'], 'ptkj_record.user_id' => get_cookie('user_id'), 'ptkj_record.is_bond' => 1));
        if (!$record_info){
            printAjaxError('fail','未成功参加团预购');
        }

        //当前价格
        $pintuan_rule = $this->Pintuan_model->gets(array('ptkj_id' => $ptkj_id));
        $pintuan_price = $product_info['sell_price'];
        if ($pintuan_info['type']){
            $pintuan_price = $pintuan_info['sale_price'];
        }else{
            foreach ($pintuan_rule as $ls) {
                if ($pintuan_info['pintuan_people'] >= $ls['low'] && $pintuan_info['pintuan_people'] <= $ls['high']) {
                    $pintuan_price = $ls['money'];
                }
            }
        }

        $cur_pro_info = $this->Product_model->getProductStock($pintuan_info['product_id'], $color_id, $size_id);
        $cur_price = number_format($cur_pro_info['price'] - $product_info['sell_price'] + $pintuan_price,2,'.','');

        $total = $cur_price - $pintuan_info['deposit'];
        $order_number = $this->_getUniqueBondNumber();
        /****************提交订单*****************/
        $fields = array(
            'user_id' =>      $user_id,
            'user_name'=>     $user_info['username'],
            'seller_id'=>     $store_info['user_id'],
            'store_id'=>      $product_info['store_id'],
            'store_name'=>    $store_info['store_name'],
            'order_number' => $order_number,
            'postage_id' =>   0,
            'postage_title' =>'',
            'postage_price' =>0,
            'product_total'=> 0,
            'taxation_total'=>0,
            'discount_total'=>0,
            'deposit' =>      $pintuan_info['deposit'],
            'total' =>        $total,
            'status' =>       0,
            'add_time' =>    time(),
            'buyer_name' =>  $user_address_info['buyer_name'],
            'country_id'=>   $user_address_info['country_id'],
            'province_id' => $user_address_info['province_id'],
            'city_id' =>     $user_address_info['city_id'],
            'area_id' =>     $user_address_info['area_id'],
            'txt_address' => $user_address_info['txt_address'],
            'address' =>     $user_address_info['address'],
            'phone' =>       $user_address_info['phone'],
            'mobile' =>      $user_address_info['mobile'],
            'remark' =>      '',
            'order_type' => 1,
            'groupon_id' => $ptkj_id,
        );
        //添加订单
        $ret_id = $this->Orders_model->save($fields);
        if ($ret_id) {
            /***************************添加订单详细信息*********************** */

            //订单详情
            $orders_detail_fields = array(
                'order_id' =>        $ret_id,
                'product_id' =>      $pintuan_info['product_id'],
                'product_num' =>     $product_info['product_num'],
                'product_title' =>   $product_info['title'],
                'buy_number' =>      1,
                'buy_price' =>       $cur_price,
                'size_name' =>       $cur_pro_info['size_name'],
                'size_id' =>         $size_id,
                'color_name' =>      $cur_pro_info['color_name'],
                'color_id' =>        $color_id,
                'path' =>            $product_info['path'],
                'color_size_open'=>     $product_info['color_size_open'],
                'product_color_name'=>  $product_info['product_color_name'],
                'product_size_name'=>   $product_info['product_size_name']
            );
            if (!$this->Orders_detail_model->save($orders_detail_fields)) {
                //删除订单详细信息
                $this->Orders_detail_model->delete("order_id = {$ret_id}");
                //删除记录
                $this->Orders_process_model->delete("order_id = {$ret_id}");
                //删除已经添加进去的数据，保持数据统一性
                $this->Orders_model->delete("id order_id = {$ret_id}");
                printAjaxError('fail','订单创建失败');
            }else{
                //订单跟踪记录
                $orders_process_fields = array(
                    'add_time' =>     time(),
                    'content' =>      "订单创建成功",
                    'order_id' =>     $ret_id,
                    'order_status'=>  0,
                    'change_status'=> 0
                );
                $this->Orders_process_model->save($orders_process_fields);
            }
            printAjaxSuccess(base_url() . "index.php/order/my_go_to_pay/{$ret_id}.html", '订单提交成功');

        }
        printAjaxError('fail','订单创建失败');
    }





    //支付宝支付
    public function alipay_pay($record_id = NULL) {
        header('Content-type:text/html;charset=utf-8');
        $gloabPreUrl = $this->session->userdata('gloabPreUrl');
        checkLogin();
        if (!$record_id) {
            $data = array(
                'user_msg' => '操作异常',
                'user_url' => $gloabPreUrl
            );

            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $user_id = get_cookie('user_id');
        //判断下单用户是否存在
        $user_info = $this->User_model->get('*', array('user.id' => $user_id));
        if (!$user_info) {
            $data = array(
                'user_msg' => '用户信息不存在，结算失败',
                'user_url' => $gloabPreUrl
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $item_info = $this->Ptkj_record_model->get("ptkj_record.id = '{$record_id}' and ptkj_record.user_id = {$user_id} and ptkj_record.is_bond = 0");
        if (!$item_info) {
            $data = array(
                'user_msg' => '信息不存在',
                'user_url' => $gloabPreUrl
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $out_trade_no = $item_info['bond_number'];
        $total_fee =  $item_info['deposit'];
        //生成支付记录
        if(!$this->Pay_log_model->rowCount(array('out_trade_no'=>$out_trade_no, 'payment_type'=>'alipay', 'order_type'=>'groupon'))) {
//            $this->Ptkj_record_model->save(array('out_trade_no'=>$out_trade_no), array('id'=>$item_info['id']));
            $fields = array(
                'user_id'=>       $user_id,
                'total_fee'=>     $total_fee,
                'total_fee_give'=>0,
                'out_trade_no'=>  $out_trade_no,
                'order_num'=>     $item_info['bond_number'],
                'trade_status'=>  'WAIT_BUYER_PAY',
                'add_time'=>      time(),
                'payment_type'=>  'alipay',
                'order_type'=>    'groupon',
                'seller_id'=>    $item_info['seller_id'],
                'store_id'=>    $item_info['store_id'],
            );
            if (!$this->Pay_log_model->save($fields)) {
                $data = array(
                    'user_msg' => '支付失败，请重试',
                    'user_url' => $gloabPreUrl
                );
                $this->session->set_userdata($data);
                redirect(base_url() . 'index.php/message/index');
            }
        }
        /********************支付***********************/
        require_once("sdk/alipay/alipay.config.php");
        require_once("sdk/alipay/lib/alipay_submit.class.php");

        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service"       => $alipay_config['service'],
            "partner"       => $alipay_config['partner'],
            "seller_id"  =>    $alipay_config['seller_id'],
            "payment_type"	=> $alipay_config['payment_type'],
            "notify_url"	=> base_url().'index.php/groupon/alipay_notify',
            "return_url"	=> base_url().'index.php/groupon/alipay_return',
            "anti_phishing_key"=>$alipay_config['anti_phishing_key'],
            "exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
            "out_trade_no"	=> $out_trade_no,
            "subject"	=>"蚁立网团预购支付定金",
            "total_fee"	=> $total_fee,
            "body"	=> '蚁立网即时到账支付',
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );
        $alipay_config['notify_url'] = $parameter['notify_url'];
        $alipay_config['return_url'] = $parameter['return_url'];
        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }

    //支付 宝异步通知
    public function alipay_notify() {
        if ($_POST) {
            require_once("sdk/alipay/alipay.config.php");
            require_once("sdk/alipay/lib/alipay_notify.class.php");
            //计算得出通知验证结果
            $alipay_config['notify_url'] = base_url().'index.php/groupon/alipay_notify';
            $alipay_config['return_url'] = base_url().'index.php/groupon/alipay_return';
            $alipayNotify = new AlipayNotify($alipay_config);
            $verify_result = $alipayNotify->verifyNotify();
            if($verify_result) {
                //商户订单号
                $out_trade_no = $this->input->post('out_trade_no', TRUE);
                $order_num = $out_trade_no;
                //支付宝交易号
                $trade_no     = $this->input->post('trade_no', TRUE);
                //交易状态
                $trade_status = $this->input->post('trade_status', TRUE);
                //买家支付宝账号
                $buyer_email  = $this->input->post('buyer_email', TRUE);
                //通知时间
                $notify_time  = strtotime($this->input->post('notify_time', TRUE));
                $seller_id  = $this->input->post('seller_id', TRUE);
                $total_fee  = $this->input->post('total_fee', TRUE);
                if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                    $pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no'=>$out_trade_no, 'order_type'=>'groupon', 'payment_type'=>'alipay'));
                    if ($pay_log_info && $alipay_config['seller_id'] == $seller_id && $total_fee == $pay_log_info['total_fee']) {
                        if ($pay_log_info['trade_status'] != $trade_status && $pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
                            //支付记录
                            $fields = array(
                                'payment_type'=> 'alipay',
                                'order_type'=>   'groupon',
                                'trade_no'=>     $trade_no,
                                'trade_status'=> $trade_status,
                                'buyer_email'=>  $buyer_email,
                                'notify_time'=>  $notify_time
                            );
                            if ($this->Pay_log_model->save($fields, array('id'=>$pay_log_info['id']))) {
                                $item_info = $this->Ptkj_record_model->get("ptkj_record.bond_number = '{$order_num}' and ptkj_record.is_bond = 0");

                                $user_info = $this->User_model->get('id, total, username', array('id'=>$item_info['user_id']));
                                if ($item_info && $user_info) {
                                    //修改订单状态
                                    $fields = array(
                                        'is_bond'=> 1,
                                        'trade_no'=>$trade_no,
                                        'payment_id'=>2);
                                    if ($this->Ptkj_record_model->save($fields, array('id'=>$item_info['id']))) {
                                        $this->Promotion_ptkj_model->save(array('pintuan_people'=>$item_info['pintuan_people']+1),array('id'=>$item_info['ptkj_id']));
                                        if ($item_info['max_number'] == $item_info['pintuan_people']+1){
                                            $this->Promotion_ptkj_model->save(array('is_success'=>1,'success_time'=>time()),array('id'=>$item_info['ptkj_id']));
                                        }
                                        //财务记录
                                        if (!$this->Financial_model->rowCount(array('type'=>'order_out', 'ret_id'=>$item_info['id']))) {
                                            $fields = array(
                                                'cause'=>"支付成功-[订单号：{$item_info['bond_number']}]",
                                                'price'=>-$item_info['deposit'],
                                                'balance'=>$user_info['total'],
                                                'add_time'=>time(),
                                                'user_id'=>$user_info['id'],
                                                'username'=>$user_info['username'],
                                                'type' =>  'order_out',
                                                'pay_way'=>'2',
                                                'ret_id'=>$item_info['id'],
                                                'from_user_id'=>$user_info['id'],
                                                'seller_id'=>$item_info['seller_id'],
                                                'store_id'=>$item_info['store_id'],
                                            );
                                            $this->Financial_model->save($fields);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    //支付 宝同步通知
    public function alipay_return() {
        require_once("sdk/alipay/alipay.config.php");
        require_once("sdk/alipay/lib/alipay_notify.class.php");
        $alipay_config['notify_url'] = base_url().'index.php/groupon/alipay_notify';
        $alipay_config['return_url'] = base_url().'index.php/groupon/alipay_return';
        $gloabPreUrl = $this->session->userdata('gloabPreUrl');
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if (!$verify_result) {
            $data = array(
                'user_msg' => '订单支付失败',
                'user_url' => $gloabPreUrl
            );

            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $out_trade_no = $_GET['out_trade_no'];
        $order_num = $out_trade_no;
        //支付宝交易号
        $trade_no = $_GET['trade_no'];
        //交易状态
        $trade_status = $_GET['trade_status'];
        //买家支付宝账号
        $buyer_email  = $this->input->get('buyer_email', TRUE);
        //通知时间
        $notify_time  = strtotime($this->input->get('notify_time', TRUE));
        $item_info = $this->Ptkj_record_model->get("ptkj_record.bond_number = '{$order_num}' and ptkj_record.is_bond = 0");
        if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
            //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //如果有做过处理，不执行商户的业务程序
            $pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no'=>$out_trade_no, 'order_type'=>'groupon', 'payment_type'=>'alipay'));
            if (!$pay_log_info) {
                $data = array(
                    'user_msg'=>'此支付记录不存在,支付失败',
                    'user_url'=> $gloabPreUrl
                );
                $this->session->set_userdata($data);
                redirect(base_url().'index.php/message/index');
            }
            if ($pay_log_info['trade_status'] != $trade_status && $pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
                //支付记录
                $fields = array(
                    'payment_type'=> 'alipay',
                    'order_type'=>   'groupon',
                    'trade_no'=>     $trade_no,
                    'trade_status'=> $trade_status,
                    'buyer_email'=>  $buyer_email,
                    'notify_time'=>  $notify_time
                );
                if (!$this->Pay_log_model->save($fields, array('id'=>$pay_log_info['id']))) {
                    $data = array(
                        'user_msg'=>'支付失败，请重试',
                        'user_url'=> $gloabPreUrl
                    );
                    $this->session->set_userdata($data);
                    redirect(base_url().'index.php/message/index');
                }

                $user_info = $this->User_model->get('id, total, username', array('id'=>$item_info['user_id']));
                if ($item_info && $user_info) {
                    //修改订单状态
                    $fields = array(
                        'is_bond'=> 1,
                        'payment_id'=>2);
                    if ($this->Ptkj_record_model->save($fields, array('id'=>$item_info['id'], 'is_bond'=>0))) {
                        $this->Promotion_ptkj_model->save(array('pintuan_people'=>$item_info['pintuan_people']+1),array('id'=>$item_info['ptkj_id']));
                        if ($item_info['max_number'] == $item_info['pintuan_people']+1){
                            $this->Promotion_ptkj_model->save(array('is_success'=>1,'success_time'=>time()),array('id'=>$item_info['ptkj_id']));
                        }
                        //财务记录
                        if (!$this->Financial_model->rowCount(array('type'=>'order_out', 'ret_id'=>$item_info['id']))) {
                            $fields = array(
                                'cause'=>"支付成功-[订单号：{$item_info['bond_number']}]",
                                'price'=>-$item_info['deposit'],
                                'balance'=>$user_info['total'],
                                'add_time'=>time(),
                                'user_id'=>$user_info['id'],
                                'username'=>$user_info['username'],
                                'type' =>   'order_out',
                                'pay_way'=>'2',
                                'ret_id'=>$item_info['id'],
                                'from_user_id'=>$user_info['id'],
                                'seller_id'=>$item_info['seller_id'],
                                'store_id'=>$item_info['store_id'],
                            );
                            $this->Financial_model->save($fields);
                        }
                    }
                }
                redirect(base_url() . "index.php/groupon/detail/{$item_info['ptkj_id']}.html");
            } else {
                $fields = array('payment_type'=>'alipay', 'order_type'=>'groupon');
                if (!$pay_log_info['buyer_email']) {
                    $fields['buyer_email'] = $buyer_email;
                }
                if (!$pay_log_info['notify_time']) {
                    $fields['notify_time'] = $notify_time;
                }
                if ($fields) {
                    $this->Pay_log_model->save($fields, array('id'=>$pay_log_info['id']));
                }
                redirect(base_url() . "index.php/groupon/detail/{$item_info['ptkj_id']}.html");
            }
        } else {
            $data = array(
                'user_msg'=>$this->_trade_status_msg[$trade_status].'，支付失败，请重试',
                'user_url'=> $gloabPreUrl
            );
            $this->session->set_userdata($data);
            redirect(base_url().'index.php/message/index');
        }
    }


    //付款-微信支付界面
    public function my_pay_weixin($record_id = NULL)
    {
        $gloabPreUrl = $this->session->userdata('gloabPreUrl');
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        if (!$record_id) {
            $data = array(
                'user_msg' => '操作异常',
                'user_url' => $gloabPreUrl
            );

            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $user_id = get_cookie('user_id');
        //判断下单用户是否存在
        $user_info = $this->User_model->get('*', array('user.id' => $user_id));
        if (!$user_info) {
            $data = array(
                'user_msg' => '用户信息不存在，结算失败',
                'user_url' => $gloabPreUrl
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $item_info = $this->Ptkj_record_model->get("ptkj_record.id = '{$record_id}' and ptkj_record.user_id = {$user_id} and ptkj_record.is_bond = 0");
        if (!$item_info) {
            $data = array(
                'user_msg' => '信息不存在',
                'user_url' => $gloabPreUrl
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }

        /********************微信支付**********************/
        require_once "sdk/weixin_pay/lib/WxPay.Api.php";
        require_once "sdk/weixin_pay/WxPay.NativePay.php";

        $product_id = $item_info['bond_number'];
        $out_trade_no = $item_info['bond_number'];
        $notify = new NativePay();
        $input = new WxPayUnifiedOrder();
        $input->SetBody("蚁立网付款");
        $input->SetAttach("{$item_info['bond_number']}");
        $input->SetTotal_fee($item_info['deposit'] * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url(base_url() . "index.php/groupon/weixin_notify");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($product_id);
        $input->SetOut_trade_no($out_trade_no);
        $result = $notify->GetPayUrl($input);
        $qr_url = '';
        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            $qr_url = $result["code_url"];
            //生成支付记录
            if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'groupon'))) {
                $fields = array(
                    'user_id' => $user_id,
                    'total_fee' => $item_info['deposit'],
                    'total_fee_give' => 0,
                    'out_trade_no' => $out_trade_no,
                    'order_num' => $item_info['bond_number'],
                    'trade_status' => 'WAIT_BUYER_PAY',
                    'add_time' => time(),
                    'payment_type' => 'weixin',
                    'order_type' => 'groupon',
                    'seller_id'=>    $item_info['seller_id'],
                    'store_id'=>    $item_info['store_id'],
                );
                $this->Pay_log_model->save($fields);
            }
        } else {
            if (array_key_exists('result_code', $result) && $result['result_code'] == "FAIL") {
                //商户号重复时，要重新生成
                if ($result['err_code'] == 'OUT_TRADE_NO_USED' || $result['err_code'] == 'INVALID_REQUEST') {
                    $out_trade_no = 'O'.$this->_getUniqueBondNumber();
//                    $this->tableObject->save(array('out_trade_no' => $out_trade_no), array('id' => $item_info['id']));

                    $notify = new NativePay();
                    $input = new WxPayUnifiedOrder();
                    $input->SetBody("蚁立网付款");
                    $input->SetAttach("{$item_info['bond_number']}");
                    $input->SetTotal_fee($item_info['deposit'] * 100);
                    $input->SetTime_start(date("YmdHis"));
                    $input->SetTime_expire(date("YmdHis", time() + 600));
                    $input->SetNotify_url(base_url() . "index.php/groupon/weixin_notify");
                    $input->SetTrade_type("NATIVE");
                    $input->SetProduct_id($product_id);
                    $input->SetOut_trade_no($out_trade_no);
                    $result = $notify->GetPayUrl($input);
                    if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
                        $qr_url = $result["code_url"];
                        //生成支付记录
                        if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'groupon'))) {
                            $fields = array(
                                'user_id' => $user_id,
                                'total_fee' => $item_info['deposit'],
                                'total_fee_give' => 0,
                                'out_trade_no' => $out_trade_no,
                                'order_num' => $item_info['bond_number'],
                                'trade_status' => 'WAIT_BUYER_PAY',
                                'add_time' => time(),
                                'payment_type' => 'weixin',
                                'order_type' => 'groupon',
                                'seller_id'=>    $item_info['seller_id'],
                                'store_id'=>    $item_info['store_id'],
                            );
                            $this->Pay_log_model->save($fields);
                        }
                    }
                }
            }
        }


        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '去付款',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_info' => $item_info,
            'total' => $item_info ? $item_info['deposit'] : '0.00',
            'qr_url' => $qr_url,
            'result' => $result,
            'out_trade_no' => $out_trade_no,
            'template' => $this->_template
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_pay_weixin", $data, TRUE)
        );
        $this->load->view('layout/cart_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //微信支付异步通知
    public function weixin_notify()
    {
        /********************微信支付**********************/
        require_once "sdk/weixin_pay/lib/WxPay.Api.php";

        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        try {
            $data = WxPayResults::Init($xml);
            if (array_key_exists("transaction_id", $data)) {
                $input = new WxPayOrderQuery();
                $input->SetTransaction_id($data["transaction_id"]);
                $result = WxPayApi::orderQuery($input);
                if (array_key_exists("return_code", $result)
                    && array_key_exists("result_code", $result)
                    && $result["return_code"] == "SUCCESS"
                    && $result["result_code"] == "SUCCESS"
                ) {
                    //订单号
                    $order_num = $result['attach'];
                    //商户订单号
                    $out_trade_no = $result['out_trade_no'];
                    //微信交易号
                    $trade_no = $result['transaction_id'];
                    //通知时间
                    $notify_time = $result['time_end'];
                    $total_fee = $result['total_fee'];

                    $pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'groupon', 'payment_type' => 'weixin'));
                    if ($pay_log_info && $total_fee == $pay_log_info['total_fee'] * 100) {
                        if ($pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
                            //支付记录
                            $fields = array(
                                'payment_type' => 'weixin',
                                'order_type' => 'groupon',
                                'trade_no' => $trade_no,
                                'trade_status' => 'TRADE_SUCCESS',
                                'buyer_email' => '',
                                'notify_time' => strtotime($notify_time)
                            );
                            if ($this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
                                $item_info = $this->Ptkj_record_model->get("ptkj_record.bond_number = '{$order_num}' and ptkj_record.is_bond = 0");
                                $user_info = $this->User_model->get('id, total, username', array('id' => $item_info['user_id']));
                                if ($item_info && $user_info) {
                                    //修改订单状态
                                    $fields = array(
                                        'is_bond'=> 1,
                                        'trade_no'=>$trade_no,
                                        'payment_id' => 3);
                                    if ($this->Ptkj_record_model->save($fields, array('id' => $item_info['id']))) {
                                        $this->Promotion_ptkj_model->save(array('pintuan_people'=>$item_info['pintuan_people']+1),array('id'=>$item_info['ptkj_id']));
                                        if ($item_info['max_number'] == $item_info['pintuan_people']+1){
                                            $this->Promotion_ptkj_model->save(array('is_success'=>1,'success_time'=>time()),array('id'=>$item_info['ptkj_id']));
                                        }
                                        //财务记录
                                        if (!$this->Financial_model->rowCount(array('type' => 'order_out', 'ret_id' => $item_info['id']))) {
                                            $fields = array(
                                                'cause' => "支付成功-[订单号：{$item_info['bond_number']}]",
                                                'price' => -$item_info['deposit'],
                                                'balance' => $user_info['total'],
                                                'add_time' => time(),
                                                'user_id' => $user_info['id'],
                                                'username' => $user_info['username'],
                                                'type' => 'order_out',
                                                'pay_way' => '3',
                                                'ret_id' => $item_info['id'],
                                                'from_user_id' => $user_info['id'],
                                                'seller_id'=>    $item_info['seller_id'],
                                                'store_id'=>    $item_info['store_id'],
                                            );
                                            $this->Financial_model->save($fields);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } catch (WxPayException $e) {
            $msg = $e->errorMessage();
        }
    }

    /***
     * 微信支付心跳程序
     */
    public function get_weixin_heart()
    {
        if ($_POST) {
            $out_trade_no = $this->input->post('out_trade_no');
            if (!$out_trade_no) {
                printAjaxError('fail', '参数错误');
            }
            $pay_log_info = $this->Pay_log_model->get('trade_status, order_num', array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'groupon'));
            if (!$pay_log_info) {
                printAjaxError('fail', '支付记录不存在');
            }
            if ($pay_log_info['trade_status'] != 'WAIT_BUYER_PAY'){
                $record_info = $this->Ptkj_record_model->get("ptkj_record.bond_number = {$pay_log_info['order_num']}");
                if ($record_info){
                    printAjaxData($record_info['ptkj_id']);
                }
            }
            printAjaxError('fail', '参数异常');

        }
    }

    /**
     * 生成微信支付二维码
     */
    public function get_weixin_qr() {
        $url = $_GET['url'];
        if ($url) {
            $qr = get_qrcode(urldecode($url), 8);
            header("Content-type:image/png");
            imagepng($qr);
            imagedestroy($qr);
        }
    }

    //预存款订单结算
    public function my_yue_pay(){
        checkLoginAjax();
        if ($_POST) {
            $user_id = get_cookie('user_id');
            $record_id = $this->input->post('record_id');
            $pay_password = $this->input->post('pay_password');
            if (!$pay_password) {
                printAjaxError('fail', '支付密码不能为空');
            }
            //判断下单用户是否存在
            $user_info = $this->User_model->get('*', array('user.id' => $user_id));
            if (!$user_info) {
                printAjaxError('fail', '此用户不存在，结算失败');
            }
            $item_info = $this->Ptkj_record_model->get("ptkj_record.id = '{$record_id}' and ptkj_record.user_id = {$user_id} and ptkj_record.is_bond = 0");
            if (!$item_info) {
                printAjaxError('fail', '信息不存在');
            }
            //预存款支付
            if ($item_info['deposit'] > $user_info['total']) {
                printAjaxError('fail', '预存款余额不足，请选择其它支付方式');
            }
            if (create_password_salt($user_info['username'], $user_info['add_time'], $pay_password) != $user_info['pay_password']) {
                printAjaxError('fail', '支付密码错误，请重新输入');
            }



            $ret_1 = $this->Ptkj_record_model->save(array('is_bond'=>1), array('id' => $item_info['id'], 'user_id' => $user_info['id']));
            $ret_2 = $this->Promotion_ptkj_model->save(array('pintuan_people'=>$item_info['pintuan_people']+1),array('id'=>$item_info['ptkj_id']));
            $ret_3 = $this->User_model->save(array('total' => $user_info['total'] - $item_info['deposit']), array('id' => $user_id));


            if (!($ret_1 + $ret_2 + $ret_3)) {
                $this->Ptkj_record_model->save(array('is_bond'=>0), array('id' => $item_info['id'], 'user_id' => $user_info['id']));
                printAjaxError('fail', '预存款支付失败');
            }

            if ($item_info['max_number'] == $item_info['pintuan_people']+1){
                $this->Promotion_ptkj_model->save(array('is_success'=>1,'success_time'=>time()),array('id'=>$item_info['ptkj_id']));
            }

            //财务记录还没有添加
            $fields = array(
                'cause' => "团预购定金付款成功--[订单号：{$item_info['bond_number']}]",
                'price' => -$item_info['deposit'],
                'balance' => $user_info['total'] - $item_info['deposit'],
                'add_time' => time(),
                'user_id' => $user_info['id'],
                'username' => $user_info['username'],
                'type' => 'order_out',
                'pay_way' => 1,
                'ret_id' => $item_info['id'],
                'from_user_id' => $user_info['id'],
                'seller_id'=>    $item_info['seller_id'],
                'store_id'=>    $item_info['store_id'],
            );
            $this->Financial_model->save($fields);
            printAjaxSuccess(base_url() . "index.php/groupon/detail/{$item_info['ptkj_id']}",'参团成功！');
        }
    }

    //我的团预购
    public function my_ptkj_record()
    {
        checkLogin();
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $user_id = get_cookie('user_id');
        $item_list = $this->Ptkj_record_model->gets(array('user_id'=>$user_id,'is_bond'=>1));
        if ($item_list){
            foreach ($item_list as $key=>$value){
                $product_info = $this->Product_model->get("*", array('id' => $value['product_id']));
                $item_list[$key]['product_info'] = $product_info;

                //当前价格
                if ($value['type']){
                    $item_list[$key]['pintuan_price'] = $value['sale_price'];
                }else{
                    $pintuan_rule = $this->Pintuan_model->gets("ptkj_id = {$value['ptkj_id']}");
                    $max = 0;
                    foreach ($pintuan_rule as $ls) {
                        if ($value['pintuan_people'] >= $ls['low'] && $value['pintuan_people'] <= $ls['high']) {
                            $max = $ls['money'];
                            break;
                        }else{
                            $max = max($max,$ls['money']);
                        }
                    }
                    $item_list[$key]['pintuan_price'] = $max;
                }

                //当前状态
                if ($value['end_time'] > time() && !$value['is_success']){
                    $status = '进行中';
                }else{
                    if ($value['min_number'] > $value['pintuan_people']){
                        $status = '<font color="red">活动未成功</font>';
                    }else{
                        //是否逾期
                        $success_time = $value['is_success'] ? $value['success_time'] : $value['end_time'];
                        if (strtotime('+24hours',$success_time) < time()){
                            $status = '<font class="c9">活动已结束</font>';
                        }else{
                            $order_info = $this->Orders_model->get('*',array('user_id'=>$user_id,'groupon_id'=>$value['ptkj_id'],'order_type'=>1));
                            if ($order_info){
                                if ($order_info['status'] > 0){
                                    $status = '<font color="red">参团成功</font>';
                                }else{
                                    $status = '<a href="'.base_url().'index.php/order/my_go_to_pay/'.$order_info['id'].'.html" target="_blank" class="m_btn">去支付</a>';
                                }
                            }else{
                                $status = '<a href="'.base_url().'index.php/groupon/detail/'.$value['ptkj_id'].'.html" target="_blank" class="m_btn">支付尾款</a>';
                            }
                        }
                    }
                }
                $item_list[$key]['status'] = $status;
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '我的团预购' . $systemInfo['site_name'],
            'keywords' => '我的团预购',
            'description' => '我的团预购',
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'systemInfo' => $systemInfo,
            'item_list' => $item_list,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/my_ptkj_record", $data, TRUE)
        );
        $this->load->view('layout/user_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }


    //自动退定金
    public function auto_refund_deposit()
    {
        $time = time();
        $record_list = $this->Ptkj_record_model->gets("promotion_ptkj.is_success = 0 and promotion_ptkj.end_time < {$time} and promotion_ptkj.pintuan_people < promotion_ptkj.min_number and ptkj_record.is_bond = 1 and ptkj_record.is_refund = 0");
        if ($record_list){
            foreach ($record_list as $value){
                $user_info = $this->User_model->get('id,total,username',array('id'=>$value['user_id']));
                if ($this->User_model->save(array('total'=>$user_info['total'] + $value['deposit']),array('id'=>$value['user_id']))){
                    $this->Ptkj_record_model->save(array('is_refund'=>1),array('id'=>$value['id']));
                    //财务记录
                    if (!$this->Financial_model->rowCount(array('type'=>'order_in', 'ret_id'=>$value['id']))) {
                        $fields = array(
                            'cause'=>"团预购定金退款成功-[订单号：{$value['bond_number']}]",
                            'price'=>$value['deposit'],
                            'balance'=>$user_info['total'] + $value['deposit'],
                            'add_time'=>time(),
                            'user_id'=>$user_info['id'],
                            'username'=>$user_info['username'],
                            'type' =>  'order_in',
                            'pay_way'=>$value['payment_id'],
                            'ret_id'=>$value['id'],
                            'from_user_id'=>$user_info['id'],
                            'seller_id'=>$value['seller_id'],
                            'store_id'=>$value['store_id'],
                        );
                        $this->Financial_model->save($fields);
                    }
                }
            }
        }
    }


    //获取唯一的订单号
    private function _getUniqueBondNumber() {
        //一秒钟一万件的量
        $randCode = '';
        while (true) {
            $randCode = getOrderNumber(5);
            $count1= $this->Ptkj_record_model->rowCount(array('bond_number' => $randCode));
            $count2 = $this->Orders_model->rowCount(array('order_number' => $randCode));
            $count = $count1 + $count2;
            if ($count > 0) {
                $randCode = '';
                continue;
            } else {
                break;
            }
        }
        return $randCode;
    }

}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */
