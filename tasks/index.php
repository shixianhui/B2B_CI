<?php
/**
 * ECSHOP 首页文件
 * ============================================================================
 * * 版权所有 2005-2012 杭州故乡人网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: index.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS', true);
ignore_user_abort(true);
set_time_limit(0);
//$interval = 60*5;
$interval = 5;
do{
	$run = include 'config.php';
	if($run==1){
		$url  = "http://localhost/yiliwang/index.php/groupon/auto_refund_deposit";
		$ch   = curl_init();
		$data = "";
		curl_setopt($ch, CURLOPT_URL, $url);          //发贴地址
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //1=隐藏完整信息
		curl_setopt($ch, CURLOPT_POST, true);         //设置POST方式
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);// post传输数据
		curl_setopt($ch, CURLOPT_TIMEOUT,2);           //最大延续2秒
		$result = curl_exec($ch);
		curl_close($ch);
		sleep($interval);//休息5分钟
	}else{
		die();
	}
}while(true);
exit;
?>