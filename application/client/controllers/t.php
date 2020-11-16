<?php
class T extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('User_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
	}

	public function i($refereeCode = NULL) {
	    if ($refereeCode) {
        	$itemInfo = $this->User_model->get('id, distributor', array("pop_code"=>$refereeCode));
        	if ($itemInfo) {
        		$cookie1 = array(
        				'name'  =>'g_pop_code',
        				'value' =>$refereeCode,
        				'expire'=>5184000
        		);
        		set_cookie($cookie1);

        		if (is_mobile_request()) {
        			if($itemInfo['distributor'] == 1) {
        				$url = base_url().getBaseUrl(false, "", "join/city.html", 'weixin.php');
        				redirect("{$url}");
						exit;
        			} else if ($itemInfo['distributor'] == 2) {
        				$url = base_url().getBaseUrl(false, "", "join/store.html", 'weixin.php');
        				redirect("{$url}");
						exit;
        			}
        		} else {
        			$url = base_url().getBaseUrl(false, "", "user/register.html", 'index.php');
        			redirect("{$url}");
					exit;
        		}
            }
        }
        if (is_mobile_request()) {
        	$url = base_url().'weixin.php';
        	redirect("{$url}");
			exit;
        } else {
        	redirect(base_url());
			exit;
        }
	}
}
/* End of file main.php */
/* Location: ./application/client/controllers/main.php */