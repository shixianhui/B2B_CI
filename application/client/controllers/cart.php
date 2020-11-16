<?php

class Cart extends CI_Controller {
	private $_table = 'cart';
	private $_template = 'cart';
    public function __construct() {
        parent::__construct();
        $this->load->model(ucfirst($this->_table) . '_model', 'tableObject', TRUE);
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Score_setting_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Payment_way_model', '', TRUE);
        $this->load->model('Postage_price_model', '', TRUE);
        $this->load->model('Postage_way_model', '', TRUE);
        $this->load->model('Area_model', '', TRUE);
        $this->load->model('User_address_model', '', TRUE);
        $this->load->model('Favorite_model', '', TRUE);
        $this->load->library('Form_validation');
    }

    public function index() {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //按店铺分组显示
        $item_list = $this->tableObject->gets_store_list(array("{$this->_table}.user_id"=>get_cookie('user_id')));
        if ($item_list) {
        	foreach ($item_list as $key=>$value) {
        		$item_list[$key]['cart_list'] = $this->tableObject->gets(array("{$this->_table}.user_id"=>$value['user_id'], "{$this->_table}.store_id"=>$value['store_id']));
        	}
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '购物车' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
        	'item_list'=>$item_list,
        	'parent_id'=>0
        );
        $layout = array(
            'content' => $this->load->view('cart/index', $data, TRUE)
        );
        $this->load->view('layout/cart_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function confirm() {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $cart_ids = $this->input->post('cart_ids', TRUE);
        if (!$cart_ids) {
        	$data = array(
        			'user_msg' => '请选择结算商品',
        			'user_url' => base_url() . getBaseUrl(false, "cart.html", "cart.html", $systemInfo['client_index'])
        	);
        	$this->session->set_userdata($data);
        	redirect('/message/index');
        	exit;
        }
        //获取结算的商品
        $cart_ids = implode(',', $cart_ids);
        $user_id = get_cookie('user_id');
        $score_setting = $this->Score_setting_model->get('*', array('id' => 1));
        $user_info = $this->User_model->get('score', array('id' =>$user_id));
        //按店铺分组显示
        //优惠
        $discount_total = 0;
        //税费
        $taxation_total = 0;
        //商品
        $product_total = 0;
        //邮费
        $postage_price = 0;

        //总金额
        $total = 0;
        $item_list = $this->tableObject->gets_store_list("{$this->_table}.id in ({$cart_ids}) and {$this->_table}.user_id = {$user_id}");
        if ($item_list) {
        	foreach ($item_list as $key=>$value) {
        		//优惠
        		$store_discount_total = 0;
        		//税费
        		$store_taxation_total = 0;
        		//商品
        		$store_product_total = 0;
        		//邮费
        		$store_postage_price = 0;
                //店铺订单商品数
                $store_cart_ids = '';
        		//总金额
        		$store_total = 0;
        		$cart_list = $this->tableObject->gets("{$this->_table}.id in ({$cart_ids}) and {$this->_table}.user_id = {$user_id} and {$this->_table}.store_id = {$value['store_id']}");
        		if ($cart_list) {
        			foreach ($cart_list as $cart) {
        				$store_product_total += $cart['buy_number']*$cart['sell_price'];
                        $store_cart_ids .= $cart['id'].',';
        			}
                    if ($store_cart_ids) {
                        $store_cart_ids = substr($store_cart_ids, 0, -1);
                    }
        		}
        		$product_total += $store_product_total;
        		$discount_total += $store_discount_total;
        		$taxation_total += $store_taxation_total;
        		$postage_price += $store_postage_price;
                $item_list[$key]['store_cart_ids'] = $store_cart_ids;
        		$item_list[$key]['store_product_total'] = number_format($store_product_total, '2', '.', '');
        		$item_list[$key]['store_discount_total'] = number_format($store_discount_total, '2', '.', '');
        		$item_list[$key]['store_taxation_total'] = number_format($store_taxation_total, '2', '.', '');
        		$item_list[$key]['store_postage_price'] = number_format($store_postage_price, '2', '.', '');
        		$item_list[$key]['store_total'] = number_format($store_product_total+$store_taxation_total+$store_postage_price-$store_discount_total, '2', '.', '');
        		$item_list[$key]['cart_list'] = $cart_list;
                //配送方式
                $postage_way_list = $this->Postage_way_model->gets('*', array('display' => 1,'store_id'=>$value['store_id']));
                $item_list[$key]['postage_way_list'] = $postage_way_list;
        	}
        }
        $total = number_format($product_total+$taxation_total+$postage_price-$discount_total, '2', '.', '');
        if (!$item_list) {
            $data = array(
                'user_msg' => '您的购物车没有宝贝，快去选购宝贝哦！',
                'user_url' => base_url() . getBaseUrl(false, "cart.html", "cart.html", $systemInfo['client_index'])
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }

        //地址
        $area_list = $this->Area_model->gets('*', array('parent_id' => 0));
        //用户收货地址
        $user_address_list = $this->User_address_model->gets('*', array('user_id' => get_cookie('user_id')));


        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '订单信息' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_list' => $item_list,
            'area_list' => $area_list,
            'user_address_list'=>$user_address_list,
            'postage_way_list' => $postage_way_list,
        	'total'=>$total,
        	'cart_ids'=>$cart_ids
        );
        $layout = array(
            'content' => $this->load->view('cart/confirm', $data, TRUE)
        );
        $this->load->view('layout/cart_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function cal_postage() {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        checkLogin();
        $address_id = $this->input->post('address_id', true);
        $postage_template_id = $this->input->post('postage_template_id', true);
        $cart_ids = $this->input->post('cart_ids',true);
        $product_number = 1;
        if($cart_ids){
           $product_number = $this->tableObject->rowSum("id in ($cart_ids)");
        }
        if (empty($address_id)) {
            printAjaxError('fail', '请收货地址');
        }
         if (empty($postage_template_id)) {
            printAjaxError('fail', '请选择配送方式');
        }
        $address = $this->User_address_model->get('*', array('id' => $address_id));
        if (empty($address)) {
            printAjaxError('fail', '不存在此收货地址');
        }
        $province = $this->Area_model->get('name',array('id'=>$address['province_id']));
        $postage_price = $this->advdbclass->_getPostagewayPrice($postage_template_id,$province['name'],$product_number);
        printAjaxData(array('postage_price' => $postage_price));
    }

    public function add() {
    	if (! get_cookie('user_id')) {
    		printAjaxError('go_login', '您还没有登录，请登录');
    	}
    	if ($_POST) {
    		$product_id = $this->input->post('product_id');
    		$color_id = $this->input->post('color_id', TRUE);
    		$size_id = $this->input->post('size_id', TRUE);
    		$buy_number = $this->input->post('buy_number');
    		$buy_type = $this->input->post('buy_type');

    		$color_name = '';
    		$size_name = '';
    		$sell_price = '';
    		if (! $this->form_validation->required($product_id)) {
    			printAjaxError('fail', '操作异常，刷新页面重试');
    		}
    		$item_info = $this->Product_model->get('color_size_open, stock, sell_price, unclear_price, store_id, color_size_open, product_color_name, product_size_name', array('id'=>$product_id, 'display'=>1));
    		if (! $item_info) {
    			printAjaxError('fail', '此商品不存在或被删除');
    		}
    		if ($item_info['unclear_price']){
                printAjaxError('fail', '此商品需要到实体店咨询');
            }
    		if ($item_info['color_size_open']) {
	    		if (! $this->form_validation->required($color_id)) {
	    			printAjaxError('fail', '请选择'.$item_info['product_color_name']);
	    		}
	    		$color_list = $this->Product_model->getDetailColor($product_id);
	    		if ($color_list) {
	    			foreach ($color_list as $key=>$value) {
	    				if ($value['color_id'] == $color_id) {
	    					$color_name = $value['color_name'];
	    					break;
	    				}
	    			}
	    		}
	    		if (! $color_name) {
	    			printAjaxError('fail', '此'.$item_info['product_color_name'].'不存在');
	    		}
	    		if (! $this->form_validation->required($size_id)) {
	    			printAjaxError('fail', '请选择'.$item_info['product_size_name']);
	    		}
	    		$sizeList = $this->Product_model->getDetailSize($product_id);
	    		if ($sizeList) {
	    			foreach ($sizeList as $key=>$value) {
	    				if ($value['size_id'] == $size_id) {
	    					$size_name = $value['size_name'];
	    				}
	    			}
	    		}
	    		if (!$size_name) {
	    			printAjaxError('fail', '此'.$item_info['product_size_name'].'不存在');
	    		}
    		}
    		if (! $this->form_validation->integer($buy_number)) {
    			printAjaxError('fail', '请填写正确的购买数量');
    		}
    		if ($buy_number < 1) {
    			printAjaxError('fail', '购买数量必须大于零');
    		}

    		//有规格的产品
    		if ($item_info['color_size_open']) {
    			$product_stock_info = $this->Product_model->getProductStock($product_id, $color_id, $size_id);
    			if (!$product_stock_info) {
    				printAjaxError('fail', '没有此规格的商品');
    			}
    			$sell_price = $product_stock_info['price'];
    			if ($buy_number > $product_stock_info['stock']) {
    				printAjaxError('fail', '购买数量不能大于库存');
    			}
    		} else {
    			//没有规格的产品
    			$color_id = 0;
    			$size_id = 0;
    			$sell_price = $item_info['sell_price'];
    			//没有规格的产品
    			if ($buy_number > $item_info['stock']) {
    				printAjaxError('fail', '购买数量不能大于库存');
    			}
    		}

    		$strWhere = array(
    				'user_id'=>    get_cookie('user_id'),
    				'product_id'=> $product_id,
    				'size_id'=>    $size_id,
    				'color_id'=>   $color_id
    		);
    		$cartInfo = $this->tableObject->get('buy_number,id', $strWhere);
    		//已购买的
    		if ($cartInfo) {
    		    $edit_fields = array(
    					'buy_number'=>$buy_number+$cartInfo['buy_number']
    			);
    			if ($buy_type) {
    				$edit_fields = array(
    						'buy_number'=>$buy_number
    				);
    			}
    			if ($this->tableObject->save($edit_fields, $strWhere)) {
    				$cart_count = $this->tableObject->rowSum(array('user_id'=>get_cookie('user_id')));
    				printAjaxData(array('cart_count'=>$cart_count, 'cart_id'=>$cartInfo['id']));
    			} else {
    				printAjaxError('fail', '加入购物车失败');
    			}
    		} else {//第一次购买的
    			$fields = array(
    					'user_id'=>    get_cookie('user_id'),
    					'store_id'=>   $item_info['store_id'],
    					'product_id'=> $product_id,
    					'size_name'=>  $size_name,
    					'size_id'=>    $size_id,
    					'color_name'=> $color_name,
    					'color_id'=>   $color_id,
    					'buy_number'=> $buy_number,
    					'sell_price'=> $sell_price
    			);
    			$ret_id = $this->tableObject->save($fields);
    			if ($ret_id) {
    				$cart_count = $this->tableObject->rowSum(array('user_id'=>get_cookie('user_id')));
    				printAjaxData(array('cart_count'=>$cart_count, 'cart_id'=>$ret_id));
    			} else {
    				printAjaxError('fail', '加入购物车失败');
    			}
    		}
    	}
    }

    //修改数量
    public function change_buy_number() {
        checkLoginAjax();
        if ($_POST) {
            $buy_number = $this->input->post('buy_number', TRUE);
            $cart_id = $this->input->post('cart_id', TRUE);
            $ids = $this->input->post('ids', TRUE);
            $user_id = get_cookie('user_id');

            if (!$buy_number || !$cart_id) {
                printAjaxError('fail', '操作异常，刷新重试');
            }
            $item_info = $this->tableObject->get2(array("{$this->_table}.id" => $cart_id));
            if (!$item_info) {
                printAjaxError('fail', '修改信息不存在，刷新重试');
            }
            if ($item_info['color_size_open']) {
            	//有规格的商品
            	$product_stock_info = $this->Product_model->getProductStock($item_info['product_id'], $item_info['color_id'], $item_info['size_id']);
            	if (!$product_stock_info) {
            		printAjaxError('fail', '没有此规格的商品，请删除');
            	}
            	if ($buy_number > $product_stock_info['stock']) {
            		printAjaxError('fail', "此款商品库存不足，库存为：{$product_stock_info['stock']}");
            	}
            } else {
            	if ($buy_number > $item_info['stock']) {
            		printAjaxError('fail', "此款商品库存不足，库存为：{$item_info['stock']}");
            	}
            }
            if (!$this->tableObject->save(array('buy_number' => $buy_number), array('id' => $cart_id, 'user_id'=>$user_id))) {
                printAjaxError('fail', '数量修改失败');
            }

            printAjaxData($this->_select_cart_info($user_id, $ids));
        }
    }

    //删除商品
    public function delete_cart_product() {
        checkLoginAjax();
        if ($_POST) {
        	$select_ids = $this->input->post('select_ids', TRUE);
            $delete_ids = $this->input->post('delete_ids', TRUE);
            $user_id = get_cookie('user_id');

            if (!$delete_ids) {
                printAjaxError('fail', '操作异常，刷新重试');
            };
            if (!$this->tableObject->delete("id in ({$delete_ids}) and user_id = {$user_id} ")) {
                printAjaxError('fail', '删除失败');
            }

            printAjaxData($this->_select_cart_info($user_id, $select_ids));
        }
    }

    //批量删除商品
    public function batch_delete_cart_product() {
    	checkLoginAjax();
    	if ($_POST) {
    		$delete_ids = $this->input->post('delete_ids', TRUE);
    		$user_id = get_cookie('user_id');

    		if (!$delete_ids) {
    			printAjaxError('fail', '操作异常，刷新重试');
    		};
    		if (!$this->tableObject->delete("id in ({$delete_ids}) and user_id = {$user_id} ")) {
    			printAjaxError('fail', '删除失败');
    		}

    		printAjaxData($this->_select_cart_info($user_id, ''));
    	}
    }

    //移入收藏夹
    public function move_product_to_favorite() {
    	checkLoginAjax();
    	if ($_POST) {
    		$select_ids = $this->input->post('select_ids', TRUE);
    		$cart_id = $this->input->post('cart_id', TRUE);
    		$user_id = get_cookie('user_id');

    		if (!$cart_id) {
    			printAjaxError('fail', '操作异常，刷新重试');
    		};
    		$item_info = $this->tableObject->get('product_id', array('id'=>$cart_id));
    		if (!$item_info) {
    			printAjaxError('fail', '删除信息不存在');
    		}
    		if (!$this->tableObject->delete("id in ({$cart_id}) and user_id = {$user_id} ")) {
    			printAjaxError('fail', '删除失败');
    		}
    		//收藏
    		if (!$this->Favorite_model->rowCount(array('user_id'=>$user_id, 'type'=>'product', 'item_id'=>$item_info['product_id']))) {
    			$fields = array(
    					'user_id'=>$user_id,
    					'type'=>'product',
    					'item_id'=>$item_info['product_id'],
    					'add_time'=>time()
    			);
    			$this->Favorite_model->save($fields);
    		}

    		printAjaxData($this->_select_cart_info($user_id, $select_ids));
    	}
    }

    //删除收货地址
    public function delete_user_address() {
        checkLoginAjax();
        if ($_POST) {
            $id = $this->input->post('id', TRUE);
            if (!$id) {
                printAjaxError('fail', '操作异常');
            }

            if ($this->User_address_model->delete(array('id' => $id, 'user_id' => get_cookie('user_id')))) {
                printAjaxData(array('id' => $id));
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }

    //设置默认收货地址
    public function set_default_user_address() {
        checkLoginAjax();
        if ($_POST) {
            $ret = 0;
            $id = $this->input->post('id', TRUE);
            if (!$id) {
                printAjaxError('fail', '操作异常,删除失败');
            }
            $userId = get_cookie('user_id');
            if ($this->User_address_model->save(array('is_default' => 0), "user_id = {$userId}")) {
                if ($this->User_address_model->save(array('is_default' => 1), array('id' => $id, 'user_id' => $userId))) {
                    $ret = 1;
                }
            }
            if ($ret) {
                printAjaxSuccess('success', '设置成功');
            } else {
                printAjaxError('fail', '设置失败');
            }
        }
    }

    //获取选定商品信息
    public function get_select_cart_info() {
    	checkLoginAjax();
    	if ($_POST) {
    		$user_id = get_cookie('user_id');
    		$ids = $this->input->post('ids', TRUE);

    		printAjaxData($this->_select_cart_info($user_id, $ids));
    	}
    }

    private function _select_cart_info($user_id = NULL, $ids = '') {
    	//优惠
    	$discount_total = 0;
    	//税费
    	$taxation_total = 0;
    	//商品
    	$product_total = 0;
    	//总金额
    	$total = 0;
    	//选定数量
    	$select_num = 0;
    	$item_list = array();
    	if ($ids) {
    		$item_list = $this->tableObject->gets_store_list("{$this->_table}.id in ({$ids}) and {$this->_table}.user_id = {$user_id}");
    		if ($item_list) {
    			foreach ($item_list as $key=>$value) {
    				$store_discount_total = 0;
    				$store_taxation_total = 0;
    				$store_product_total = 0;

    				$cart_list = $this->tableObject->gets("{$this->_table}.id in ({$ids}) and {$this->_table}.user_id = {$user_id} and {$this->_table}.store_id = {$value['store_id']}");
    				if ($cart_list) {
    					foreach ($cart_list as $cart) {
    						$select_num += $cart['buy_number'];
    						$store_product_total += $cart['buy_number']*$cart['sell_price'];
    					}
    				}
    				$discount_total += $store_discount_total;
    				$taxation_total += $store_taxation_total;
    				$product_total += $store_product_total;
    				$item_list[$key]['store_product_total'] = number_format($store_product_total, '2', '.', '');
    				$item_list[$key]['store_discount_total'] = number_format($store_discount_total, '2', '.', '');
    				$item_list[$key]['store_taxation_total'] = number_format($store_taxation_total, '2', '.', '');
    			}
    		}
    	}
    	$total = number_format($product_total+$taxation_total-$discount_total, '2', '.', '');
    	$discount_total = number_format($discount_total, '2', '.', '');
    	$taxation_total = number_format($taxation_total, '2', '.', '');
    	$product_total = number_format($product_total, '2', '.', '');
        $cart_count = $this->tableObject->rowSum(array('user_id'=>$user_id));
    	return array('item_list'=>$item_list, 'discount_total'=>$discount_total, 'taxation_total'=>$taxation_total, 'product_total'=>$product_total, 'total'=>$total, 'select_num'=>$select_num, 'cart_count'=>$cart_count);
    }

    //获取对应地址
    public function get_city() {
    	if ($_POST) {
    		$parent_id = $this->input->post('parent_id', TRUE);
    		$item_list = $this->Area_model->gets('id, name', array('parent_id'=>$parent_id, 'display'=>1));
    		printAjaxData($item_list);
    	}
    }

    //编辑收货地址
    public function save_user_address() {
    	checkLoginAjax();
    	if ($_POST) {
    		$user_id = get_cookie('user_id');

    		$id = $this->input->post('id', TRUE);
    		$buyer_name = $this->input->post('buyer_name', TRUE);
    		$country_id = $this->input->post('country_id', TRUE);
    		$province_id = $this->input->post('province_id', TRUE);
    		$city_id = $this->input->post('city_id', TRUE);
    		$area_id = $this->input->post('area_id', TRUE);
    		$address = $this->input->post('address', TRUE);
    		$txt_address = $this->input->post('txt_address', TRUE);
    		$phone = $this->input->post('phone', TRUE);
    		$mobile = $this->input->post('mobile', TRUE);
    		$is_default = $this->input->post('is_default', TRUE);

    		if ($id) {
    			if (!$this->User_address_model->rowCount(array('id'=>$id, 'user_id'=>$user_id))) {
    				printAjaxError('fail', '此收货地址不存在');
    			}
    		} else {
    			if ($this->User_address_model->rowCount(array('user_id'=>$user_id)) >= 10 ) {
    				printAjaxError('fail', '最多只能添加10个收货地址');
    			}
    		}
    		if ($country_id === '') {
    			printAjaxError('country_id', '请选择国家或地区');
    		}
    		if (!$address) {
    			printAjaxError('address', '请填写详细地址');
    		}
    		if (!$buyer_name) {
    			printAjaxError('buyer_name', '请填写收货人姓名');
    		}
    		if (!$mobile) {
    			printAjaxError('mobile', '请填写手机号');
    		}
    		if (!preg_match('/^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/', $mobile)) {
    			printAjaxError('mobile', '请填写正确的手机号码');
    		}

    		$fields = array(
    			'buyer_name'=>$buyer_name,
    			'country_id'=>$country_id,
    			'province_id'=>$province_id?$province_id:0,
    			'city_id'=>$city_id?$city_id:0,
    			'area_id'=>$area_id?$area_id:0,
    			'address'=>$address,
    			'txt_address'=>$txt_address,
    			'phone'=>$phone,
    			'mobile'=>$mobile,
    			'is_default'=>$is_default,
    			'user_id'=>$user_id
    		    );
    		$ret_id = $this->User_address_model->save($fields, $id?array('id'=>$id):NULL);
    		if (!$ret_id) {
    			printAjaxError('fail', '操作失败');
    		}
    		$ret_id = $id?$id:$ret_id;
    		//设置默认地址
    		if ($is_default) {
    			$this->User_address_model->save(array('is_default' => 0), "id <> {$ret_id} and user_id = {$user_id}");
    		}
    		printAjaxData(array('id'=>$ret_id, 'mobile'=>createMobileBit($mobile)));
    	}
    }

    //获取用户地址
    public function get_user_address() {
    	checkLoginAjax();
    	if ($_POST) {
    		$user_id = get_cookie('user_id');
	    	$id = $this->input->post('id', TRUE);

	    	$item_info = $this->User_address_model->get('*', array('id' => $id, 'user_id' => $user_id));
	    	if (!$item_info) {
	    		printAjaxError('fail','此收货地址不存在');
	    	}
	    	printAjaxData($item_info);
    	}
    }
}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */