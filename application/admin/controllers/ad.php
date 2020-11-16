<?php
class Ad extends CI_Controller {
	private $_title = '广告管理';
	private $_ad_type_arr = array('image'=>'图片广告', 'flash'=>'<font color="#077ac7">Flash广告</font>', 'html'=>'<font color="#ff0000">Html广告</font>', 'text'=>'<font color="#e76e24">文字广告</font>');
	private $_tool = '';
	private $_table = '';
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		//快捷方式
		$this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'广告管理', 'title'=>'广告内容'), TRUE);
		$this->load->model('Ad_group_model', '', TRUE);
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
			$strWhere = "{$this->_table}.id > 0 ";
		    $category_id = $this->input->post('category_id', TRUE);
		    $ad_type = $this->input->post('ad_type', TRUE);

		    if ($category_id) {
		        $strWhere .= " and {$this->_table}.category_id = {$category_id} ";
		    }
		    if ($ad_type) {
		        $strWhere .= " and {$this->_table}.ad_type = '{$ad_type}' ";
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

		$ad_list = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);

		$ad_group_list = $this->Ad_group_model->gets();

		$data = array(
		              'tool'=>$this->_tool,
				      'table'=>$this->_table,
		              'ad_list'=>$ad_list,
		              'ad_type_arr'=>$this->_ad_type_arr,
		              'ad_group_list'=>$ad_group_list,
		              'pagination'=>$pagination,
		              'paginationCount'=>$paginationCount,
		              'pageCount'=>ceil($paginationCount/$paginationConfig['per_page'])
		              );
	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/index", $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
		$prfUrl = $this->session->userdata("{$this->_table}RefUrl")?$this->session->userdata("{$this->_table}RefUrl"):base_url()."admincp.php/{$this->_table}/index/1";
		if ($_POST) {
		    $fields = array(
			          'ad_type'=>    $this->input->post('ad_type'),
			          'content'=>    unhtml($this->input->post('content')),
			          'width'=>      $this->input->post('width'),
			          'height'=>     $this->input->post('height'),
			          'display'=>     $this->input->post('display'),
		              'category_id'=>$this->input->post('category_id'),
		              'path'=>       $this->input->post('path', TRUE),
		              'ad_text'=>    $this->input->post('ad_text', TRUE),
		              'url'=>        $this->input->post('url'),
		              'app_url'=>        $this->input->post('app_url'),
		              'xcx_url'=>        $this->input->post('xcx_url')
			          );
		    if ($this->tableObject->save($fields, $id?array('id'=>$id):$id)) {
		    	printAjaxSuccess($prfUrl);
			} else {
				printAjaxError('fail', "操作失败！");
			}
		}

		$item_info = $this->tableObject->get('*', array('id'=>$id));
		$ad_group_list = $this->Ad_group_model->gets();

	    $data = array(
		        'tool'=>$this->_tool,
	            'item_info'=>$item_info,
	    		'table'=>$this->_table,
	            'ad_group_list'=>$ad_group_list,
	            'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/save", $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

    public function category() {
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

    public function delete() {
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

    public function sort() {
    	if ($_POST) {
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
    			printAjaxSuccess('success', '排序成功！');
    		}

    		printAjaxError('fail', '排序失败！');
    	}
	}
}
/* End of file link.php */
/* Location: ./application/admin/controllers/link.php */