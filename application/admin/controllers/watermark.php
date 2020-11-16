<?php
class Watermark extends CI_Controller {
	private $_title = '图片水印设置';
	private $_tool = '';
	public function __construct() {
		parent::__construct();
		$this->_tool = $this->load->view('element/watermark_tool', '', TRUE);
		$this->load->model('Watermark_model', '', TRUE);
	}

	public function save() {
		if ($_POST) {
			$fields = array(
					'is_open'=>     $this->input->post('is_open'),
					'path'=>  		$this->input->post('path', TRUE),
					'location'=>    $this->input->post('location', TRUE)
			        );
		    if ($this->Watermark_model->save($fields, array('id'=>1))) {
		    	printAjaxSuccess(base_url().'admincp.php/watermark/save');
			} else {
				printAjaxError("修改失败！");
			}
		}
		$watermarkInfo = $this->Watermark_model->get('*', array('id'=>1));
		$data = array(
		        'tool'=>$this->_tool,
				'watermarkInfo'=>$watermarkInfo
		        );
	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view('watermark/save', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}
}
/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */