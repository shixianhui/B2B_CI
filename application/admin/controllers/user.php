<?php
class User extends CI_Controller {
	private $_title = '会员管理';
	private $_tool = '';
	private $_table = '';

	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->_tool = $this->load->view('element/user_tool', '', TRUE);
		$this->load->model('User_group_model', '', TRUE);
		$this->load->model('Favorite_model', '', TRUE);
		$this->load->model('Area_model', '', TRUE);
		$this->load->model('Browse_model', '', TRUE);
		$this->load->library('pagination');
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
		$condition = "{$this->_table}.id > 0";
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):$condition;

	    if ($_POST) {
			$strWhere = $condition;

		    $categoryId = $this->input->post('category_id', TRUE);
		    $display = $this->input->post('display');
		    $startTime = $this->input->post('inputdate_start');
		    $endTime = $this->input->post('inputdate_end');
		    $id = trim($this->input->post('id', TRUE));
		    $username = trim($this->input->post('username', TRUE));
		    $real_name = trim($this->input->post('real_name', TRUE));
		    $mobile = trim($this->input->post('mobile', TRUE));
		    $nickname = trim($this->input->post('nickname', TRUE));

		    if ($id) {
		    	$strWhere .= " and {$this->_table}.id = '{$id}' ";
		    }
		    if ($username) {
		    	$strWhere .= " and {$this->_table}.username = '{$username}' ";
		    }
		    if ($real_name) {
		    	$strWhere .= " and {$this->_table}.real_name REGEXP '{$real_name}' ";
		    }
		    if ($mobile) {
		    	$strWhere .= " and {$this->_table}.mobile REGEXP '{$mobile}' ";
		    }
		    if ($nickname) {
		    	$strWhere .= " and {$this->_table}.nickname REGEXP '{$nickname}' ";
		    }
	        if ($categoryId) {
		        $strWhere .= " and {$this->_table}.user_group_id = '{$categoryId}' ";
		    }
		    if ($display != "") {
		        $strWhere .= " and {$this->_table}.display={$display} ";
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
    	$paginationConfig['base_url'] = base_url()."admincp.php/{$this->_table}/index/{$clear}/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 4;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$user_list = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
		$user_group_list = $this->User_group_model->gets();

		$data = array(
		              'tool'=>$this->_tool,
				      'clear'=>$clear,
		              'user_list'=>$user_list,
		              'user_group_list'=>$user_group_list,
		              'pagination'=>$pagination,
		              'paginationCount'=>$paginationCount,
		              'pageCount'=>ceil($paginationCount/$paginationConfig['per_page'])
		              );
	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view('user/index', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function select($clear = 0, $type = 0, $page = 0) {
		if ($clear) {
			$clear = 0;
			$this->session->unset_userdata(array('search'=>''));
		}
		$uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
		$uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/0/{$type}/{$page}";
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>$uri_sg));
		//只显示未推荐普通会员
		$condition = "{$this->_table}.id > 0 ";
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):$condition;
		if ($_POST) {
			$strWhere = $condition;

			$id = trim($this->input->post('id', TRUE));
			$username = trim($this->input->post('username', TRUE));
			$real_name = trim($this->input->post('real_name', TRUE));
			$mobile = trim($this->input->post('mobile', TRUE));
			$nickname = trim($this->input->post('nickname', TRUE));

			if ($id) {
				$strWhere .= " and {$this->_table}.id = '{$id}' ";
			}
			if ($username) {
				$strWhere .= " and {$this->_table}.username = '{$username}' ";
			}
			if ($real_name) {
				$strWhere .= " and {$this->_table}.real_name REGEXP '{$real_name}' ";
			}
			if ($mobile) {
				$strWhere .= " and {$this->_table}.mobile REGEXP '{$mobile}' ";
			}
			if ($nickname) {
				$strWhere .= " and {$this->_table}.nickname REGEXP '{$nickname}' ";
			}

			$this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationConfig = $this->config->item('pagination_config');
		$paginationCount = $this->tableObject->rowCount($strWhere);
		$paginationConfig['base_url'] = base_url()."admincp.php/{$this->_table}/select/{$clear}/";
		$paginationConfig['total_rows'] = $this->tableObject->rowCount($strWhere);
		$paginationConfig['uri_segment'] = 4;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$itemList = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);

		$data = array(
				'tool'=>$this->_tool,
				'clear'=>$clear,
				'type'=>$type,
				'itemList'=>$itemList,
				'pagination'=>$pagination,
				'paginationCount'=>$paginationCount,
				'pageCount'=>ceil($paginationCount/$paginationConfig['per_page'])
		);
		$layout = array(
				'title'=>$this->_title,
				'content'=>$this->load->view('user/select', $data, TRUE)
		);
		$this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
		$prfUrl = $this->session->userdata("{$this->_table}RefUrl")?$this->session->userdata("{$this->_table}RefUrl"):base_url()."admincp.php/{$this->_table}/index/1";
		if ($_POST) {
			$province_id = $this->input->post('province_id', TRUE);
			$city_id = $this->input->post('city_id', TRUE);
			$area_id = $this->input->post('area_id', TRUE);
			$txt_address = $this->input->post('txt_address', TRUE);
			$username = trim($this->input->post('username', TRUE));

			$fields = array(
			          'user_group_id'=>$this->input->post('user_group_id'),
			          'nickname'=>      $this->input->post('nickname', TRUE),
			          'real_name'=>     $this->input->post('real_name', TRUE),
			          'qq_number'=>     $this->input->post('qq_number', TRUE),
			          'wangwang_number'=>     $this->input->post('wangwang_number', TRUE),
			          'mobile'=>     $this->input->post('mobile', TRUE),
			          'phone'=>      $this->input->post('phone', TRUE),
			          'zip'=>        $this->input->post('zip', TRUE),
			          'address'=>    $this->input->post('address', TRUE),
			          'email'=>      $this->input->post('email', TRUE),
					  'province_id'=>$province_id?$province_id:0,
					  'city_id'=>    $city_id?$city_id:0,
					  'area_id'=>    $area_id?$area_id:0,
					  'txt_address'=>$txt_address
			          );
			if(!$id) {
				$fields['username'] = $username;
			}
		    $password = $this->input->post('password', TRUE);
			if ($id && $password) {
			      $fields['password'] = $this->tableObject->getPasswordSalt($username, $password);
			}
			if (!$id && $password) {
				$addTime = time();
				$fields['add_time'] = $addTime;
				$fields['login_time'] = $addTime;
				$fields['ip_address'] = '';
			    $fields['password'] = $this->createPasswordSALT($username, $addTime, $password);
			}
			if (empty($id)) {
			    if ($this->tableObject->validateUnique($this->input->post('username', TRUE))) {
			        printAjaxError("用户名已经存在，请换个用户名！");
			    }
			}

		    if ($this->tableObject->save($fields, $id?array('id'=>$id):$id)) {
		    	printAjaxSuccess($prfUrl);
			} else {
				printAjaxError("操作失败！");
			}
		}

		$user_info = $this->tableObject->get(array("{$this->_table}.id"=>$id));
		$item_list = $this->Area_model->gets('id, name', array('parent_id'=>0, 'display'=>1));
		$user_group_list = $this->User_group_model->gets();

	    $data = array(
		        'tool'=>$this->_tool,
	            'user_info'=>$user_info,
	    		'item_list'=>$item_list,
	    		'user_group_list'=>$user_group_list,
	    		'id'=>$id,
	            'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view('user/save', $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

	public function view($id = NULL) {
		$prfUrl = $this->session->userdata("{$this->_table}RefUrl")?$this->session->userdata("{$this->_table}RefUrl"):base_url()."admincp.php/{$this->_table}/index";
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		$user_info = $this->tableObject->get(array("{$this->_table}.id"=>$id));

		$data = array(
				'tool'=>$this->_tool,
				'id'=>$id,
				'user_info'=>$user_info,
				'prfUrl'=>$prfUrl
		);
		$layout = array(
				'title'=>$this->_title,
				'content'=>$this->load->view('user/view', $data, TRUE)
		);
		$this->load->view('layout/default', $layout);
	}

    //加盐算法
	private function createPasswordSALT($user, $salt, $password) {

	    return md5($user.$salt.$password);
	}

    public function category() {
	    $ids = $this->input->post('ids', TRUE);
		$categoryId = $this->input->post('categoryId', TRUE);

		if (! empty($ids) && ! empty($categoryId)) {
			if($this->tableObject->save(array('user_group_id'=>$categoryId), 'id in ('.$ids.')')) {
			    printAjaxSuccess('修改管理组成功！');
			}
		}

		printAjaxError('修改管理组失败！');
	}

    public function delete() {
	    $ids = $this->input->post('ids', TRUE);
	    //购物车
	    $this->load->model('Cart_model', '', TRUE);
	    if ($this->Cart_model->rowCount("user_id in ({$ids})")) {
	        printAjaxError('fail','购物车存在关联数据，删除失败！');
	    }
	    //退换货
	    $this->load->model('Exchange_model', '', TRUE);
	    if ($this->Exchange_model->rowCount("user_id in ({$ids})")) {
	        printAjaxError('fail','退换货存在关联数据，删除失败！');
	    }
	    //订单
	    $this->load->model('Orders_model', '', TRUE);
	    if ($this->Orders_model->rowCount("user_id in ({$ids})")) {
	        printAjaxError('fail','订单存在关联数据，删除失败！');
	    }
	    if (! empty($ids)) {
	        if ($this->tableObject->delete('id in ('.$ids.')')) {
	        	//浏览
	        	$this->Browse_model->delete("user_id in ({$ids}) and type = 'product'");
	        	//收藏
	        	$this->Favorite_model->delete("user_id in ({$ids})");
	        	//收货地址
	        	$this->load->model('User_address_model', '', TRUE);
	        	$this->User_address_model->delete("user_id in ({$ids})");

	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('删除失败！');
	}

	public function validateUnique() {
		$username = $this->input->post('username', TRUE);
		if (! empty($username)) {
		    if ($this->tableObject->validateUnique($username)) {
		        printAjaxError('用户名已经存在，请换个用户名！');
		    } else {
		        printAjaxSuccess('用户名可使用！');
		    }
		}
	}

    public function display() {
	    $ids = $this->input->post('ids');
		$display = $this->input->post('display');

		if (! empty($ids) && $display != "") {
			if($this->tableObject->save(array('display'=>$display), 'id in ('.$ids.')')) {
			    printAjaxSuccess('', '修改状态成功！');
			}
		}

		printAjaxError('修改状态失败！');
	}

	public function _delete_item() {
		if ($_POST) {
			$id = $this->input->post('id');
			if (!$id) {
				printAjaxError('fail', '操作异常');
			}

			$fields = array(
					'presenter_id'=>      0,
					'presenter_username'=>'',
					'remark_time'=>       0,
					'remark'=>            ''
			);
			if($this->tableObject->save($fields, array('id'=>$id))) {
				printAjaxSuccess('success', '操作成功');
			}

			printAjaxError('fail', '操作失败');
		}
	}

	public function get_city() {
		if ($_POST) {
			$parent_id = $this->input->post('parent_id', TRUE);
			$item_list = $this->Area_model->gets('id, name', array('parent_id'=>$parent_id, 'display'=>1));
			printAjaxData($item_list);
		}
	}

	public function user_login() {
		if ($_POST) {
			$username = trim($this->input->post('username', TRUE));
			$password = trim($this->input->post('password', TRUE));

			if(!$username || !$password) {
				printAjaxError('fail', '用户名或密码不能为空');
			}
			$item_info = $this->tableObject->getInfo('id, username, password', array('username'=>$username));
			if (!$item_info) {
				printAjaxError('fail', '登录失败');
			}
			if ($this->tableObject->getPasswordSalt($username, $password) != $item_info['password']) {
				printAjaxError('fail', '登录失败');
			}
			unset($item_info['password']);
			printAjaxData(array('item_info'=>$item_info));
		}
	}
}
/* End of file admin.php */
/* Location: ./application/admin/controllers/admin.php */