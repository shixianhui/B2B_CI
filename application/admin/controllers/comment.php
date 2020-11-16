<?php
class Comment extends CI_Controller {
    private $_title = '商品评价管理';
    private $_tool = '';
    private $_table = '';

    private $_evaluate_arr = array(
        '1'=>'好评',
        '2'=>'中评',
        '3'=>'差评',
    );
    public function __construct() {
        parent::__construct();
        //获取表名
        $this->_table = $this->uri->segment(1);
        //快捷方式
        $this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'交易管理', 'title'=>'商品评价'), TRUE);
        //获取表对象
        $this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Orders_model', '', TRUE);
        $this->load->model('Store_reply_comment_model', '', TRUE);
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

        $data = array(
            'tool' => $this->_tool,
            'clear'=>     $clear,
			'item_list'  =>$item_list,
		    'pagination'=>$pagination,
		    'paginationCount'=>$paginationCount,
		    'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		    'table'=>$this->_table,
		    'evaluate_arr'=>$this->_evaluate_arr,
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_table}/index", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function save($id=null) {
    	$prfUrl = $this->session->userdata($this->_table.'RefUrl')?$this->session->userdata($this->_table.'RefUrl'):base_url()."admincp.php/{$this->_table}/index/1";
        $item_info = $this->tableObject->get('*',array('id'=>$id));
        if ($item_info){
            $order_info = $this->Orders_model->get('id',array('order_number'=>$item_info['order_number']));
        }
        if($item_info['is_reply']){
            $store_reply_info = $this->Store_reply_comment_model->get('evaluate,content,add_time',array('comment_id'=>$item_info['id']));
            if($store_reply_info){
                $item_info['store_evaluate'] = $store_reply_info['evaluate'];
                $item_info['store_reply'] = $store_reply_info['content'];
                $item_info['reply_time'] = $store_reply_info['add_time'];
            }
        }
        if($_POST){
            $grade = $this->input->post('grade',true);
            $content = $this->input->post('content',true);
            if(empty($grade)|| empty($content)){
                printAjaxError('fail','分数和评价内容不能为空');
            }
            $fields = array(
            		'grade'=>$grade,
            		'content'=>$content);
            $this->tableObject->save($fields,array('id'=>$id));
            printAjaxSuccess($prfUrl);
        }
        $data = array(
            'tool' => $this->_tool,
            'item_info' => $item_info,
            'order_info' => $order_info,
            'evaluate_arr'=>$this->_evaluate_arr,
        	'prfUrl'=>$prfUrl
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_table}/save", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function delete(){
            $ids = $this->input->post('ids', TRUE);
	    if (! empty($ids)) {
	        if ($this->tableObject->delete("id in ($ids)")) {
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }
	    printAjaxError('删除失败！');
    }

    public function display() {
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
}
