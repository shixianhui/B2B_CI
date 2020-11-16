<?php
class Product extends CI_Controller {
    private $_title = '商品管理';
    private $_tool = '';
    private $_table = '';
    private $_display_arr = array(
        '1' => '<font color="#ff4200">上架</font>',
        '0' => '<font color="#cc3333">下架</font>',
        '2' => '放入仓库',
    );
    private $_attribute_arr = array(
        'a' => '人气推荐',
        'f' => '热门关注'
    );

    private $_attribute_arr_2 = array(
    		'a' => '<font color=#FF0000>人气推荐</font>',
    		'f' => '<font color=#FF0000>热门关注</font>'
    );
    private $_options_arr = array('1'=>'7天无理由退换','2'=>'45天无理由退换','3'=>'包物流','4'=>'送货入户并安装','5'=>'一年质保');

    public function __construct() {
        parent::__construct();
        //获取表名
        $this->_table = $this->uri->segment(1);
        //快捷方式
        $this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'商品管理', 'title'=>'商品'), TRUE);
        //获取表对象
        $this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('Brand_model', '', TRUE);
        $this->load->model('product_size_color_model', '', TRUE);
        $this->load->model('Postage_way_model', '', TRUE);
        $this->load->model('Product_category_model', '', TRUE);
        $this->load->model('Product_category_ids_model', '', TRUE);
        $this->load->model('Favorite_model', '', TRUE);
        $this->load->model('Browse_model', '', TRUE);
        $this->load->model('Style_model', '', TRUE);
        $this->load->model('Store_category_model', '', TRUE);
        $this->load->model('Material_model', '', TRUE);
        $this->load->model('Fabric_model', '', TRUE);
        $this->load->model('Leather_model', '', TRUE);
        $this->load->model('Filler_model', '', TRUE);
        $this->load->helper(array('url', 'my_fileoperate'));
        $this->load->library(array('Form_validation'));
    }

    public function index($clear = 0, $page = 0) {
        clearSession(array('search'));
		if ($clear) {
			$clear = 0;
		    $this->session->unset_userdata(array('search'=>''));
		}
		$uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
		$uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/{$clear}/{$page}";
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>$uri_sg));
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):NULL;
		//属性
		$floor_menu_list = $this->Menu_model->gets('id, menu_name', array('parent'=>294));
		if ($floor_menu_list) {
			foreach ($floor_menu_list as $key=>$value) {
				$this->_attribute_arr[$value['id']] = $value['menu_name'];
				$this->_attribute_arr_2[$value['id']] = '<font color=#FF0000>'.$value['menu_name'].'</font>';
			}
		}
        if ($_POST) {
            $strWhere = "{$this->_table}.id > 0";

            $id = trim($this->input->post('id'));
            $title =  trim($this->input->post('title'));
            $product_num =  trim($this->input->post('product_num'));
            $display = $this->input->post('display');
            $category_id = $this->input->post('select_category_id');
            $custom_attribute = $this->input->post('custom_attribute');
            $pay_mode = $this->input->post('pay_mode');
            $startTime = $this->input->post('inputdate_start');
            $endTime = $this->input->post('inputdate_end');

            if ($id) {
            	$strWhere .= " and {$this->_table}.id = '{$id}' ";
            }
            if (!empty($title)) {
                $strWhere .= " and {$this->_table}.title REGEXP '{$title}' ";
            }
            if ($product_num) {
                $strWhere .= " and {$this->_table}.product_num = '{$product_num}' ";
            }
            if ($display != "") {
                $strWhere .= " and {$this->_table}.display={$display} ";
            }
            if ($category_id) {
                $category_id = explode(',',$category_id);
                foreach ($category_id as $key=>$value){
                    if (!empty($value)){
                        $k = $key+1;
                        $strWhere .= " and {$this->_table}.category_id_{$k} = {$value} ";
                    }
                }
            }
            if ($custom_attribute) {
                $strWhere .= " and FIND_IN_SET('{$custom_attribute}', {$this->_table}.custom_attribute) ";
            }
            if ($pay_mode != "") {
                $strWhere .= " and {$this->_table}.pay_mode={$pay_mode} ";
            }
            if (!empty($startTime) && !empty($endTime)) {
                $strWhere .= " and {$this->_table}.add_time > " . strtotime($startTime . ' 00:00:00') . " and {$this->_table}.add_time < " . strtotime($endTime . ' 23:59:59') . " ";
            }
            $this->session->set_userdata('search', $strWhere);
        }

        //分页
        $this->config->load('pagination_config', TRUE);
        $paginationCount = $this->tableObject->rowCount($strWhere);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "admincp.php/{$this->_table}/index/{$clear}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->tableObject->gets('*', $strWhere, $paginationConfig['per_page'], $page);
        foreach ($item_list as $key => $value) {
            $item_list[$key]['title'] = $value['title'] . '&nbsp;&nbsp;' . $this->tableObject->attribute($this->_attribute_arr_2, $value['custom_attribute']);
            //分类
            $product_category_str = '';
            $p_c_i_list = $this->Product_category_ids_model->gets('*', array('product_id' => $value['id']));
            if ($p_c_i_list) {
                foreach ($p_c_i_list as $p_c_i_key => $p_c_i_value) {
                    $product_category_str .= $this->Product_category_model->getLocation($p_c_i_value['product_category_id']) . '<br/>';
                }
                if ($product_category_str) {
                    $product_category_str = substr($product_category_str, 0, -1);
                }
            }
            $item_list[$key]['product_category_str'] = $product_category_str;

            $category_str = '';
            $category_arr = array($value['category_id_1'],$value['category_id_2'],$value['category_id_3'],$value['category_id_4'],$value['category_id_5']);
            foreach ($category_arr as $k => $v){
                if ($v){
                    $category_info = $this->Product_category_model->get('product_category_name',array('id'=>$v));
                    if ($k == 0){
                        $category_str .=  $category_info ? $category_info['product_category_name'] : '';
                    }else{
                        $category_str .=  $category_info ? " -> ".$category_info['product_category_name'] : '';
                    }

                }
            }
            $item_list[$key]['category_str'] = $category_str;
        }

        $product_category = $this->Product_category_model->menuTree();

        $data = array(
            'tool' => $this->_tool,
        	'clear'=>$clear,
        	'table'=> $this->_table,
        	'display_arr'=>$this->_display_arr,
        	'attribute_arr' => $this->_attribute_arr,
            'item_list' => $item_list,
            'product_category' => $product_category,
            'pagination' => $pagination,
            'paginationCount' => $paginationCount,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page'])
        );

        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_table}/index", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function selector($page = 0) {
        if (!$this->uri->segment(2)) {
            $this->session->unset_userdata(array('search' => ''));
        }
        $this->session->set_userdata(array("{$this->_table}RefUrl" => base_url() . 'admincp.php/' . uri_string()));
        $strWhere = $this->session->userdata('search') ? $this->session->userdata('search') : NULL;
        //属性
        $floor_menu_list = $this->Menu_model->gets('id, menu_name', array('parent'=>294));
        if ($floor_menu_list) {
            foreach ($floor_menu_list as $key=>$value) {
                $this->_attribute_arr[$value['id']] = $value['menu_name'];
                $this->_attribute_arr_2[$value['id']] = '<font color=#FF0000>'.$value['menu_name'].'</font>';
            }
        }
        if ($_POST) {
            $strWhere = "{$this->_table}.id > 0";
            $title = $this->input->post('title');
            $product_num = $this->input->post('product_num');
            $display = $this->input->post('display');
            $category_id = $this->input->post('category_id');
            $custom_attribute = $this->input->post('custom_attribute');
            $startTime = $this->input->post('inputdate_start');
            $endTime = $this->input->post('inputdate_end');

            if (!empty($title)) {
                $strWhere .= " and {$this->_table}.title like '%" . $title . "%'";
            }
            if ($product_num) {
                $strWhere .= " and {$this->_table}.product_num = '{$product_num}' ";
            }
            if ($display != "") {
                $strWhere .= " and {$this->_table}.display={$display} ";
            }
            if ($category_id) {
                $ids = $this->Menu_model->getChildMenus($category_id);
                $strWhere .= " and {$this->_table}.category_id in ({$ids}) ";
            }
            if ($custom_attribute) {
                $strWhere .= " and {$this->_table}.custom_attribute like '%{$custom_attribute}' or {$this->_table}.custom_attribute like '{$custom_attribute}%' or {$this->_table}.custom_attribute like '%,{$custom_attribute},%' ";
            }
            if (!empty($startTime) && !empty($endTime)) {
                $strWhere .= " and {$this->_table}.add_time > " . strtotime($startTime . ' 00:00:00') . " and {$this->_table}.add_time < " . strtotime($endTime . ' 23:59:59') . " ";
            }
            $this->session->set_userdata('search', $strWhere);
        }

        //分页
        $this->config->load('pagination_config', TRUE);
        $paginationCount = $this->tableObject->rowCount($strWhere);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "admincp.php/{$this->_table}/index/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 3;
        $paginationConfig['per_page'] = 10000;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $productList = $this->tableObject->gets('*', $strWhere, $paginationConfig['per_page'], $page);
        foreach ($productList as $key => $value) {
            $productList[$key]['title'] = $value['title'] . '&nbsp;&nbsp;' . $this->tableObject->attribute($this->_attribute_arr_2, $value['custom_attribute']);
            $productList[$key]['product_title'] = $value['title'];
            //分类
            $product_category_str = '';
            $p_c_i_list = $this->Product_category_ids_model->gets('*', array('product_id' => $value['id']));
            if ($p_c_i_list) {
                foreach ($p_c_i_list as $p_c_i_key => $p_c_i_value) {
                    $product_category_str .= $this->Product_category_model->getLocation($p_c_i_value['product_category_id']) . '<br/>';
                }
                if ($product_category_str) {
                    $product_category_str = substr($product_category_str, 0, -1);
                }
            }
            $productList[$key]['product_category_str'] = $product_category_str;
        }
        $data = array(
            'tool' => $this->_tool,
            'productList' => $productList,
            'pagination' => $pagination,
            'paginationCount' => $paginationCount,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
            'displayArr' => $this->_display_arr,
            'attribute_arr' => $this->_attribute_arr,
        );

        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_table}/selector", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function save($id = NULL) {

        $prfUrl = $this->session->userdata("{$this->_table}RefUrl") ? $this->session->userdata("{$this->_table}RefUrl") : base_url() . "admincp.php/{$this->_table}/index/1";
        if ($_POST) {
            $store_id = $this->input->post('store_id', TRUE);
            $category_ids = $this->input->post('category_ids', TRUE);
            $product_category_id_arr = $this->input->post('product_category_id', TRUE);
            $brand_name = $this->input->post('brand_name', TRUE);
            $material_name = $this->input->post('material_name', TRUE);
            $fabric_name = $this->input->post('fabric_name', TRUE);
            $leather_name = $this->input->post('leather_name', TRUE);
            $filler_name = $this->input->post('filler_name', TRUE);
            $style_name = $this->input->post('style_name', TRUE);
            $sell_price = $this->input->post('sell_price', TRUE);
            $market_price = $this->input->post('market_price', TRUE);
            $stock = $this->input->post('stock', TRUE);
            $weight = $this->input->post('weight', TRUE);
            $give_score = $this->input->post('give_score', TRUE);
            $consume_score = $this->input->post('consume_score', TRUE);
            $product_num = $this->input->post('product_num', TRUE);
            $title = $this->input->post('title', TRUE);
            $content = $this->input->post('content');
            $app_content = $this->input->post('app_content');
            $custom_attribute = $this->input->post('custom_attribute', TRUE);
            $is_promise = $this->input->post('is_promise', TRUE);
            $service_options = $this->input->post('service_options', TRUE);
            $reduced_price = $this->input->post('reduced_price', TRUE);
            if (!empty($custom_attribute)) {
                $custom_attribute = implode($custom_attribute, ',');
            } else {
                $custom_attribute = '';
            }
            /**************************规格开始**************************/
            $product_color_name = $this->input->post('product_color_name', TRUE);
            $product_size_name = $this->input->post('product_size_name', TRUE);
            $color_size_open = $this->input->post('color_size_open', TRUE);
            //颜色
            $attribute_color_ids = $this->input->post('attribute_color_ids', TRUE);
            $attribute_color_name = $this->input->post('attribute_color_name', TRUE);
            $attribute_color_hint = $this->input->post('attribute_color_hint', TRUE);
            $attribute_path = $this->input->post('attribute_path', TRUE);
            //尺码
            $attribute_size_ids = $this->input->post('attribute_size_ids', TRUE);
            $attribute_size_name = $this->input->post('attribute_size_name', TRUE);
            $attribute_size_hint = $this->input->post('attribute_size_hint', TRUE);
            //属性价格
            $attribute_price = $this->input->post('attribute_price', TRUE);
            //属性数量
            $attribute_stock = $this->input->post('attribute_stock', TRUE);
            //属性编号
            $attribute_product_num = $this->input->post('attribute_product_num', TRUE);
            /**************************规格结束**************************/

            if (!$store_id) {
            	printAjaxError('fail', '请选择店铺');
            }
            if (!$category_ids) {
            	printAjaxError('fail', '请选择产品分类');
            }
            $store_product_category =  $this->Product_category_model->menuTree($store_id);
            if($store_product_category){
                if(!$product_category_id_arr){
                    printAjaxError('product_category_id', '请选择店铺产品分类!');
                }
            }
            if (!$this->form_validation->required($title)) {
            	printAjaxError('title', '产品名称不能为空!');
            }
            //开启了规格
            if ($color_size_open) {
                if (!$product_color_name || !$product_size_name) {
                	printAjaxError('fail', '请填写规格名称');
                }
                if (!$attribute_color_ids) {
                	printAjaxError('fail', "请选择{$product_color_name}");
                }
                if (!$attribute_size_ids) {
                	printAjaxError('fail', "请选择{$product_size_name}");
                }
                //颜色名称
                foreach ($attribute_color_ids as $key=>$value) {
                    if (!$attribute_color_name[$key]) {
                    	printAjaxError('fail', "{$product_color_name}主属性存在没有填写项");
                    }
                }
                $attribute_color_name_filter = array_unique($attribute_color_name);
                if (count($attribute_color_name) != count($attribute_color_name_filter)) {
                	printAjaxError('fail', "{$product_color_name}主属性存在重复项");
                }
                //尺码名称
                foreach ($attribute_size_ids as $key=>$value) {
                	if (!$attribute_size_name[$key]) {
                		printAjaxError('fail', "{$product_size_name}主属性存在没有填写项");
                	}
                }
                $attribute_size_name_filter = array_unique($attribute_size_name);
                if (count($attribute_size_name) != count($attribute_size_name_filter)) {
                	printAjaxError('fail', "{$product_size_name}主属性存在重复项");
                }
                //价格
                foreach ($attribute_price as $value) {
                	if (!$value) {
                		printAjaxError('fail', '属性价格存在没有填写的项!');
                	}
                	if (!$this->form_validation->numeric($value)) {
                		printAjaxError('fail', '请填写正确的属性价格!');
                	}
                }
                //库存
                foreach ($attribute_stock as $value) {
                	if (!$this->form_validation->required($value)) {
                		printAjaxError('fail', '属性库存存在没有填写的项!');
                	}
                	if (!$this->form_validation->integer($value)) {
                		printAjaxError('fail', '请填写正确的属性库存!');
                	}
                }
            }
            if (!$this->form_validation->required($market_price)) {
            	printAjaxError('market_price', '市场价不能为空!');
            }
            if (!$this->form_validation->numeric($market_price)) {
            	printAjaxError('market_price', '请输入正确的市场价!');
            }
            if (!$this->form_validation->required($sell_price)) {
                printAjaxError('sell_price', '出售价不能为空!');
            }
            if (!$this->form_validation->numeric($sell_price)) {
                printAjaxError('sell_price', '请输入正确的出售价!');
            }
            if (!$this->form_validation->required($stock)) {
                printAjaxError('stock', '库存数量不能为空!');
            }
            if (!$this->form_validation->integer($stock)) {
                printAjaxError('stock', '请输入正确的库存数量!');
            }
            if ($weight) {
                if (!$this->form_validation->numeric($weight)) {
                    printAjaxError('weight', '请输入正确的重量!');
                }
            }
            if ($give_score) {
                if (!$this->form_validation->integer($give_score)) {
                    printAjaxError('give_score', '请输入正确积分数量!');
                }
            }
            if ($consume_score) {
                if (!$this->form_validation->integer($consume_score)) {
                    printAjaxError('$consume_score', '请输入正确积分数量!');
                }
            }
            if (!$this->form_validation->required($content)) {
                printAjaxError('content', '产品描述不能为空!');
            }
            if (!$this->form_validation->required($app_content)) {
                printAjaxError('content', 'App产品描述不能为空!');
            }
            //产品分类－$category_ids
            $category_id_1 = 0;
            $category_id_2 = 0;
            $category_id_3 = 0;
            $category_id_4 = 0;
            $category_id_5 = 0;
            $category_ids_arr = explode(',', $category_ids);
            if ($category_ids_arr) {
                if (count($category_ids_arr) >= 1) {
                	$category_id_1 = $category_ids_arr[0];
                }
                if (count($category_ids_arr) >= 2) {
                	$category_id_2 = $category_ids_arr[1];
                }
                if (count($category_ids_arr) >= 3) {
                	$category_id_3 = $category_ids_arr[2];
                }
                if (count($category_ids_arr) >= 4) {
                	$category_id_4 = $category_ids_arr[4];
                }
                if (count($category_ids_arr) >= 5) {
                	$category_id_5 = $category_ids_arr[5];
                }
            }
            if ($service_options){
                $service_options = implode(',',$service_options);
            }

            $fields = array(
            	'store_id'=>          $store_id,
            	'product_color_name'=>$product_color_name,
            	'product_size_name'=> $product_size_name,
            	'color_size_open'=>   $color_size_open,
            	'category_id_1'=>$category_id_1,
            	'category_id_2'=>$category_id_2,
            	'category_id_3'=>$category_id_3,
            	'category_id_4'=>$category_id_4,
            	'category_id_5'=>$category_id_5,
                'brand_name' =>  $brand_name,
            	'material_name' =>  $material_name,
            	'fabric_name' =>  $fabric_name,
            	'leather_name' =>  $leather_name,
            	'filler_name' =>  $filler_name,
            	'style_name' =>  $style_name,
                'sell_price' => $sell_price,
                'market_price' => $market_price,
                'stock' => $stock,
                'weight' => $weight,
                'give_score' => $give_score,
                'consume_score' => $consume_score,
                'product_num' => $product_num,
                'title' => $title,
                'keyword' => $this->input->post('keyword', TRUE),
                'abstract' => $this->input->post('abstract', TRUE),
                'content' => unhtml($content),
                'app_content' => unhtml($app_content),
                'hits' => $this->input->post('hits', TRUE),
                'sales' => $this->input->post('sales', TRUE),
                'custom_attribute' => $custom_attribute,
                'path' => $this->input->post('path', TRUE),
                'batch_path_ids' => $this->input->post('batch_path_ids', TRUE),
                'display' => $this->input->post('display', TRUE),
                'remark' => $this->input->post('remark', TRUE),
                'add_time' => strtotime($this->input->post('add_time')),
                'display_time' => time(),
                'is_promise' => $is_promise,
                'service_options' => $service_options,
                'reduced_price' => $reduced_price,
            );
            $retId = $this->tableObject->save($fields, $id ? array('id' => $id) : $id);
            if ($retId) {
                $retId = $id ? $id : $retId;
                /** **********************尺寸颜色属性****************************** */
                $this->product_size_color_model->delete(array('product_id'=> $retId));
                if ($color_size_open) {
                	if ($attribute_color_ids && $attribute_size_ids) {
                		foreach ($attribute_color_ids as $key => $value) {
                			foreach ($attribute_size_ids as $s_key=>$s_value) {
                				$color_size_fields = array(
                						'color_name' =>    $attribute_color_name[$key],
                						'color_name_hint'=>$attribute_color_hint[$key],
                						'color_id'=>       $key+1,
                						'path' =>          $attribute_path[$key],
                						'size_name' =>     $attribute_size_name[$s_key],
                						'size_name_hint'=> $attribute_size_hint[$s_key],
                						'size_id'=>        $s_key+1,
                						'price' =>         $attribute_price[$key*count($attribute_size_ids) + $s_key],
                						'stock' =>         $attribute_stock[$key*count($attribute_size_ids) + $s_key],
                						'product_num' =>   $attribute_product_num[$key*count($attribute_size_ids) + $s_key],
                						'product_id' =>    $retId
                				);
                				$this->product_size_color_model->save($color_size_fields);
                			}
                		}
                	}
                }
                /*                 * ****************添加本店分类ID******************** */
                $this->Product_category_ids_model->delete(array('product_id' => $retId));
                if ($product_category_id_arr) {
                    foreach ($product_category_id_arr as $key => $value) {
                        $id_arr = explode(",", $value);
                            if($id_arr){
                                $pc_fields = array(
                                    'parent_id' => count($id_arr)==1 ? 0 : $id_arr[0],
                                    'product_category_id' => count($id_arr)>1 ? $id_arr[1] : $id_arr[0] ,
                                    'product_id' => $retId
                                );
                            }
                            $this->Product_category_ids_model->save($pc_fields);
                    }
                }
                printAjaxSuccess($prfUrl);
            } else {
                printAjaxError("操作失败！");
            }
        }
       //产品分类
        $product_category_list = $this->Product_category_model->menuTree();
        $color_size_list = NULL;
        $color_list = NULL;
        $size_list = NULL;
        //产品详细
        $item_info = $this->tableObject->get(array("{$this->_table}.id" => $id));
        if ($item_info) {
            //颜色与尺寸
        	$color_list = $this->product_size_color_model->gets('color_name, color_id, color_name_hint, path', array('product_id' => $item_info['id']), 'color_id');
        	$size_list = $this->product_size_color_model->gets('size_name, size_id, size_name_hint', array('product_id' => $item_info['id']), 'size_id');
        	$color_size_list = $color_list;
                foreach ($color_size_list as $key => $value) {
                    $color_size_list[$key]['size_list'] = $this->product_size_color_model->gets('*', array('product_id' => $item_info['id'], 'color_id' => $value['color_id']), 'size_id');
                }
        }
        $tmp_product_num = '';
        $tmp_product_info = $this->tableObject->get2("max(id) as 'max_id'");
        if ($tmp_product_info) {
            $tmp_product_num = sprintf("C%06d", $tmp_product_info['max_id'] + 1);
        }
        //品牌
        $brand_item_list = $this->Brand_model->gets(array('display'=>1));
        //风格
        $style_item_list = $this->Style_model->gets(array('display'=>1));
        //材质
        $material_item_list = $this->Material_model->gets(array('display'=>1));
        //面料
        $fabric_item_list = $this->Fabric_model->gets(array('display'=>1));
        //皮革
        $leather_item_list = $this->Leather_model->gets(array('display'=>1));
        //填充物
        $filler_item_list = $this->Filler_model->gets(array('display'=>1));
        //属性
        $floor_menu_list = $this->Menu_model->gets('id, menu_name', array('parent'=>294));
        if ($floor_menu_list) {
        	foreach ($floor_menu_list as $key=>$value) {
        		$this->_attribute_arr[$value['id']] = $value['menu_name'];
        	}
        }
        //店铺产品分类
        $store_product_category_list = NULL;
        if ($item_info && $item_info['store_id']) {
        	$store_product_category_list = $this->Product_category_model->menuTree($item_info['store_id']);
        }
        $pci_info = $this->Product_category_ids_model->gets('product_category_id', array('product_id' => $id));

       $data = array(
            'tool' => $this->_tool,
            'item_info' => $item_info,
            'tmp_product_num' => $tmp_product_num,
            'color_size_list' => $color_size_list,
            'color_list'=>$color_list,
            'size_list'=>$size_list,
            'brand_item_list'=>$brand_item_list,
            'style_item_list'=>$style_item_list,
            'material_item_list'=>$material_item_list,
            'fabric_item_list'=>$fabric_item_list,
            'leather_item_list'=>$leather_item_list,
            'filler_item_list'=>$filler_item_list,
            'prfUrl' => $prfUrl,
            'product_category_list' => $product_category_list,
            'displayArr' => $this->_display_arr,
            'attribute_arr' => $this->_attribute_arr,
            'options_arr' => $this->_options_arr,
            'store_product_category_list' => $store_product_category_list,
            'pci_info' => $pci_info
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_table}/save", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function sort() {
        $ids = $this->input->post('ids', TRUE);
        $sorts = $this->input->post('sorts', TRUE);

        if (!empty($ids) && !empty($sorts)) {
            $ids = explode(',', $ids);
            $sorts = explode(',', $sorts);

            foreach ($ids as $key => $value) {
                $this->tableObject->save(
                        array('sort' => $sorts[$key]), array('id' => $value));
            }
            printAjaxSuccess('排序成功！');
        }

        printAjaxError('排序失败！');
    }

    public function category() {
        $ids = $this->input->post('ids', TRUE);
        $categoryId = $this->input->post('categoryId', TRUE);
        $data['success'] = FALSE;

        if (!empty($ids) && !empty($categoryId)) {
            if ($this->tableObject->save(array('category_id' => $categoryId), 'id in (' . $ids . ')')) {
                printAjaxSuccess('修改栏目成功！');
            }
        }

        printAjaxError('修改栏目失败！');
    }

    public function attribute() {
        $ids = $this->input->post('ids', TRUE);
        $customAttribute = $this->input->post('custom_attribute', TRUE);

        if (!empty($ids) && !empty($customAttribute)) {
            if ($customAttribute == 'clear') {
                $customAttribute = '';
            }
            if ($this->tableObject->save(array('custom_attribute' => $customAttribute), 'id in (' . $ids . ')')) {
                printAjaxSuccess('属性修改成功！');
            }
        }

        printAjaxError('属性修改失败！');
    }

    public function delete() {
        $ids = $this->input->post('ids', TRUE);
        //购物车
        $this->load->model('Cart_model', '', TRUE);
        if ($this->Cart_model->rowCount("product_id in ({$ids})")) {
            printAjaxError('购物车存在关联数据，删除失败！');
        }
        //订单详细
        $this->load->model('Orders_detail_model', '', TRUE);
        if ($this->Orders_detail_model->rowCount("product_id in ({$ids})")) {
            printAjaxError('订单详细存在关联数据，删除失败！');
        }

        if (!empty($ids)) {
            if ($this->tableObject->delete('id in (' . $ids . ')')) {
                //删除浏览记录
                $this->Browse_model->delete("item_id in ({$ids}) and type = 'product'");
                //删除收藏记录
                $this->Favorite_model->delete("item_id in ({$ids}) and type = 'product'");
                //删除属性
                $this->product_size_color_model->delete("product_id in ({$ids})");
                //删除分类信息
                $this->Product_category_ids_model->delete("product_id in ({$ids})");
                printAjaxData(array('ids' => explode(',', $ids)));
            }
        }

        printAjaxError('删除失败！');
    }

    public function getKeycode() {
        $this->load->library('Splitwordclass');
        $title = $this->input->post('title', TRUE);
        if ($title) {
            $splitword = new Splitwordclass();
            $keycode = $splitword->SplitRMM(iconv("UTF-8", "gbk", $title));
            $splitword->Clear();
            $keycode = iconv("gbk", "UTF-8", $keycode);
            printAjaxData(array('keycode' => $keycode));
        }
    }

    public function display() {
        $ids = $this->input->post('ids');
        $display = $this->input->post('display');

        if (!empty($ids) && $display != "") {
            if ($this->tableObject->save(array('display' => $display, 'display_time' => time()), 'id in (' . $ids . ')')) {
                printAjaxSuccess('', '修改状态成功！');
            }
        }

        printAjaxError('修改状态失败！');
    }

    //活动属性
    public function pay_mode() {
        $ids = $this->input->post('ids');
        $pay_mode = $this->input->post('pay_mode');

        if (!empty($ids) && $pay_mode != "") {
            if ($this->tableObject->save(array('pay_mode' => $pay_mode), 'id in (' . $ids . ')')) {
                printAjaxSuccess('', '修改活动属性成功！');
            }
        }

        printAjaxError('修改活动属性失败！');
    }

    //店铺产品分类
    public function change_store_category($store_id = 0){
       $store_product_category_list = $this->Product_category_model->menuTree($store_id);
       printAjaxData(array('item_list'=>$store_product_category_list));
    }

    public function get_brand_size_color_list() {
        if ($_POST) {
            $product_size_color_brand_id = $this->input->post('product_size_color_brand_id');
            $product_id = $this->input->post('product_id');

            $brand_list = array();
            $size_list = array();
            $color_list = array();

            $color_arr = array();
            $size_arr = array();
            $path_arr = array();

            if (!empty($product_size_color_brand_id)) {
                $pscb_info = $this->Product_size_color_brand_model->get('*', array('id' => $product_size_color_brand_id));
                if (!empty($pscb_info)) {
                    if ($pscb_info['brand_category_id']) {
                        $brand_list = $this->Brand_model->gets("brand.brand_category_id = {$pscb_info['brand_category_id']}");
                    }
                    if ($pscb_info['size_category_id']) {
                        $size_list = $this->Size_model->gets("size.size_category_id = {$pscb_info['size_category_id']}");
                    }
                    if ($pscb_info['color_category_id']) {
                        $color_list = $this->Color_model->gets("color.color_category_id = {$pscb_info['color_category_id']}");
                    }
                }
            }
            if (!empty($product_id)) {
                //颜色与尺寸
                $product_size_color_list = $this->product_size_color_model->gets('*', array('product_id' => $product_id));
                foreach ($product_size_color_list as $key => $value) {
                    $color_arr[$key]['color_id'] = $value['color_id'];
                    $color_arr[$key]['color_name'] = $value['color_name'];
                    $size_arr[$key]['size_id'] = $value['size_id'];
                    $size_arr[$key]['size_name'] = $value['size_name'];
                    $path_arr[$key]['color_id'] = $value['color_id'];
                    $path_arr[$key]['path'] = $value['path'];
                }
            }

            $data = array(
                'brand_list' => $brand_list,
                'size_list' => $size_list,
                'color_list' => $color_list,
                'color_arr' => $color_arr,
                'size_arr' => $size_arr,
                'path_arr' => $path_arr
            );
            printAjaxData($data);
        }
    }

    //品牌
    public function get_brand_list() {
    	if ($_POST) {
    		$item_name = trim($this->input->post('item_name', TRUE));
    		$store_id = trim($this->input->post('store_id', TRUE));
            if ($store_id){
                $strWhere = "store_id = {$store_id}";
            }else{
                $strWhere = "display = 1 ";
            }
    		if ($item_name) {
    			$strWhere .= " and (first_letter REGEXP '^{$item_name}' or brand_name REGEXP '^{$item_name}') ";
    		}

    		$item_list = $this->Brand_model->gets($strWhere);
    		if (!$item_list) {
    			printAjaxError('fail', '没有数据');
    		}
    		printAjaxData($item_list);
    	}
    }

    //风格
    public function get_style_list() {
    	if ($_POST) {
    		$style_name = trim($this->input->post('item_name', TRUE));
            $store_id = trim($this->input->post('store_id', TRUE));

            if ($store_id){
                $strWhere = "store_id = {$store_id}";
            }else{
                $strWhere = "display = 1 ";
            }
    		if ($style_name) {
    			$strWhere .= " and style_name REGEXP '^{$style_name}' ";
    		}
    		$item_list = $this->Style_model->gets($strWhere);
    		if (!$item_list) {
    			printAjaxError('fail', '没有数据');
    		}
    		printAjaxData($item_list);
    	}
    }

    //材质
    public function get_material_list() {
    	if ($_POST) {
    		$material_name = trim($this->input->post('item_name', TRUE));
            $store_id = trim($this->input->post('store_id', TRUE));

            if ($store_id){
                $strWhere = "store_id = {$store_id}";
            }else{
                $strWhere = "display = 1 ";
            }
    		if ($material_name) {
    			$strWhere .= " and material_name REGEXP '^{$material_name}' ";
    		}
    		$item_list = $this->Material_model->gets($strWhere);
    		if (!$item_list) {
    			printAjaxError('fail', '没有数据');
    		}
    		printAjaxData($item_list);
    	}
    }

    public function import() {
        if ($_POST) {
            $categoryId = $this->input->post('category_id', TRUE);
            $ret = $this->_upload('filePath');
            if (!$ret) {
                printAjaxError('文件上传失败！');
            }
            ignore_user_abort(true); // run script in background
            set_time_limit(0); // run script forever,运行时间为无限后结束
            $handle = fopen("./" . $this->_thumbPath . '/' . $ret['orig_name'], "r");
            $i = 0;
            $yes = 0;
            $no = 0;

            $product_num = '';
            $title = '';
            $cas_num = '';
            $entourage = '';

            $color_id = 18;
            $color_name = '';
            $size_id = 9;
            $size_name = '';
            $price = '';
            $stock = 1000;
            $product_num2 = '';
            $product_id = 0;

            $retId = 0;
            while ($datas = fgetcsv($handle, 1000, ",")) {
                if ($i != 0) {
                    if (!empty($datas[5])) {
                        $price = $this->_clearStr($datas[5]);
                    }
                    if (!empty($datas[5])) {
                        $product_num2 = $this->_clearStr($datas[4]);
                    }
                    if (!empty($datas[2])) {
                        $color_name = $this->_clearStr($datas[2]);
                    }
                    if (!empty($datas[3])) {
                        $size_name = $this->_clearStr($datas[3]);
                    }
                    if (!empty($datas[0])) {
                        $color_id = 18;
                        $size_id = 9;
//					    $fields = array(
//				          'product_num'=>$this->_clearStr($datas[0]),
//				          'title'=>$this->_clearStr($datas[1]),
//						  'cas_num'=>$this->_clearStr($datas[6]),
//						  'entourage'=>$this->_clearStr($datas[7]),
//				          'product_class_id'=>7,
//				          'brand_id'=>        5,
//						  'sell_price'=>      $price,
//						  'market_price'=>    $price*2,
//				          'stock'=>           9999,
//				          'weight'=>          0,
//				          'category_id'=>     $categoryId,
//				          'content'=>         '',
//				          'hits'=>            0,
//				          'sales'=>           0,
//				          'display'=>         0,
//				          'postage_template_id'=>30,
//				          'add_time'=>        time(),
//				          'display_time'=>    time()
//				          );
                        $retId = $this->tableObject->get('id', array('product_num' => $this->_clearStr($datas[0]), 'cas_num' => $this->_clearStr($datas[6])));
                        if ($retId) {
                            $retId = $retId['id'];
                            $yes++;
                        } else {
                            $no++;
                        }
                    }
                    if ($retId) {
                        if (!empty($datas[2])) {
                            $color_id++;
                        }
                        if (!empty($datas[3])) {
                            $size_id++;
                        }
                        $pzInfo = $this->product_size_color_model->get("product_id", array('product_id' => $retId, 'size_name' => trim($size_name), 'color_name' => trim($color_name)));
                        if (!$pzInfo) {
                            $asizecolorFields = array(
                                'size_id' => $size_id,
                                'size_name' => trim($size_name),
                                'color_id' => $color_id,
                                'color_name' => trim($color_name),
                                'price' => $price,
                                'stock' => 999,
                                'product_num' => trim($product_num2),
                                'product_id' => $retId
                            );
                            $this->product_size_color_model->save($asizecolorFields);
                        }
                    }
                }
                $i++;
            }
            fclose($handle);
            @unlink("./" . $this->_thumbPath . '/' . $ret['orig_name']);
            printAjaxError("文件上传成功{$yes}条, 失败{$no}条");
        }

        $data = array(
            'tool' => $this->load->view('element/import_tool', '', TRUE),
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('product/import', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //使用时改成import(),关掉上面的，将上面的改成下面
    public function _import() {
        if ($_POST) {
            $categoryId = $this->input->post('category_id', TRUE);
            $ret = $this->_upload('filePath');
            if (!$ret) {
                printAjaxError('文件上传失败！');
            }
            ignore_user_abort(true); // run script in background
            set_time_limit(0); // run script forever,运行时间为无限后结束
            $handle = fopen("./" . $this->_thumbPath . '/' . $ret['orig_name'], "r");
            $i = 0;
            $yes = 0;
            $no = 0;

            $product_num = '';
            $title = '';
            $cas_num = '';
            $entourage = '';

            $color_id = 18;
            $color_name = '';
            $size_id = 9;
            $size_name = '';
            $price = '';
            $stock = 1000;
            $product_num2 = '';
            $product_id = 0;

            $retId = 0;
            while ($datas = fgetcsv($handle, 1000, ",")) {
                if ($i != 0) {
                    if (!empty($datas[5])) {
                        $price = $this->_clearStr($datas[5]);
                    }
                    if (!empty($datas[5])) {
                        $product_num2 = $this->_clearStr($datas[4]);
                    }
                    if (!empty($datas[2])) {
                        $color_name = $this->_clearStr($datas[2]);
                    }
                    if (!empty($datas[3])) {
                        $size_name = $this->_clearStr($datas[3]);
                    }
                    if (!empty($datas[0])) {
                        $color_id = 18;
                        $size_id = 9;
                        $fields = array(
                            'product_num' => $this->_clearStr($datas[0]),
                            'title' => $this->_clearStr($datas[1]),
                            'cas_num' => $this->_clearStr($datas[6]),
                            'entourage' => $this->_clearStr($datas[7]),
                            'product_class_id' => 7,
                            'brand_id' => 5,
                            'sell_price' => $price,
                            'market_price' => $price * 2,
                            'stock' => 9999,
                            'weight' => 0,
                            'category_id' => $categoryId,
                            'content' => '',
                            'hits' => 0,
                            'sales' => 0,
                            'display' => 0,
                            'postage_template_id' => 30,
                            'add_time' => time(),
                            'display_time' => time()
                        );
                        $retId = $this->tableObject->save($fields);
                        if ($retId) {
                            $yes++;
                        } else {
                            $no++;
                        }
                    }
                    if ($retId) {
                        if (!empty($datas[2])) {
                            $color_id++;
                        }
                        if (!empty($datas[3])) {
                            $size_id++;
                        }
                        $asizecolorFields = array(
                            'size_id' => $size_id,
                            'size_name' => trim($size_name),
                            'color_id' => $color_id,
                            'color_name' => trim($color_name),
                            'price' => $price,
                            'stock' => 999,
                            'product_num' => trim($product_num2),
                            'product_id' => $retId
                        );
                        $this->product_size_color_model->save($asizecolorFields);
                    }
                }
                $i++;
            }
            fclose($handle);
            @unlink("./" . $this->_thumbPath . '/' . $ret['orig_name']);
            printAjaxError("文件上传成功{$yes}条, 失败{$no}条");
        }

        $data = array(
            'tool' => $this->load->view('element/import_tool', '', TRUE),
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('product/import', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    private function _clearStr($str) {
        return iconv("gb2312", "UTF-8", trim($str));
    }

    private function _clearStr2($str) {
        return iconv("gb2312", "UTF-8", preg_replace(array('/\'/'), array(''), trim($str)));
    }

    private function _upload($field, $filePath = './uploads', $ext = 'csv', $maxSize = '1024000') {
        $config['upload_path'] = createDateTimeDir($filePath);
        $config['file_name'] = getUniqueFileName($filePath);
        $config['allowed_types'] = $ext;
        $config['max_size'] = $maxSize;
        $this->load->library('upload', $config);
        $this->_thumbPath = substr($config['upload_path'], 2);

        if ($this->upload->do_upload($field)) {
            return $this->upload->data();
        } else {
            return false;
        }

        return fasle;
    }

}

/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */