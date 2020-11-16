<?php

class Product extends CI_Controller {
	private $_price_arr = array('1'=>array('0-1000', '0-1000元'), '2'=>array('1000-3000', '1000-3000元'), '3'=>array('3000-5000', '3000-5000元'), '4'=>array('5000-10000', '5000-10000元'), '5'=>array('10000-20000', '10000-20000元'), '6'=>array('20000', '20000元以上'));
    private $_table = 'product';
    private $_template = 'product';
    private $_options_arr = array('1'=>'7天无理由退换','2'=>'45天无理由退换','3'=>'包物流','4'=>'送货入户并安装','5'=>'一年质保');

    public function __construct() {
        parent::__construct();
        $this->load->model(ucfirst($this->_table) . '_model', 'tableObject', TRUE);
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Orders_detail_model', '', TRUE);
        $this->load->model('Orders_model', '', TRUE);
        $this->load->model('Brand_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Attachment_model', '', TRUE);
        $this->load->model('Browse_model', '', TRUE);
        $this->load->model('Favorite_model', '', TRUE);
        $this->load->model('Product_category_model', '', TRUE);
        $this->load->model('Postage_way_model', '', TRUE);
        $this->load->model('Postage_price_model', '', TRUE);
        $this->load->model('Comment_model', '', TRUE);
        $this->load->model('Store_reply_comment_model', '', TRUE);
        $this->load->model('Area_model', '', TRUE);
        $this->load->model('Product_size_color_model', '', TRUE);
        $this->load->model('Style_model', '', TRUE);
        $this->load->model('Material_model', '', TRUE);
        $this->load->model('Store_model', '', TRUE);
        $this->load->model('Keyword_model', '', TRUE);
        $this->load->model('Promotion_ptkj_model', '', TRUE);
        $this->load->library('Pagination');
    }

    public function index($menu_str = '80', $page = 0) {
    	$parent_id = 80;
    	$brand_id = 0;
    	$brand_name = '';
    	$category_id = 0;
    	$category_name = '';
    	$category_id_sub = 0;
    	$category_name_sub = '';
    	$style_id = 0;
    	$style_name = '';
    	$material_id = 0;
    	$material_name = '';
    	$price_id = 0;
    	$price_name = '';
    	$by = 'id';
    	$order = 'desc';
    	$search_keyword = '';
    	if ($menu_str) {
    		$menu_str_arr = explode("-", $menu_str);
    		if ($menu_str_arr) {
    			if (array_key_exists("1", $menu_str_arr)) {
    				$brand_id = $menu_str_arr[1];
    				if ($brand_id) {
    					$brand_info = $this->Brand_model->get('brand_name', array('id'=>$brand_id));
    					if ($brand_info) {
    						$brand_name = $brand_info['brand_name'];
    					}
    				}
    			}
    			if (array_key_exists("2", $menu_str_arr)) {
    				$category_id = $menu_str_arr[2];
    				if ($category_id) {
    					$pc_info = $this->Product_category_model->get('product_category_name', array('id'=>$category_id));
    					if ($pc_info) {
    						$category_name = $pc_info['product_category_name'];
    					}
    				}
    			}
    			if (array_key_exists("3", $menu_str_arr)) {
    				$category_id_sub = $menu_str_arr[3];
    				if ($category_id_sub) {
    					$pc_info = $this->Product_category_model->get('product_category_name', array('id'=>$category_id_sub));
    					if ($pc_info) {
    						$category_name_sub = $pc_info['product_category_name'];
    					}
    				}
    			}
    			if (array_key_exists("4", $menu_str_arr)) {
    				$style_id = $menu_str_arr[4];
    				if ($style_id) {
    					$style_info = $this->Style_model->get('style_name', array('id'=>$style_id));
    					if ($style_info) {
    						$style_name = $style_info['style_name'];
    					}
    				}
    			}
    			if (array_key_exists("5", $menu_str_arr)) {
    				$material_id = $menu_str_arr[5];
    				if ($material_id) {
    					$material_info = $this->Material_model->get('material_name', array('id'=>$material_id));
    					if ($material_info) {
    						$material_name = $material_info['material_name'];
    					}
    				}
    			}
    			if (array_key_exists("6", $menu_str_arr)) {
    				$price_id = $menu_str_arr[6];
    				if ($price_id) {
    					$price_name = $this->_price_arr[$price_id][1];
    				}
    			}
    			if (array_key_exists("7", $menu_str_arr)) {
    				$by = $menu_str_arr[7];
    			}
    			if (array_key_exists("8", $menu_str_arr)) {
    				$order = $menu_str_arr[8];
    			}
    		}
    	}
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $menuInfo = $this->Menu_model->get('menu_name, keyword, abstract', array('id' => $parent_id));

        $strWhere = "{$this->_table}.display = 1 ";
        if ($brand_id) {
        	$strWhere .= " and {$this->_table}.brand_name = '{$brand_name}' ";
        }
        if ($category_id) {
        	$strWhere .= " and {$this->_table}.category_id_1 = '{$category_id}' ";
        }
        if ($category_id_sub) {
        	$strWhere .= " and {$this->_table}.category_id_2 = '{$category_id_sub}' ";
        }
        if ($style_id) {
        	$strWhere .= " and {$this->_table}.style_name = '{$style_name}' ";
        }
        if ($material_id) {
        	$strWhere .= " and {$this->_table}.material_name = '{$material_name}' ";
        }
        if ($price_id) {
            $price_arr = explode('-', $this->_price_arr[$price_id][0]);
            if (count($price_arr) == 1) {
            	$strWhere .= " and {$this->_table}.sell_price >= {$price_arr[0]} ";
            } else {
            	$strWhere .= " and ({$this->_table}.sell_price >= {$price_arr[0]} and {$this->_table}.sell_price < {$price_arr[1]}) ";
            }
        }
        if ($_GET) {
        	$search_keyword = str_replace('?','', trim($this->input->get('search_keyword', TRUE)));
        	$start_price = $this->input->get('start_price', TRUE);
        	$end_price = $this->input->get('end_price', TRUE);
        	if ($search_keyword) {
        		$keyword_info = $this->Keyword_model->get('*', array('name'=>$search_keyword));
        		if ($keyword_info) {
        			$this->Keyword_model->save(array('hits'=>$keyword_info['hits']+1), array('name'=>$keyword_info['name']));
        		} else {
        			$this->Keyword_model->save(array('name'=>$search_keyword, 'hits'=>1));
        		}

        		$strWhere .= " and ({$this->_table}.title regexp '{$search_keyword}' or {$this->_table}.keyword regexp '{$search_keyword}')";
        	}
        	if ($start_price && $end_price) {
        		$strWhere .= " and ({$this->_table}.sell_price >= {$start_price} and {$this->_table}.sell_price < {$end_price} ) ";
        	}
        }

        //判断权限
        if (!check_store_type()){
            $strWhere .= " and {$this->_table}.store_id not in (select id from store where producer_auth = 1 and id is not null)";
        }
        //分页
        $paginationCount = $this->tableObject->rowCount2($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/{$this->_template}/index/{$menu_str}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $paginationConfig['per_page'] = 20;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->tableObject->gets2($strWhere,$paginationConfig['per_page'],$page, $by, $order);
        if($item_list){
            foreach ($item_list as $key=>$value){
                //主图拿第一张商品图
                $attachment_list = NULL;
                if ($value && $value['batch_path_ids']) {
                    $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $value['batch_path_ids']);
                    $attachment_list = $this->Attachment_model->gets4($tmp_atm_ids);
                    if ($attachment_list){
                        $item_list[$key]['path'] = $attachment_list[0]['path'];
                    }
                }
            }
        }
        //国家
        $area_list = $this->Area_model->gets('id,name', array('parent_id'=>0, 'display'=>1));
        //品牌
        $brand_list = $this->Brand_model->gets('id, brand_name, path', array('display'=>1));
        //产品分类
        $product_category_list = $this->Product_category_model->gets(array('parent_id'=>0, 'display'=>1, 'store_id'=>0));
        //子产品分类
        $sub_product_category_list = NULL;
        if ($category_id) {
        	$sub_product_category_list = $this->Product_category_model->gets(array('parent_id'=>$category_id, 'display'=>1, 'store_id'=>0));
        }
        //风格
        $style_list = $this->Style_model->gets(array('display'=>1));
        //材质
        $material_list = $this->Material_model->gets(array('display'=>1));

        $prv_page = $page-$paginationConfig['per_page'];
        $next_page = $page+$paginationConfig['per_page'];
        $prv_page = $prv_page < 0?0:$prv_page;
        $next_page = $next_page > $paginationCount?$page:$next_page;

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title'=>$menuInfo['menu_name'].$systemInfo['site_name'],
            'keywords' => $menuInfo['keyword'],
            'description' => $menuInfo['abstract'],
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
        	'parent_id'=>$parent_id,
        	'template'=>$this->_template,
        	'area_list'=>$area_list,
        	'product_category_list'=>$product_category_list,
        	'sub_product_category_list'=>$sub_product_category_list,
        	'brand_list'=>$brand_list,
        	'style_list'=>$style_list,
        	'material_list'=>$material_list,
        	'brand_id'=>    $brand_id,
    	    'brand_name'=>  $brand_name,
    	    'category_id'=> $category_id,
    	    'category_name'=>$category_name,
        	'category_id_sub'=>  $category_id_sub,
        	'category_name_sub'=>$category_name_sub,
    	    'style_id'=>     $style_id,
    	    'style_name'=>   $style_name,
    	    'material_id'=>  $material_id,
    	    'material_name'=>$material_name,
    	    'price_id'=>     $price_id,
    	    'price_name'=>   $price_name,
        	'by'=>           $by,
        	'order'=>       $order,
        	'price_arr'=>    $this->_price_arr,
        	'menu_str'=>     $menu_str,
        	'search_keyword'=>$search_keyword
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
    public function detail($id = NULL, $page = 0) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $item_info = $this->tableObject->get('*', array('id' => $id));
        if (!$item_info) {
            $data = array(
                'user_msg' => '此商品不存在或被删除',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        //记录浏览次数
        $this->tableObject->save(array('hits' => $item_info['hits'] + 1), array('id' => $id));
        //主图
        $attachment_list = NULL;
        if ($item_info && $item_info['batch_path_ids']) {
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }
        $priceInfo = $this->tableObject->getPrice($id);
        if (!$priceInfo['min_price'] && !$priceInfo['max_price']) {
            $priceInfo['min_price'] = $item_info['sell_price'];
            $priceInfo['max_price'] = $item_info['sell_price'];
        }
        //当前位置
        $location = '';
        if ($systemInfo['html']) {
            $location = "<a href='index.html'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
        } else {
            $location = "<a href='{$systemInfo['client_index']}'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
        }
        $url = $systemInfo['client_index'];
        $url .= $systemInfo['client_index'] ? '/' : '';
        $url = $this->Menu_model->getLocation(80, $systemInfo['html'], $url);
        $location .= $url;
       //评论列表
        $comment_count = $this->Comment_model->rowCount(array('product_id'=>$id));
        $evaluate_a_count = $this->Comment_model->rowCount(array('product_id'=>$id,'evaluate'=>1));
        $evaluate_b_count = $this->Comment_model->rowCount(array('product_id'=>$id,'evaluate'=>2));
        $evaluate_c_count = $this->Comment_model->rowCount(array('product_id'=>$id,'evaluate'=>3));
        $comment_list = $this->Comment_model->gets('*',array('product_id'=>$id));
        if ($comment_list){
            foreach ($comment_list as $key=>$item){
                $user_info = $this->User_model->get('path', array('id'=>$item['user_id']));
                $comment_list[$key]['user_logo'] = $user_info['path'];
                $store_reply = array();
                if ($item['is_reply']){
                    $store_reply_info = $this->Store_reply_comment_model->get('content',array('comment_id'=>$item['id']));
                    if($store_reply_info){
                        $store_reply = $store_reply_info['content'];
                    }
                }
                $comment_list[$key]['store_reply'] = $store_reply;
                $comment_attachment_list = NULL;
                if($item['batch_path_ids']){
                    $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item['batch_path_ids']);
                    $comment_attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
                }
                $comment_list[$key]['attachment_list'] = $comment_attachment_list;
            }
        }
        //颜色
        $color_list = $this->Product_size_color_model->gets('id, color_id, color_name, color_name_hint, path', array('product_id'=>$id), 'color_id');
        //尺码
        $size_list = $this->Product_size_color_model->gets('id, size_id, size_name, size_name_hint', array('product_id'=>$id), 'size_id');
        //店铺信息
        $store_info = $this->Store_model->get('id, store_name', array('id'=>$item_info['store_id']));
       //用户是否收藏
        $favorite_count = $this->Favorite_model->rowCount('product', array('favorite.type'=>'product','favorite.user_id'=>get_cookie('user_id'),'favorite.item_id'=>$id));
        //用户是否收藏店铺
        $favorite_store_count = $this->Favorite_model->rowCount('store', array('favorite.type'=>'store','favorite.user_id'=>get_cookie('user_id'),'favorite.item_id'=>$item_info['store_id']));

        //团预购
        $current_time = time();
        $groupon_info = $this->Promotion_ptkj_model->get('id',"product_id = {$id} and is_open = 1 and start_time <= $current_time and end_time > $current_time and is_success = 0");

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $item_info['title'] . $systemInfo['site_name'],
            'keywords' => $item_info['keyword'],
            'description' => $item_info['abstract'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'systemInfo' => $systemInfo,
            'item_info' => $item_info,
            'store_info'=> $store_info,
            'attachment_list' => $attachment_list,
            'location' => $location,
            'parent_id' => '80',
            'priceInfo' => $priceInfo,
            'color_list'=>$color_list,
            'size_list'=>$size_list,
            'comment_count'=>$comment_count,
            'evaluate_a_count'=>$evaluate_a_count,
            'evaluate_b_count'=>$evaluate_b_count,
            'evaluate_c_count'=>$evaluate_c_count,
            'comment_list'=>$comment_list,
            'favorite_count' => $favorite_count,
            'favorite_store_count' => $favorite_store_count,
            'options_arr' => $this->_options_arr,
            'groupon_info' => $groupon_info,
        );
        if ($item_info['unclear_price']){
            $layout = array(
                'content' => $this->load->view("{$this->_template}/detail_2", $data, TRUE)
            );
        }else{
            $layout = array(
                'content' => $this->load->view("{$this->_template}/detail", $data, TRUE)
            );
        }

        $this->load->view('layout/default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //收藏商品/店铺
    public function save_favorite() {
        checkLoginAjax();
        if ($_POST) {
        	$type = $this->input->post('type');
            $item_id = $this->input->post('item_id');
            if (!$item_id || !$type) {
                printAjaxError('fail', '操作异常，刷新重试');
            }
            $item_info = NULL;
            if ($type == 'store') {
            	$item_info = $this->Store_model->get('favorite_num', array('id' => $item_id));
            	if (!$item_info) {
            		printAjaxError('fail', '此店铺不存在，收藏失败');
            	}
            } else {
            	$item_info = $this->tableObject->get('favorite_num', array('id' => $item_id));
            	if (!$item_info) {
            		printAjaxError('fail', '此商品不存在，收藏失败');
            	}
            }

            $favorite_info = $this->Favorite_model->get('id', array('item_id' => $item_id, 'user_id' => get_cookie('user_id'), 'type'=>$type));
            if ($favorite_info) {
            	if ($this->Favorite_model->delete(array('id'=>$favorite_info['id']))) {
            		if ($type == 'store') {
            			$this->Store_model->save(array('favorite_num' => $item_info['favorite_num'] - 1 > 0?$item_info['favorite_num'] - 1:0), array('id' => $item_id));
            		} else {
            			$this->tableObject->save(array('favorite_num' => $item_info['favorite_num'] - 1 > 0?$item_info['favorite_num'] - 1:0), array('id' => $item_id));
            		}
            		printAjaxData(array('action'=>'delete', 'id'=>$favorite_info['id']));
            	} else {
                    printAjaxError('fail', '收藏失败');
            	}
            } else {
            	$fields = array(
            			'item_id' => $item_id,
            			'type'=>     $type,
            			'user_id' => get_cookie('user_id'),
            			'add_time' => time()
            	    );
            	$ret_id = $this->Favorite_model->save($fields);
            	if ($ret_id) {
            		if ($type == 'store') {
            			$this->Store_model->save(array('favorite_num' => $item_info['favorite_num'] + 1), array('id' => $item_id));
            		} else {
            			$this->tableObject->save(array('favorite_num' => $item_info['favorite_num'] + 1), array('id' => $item_id));
            		}
            		printAjaxData(array('action'=>'add', 'id'=>$ret_id));
            	} else {
            		printAjaxError('fail', '收藏失败');
            	}
            }
        }
    }

    //获取库存
    public function get_stock() {
        if ($_POST) {
            $product_id = $this->input->post('product_id');
            $color_id = $this->input->post('color_id', TRUE);
            $size_id = $this->input->post('size_id', TRUE);

            if (!$product_id || !$color_id || !$size_id) {
                printAjaxError('fail', '操作异常');
            }
            if ($product_id && $color_id && $size_id) {
                $item_info = $this->tableObject->getProductStock($product_id, $color_id, $size_id);
                if ($item_info) {
                    printAjaxData($item_info);
                } else {
                    printAjaxError('fail', '获取失败');
                }
            }
        }
    }
}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */