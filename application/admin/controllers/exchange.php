<?php
class Exchange extends CI_Controller {
	private $_title = '退换货管理';
	private $_tool = '';
	private $_table = '';
    private $_exchange_reason_arr = array(
        '0'=>'无理由退货',
        '1'=>'不需要/不想的商品',
        '2'=>'其它'
    );
    private $_status_arr = array(
        '0'=>'<font color="red">待审核</font>',
        '1'=>'审核未通过',
        '2'=>'审核通过',
        '3'=>'退款到余额成功',
        '4'=>'原路返回退款成功'
    );
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view("element/save_list_tool", array('table' => $this->_table, 'parent_title' => '交易管理', 'title' => '退换货申请'), TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('Orders_model', '', TRUE);
		$this->load->model('Financial_model', '', TRUE);
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Attachment_model', '', TRUE);
		$this->load->model('Pay_log_model', '', TRUE);
		$this->load->model('Orders_process_model', '', TRUE);
	}

	public function index($clear = 0, $page = 0) {
	   clearSession(array('search'));
		if ($clear) {
			$clear = 0;
		    $this->session->unset_userdata(array('search'=>''));
		}
		$uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
		$uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/{$clear}/{$page}";
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>$uri_sg));
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):NULL;

		if ($_POST) {
			$strWhere = "{$this->_table}.id > 0";
            $order_num = $this->input->post('order_num');
            $username = $this->input->post('username');
            $status = $this->input->post('status');
		    $startTime = $this->input->post('inputdate_start');
		    $endTime = $this->input->post('inputdate_end');

		    if (! empty($order_num) ) {
		        $strWhere .= " and {$this->_table}.order_num = '{$order_num}' ";
		    }
		    if (! empty($username) ) {
		        $strWhere .= " and {$this->_table}.username like '%".$username."%'";
		    }
		    if ($status != "") {
		        $strWhere .= " and {$this->_table}.status={$status} ";
		    }
		    if (! empty($startTime) && ! empty($endTime)) {
		    	$strWhere .= ' and add_time > '.strtotime($startTime.' 00:00:00').' and add_time < '.strtotime($endTime.' 23:59:59').' ';
		    }
		    $this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationCount = $this->tableObject->rowCount($strWhere);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationConfig['base_url'] = base_url()."admincp.php/{$this->_table}/index/{$clear}/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 4;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$item_list = $this->tableObject->gets('*', $strWhere, $paginationConfig['per_page'], $page);

		$data = array(
		        'tool'      =>$this->_tool,
				'item_list'  =>$item_list,
		        'pagination'=>$pagination,
		        'paginationCount'=>$paginationCount,
		        'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		        'table'=>$this->_table,
                'exchange_reason_arr'=>$this->_exchange_reason_arr,
                'status_arr'=>$this->_status_arr,
				'clear'=>$clear
		        );

	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/index", $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
        $prfUrl = $this->session->userdata($this->_table.'RefUrl')?$this->session->userdata($this->_table.'RefUrl'):base_url()."admincp.php/{$this->_table}/index/";
        $this->session->set_userdata(array("ordersRefUrl"=>base_url().'admincp.php/'.uri_string()));
        $this->session->set_userdata(array("userRefUrl"=>base_url().'admincp.php/'.uri_string()));
        $item_info = $this->tableObject->get('*', array('id'=>$id));
        //凭证图片
        $attachment_list = NULL;
        if ($item_info && $item_info['batch_path_ids']) {
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }
        $payment_title = '';
        if ($item_info) {
            $orders_info = $this->Orders_model->get('payment_id, payment_title', array('id'=>$item_info['orders_id']));
            if ($orders_info) {
                $payment_title = $orders_info['payment_title'];
            }
            $item_info['payment_title'] = $payment_title;
        }


        $data = array(
            'tool'=>$this->_tool,
            'table'=>$this->_table,
            'item_info'=>$item_info,
            'orders_info'=>$orders_info,
            'status_arr'=>$this->_status_arr,
            'exchange_reason_arr'=>$this->_exchange_reason_arr,
            'attachment_list'=>$attachment_list,
            'prfUrl'=>$prfUrl
        );
        $layout = array(
            'title'=>$this->_title,
            'content'=>$this->load->view("{$this->_table}/save", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
	}

    public function delete() {
	    $ids = $this->input->post('ids', TRUE);

	    if (! empty($ids)) {
	        if ($this->tableObject->delete('id in ('.$ids.')')) {
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('删除失败！');
	}

    public function change_check() {
        if($_POST) {
            $id = $this->input->post('id', TRUE);
            $status = $this->input->post('status', TRUE);
            $client_remark = $this->input->post('client_remark', TRUE);
            $admin_remark = $this->input->post('admin_remark', TRUE);

            if (!$id) {
                printAjaxError('fail', '操作异常');
            }
            $item_info = $this->tableObject->get('*', array('id'=>$id));
            if (!$item_info) {
                printAjaxError('fail', '此退款信息不存在');
            }
//            if ($item_info['status'] != 0) {
//                printAjaxError('fail', '此退款状态异常');
//            }
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
            if (!$this->tableObject->save($fields, array('id'=>$item_info['id']))) {
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
            $item_info = $this->tableObject->get('*', array('id'=>$id));
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
                $user_info = $this->User_model->get(array('user.id'=>$orders_info['user_id']));
                if (!$user_info) {
                    printAjaxError('fail', '买家信息不存在，退款失败');
                }
                $this->_balance_trade_refund(NULL, $item_info, $orders_info, $user_info, 3);
            }
            //支付宝
            else if ($orders_info['payment_id'] == 2) {
                $pay_log_info = $this->Pay_log_model->get(array('pay_log.out_trade_no'=>$orders_info['out_trade_no'], 'pay_log.payment_type'=>'alipay', 'pay_log.order_type'=>'orders'));
                if (!$pay_log_info) {
                    printAjaxError('fail', '支付记录不存在，退款失败');
                }
                if ($pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_FINISHED') {
                    printAjaxError('fail', '订单未付款，退款失败');
                }
                $user_info = $this->User_model->get(array('user.id'=>$orders_info['user_id']));
                if (!$user_info) {
                    printAjaxError('fail', '买家信息不存在，退款失败');
                }
                $this->_balance_trade_refund(NULL, $item_info, $orders_info, $user_info, 3);
            }
            //微信
            else if ($orders_info['payment_id'] == 3) {
                $pay_log_info = $this->Pay_log_model->get(array('pay_log.out_trade_no'=>$orders_info['out_trade_no'], 'pay_log.payment_type'=>'weixin', 'pay_log.order_type'=>'orders'));
                if (!$pay_log_info) {
                    printAjaxError('fail', '支付记录不存在，退款失败');
                }
                if ($pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_FINISHED') {
                    printAjaxError('fail', '订单未付款，退款失败');
                }
                $user_info = $this->User_model->get(array('user.id'=>$orders_info['user_id']));
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
        $this->tableObject->save(array('status'=>$status, 'update_time'=>time()), array('id'=>$item_info['id']));
        printAjaxSuccess('success', '退款成功');

    }
}
/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */