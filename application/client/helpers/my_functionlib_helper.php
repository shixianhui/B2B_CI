<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * print ajax error
 *
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('getBaseUrl')) {
	function getBaseUrl($isHtml = false, $htmlUrl = '', $unHtmlUrl = '', $client_index = '') {
		$url = '';
		if ($isHtml) {
		    $url = $htmlUrl;
		} else {
		    $url = $client_index;
    	    $url .= $client_index?'/':'';
    	    $url .= $unHtmlUrl;
		}

		return $url;
	}
}

// ------------------------------------------------------------------------
/**
 * 获取字的宽度
 *
 *
 */
if ( ! function_exists('getStrWidth')) {
	function getStrWidth($str) {
		$len = mb_strlen($str);
		$letterCount = 0.0;
		for ($i = 0; $i < $len; $i++) {
		    if (strlen(mb_substr($str, $i, 1)) == 3) {
		        $letterCount += 1.0;
		    } else {
		        $letterCount += 0.5;
		    }
		}

		return $letterCount;
	}
}

// ------------------------------------------------------------------------

/**
 * Intercept length of the string
 *
 *
 * @access	public
 * @param	string
 * @param	int
 * @param	string
 * @return	string
 */
if ( ! function_exists('my_substr')) {
function my_substr($string, $length, $dot = '...', $charset = 'utf-8') {
		if(strlen($string) <= $length) return $string;
		$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
		$strcut = '';
		if(strtolower($charset) == 'utf-8') {
			$n = $tn = $noc = 0;
			while($n < strlen($string)) {
				$t = ord($string[$n]);
				// 特别要注意这部分，utf-8是1--6位不定长表示的，这里就是如何
				// 判断utf-8是1位2位还是3位还是4、5、6位,这对其他语言的编程也有用处
				// 具体可以查看rfc3629或rfc2279
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} else if(194 <= $t && $t <= 223) {
					$tn = 2; $n += 2; $noc += 2;
				} elseif(224 <= $t && $t < 239) {
					$tn = 3; $n += 3; $noc += 2;
				} elseif(240 <= $t && $t <= 247) {
					$tn = 4; $n += 4; $noc += 2;
				} elseif(248 <= $t && $t <= 251) {
					$tn = 5; $n += 5; $noc += 2;
				} elseif($t == 252 || $t == 253) {
					$tn = 6; $n += 6; $noc += 2;
				} else {
					$n++;
				}

				if($noc >= $length) {
					break;
				}
			}

			if($noc > $length) $n -= $tn;

			$strcut = substr($string, 0, $n);
		} else {
			for($i = 0; $i < $length; $i++) {
				$strcut .= ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
			}
		}
		//$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
		return strlen($string) > strlen($strcut)? $strcut . $dot:$strcut;
    }
}

// ------------------------------------------------------------------------

/**
 * Display html
 *
 */
if ( ! function_exists('html')) {
    function html($str) {
    	return html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
    }
}

// ------------------------------------------------------------------------

/**
 * Html filter
 *
 */
if ( ! function_exists('unhtml')) {
    function unhtml($str) {
    	return htmlentities($str, ENT_NOQUOTES, 'UTF-8');
    }
}

// ------------------------------------------------------------------------

/**
 * clear string
 *
 */
if ( ! function_exists('clearstring')) {
    function clearstring($str) {
    	return str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $str);
    }
}

// ------------------------------------------------------------------------

/**
 * get order number
 *
 *
 * @access	public
 * @param int
 * @return	string
 */
if ( ! function_exists('getOrderNumber')) {
	function getOrderNumber($len) {
	    $str = '0123456789';
		$maxLen = strlen($str)-1;
		$randStr = '';
		for ($i = 0; $i < $len; $i++) {
		    $randStr .= substr($str, rand(0, $maxLen), 1);
		}

		return date('ymdhi', time()).$randStr;
	}
}
/**
 * 生成随机码(纯数字);
 *
 *
 * @access	public
 * @param int
 * @return	string
 */
if ( ! function_exists('getRandCode')) {
	function getRandCode($len) {
	    $str = '0123456789';
		$maxLen = strlen($str)-1;
		$randStr = '';
		for ($i = 0; $i < $len; $i++) {
		    $randStr .= substr($str, rand(0, $maxLen), 1);
		}

		return $randStr;
	}
}

