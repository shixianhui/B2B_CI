<?php
class Link extends CI_Controller {
	private $_title = '友情链接';
	private $_tool = '';
	private $_table = '';
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view("element/save_list_tool", array('table' => $this->_table, 'parent_title' => '网站管理', 'title' => '友情链接'), TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Menu_model', '', TRUE);
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
		if ($_POST) {
		    $strWhere = "{$this->_table}.id > 0 ";
		    $siteName = $this->input->post('site_name', TRUE);
		    $category_id = $this->input->post('category_id');
		    $link_type = $this->input->post('link_type', TRUE);
		    $display = $this->input->post('display');

		    if ($siteName) {
		        $strWhere .= " and {$this->_table}.site_name REGEXP '{$siteName}' ";
		    }
		    if (! empty($category_id) ) {
		        $strWhere .= " and {$this->_table}.category_id = {$category_id} ";
		    }
		    if ($link_type) {
		        $strWhere .= " and {$this->_table}.link_type = '{$link_type}' ";
		    }
		    if ($display != "") {
		        $strWhere .= " and {$this->_table}.display={$display} ";
		    }
		    $this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationCount = $this->tableObject->rowCount($strWhere);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationConfig['base_url'] = base_url()."admincp.php/{$this->_table}/index/{$clear}";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 4;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$menu_list = $this->Menu_model->menuTree('id, menu_name', $this->_table);
		$item_list = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);

		$data = array(
		        'tool'      =>$this->_tool,
				'item_list'  =>$item_list,
		        'pagination'=>$pagination,
		        'paginationCount'=>$paginationCount,
		        'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		        'table'=>$this->_table,
				'clear'=>$clear,
		        'menu_list'=>$menu_list
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
		$prfUrl = $this->session->userdata($this->_table.'RefUrl')?$this->session->userdata($this->_table.'RefUrl'):base_url()."admincp.php/{$this->_table}/index/";
		if ($_POST) {
		    $fields = array(
			          'site_name'=>  $this->input->post('site_name', TRUE),
			          'url'=>        $this->input->post('url', TRUE),
			          'sort'=>       $this->input->post('sort'),
			          'link_type'=>  $this->input->post('link_type', TRUE),
			          'description'=>$this->input->post('description', TRUE),
		              'qq'=>         $this->input->post('qq', TRUE),
		              'email'=>      $this->input->post('email', TRUE),
		              'category_id'=>$this->input->post('category_id'),
		              'path'=>       $this->input->post('path')
			          );
		    if ($this->tableObject->save($fields, $id?array('id'=>$id):$id)) {
				printAjaxSuccess($prfUrl);
			} else {
				printAjaxError('fail', "操作失败！");
			}
		}

		$item_info = $this->tableObject->get('*', array('id'=>$id));
		$menu_list = $this->Menu_model->menuTree('id, menu_name', $this->_table);

	    $data = array(
		        'tool'=>$this->_tool,
		        'menu_list'=>$menu_list,
		        'table'=>$this->_table,
		        'item_info'=>$item_info,
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
        	$category_id = $this->input->post('categoryId', TRUE);

        	if (! empty($ids) && ! empty($category_id)) {
        		if($this->tableObject->save(array('category_id'=>$category_id), 'id in ('.$ids.')')) {
        			printAjaxSuccess('success', '修改分类成功！');
        		}
        	}

        	printAjaxError('fail', '修改分类失败！');
        }
	}

    public function display() {
        checkPermissionAjax("{$this->_table}_edit");
        if ($_POST) {
        	$ids = $this->input->post('ids');
        	$display = $this->input->post('display');

        	if (! empty($ids) && $display != "") {
        		if($this->tableObject->save(array('display'=>$display), 'id in ('.$ids.')')) {
        			printAjaxSuccess('success', '修改状态成功！');
        		}
        	}

        	printAjaxError('fail', '修改状态失败！');
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
}
/* End of file link.php */
/* Location: ./application/admin/controllers/link.php */