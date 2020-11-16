<?php
class Score extends CI_Controller {
	private $_title = '会员积分消费记录';
	private $_score_type_arr = array('login_score_in'=>'每日登录奖励','reg_score_in'=>'新用户注册','luck_in'=>'抽奖获得','luck_out'=>'抽奖花掉','product_in'=>'购物获得','store_score_in'=>'绑定邀请码');
	private $_tool = '';
	private $_table = '';
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view("element/score_tool", NULL, TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('User_model', '', TRUE);
	}

	public function index($clear = 0, $userId = 0, $page = 0) {
	    if ($clear) {
	    	$clear = 0;
		    $this->session->unset_userdata(array('search'=>''));
		}
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		$contion = NULL;
		if ($userId) {
			$userInfo = $this->User_model->getInfo('username', array('id'=>$userId));
		    $contion = "{$this->_table}.username = '{$userInfo['username']}' ";
		}
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):$contion;

		if ($_POST) {
			$strWhere = "{$this->_table}.id > 0";

			$user_id = trim($this->input->post('user_id', TRUE));
			$username = trim($this->input->post('username', TRUE));
		    $startTime = $this->input->post('inputdate_start');
		    $endTime = $this->input->post('inputdate_end');

		    if (! empty($user_id) ) {
		    	$strWhere .= " and user_id = '{$user_id}'";
		    }
		    if (! empty($username) ) {
		        $strWhere .= " and username = '{$username}'";
		    }
		    if (! empty($startTime) && ! empty($endTime)) {
		    	$strWhere .= " and add_time > ".strtotime($startTime.' 00:00:00')." and add_time < ".strtotime($endTime.' 23:59:59').' ';
		    }
		    $this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationCount = $this->tableObject->rowCount($strWhere);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationConfig['base_url'] = base_url()."admincp.php/{$this->_table}/index/{$clear}/{$userId}/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 5;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$itemList = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
		$count0 = 0;
		$count1 = 0;
		$sumprice0 = 0;
		$sumprice1 = 0;
		foreach ($itemList as $item) {
			//支付
		    if ($item['score'] < 0) {
		        $count1++;
		        $sumprice1+=$item['score'];
		    } else {
		        $count0++;
		        $sumprice0+=$item['score'];
		    }
		}

		$data = array(
		        'tool'      =>$this->_tool,
				'itemList'  =>$itemList,
		        'pagination'=>$pagination,
		        'paginationCount'=>$paginationCount,
		        'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		        'count0'=>$count0,
		        'count1'=>$count1,
		        'sumprice0'=>$sumprice0,
		        'sumprice1'=>$sumprice1,
				'score_type_arr'=>$this->_score_type_arr,
		        'table'=>$this->_table
		        );

	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view($this->_table.'/index', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}
}
/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */