<?php
class Main extends CI_Controller {
	private $_left_ad_id_arr = array('0'=>8, '1'=>9, '2'=>10, '3'=>11, '4'=>12, '5'=>13, '6'=>14, '7'=>15, '8'=>16, '9'=>17);
	private $_lb_ad_id_arr = array('0'=>18, '1'=>19, '2'=>20, '3'=>21, '4'=>22, '5'=>23, '6'=>24, '7'=>25, '8'=>26, '9'=>27);

	public function __construct() {
		parent::__construct();
		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
		$this->load->model('Area_model', '', TRUE);
	}

	public function index() {
		$systemInfo = $this->System_model->get('*', array('id'=>1));
        //地址
        $area_list = $this->Area_model->gets('*', array('parent_id' => 0));
		$data = array(
				'site_name'=>$systemInfo['index_site_name'],
				'index_name'=>$systemInfo['index_name'],
		        'client_index'=>$systemInfo['client_index'],
				'title'=>$systemInfo['index_site_name'],
		        'keywords'=>$systemInfo['site_keycode'],
		        'description'=>$systemInfo['site_description'],
		        'site_copyright'=>$systemInfo['site_copyright'],
				'icp_code'=>$systemInfo['icp_code'],
				'html'=>$systemInfo['html'],
				'left_ad_id_arr'=>$this->_left_ad_id_arr,
				'lb_ad_id_arr'=>$this->_lb_ad_id_arr,
				'parent_id'=>'0',
				'area_list'=>$area_list
		        );

	    $layout = array(
				  'content'=>$this->load->view('main/index', $data, TRUE)
			      );
	    $this->load->view('layout/index', $layout);
	    //缓存
	    if ($systemInfo['cache'] == 1) {
	    	$this->output->cache($systemInfo['cache_time']);
	    }
	}
}
/* End of file main.php */
/* Location: ./application/client/controllers/main.php */