// ------------------------------------------------------------------------

/**
 * 生成密码
 *
 *
 * @access	public
 * @param int
 * @return	string
 */
if ( ! function_exists('getRandPass')) {
	function getRandPass($len) {
	    $str = 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
		$maxLen = strlen($str)-1;
		$randStr = '';
		for ($i = 0; $i < $len; $i++) {
		    $randStr .= substr($str, rand(0, $maxLen), 1);
		}

		return $randStr;
	}
}

// ------------------------------------------------------------------------

/**
 * 星号部分隐藏用户名,手机，邮箱
 *
 * @param string $str
 * @return	string
 */
/*
 * 星号部分隐藏姓名,手机，邮箱,身份证号
 */
if (!function_exists('hideStar')) {

    function hideStar($str) {
        $rs = $str;
        if (strpos($str, '@')) {  //邮箱*隐藏
            $email_array = explode("@", $str);
            $prevfix = (strlen($email_array[0]) < 4) ? "" : substr($str, 0, 3); //邮箱前缀
            $count = 0;
            $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $str, -1, $count);
            $rs = $prevfix . $str;
        }
        if (preg_match('/(1[3458]{1}[0-9])[0-9]{4}([0-9]{4})/i', $str)) { //手机账号*隐藏
            $rs = preg_replace('/(1[3458]{1}[0-9])[0-9]{4}([0-9]{4})/i', '$1****$2', $str); // substr_replace($name,'****',3,4);
        }
        if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $str)) {//判断是否包含中文字符  姓名*隐藏
            //按照中文字符计算长度
            $len = mb_strlen($str, 'UTF-8');
            $rs = mb_substr($str, 0, 1, 'UTF-8'). '***' . mb_substr($str, -1, 1, 'UTF-8');
        }

        if (preg_match("/[\x7f-\xff]/", $str)  || preg_match("/[0-9]/", $str) || preg_match("/[a-zA-Z]/", $str)) {//判断是否包含中文字符  姓名*隐藏
            //按照中文字符计算长度
            $len = mb_strlen($str, 'UTF-8');
            $rs = mb_substr($str, 0, 1, 'UTF-8'). '***' . mb_substr($str, -1, 1, 'UTF-8');
        }
        if (preg_match('/(^\d{15}$)|(^\d{17}[0-9Xx]$)/', $str)) {  //身份证号隐藏
            if (strlen($str) == 15) {
                $rs = preg_replace('/^(\d{3})\d{8}(\d{4})$/i', '$1********$2', $str);
            } else {
                $rs = preg_replace('/^(\d{4})\d{8}(\d{5}[0-9Xx])$/i', '$1********$2', $str);
            }
        }
        return $rs;
    }

}

// ------------------------------------------------------------------------

/**
 * 获取IP地址
 *
 *
 * @access	public
 * @param int
 * @return	string
 */
if ( ! function_exists('getUserIPAddress')) {
	function getUserIPAddress($time = 3) {
		$cip = '';
		$address = '';
		if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
			$cip = $_SERVER["HTTP_CLIENT_IP"];
		} else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else if (!empty($_SERVER["REMOTE_ADDR"])){
			$cip = $_SERVER["REMOTE_ADDR"];
		}
		if (!$cip) {
			return array('', '');
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
			curl_setopt($ch, CURLOPT_TIMEOUT, $time);
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
		}

		return array($cip, $address);
	}
}


// ------------------------------------------------------------------------

/**
 * clear string
 *
 */
