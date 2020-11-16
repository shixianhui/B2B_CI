<?php
class Store extends CI_Controller {
	private $_title = '店铺管理';
	private $_tool = '';
	private $_table = '';
	private $_display_arr = array('0'=>'<font color="red">待审核</font>', '1'=>'通过', '2'=>'暂未通过', '3'=>'关闭店铺');
	private $_store_type_arr = array('1'=>'实体商家', '2'=>'实体厂家', '3'=>'实力电商', '4'=>'个人实名');
	private $_auth_file_type_arr = array('1'=>'实体商家认证文档', '2'=>'实体厂家认证文档', '3'=>'实力电商认证文档', '4'=>'个人实名认证文档');

	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'店铺管理', 'title'=>'店铺'), TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Store_grade_model', '', TRUE);
		$this->load->model('Store_category_model', '', TRUE);
		$this->load->model('Area_model', '', TRUE);
		$this->load->model('Theme_model', '', TRUE);
		$this->load->model('Seller_group_model', '', TRUE);
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Market_model', '', TRUE);
	}

	public function index($clear = 0, $page = 0) {
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		clearSession(array('search'));
		if ($clear) {
			$clear = 0;
			$this->session->unset_userdata(array('search'=>''));
		}
		$uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
		$uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/{$clear}/{$page}";
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>$uri_sg));
		$condition = "{$this->_table}.display in (1,2,3)";
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):$condition;

		if ($_POST) {
			$strWhere = $condition;
			$id = $this->input->post('id');
			$username = $this->input->post('username');
			$store_name = $this->input->post('store_name');
			$owner_name = $this->input->post('owner_name');

			if (! empty($id) ) {
				$strWhere .= " and {$this->_table}.id = {$id} ";
			}
			if (! empty($username) ) {
				$strWhere .= " and user.username REGEXP '{$username}'";
			}
            if (! empty($store_name) ) {
                $strWhere .= " and {$this->_table}.store_name REGEXP '{$store_name}'";
            }
            if (! empty($owner_name) ) {
                $strWhere .= " and {$this->_table}.owner_name REGEXP '{$owner_name}'";
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

		$item_list = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
		if ($item_list) {
			foreach ($item_list as $key=>$value) {
				$item_list[$key]['store_name'] = $value['store_name'].'&nbsp;'.$this->tableObject->attribute($value['custom_attribute']);
			}
		}
		$data = array(
		        'tool'=>$this->_tool,
		        'clear'=>     $clear,
				'item_list'  =>$item_list,
		        'pagination'=>$pagination,
		        'paginationCount'=>$paginationCount,
		        'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
				'display_arr'=>$this->_display_arr,
		        'table'=>$this->_table
		        );
	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/index", $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function index_0($clear = 0, $page = 0) {
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		clearSession(array('search'));
		if ($clear) {
			$clear = 0;
			$this->session->unset_userdata(array('search'=>''));
		}
		$uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
		$uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/{$clear}/{$page}";
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>$uri_sg));
		$condition = "{$this->_table}.display = 0";
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):$condition;

		if ($_POST) {
			$strWhere = $condition;
			$title = $this->input->post('title');
			$category_id = $this->input->post('select_category_id');
			$display = $this->input->post('display');
			$startTime = $this->input->post('inputdate_start');
			$endTime = $this->input->post('inputdate_end');

			if (! empty($category_id) ) {
				$strWhere .= " and {$this->_table}.category_id = {$category_id} ";
			}
			if (! empty($title) ) {
				$strWhere .= " and {$this->_table}.title REGEXP '{$title}'";
			}
			if ($display != "") {
				$strWhere .= " and {$this->_table}.display = {$display} ";
			}
			if (! empty($startTime) && ! empty($endTime)) {
				$strWhere .= " and {$this->_table}.add_time > ".strtotime($startTime.' 00:00:00')." and {$this->_table}.add_time < ".strtotime($endTime." 23:59:59")." ";
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

		$item_list = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
		if ($item_list) {
			foreach ($item_list as $key=>$value) {
				$item_list[$key]['store_name'] = $value['store_name'].'&nbsp;'.$this->tableObject->attribute($value['custom_attribute']);
			}
		}
		$data = array(
				'tool'=>$this->_tool,
				'clear'=>     $clear,
				'item_list'  =>$item_list,
				'pagination'=>$pagination,
				'paginationCount'=>$paginationCount,
				'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
				'display_arr'=>$this->_display_arr,
				'table'=>$this->_table
		);
		$layout = array(
				'title'=>$this->_title,
				'content'=>$this->load->view("{$this->_table}/index_0", $data, TRUE)
		);
		$this->load->view('layout/default', $layout);
	}

	public function select($clear = 0, $page = 0) {
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
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
			$strWhere = "{$this->_table}.id > 0";
			$title = $this->input->post('title');
			$category_id = $this->input->post('select_category_id');
			$display = $this->input->post('display');
			$startTime = $this->input->post('inputdate_start');
			$endTime = $this->input->post('inputdate_end');

			if (! empty($category_id) ) {
				$strWhere .= " and {$this->_table}.category_id = {$category_id} ";
			}
			if (! empty($title) ) {
				$strWhere .= " and {$this->_table}.title REGEXP '{$title}'";
			}
			if ($display != "") {
				$strWhere .= " and {$this->_table}.display = {$display} ";
			}
			if (! empty($startTime) && ! empty($endTime)) {
				$strWhere .= " and {$this->_table}.add_time > ".strtotime($startTime.' 00:00:00')." and {$this->_table}.add_time < ".strtotime($endTime." 23:59:59")." ";
			}
			$this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationCount = $this->tableObject->rowCount($strWhere);
		$paginationConfig = $this->config->item('pagination_config');
		$paginationConfig['base_url'] = base_url()."admincp.php/{$this->_table}/select/{$clear}/";
		$paginationConfig['total_rows'] = $paginationCount;
		$paginationConfig['uri_segment'] = 4;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$item_list = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);

		$data = array(
				'tool'=>'',
				'clear'=>     $clear,
				'item_list'  =>$item_list,
				'pagination'=>$pagination,
				'paginationCount'=>$paginationCount,
				'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
				'table'=>$this->_table
		);
		$layout = array(
				'title'=>$this->_title,
				'content'=>$this->load->view("{$this->_table}/select", $data, TRUE)
		);
		$this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
		$prfUrl = $this->session->userdata("{$this->_table}RefUrl")?$this->session->userdata("{$this->_table}RefUrl"):base_url()."admincp.php/{$this->_table}/index";
		if ($_POST) {
			$store_name = trim($this->input->post('store_name', TRUE));
			$owner_name = trim($this->input->post('owner_name', TRUE));
			$owner_card = trim($this->input->post('owner_card', TRUE));
			$province_id = $this->input->post('province_id', TRUE);
			$city_id = $this->input->post('city_id', TRUE);
			$area_id = $this->input->post('area_id', TRUE);
			$txt_address = $this->input->post('txt_address', TRUE);
			$address = $this->input->post('address', TRUE);
			$mobile = $this->input->post('mobile', TRUE);
			$store_category_id = $this->input->post('store_category_id', TRUE);
			$store_grade_id = $this->input->post('store_grade_id', TRUE);
			$display = $this->input->post('display', TRUE);
			$close_reason = $this->input->post('close_reason', TRUE);
			$end_time = $this->input->post('end_time', TRUE);
			$real_name_auth = $this->input->post('real_name_auth', TRUE);
			$retailer_auth = $this->input->post('retailer_auth', TRUE);
			$store_auth = $this->input->post('store_auth', TRUE);
			$producer_auth = $this->input->post('producer_auth', TRUE);
			$sort = $this->input->post('sort', TRUE);
			$recommended = $this->input->post('recommended', TRUE);
			$description = $this->input->post('description', TRUE);
			$im_qq = $this->input->post('im_qq', TRUE);
			$im_ww = $this->input->post('im_ww', TRUE);
			$im_weixin = $this->input->post('im_weixin', TRUE);
			$store_banner = $this->input->post('store_banner', TRUE);
			$path = $this->input->post('path', TRUE);
			$batch_path_ids = $this->input->post('batch_path_ids', TRUE);
			$user_id = $this->input->post('user_id', TRUE);
			$business_scope = $this->input->post('business_scope', TRUE);
			$admin_remark = $this->input->post('admin_remark', TRUE);
			$theme = $this->input->post('theme', TRUE);
			$logo_path = $this->input->post('logo_path', TRUE);
			$index_path = $this->input->post('index_path', TRUE);
			$custom_attribute = $this->input->post('custom_attribute', TRUE);
            $auth_file_path = $this->input->post('auth_file_path', TRUE);
			if (! empty($custom_attribute)) {
				$custom_attribute = implode($custom_attribute, ',');
			} else {
				$custom_attribute = '';
			}
            if ($id) {
            	if ($this->tableObject->rowCount("{$this->_table}.user_id = {$user_id} and {$this->_table}.id <> {$id}")) {
            		printAjaxError('fail', '此用户已开通过店铺，同一用户只能开一个店铺');
            	}
            } else {
            	if ($this->tableObject->rowCount("{$this->_table}.user_id = {$user_id}")) {
            		printAjaxError('fail', '此用户已开通过店铺，同一用户只能开一个店铺');
            	}
            }

            //部门管理
            if ($display == 1){
			    $user_info = $this->User_model->get('seller_group_id', array('id'=>$user_id));
			    if (empty($user_info['seller_group_id'])){
			        $permissions = 'seller_g,seller,seller_index,seller_add,useller_edit,seller_delete,ad_store,ad_store_index,ad_store_add,ad_store_edit,ad_store_delete,theme,theme_index,theme_add,theme_edit,theme_delete,navigation,navigation_index,navigation_add,navigation_edit,navigation_delete,order_g,order,order_index,order_add,order_edit,order_delete,comment,comment_index,comment_add,comment_edit,comment_delete,exchange,exchange_index,exchange_add,exchange_edit,exchange_delete,product_g,product,product_index,product_add,product_edit,product_delete,product_category,product_category_index,product_category_add,product_category_edit,product_category_delete,brand,brand_index,brand_add,brand_edit,brand_delete,style,style_index,style_add,style_edit,style_delete,material,material_index,material_add,material_edit,material_delete,postage_way_g,postage_way,postage_way_index,postage_way_add,postage_way_edit,postage_way_delete,seller_group_g,seller_group,seller_group_index,seller_group_add,seller_group_edit,seller_group_delete,user,user_index,user_add,user_edit,user_delete';
			        $ret_id = $this->Seller_group_model->save2(array('group_name'=>'超级管理员', 'permissions'=>$permissions,'user_id'=>$user_id));
			        if ($ret_id > 0){
                        $this->User_model->save(array('seller_group_id'=>$ret_id), array('id'=>$user_id));
                    }
                }
            }


			$fields = array(
					'user_id'=>      $user_id,
					'store_name'=>   $store_name,
					'owner_name'=>   $owner_name,
					'owner_card'=>   $owner_card,
					'market_id'=>    $this->input->post('market_id', TRUE),
					'province_id'=>  $province_id?$province_id:0,
					'city_id'=>      $city_id?$city_id:0,
					'area_id'=>      $area_id?$area_id:0,
					'txt_address'=>  $txt_address,
					'address'=>      $address,
					'mobile'=>       $mobile,
					'store_category_id'=>$store_category_id,
					'store_grade_id'=>   $store_grade_id,
					'display'=>          $display,
					'close_reason'=>     $close_reason,
					'admin_remark'=>     $admin_remark,
					'end_time'=>         $end_time?strtotime($end_time.' 23:59:59'):0,
					'real_name_auth'=>   $real_name_auth,
					'retailer_auth'=>    $retailer_auth,
					'store_auth'=>       $store_auth,
					'producer_auth'=>    $producer_auth,
					'sort'=>             $sort,
					'recommended'=>      $recommended,
					'description'=>      $description,
					'im_qq'=>            $im_qq,
					'im_ww'=>            $im_ww,
					'im_weixin'=>        $im_weixin,
					'store_banner'=>     $store_banner,
					'path'=>             $path,
					'batch_path_ids'=>   $batch_path_ids,
					'custom_attribute'=> $custom_attribute,
					'theme'=>            $theme,
					'business_scope'=>   $business_scope,
					'logo_path'=>        $logo_path,
					'index_path'=>       $index_path,
                    'auth_file_path' => $auth_file_path,
                'reg_num' => trim($this->input->post('reg_num', TRUE)),
                'license_store_name' => trim($this->input->post('license_store_name', TRUE)),
                'license_username' => trim($this->input->post('license_username', TRUE)),
                'license_form' => trim($this->input->post('license_form', TRUE)),
                'license_place' => trim($this->input->post('license_place', TRUE)),
                'license_credit_code' => trim($this->input->post('license_credit_code', TRUE)),
                'license_store_type' => trim($this->input->post('license_store_type', TRUE)),
                'license_residence' => trim($this->input->post('license_residence', TRUE)),
                'license_representative' => trim($this->input->post('license_representative', TRUE)),
                'license_capital' => trim($this->input->post('license_capital', TRUE)),
                'license_made_time' => trim($this->input->post('license_made_time', TRUE)),
                'license_time_limit' => trim($this->input->post('license_time_limit', TRUE)),
                'license_business_scope' => trim($this->input->post('license_business_scope', TRUE)),
            );
			if ($id) {
				$fields['display_time'] = time();
			} else {
				$fields['add_time'] = time();
			}
			if ($this->tableObject->save($fields, $id?array('id'=>$id):NULL)) {
				printAjaxSuccess($prfUrl);
			} else {
				printAjaxError('fail', "操作失败！");
			}
		}

		$item_info = $this->tableObject->get(array("{$this->_table}.id"=>$id));
		$theme_list = NULL;
		if ($item_info) {
			if ($item_info['store_grade_id']) {
				$store_grade_info = $this->Store_grade_model->get('theme_ids', array('id'=>$item_info['store_grade_id']));
				if ($store_grade_info && $store_grade_info['theme_ids']) {
					$theme_list = $this->Theme_model->gets("id in ({$store_grade_info['theme_ids']}) and display = 1 ");
				}
			}
		} else {
			$store_grade_info = $this->Store_grade_model->get('theme_ids', array('id'=>1));
			if ($store_grade_info) {
				$theme_list = $this->Theme_model->gets("id in ({$store_grade_info['theme_ids']}) and display = 1 ");
			}
		}
		$store_grade_list =  $this->Store_grade_model->gets();
		$store_category_list = $this->Store_category_model->menuTree();
		$area_list = $this->Area_model->gets('id, name', array('parent_id'=>1));

        //商场
        $market_list = $this->Market_model->gets(array('display' => 1));
	    $data = array(
		        'tool'=>$this->_tool,
	            'item_info'=>$item_info,
	    		'table'=>$this->_table,
	    		'store_grade_list'=>$store_grade_list,
	    		'store_category_list'=>$store_category_list,
	    		'theme_list'=>$theme_list,
	    		'area_list'=>$area_list,
	    		'market_list'=>$market_list,
	    		'display_arr'=>$this->_display_arr,
	    		'store_type_arr'=>$this->_store_type_arr,
	    		'auth_file_type_arr'=>$this->_auth_file_type_arr,
	            'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/save", $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

    public function delete() {
	    $ids = $this->input->post('ids', TRUE);

	    if (! empty($ids)) {
	        if ($this->tableObject->delete("id in ($ids)")) {
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('删除失败！');
	}

	public function sort() {
		$ids = $this->input->post('ids', TRUE);
		$sorts = $this->input->post('sorts', TRUE);

		if (! empty($ids)) {
			$ids = explode(',', $ids);
			$sorts = explode(',', $sorts);

			foreach ($ids as $key=>$value) {
				$this->tableObject->save(
						array('sort'=>$sorts[$key]),
						array('id'=>$value));
			}
			printAjaxSuccess('', '排序成功！');
		}

		printAjaxError('fail', '排序失败！');
	}

	public function get_city() {
		if ($_POST) {
			$parent_id = $this->input->post('parent_id', TRUE);
			$item_list = $this->Area_model->gets('id, name', array('parent_id'=>$parent_id, 'display'=>1));
			printAjaxData($item_list);
		}
	}

	public function get_theme_list() {
		if ($_POST) {
			$store_grade_id = $this->input->post('store_grade_id', TRUE);
            if (!$store_grade_id) {
            	printAjaxError('fail', '请选择店铺分类');
            }
			$store_grade_info = $this->Store_grade_model->get('theme_ids', array('id'=>$store_grade_id));
			if (!$store_grade_info) {
				printAjaxError('fail', '店铺等级还未设置关联的店铺模板,请设置');
			}
			$theme_list = $this->Theme_model->gets("id in ({$store_grade_info['theme_ids']}) and display = 1 ");
		    if (!$theme_list) {
		    	printAjaxError('fail', '店铺等级还未设置关联的店铺模板,请设置');
		    }
		    printAjaxData(array('theme_list'=>$theme_list));
		}
	}
}
/* End of file admingroup.php */
/* Location: ./application/admin/controllers/admingroup.php */