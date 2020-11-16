<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 多次调用的方法集成
 *
 */
class Advdbclass {
	public function __construct() {
		$CI =& get_instance();
		$CI->load->library('session');
		if (!$CI->session->userdata('gloab_city_name')) {
			//获取地区
			$cip = '';
			$cur_city = '';
			if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
				$cip = $_SERVER["HTTP_CLIENT_IP"];
			} else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
				$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} else if (!empty($_SERVER["REMOTE_ADDR"])){
				$cip = $_SERVER["REMOTE_ADDR"];
			}
			if ($cip != '127.0.0.1') {
				//初始化
				$ch = curl_init();
				//设置选项，包括URL
				curl_setopt($ch, CURLOPT_URL, "http://www.ip138.com/ips138.asp?ip={$cip}");
				curl_setopt($ch, CURLOPT_REFERER, "http://www.yhd.com");
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:37.0) Gecko/20100101 Firefox/37.0");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_TIMEOUT, 3);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
				//执行并获取HTML文档内容
				$output = curl_exec($ch);
				//释放curl句柄
				curl_close($ch);
				$output = mb_convert_encoding($output, 'utf-8', 'gbk');
				header("Content-type: text/html; charset=utf-8");
				if (!$output) {
					return array('', '');
				}
				preg_match("/(本站数据：)+.*(参考数据1：)+/", $output, $matches);
				if (!$matches || !$matches[0]) {
					return array('', '');
				}
				$address = preg_replace(array('/本站数据：/', '/参考数据1：/', '/(<\/li>|<li>)/'), array('', '', ''), $matches[0]);
				if ($address) {
					$address_str = str_replace(array('省', '市', ' '), array('|', '|', '|'), $address);
					$address_str_arr = explode('|', $address_str);
					if ($address_str_arr) {
						$cur_city = $address_str_arr[1];
					}
				}
			}

			$CI->session->set_userdata(array("gloab_city_name"=>$cur_city));
		}
	}
    //获取友情链接
    public function getLink() {
        $CI = & get_instance();
        $CI->load->model('Link_model', '', TRUE);

        return $CI->Link_model->gets("display = 1 ");
    }

    //获取头部的栏目
    public function getHeadMenu() {
        $CI = & get_instance();
        $CI->load->model('Menu_model', '', TRUE);
        $headWhere = "parent = 0 and hide = 0 and find_in_set('head', position) ";
        return $CI->Menu_model->gets('id, menu_name, model, html_path, template, menu_type, cover_function, url', $headWhere);
    }

    //获取导航栏目的栏目
    public function getNavigationMenu() {
        $CI = & get_instance();
        $CI->load->model('Menu_model', '', TRUE);

        return $CI->Menu_model->menuTree('id, menu_name, model, html_path, template, menu_type, url, cover_function, list_function, detail_function, en_menu_name', 0);
    }

    //获取版权的栏目
    public function getFooterMenu() {
        $CI = & get_instance();
        $CI->load->model('Menu_model', '', TRUE);
        $footerWhere = "parent = 0 and hide = 0 and find_in_set('footer', position) ";
        return $CI->Menu_model->gets('id, menu_name, model, html_path, template, menu_type, cover_function, url', $footerWhere);
    }

    //获取产品分类,分类ID为已知
    public function getProductClass($id) {
        $CI = & get_instance();
        $CI->load->model('Menu_model', '', TRUE);
        $parentId = $CI->Menu_model->getParentMenuId($id);
        return $CI->Menu_model->getChildMenuTree('id, menu_name, html_path, template', $parentId);
    }

    //获取产品分类,分类ID为已知
    public function getMenuClass($menuId = NULL, $num = 100, $is_all = 1) {
        $CI = & get_instance();
        $CI->load->model('Menu_model', '', TRUE);
        $parentId = $CI->Menu_model->getParentMenuId($menuId);

        return $CI->Menu_model->getChildMenuTree('id, menu_name, model, html_path, template, menu_type, url, cover_function, list_function, detail_function, en_menu_name', $parentId, $num, $is_all);
    }

    public function getMenuList($menuId = NULL, $position = '', $num = 100) {
    	$CI = & get_instance();
    	$CI->load->model('Menu_model', '', TRUE);
    	$str_where = "parent = {$menuId} and hide = 0 ";
    	if ($position) {
    		$str_where .= " and find_in_set('{$position}', position) ";
    	}

    	return $CI->Menu_model->gets('*', $str_where, $num, 0);
    }

    //获取产品分类,分类ID为已知
    public function getMenuInfo($menuId) {
        $CI = & get_instance();
        $CI->load->model('Menu_model', '', TRUE);
        $parentId = $CI->Menu_model->getParentMenuId($menuId);

        return $CI->Menu_model->get('menu_name', array('id' => $parentId));
    }

    public function get_product_category_list($store_id = NULL) {
    	$CI = & get_instance();
    	$CI->load->model('Product_category_model', '', TRUE);

    	return $CI->Product_category_model->menuTree($store_id);
    }

    /**
     * 获取广告
     *
     * @param unknown_type $id   分类ID
     * @param unknown_type $num  数量
     */
    public function getAd($id, $num = 10) {
        $CI = & get_instance();
        $CI->load->model('Ad_model', '', TRUE);

        return $CI->Ad_model->gets('id, path, url, ad_text,app_url,xcx_url', array('category_id' => $id, 'ad_type' => 'image', 'display' => 1), $num, 0);
    }

    /**
     * 获取店铺广告
     *
     * @param unknown_type $id   分类ID
     * @param unknown_type $num  数量
     */
    public function get_ad_store_list($position = 1, $store_id = NULL, $num = 10, $offest = 0) {
    	$CI = & get_instance();
    	$CI->load->model('Ad_store_model', '', TRUE);

    	return $CI->Ad_store_model->gets('*', array('position' => $position, 'store_id' => $store_id), $num, $offest);
    }

    //获取栏目的url
    public function getMenuUrl($menuId, $isHtml = false, $client_index = '') {
        $CI = & get_instance();
        $CI->load->model('Menu_model', '', TRUE);
        $url = '';

        $menuInfo = $CI->Menu_model->get('id, html_path, menu_type, template', array('id' => $menuId));
        if ($menuInfo) {
            if ($menuInfo['menu_type'] == '3') {
                $url = $menuInfo['url'];
            } else {
                if ($isHtml) {
                    $url = $menuInfo['html_path'];
                } else {
                    $url = $client_index;
                    $url .= $client_index ? '/' : '';
                    $url .= "{$menuInfo['template']}/index/{$menuInfo['id']}.html";
                }
            }
        }

        return $url;
    }

    //单页面内容
    public function getFooterPage($menuId) {
        $CI = & get_instance();
        $CI->load->model('Menu_model', '', TRUE);
        $CI->load->model('Page_model', '', TRUE);
        $url = '';
        $ids = $CI->Menu_model->getChildMenus($menuId);
        $strWhere = "page.display = 1 and page.category_id in ({$ids}) ";

        return $CI->Page_model->gets($strWhere, 5, 0);
    }

    //单页面内容
    public function getPages($menuId) {
        $CI = & get_instance();
        $CI->load->model('Menu_model', '', TRUE);
        $CI->load->model('Page_model', '', TRUE);
        $url = '';
        $ids = $CI->Menu_model->getChildMenus($menuId);
        $strWhere = "page.display = 1 and page.category_id in ({$ids}) ";

        return $CI->Page_model->gets($strWhere);
    }

    //获取购物车商品数量
    public function getCartSum($userId = 0) {
        $CI = & get_instance();
        $CI->load->model('Cart_model', '', TRUE);

        return $CI->Cart_model->rowSum(array('user_id' => $userId));
    }

    /**
     * 全局内容调用
     *
     * @param $table     模型-news=新闻；cases=案例；teacher=优秀导师；team=优秀团队；download=软件下载；product=产品；video=视频；picture=图库；
     * @param $menuId    分类ID
     * @param $type      属性-头条[h]；推荐[c];特荐[a]；幻灯[f]；滚动[s]；加粗[b]；图片[p]；跳转[j]
     * @param $is_image  1=仅调用图片
     * @param $num       数量
     */
    public function get_cus_list($table = 'news', $menuId, $type = 'c', $is_image = 0, $num = 10) {
        $CI = & get_instance();
        $tmp_obj = ucfirst($table) . '_model';
        $CI->load->model('Menu_model', '', TRUE);
        $CI->load->model(ucfirst($table) . '_model', $tmp_obj, TRUE);
        $url = '';
        $ids = $CI->Menu_model->getChildMenus($menuId);
        $strWhere = "{$table}.display = 1 and {$table}.category_id in ({$ids})";
        if ($type) {
            $strWhere .= " and FIND_IN_SET('{$type}', `{$table}`.`custom_attribute`)";
        }
        if ($is_image) {
            $strWhere .= " and {$table}.path <> ''  ";
        }

        return $CI->$tmp_obj->gets($strWhere, $num, 0);
    }

    public function get_cus_store_list($type = 'c', $num = 10, $is_producer = 0) {
    	$CI = & get_instance();
    	$CI->load->model('Menu_model', '', TRUE);
    	$CI->load->model('Store_model', NULL, TRUE);
    	$strWhere = "store.display = 1 ";
    	if ($type) {
    		$strWhere .= " and FIND_IN_SET('{$type}', store.custom_attribute)  ";
    	}
    	if ($is_producer){
            $strWhere .= " and producer_auth = 1";
        }else{
            $strWhere .= " and producer_auth = 0";
        }

//    	if ($type == 'c' || $type == 'a') {
    		return $CI->Store_model->getsRand($strWhere, $num, 0);
//    	} else {
//    		return $CI->Store_model->gets($strWhere, $num, 0);
//    	}
    }

    public function get_cus_product_list($type = 'c', $num = 10, $store_id = 0) {
    	$CI = & get_instance();
    	$CI->load->model('Menu_model', '', TRUE);
    	$CI->load->model('product_model', NULL, TRUE);
    	$url = '';
    	$strWhere = "product.display = 1 ";
    	if ($type) {
    		$strWhere .= " and FIND_IN_SET('{$type}', product.custom_attribute)  ";
    	}
    	if ($store_id) {
    		$strWhere .= " and product.store_id = {$store_id}  ";
    	}

    	return $CI->product_model->gets('path,id,sell_price,market_price,title,abstract,sales,batch_path_ids', $strWhere, $num, 0);
    }

    public function get_recommend_product_list($num = 0, $store_id = 0) {
        $CI = & get_instance();
        $CI->load->model('product_model', NULL, TRUE);
        $strWhere1 = "product.display = 1 and recommend_to_store_index <> 1 ";
        $strWhere = "product.display = 1 and recommend_to_store_index = 1 ";
        if ($store_id) {
            $strWhere .= " and product.store_id = {$store_id}  ";
            $strWhere1 .= " and product.store_id = {$store_id}  ";
        }
        $count = $CI->product_model->rowCount($strWhere);
        if ($count >= $num){
            $product_list = $CI->product_model->gets('path,id,sell_price,market_price,title,abstract,sales,batch_path_ids', $strWhere, $num, 0);
        }else{
            $product_list1 = $CI->product_model->gets('path,id,sell_price,market_price,title,abstract,sales,batch_path_ids', $strWhere, $num, 0);
            $product_list2 = $CI->product_model->gets('path,id,sell_price,market_price,title,abstract,sales,batch_path_ids', $strWhere1, $num - $count, 0);
            $product_list = array_merge($product_list1, $product_list2);
        }


        return $product_list;
    }

    public function get_product_list($category_ids = '', $type = 'c', $num = 10, $order = 'id', $is_api = 0, $is_check_store = 1) {
    	$CI = & get_instance();
    	$CI->load->model('product_model', NULL, TRUE);
    	$strWhere = "product.display = 1 ";
        if ($type) {
    		$strWhere .= " and FIND_IN_SET('{$type}', custom_attribute)  ";
    	}
        //判断权限
        if ($is_api){
            if (!$is_check_store){
                $strWhere .= " and store_id not in (select id from store where producer_auth = 1 and id is not null)";
            }
        }else{
            if (!check_store_type()){
                $strWhere .= " and store_id not in (select id from store where producer_auth = 1 and id is not null)";
            }
        }


    	$ids = '';
    	$product_list = $CI->product_model->gets('path,id,sell_price,market_price,title,abstract,sales,batch_path_ids', $strWhere, $num, 0, $order);
    	if ($product_list) {
    		foreach ($product_list as $key=>$value) {
    			$ids .= $value['id'].',';
    		}
    		if ($ids) {
    			$ids = substr($ids, 0, -1);
    		}
    	}
        $sum = count($product_list);
    	if ($sum < $num && $category_ids) {
    		$strWhere = "product.display = 1 and product.category_id_1 in ({$category_ids}) ";
    		if ($ids) {
    			$strWhere .= " and product.id not in ({$ids})";
    		}
    		$sub_product_list = $CI->product_model->gets('path,id,sell_price,market_price,title,abstract,sales,batch_path_ids', $strWhere, $num-$sum, 0);
    		if ($sub_product_list) {
    			foreach ($sub_product_list as $key=>$value) {
    				$product_list[$sum+$key] = $value;
    			}
    		}
    	}

    	return $product_list;
    }

    public function get_keycode_list() {
    	$CI = & get_instance();
    	$CI->load->model('Keyword_model', '', TRUE);

    	return $CI->Keyword_model->gets('*', NULL, 6, 0);
    }

    public function get_site_list($num = 10) {
    	$CI = & get_instance();
    	$CI->load->model('Site_model', '', TRUE);

    	return $CI->Site_model->gets('*', array('display'=>1), $num, 0);
    }

    public function get_style_list($num = 10) {
    	$CI = & get_instance();
    	$CI->load->model('Style_model', '', TRUE);

    	return $CI->Style_model->gets(array('display'=>1), $num, 0);
    }

    public function get_navigation_list($store_id = NULL, $num = 7) {
    	$CI = & get_instance();
    	$CI->load->model('Navigation_model', '', TRUE);

    	return $CI->Navigation_model->gets(array('display'=>1, 'store_id'=>$store_id), $num, 0);
    }

    public function get_brand_list($ids = "") {
    	$CI = & get_instance();
    	$CI->load->model('Brand_model', '', TRUE);
    	$ids = $ids?$ids:0;

    	return $CI->Brand_model->gets('*', "id in ({$ids})", 4, 0);
    }

    public function check_store($user_id = NULL) {
    	$CI = & get_instance();
    	$CI->load->model('Store_model', '', TRUE);

    	$store_info = $CI->Store_model->rowCount(array('user_id'=>$user_id));

    	return $store_info?true:false;
    }

    public function get_store_info($store_id = NULL) {
    	$CI = & get_instance();
    	$CI->load->model('Store_model', '', TRUE);
    	$CI->load->model('Favorite_model', '', TRUE);

    	$store_info = $CI->Store_model->get('*', array('id'=>$store_id));
        //用户是否收藏店铺
        $favorite_store_count = $CI->Favorite_model->rowCount('store', array('favorite.type'=>'store','favorite.user_id'=>get_cookie('user_id'),'favorite.item_id'=>$store_info['id']));
        $store_info['is_favorite'] = $favorite_store_count ? 1 : 0;

    	return $store_info;
    }

    public function getPermissionsStr($adminGroupId = NULL) {
        $ret = false;
        $CI = & get_instance();
        $CI->load->model('Seller_group_model', '', TRUE);
        return $CI->Seller_group_model->get('permissions', array('id'=>$adminGroupId));
    }

    //获取权限
    public function getPermissions($adminGroupId = NULL, $permissionsItem = NULL) {
        $ret = false;
        $CI = & get_instance();
        $CI->load->model('Seller_group_model', '', TRUE);
        $admingroupInfo = $CI->Seller_group_model->get('permissions', array('id'=>$adminGroupId));
        if ($admingroupInfo) {
            $permissionArr = explode(',', $admingroupInfo['permissions']);
            if (in_array($permissionsItem, $permissionArr)) {
                $ret = true;
            }
        }

        return $ret;
    }

    //获取唯一普通订单的订单号
    public function get_unique_orders_number($field = 'order_number'){
        $CI = & get_instance();
        $CI->load->model('Orders_model', '', TRUE);

        //一秒钟一万件的量
        $randCode = '';
        while (true) {
            $randCode = getOrderNumber(6);
            $count = $CI->Orders_model->rowCount(array("{$field}" => $randCode));
            if ($count > 0) {
                $randCode = '';
                continue;
            } else {
                break;
            }
        }
        return $randCode;
    }

}

// END Validateloginclass class

/* End of file Validateloginclass.php */
/* Location: ./system/libraries/Validateloginclass.php */