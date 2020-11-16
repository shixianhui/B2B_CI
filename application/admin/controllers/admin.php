<?php
class Admin extends CI_Controller {
	private $_title = '管理员管理';
	private $_tool = '';
	private $_table = 'admin';

	public function __construct() {
		parent::__construct();
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->_tool = $this->load->view("element/save_list_tool", array('table' => $this->_table, 'parent_title' => '员工管理', 'title' => '员工'), TRUE);
		$this->load->model('Admin_group_model', '', TRUE);
		$this->load->model('Systemloginlog_model', '', TRUE);
		$this->load->library('Securitysecoderclass');
	}

	public function index($clear = 0, $page = 0) {
	    checkPermission("{$this->_table}_index");
	    clearSession(array('search'));
	    if ($clear) {
	    	$clear = 0;
	    	$this->session->unset_userdata(array('search'=>''));
	    }
	    $uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
	    $uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/{$clear}/{$page}";
	    $this->session->set_userdata(array("{$this->_table}RefUrl"=>$uri_sg));
	    $strWhere = $this->session->userdata('search')?$this->session->userdata('search'):NULL;

		$condition = '';
		$fields = '';
		if ($_POST) {
		    $condition = $this->input->post('condition', TRUE);
		    $fields = $this->input->post('fields', TRUE);

		    $strWhere = "{$this->_table}.`{$condition}` REGEXP '{$fields}'";

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

		$item_list = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
		$admingroup_list = $this->Admin_group_model->gets();

		$data = array(
		              'tool'=>$this->_tool,
		              'admingroup_list'=>$admingroup_list,
		              'item_list'=>$item_list,
		              'pagination'=>$pagination,
		              'paginationCount'=>$paginationCount,
		              'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		              'table'=>$this->_table,
		              'condition'=>$condition,
		              'fields'=>$fields
		              );
	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/index", $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
	    if ($id) {
	        checkPermission("{$this->_table}_edit");
	    } else {
	        checkPermission("{$this->_table}_add");
	    }

		$prfUrl = $this->session->userdata("{$this->_table}RefUrl")?$this->session->userdata("{$this->_table}RefUrl"):base_url()."admincp.php/{$this->_table}/index";
		if ($_POST) {
			$username = $this->input->post('username', TRUE);

			$fields = array(
			          'admin_group_id'=>$this->input->post('admin_group_id'),
			          'username'=>      $username,
					  'is_boss'=>       $this->input->post('is_boss', TRUE),
			          'nickname'=>      $this->input->post('nickname', TRUE),
			          'real_name'=>     $this->input->post('real_name', TRUE),
			          'qq_number'=>     $this->input->post('qq_number', TRUE),
			          'email'=>         $this->input->post('email', TRUE)
			          );
		    $password = $this->input->post('password', TRUE);
			if ($password) {
				  $addTime = time();
				  $fields['add_time'] = $addTime;
			      $fields['password'] = $this->createPasswordSALT($username, $addTime, $password);
			}
			if (empty($id)) {
			    if ($this->tableObject->validateUnique($this->input->post('username', TRUE))) {
			        printAjaxError('fail', "用户名已经存在，请换个用户名！");
			    }
			}

		    if ($this->tableObject->save($fields, $id?array('id'=>$id):$id)) {
		    	printAjaxSuccess($prfUrl);
			} else {
				printAjaxError('fail', "操作失败！");
			}
		}

		$admingroup_list = $this->Admin_group_model->gets();
		$item_info = $this->tableObject->get(array($this->_table.'.id'=>$id));

	    $data = array(
		        'tool'=>$this->_tool,
	            'item_info'=>$item_info,
	            'admingroup_list'=>$admingroup_list,
	            'table'=>$this->_table,
	            'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/save", $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

    public function category() {
        checkPermissionAjax("{$this->_table}_edit");
        if ($_POST) {
        	$ids = $this->input->post('ids', TRUE);
        	$categoryId = $this->input->post('categoryId', TRUE);

        	if (! empty($ids) && ! empty($categoryId)) {
        		if($this->tableObject->save(array('admin_group_id'=>$categoryId), 'id in ('.$ids.')')) {
        			printAjaxSuccess('success', '修改管理组成功！');
        		}
        	}

        	printAjaxError('fail', '修改管理组失败！');
        }
	}

    public function delete() {
        checkPermissionAjax("{$this->_table}_delete");
        if ($_POST) {
        	$ids = $this->input->post('ids', TRUE);

        	if (! empty($ids)) {
        		if ($this->tableObject->delete('id in ('.$ids.')')) {
        			printAjaxData(array('ids'=>explode(',', $ids)));
        		}
        	}

        	printAjaxError('fail', '删除失败！');
        }
	}

	public function login() {
		if ($_POST) {
			$username = $this->input->post('username', TRUE);
			$password = $this->input->post('password', TRUE);
			$code = $this->input->post('code', TRUE);

			if (!$username) {
			    $data = array(
			        'msg'=>'请输入用户名',
			        'url'=>'admincp.php/admin/login'
			    );
			    $this->session->set_userdata($data);
			    redirect('/message/index');
			}
			if (!$password) {
			    $data = array(
			        'msg'=>'请输入密码',
			        'url'=>base_url().'admincp.php/admin/login'
			    );
			    $this->session->set_userdata($data);
			    redirect('/message/index');
			}
			if (!$code) {
			    $data = array(
			        'msg'=>'请输入验证码',
			        'url'=>base_url().'admincp.php/admin/login'
			    );
			    $this->session->set_userdata($data);
			    redirect('/message/index');
			}
			$securitysecoder = new Securitysecoderclass();
			if (! $securitysecoder->check($code)) {
			    $data = array(
			        'msg'=>'验证码错误',
			        'url'=>base_url().'admincp.php/admin/login'
			    );
			    $this->session->set_userdata($data);
			    redirect('/message/index');
			}
			$adminInfo = $this->tableObject->login($username, $password);
		    if ($adminInfo) {
		        $ip_arr = getUserIPAddress();
		        $fields = array(
		            'ip'=>     $ip_arr[0],
		            'address'=>$ip_arr[1],
		            'add_time'=>time(),
		            'admin_id'=>$adminInfo['id']
		            );
		        if ($this->Systemloginlog_model->save($fields)) {
		            $this->tableObject->save(array('ip'=>$ip_arr[0], 'ip_address'=>$ip_arr[1]), array('id'=>$adminInfo['id']));
		        }
		    	$this->_setCookie($adminInfo);
		        redirect('/menu');
		    } else {
		    	$data = array(
		                'msg'=>'登录失败!',
		                'url'=>base_url().'admincp.php/admin/login'
		                );
			    $this->session->set_userdata($data);
		        redirect('/message/index');
		    }
		}
		if ($this->session->userdata('username')) {
		    redirect('/menu');
		}

	    $this->load->view('admin/login');
	}

	public function logout() {
	    $this->_deleteCookie();
	    redirect('/menu');
	}

	public function validateUnique() {
		$username = $this->input->post('username', TRUE);
		if (! empty($username)) {
		    if ($this->tableObject->validateUnique($username)) {
		        printAjaxError('fail', '', '用户名已经存在，请换个用户名！');
		    } else {
		        printAjaxSuccess('success', '用户名可使用！');
		    }
		}
	}

	//加盐算法
	public function createPasswordSALT($user, $salt, $password) {

	    return md5($user.$salt.$password);
	}

    private function _deleteCookie() {
		delete_cookie('admin_id');
		delete_cookie('admin_username');
		delete_cookie('admin_nickname');
		delete_cookie('admin_group_name');
		delete_cookie('admin_ip');
		delete_cookie('admin_ip_address');
	}

	private function _setCookie($data) {
	    $cookie1 = array(
                   'name'  =>'admin_id',
                   'value' =>$data['id'],
                   'expire'=>0
                   );
		set_cookie($cookie1);

		$cookie2 = array(
                   'name'  =>'admin_username',
                   'value' =>$data['username'],
                   'expire'=>0
                   );
		set_cookie($cookie2);

		$cookie3 = array(
                   'name'  =>'admin_group_name',
                   'value' =>$data['group_name'],
                   'expire'=>0
                   );
		set_cookie($cookie3);

		$cookie7 = array(
		    'name'  =>'admin_group_id',
		    'value' =>$data['admin_group_id'],
		    'expire'=>0
		);
		set_cookie($cookie7);

		$cookie4 = array(
                   'name'  =>'admin_nickname',
                   'value' =>$data['nickname'],
                   'expire'=>0
                   );
		set_cookie($cookie4);

		$cookie5 = array(
		    'name'  =>'admin_ip',
		    'value' =>$data['ip'],
		    'expire'=>0
		);
		set_cookie($cookie5);

		$cookie6 = array(
		    'name'  =>'admin_ip_address',
		    'value' =>$data['ip_address'],
		    'expire'=>0
		);
		set_cookie($cookie6);
	}
}
/* End of file admin.php */
/* Location: ./application/admin/controllers/admin.php */