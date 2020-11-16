<?php
class Ad_group extends CI_Controller {
	private $_title = '广告位管理';
	private $_tool = '';
	private $_table = '';
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Ad_model', '', TRUE);
		//快捷方式
		$this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'广告管理', 'title'=>'广告位'), TRUE);
	}

	public function index() {
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		$item_list = $this->tableObject->gets();

		$data = array(
		                'tool'=>$this->_tool,
				        'table'=>$this->_table,
		                'item_list'=>$item_list
		                );
	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/index", $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
		$prfUrl = $this->session->userdata("{$this->_table}RefUrl")?$this->session->userdata("{$this->_table}RefUrl"):base_url()."admincp.php/{$this->_table}/index";
		if ($_POST) {
		    $fields = array(
		    		'group_name'=>$this->input->post('group_name', TRUE)
		    );
		    if ($this->tableObject->save($fields, $id?array('id'=>$id):$id)) {
		    	printAjaxSuccess($prfUrl);
			} else {
				printAjaxError('fail', "操作失败！");
			}
		}

		$item_info = $this->tableObject->get('*', array('id'=>$id));

	    $data = array(
		        'tool'=>$this->_tool,
	            'item_info'=>$item_info,
	            'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/save", $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

    public function delete() {
    	if ($_POST) {
    		$ids = $this->input->post('ids', TRUE);

    		if (! empty($ids)) {
    			if ($this->Ad_model->rowCount("ad.category_id in ({$ids})")) {
    				printAjaxError('fail', '在[广告内容管]理存在关联数据，删除失败');
    			}
    			if ($this->tableObject->delete('id in ('.$ids.')')) {
    				printAjaxData(array('ids'=>explode(',', $ids)));
    			}
    		}

    		printAjaxError('fail', '删除失败！');
    	}
	}
}
/* End of file admingroup.php */
/* Location: ./application/admin/controllers/admingroup.php */