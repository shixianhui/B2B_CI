<?php
class System extends CI_Controller {

    private $_title = '系统设置';
    private $_tool = '';

    public function __construct() {
        parent::__construct();
        $this->_tool = $this->load->view('element/system_tool', array('title' => ''), TRUE);
        $this->load->model('System_model', '', TRUE);
    }

    public function save() {
        if ($_POST) {
            $fields = array(
                'index_name' => $this->input->post('index_name', TRUE),
                'site_name' => $this->input->post('site_name', TRUE),
                'index_site_name' => $this->input->post('index_site_name', TRUE),
                'client_index' => $this->input->post('client_index', TRUE),
                'site_copyright' => $this->input->post('site_copyright', TRUE),
                'site_keycode' => $this->input->post('site_keycode', TRUE),
                'site_description' => $this->input->post('site_description', TRUE),
                'icp_code' => $this->input->post('icp_code', TRUE),
                'html_folder' => $this->input->post('html_folder', TRUE),
                'html_level' => $this->input->post('html_level', TRUE)
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/save');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '基本设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/save', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //搜索关键词设置
    public function keyword() {
        if ($_POST) {
            $fields = array(
                'text_keyword' => $this->input->post('text_keyword', TRUE),
                'link_keyword' => $this->input->post('link_keyword', TRUE)
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/keyword');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '搜索关键词设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/keyword', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //免运费设置
    public function free_postage() {
        if ($_POST) {
            $fields = array(
                'free_postage' => $this->input->post('free_postage', TRUE),
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/free_postage');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '免运费设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/free_postage', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //在线客服设置
    public function qq_service() {
        if ($_POST) {
            $fields = array(
                'globle_qq_service' => unhtml($this->input->post('globle_qq_service')),
                'left_qq_service' => unhtml($this->input->post('left_qq_service'))
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/qq_service');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '在线客服设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/qq_service', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //在线充值设置
    public function online_recharge() {
        if ($_POST) {
            $fields = array(
                'online_recharge' => unhtml($this->input->post('online_recharge'))
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/online_recharge');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '在线充值设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/online_recharge', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //送积分设置
    public function score() {
        if ($_POST) {
            $fields = array(
                'login_score' => $this->input->post('login_score'),
                'register_score' => $this->input->post('register_score'),
                'product_percent' => $this->input->post('product_percent'),
                'open_score' => $this->input->post('open_score')
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/score');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '送积分设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/score', $data, TRUE)
        );
        $this->load->view('layout/default',$layout);
    }

    //售后服务
    public function pay_service() {
        if ($_POST) {
            $fields = array(
                'pay_service' => unhtml($this->input->post('pay_service'))
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/pay_service');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '售后服务'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/pay_service', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }
   //订单离付款剩余时间设置
    public function set_expires(){
        if ($_POST) {
            $fields = array(
                'free_postage' => $this->input->post('free_postage', TRUE),
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/free_postage');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '订单离付款剩余时间设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/set_expires', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }
    //支付方式设置
    public function pay_mode() {
        if ($_POST) {
            $fields = array(
                'pay_mode' => unhtml($this->input->post('pay_mode'))
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/pay_mode');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '支付方式设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/pay_mode', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //购物流程设置
    public function buy_process() {
        if ($_POST) {
            $fields = array(
                'buy_process' => unhtml($this->input->post('buy_process'))
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/buy_process');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '购物流程设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/buy_process', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //限时抢购设置
    public function discount() {
        if ($_POST) {
            $fields = array(
                'discount_title' => unhtml($this->input->post('discount_title')),
                'discount_ad' => unhtml($this->input->post('discount_ad')),
                'discount_add_time' => strtotime($this->input->post('discount_add_time', TRUE)),
                'discount_end_time' => strtotime($this->input->post('discount_end_time', TRUE)),
                'discount_percent' => $this->input->post('discount_percent', TRUE),
                'discount_open' => $this->input->post('discount_open', TRUE),
                'discount_content' => unhtml($this->input->post('discount_content'))
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/discount');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '限时抢购设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/discount', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //积分兑换设置
    public function exchange() {
        if ($_POST) {
            $fields = array(
                'exchange_space_min' => $this->input->post('exchange_space_min', TRUE),
                'exchange_percent' => $this->input->post('exchange_percent', TRUE),
                'score_deductible' => $this->input->post('score_deductible', TRUE),
                'exchange_open' => $this->input->post('exchange_open', TRUE)
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/exchange');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '积分兑换设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/exchange', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //服务协议设置
    public function reg_agreement() {
        if ($_POST) {
            $fields = array(
                'reg_agreement' => unhtml($this->input->post('reg_agreement'))
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/reg_agreement');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '服务协议设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/reg_agreement', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //推广页面介绍
    public function presenter_text() {
    	if ($_POST) {
    		$fields = array(
    				'presenter_is_open'=>$this->input->post("presenter_is_open", TRUE),
    				'parent_presenter_text' => unhtml($this->input->post('parent_presenter_text')),
    				'sub_presenter_text' => unhtml($this->input->post('sub_presenter_text')),
    				'presenter_city_text' => unhtml($this->input->post('presenter_city_text')),
    				'presenter_store_text' => unhtml($this->input->post('presenter_store_text'))
    		);
    		if ($this->System_model->save($fields, array('id' => 1))) {
    			printAjaxSuccess(base_url() . 'admincp.php/system/presenter_text');
    		} else {
    			printAjaxError("修改失败！");
    		}
    	}
    	$itemInfo = $this->System_model->get('*', array('id' => 1));
    	$data = array(
    			'tool' => $this->load->view('element/system_tool', array('title' => '分销商推广页面设置'), TRUE),
    			'itemInfo' => $itemInfo
    	);
    	$layout = array(
    			'title' => $this->_title,
    			'content' => $this->load->view('system/presenter_text', $data, TRUE)
    	);
    	$this->load->view('layout/default', $layout);
    }

    public function update() {
    	if ($_POST) {
    		$fields = array(
    			'android_full_update_version'=> $this->input->post('android_full_update_version'),
				'android_full_update_url'=>     $this->input->post('android_full_update_url'),
				'ios_full_update_version'=>     $this->input->post('ios_full_update_version'),
				'ios_full_update_url'=>         $this->input->post('ios_full_update_url'),
    			'wget_version'=>                $this->input->post('wget_version'),
    			'wget_url'=>                    $this->input->post('wget_url')
    		);
    		if ($this->System_model->save($fields, array('id' => 1))) {
    			printAjaxSuccess(base_url() . 'admincp.php/system/update');
    		} else {
    			printAjaxError("修改失败！");
    		}
    	}
    	$itemInfo = $this->System_model->get('*', array('id' => 1));
    	$data = array(
    			'tool' => $this->load->view('element/system_tool', array('title' => 'App更新'), TRUE),
    			'itemInfo' => $itemInfo
    	);
    	$layout = array(
    			'title' => $this->_title,
    			'content' => $this->load->view('system/update', $data, TRUE)
    	);
    	$this->load->view('layout/default', $layout);
    }
}

/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */