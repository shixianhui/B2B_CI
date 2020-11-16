<?php
class Score_setting extends CI_Controller {
    private $_title = '系统设置';
    private $_tool = '';

    public function __construct() {
        parent::__construct();
        $this->_tool = $this->load->view('element/system_tool', array('title' => ''), TRUE);
        $this->load->model('Score_setting_model', '', TRUE);
    }

    public function save() {
        if ($_POST) {
            $fields = array(
                'login_score' =>     $this->input->post('login_score', TRUE),
                'login_score_max' => $this->input->post('login_score_max', TRUE),
                'reg_score' =>       $this->input->post('reg_score', TRUE),
                'exchange_rmb_num' =>$this->input->post('exchange_rmb_num', TRUE),
            	'is_open' =>         $this->input->post('is_open', TRUE),
            	'store_score' =>     $this->input->post('store_score', TRUE)
            );
            if ($this->Score_setting_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/score_setting/save');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->Score_setting_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '街贝设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('score_setting/save', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }
}

/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */