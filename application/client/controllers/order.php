<?php

class Order extends CI_Controller {

    private $_status = array(
        '0' => '<font color="#ff4200">未付款</font>',
        '1' => '<font color="#cc3333">已付款</font>',
        '2' => '<font color="#ff811f">待收货</font>',
        '3' => '<font color="#066601">交易成功</font>',
        '4' => '<font color="#a0a0a0">交易关闭</font>',
    );
    private $_deliveryTime = array('1' => '工作日、双休日均可(周一至周日)', '2' => '工作日(周一至周五)', '3' => '双休日(周六周日)');
    private $_hideValue = array(
        'a' => 0,
        'b' => 1,
        'c' => 2,
        'd' => 3,
        'e' => 4
    );
    private $_table = 'orders';
    private $_template = 'order';
    public function __construct() {
        parent::__construct();
        $this->load->model(ucfirst($this->_table) . '_model', 'tableObject', TRUE);
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Cart_model', '', TRUE);
        $this->load->model('Payment_way_model', '', TRUE);
        $this->load->model('Area_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Postage_price_model', '', TRUE);
        $this->load->model('Postage_way_model', '', TRUE);
        $this->load->model('Free_postage_setting_model', '', TRUE);
        $this->load->model('Orders_detail_model', '', TRUE);
        $this->load->model('Orders_process_model', '', TRUE);
        $this->load->model('User_address_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Financial_model', '', TRUE);
        $this->load->model('Ptkj_record_model', '', TRUE);
        $this->load->model('Pintuan_model', '', TRUE);
        $this->load->model('Promotion_ptkj_model', '', TRUE);
        $this->load->model('Chop_record_model', '', TRUE);
        $this->load->model('Flash_sale_record_model', '', TRUE);
        $this->load->model('Score_model', '', TRUE);
        $this->load->model('Score_setting_model', '', TRUE);
        $this->load->model('Pay_log_model', '', TRUE);
        $this->load->model('Financial_model', '', TRUE);
        $this->load->model('Exchange_model', '', TRUE);
        $this->load->model('Store_model', '', TRUE);
        $this->load->library('Form_validation');
        $this->load->library('Pagination');
        $this->load->helper('my_functionlib');
    }

    public function my_order_index($s = 'all', $order_type = 0, $page = 0) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();

