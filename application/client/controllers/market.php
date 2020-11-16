<?php
class Market extends CI_Controller {
	private $_table = 'market';
	private $_template = 'market';
	public function __construct() {
		parent::__construct();
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
		$this->load->model('Attachment_model', '', TRUE);
	}

    public function index($id = NULL) {
    	$systemInfo = $this->System_model->get('*', array('id'=>1));
    	$item_info = $this->tableObject->get('*', array('id'=>$id, 'display'=>1));
    	if (!$item_info) {
    		$data = array(
    				'user_msg'=>'此商场不存在',
    				'user_url'=> base_url()
    		);
    		$this->session->set_userdata($data);
    		redirect('/message/index');
    	}
    	//记录浏览次数
    	$this->tableObject->save(array('hits'=>$item_info['hits']+1), array('id'=>$id));
    	//商场顶部广告图
    	$top_attachment_list = NULL;
    	if ($item_info && $item_info['batch_path_ids_top']) {
    		$tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids_top']);
    		$top_attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
    	}
    	//商场首页轮播图
    	$attachment_list = NULL;
    	if ($item_info && $item_info['batch_path_ids']) {
    		$tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
    		$attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
    	}
    	//商场底部广告图
    	$bottom_attachment_list = NULL;
    	if ($item_info && $item_info['batch_path_ids_bottom']) {
    		$tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids_bottom']);
    		$bottom_attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
    	}

		$data = array(
				'site_name'=>$systemInfo['site_name'],
				'index_name'=>$systemInfo['index_name'],
		        'client_index'=>$systemInfo['client_index'],
				'title'=>$item_info['seo_title']?$item_info['seo_title'].$systemInfo['site_name']:$item_info['title'].$systemInfo['site_name'],
		        'keywords'=>$item_info['keyword'],
		        'description'=>$item_info['abstract'],
				'site_copyright'=>$systemInfo['site_copyright'],
				'icp_code'=>$systemInfo['icp_code'],
				'html'=>$systemInfo['html'],
				'item_info'=>$item_info,
				'attachment_list'=>$attachment_list,
				'top_attachment_list'=>$top_attachment_list,
				'bottom_attachment_list'=>$bottom_attachment_list,
		        'template'=>$this->_template,
				'id'=>$id
		        );
		$layout = array(
				  'content'=>$this->load->view("{$this->_template}/index", $data, TRUE)
			      );
	    $this->load->view('layout/market_layout', $layout);
        //缓存
	    if ($systemInfo['cache'] == 1) {
	    	$this->output->cache($systemInfo['cache_time']);
	    }
	}
}
/* End of file main.php */
/* Location: ./application/client/controllers/main.php */