if ( ! function_exists('checkLogin')) {
	function checkLogin($is_check_store = false) {
		$CI = & get_instance();
		$CI->load->library('session');
		if (!get_cookie('user_id')) {
			$data = array(
					'user_msg'=>'你还未登录,请登录',
					'user_url'=> base_url()."index.php/user/login.html"
			);

			$CI->session->set_userdata($data);
			redirect(base_url().'index.php/message/index');
			exit;
		}
		$CI->load->model('User_model', '', TRUE);
		$userInfo = $CI->User_model->get('display', array('id'=>get_cookie('user_id')));
		if (!$userInfo) {
			$data = array(
					'user_msg'=>'您的账号不存在或被管理员删除',
					'user_url'=> base_url()."index.php/user/logout"
			);
			$CI->session->set_userdata($data);
			redirect(base_url().'index.php/message/index');
			exit;
		}
		if ($userInfo['display'] == 0) {
			$data = array(
					'user_msg'=>'您的账号未激活，请联系网站客服',
					'user_url'=> base_url()."index.php"
			);

			$CI->session->set_userdata($data);
			redirect(base_url().'index.php/message/index');
			exit;
		} else if ($userInfo['display'] == 2) {
			$data = array(
					'user_msg'=>'您的账号被冻结，请联系网站客服',
					'user_url'=> base_url()."index.php"
			);
			$CI->session->set_userdata($data);
			redirect(base_url().'index.php/message/index');
			exit;
		}
		if ($is_check_store) {
			$CI->load->model('Store_model', '', TRUE);
            $CI->load->model('Seller_group_model', '', TRUE);
            if (!get_cookie('seller_group_id')){
                $data = array(
                    'user_msg'=>'您还未申请店铺,请申请店铺',
                    'user_url'=> base_url()."index.php/seller/my_join.html"
                );

                $CI->session->set_userdata($data);
                redirect(base_url().'index.php/message/index');
                exit;
            }
            $seller_group_info = $CI->Seller_group_model->get('user_id',array('id'=>get_cookie('seller_group_id')));
            if (!$seller_group_info) {
                $data = array(
                    'user_msg'=>'您还未申请店铺,请申请店铺',
                    'user_url'=> base_url()."index.php/seller/my_join.html"
                );

                $CI->session->set_userdata($data);
                redirect(base_url().'index.php/message/index');
                exit;
            }
            $storeInfo = $CI->Store_model->get('display,close_reason', array('user_id'=>$seller_group_info['user_id']));
			if (!$storeInfo) {
				$data = array(
						'user_msg'=>'您还未申请店铺,请申请店铺',
						'user_url'=> base_url()."index.php/seller/my_join.html"
				);

				$CI->session->set_userdata($data);
				redirect(base_url().'index.php/message/index');
				exit;
			}
			if ($storeInfo['display'] == 0) {
				$data = array(
						'user_msg'=>'店铺审核中，请耐心等待',
						'user_url'=> base_url()."index.php/seller.html"
				);

				$CI->session->set_userdata($data);
				redirect(base_url().'index.php/message/index');
				exit;
			} else if ($storeInfo['display'] == 2) {
				$data = array(
						'user_msg'=>'店铺审核暂未通过，原因：'.$storeInfo['close_reason'],
						'user_url'=> base_url()."index.php/seller.html"
				);

				$CI->session->set_userdata($data);
				redirect(base_url().'index.php/message/index');
				exit;
			} else if ($storeInfo['display'] == 3) {
				$data = array(
						'user_msg'=>'店铺已关闭，原因：'.$storeInfo['close_reason'],
						'user_url'=> base_url()."index.php/seller.html"
				);

				$CI->session->set_userdata($data);
				redirect(base_url().'index.php/message/index');
				exit;
			}
		}
	}
}

// ------------------------------------------------------------------------

/**
 * clear string
 *
 */
