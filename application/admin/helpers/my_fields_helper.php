<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * 对应颜色的
 */
if ( ! function_exists('getColorName')) {
    function getColorName($isSpace = 1) {
		if (!$isSpace) {
		    return '颜色';
		} else {
		    return '颜&#12288;&#12288;色';
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
		    return '尺码';
		} else {
		    return '尺&#12288;&#12288;码';
		}
	}
}
/* End of file html_helper.php */
/* Location: ./application/admin/helpers/My_ajaxerror.php */