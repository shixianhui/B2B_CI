<?php
class Fabric extends CI_Controller {
	private $_title = '面料管理';
	private $_tool = '';
	private $_table = '';
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'商品管理', 'title'=>'面料'), TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
	}

	public function index() {
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		$strWhere = array('display'=>1);
	    if ($_POST) {
			$strWhere = "{$this->_table}.id > 0";
			$brand_category_id = $this->input->post('brand_category_id', true);

		    if (! empty($brand_category_id) ) {
		        $strWhere .= " and {$this->_table}.brand_category_id = {$brand_category_id} ";
		    }
		}

		$item_list = $this->tableObject->gets($strWhere);

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

	public function index_0() {
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));

		$item_list = $this->tableObject->gets(array('display'=>0));

		$data = array(
				'tool'=>$this->_tool,
				'table'=>$this->_table,
				'item_list'=>$item_list
		);
		$layout = array(
				'title'=>$this->_title,
				'content'=>$this->load->view("{$this->_table}/index_0", $data, TRUE)
		);
		$this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
		$prfUrl = $this->session->userdata("{$this->_table}RefUrl")?$this->session->userdata("{$this->_table}RefUrl"):base_url()."admincp.php/{$this->_table}/index";
		if ($_POST) {
		    if ($id != NULL) {
		    	$fabric_name = trim($this->input->post('fabric_name', TRUE));
		    	$tag = trim($this->input->post('tag', TRUE));
				$fields = array(
				          'fabric_name'=>  $fabric_name,
						  'tag'=>         $tag,
		    		      'sort'=>        $this->input->post('sort', TRUE)
				          );
			    if ($this->tableObject->save($fields, array('id'=>$id))) {
					printAjaxSuccess($prfUrl);
				} else {
					printAjaxError("操作失败！");
				}
			} else {
				$i = 0;
				$tag = trim($this->input->post('tag', TRUE));
				$fabric_name = $this->input->post('fabric_name', TRUE);
				$sort = $this->input->post('sort', TRUE);
				$fabric_name = preg_replace(array('/^\|+/', '/\|+$/'), array('', ''), $fabric_name);
				$fabric_name_arr = explode("|", $fabric_name);
				foreach ($fabric_name_arr as $key=>$value) {
					$fields = array(
				          'sort'=>$sort+$key,
						  'tag'=>         $tag,
				          'fabric_name'=>trim($value)
				          );
			         if ($this->tableObject->save($fields)) {
			             $i++;
			         }
				}
				if (count($fabric_name_arr) == $i) {
				    printAjaxSuccess($prfUrl);
				} else {
				    printAjaxError("操作失败！");
				}
			}
		}

		$item_info = $this->tableObject->get('*', array("{$this->_table}.id"=>$id));

	    $data = array(
		        'tool'=>$this->_tool,
	            'item_info'=>$item_info,
	    		'table'=>$this->_table,
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
	        if ($this->tableObject->delete("id in ($ids)")) {
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('删除失败！');
	}

    public function sort() {
		$ids = $this->input->post('ids', TRUE);
		$sorts = $this->input->post('sorts', TRUE);

		if (! empty($ids) && ! empty($sorts)) {
			$ids = explode(',', $ids);
			$sorts = explode(',', $sorts);

			foreach ($ids as $key=>$value) {
				$this->tableObject->save(
				                   array('sort'=>$sorts[$key]),
				                   array('id'=>$value));
			}
			printAjaxSuccess('', '排序成功！');
		}
		printAjaxError('排序失败！');
	}

	public function display() {
		$ids = $this->input->post('ids');
		$display = $this->input->post('display');

		if (! empty($ids) && $display != "") {
			if($this->tableObject->save(array('display'=>$display), 'id in ('.$ids.')')) {
				printAjaxSuccess('', '修改状态成功！');
			}
		}

		printAjaxError('fail', '修改状态失败！');
	}
}
/* End of file admingroup.php */
/* Location: ./application/admin/controllers/admingroup.php */