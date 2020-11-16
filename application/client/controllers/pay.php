<?php

class Pay extends CI_Controller {

    //通联支付密钥
    private $_key = 'yizhejiediancom';
    //通联支付商户号
    private $_merchantId = '109115711607012';

    public function __construct() {
        parent::__construct();
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('User_address_model', '', TRUE);
        $this->load->model('Orders_model', '', TRUE);
        $this->load->model('Orders_detail_model', '', TRUE);
        $this->load->model('Orders_process_model', '', TRUE);
        $this->load->model('Financial_model', '', TRUE);
        $this->load->model('Recharge_record_model', '', TRUE);
        $this->load->library('Securitysecoderclass');
        $this->load->library('Form_validation');
    }

    //在线充值
    public function recharge() {
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>预存款</a> > 在线充值";
        $userInfo = $this->User_model->get('total', array('id' => get_cookie('user_id')));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '在线充值' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'location' => $location,
            'userInfo' => $userInfo
        );
        $layout = array(
            'content' => $this->load->view('pay/recharge', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //网银结算(结算)
    public function buy($order_id = 0) {
        $order_id = intval($order_id);
        //判断下单用户是否存在
        $userInfo = $this->User_model->get('*', array('user.id' => get_cookie('user_id')));
        if (!$userInfo) {
            printAjaxError('fail', '此用户不存在，结算失败');
        }
        $orders_info = $this->Orders_model->get('id,total,txt_address,address,add_time,expires,buyer_name,mobile,status, order_number, payment_id', array('id' => $order_id, 'user_id' => get_cookie('user_id')));
        if (!$orders_info) {
            printAjaxError('fail', '此订单信息不存在');
        }
        if ($orders_info['status'] != 0) {
            printAjaxError('fail', '此订单操作异常');
        }
        if ($orders_info['add_time'] + $orders_info['expires'] < time()) {
            $data = array(
                'user_msg' => '此订单已过期',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        //支付金额
        $total = $orders_info['total'];
        //页面编码要与参数inputCharset一致，否则服务器收到参数值中的汉字为乱码而导致验证签名失败。	
        $serverUrl = 'http://service.allinpay.com/gateway/index.do';
        $inputCharset = '1';
        $pickupUrl = base_url() . 'index.php/pay/pay_result';
        $receiveUrl = base_url() . 'index.php/pay/pay_notify';
        $version = 'v1.0';
        $signType = '0';
        $merchantId = $this->_merchantId; //商户号
        $orderNo = $orders_info['order_number'];
        $orderAmount = intval($total * 100);
        $orderDatetime = date('YmdHis');
        $payType = '0'; //payType 不能为空，必须放在表单中提交。
        $tradeNature = 'GOODS';
        $key = $this->_key;
        $bufSignSrc = "inputCharset=$inputCharset&pickupUrl=$pickupUrl&receiveUrl=$receiveUrl&version=$version&signType=$signType&merchantId=$merchantId&orderNo=$orderNo&orderAmount=$orderAmount&orderDatetime=$orderDatetime&payType=$payType&tradeNature=$tradeNature&key=$key";
        $signMsg = strtoupper(md5($bufSignSrc));
        $data = array(
            'serverUrl' => $serverUrl,
            'inputCharset' => $inputCharset,
            'pickupUrl' => $pickupUrl,
            'receiveUrl' => $receiveUrl,
            'version' => $version,
            'signType' => $signType,
            'merchantId' => $merchantId,
            'orderNo' => $orderNo,
            'orderAmount' => $orderAmount,
            'orderDatetime' => $orderDatetime,
            'payType' => $payType,
            'tradeNature' => $tradeNature,
            'signMsg' => $signMsg,
        );
        $this->load->view('pay/ebank', $data);
    }

    //微信结算(结算)
    public function wechat_buy($order_id = '0') {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $order_id = intval($order_id);
        //判断下单用户是否存在
        $userInfo = $this->User_model->get('*', array('user.id' => get_cookie('user_id')));
        if (!$userInfo) {
            printAjaxError('fail', '此用户不存在，结算失败');
        }
        $orders_info = $this->Orders_model->get('id,total,txt_address,add_time,expires,address,buyer_name,mobile,status, order_number, payment_id', array('id' => $order_id, 'user_id' => get_cookie('user_id')));
        if (!$orders_info) {
            printAjaxError('fail', '此订单信息不存在');
        }
        if ($orders_info['status'] != 0) {
            printAjaxError('fail', '此订单操作异常');
        }
        if ($orders_info['add_time'] + $orders_info['expires'] < time()) {
            $data = array(
                'user_msg' => '此订单已过期',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        //支付金额
        $total = $orders_info['total'];
        require_once (APPPATH . 'libraries/wxpay/log.php');
        //初始化日志
        $logHandler = new CLogFileHandler(APPPATH . "logs/" . date('Y-m-d') . '.log');
        Log::Init($logHandler, 15);
        // 调用微信扫码支付接口配置信息  
        $this->load->config('wxpay_config');

        $wxconfig['appid'] = $this->config->item('appid');
        $wxconfig['mch_id'] = $this->config->item('mch_id');
        $wxconfig['apikey'] = $this->config->item('apikey');
        $wxconfig['appsecret'] = $this->config->item('appsecret');
        $wxconfig['sslcertPath'] = $this->config->item('sslcertPath');
        $wxconfig['sslkeyPath'] = $this->config->item('sslkeyPath');
        //由于此类库构造函数需要传参，我们初始化类库就传参数给他吧  
        $this->load->library('Wechatpay', $wxconfig);

        $param['body'] = '商品购买'; //"商品名称（自行看文档具体填什么）";  
        $param['attach'] = ''; // "我有个参数要传我就穿了个id过来，这里不要有空格避免出错";  
        $param['detail'] = '';  //"我填了商品名称加订单号";  
        $param['out_trade_no'] = $orders_info['order_number']; //"商户订单号";  
        $param['total_fee'] = intval($total * 100); //"金额，记得乘以100，微信支付单位默认分";//如$total_fee*100  
        $param["spbill_create_ip"] = $_SERVER['REMOTE_ADDR']; //客户端IP地址  
        $param["time_start"] = date("YmdHis"); //请求开始时间  
        $param["time_expire"] = date("YmdHis", time() + 600); //请求超时时间 10分钟  
        $param["goods_tag"] = ''; //商品标签，自行填写  
        $param["notify_url"] = base_url() . 'index.php/pay/wechat_buy_notify'; //自行定义异步通知url  
        $param["trade_type"] = "NATIVE"; //扫码支付模式二  
        $param["product_id"] = '12'; //正好有产品id就传了个，看文档说自己定义  
        //调用统一下单API接口  
        $result = $this->wechatpay->unifiedOrder($param); //这里可以加日志输出，
        //成功（return_code和result_code都为SUCCESS）就会返回含有带支付二维码链接的数据  
        $data = array();
        if (isset($result["code_url"]) && !empty($result["code_url"])) {//二维码图片链接  
            $data = array(
                'site_name' => $systemInfo['site_name'],
                'index_name' => $systemInfo['index_name'],
                'index_url' => $systemInfo['index_url'],
                'client_index' => $systemInfo['client_index'],
                'title' => '会员中心' . $systemInfo['site_name'],
                'keywords' => $systemInfo['site_keycode'],
                'description' => $systemInfo['site_description'],
                'site_copyright' => $systemInfo['site_copyright'],
                'icp_code' => $systemInfo['icp_code'],
                'html' => $systemInfo['html'],
                'wxurl' => $result["code_url"],
                'orderno' => $param['out_trade_no'],
                'time_expire' => strtotime($param["time_expire"]),
                'money' => $total,
            );
            $layout = array(
                'content' => $this->load->view("pay/weixin", $data, TRUE)
            );
            $this->load->view('layout/user_default', $layout);
        } else {
            // 失败写入日志  
            log::debug(json_encode($result));
        }
    }
   /*
    * 发起支付宝付款
    */
    public function alipay_buy($order_id=0){
        $order_id = intval($order_id);
        //判断下单用户是否存在
        $userInfo = $this->User_model->get('*', array('user.id' => get_cookie('user_id')));
        if (!$userInfo) {
            printAjaxError('fail', '此用户不存在，结算失败');
        }
        $orders_info = $this->Orders_model->get('id,total,txt_address,add_time,expires,address,buyer_name,mobile,status, order_number, payment_id', array('id' => $order_id, 'user_id' => get_cookie('user_id')));
        if (!$orders_info) {
            printAjaxError('fail', '此订单信息不存在');
        }
        if ($orders_info['status'] != 0) {
            printAjaxError('fail', '此订单操作异常');
        }
        if ($orders_info['add_time'] + $orders_info['expires'] < time()) {
            $data = array(
                'user_msg' => '此订单已过期',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
            require_once("sdk/alipay/alipay.config.php");
            require_once("sdk/alipay/lib/alipay_submit.class.php");
            /*             * ************************请求参数************************* */
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $orders_info['order_number'];

            //订单名称，必填
            $subject = '一折街付款';

            //付款金额，必填
            $total_fee = $orders_info['total'];

            //商品描述，可空
            $body = '';
            /*       * ********************************************************* */
            //构造要请求的参数数组，无需改动
            $parameter = array(
                "service" => $alipay_config['service'],
                "partner" => $alipay_config['partner'],
                "seller_id" => $alipay_config['seller_id'],
                "payment_type" => $alipay_config['payment_type'],
                "notify_url" => base_url().'index.php/pay/alipay_buy_notify',
                "return_url" => base_url().'index.php/order/result',
                "anti_phishing_key" => $alipay_config['anti_phishing_key'],
                "exter_invoke_ip" => $alipay_config['exter_invoke_ip'],
                "out_trade_no" => $out_trade_no,
                "subject" => $subject,
                "total_fee" => $total_fee,
                "body" => $body,
                "_input_charset" => trim(strtolower($alipay_config['input_charset']))
            );
            //建立请求
            $alipaySubmit = new AlipaySubmit($alipay_config);
            $html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
            echo $html_text;
    }
    
    //
    
    //网银支付结算结果通知(结算)
    public function pay_result() {
        if ($_POST) {
            $orderNo = $this->input->post('orderNo', true);
            $orders_info = $this->Orders_model->get('*', array('order_number' => $orderNo));
            if (empty($orders_info)) {
                printAjaxError('fail', '无此订单');
            }
            if ($orders_info['status'] == 1) {
                $data = array(
                    'user_msg' => '支付成功',
                    'user_url' => 'index.php/user/index.html'
                );
                $this->session->set_userdata($data);
                redirect('/message/index');
            } else {
                $data = array(
                    'user_msg' => '支付失败',
                    'user_url' => 'index.php/user/index.html'
                );
                $this->session->set_userdata($data);
                redirect('/message/index');
            }
        }
    }

    //网银支付结算后台通知(结算)
    public function pay_notify() {
        if ($_POST) {
            $md5key = $this->_key;
            $merchantId = $this->input->post('merchantId', true);
            $version = $this->input->post('version', true);
            $language = $this->input->post('language', true);
            $signType = $this->input->post('signType', true);
            $payType = $this->input->post('payType', true);
            $issuerId = $this->input->post('issuerId', true);
            $paymentOrderId = $this->input->post('paymentOrderId', true);
            $orderNo = $this->input->post('orderNo', true);
            $orderDatetime = $this->input->post('orderDatetime', true);
            $orderAmount = $this->input->post('orderAmount', true);
            $payDatetime = $this->input->post('payDatetime', true);
            $payAmount = $this->input->post('payAmount', true);
            $ext1 = $this->input->post('ext1', true);
            $ext2 = $this->input->post('ext2', true);
            $payResult = $this->input->post('payResult', true);
            $errorCode = $this->input->post('errorCode', true);
            $returnDatetime = $this->input->post('returnDatetime', true);
            $signMsg = $this->input->post('signMsg', true);
            $bufSignSrc = "";
            if ($merchantId != "")
                $bufSignSrc = $bufSignSrc . "merchantId=" . $merchantId . "&";
            if ($version != "")
                $bufSignSrc = $bufSignSrc . "version=" . $version . "&";
            if ($language != "")
                $bufSignSrc = $bufSignSrc . "language=" . $language . "&";
            if ($signType != "")
                $bufSignSrc = $bufSignSrc . "signType=" . $signType . "&";
            if ($payType != "")
                $bufSignSrc = $bufSignSrc . "payType=" . $payType . "&";
            if ($issuerId != "")
                $bufSignSrc = $bufSignSrc . "issuerId=" . $issuerId . "&";
            if ($paymentOrderId != "")
                $bufSignSrc = $bufSignSrc . "paymentOrderId=" . $paymentOrderId . "&";
            if ($orderNo != "")
                $bufSignSrc = $bufSignSrc . "orderNo=" . $orderNo . "&";
            if ($orderDatetime != "")
                $bufSignSrc = $bufSignSrc . "orderDatetime=" . $orderDatetime . "&";
            if ($orderAmount != "")
                $bufSignSrc = $bufSignSrc . "orderAmount=" . $orderAmount . "&";
            if ($payDatetime != "")
                $bufSignSrc = $bufSignSrc . "payDatetime=" . $payDatetime . "&";
            if ($payAmount != "")
                $bufSignSrc = $bufSignSrc . "payAmount=" . $payAmount . "&";
            if ($ext1 != "")
                $bufSignSrc = $bufSignSrc . "ext1=" . $ext1 . "&";
            if ($ext2 != "")
                $bufSignSrc = $bufSignSrc . "ext2=" . $ext2 . "&";
            if ($payResult != "")
                $bufSignSrc = $bufSignSrc . "payResult=" . $payResult . "&";
            if ($errorCode != "")
                $bufSignSrc = $bufSignSrc . "errorCode=" . $errorCode . "&";
            if ($returnDatetime != "")
                $bufSignSrc = $bufSignSrc . "returnDatetime=" . $returnDatetime;
            //验签
            if ($signType == '0') {
                if ($signMsg == strtoupper(md5($bufSignSrc . "&key=" . $md5key))) {
                    if ($payResult == 1) {
                        $orders_info = $this->Orders_model->get('total,status,order_number,user_id,id', array('order_number' => $orderNo));
                        if ($orders_info['status'] == 1) {
                            printAjaxError('fail', '此订单已支付');
                        }
                        $userInfo = $this->User_model->get('username,id,total', array('id' => $orders_info['user_id']));
                        if ($orderAmount < $orders_info['total'] * 100) {
                            printAjaxError('fail', '您支付的金额有误');
                        }
                        //付款成功，修改订单状态
                        $this->Orders_model->save(array('status' => 1, 'payment_title' => '网银支付', 'payment_id' => 4), array('order_number' => $orderNo));
                        //付款成功减少相应库存
                        $orders_detail = $this->Orders_detail_model->gets('*', array('order_id' => $orders_info['id']));
                        foreach ($orders_detail as $item) {
                            $stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
                            $this->Product_model->changeStock(array('stock' => $stock_info['stock'] - $item['buy_number']), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
                        }
                        //财务记录还没有添加
                        $fFields = array(
                            'cause' => "订单付款成功--[订单号：{$orders_info['order_number']}]",
                            'price' => -$orders_info['total'],
                            'balance' => $userInfo['total'],
                            'add_time' => time(),
                            'user_id' => $orders_info['user_id'],
                            'username' => $userInfo['username'],
                            'type' => 'order_out',
                            'pay_way' => 4
                        );
                        $this->Financial_model->save($fFields);
                        //添加跟踪记录
                        $ordersprocessFields2 = array(
                            'add_time' => time(),
                            'content' => "订单付款成功",
                            'order_id' => $orders_info['user_id']
                        );
                        $this->Orders_process_model->save($ordersprocessFields2);
                    } else {
                        $pay_Result_0 = "订单支付失败！";
                    }
                } else {
                    $verify_Result_0 = "报文验签失败!";
                }
            }
        }
    }

//微信支付结算后台通知（结算）
    public function wechat_buy_notify() {
        require_once (APPPATH . 'libraries/wxpay/log.php');
        //$postStr = file_get_contents("php://input");//因为很多都设置了register_globals禁止,不能用$GLOBALS["HTTP_RAW_POST_DATA']　　　　 //这部分困扰了好久用上面这种一直接受不到数据，或者接受了解析不正确，最终用下面的正常了，有哪位愿意指点的可以告知一二
        //$xml = $GLOBALS['HTTP_RAW_POST_DATA']; //这个需要开启;always_populate_raw_post_data = On
        $this->load->config('wxpay_config');
        $wxconfig['appid'] = $this->config->item('appid');
        $wxconfig['mch_id'] = $this->config->item('mch_id');
        $wxconfig['apikey'] = $this->config->item('apikey');
        $wxconfig['appsecret'] = $this->config->item('appsecret');
        $wxconfig['sslcertPath'] = $this->config->item('sslcertPath');
        $wxconfig['sslkeyPath'] = $this->config->item('sslkeyPath');
        $this->load->library('Wechatpay', $wxconfig);
        libxml_disable_entity_loader(true);
        $array = $this->wechatpay->get_back_data();
        if ($array != null) {
            $orders_info = $this->Orders_model->get('total,status,order_number,user_id,id', array('order_number' => $array['out_trade_no']));
            if ($orders_info['status'] == 1) {
                echo 'success';
            }
            $userInfo = $this->User_model->get('username,id,total', array('id' => $orders_info['user_id']));
                        if ($array['total_fee'] < $orders_info['total'] * 100) {
                            echo 'fail';
                        }
            //付款成功减少相应库存
            $orders_detail = $this->Orders_detail_model->gets('*', array('order_id' => $orders_info['id']));
            foreach ($orders_detail as $item) {
                $stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
                $this->Product_model->changeStock(array('stock' => $stock_info['stock'] - $item['buy_number']), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
            }
            //付款成功，修改订单状态
            $this->Orders_model->save(array('status' => 1, 'payment_title' => '微信支付', 'payment_id' => 3), array('order_number' => $array['out_trade_no']));
            //财务记录还没有添加
            $fFields = array(
                'cause' => "订单付款成功--[订单号：{$orders_info['order_number']}]",
                'price' => -$orders_info['total'],
                'balance' => $userInfo['total'],
                'add_time' => time(),
                'user_id' => $orders_info['user_id'],
                'username' => $userInfo['username'],
                'type' => 'order_out',
                'pay_way' => 3
            );
            $this->Financial_model->save($fFields);
            //添加跟踪记录
            $ordersprocessFields2 = array(
                'add_time' => time(),
                'content' => "订单付款成功",
                'order_id' => $orders_info['user_id']
            );
            $this->Orders_process_model->save($ordersprocessFields2);
        }
    }
    public function alipay_buy_notify(){
        require_once("sdk/alipay/alipay.config.php");
        require_once("sdk/alipay/lib/alipay_notify.class.php");
        $alipay_config['notify_url'] = base_url().'index.php/pay/alipay_buy_notify';
        $alipay_config['return_url'] = base_url().'index.php/order/result';
        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        if ($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            //交易金额
            $total_fee = $_POST['total_fee'];
            if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
              $orders_info = $this->Orders_model->get('total,status,order_number,user_id,id', array('order_number' => $out_trade_no));
            if ($orders_info['status'] == 1) {
                echo 'success';
            }
            $userInfo = $this->User_model->get('username,id,total', array('id' => $orders_info['user_id']));
                        if ($total_fee < $orders_info['total']) {
                            echo 'fail';
                        }
            //付款成功减少相应库存
            $orders_detail = $this->Orders_detail_model->gets('*', array('order_id' => $orders_info['id']));
            foreach ($orders_detail as $item) {
                $stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
                $this->Product_model->changeStock(array('stock' => $stock_info['stock'] - $item['buy_number']), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
            }
            //付款成功，修改订单状态
            $this->Orders_model->save(array('status' => 1, 'payment_title' => '支付宝支付', 'payment_id' => 2), array('order_number' => $out_trade_no));
            //财务记录还没有添加
            $fFields = array(
                'cause' => "订单付款成功--[订单号：{$orders_info['order_number']}]",
                'price' => -$orders_info['total'],
                'balance' => $userInfo['total'],
                'add_time' => time(),
                'user_id' => $orders_info['user_id'],
                'username' => $userInfo['username'],
                'type' => 'order_out',
                'pay_way' => 3
            );
            $this->Financial_model->save($fFields);
            //添加跟踪记录
            $ordersprocessFields2 = array(
                'add_time' => time(),
                'content' => "订单付款成功",
                'order_id' => $orders_info['user_id']
            );
            $this->Orders_process_model->save($ordersprocessFields2);
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";  //请不要修改或删除
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            echo "fail";
            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }

    //网银支付(充值)
    public function ebank() {
        checkLogin();
        if ($_POST) {
            $money = $this->input->post('money', true);
            if (!preg_match("/^\d+(\.\d+)?$/", $money)) {
                printAjaxError('fail', '金钱格式有误');
            }
            $userInfo = $this->User_model->get('total', array('id' => get_cookie('user_id')));
            if (empty($userInfo)) {
                printAjaxError('fail', '此用户不存在');
            }
            $order_number = $this->_getUniqueOrderNumber();
            $fields_data = array(
                'user_id' => get_cookie('user_id'),
                'order_number' => $order_number,
                'add_time' => time(),
                'status ' => 0,
                'money ' => $money,
                'balance ' => $userInfo['total'],
            );
            if (!$this->Recharge_record_model->save($fields_data)) {
                printAjaxError('fail', '充值失败');
            }
            //页面编码要与参数inputCharset一致，否则服务器收到参数值中的汉字为乱码而导致验证签名失败。	
            $serverUrl = 'http://service.allinpay.com/gateway/index.do';
            $inputCharset = '1';
            $pickupUrl = base_url() . 'index.php/pay/recharge_result';
            $receiveUrl = base_url() . 'index.php/pay/recharge_notify';
            $version = 'v1.0';
            $signType = '0';
            $merchantId = $this->_merchantId; //商户号
            $orderNo = $order_number;
            $orderAmount = intval($money * 100);
            $orderDatetime = date('YmdHis');
            $payType = '0'; //payType 不能为空，必须放在表单中提交。
            $tradeNature = 'GOODS';
            $key = $this->_key;
            $bufSignSrc = "inputCharset=$inputCharset&pickupUrl=$pickupUrl&receiveUrl=$receiveUrl&version=$version&signType=$signType&merchantId=$merchantId&orderNo=$orderNo&orderAmount=$orderAmount&orderDatetime=$orderDatetime&payType=$payType&tradeNature=$tradeNature&key=$key";
            $signMsg = strtoupper(md5($bufSignSrc));
            $data = array(
                'serverUrl' => $serverUrl,
                'inputCharset' => $inputCharset,
                'pickupUrl' => $pickupUrl,
                'receiveUrl' => $receiveUrl,
                'version' => $version,
                'signType' => $signType,
                'merchantId' => $merchantId,
                'orderNo' => $orderNo,
                'orderAmount' => $orderAmount,
                'orderDatetime' => $orderDatetime,
                'payType' => $payType,
                'tradeNature' => $tradeNature,
                'signMsg' => $signMsg,
            );
            $this->load->view('pay/ebank', $data);
        }
    }

    //微信支付(充值)
    public function weixin() {
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        if ($_POST) {
            $money = $this->input->post('money', true);
            if (!preg_match("/^\d+(\.\d+)?$/", $money)) {
                printAjaxError('fail', '金钱格式有误');
            }
            $userInfo = $this->User_model->get('total', array('id' => get_cookie('user_id')));
            if (empty($userInfo)) {
                printAjaxError('fail', '此用户不存在');
            }
            $order_number = $this->_getUniqueOrderNumber();
            $fields_data = array(
                'user_id' => get_cookie('user_id'),
                'order_number' => $order_number,
                'add_time' => time(),
                'status ' => 0,
                'money ' => $money,
                'balance ' => $userInfo['total'],
            );
            if (!$this->Recharge_record_model->save($fields_data)) {
                printAjaxError('fail', '充值失败');
            }
            require_once (APPPATH . 'libraries/wxpay/log.php');
            //初始化日志
            $logHandler = new CLogFileHandler(APPPATH . "logs/" . date('Y-m-d') . '.log');
            Log::Init($logHandler, 15);
            // 调用微信扫码支付接口配置信息  
            $this->load->config('wxpay_config');

            $wxconfig['appid'] = $this->config->item('appid');
            $wxconfig['mch_id'] = $this->config->item('mch_id');
            $wxconfig['apikey'] = $this->config->item('apikey');
            $wxconfig['appsecret'] = $this->config->item('appsecret');
            $wxconfig['sslcertPath'] = $this->config->item('sslcertPath');
            $wxconfig['sslkeyPath'] = $this->config->item('sslkeyPath');
            //由于此类库构造函数需要传参，我们初始化类库就传参数给他吧  
            $this->load->library('Wechatpay', $wxconfig);

            $param['body'] = '充值金额￥' . $money; //"商品名称（自行看文档具体填什么）";  
            $param['attach'] = ''; // "我有个参数要传我就穿了个id过来，这里不要有空格避免出错";  
            $param['detail'] = '充值金额￥' . $money;  //"我填了商品名称加订单号";  
            $param['out_trade_no'] = $order_number; //"商户订单号";  
            $param['total_fee'] = intval($money * 100); //"金额，记得乘以100，微信支付单位默认分";//如$total_fee*100  
            $param["spbill_create_ip"] = $_SERVER['REMOTE_ADDR']; //客户端IP地址  
            $param["time_start"] = date("YmdHis"); //请求开始时间  
            $param["time_expire"] = date("YmdHis", time() + 600); //请求超时时间 10分钟  
            $param["goods_tag"] = ''; //商品标签，自行填写  
            $param["notify_url"] = base_url() . 'index.php/pay/wxnotify'; //自行定义异步通知url  
            $param["trade_type"] = "NATIVE"; //扫码支付模式二  
            $param["product_id"] = '12'; //正好有产品id就传了个，看文档说自己定义  
            //调用统一下单API接口  
            $result = $this->wechatpay->unifiedOrder($param); //这里可以加日志输出，
            // 写入日志  
            //log::debug(json_encode($result));
            //成功（return_code和result_code都为SUCCESS）就会返回含有带支付二维码链接的数据  
            $data = array();
            if (isset($result["code_url"]) && !empty($result["code_url"])) {//二维码图片链接  
                $data = array(
                    'site_name' => $systemInfo['site_name'],
                    'index_name' => $systemInfo['index_name'],
                    'index_url' => $systemInfo['index_url'],
                    'client_index' => $systemInfo['client_index'],
                    'title' => '会员中心' . $systemInfo['site_name'],
                    'keywords' => $systemInfo['site_keycode'],
                    'description' => $systemInfo['site_description'],
                    'site_copyright' => $systemInfo['site_copyright'],
                    'icp_code' => $systemInfo['icp_code'],
                    'html' => $systemInfo['html'],
                    'wxurl' => $result["code_url"],
                    'orderno' => $param['out_trade_no'],
                    'time_expire' => strtotime($param["time_expire"]),
                    'money' => $money,
                );
                $layout = array(
                    'content' => $this->load->view("pay/weixin", $data, TRUE)
                );
                $this->load->view('layout/user_default', $layout);
            } else {
                // 失败写入日志  
                log::debug(json_encode($result));
            }
        }
    }
    //支付宝充值
    public function alipay() {
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        if ($_POST) {
            $money = $this->input->post('money', true);
            if (!preg_match("/^\d+(\.\d+)?$/", $money)) {
                printAjaxError('fail', '金钱格式有误');
            }
            $userInfo = $this->User_model->get('total', array('id' => get_cookie('user_id')));
            if (empty($userInfo)) {
                printAjaxError('fail', '此用户不存在');
            }
            $order_number = $this->_getUniqueOrderNumber();
            $fields_data = array(
                'user_id' => get_cookie('user_id'),
                'order_number' => $order_number,
                'add_time' => time(),
                'status ' => 0,
                'money ' => $money,
                'balance ' => $userInfo['total'],
            );
            if (!$this->Recharge_record_model->save($fields_data)) {
                printAjaxError('fail', '充值失败');
            }
            require_once("sdk/alipay/alipay.config.php");
            require_once("sdk/alipay/lib/alipay_submit.class.php");
            /*             * ************************请求参数************************* */
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $order_number;

            //订单名称，必填
            $subject = '一折街充值';

            //付款金额，必填
            $total_fee = $money;

            //商品描述，可空
            $body = '';
            /*             * ********************************************************* */
            //构造要请求的参数数组，无需改动
            $parameter = array(
                "service" => $alipay_config['service'],
                "partner" => $alipay_config['partner'],
                "seller_id" => $alipay_config['seller_id'],
                "payment_type" => $alipay_config['payment_type'],
                "notify_url" => $alipay_config['notify_url'],
                "return_url" => $alipay_config['return_url'],
                "anti_phishing_key" => $alipay_config['anti_phishing_key'],
                "exter_invoke_ip" => $alipay_config['exter_invoke_ip'],
                "out_trade_no" => $out_trade_no,
                "subject" => $subject,
                "total_fee" => $total_fee,
                "body" => $body,
                "_input_charset" => trim(strtolower($alipay_config['input_charset']))
            );
            //建立请求
            $alipaySubmit = new AlipaySubmit($alipay_config);
            $html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
            echo $html_text;
        }
    }

    //微信支付异步通知(充值)
    function wxnotify() {
        require_once (APPPATH . 'libraries/wxpay/log.php');
        //$postStr = file_get_contents("php://input");//因为很多都设置了register_globals禁止,不能用$GLOBALS["HTTP_RAW_POST_DATA']　　　　 //这部分困扰了好久用上面这种一直接受不到数据，或者接受了解析不正确，最终用下面的正常了，有哪位愿意指点的可以告知一二
        //$xml = $GLOBALS['HTTP_RAW_POST_DATA']; //这个需要开启;always_populate_raw_post_data = On
        $this->load->config('wxpay_config');
        $wxconfig['appid'] = $this->config->item('appid');
        $wxconfig['mch_id'] = $this->config->item('mch_id');
        $wxconfig['apikey'] = $this->config->item('apikey');
        $wxconfig['appsecret'] = $this->config->item('appsecret');
        $wxconfig['sslcertPath'] = $this->config->item('sslcertPath');
        $wxconfig['sslkeyPath'] = $this->config->item('sslkeyPath');
        $this->load->library('Wechatpay', $wxconfig);
        libxml_disable_entity_loader(true);
        $array = $this->wechatpay->get_back_data();
        if ($array != null) {
            $recharge_record = $this->Recharge_record_model->get('*', array('order_number' => $array['out_trade_no']));
            if ($recharge_record['status'] == 1) {
                printAjaxError('fail', '此充值订单已成功支付');
            }
            $userInfo = $this->User_model->get('total,username', array('id' => $recharge_record['user_id']));
            $this->Recharge_record_model->save(array('status' => 1, 'pay_type' => '微信支付'), array('id' => $recharge_record['id']));
            $this->User_model->save(array('total' => $userInfo['total'] + ($array['total_fee'] / 100)), array('id' => $recharge_record['user_id']));
            //添加财务记录
            $fields = array(
                'cause' => '充值成功--' . $array['out_trade_no'],
                'price' => $array['total_fee'] / 100,
                'balance' => $userInfo['total'] + ($array['total_fee'] / 100),
                'add_time' => time(),
                'username' => $userInfo['username'],
                'user_id' => $recharge_record['user_id'],
                'type' => 'recharge_in',
                'pay_way' => 3,
            );
            $this->Financial_model->save($fields);
        }
    }

    //支付宝充值异步通知
    public function alipay_recharge_notify() {
        require_once("sdk/alipay/alipay.config.php");
        require_once("sdk/alipay/lib/alipay_notify.class.php");
        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        if ($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            //交易金额
            $total_fee = $_POST['total_fee'];
            if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                $recharge_record = $this->Recharge_record_model->get('*', array('order_number' => $out_trade_no));
                if ($recharge_record['status'] == 1) {
                    echo 'success';
                }
                $userInfo = $this->User_model->get('total,username', array('id' => $recharge_record['user_id']));
                $this->Recharge_record_model->save(array('status' => 1, 'pay_type' => '支付宝支付'), array('id' => $recharge_record['id']));
                $this->User_model->save(array('total' => $userInfo['total'] + $total_fee), array('id' => $recharge_record['user_id']));
                //添加财务记录
                $fields = array(
                    'cause' => '充值成功--' . $out_trade_no,
                    'price' => $total_fee,
                    'balance' => $userInfo['total'] + $total_fee,
                    'add_time' => time(),
                    'username' => $userInfo['username'],
                    'user_id' => $recharge_record['user_id'],
                    'type' => 'recharge_in',
                    'pay_way' => 2,
                );
                $this->Financial_model->save($fields);
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";  //请不要修改或删除
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            echo "fail";
            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }

    //支付宝 充值成功后页面通知
    public function alipay_result() {
        if ($_GET) {
            $orderNo = $this->input->get('out_trade_no', true);
            $recharge_record = $this->Recharge_record_model->get('*', array('order_number' => $orderNo));
            if (empty($recharge_record)) {
                printAjaxError('fail', '无此订单');
            }
            if ($recharge_record['status'] == 1) {
                $data = array(
                    'user_msg' => '成功充值' . $recharge_record['money'] . '元',
                    'user_url' => 'index.php/user/index.html'
                );
                $this->session->set_userdata($data);
                redirect('/message/index');
            } else {
                $data = array(
                    'user_msg' => '充值失败',
                    'user_url' => 'index.php/user/index.html'
                );
                $this->session->set_userdata($data);
                redirect('/message/index');
            }
        }
    }

    //订单状态查询（采用轮询方式）;
    public function queryorder() {
        $this->load->config('wxpay_config');
        $wxconfig['appid'] = $this->config->item('appid');
        $wxconfig['mch_id'] = $this->config->item('mch_id');
        $wxconfig['apikey'] = $this->config->item('apikey');
        $wxconfig['appsecret'] = $this->config->item('appsecret');
        $wxconfig['sslcertPath'] = $this->config->item('sslcertPath');
        $wxconfig['sslkeyPath'] = $this->config->item('sslkeyPath');
        $this->load->library('Wechatpay', $wxconfig);
        $out_trade_no = $this->input->post('orderno', true); //调用查询订单API接口
        $array = $this->wechatpay->orderQuery('', $out_trade_no);
        echo json_encode($array);
    }

    //网银 充值成功后后台通知(充值)
    public function recharge_notify() {
        if ($_POST) {
            //测试商户的key! 请修改。
            $md5key = $this->_key;
            $merchantId = $this->input->post('merchantId', true);
            $version = $this->input->post('version', true);
            $language = $this->input->post('language', true);
            $signType = $this->input->post('signType', true);
            $payType = $this->input->post('payType', true);
            $issuerId = $this->input->post('issuerId', true);
            $paymentOrderId = $this->input->post('paymentOrderId', true);
            $orderNo = $this->input->post('orderNo', true);
            $orderDatetime = $this->input->post('orderDatetime', true);
            $orderAmount = $this->input->post('orderAmount', true);
            $payDatetime = $this->input->post('payDatetime', true);
            $payAmount = $this->input->post('payAmount', true);
            $ext1 = $this->input->post('ext1', true);
            $ext2 = $this->input->post('ext2', true);
            $payResult = $this->input->post('payResult', true);
            $errorCode = $this->input->post('errorCode', true);
            $returnDatetime = $this->input->post('returnDatetime', true);
            $signMsg = $this->input->post('signMsg', true);
            $bufSignSrc = "";
            if ($merchantId != "")
                $bufSignSrc = $bufSignSrc . "merchantId=" . $merchantId . "&";
            if ($version != "")
                $bufSignSrc = $bufSignSrc . "version=" . $version . "&";
            if ($language != "")
                $bufSignSrc = $bufSignSrc . "language=" . $language . "&";
            if ($signType != "")
                $bufSignSrc = $bufSignSrc . "signType=" . $signType . "&";
            if ($payType != "")
                $bufSignSrc = $bufSignSrc . "payType=" . $payType . "&";
            if ($issuerId != "")
                $bufSignSrc = $bufSignSrc . "issuerId=" . $issuerId . "&";
            if ($paymentOrderId != "")
                $bufSignSrc = $bufSignSrc . "paymentOrderId=" . $paymentOrderId . "&";
            if ($orderNo != "")
                $bufSignSrc = $bufSignSrc . "orderNo=" . $orderNo . "&";
            if ($orderDatetime != "")
                $bufSignSrc = $bufSignSrc . "orderDatetime=" . $orderDatetime . "&";
            if ($orderAmount != "")
                $bufSignSrc = $bufSignSrc . "orderAmount=" . $orderAmount . "&";
            if ($payDatetime != "")
                $bufSignSrc = $bufSignSrc . "payDatetime=" . $payDatetime . "&";
            if ($payAmount != "")
                $bufSignSrc = $bufSignSrc . "payAmount=" . $payAmount . "&";
            if ($ext1 != "")
                $bufSignSrc = $bufSignSrc . "ext1=" . $ext1 . "&";
            if ($ext2 != "")
                $bufSignSrc = $bufSignSrc . "ext2=" . $ext2 . "&";
            if ($payResult != "")
                $bufSignSrc = $bufSignSrc . "payResult=" . $payResult . "&";
            if ($errorCode != "")
                $bufSignSrc = $bufSignSrc . "errorCode=" . $errorCode . "&";
            if ($returnDatetime != "")
                $bufSignSrc = $bufSignSrc . "returnDatetime=" . $returnDatetime;
            //验签
            if ($signType == '0') {
                if ($signMsg == strtoupper(md5($bufSignSrc . "&key=" . $md5key))) {
                    if ($payResult == 1) {
                        $pay_Result_0 = "订单支付成功！";
                        $recharge_record = $this->Recharge_record_model->get('*', array('order_number' => $orderNo));
                        if ($recharge_record['status'] == 1) {
                            printAjaxError('fail', '此充值订单已成功支付');
                        }
                        $userInfo = $this->User_model->get('total,username', array('id' => $recharge_record['user_id']));
                        $this->Recharge_record_model->save(array('status' => 1, 'pay_type' => '网银支付'), array('id' => $recharge_record['id']));
                        $this->User_model->save(array('total' => $userInfo['total'] + ($orderAmount / 100)), array('id' => $recharge_record['user_id']));
                        //添加财务记录
                        $fields = array(
                            'cause' => '充值成功--' . $orderNo,
                            'price' => $orderAmount / 100,
                            'balance' => $userInfo['total'] + ($orderAmount / 100),
                            'add_time' => time(),
                            'username' => $userInfo['username'],
                            'user_id' => $recharge_record['user_id'],
                            'type' => 'recharge_in',
                            'pay_way' => 4,
                        );
                        $this->Financial_model->save($fields);
                    } else {
                        $pay_Result_0 = "订单支付失败！";
                    }
                } else {
                    $verify_Result_0 = "报文验签失败!";
                }
            }
        }
    }

    //网银 充值成功后页面通知
    public function recharge_result() {
        if ($_POST) {
            $orderNo = $this->input->post('orderNo', true);
            $recharge_record = $this->Recharge_record_model->get('*', array('order_number' => $orderNo));
            if (empty($recharge_record)) {
                printAjaxError('fail', '无此订单');
            }
            if ($recharge_record['status'] == 1) {
                $data = array(
                    'user_msg' => '成功充值' . $recharge_record['money'] . '元',
                    'user_url' => 'index.php/user/index.html'
                );
                $this->session->set_userdata($data);
                redirect('/message/index');
            } else {
                $data = array(
                    'user_msg' => '充值失败',
                    'user_url' => 'index.php/user/index.html'
                );
                $this->session->set_userdata($data);
                redirect('/message/index');
            }
        }
    }

    //二维码调用
    function qrcode() {
        require_once(APPPATH . 'libraries/wxpay/phpqrcode/phpqrcode.php');
        $url = urldecode($_GET["data"]);
        QRcode::png($url);
    }

    //获取唯一的充值订单号
    private function _getUniqueOrderNumber() {
        //一秒钟一万件的量
        $randCode = '';
        while (true) {
            $randCode = getOrderNumber(5);
            $count = $this->Recharge_record_model->rowCount(array('order_number' => $randCode));
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
