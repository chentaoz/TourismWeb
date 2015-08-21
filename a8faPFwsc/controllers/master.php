<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends CI_Controller {
	private $rights=array(
		'backup'=>1,
		'backupData'=>1,
		'manage'=>2,
		'optimize'=>2,
		'repair'=>2,
		'showTable'=>2,
		'sql'=>3,
		'execSql'=>3
	);
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->lang->load('default');
		$this->lang->load('master');//加载语言包
		$this->load->model('common_model','common');
		$this->load->model('system_model','system');
		$this->system->isLogin();
		$method=$this->uri->rsegment(2);//获取控制器中的方法
		if (array_key_exists($method,$this->rights)) {//进行权限控制
			$this->system->verify($this->rights[$method]);
		}
	}
	public function backup(){
		$this->load->helper(array('form'));
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js));
		$data['form']=form_open('master/backupData',array('id'=>'form1'));
		$data['tables']=$this->db->list_tables();
		$this->load->view('head',$data);
		$this->load->view('master_backup');
		$this->load->view('foot');
	}
	public function backupData(){
		$tables=$this->input->post();
		unset($tables['Submit']);
		unset($tables['checkall']);
		unset($tables['local']);
		if (!count($tables)) {
			message($this->lang->line('master_select_table'),'master/backup');
		}
		$config=array('tables'=>$tables,'format'=>'zip');
		$name=date('Y-m-d H-i-s',time()).'_'.md5(uniqid(mt_rand()));
		$filename=$name.'.zip';
		if (file_exists(FCPATH.'data/'.$filename)) {
			for($i=1;$i<=100;$i++){
				$filename=$name.'_v'.$i.'.zip';
				if (!file_exists(FCPATH.'data/'.$filename)) {
					break;
				}
			}
		}
		$config['filename']=$filename;
		$this->load->dbutil();
		$backup=&$this->dbutil->backup($config);
		$this->load->helper(array('file','download'));
		write_file(FCPATH.'data/'.$config['filename'],$backup);
		$local=trim($this->input->post('local'));
		if ($local==1) {
			force_download($config['filename'],$backup);
		}
		message($this->lang->line('success'),'master/backup');
	}
	public function manage(){
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'global.js'));
		$t['data']=$t['free']=$t['record']=$t['total']='';
		$r=$this->db->query('show table status from '.$this->db->database);
		$r=$r->result_array();
		foreach ($r as $k=>$v){
			$r[$k]['Data_length']=$r[$k]['Data_length']/1024;
			$r[$k]['Data_free']=$r[$k]['Data_free']/1024;
			$t['data']+=$r[$k]['Data_length'];
			$t['free']+=$r[$k]['Data_free'];
			$t['record']+=$r[$k]['Rows'];
			$t['total']++;
		}
		$t['data']=number_format($t['data'],2,'.',',');
		$t['free']=number_format($t['free'],2,'.',',');
		foreach ($r as $k=>$v){
			$r[$k]['Data_length']=number_format($v['Data_length'],2,'.',',');
			$r[$k]['Data_free']=number_format($v['Data_free'],2,'.',',');
			$d=$this->db->query('check table '.$v['Name']);
			$d=$d->result_array();
			$r[$k]['status']=$d[0]['Msg_text'];
		}
		$data['info']=$r;
		$data['t']=$t;
		$this->load->view('head',$data);
		$this->load->view('master_manage');
		$this->load->view('foot');
	}
	public function optimize(){
		$table=$this->uri->segment(4);
		$table=$table!==false?$table:message($this->lang->line('error'),'master/manage');
		$this->load->dbutil();
		$this->dbutil->optimize_table($table);
		message($this->lang->line('success'),'master/manage');
	}
	public function repair(){
		$table=$this->uri->segment(4);
		$table=$table!==false?$table:message($this->lang->line('error'),'master/manage');
		$this->load->dbutil();
		$this->dbutil->repair_table($table);
		message($this->lang->line('success'),'master/manage');
	}
	public function showTable(){
		$table=$this->uri->segment(4);
		$table=$table!==false?$table:message($this->lang->line('error'),'master/manage');
		$r=$this->db->query('describe '.$table);
		$r=$r->result_array();
		$data=$this->common->setConfig($this->common->configs,array('global.css'));
		$data['d']=$r;
		$this->load->view('head',$data);
		$this->load->view('master_table_struct');
		$this->load->view('foot');
	}
	public function execSql(){
		$this->load->helper('form');
		$data=$this->common->setConfig($this->common->configs,array('global.css'));
		$data['form']=form_open('master/sql');
		$this->load->view('head',$data);
		$this->load->view('master_sql');
		$this->load->view('foot');
	}
	public function sql(){
		$sql=trim($this->input->post('sql'));
		$sql=$sql?$sql:message($this->lang->line('master_input_sql'),'master/execSql');
		$r=$this->db->simple_query($sql);
		if ($r) {
			message($this->lang->line('success'),'master/execSql');
		}
		else {
			message($this->lang->line('failure'),'master/execSql');
		}
	}
}