        //超过24小时关闭订单
        $time = time();
        $order_list = $this->tableObject->gets('id',"add_time <= {$time} - (24*60*60) and status = 0");
        if ($order_list){
            foreach ($order_list as $value){
                $fields = array(
                    'cancel_cause'=>'超时自动关闭',
                    'status'=>4
                );
                if ($this->tableObject->save($fields, array('id'=>$value['id']))) {
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
        //当前位置
        $location = "<a href='index.php/user.html'>会员中心</a> > <a href='javascript:void(0);'>我是消费者</a> > 我的订单";
        $user_id = get_cookie('user_id');
        $strWhere = "user_id = {$user_id} ";
        if ($s != 'all') {
        	$strWhere .= " and status in ({$this->_hideValue[$s]}) ";
        }
        //分页
        $paginationCount = $this->tableObject->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/order/my_order_index/{$s}/$order_type/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 5;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->tableObject->gets('*', $strWhere, $paginationConfig['per_page'], $page);
        if ($item_list) {
            foreach ($item_list as $key => $order) {
                $order_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $order['id']));
                $item_list[$key]['order_detail_list'] = $order_detail_list;
            }
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '订单列表' . $systemInfo['site_name'],
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
            'location' => $location,
            'select_status' => $s,
        	'template'=>$this->_template
        );
        $layout = array(
            'content' => $this->load->view('order/my_order_index', $data, TRUE)
        );
        $this->load->view('layout/user_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //查看详情
    public function my_view($id = NULL) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        checkLogin();
        //判断是否登录
        if (!$id) {
            $data = array(
                'user_msg' => '你访问的页面不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $strWhere = array('user_id' => get_cookie('user_id'), 'id' => $id);
        $item_info = $this->tableObject->get('*', $strWhere);
        if (!$item_info) {
            $data = array(
                'user_msg' => '此订单信息不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $item_info['id']));
        if($orders_detail_list){
            foreach ($orders_detail_list as $key=>$value){
                $exchange_info = $this->Exchange_model->get('id,status', array('orders_id' => $value['order_id'],'orders_detail_id'=>$value['id']));
                if ($exchange_info) {
                    $exchange_info['is_exchange'] = 1;
                    $orders_detail_list[$key]['exchange_info'] = $exchange_info;
                } else {
                    $orders_detail_list[$key]['exchange_info'] = array('is_exchange' => 0);
                }
            }
        }
        $item_info['orders_detail_list'] = $orders_detail_list;
        $item_info['orders_process_list'] = $this->Orders_process_model->gets('*', array('order_id' => $item_info['id']));
        $item_info['pay_time'] = null;
        $item_info['delivery_time'] = null;
        $item_info['receiving_time'] = null;
        if($item_info['orders_process_list']){
            foreach ($item_info['orders_process_list'] as $key=>$value){
                if($value['change_status'] == 1){
                    $item_info['pay_time'] = $value['add_time'];
                }
                if($value['change_status'] == 2){
                    $item_info['delivery_time'] = $value['add_time'];
                }
                if($value['change_status'] == 3){
                    $item_info['receiving_time'] = $value['add_time'];
                }
            }
        }
        //当前位置
        $location = "<a href='index.php/user.html'>会员中心</a> > <a href='javascript:void(0);'>我是消费者</a> > <a href='javascript:void(0);'>我的订单</a> > 订单详情";

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '订单详细',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_info' => $item_info,
            'location' => $location,
            'deliveryTime' => $this->_deliveryTime,
            'status' => $this->_status
        );
        $layout = array(
            'content' => $this->load->view('order/my_view', $data, TRUE)
        );
        $this->load->view('layout/user_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //收货
    public function receiving() {
        checkLogin();
        if ($_POST) {
            $user_id = get_cookie('user_id');
            $id = $this->input->post('id', TRUE);
            if (!$id) {
                printAjaxError('fail', "操作异常，刷新重试");
            }
            $ordersInfo = $this->tableObject->get('id, user_id,status,score, order_number, divide_total, divide_store_price', array('id' => $id, 'user_id' => $user_id));
            if (!$ordersInfo) {
                printAjaxError('fail', "不存在此订单");
            }
            if ($ordersInfo['status'] != 2) {
                printAjaxError('fail', "此订单状态异常，确认收货失败");
            }
            $fields = array(
                'status' => 3
            );
            if (!$this->tableObject->save($fields, array('id' => $id, 'user_id' => $user_id))) {
                printAjaxError('fail', "操作失败！");
            }
            //订单记录跟踪(只修改状态，扣钱，是下线交易的)
            $fields = array(
                'add_time' => time(),
                'content' => '确认收货，交易成功',
                'order_id' => $id
            );
            $this->Orders_process_model->save($fields);
            //积分记录操作
            if ($ordersInfo && $ordersInfo['score']) {
                $userInfo = $this->User_model->getInfo('id, username, score', array('id' => $ordersInfo['user_id']));
                if ($userInfo) {
                    if ($this->User_model->save(array('score' => $ordersInfo['score'] + $userInfo['score']), array('id' => $ordersInfo['user_id']))) {
                        $sFields = array(
                            'cause' => "订单交易成功--{$ordersInfo['order_number']}",
                            'score' => $ordersInfo['score'],
                            'balance' => $ordersInfo['score'] + $userInfo['score'],
                            'type' => 'product_in',
                            'add_time' => time(),
                            'username' => $userInfo['username'],
                            'user_id' => $userInfo['id'],
                            'ret_id' => $ordersInfo['id']
                        );
                        $this->Score_model->save($sFields);
                    }
                }
            }
            //减库存与加销售量
            $orderdetailInfo = $this->Orders_detail_model->get('product_id, buy_number', array('order_id' => $id));
            if ($orderdetailInfo) {
                $productInfo = $this->Product_model->get('stock, sales', array('id' => $orderdetailInfo['product_id']));
                $stock = 0;
                if ($productInfo['stock'] - $orderdetailInfo['buy_number'] > 0) {
                    $stock = $productInfo['stock'] - $orderdetailInfo['buy_number'];
                }
                $pFields = array(
                    'stock' => $stock,
                    'sales' => $productInfo['sales'] + $orderdetailInfo['buy_number']
                );
                $this->Product_model->save($pFields, array('id' => $orderdetailInfo['product_id']));
            }
            printAjaxSuccess('success', '操作成功！');
        }
    }

    public function closeOrder() {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/order.html'));
        //判断是否登录
        checkLoginAjax();
        if ($_POST) {
            $id = $this->input->post('id', TRUE);
            if (!$id) {
                printAjaxError('fail', '异常操作');
            }
            $order_info = $this->tableObject->get('status', array('id' => $id, 'user_id' => get_cookie('user_id')));
            if (!$order_info) {
                printAjaxError('fail', '此订单不存在');
            }
            if ($order_info['status'] > 0) {
                printAjaxError('fail', '此状态不可取消订单');
            }
            //添加订单信息
            $fields = array(
                'status' => 4,
                'cancel_cause' => '买家关闭交易',
            );
            $ret = $this->tableObject->save($fields, array('id' => $id, 'user_id' => get_cookie('user_id')));
            if ($ret) {
                $this->Orders_process_model->save(array('add_time' => time(), 'content' => '买家关闭交易', 'order_id' => $id));
                printAjaxSuccess('success', '交易关闭成功！');
            } else {
                printAjaxError('fail', '交易关闭失败');
            }
        }
    }

    //普通下单
    public function add() {
        //判断是否登录
        checkLoginAjax();
        if ($_POST) {
            $systemInfo = $this->System_model->get('*', array('id' => 1));
            $score_setting = $this->Score_setting_model->get('*',array('id'=>1));
            $user_id = get_cookie('user_id');
            //备注
            $store_remark = $this->input->post('store_remark', TRUE);
            //配送方式
            $store_postage_ids = $this->input->post('store_postage_ids', TRUE);
            //收货地址ID
            $select_user_address_id = $this->input->post('select_user_address_id', TRUE);
            //选购商品
            $cart_ids = $this->input->post('cart_ids',true);

            if (!$select_user_address_id) {
            	printAjaxError('fail', "请选择收货地址");
            }
            //用已经存在的收货地址
            $user_address_info = $this->User_address_model->get('*', array('id' => $select_user_address_id));
            if (!$user_address_info) {
            	printAjaxError('fail', '此收货地址信息不存在，下单失败');
            }
            if (!$store_postage_ids) {
            	printAjaxError('fail', "请选择配送方式");
            }
            if (!$cart_ids) {
            	printAjaxError('fail', "您未选购商品，订单提交失败");
            }
            $user_info = $this->User_model->getInfo('*', array('id' => $user_id));
            if (!$user_info) {
                printAjaxError('fail', "您的账号不存在或被管理员删除");
            }
            //提交订单-每个店生成一个订单
            //按店铺分组显示
            //优惠
            $discount_total = 0;
            //税费
            $taxation_total = 0;
            //商品
            $product_total = 0;
            //邮费
            $postage_price = 0;
            //总金额
            $total = 0;
            //成功数量
            $store_succes_count = 0;
            $order_ids = '';
            $strWhere = "cart.id in ({$cart_ids}) and cart.user_id = {$user_id}";
            $item_list = $this->Cart_model->gets_store_list($strWhere);
            if ($item_list) {
            	foreach ($item_list as $key=>$value) {
//                    if (!$store_postage_ids[$key]) {
//                        printAjaxError('fail', "请选择配送方式");
//                    }
            		$order_number = $this->_getUniqueOrderNumber();
            		//优惠
            		$store_discount_total = 0;
            		//税费
            		$store_taxation_total = 0;
            		//商品
            		$store_product_total = 0;
            		//邮费
            		$store_postage_price = 0;
                    $area_name = '';
                    $weight_num_total = 0;

            		//总金额
            		$store_total = 0;

                    //运费
                    $area_info = $this->Area_model->get('name', array('id' => $user_address_info['province_id']));
                    if ($area_info) {
                        $area_name = $area_info['name'];
                    }

                    $postage_way_list = $this->Postage_way_model->gets('*', array('display' => 1,'store_id'=>$value['store_id']));
                    $postage_way_info = array();
                    if ($postage_way_list) {
                        if (empty($store_postage_ids[$key])){
                            printAjaxError('fail', "请选择配送方式");
                        }
                        $postage_way_info = $this->Postage_way_model->get('id,charging_mode', array('id' => $store_postage_ids[$key],'display' => 1));
                        if (!$postage_way_info) {
                            printAjaxError('fail', '配送方式不存在，请重新选择');
                        }
                    }

            		$cart_list = $this->Cart_model->gets("cart.id in ({$cart_ids}) and cart.user_id = {$user_id} and cart.store_id = {$value['store_id']}");
            		if ($cart_list) {
            			foreach ($cart_list as $cart) {
            				$store_product_total += $cart['buy_number']*$cart['sell_price'];

                            if ($postage_way_info){
                                if ($postage_way_info['charging_mode'] == 2){
                                    $weight_num_total += $cart['buy_number'] * $cart['weight'];
                                }else{
                                    $weight_num_total += $cart['buy_number'];
                                }
                            }

                        }

            		}

                    //运费
                    if ($postage_way_info){
                        $store_postage_price = $this->_get_postage_price($store_postage_ids[$key], $weight_num_total, $area_name);
                    }

            		$product_total += $store_product_total;
            		$discount_total += $store_discount_total;
            		$taxation_total += $store_taxation_total;
            		$postage_price += $store_postage_price;
            		$store_total = number_format($store_product_total+$store_taxation_total+$store_postage_price-$store_discount_total, '2', '.', '');
//            		$store_info = $this->Store_model->get('user_id',array('id'=>$value['store_id']));
            		/****************提交订单*****************/
            		$fields = array(
            				'user_id' =>      $user_info['id'],
            				'user_name'=>     $user_info['username'],
            				'seller_id'=>     $value['store_user_id'],
            				'store_id'=>      $value['store_id'],
            				'store_name'=>    $value['store_name'],
            				'order_number' => $order_number,
            				'postage_id' =>   0,
            				'postage_title' =>'',
            				'postage_price' =>$store_postage_price,
            				'product_total'=> $store_product_total,
            				'taxation_total'=>$store_taxation_total,
            				'discount_total'=>$store_discount_total,
            				'total' =>        $store_total,
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
            				'remark' =>      $store_remark[$key]
            		);
            		//添加订单
            		$ret_id = $this->tableObject->save($fields);
            		if ($ret_id) {
            			/***************************添加订单详细信息*********************** */
            			$succes_count = 0;
            			if ($cart_list) {
            				foreach ($cart_list as $cart) {
            					//订单详情
            					$orders_detail_fields = array(
            							'order_id' =>        $ret_id,
            							'product_id' =>      $cart['product_id'],
            							'product_num' =>     $cart['product_num'],
            							'product_title' =>   $cart['title'],
            							'buy_number' =>      $cart['buy_number'],
            							'buy_price' =>       number_format($cart['sell_price'], 2, '.', ''),
            							'size_name' =>       $cart['size_name'],
            							'size_id' =>         $cart['size_id'],
            							'color_name' =>      $cart['color_name'],
            							'color_id' =>        $cart['color_id'],
            							'path' =>            $cart['path'],
            							'color_size_open'=>     $cart['color_size_open'],
            							'product_color_name'=>  $cart['product_color_name'],
            							'product_size_name'=>   $cart['product_size_name']
            					);
            					if ($this->Orders_detail_model->save($orders_detail_fields)) {
            						$succes_count++;
            					}
            				}
            			}
            			if (($succes_count != count($cart_list)) || count($cart_list) == 0) {
            				//删除订单详细信息
            				$this->Orders_detail_model->delete("order_id in (".$order_ids.$ret_id.")");
            				//删除记录
            				$this->Orders_process_model->delete("order_id in (".$order_ids.$ret_id.")");
            				//删除已经添加进去的数据，保持数据统一性
            				$this->tableObject->delete("id in (".$order_ids.$ret_id.")");
            				//下单失败，直接退出
            				break;
            			} else {
            				$store_succes_count++;
            				$order_ids .= $ret_id.',';
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
            		} else {
            			//失败，直接退出
            			if ($order_ids) {
            				//删除订单详细信息
            				$this->Orders_detail_model->delete("order_id in (".substr($order_ids, 0, -1).")");
            				//删除记录
            				$this->Orders_process_model->delete("order_id in (".substr($order_ids, 0, -1).")");
            				//删除已经添加进去的数据，保持数据统一性
            				$this->tableObject->delete("id in (".substr($order_ids, 0, -1).")");
            			}
            			break;
            		}
            	}
            }
            if ($store_succes_count != count($item_list)) {
            	if ($order_ids) {
            		//删除订单详细信息
            		$this->Orders_detail_model->delete("order_id in (".substr($order_ids, 0, -1).")");
            		//删除记录
            		$this->Orders_process_model->delete("order_id in (".substr($order_ids, 0, -1).")");
            		//删除已经添加进去的数据，保持数据统一性
            		$this->tableObject->delete("id in (".substr($order_ids, 0, -1).")");
            	}
            	printAjaxError('fail', '下单失败，请重试');
            } else {
            	//删除购物车数据
            	$this->Cart_model->delete($strWhere);
            }
            if ($order_ids) {
            	$order_ids = str_replace(',', '_', substr($order_ids, 0, -1));
            }
            if (count($item_list) > 1) {
                printAjaxSuccess(base_url() . "index.php/order/my_pay/{$order_ids}.html", '订单提交成功');
            } else {
                printAjaxSuccess(base_url() . "index.php/order/my_go_to_pay/{$order_ids}.html", '订单提交成功');
            }
        }
    }

    //付款
    public function my_pay($order_ids = NULL) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        if (!$order_ids) {
        	$data = array(
        			'user_msg' => '付款订单信息不存在',
        			'user_url' => base_url()
        	);
        	$this->session->set_userdata($data);
        	redirect('/message/index');
        }
        $order_ids = str_replace('_', ',', $order_ids);
        $item_list = $this->tableObject->gets('*', "id in ({$order_ids}) and user_id = {$user_id}");
        if (!$item_list) {
            $data = array(
                'user_msg' => '付款订单信息不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $order_status_success = 1;
        foreach ($item_list as $key=>$value) {
        	if ($value['status'] > 0) {
        		$order_status_success = 0;
        		break;
        	}
        }
        if (!$order_status_success) {
            $data = array(
                'user_msg' => '付款订单操作异常',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $total = 0;
        $delivery_address = '';
        foreach ($item_list as $key=>$value) {
        	$total+=$value['total'];
            $delivery_address = str_replace(' ','',$value['txt_address']).$value['address'];
        }
        $total = number_format($total, 2, '.', '');
        $user_info = $this->User_model->get('total', array('id' => $user_id));
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
        	'item_list'=>$item_list,
        	'order_ids'=>str_replace(',', '_', $order_ids),
        	'total'=>$total,
        	'delivery_address'=>$delivery_address,
        	'user_info'=>$user_info,
        );
        $layout = array(
            'content' => $this->load->view('order/my_pay', $data, TRUE)
        );
        $this->load->view('layout/cart_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_go_to_pay($order_id = NULL){
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        if (!$order_id) {
            $data = array(
                'user_msg' => '付款订单信息不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $item_info = $this->tableObject->get('*', "id = '{$order_id}' and status = 0 and user_id = {$user_id}");
        if (!$item_info) {
            $data = array(
                'user_msg' => '付款订单信息不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $total = number_format($item_info['total'], 2, '.', '');
        $delivery_address = str_replace(' ','',$item_info['txt_address']).$item_info['address'];
        $user_info = $this->User_model->get('total', array('id' => $user_id));
        $order_detail_list = $this->Orders_detail_model->gets('*',array('order_id'=>$order_id));
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
            'total' => $total,
            'user_info' => $user_info,
            'delivery_address' => $delivery_address,
            'order_detail_list' => $order_detail_list,
        );
        $layout = array(
            'content' => $this->load->view('order/my_go_to_pay', $data, TRUE)
        );
        $this->load->view('layout/cart_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //预存款订单结算
    public function trade() {
        checkLogin();
        if ($_POST) {
            $pay_title = $this->input->post('pay_title');
            $order_id = $this->input->post('order_id');
            //判断下单用户是否存在
            $userInfo = $this->User_model->get('*', array('user.id' => get_cookie('user_id')));
            if (!$userInfo) {
                printAjaxError('fail', '此用户不存在，结算失败');
            }
            $orders_info = $this->tableObject->get('id,total,txt_address,add_time,expires,address,buyer_name,mobile,status, order_number, payment_id', array('id' => $order_id, 'user_id' => get_cookie('user_id')));
            if (!$orders_info) {
                printAjaxError('fail', '此订单信息不存在');
            }
            if ($orders_info['status'] != 0) {
                printAjaxError('fail', '此订单操作异常');
            }
            if ($orders_info['add_time'] + $orders_info['expires'] < time()) {
                printAjaxError('fail', '对不起，该订单已过期！');
            }
            //支付金额
            $total = $orders_info['total'];
            //预存款支付
            if ($total > $userInfo['total']) {
                printAjaxError('fail', '预存款余额不足，请选择其它支付方式');
            }
            //进行扣款
            if ($this->User_model->save(array('total' => $userInfo['total'] - $total), array('id' => get_cookie('user_id')))) {
                //付款成功，修改订单状态
                $this->tableObject->save(array('status' => 1, 'payment_title' => '预存款支付', 'payment_id' => 1), array('id' => $order_id, 'user_id' => get_cookie('user_id')));
                //付款成功减少相应库存
                $orders_detail = $this->Orders_detail_model->gets('*', array('order_id' => $orders_info['id']));
                foreach ($orders_detail as $item) {
                    $stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
                    $this->Product_model->changeStock(array('stock' => $stock_info['stock'] - $item['buy_number']), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
                }
                //财务记录还没有添加
                $fFields = array(
                    'cause' => "订单付款成功--[订单号：{$orders_info['order_number']}]",
                    'price' => -$total,
                    'balance' => ($userInfo['total'] - $total),
                    'add_time' => time(),
                    'user_id' => $userInfo['id'],
                    'username' => $userInfo['username'],
                    'type' => 'recharge_out'
                );
                $this->Financial_model->save($fFields);
                //添加跟踪记录
                $ordersprocessFields2 = array(
                    'add_time' => time(),
                    'content' => "订单付款成功",
                    'order_id' => $order_id
                );
                $this->Orders_process_model->save($ordersprocessFields2);
                printAjaxSuccess(base_url() . 'index.php/order/result?out_trade_no='.$orders_info['order_number'],'恭喜您支付成功!');
            } else {
                printAjaxError('fail', '支付失败!');
            }
        }
    }

    //支付宝支付
    public function alipay_pay($order_id = NULL) {
        header('Content-type:text/html;charset=utf-8');
        $gloabPreUrl = $this->session->userdata('gloabPreUrl');
        checkLogin();
        if (!$order_id) {
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
        $orders_info = $this->tableObject->get('*', "id = {$order_id} and user_id = {$user_id} and status = 0");
        if (!$orders_info) {
            $data = array(
                'user_msg' => '此订单信息不存在',
                'user_url' => $gloabPreUrl
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $out_trade_no = $orders_info['order_number'];
        $total_fee =  $orders_info['total'];
        //生成支付记录
        if(!$this->Pay_log_model->rowCount(array('out_trade_no'=>$out_trade_no, 'payment_type'=>'alipay', 'order_type'=>'orders'))) {
            $this->tableObject->save(array('out_trade_no'=>$out_trade_no), array('id'=>$orders_info['id']));
            $fields = array(
                'user_id'=>       $user_id,
                'total_fee'=>     $orders_info['total'],
                'total_fee_give'=>0,
                'out_trade_no'=>  $out_trade_no,
                'order_num'=>     $orders_info['order_number'],
                'trade_status'=>  'WAIT_BUYER_PAY',
                'add_time'=>      time(),
                'payment_type'=>  'alipay',
                'order_type'=>    'orders',
                'seller_id'=>    $orders_info['seller_id'],
                'store_id'=>    $orders_info['store_id'],
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
            "notify_url"	=> base_url().'index.php/order/alipay_notify',
            "return_url"	=> base_url().'index.php/order/alipay_return',
            "anti_phishing_key"=>$alipay_config['anti_phishing_key'],
            "exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
            "out_trade_no"	=> $out_trade_no,
            "subject"	=>"蚁立网付款",
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
            $alipay_config['notify_url'] = base_url().'index.php/order/alipay_notify';
            $alipay_config['return_url'] = base_url().'index.php/order/alipay_return';
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
                    $pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no'=>$out_trade_no, 'order_type'=>'orders', 'payment_type'=>'alipay'));
                    if ($pay_log_info && $alipay_config['seller_id'] == $seller_id && $total_fee == $pay_log_info['total_fee']) {
                        if ($pay_log_info['trade_status'] != $trade_status && $pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
                            //支付记录
                            $fields = array(
                                'payment_type'=> 'alipay',
                                'order_type'=>   'orders',
                                'trade_no'=>     $trade_no,
                                'trade_status'=> $trade_status,
                                'buyer_email'=>  $buyer_email,
                                'notify_time'=>  $notify_time
                            );
                            if ($this->Pay_log_model->save($fields, array('id'=>$pay_log_info['id']))) {
                                $item_info = $this->tableObject->get('*', array('order_number'=>$order_num, 'status'=>0));
                                $user_info = $this->User_model->get('id, total, username', array('id'=>$item_info['user_id']));
                                if ($item_info && $user_info) {
                                    //修改订单状态
                                    $fields = array(
                                        'status'=> 1,
                                        'payment_price'=> 0,//费率
                                        'payment_title'=> '支付宝支付',
                                        'payment_id'=>2);
                                    if ($this->tableObject->save($fields, array('id'=>$item_info['id']))) {
                                        //订单追踪记录
                                        $fields = array(
                                            'add_time' =>     time(),
                                            'content'=>       "订单付款成功[支付宝支付]",
                                            'order_id' =>    $item_info['id'],
                                            'order_status'=>$item_info['status'],
                                            'change_status'=> 1
                                        );
                                        $this->Orders_process_model->save($fields);
                                        //财务记录
                                        if (!$this->Financial_model->rowCount(array('type'=>'order_out', 'ret_id'=>$item_info['id']))) {
                                            $fields = array(
                                                'cause'=>"支付成功-[订单号：{$item_info['order_number']}]",
                                                'price'=>-$item_info['total'],
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
        $alipay_config['notify_url'] = base_url().'index.php/order/alipay_notify';
        $alipay_config['return_url'] = base_url().'index.php/order/alipay_return';
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

        if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
            //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //如果有做过处理，不执行商户的业务程序
            $pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no'=>$out_trade_no, 'order_type'=>'orders', 'payment_type'=>'alipay'));
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
                    'order_type'=>   'orders',
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
                $item_info = $this->tableObject->get('*', array('order_number'=>$order_num, 'status'=>0));
                $user_info = $this->User_model->get('id, total, username', array('id'=>$item_info['user_id']));
                if ($item_info && $user_info) {
                    //修改订单状态
                    $fields = array(
                        'status'=> 1,
                        'payment_price'=> 0,//费率
                        'payment_title'=> '支付宝支付',
                        'payment_id'=>2);
                    if ($this->tableObject->save($fields, array('id'=>$item_info['id'], 'status'=>0))) {
                        //订单追踪记录
                        $fields = array(
                            'add_time' =>     time(),
                            'content'=>       "订单付款成功[支付宝支付]",
                            'order_id' =>    $item_info['id'],
                            'order_status'=>$item_info['status'],
                            'change_status'=> 1
                        );
                        $this->Orders_process_model->save($fields);
                        //财务记录
                        if (!$this->Financial_model->rowCount(array('type'=>'order_out', 'ret_id'=>$item_info['id']))) {
                            $fields = array(
                                'cause'=>"支付成功-[订单号：{$item_info['order_number']}]",
                                'price'=>-$item_info['total'],
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
                redirect(base_url() . "index.php/{$this->_template}/pay_result/{$order_num}.html");
            } else {
                $fields = array('payment_type'=>'alipay', 'order_type'=>'orders');
                if (!$pay_log_info['buyer_email']) {
                    $fields['buyer_email'] = $buyer_email;
                }
                if (!$pay_log_info['notify_time']) {
                    $fields['notify_time'] = $notify_time;
                }
                if ($fields) {
                    $this->Pay_log_model->save($fields, array('id'=>$pay_log_info['id']));
                }
                redirect(base_url() . "index.php/{$this->_template}/pay_result/{$order_num}.html");
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
    public function my_pay_weixin($order_id = NULL)
    {
        $gloabPreUrl = $this->session->userdata('gloabPreUrl');
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        if (!$order_id) {
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
        $item_info = $this->tableObject->get('*', "id = {$order_id} and user_id = {$user_id} and status = 0");
        if (!$item_info) {
            $data = array(
                'user_msg' => '此订单信息不存在',
                'user_url' => $gloabPreUrl
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }

        /********************微信支付**********************/
        require_once "sdk/weixin_pay/lib/WxPay.Api.php";
        require_once "sdk/weixin_pay/WxPay.NativePay.php";

        $product_id = 'O' . $item_info['order_number'];
        $out_trade_no = $item_info['out_trade_no'];
        if (!$out_trade_no) {
            $out_trade_no = 'O' . $this->advdbclass->get_unique_orders_number('out_trade_no');
            $this->tableObject->save(array('out_trade_no' => $out_trade_no), array('id' => $item_info['id']));
        }
        $notify = new NativePay();
        $input = new WxPayUnifiedOrder();
        $input->SetBody("蚁立网付款");
        $input->SetAttach("{$item_info['order_number']}");
        $input->SetTotal_fee($item_info['total'] * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url(base_url() . "index.php/order/weixin_notify");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($product_id);
        $input->SetOut_trade_no($out_trade_no);
        $result = $notify->GetPayUrl($input);
        $qr_url = '';
        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            $qr_url = $result["code_url"];
            //生成支付记录
            if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'orders'))) {
                $fields = array(
                    'user_id' => $user_id,
                    'total_fee' => $item_info['total'],
                    'total_fee_give' => 0,
                    'out_trade_no' => $out_trade_no,
                    'order_num' => $item_info['order_number'],
                    'trade_status' => 'WAIT_BUYER_PAY',
                    'add_time' => time(),
                    'payment_type' => 'weixin',
                    'order_type' => 'orders',
                    'seller_id'=>    $item_info['seller_id'],
                    'store_id'=>    $item_info['store_id'],
                );
                $this->Pay_log_model->save($fields);
            }
        } else {
            if (array_key_exists('result_code', $result) && $result['result_code'] == "FAIL") {
                //商户号重复时，要重新生成
                if ($result['err_code'] == 'OUT_TRADE_NO_USED' || $result['err_code'] == 'INVALID_REQUEST') {
                    $out_trade_no = 'O' . $this->advdbclass->get_unique_orders_number('out_trade_no');
                    $this->tableObject->save(array('out_trade_no' => $out_trade_no), array('id' => $item_info['id']));

                    $notify = new NativePay();
                    $input = new WxPayUnifiedOrder();
                    $input->SetBody("蚁立网付款");
                    $input->SetAttach("{$item_info['order_number']}");
                    $input->SetTotal_fee($item_info['total'] * 100);
                    $input->SetTime_start(date("YmdHis"));
                    $input->SetTime_expire(date("YmdHis", time() + 600));
                    $input->SetNotify_url(base_url() . "index.php/order/weixin_notify");
                    $input->SetTrade_type("NATIVE");
                    $input->SetProduct_id($product_id);
                    $input->SetOut_trade_no($out_trade_no);
                    $result = $notify->GetPayUrl($input);
                    if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
                        $qr_url = $result["code_url"];
                        //生成支付记录
                        if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'orders'))) {
                            $fields = array(
                                'user_id' => $user_id,
                                'total_fee' => $item_info['total'],
                                'total_fee_give' => 0,
                                'out_trade_no' => $out_trade_no,
                                'order_num' => $item_info['order_number'],
                                'trade_status' => 'WAIT_BUYER_PAY',
                                'add_time' => time(),
                                'payment_type' => 'weixin',
                                'order_type' => 'orders',
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
            'total' => $item_info ? $item_info['total'] : '0.00',
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

                    $pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'orders', 'payment_type' => 'weixin'));
                    if ($pay_log_info && $total_fee == $pay_log_info['total_fee'] * 100) {
                        if ($pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
                            //支付记录
                            $fields = array(
                                'payment_type' => 'weixin',
                                'order_type' => 'orders',
                                'trade_no' => $trade_no,
                                'trade_status' => 'TRADE_SUCCESS',
                                'buyer_email' => '',
                                'notify_time' => strtotime($notify_time)
                            );
                            if ($this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
                                $item_info = $this->tableObject->get('*', array('order_number' => $order_num, 'status' => 0));
                                $user_info = $this->User_model->get('id, total, username', array('id' => $item_info['user_id']));
                                if ($item_info && $user_info) {
                                    //修改订单状态
                                    $fields = array(
                                        'status' => 1,
                                        'payment_price' => 0,//费率
                                        'payment_title' => '微信支付',
                                        'payment_id' => 3);
                                    if ($this->tableObject->save($fields, array('id' => $item_info['id']))) {
                                        //订单追踪记录
                                        $fields = array(
                                            'add_time' => time(),
                                            'content' => "订单付款成功[微信支付]",
                                            'order_id' => $item_info['id'],
                                            'current_status' => $item_info['status'],
                                            'change_status' => 1
                                        );
                                        $this->Orders_process_model->save($fields);
                                        //财务记录
                                        if (!$this->Financial_model->rowCount(array('type' => 'order_out', 'ret_id' => $item_info['id']))) {
                                            $fields = array(
                                                'cause' => "支付成功-[订单号：{$item_info['order_number']}]",
                                                'price' => -$item_info['total'],
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
            $pay_log_info = $this->Pay_log_model->get('trade_status, order_num', array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'orders'));
            if (!$pay_log_info) {
                printAjaxError('fail', '支付记录不存在');
            }
            printAjaxData($pay_log_info);
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
            $order_id = $this->input->post('order_id');
            $pay_password = $this->input->post('pay_password');
            if (!$pay_password) {
                printAjaxError('fail', '支付密码不能为空');
            }
            //判断下单用户是否存在
            $user_info = $this->User_model->get('*', array('user.id' => $user_id));
            if (!$user_info) {
                printAjaxError('fail', '此用户不存在，结算失败');
            }
            $item_info = $this->tableObject->get('*', "id = '{$order_id}' and user_id = {$user_id} and status = 0");
            if (!$item_info) {
                printAjaxError('fail', '此订单信息不存在');
            }
            //预存款支付
            if ($item_info['total'] > $user_info['total']) {
                printAjaxError('fail', '预存款余额不足，请选择其它支付方式');
            }
            if (create_password_salt($user_info['username'], $user_info['add_time'], $pay_password) != $user_info['pay_password']) {
                printAjaxError('fail', '支付密码错误，请重新输入');
            }
            //修改订单状态
            $fields = array(
                'status' => 1,
                'payment_price' => 0,//费率
                'payment_title' => '预存款支付',
                'payment_id' => 1);
            if (!$this->tableObject->save($fields, array('id' => $item_info['id'], 'user_id' => $user_info['id']))) {
                printAjaxError('fail', '预存款支付失败');
            }
            $fields = array(
                'add_time' => time(),
                'content' => "订单付款成功--[订单号：{$item_info['order_number']}]",
                'order_id' => $item_info['id'],
                'order_status' => $item_info['status'],
                'change_status' => 1
            );
            $orders_process_id = $this->Orders_process_model->save($fields);
            if (!$orders_process_id) {
                $fields = array(
                    'status' => 0,
                    'payment_price' => 0,//费率
                    'payment_title' => '',
                    'payment_id' => 0);
                $this->tableObject->save($fields, array('id' => $item_info['id'], 'user_id' => $user_info['id']));
                printAjaxError('fail', '预存款支付失败');
            }
//             //付款成功减少相应库存
//             $orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id'=> $item_info['id']));
//             if ($orders_detail_list) {
//             	foreach ($orders_detail_list as $item) {
//             		$product_info = $this->Product_model->get('color_size_open,stock', array('id' => $item['product_id']));
//             		if ($product_info['color_size_open'] == 1) {
//             			$stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
//             			$this->Product_model->changeStock(array('stock' => $stock_info['stock'] - $item['buy_number']), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
//             		} else {
//             			$this->Product_model->save(array('stock' => $product_info['stock'] - $item['buy_number']), array('id' => $item['product_id']));
//             		}
//             	}
//             }
            //进行扣款
            if (!$this->User_model->save(array('total' => $user_info['total'] - $item_info['total']), array('id' => $user_id))) {
                $fields = array(
                    'status' => 0,
                    'payment_price' => 0,//费率
                    'payment_title' => '',
                    'payment_id' => 0);
                $this->tableObject->save($fields, array('id' => $item_info['id'], 'user_id' => $user_info['id']));
                $this->Orders_process_model->delete(array('id' => $orders_process_id));
                printAjaxError('fail', '预存款支付失败');
            }
            //财务记录还没有添加
            $fields = array(
                'cause' => "订单付款成功--[订单号：{$item_info['order_number']}]",
                'price' => -$item_info['total'],
                'balance' => $user_info['total'] - $item_info['total'],
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
            printAjaxSuccess(base_url() . "index.php/order/pay_result/{$item_info['order_number']}", '恭喜您支付成功!');
        }
    }


    //付款完成
    public function pay_result($order_num = NULL){
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        if (!$order_num) {
            $data = array(
                'user_msg' => '此订单信息不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $item_info = $this->tableObject->get('*', "order_number = '{$order_num}' and user_id = {$user_id} and status = 1");
        if (!$item_info) {
            $data = array(
                'user_msg' => '此订单信息不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '付款完成' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_info' => $item_info
        );
        $layout = array(
            'content' => $this->load->view('order/pay_result', $data, TRUE)
        );
        $this->load->view('layout/cart_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function delete_order() {
        checkLogin();
        if ($_POST) {
            $user_id = get_cookie('user_id');
            $ids = trim($this->input->post('ids', true), ',');
            if (empty($ids)) {
                printAjaxError('fail', '订单id不能为空');
            }
            $userInfo = $this->User_model->get('*',array('id'=>$user_id));
            $order_list = $this->tableObject->gets('*', "id in ({$ids}) and user_id = {$user_id}");
            $score = $userInfo['score'];
            foreach ($order_list as $item) {
                if ($item['status'] == 0 || $item['status'] == 4) {
                    //街贝返还
                    if($item['deductible_score'] > 0){
                        $score = $score + $item['deductible_score'];
                     $this->User_model->save(array('score'=>$score),array('id'=>$user_id));
                        $sFields = array(
									'cause' =>   "街贝抵现退还--{$item['order_number']}",
									'score' =>   $item['deductible_score'],
									'balance'=>  $score,
									'type'=>     'product_in',
									'add_time'=> time(),
									'username' =>$userInfo['username'],
									'user_id'=>  $user_id,
									'ret_id'=>   $user_id
							);
							$this->Score_model->save($sFields);
                    }
                    $this->Orders_detail_model->delete(array('order_id' => $item['id']));
                    $this->Orders_process_model->delete(array('order_id' => $item['id']));
                    if($item['order_type']==1){
                        $ptkj_record = $this->Ptkj_record_model->get(array('ptkj_record.order_id' => $item['id'],'ptkj_record.user_id'=>$user_id));
                        if ($ptkj_record) {
                            $this->Ptkj_record_model->delete(array('id' => $ptkj_record['id']));
                            $this->Chop_record_model->delete(array('ptkj_record_id' => $ptkj_record['id']));
                        }
                    }
                    if($item['order_type']==2){
                         $this->Flash_sale_record_model->delete(array('order_id' => $item['id']));
                    }
                    $this->tableObject->delete(array('id' => $item['id']));
                }
            }
            printAjaxSuccess('success', '删除成功');
        }
    }


    //获取唯一的订单号
    private function    _getUniqueOrderNumber() {
        //一秒钟一万件的量
        $randCode = '';
        while (true) {
            $randCode = getOrderNumber(5);
            $count = $this->tableObject->rowCount(array('order_number' => $randCode));
            if ($count > 0) {
                $randCode = '';
                continue;
            } else {
                break;
            }
        }
        return $randCode;
    }


    public function get_postage_way_info(){
        //判断是否登录
        checkLoginAjax();
        if ($_POST) {
            $user_id = get_cookie('user_id');
            $postage_id = $this->input->post('postage_id', TRUE);
            $user_address_id = $this->input->post('user_address_id', TRUE);
            $store_cart_ids = $this->input->post('store_cart_ids', TRUE);
            $area_name = '';
            $weight_num_total = 0;

            $user_address_info = $this->User_address_model->get('id, province_id', array('id' => $user_address_id));
            if (!$user_address_info) {
                printAjaxError('fail', '收货地址不存在，请重新选择');
            }
            $area_info = $this->Area_model->get('name', array('id' => $user_address_info['province_id']));
            if ($area_info) {
                $area_name = $area_info['name'];
            }

            $postage_way_info = $this->Postage_way_model->get('id,charging_mode', array('id' => $postage_id,'display' => 1));
            if (!$postage_way_info) {
                printAjaxError('fail', '配送方式不存在，请重新选择');
            }

            $strWhere = "cart.user_id = {$user_id} and cart.id in ({$store_cart_ids}) ";
            $item_list = $this->Cart_model->gets($strWhere);
            if (!$item_list) {
                printAjaxError('fail', '购物车信息不存在');
            }

            foreach ($item_list as $value){
                if ($postage_way_info['charging_mode'] == 2){
                    $weight_num_total += $value['buy_number'] * $value['weight'];
                }else{
                    $weight_num_total += $value['buy_number'];
                }
            }

            $ret = $this->_get_postage_price($postage_id, $weight_num_total, $area_name);

            printAjaxData(array('postage_price'=>$ret));
        }
    }

    //获取配送费用
    private function _get_postage_price($postage_way_id,$weight_num_total,$area_name) {
        $postage_way_info = $this->Postage_way_model->get('payer,charging_mode', array('id'=>$postage_way_id));
        //卖家承担运费
        if ($postage_way_info['payer'] == 2) {
            return 0;
        }
        $postage_price_info = NULL;
        $postage_price_info = $this->Postage_price_model->get('start_val,start_price,add_val,add_price', "postage_way_id = {$postage_way_id} and FIND_IN_SET('{$area_name}', area)");
        if (!$postage_price_info) {
            $postage_price_info = $this->Postage_price_model->get('start_val,start_price,add_val,add_price', "postage_way_id = {$postage_way_id} and area = '其它地区'");
        }

        //首重
        $add_price = 0;
        if ($weight_num_total <= $postage_price_info['start_val']) {
            $add_val = 0;
            $start_price = $postage_price_info['start_price'];
        } else {
            $add_val = $weight_num_total - $postage_price_info['start_val'];
            $start_price = $postage_price_info['start_price'];
        }
        //续重
        if ($postage_price_info['add_val'] > 0) {
            $add_price = ceil($add_val/$postage_price_info['add_val'])*$postage_price_info['add_price'];
        }

        $postage_price = number_format($start_price+$add_price, 2, '.', '');

        return $postage_price;
    }

}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */