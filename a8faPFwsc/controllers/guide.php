<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class guide extends MY_Controller {
	private $rights=array(
		
	);
	public function __construct(){
		parent::__construct();
		$method=$this->uri->rsegment(2);//获取控制器中的方法
		if (array_key_exists($method,$this->rights)) {//进行权限控制
			$this->system->verify($this->rights[$method]);
		}
	}
	
}