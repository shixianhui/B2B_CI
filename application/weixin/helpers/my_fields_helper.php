<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * 对应颜色的
 */
if ( ! function_exists('getColorName')) {
    function getColorName($isSpace = 1) {
		if (!$isSpace) {
		    return '终端';
		} else {
		    return '终&#12288;端';
		}
	}
}

// ------------------------------------------------------------------------

/*
 * 对应尺码的
 */
if ( ! function_exists('getSizeName')) {
    function getSizeName($isSpace = 1) {
	    if (!$isSpace) {
		    return '主机';
		} else {
		    return '主&#12288;机';
		}
	}
}
/* End of file html_helper.php */
/* Location: ./application/admin/helpers/My_ajaxerror.php */