if ( ! function_exists('checkLoginAjax')) {
	function checkLoginAjax($is_check_store = false) {
		$CI = & get_instance();
		$CI->load->library('session');
		if (!get_cookie('user_id')) {
			$messageArr = array(
					'success'=> false,
					'field'=>   'fail',
					'message'=> '你还未登录,请登录'
			);
			echo json_encode($messageArr);
			exit;
		}
		$CI->load->model('User_model', '', TRUE);
		$userInfo = $CI->User_model->get('display', array('id'=>get_cookie('user_id')));
		if (!$userInfo) {
			$messageArr = array(
					'success'=> false,
					'field'=>   'fail',
					'message'=> '您的账号不存在或被管理员删除'
			);
			echo json_encode($messageArr);
			exit;
		}
		if ($userInfo['display'] == 0) {
			$messageArr = array(
					'success'=> false,
					'field'=>   'fail',
					'message'=> '您的账号未激活，请联系网站客服'
			);
			echo json_encode($messageArr);
			exit;
		} else if ($userInfo['display'] == 2) {
			$messageArr = array(
					'success'=> false,
					'field'=>   'fail',
					'message'=> '您的账号被冻结，请联系网站客服'
			);
			echo json_encode($messageArr);
			exit;
		} else if ($userInfo['display'] == 3) {
			$messageArr = array(
					'success'=> false,
					'field'=>   'fail',
					'message'=> '您的账号被冻结，请联系网站客服'
			);
			echo json_encode($messageArr);
			exit;
		}
		if ($is_check_store) {
			$CI->load->model('Store_model', '', TRUE);
			$CI->load->model('Seller_group_model', '', TRUE);
			if (!get_cookie('seller_group_id')){
                $messageArr = array(
                    'success'=> false,
                    'field'=>   'fail',
                    'message'=> '您还未申请店铺'
                );
                echo json_encode($messageArr);
                exit;
            }
			$seller_group_info = $CI->Seller_group_model->get('user_id',array('id'=>get_cookie('seller_group_id')));
            if (!$seller_group_info) {
                $messageArr = array(
                    'success'=> false,
                    'field'=>   'fail',
                    'message'=> '您还未申请店铺'
                );
                echo json_encode($messageArr);
                exit;
            }
			$storeInfo = $CI->Store_model->get('display,close_reason', array('user_id'=>$seller_group_info['user_id']));
			if (!$storeInfo) {
				$messageArr = array(
						'success'=> false,
						'field'=>   'fail',
						'message'=> '您还未申请店铺'
				);
				echo json_encode($messageArr);
				exit;
			}
			if ($storeInfo['display'] == 0) {
				$messageArr = array(
						'success'=> false,
						'field'=>   'fail',
						'message'=> '店铺审核中，请耐心等待'
				);
				echo json_encode($messageArr);
				exit;
			} else if ($storeInfo['display'] == 2) {
				$messageArr = array(
						'success'=> false,
						'field'=>   'fail',
						'message'=> '店铺审核暂未通过，原因：'.$storeInfo['close_reason']
				);
				echo json_encode($messageArr);
				exit;
			} else if ($storeInfo['display'] == 3) {
				$messageArr = array(
						'success'=> false,
						'field'=>   'fail',
						'message'=> '店铺已关闭，原因：'.$storeInfo['close_reason']
				);
				echo json_encode($messageArr);
				exit;
			}
		}
	}
}



/**
 * Determine access rights
 *
 *
 * @access	public
 * @param	string
 * @return	json
 */
if ( ! function_exists('checkPermission')) {
    function checkPermission($permissionsItem = NULL) {
        $CI = & get_instance();
        if (!$CI->advdbclass->getPermissions(get_cookie('seller_group_id'), $permissionsItem)) {
            $data = array(
                'user_msg'=>'没有权限',
                'user_url'=> "goback"
            );
            $CI->session->set_userdata($data);
            redirect(base_url().'index.php/message/index');
            exit;
        }
    }
}

// ------------------------------------------------------------------------

/**
 * Determine access rights
 *
 *
 * @access	public
 * @param	string
 * @return	json
 */
if ( ! function_exists('checkPermissionAjax')) {
    function checkPermissionAjax($permissionsItem = NULL) {
        $CI = & get_instance();
        if (!$CI->advdbclass->getPermissions(get_cookie('seller_group_id'), $permissionsItem)) {
            printAjaxError('fail', '没有此权限!');
        }
    }
}


// ------------------------------------------------------------------------
/**
 * 价格区间
 */
if ( ! function_exists('get_price_arr')) {
	function get_price_arr() {
		$price_arr = array('1'=>'6000-8000', '2'=>'5000-6000', '3'=>'4000-5000', '4'=>'3000-4000', '5'=>'2000-3000', '6'=>'1000-2000', '7'=>'500-1000', '8'=>'1-500', '9'=>'免费');

		return $price_arr;
	}
}

// ------------------------------------------------------------------------
/**
 * 色系
 */
if ( ! function_exists('get_color_style_arr')) {
	function get_color_style_arr() {
		$color_style_arr = array('1'=>array('棕色', 'images/default/1.png', 'zong'), '2'=>array('橙色', 'images/default/2.png', 'orange'), '3'=>array('炫彩', 'images/default/9.png', 'mix'), '4'=>array('粉色', 'images/default/3.png', 'pink'), '5'=>array('紫色', 'images/default/4.png', 'purple'), '6'=>array('红色', 'images/default/5.png', 'red'), '7'=>array('绿色', 'images/default/6.png', 'green'), '8'=>array('蓝色', 'images/default/7.png', 'blue'), '9'=>array('黑色', 'images/default/8.png', 'black'));

		return $color_style_arr;
	}
}

