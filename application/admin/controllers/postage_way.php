<?php
class Postage_way extends CI_Controller {
	private $_title = '配送方式管理';
	private $_tool = '';
	private $_table = '';
	private $_display_arr = array('0'=>'<font color="#FF0000">隐藏</font>', '1'=>'显示');

	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'系统设置', 'title'=>'配送方式'), TRUE);
		$this->load->model('Postage_price_model', '', TRUE);
		$this->load->model('Area_model', '', TRUE);
		$this->load->model('Store_model', '', TRUE);
		$this->load->library('pagination');
	}

	public function index() {
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		$item_list = $this->tableObject->gets();
		if ($item_list) {
		   foreach ($item_list as $key=>$postageway) {
		   	   $store_info = $this->Store_model->get2('store_name', array('id'=>$postageway['store_id']));
		   	   if ($store_info) {
		   	       $item_list[$key]['store_name'] = $store_info['store_name'];
		   	   } else {
		   	   	    $item_list[$key]['store_name'] = '';
		   	   }
		       $item_list[$key]['postagepriceList'] = $this->Postage_price_model->gets('*', array('postage_way_id'=>$postageway['id']));
		   }
		}

		$data = array(
		              'tool'=>$this->_tool,
				      'table'=>$this->_table,
				      'display_arr'=>$this->_display_arr,
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
			$areaNames = $this->input->post('area_name');
			$start_val = $this->input->post('start_val', TRUE);
			$startPrices = $this->input->post('start_price');
			$add_val = $this->input->post('add_val', TRUE);
			$addPrices = $this->input->post('add_price');
			$payer = $this->input->post('payer', TRUE);
			$charging_mode = $this->input->post('charging_mode', TRUE);
			$province_id = $this->input->post('province_id', TRUE);
			$city_id = $this->input->post('city_id', TRUE);
			$area_id = $this->input->post('area_id', TRUE);
			$txt_address = $this->input->post('txt_address', TRUE);
			$store_id = $this->input->post('store_id', TRUE);

		    $fields = array(
			          'title'=>$this->input->post('title', TRUE),
		              'sort'=>$this->input->post('sort'),
		              'content'=>$this->input->post('content', TRUE),
		    		  'payer'=>            $payer,
		    		  'charging_mode'=>    $charging_mode,
		    		  'province_id'=>      $province_id?$province_id:0,
		    		  'city_id'=>          $city_id?$city_id:0,
		    		  'area_id'=>          $area_id?$area_id:0,
		    		  'txt_address'=>      $txt_address,
		    		  'store_id'=>         $store_id
			          );
			$retId = $this->tableObject->save($fields, $id?array('id'=>$id):$id);
		    if ($retId) {
		    	//修改时删除原来所有的
		    	if ($id) {
		    		$this->Postage_price_model->delete(array('postage_way_id'=>$id));
		    	}
		    	//添加数据
		    	if ($areaNames) {
				    foreach ($areaNames as $key=>$areaName) {
				        $data = array(
					    	    'postage_way_id'=>$id?$id:$retId,
					    	    'area'=>$areaNames[$key],
				        		'start_val'=>$start_val[$key],
					    	    'start_price'=>$startPrices[$key],
				        		'add_val'=>$add_val[$key],
					    	    'add_price'=>$addPrices[$key]
					    	     );
					    $this->Postage_price_model->save($data);
				    }
		    	}
		    	printAjaxSuccess($prfUrl, '操作成功');
			} else {
				printAjaxError("操作失败！");
			}
		}

		$item_info = $this->tableObject->get('*', array('id'=>$id));
		if ($item_info) {
			$item_info['postagepriceList'] = $this->Postage_price_model->gets('*', array('postage_way_id'=>$id));
		}
		$areaList = $this->Area_model->gets('*', array('parent_id'=>0));

	    $data = array(
		        'tool'=>$this->_tool,
	            'item_info'=>$item_info,
	            'areaList'=>$areaList,
	    		'area_list'=>$areaList,
	            'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/save", $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
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

    public function delete() {
	    $ids = $this->input->post('ids', TRUE);
	    if (! empty($ids)) {
	        if ($this->tableObject->delete('id in ('.$ids.')')) {
	        	//同时删除关联项
	        	$this->Postage_price_model->delete("postage_way_id in ({$ids})");
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('删除失败！');
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
}
/* End of file link.php */
/* Location: ./application/admin/controllers/link.php */