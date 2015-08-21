<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

if (!function_exists('message')) {
	/*
	* 信息提示跳转
	* @param   标题
	* @param   内容
	* @param   跳转目标
	* @param   跳转延时
	*/

	function message( $content, $target_url, $delay_time =1) {
		$_CI = &get_instance();
		$_CI->load->view('message', array(
		'content' => $content,
		'target_url' => $target_url,
		'delay_time' => $delay_time,
		'lang'=>$_CI->lang->language
		));
	}
}