// ------------------------------------------------------------------------
/**
 * 平台
 */
if ( ! function_exists('get_device_arr')) {
	function get_device_arr() {
		$device_arr = array('1'=>'Web网站', '2'=>'原生App', '3'=>'混合App', '4'=>'手机网站', '5'=>'微网站');

		return $device_arr;
	}
}

// ------------------------------------------------------------------------
/**
 * xml转化为数组
 */
if ( ! function_exists('xmlToArray')) {
	function xmlToArray($xml){
	    //禁止引用外部xml实体
	    libxml_disable_entity_loader(true);
	    $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
	    $val = json_decode(json_encode($xmlstring),true);

	    return $val;
	}
}


// ------------------------------------------------------------------------

/**
 * 生成二维码
 *
 *
 * @access	public
 * @param int
 * @return	string
 */
if ( ! function_exists('create_qrcode')) {
	function create_qrcode($url = NULL, $logo = NULL) {
		include 'phpqrcode/phpqrcode.php';
		$errorCorrectionLevel = 'H';//容错级别
		$matrixPointSize = 6;//生成图片大小
		//生成二维码图片
		$QR = './uploads/qrcode.png';//已经生成的原始二维码图
		$logo = './'.$logo;
		QRcode::png($url, $QR, $errorCorrectionLevel, $matrixPointSize, 2);

		if ($logo !== FALSE) {
			$QR = imagecreatefromstring(file_get_contents($QR));
			$logo = imagecreatefromstring(file_get_contents($logo));
			$QR_width = imagesx($QR);//二维码图片宽度
			$QR_height = imagesy($QR);//二维码图片高度
			$logo_width = imagesx($logo);//logo图片宽度
			$logo_height = imagesy($logo);//logo图片高度
			$logo_qr_width = $QR_width / 4;
			$scale = $logo_width/$logo_qr_width;
			$logo_qr_height = $logo_height/$scale;
			$from_width = ($QR_width - $logo_qr_width) / 2;
			//重新组合图片并调整大小
			imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
			$logo_qr_height, $logo_width, $logo_height);
		}
		//输出图片
		imagepng($QR, "./uploads/qrcode_logo.png");
		echo '<img src="uploads/qrcode_logo.png" width="100px" height="100px" />';
		ImageDestroy($QR);
	}
}

// --------------------------------中间星号----------------------------------------

/**
 * clear string
 *
 */
if ( ! function_exists('createMobileBit')) {
	function createMobileBit($mobile = NULL) {
		return  str_replace(mb_substr($mobile, 3, 4), '****', $mobile);
	}
}

// --------------------------------判断是手机还是PC----------------------------------------

/**
 * clear string
 *
 */
