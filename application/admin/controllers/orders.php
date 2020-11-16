<?php
class Orders extends CI_Controller {
	private $_title = '订单管理';
	private $_tool = '';
	private $_status = array(
	                   '0'=>'<font color="#ff4200">未付款</font>',
	                   '1'=>'<font color="#cc3333">已付款</font>',
	                   '2'=>'<font color="#ff811f">已发货</font>',
	                   '3'=>'<font color="#066601">交易成功</font>',
	                   '4'=>'<font color="#a0a0a0">交易关闭</font>',
	                   );
	private $_deliveryTime = array('1'=>'工作日、双休日均可(周一至周日)', '2'=>'工作日(周一至周五)', '3'=>'双休日(周六周日)');
        private $_order_type_arr = array(
              '1' => '拼团砍价',
              '2' => '限时秒杀'
        );
    private $_exchange_status_arr = array(
        '0'=>'(退款审核中)',
        '1'=>'(退款审核拒绝)',
        '2'=>'(退款审核通过)',
        '3'=>'(退款成功)',
//        '4'=>'(退款成功)'
    );

	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->_tool = $this->load->view('element/orders_tool', '', TRUE);
		$this->load->model('Area_model', '', TRUE);
		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Orders_detail_model', '', TRUE);
		$this->load->model('Orders_process_model', '', TRUE);
		$this->load->model('Score_model', '', TRUE);
		$this->load->model('Product_model', '', TRUE);
		$this->load->model('Financial_model', '', TRUE);
		$this->load->model('Exchange_model', '', TRUE);
		$this->load->helper('url');
		$this->load->library('pagination');
		$this->load->library('session');
	}

	public function index($status = 'all', $page = 0) {
        //超过24小时关闭订单
        $time = time();
        $order_list = $this->tableObject->gets("add_time <= {$time} - (24*60*60) and status = 0");
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

	    if ($this->uri->segment(4) == -1) {
		    $this->session->unset_userdata(array('search'=>''));
		    $page = 0;
		}
		$this->session->set_userdata(array('ordersRefUrl'=>base_url().'admincp.php/'.uri_string()));
		//用钱买的
		$condition = "{$this->_table}.id > 0";
		if ($status != 'all') {
		    $condition .= " and {$this->_table}.status = {$status}";
		}
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):$condition;

		if ($_POST) {
			$strWhere = $condition;
			$order_number = $this->input->post('order_number', TRUE);
			$buyer_name = $this->input->post('buyer_name', TRUE);
            $startTime = $this->input->post('inputdate_start');
            $endTime = $this->input->post('inputdate_end');
            $order_type = $this->input->post('order_type');

		    if (! empty($order_number) ) {
		        $strWhere .= " and {$this->_table}.order_number = '{$order_number}' ";
		    }
		    if (! empty($buyer_name) ) {
		        $strWhere .= " and {$this->_table}.buyer_name = '{$buyer_name}' ";
		    }
            if(!empty($order_type)){
                $strWhere .= " and {$this->_table}.order_type = '{$order_type}' ";
            }
		    if (! empty($startTime) && ! empty($endTime)) {
		    	$strWhere .= ' and {$this->_table}.add_time > '.strtotime($startTime.' 00:00:00').' and {$this->_table}.add_time < '.strtotime($endTime.' 23:59:59').' ';
		    }
		    $this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationCount = $this->tableObject->rowCount($strWhere);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url()."admincp.php/{$this->_table}/index/{$status}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$ordersList = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
	    foreach ($ordersList as $key=>$order) {
        	$orderdetailList = $this->Orders_detail_model->gets('*', array('order_id'=>$order['id']));
        	$ordersList[$key]['orderdetailList'] = $orderdetailList;
        	//省
                $address = '';
                $provinceInfo = $this->Area_model->get('name', array('id'=>$order['province_id']));
                if ($provinceInfo) {
                    $address .= $provinceInfo['name'];
                }
                //市
                $cityInfo = $this->Area_model->get('name', array('id'=>$order['city_id']));
                if ($cityInfo) {
                    $address .= $cityInfo['name'];
                }
                $ordersList[$key]['address'] = $address.$order['address'];

            $exchange_info = $this->Exchange_model->get('status',array('orders_id' => $order['id']));
            if($exchange_info){
                $ordersList[$key]['exchange_status'] = $exchange_info['status'];
            }else{
                $ordersList[$key]['exchange_status'] = '';
            }
        }

		$data = array(
		             'tool'   =>$this->_tool,
                     'ordersList'  =>$ordersList,
		             'pagination'=>$pagination,
		             'paginationCount'=>$paginationCount,
		             'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		             'statusPrema'=>$status,
		             'status'=>$this->_status,
                     'exchange_status_arr' => $this->_exchange_status_arr,
		             'order_type_arr'=>$this->_order_type_arr,
		             );
	    $layout = array(
			      'title'=>$this->_title,
		              'content'=>$this->load->view('orders/index', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

    public function view($id = NULL) {
    	$prfUrl = $this->session->userdata('ordersRefUrl')?$this->session->userdata('ordersRefUrl'):base_url().'admincp.php/{$this->_table}/index/';
		$itemInfo = $this->tableObject->get('*', array('id'=>$id));
		if ($itemInfo) {
		    $itemInfo['userInfo'] = $this->User_model->get(array('user.id'=>$itemInfo['user_id']));
		    $productList = $this->Orders_detail_model->gets('*', array('order_id'=>$id));
		    $itemInfo['productList'] = $productList;
		    $sum = 0;
		    foreach ($productList as $product) {
		        $sum += $product['buy_number']*$product['buy_price'];
		    }
		    $itemInfo['productSum'] = $sum;
		    //省
            $address = '';
            $provinceInfo = $this->Area_model->get('name', array('id'=>$itemInfo['province_id']));
            if ($provinceInfo) {
                $address .= $provinceInfo['name'];
            }
            //市
            $cityInfo = $this->Area_model->get('name', array('id'=>$itemInfo['city_id']));
            if ($cityInfo) {
                $address .= $cityInfo['name'];
            }
            $itemInfo['address'] = $address.$itemInfo['address'];

            $exchange_info = $this->Exchange_model->get('status',array('orders_id' => $itemInfo['id']));
            if($exchange_info){
                $itemInfo['exchange_status'] = $exchange_info['status'];
            }else{
                $itemInfo['exchange_status'] = '';
            }
		}
		$ordersprocessList = $this->Orders_process_model->gets('*', array('order_id'=>$id));

		$data = array(
		        'tool'=>$this->_tool,
		        'itemInfo'=>$itemInfo,
		        'status'=>$this->_status,
                'exchange_status_arr' => $this->_exchange_status_arr,
		        'ordersprocessList'=>$ordersprocessList,
		        'deliveryTime'=>$this->_deliveryTime,
		        'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view('orders/view', $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

    public function delete() {
	    $ids = $this->input->post('ids', TRUE);

	    if (! empty($ids)) {
	        if ($this->tableObject->delete('id in ('.$ids.')')) {
	        	//删除订单详细
	        	$this->Orders_detail_model->delete("order_id in ({$ids})");
	        	//删除跟踪记录
	        	$this->Orders_process_model->delete("order_id in ({$ids})");
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('删除失败！');
	}

	//修改价格
    public function changePrice($id = NULL) {
    	$prfUrl = $this->session->userdata('ordersRefUrl')?$this->session->userdata('ordersRefUrl'):base_url().'admincp.php/{$this->_table}/index/1';
		if ($_POST) {
			$total = $this->input->post('total', TRUE);
		    if (! $this->form_validation->required($total)) {
	    		printAjaxError('修改价格不能为空！');
	    	}
		    if (! $this->form_validation->numeric($total)) {
	    		printAjaxError('修改价格必须为钱数！');
	    	}
	    	$count = $this->tableObject->rowCount(array('id'=>$id));
	    	if (!$count) {
	    	    printAjaxError('此订单不存在，修改价格失败！');
	    	}
			$fields = array(
			          'total'=>$total
			          );
		    if ($this->tableObject->save($fields, array('id'=>$id))) {
		    	$fields = array(
		    	    'add_time'=>time(),
		    	    'content'=>'修改价格成功',
		    	    'order_id'=>$id
		    	    );
		    	$this->Orders_process_model->save($fields);
				printAjaxSuccess($prfUrl, '修改价格成功！');
			} else {
				printAjaxError("修改价格失败！");
			}
		}

		$itemInfo = $this->tableObject->get('*', array('id'=>$id));

		$data = array(
		        'tool'=>$this->_tool,
		        'itemInfo'=>$itemInfo,
		        'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view('orders/changeprice', $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

    //交易关闭
    public function closeOrder($id = NULL) {
    	$prfUrl = $this->session->userdata('ordersRefUrl')?$this->session->userdata('ordersRefUrl'):base_url().'admincp.php/{$this->_table}/index/1';
		if ($_POST) {
			$cancelCause = $this->input->post('cancel_cause', TRUE);
		    if (! $this->form_validation->required($cancelCause)) {
	    		printAjaxError('请填写交易关闭的原因！');
	    	}
	    	$count = $this->tableObject->rowCount(array('id'=>$id));
	    	if (!$count) {
	    	    printAjaxError('此订单不存在，交易关闭失败！');
	    	}
			$fields = array(
			          'cancel_cause'=>$cancelCause,
			          'status'=>4
			          );
		    if ($this->tableObject->save($fields, array('id'=>$id))) {
		    	$fields = array(
		    	    'add_time'=>time(),
		    	    'content'=>'交易关闭',
		    	    'order_id'=>$id
		    	    );
		    	$this->Orders_process_model->save($fields);
				printAjaxSuccess($prfUrl, '交易关闭成功！');
			} else {
				printAjaxError("交易关闭失败！");
			}
		}

		$itemInfo = $this->tableObject->get('*', array('id'=>$id));

		$data = array(
		        'tool'=>$this->_tool,
		        'itemInfo'=>$itemInfo,
		        'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view('orders/closeorder', $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

//	//修改状态(备货中)
//	public function changeStatus() {
//	    $id = $this->input->post('id', TRUE);
//
//	    if ($id) {
//	        $fields = array(
//			          'status'=>2
//			          );
//		    if ($this->tableObject->save($fields, array('id'=>$id))) {
//		    	$fields = array(
//		    	    'add_time'=>time(),
//		    	    'content'=>'开始备货',
//		    	    'order_id'=>$id
//		    	    );
//		    	$this->Orders_process_model->save($fields);
//				printAjaxSuccess('', '操作成功！');
//			} else {
//				printAjaxError("操作失败！");
//			}
//	    }
//	}

    //修改状态(已付款)
	public function changeStatus2() {
	    $id = $this->input->post('id', TRUE);

	    if ($id) {
	        $fields = array(
			          'status'=>1
			          );
		    if ($this->tableObject->save($fields, array('id'=>$id))) {
		    	//财务记录
		    	$ordersInfo = $this->tableObject->get('user_id, total, order_number', array('id'=>$id));
		    	if (!$ordersInfo) {
		    	    printAjaxError("操作异常！");
		    	}
		    	$userInfo = $this->User_model->getInfo('username', array('id'=>$ordersInfo['user_id']));
		    	if (!$userInfo) {
		    	    printAjaxError("操作异常！");
		    	}
		    	$this->load->model('Financial_model', '', TRUE);
		    	$fFields = array(
		    	    'cause'=>"付款成功--{$ordersInfo['order_number']}",
		    	    'price'=>-$ordersInfo['total'],
		    	    'add_time'=>time(),
		    	    'username'=>$userInfo['username']
		    	     );
		    	$this->Financial_model->save($fFields);
		    	//订单跟踪记录
		    	$fields = array(
		    	    'add_time'=>time(),
		    	    'content'=>'付款成功',
		    	    'order_id'=>$id
		    	    );
		    	$this->Orders_process_model->save($fields);
				printAjaxSuccess('', '操作成功！');
			} else {
				printAjaxError("操作失败！");
			}
	    }
	}

	//发货
	public function delivery($id = NULL) {
	    $prfUrl = $this->session->userdata('ordersRefUrl')?$this->session->userdata('ordersRefUrl'):base_url().'admincp.php/{$this->_table}/index/';
		if ($_POST) {
			$deliveryName = $this->input->post('delivery_name', TRUE);
			$expressNumber = $this->input->post('express_number', TRUE);
		    if (! $this->form_validation->required($deliveryName)) {
	    		printAjaxError('快递名称不能为空！');
	    	}
		    if (! $this->form_validation->numeric($expressNumber)) {
	    		printAjaxError('快递单号不能为空！');
	    	}
            $item_info = $this->tableObject->get('user_id',array('id'=>$id));
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
		    if ($this->tableObject->save($fields, array('id'=>$id))) {
		    	$fields = array(
		    	    'add_time'=>time(),
		    	    'content'=>'发货成功',
		    	    'order_id'=>$id,
                    'change_status'=> 2
		    	    );
		    	$this->Orders_process_model->save($fields);
				printAjaxSuccess($prfUrl, '发货成功！');
			} else {
				printAjaxError("发货失败！");
			}
		}

		$itemInfo = $this->tableObject->get('*', array('id'=>$id));

		$data = array(
		        'tool'=>$this->_tool,
		        'itemInfo'=>$itemInfo,
		        'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view('orders/delivery', $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

    //收货
	public function receiving() {
		if ($_POST) {
			$id = $this->input->post('id', TRUE);

		    if (!$id) {
        		printAjaxError('fail', "操作异常，刷新重试");
        	}
        	$ordersInfo = $this->tableObject->get('id, user_id,status,score, order_number, divide_total, divide_store_price', array('id' =>$id));
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
			if ($this->tableObject->save($fields, array('id'=>$id))) {
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
					$productInfo = $this->Product_model->get2('stock, sales', array('id'=>$orderdetailInfo['product_id']));
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
}
/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */