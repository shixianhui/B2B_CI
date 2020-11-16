<?php

class Store extends CI_Controller {
    private $_price_arr = array('1'=>array('0-1000', '0-1000元'), '2'=>array('1000-3000', '1000-3000元'), '3'=>array('3000-5000', '3000-5000元'), '4'=>array('5000-10000', '5000-10000元'), '5'=>array('10000-20000', '10000-20000元'), '6'=>array('20000', '20000元以上'));
    private $_table = 'store';
    private $_template = 'store';
    private $_style = 'style1';
    private $_auth_type_arr = array('1'=>'store_auth', '2'=>'producer_auth', '3'=>'retailer_auth', '4'=>'real_name_auth');
    public function __construct() {
        parent::__construct();
        $this->load->model(ucfirst($this->_table) . '_model', 'tableObject', TRUE);
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Style_model', '', TRUE);
        $this->load->model('Store_category_model', '', TRUE);
        $this->load->model('Market_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Brand_model', '', TRUE);
        $this->load->model('Style_model', '', TRUE);
        $this->load->model('Material_model', '', TRUE);
        $this->load->model('Product_category_model', '', TRUE);
        $this->load->model('Keyword_model', '', TRUE);
        $this->load->model('Navigation_model', '', TRUE);
        $this->load->model('Attachment_model', '', TRUE);
    }

    public function index($auth_type = 0,$menu_str = NULL, $page = 0) {
        if ($auth_type == 2){
            if (!check_store_type()) {
                $data = array(
                    'user_msg' => '招商采购频道，经认证的入驻商家方可进入<br>商家入驻请点击这里',
                    'user_url' =>  base_url()."index.php/seller/my_join.html"
                );
                $this->session->set_userdata($data);
                redirect('/message/index');
                exit;
            }
        }

        $menuId = 0;
        $style_id = 0;
        $style_name = '';
        $brand_id = 0;
        $brand_name = '';
        $store_category_id = 0;
        $store_category_name = '';
        $market_id = 0;
        $market_name = '';
        $market_info = NULL;
        if ($menu_str) {
            $menu_str_arr = explode("-", $menu_str);
            if ($menu_str_arr) {
                if (array_key_exists("0", $menu_str_arr)) {
                    $menuId = $menu_str_arr[0];
                }
                if (array_key_exists("1", $menu_str_arr)) {
                    $style_id = $menu_str_arr[1];
                    if ($style_id) {
                        $style_info = $this->Style_model->get('style_name', array('id' => $style_id));
                        if ($style_info) {
                            $style_name = $style_info['style_name'];
                        }
                    }
                }
                if (array_key_exists("2", $menu_str_arr)) {
                    $store_category_id = $menu_str_arr[2];
                    if ($store_category_id) {
                        $sc_info = $this->Store_category_model->get('store_category_name', array('id' => $store_category_id));
                        if ($sc_info) {
                            $store_category_name = $sc_info['store_category_name'];
                        }
                    }
                }
                if (array_key_exists("3", $menu_str_arr)) {
                    $market_id = $menu_str_arr[3];
                    if ($market_id) {
                        $market_info = $this->Market_model->get('*', array('id' => $market_id));
                        if ($market_info) {
                            $market_name = $market_info['title'];
                        }
                    }
                }
                if (array_key_exists("4", $menu_str_arr)) {
                    $brand_id = $menu_str_arr[4];
                    if ($brand_id) {
                        $brand_info = $this->Brand_model->get('brand_name', array('id' => $brand_id));
                        if ($brand_info) {
                            $brand_name = $brand_info['brand_name'];
                        }
                    }
                }
            }
        }

        //关键字信息
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $menuInfo = $this->Menu_model->get('menu_name, seo_menu_name, keyword, abstract', array('id' => $menuId));
        if (!$menuInfo) {
            $data = array(
                'user_msg' => '此栏目不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
            exit;
        }


        $strWhere = "display = 1";
        if ($auth_type && !empty($this->_auth_type_arr[$auth_type])){
            $strWhere .= " and {$this->_auth_type_arr[$auth_type]} = 1";
        }
        if ($store_category_id){
            $strWhere .= " and store_category_id = {$store_category_id}";
        }

        if($style_id){
            $strWhere .= " and id in (select store_id from product where style_name = '{$style_name}')";
        }
        if($brand_id){
            $strWhere .= " and id in (select store_id from product where brand_name = '{$brand_name}')";
        }
        if ($market_id) {
            $strWhere .= " and market_id = {$market_id}";
        }


//        $paginationCount = $this->tableObject->rowCount($strWhere);
//        $this->config->load('pagination_config', TRUE);
//        $paginationConfig = $this->config->item('pagination_config');
//        $paginationConfig['base_url'] = base_url() ."index.php/{$this->_template}/index/{$auth_type}/{$menu_str}/";
//        $paginationConfig['total_rows'] = $paginationCount;
//        $paginationConfig['uri_segment'] = 5;
//        $paginationConfig['per_page'] = 10;
//        $this->pagination->initialize($paginationConfig);
//        $pagination = $this->pagination->create_links();

//        $item_list = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
        $item_list = $this->tableObject->getsRand2($strWhere);
        //随机排序
//        shuffle($item_list);
        //风格
        $style_list = $this->Style_model->gets(array('display' => 1));
        //品牌
        $brand_list = $this->Brand_model->gets('*',array('display' => 1));
        //分类
        $store_category_list = $this->Store_category_model->gets(array('display' => 1));
        //商场
        $market_list = $this->Market_model->gets(array('display' => 1));
        //左侧分类
        $parent_id = $this->Menu_model->getParentMenuId($menuId);

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => $menuInfo['seo_menu_name'] ? $menuInfo['seo_menu_name'] : $menuInfo['menu_name'] . $systemInfo['site_name'],
            'keywords' => $menuInfo['keyword'],
            'description' => $menuInfo['abstract'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_list' => $item_list,
            'menuId' => $menuId,
//            'pagination' => $pagination,
//            'paginationCount' => $paginationCount,
//            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
//            'perPage' => $paginationConfig['per_page'],
            'template' => $this->_template,
            'style_list' => $style_list,
            'brand_list' => $brand_list,
            'store_category_list' => $store_category_list,
            'market_list' => $market_list,
            'auth_type' => $auth_type,
            'parent_id' => $parent_id,
            'style_id' => $style_id,
            'style_name' => $style_name,
            'brand_id' => $brand_id,
            'brand_name' => $brand_name,
            'store_category_id' => $store_category_id,
            'store_category_name' => $store_category_name,
            'market_id' => $market_id,
            'market_name' => $market_name,
            'market_info' => $market_info
        );

        $layout = array(
            'content' => $this->load->view("{$this->_template}/index", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function banner_index(){
        $systemInfo = $this->System_model->get('*', array('id'=>1));

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
            'parent_id'=>'0'
        );

        $layout = array(
            'content'=>$this->load->view('store/banner_index', $data, TRUE)
        );
        $this->load->view('layout/index', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //店铺首页
    public function home($store_id = NULL) {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $item_info = $this->tableObject->get3(array('store.id' => $store_id, 'store.display' => 1));
        if (!$item_info) {
            $data = array(
                'user_msg' => '此店铺不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
            exit;
        }
        $item_info['des_grade'] = floatval($item_info['des_grade']);
        $item_info['serve_grade'] = floatval($item_info['serve_grade']);
        $item_info['express_grade'] = floatval($item_info['express_grade']);
        if ($item_info['theme']) {
        	$this->_style = $item_info['theme'];
        }

        $recommend_product_list = $this->advdbclass->get_recommend_product_list(12, $store_id);
//        if($recommend_product_list) {
//            foreach ($recommend_product_list as $key=>$item) {
//                //主图拿第一张商品图
//                $attachment_list = NULL;
//                if ($item && $item['batch_path_ids']) {
//                    $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item['batch_path_ids']);
//                    $attachment_list = $this->Attachment_model->gets4($tmp_atm_ids);
//                    if ($attachment_list) {
//                        $recommend_product_list[$key]['path'] = $attachment_list[0]['path'];
//                    }
//                }
//            }
//        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => $item_info['store_name'] . $systemInfo['site_name'],
            'keywords' => '',
            'description' => '',
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_info' => $item_info,
            'template' => $this->_template,
            'store_id' => $store_id,
            'recommend_product_list' => $recommend_product_list,
            'style' => $this->_style
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/home_{$this->_style}", $data, TRUE)
        );
        $this->load->view('layout/store_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //产品列表
    public function product($store_id_str = NULL, $page = 0) {
        //关键字信息
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $store_id = 0;
        $category_id = 0;
        $category_name = '';
        $category_id_sub = 0;
        $category_name_sub = '';
        $brand_id = 0;
        $brand_name = '';
        $style_id = 0;
        $style_name = '';
        $material_id = 0;
        $material_name = '';
        $price_id = 0;
        $price_name = '';
        $by = 'id';
        $order = 'desc';
        $search_keyword = '';
        if ($store_id_str) {
        	$store_id_str_arr = explode("-", $store_id_str);
        	if ($store_id_str_arr) {
        		if (array_key_exists("0", $store_id_str_arr)) {
        			$store_id = $store_id_str_arr[0];
        		}
        		if (array_key_exists("1", $store_id_str_arr)) {
        			$category_id = $store_id_str_arr[1];
        			if ($category_id) {
        				$pc_info = $this->Product_category_model->get('product_category_name', array('id'=>$category_id));
        				if ($pc_info) {
        					$category_name = $pc_info['product_category_name'];
        				}
        			}
        		}
        		if (array_key_exists("2", $store_id_str_arr)) {
        			$category_id_sub = $store_id_str_arr[2];
        			if ($category_id_sub) {
        				$pc_info = $this->Product_category_model->get('product_category_name', array('id'=>$category_id_sub));
        				if ($pc_info) {
        					$category_name_sub = $pc_info['product_category_name'];
        				}
        			}
        		}
        		if (array_key_exists("3", $store_id_str_arr)) {
        			$brand_id = $store_id_str_arr[3];
        			if ($brand_id) {
        				$brand_info = $this->Brand_model->get('brand_name', array('id'=>$brand_id));
        				if ($brand_info) {
        					$brand_name = $brand_info['brand_name'];
        				}
        			}
        		}
        		if (array_key_exists("4", $store_id_str_arr)) {
        			$style_id = $store_id_str_arr[4];
        			if ($style_id) {
        				$style_info = $this->Style_model->get('style_name', array('id'=>$style_id));
        				if ($style_info) {
        					$style_name = $style_info['style_name'];
        				}
        			}
        		}
        		if (array_key_exists("5", $store_id_str_arr)) {
        			$material_id = $store_id_str_arr[5];
        			if ($material_id) {
        				$material_info = $this->Material_model->get('material_name', array('id'=>$material_id));
        				if ($material_info) {
        					$material_name = $material_info['material_name'];
        				}
        			}
        		}
        		if (array_key_exists("6", $store_id_str_arr)) {
        			$price_id = $store_id_str_arr[6];
        			if ($price_id) {
        				$price_name = $this->_price_arr[$price_id][1];
        			}
        		}
        		if (array_key_exists("7", $store_id_str_arr)) {
        			$by = $store_id_str_arr[7];
        		}
        		if (array_key_exists("8", $store_id_str_arr)) {
        			$order = $store_id_str_arr[8];
        		}
        	}
        }
        $item_info = $this->tableObject->get('*', array('id' => $store_id, 'display' => 1));
        if (!$item_info) {
            $data = array(
                'user_msg' => '此文章不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
            exit;
        }
        if ($item_info['theme']) {
        	$this->_style = $item_info['theme'];
        }
        $strWhere = "display = 1 and store_id = {$store_id}";
        if ($category_id) {
         	if ($category_id_sub){
                $strWhere .= " and id in (select product_id from product_category_ids where product_category_id = '{$category_id_sub}' and parent_id = '{$category_id}')";
            }else{
                $strWhere .= " and id in (select product_id from product_category_ids where product_category_id = '{$category_id}' or parent_id = '{$category_id}')";
            }
        }
        if ($brand_id) {
        	$strWhere .= " and brand_name = '{$brand_name}' ";
        }
        if ($style_id) {
        	$strWhere .= " and style_name = '{$style_name}' ";
        }
        if ($material_id) {
        	$strWhere .= " and material_name = '{$material_name}' ";
        }
        if ($price_id) {
        	$price_arr = explode('-', $this->_price_arr[$price_id][0]);
        	if (count($price_arr) == 1) {
        		$strWhere .= " and sell_price >= {$price_arr[0]} ";
        	} else {
        		$strWhere .= " and (sell_price >= {$price_arr[0]} and sell_price < {$price_arr[1]}) ";
        	}
        }
        if ($_GET) {
        	$search_keyword = trim($this->input->get('search_keyword', TRUE));
        	$start_price = $this->input->get('start_price', TRUE);
        	$end_price = $this->input->get('end_price', TRUE);
        	if ($search_keyword) {
        		$keyword_info = $this->Keyword_model->get('*', array('name'=>$search_keyword));
        		if ($keyword_info) {
        			$this->Keyword_model->save(array('hits'=>$keyword_info['hits']+1), array('name'=>$keyword_info['name']));
        		} else {
        			$this->Keyword_model->save(array('name'=>$search_keyword, 'hits'=>1));
        		}
        		$strWhere .= " and (title regexp '{$search_keyword}' or keyword regexp '{$search_keyword}')";
        	}
        	if ($start_price && $end_price) {
        		$strWhere .= " and (sell_price >= {$start_price} and sell_price < {$end_price} ) ";
        	}
        }
        //分页
        $url = $systemInfo['client_index'];
        if ($systemInfo['client_index']) {
            $url .= '/';
        }
        $paginationCount = $this->Product_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = "{$url}{$this->_template}/product/{$store_id}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $paginationConfig['per_page'] = 12;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->Product_model->gets('*', $strWhere, $paginationConfig['per_page'], $page, $by, $order);
//        if($item_list){
//            foreach ($item_list as $key=>$value){
//                //主图拿第一张商品图
//                $attachment_list = NULL;
//                if ($value && $value['batch_path_ids']) {
//                    $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $value['batch_path_ids']);
//                    $attachment_list = $this->Attachment_model->gets4($tmp_atm_ids);
//                    if ($attachment_list){
//                        $item_list[$key]['path'] = $attachment_list[0]['path'];
//                    }
//                }
//            }
//        }
        //品牌
        $brand_list = $this->Brand_model->gets('id, brand_name', "store_id = {$store_id} or store_id = 0");
        //风格
        $style_list = $this->Style_model->gets("store_id = {$store_id} or store_id = 0");
        //材质
        $material_list = $this->Material_model->gets("store_id = {$store_id} or store_id = 0");

        $prv_page = $page-$paginationConfig['per_page'];
        $next_page = $page+$paginationConfig['per_page'];
        $prv_page = $prv_page < 0?0:$prv_page;
        $next_page = $next_page > $paginationCount?$page:$next_page;

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => $item_info['store_name'] . $systemInfo['site_name'],
            'keywords' => '',
            'description' => '',
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
        	'item_list' => $item_list,
            'pagination'=>$pagination,
        	'paginationCount'=>$paginationCount,
        	'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
        	'curPage'=>ceil($page/$paginationConfig['per_page'])+1,
        	'perPage'=>$paginationConfig['per_page'],
        	'page'=>$page,
        	'prv_page'=>$prv_page,
        	'next_page'=>$next_page,
            'template' => $this->_template,
        	'store_id' => $store_id,
        	'category_id'=>$category_id,
        	'category_name'=>$category_name,
        	'category_id_sub'=>$category_id_sub,
        	'category_name_sub'=>$category_name_sub,
        	'brand_id'=>$brand_id,
        	'brand_name'=>$brand_name,
        	'style_id'=>$style_id,
        	'style_name'=>$style_name,
        	'material_id'=>$material_id,
        	'material_name'=>$material_name,
        	'price_id'=>$price_id,
        	'price_name'=>$price_name,
        	'by'=>        $by,
        	'order'=>     $order,
        	'brand_list'=>$brand_list,
        	'style_list'=>$style_list,
        	'material_list'=>$material_list,
        	'store_id_str'=>$store_id_str,
        	'search_keyword'=>$search_keyword,
        	'item_info'=>$item_info,
        	'price_arr'=>$this->_price_arr,
            'style' => $this->_style
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/product_{$this->_style}", $data, TRUE)
        );
        $this->load->view('layout/store_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //信誉列表
    public function credit($store_id = NULL) {
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	$item_info = $this->tableObject->get3(array('store.id' => $store_id, 'store.display' => 1));
    	if (!$item_info) {
    		$data = array(
    				'user_msg' => '此店铺不存在',
    				'user_url' => base_url()
    		);
    		$this->session->set_userdata($data);
    		redirect('/message/index');
    		exit;
    	}
    	$item_info['des_grade'] = floatval($item_info['des_grade']);
    	$item_info['serve_grade'] = floatval($item_info['serve_grade']);
    	$item_info['express_grade'] = floatval($item_info['express_grade']);
    	if ($item_info['theme']) {
    		$this->_style = $item_info['theme'];
    	}

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => $item_info['store_name'] . $systemInfo['site_name'],
    			'keywords' => '',
    			'description' => '',
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'html' => $systemInfo['html'],
    			'item_info' => $item_info,
    			'template' => $this->_template,
    			'store_id' => $store_id,
    			'style' => $this->_style
    	);
    	$layout = array(
    			'content' => $this->load->view("{$this->_template}/credit_{$this->_style}", $data, TRUE)
    	);
    	$this->load->view('layout/store_layout', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    //单页面列表
    public function page($store_id = NULL, $id = NULL) {
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	$item_info = $this->tableObject->get3(array('store.id' => $store_id, 'store.display' => 1));
    	if (!$item_info) {
    		$data = array(
    				'user_msg' => '此店铺不存在',
    				'user_url' => base_url()
    		);
    		$this->session->set_userdata($data);
    		redirect('/message/index');
    		exit;
    	}
    	$item_info['des_grade'] = floatval($item_info['des_grade']);
    	$item_info['serve_grade'] = floatval($item_info['serve_grade']);
    	$item_info['express_grade'] = floatval($item_info['express_grade']);
    	if ($item_info['theme']) {
    		$this->_style = $item_info['theme'];
    	}
    	$nav_info = $this->Navigation_model->get('title, content', array('id'=>$id, 'display'=>1));
    	if (!$nav_info) {
    		$data = array(
    				'user_msg' => '此页面不存在',
    				'user_url' => base_url()
    		);
    		$this->session->set_userdata($data);
    		redirect('/message/index');
    		exit;
    	}

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => $item_info['store_name'] . $systemInfo['site_name'],
    			'keywords' => '',
    			'description' => '',
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'html' => $systemInfo['html'],
    			'item_info' => $item_info,
    			'template' => $this->_template,
    			'store_id' => $store_id,
    			'nav_info'=>$nav_info,
    			'style' => $this->_style
    	);
    	$layout = array(
    			'content' => $this->load->view("{$this->_template}/page_{$this->_style}", $data, TRUE)
    	);
    	$this->load->view('layout/store_layout', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    public function get_rand_store_list($type = 'c') {
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	$strWhere = "store.display = 1 ";
    	if ($type) {
    		$strWhere .= " and FIND_IN_SET('{$type}', store.custom_attribute)  ";
    	}

    	$item_list=  $this->tableObject->getsRand($strWhere, 4, 0);
    	if ($item_list) {
    		foreach ($item_list as $key=>$value) {
    			$url = getBaseUrl(false, "", "store/home/{$value['id']}.html", $systemInfo['client_index']);
    			$item_list[$key]['url'] = $url;
    			$item_list[$key]['logo_path_thumb'] = preg_replace('/\./', '_thumb.', $value['logo_path']);
    			$item_list[$key]['index_path_thumb'] = preg_replace('/\./', '_thumb.', $value['index_path']);
    		}
    	}
    	printAjaxData(array('item_list'=>$item_list));
    }
}

/* End of file main.php */
/* Location: ./application/client/controllers/main.php */