if ( ! function_exists('is_mobile_request')) {
	function is_mobile_request($mobile = NULL) {
		$_SERVER ['ALL_HTTP'] = isset ( $_SERVER ['ALL_HTTP'] ) ? $_SERVER ['ALL_HTTP'] : '';
		$mobile_browser = '0';
		if (preg_match ( '/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower ( $_SERVER ['HTTP_USER_AGENT'] ) ))
			$mobile_browser ++;
		if ((isset ( $_SERVER ['HTTP_ACCEPT'] )) and (strpos ( strtolower ( $_SERVER ['HTTP_ACCEPT'] ), 'application/vnd.wap.xhtml+xml' ) !== false))
			$mobile_browser ++;
		if (isset ( $_SERVER ['HTTP_X_WAP_PROFILE'] ))
			$mobile_browser ++;
		if (isset ( $_SERVER ['HTTP_PROFILE'] ))
			$mobile_browser ++;
		$mobile_ua = strtolower ( substr ( $_SERVER ['HTTP_USER_AGENT'], 0, 4 ) );
		$mobile_agents = array ('w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac', 'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno', 'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-', 'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-', 'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox', 'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar', 'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-', 'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp', 'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-' );
		if (in_array ( $mobile_ua, $mobile_agents ))
			$mobile_browser ++;
		if (strpos ( strtolower ( $_SERVER ['ALL_HTTP'] ), 'operamini' ) !== false)
			$mobile_browser ++;
		// Pre-final check to reset everything if the user is on Windows
		if (strpos ( strtolower ( $_SERVER ['HTTP_USER_AGENT'] ), 'windows' ) !== false)
			$mobile_browser = 0;
		// But WP7 is also Windows, with a slightly different characteristic
		if (strpos ( strtolower ( $_SERVER ['HTTP_USER_AGENT'] ), 'windows phone' ) !== false)
			$mobile_browser ++;
		if ($mobile_browser > 0)
			return true;
		else
			return false;
	}
}

// --------------------------------中间星号----------------------------------------

/**
 * clear string
 *
 */
if ( ! function_exists('filter_address')) {
	function filter_address($str = NULL) {
		$ret = '';
		if ($str) {
            $arr = explode(' ', $str);
            if ($arr[0] == '北京市' || $arr[0] == '天津市' || $arr[0] == '上海市' || $arr[0] == '重庆市') {
            	$ret = $arr[0];
            } else {
            	$ret = $arr[1];
            }
		}

		return $ret;
	}
}
/**
 * clear string
 *
 */
if ( ! function_exists('myInArray')) {
	function myInArray($action = NULL, $serviceList = NULL, $field = 'product_category_id') {
		if ($action && $serviceList) {
			foreach ($serviceList as $key=>$value) {
				if ($value[$field] == $action) {
					return true;
					break;
				}
			}
		}

		return false;
	}
}


// ------------------------------------------------------------------------
/**
 * 判断用户
 */
if ( ! function_exists('check_store')) {
	function check_store() {
		$CI = & get_instance();
        $CI->load->model('Seller_group_model', '', TRUE);
        $seller_group_info = $CI->Seller_group_model->get('user_id',array('id'=>get_cookie('seller_group_id')));
        if (!$seller_group_info) {
            return false;
        }else{
            return $CI->advdbclass->check_store($seller_group_info['user_id']);

        }
	}
}

/**
 * 判断实体商家和实力电商
 */
if ( ! function_exists('check_store_type')) {
    function check_store_type() {
        $CI = & get_instance();
        $CI->load->model('Seller_group_model', '', TRUE);
        $CI->load->model('Store_model', '', TRUE);
        $seller_group_info = $CI->Seller_group_model->get('user_id',array('id'=>get_cookie('seller_group_id')));
        if (!$seller_group_info) {
            return false;
        }else {
            $store_info = $CI->Store_model->get('store_auth,retailer_auth', array('user_id' => $seller_group_info['user_id']));
            if ($store_info) {
                if ($store_info['store_auth'] || $store_info['retailer_auth']) {
                    return true;
                }
            }
            return false;
        }
    }
}

/**
 * 加盐算法
 *
 *
 */
if (!function_exists('create_password_salt')) {
    function create_password_salt($user = NULL, $salt = NULL, $password = NULL) {
        return md5(strtolower($user) . $salt . $password);
    }
}


/**
 * 返回二维码
 *
 *
 * @access	public
 * @param int
 * @return	string
 */
if ( ! function_exists('get_qrcode')) {
    function get_qrcode($url = NULL, $matrixPointSize = 6) {
        include 'phpqrcode/phpqrcode.php';
        $errorCorrectionLevel = 'H';//容错级别
        //生成二维码图片
        $qr = QRcode::png($url, 2, $errorCorrectionLevel, $matrixPointSize, 2);

        return $qr;
    }
}

// --------------------------------替换内容图片的路径－相对路径换成绝对路径----------------------------------------

/**
 * clear string
 *
 */
if ( ! function_exists('filter_content')) {
    function filter_content($content = '', $url = '') {
        preg_match_all("/<img(.*)src=\"([^\"]+)\"[^>]+>/isU", $content, $matches);
        if($matches){
            $img_url_arr = $matches[2];
            $img_url_arr = array_unique($img_url_arr);
            if ($img_url_arr) {
                foreach($img_url_arr as $val){
                    if (!preg_match('/^http/', $val)) {
                        $content = str_replace($val, $url.$val, $content);
                    }
                }
            }
        }

        return $content;
    }
}
/* End of file my_functionlib_helper.php */
/* Location: ./application/admin/helpers/my_functionlib_helper.php */