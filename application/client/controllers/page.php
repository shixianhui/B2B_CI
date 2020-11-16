<?php
class Page extends CI_Controller {
	private $_table = 'page';
	private $_template = 'page';
	public function __construct() {
		parent::__construct();
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
	}

	//封面
	public function cover($menuId = NULL) {
		//关键字信息
		$systemInfo = $this->System_model->get('*', array('id'=>1));
		$menuInfo = $this->Menu_model->get('menu_name, seo_menu_name, keyword, abstract', array('id'=>$menuId));
		$parent_id = $this->Menu_model->getParentMenuId($menuId);

		$data = array(
				'site_name'=>$systemInfo['site_name'],
				'index_name'=>$systemInfo['index_name'],
				'client_index'=>$systemInfo['client_index'],
				'title'=>$menuInfo['seo_menu_name']?$menuInfo['seo_menu_name']:$menuInfo['menu_name'].$systemInfo['site_name'],
				'keywords'=>$menuInfo['keyword'],
				'description'=>$menuInfo['abstract'],
				'site_copyright'=>$systemInfo['site_copyright'],
				'icp_code'=>$systemInfo['icp_code'],
				'template'=>$this->_template,
				'html'=>$systemInfo['html'],
				'parent_id'=>$parent_id
		);
		$layout = array(
				'content'=>$this->load->view("{$this->_template}/cover", $data, TRUE)
		);
		$this->load->view('layout/default', $layout);
		//缓存
		if ($systemInfo['cache'] == 1) {
			$this->output->cache($systemInfo['cache_time']);
		}
	}

	public function index($menuId = NULL, $id = NULL) {
		$item_info = array();
		if ($id) {
			$item_info = $this->tableObject->get('*', array('id'=>$id, 'display'=>1));
			if (!$item_info) {
				$data = array(
						'user_msg'=>'此文章不存在',
						'user_url'=> base_url()
				);
				$this->session->set_userdata($data);
				redirect('/message/index');
			}
			//记录浏览次数
			$this->tableObject->save(array('hits'=>$item_info['hits']+1), array('id'=>$id));
		}  else {
			$menu_info = $this->Menu_model->get('content, menu_name, seo_menu_name, keyword, abstract', array('id'=>$menuId));
			if ($menu_info && $menu_info['content']) {
				$item_info['id'] = 0;
				$item_info['seo_title'] = $menu_info['seo_menu_name'];
			    $item_info['title'] = $menu_info['menu_name'];
			    $item_info['content'] = $menu_info['content'];
			    $item_info['keyword'] = $menu_info['keyword'];
			    $item_info['abstract'] = $menu_info['abstract'];
			} else {
				$itemList = $this->tableObject->gets(array('page.category_id'=>$menuId, 'page.display'=>1), 1, 0);
				if ($itemList) {
					$item_info = $itemList[0];
				}
			}
		}
        $systemInfo = $this->System_model->get('*', array('id'=>1));
        //当前位置
		$location = '';
		if ($systemInfo['html']) {
			$location = "<a href='index.html'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
		} else {
			$location = "<a href='{$systemInfo['client_index']}'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
		}
		$url = $systemInfo['client_index'];
		$url .= $systemInfo['client_index']?'/':'';
		$url = $this->Menu_model->getLocation($menuId, $systemInfo['html'], $url);
		$location .= $url;
		//左侧分类
		$parent_id = $this->Menu_model->getParentMenuId($menuId);
		$parent_menu_info = $this->Menu_model->get('menu_name', array('id'=>$parent_id));

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
				'parent_id'=>$parent_id,
		        'parent_menu_info'=>$parent_menu_info,
				'template'=>$this->_template,
		        'location'=>$location
		        );
	    $layout = array(
				  'content'=>$this->load->view("{$this->_template}/index", $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	    //缓存
	    if ($systemInfo['cache'] == 1) {
	    	$this->output->cache($systemInfo['cache_time']);
	    }
	}
}
/* End of file page.php */
/* Location: ./application/client/controllers/page.php */