<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {
	private $rights=array(
		
	);
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->lang->load('news');//加载语言包
		$this->load->model('common_model','common');
		$this->load->model('system_model','system');
		$this->system->isLogin();
		$method=$this->uri->rsegment(2);//获取控制器中的方法
		if (array_key_exists($method,$this->rights)) {//进行权限控制
			$this->system->verify($this->rights[$method]);
		}
	}
	public function bclass(){
		$this->load->helper(array('form'));
		$this->load->model('news_model');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js','global.js'));
		$data['form']=form_open('news/bclassSave',array('id'=>'form1'));
		$bclass=$this->news_model->bclass();
		foreach ($bclass as $k=>$v){
			$bclass[$k]['sclass']=$this->news_model->Sclass($v['id']);
		}
		$data['results']=$bclass;
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('news_class');
		$this->load->view('foot');
	}
	public function bclassSave(){//保存新增的一级分类
		$name=$this->input->post('name');
		$name=$name?$name:message($this->lang->line('news_name'),'news/bclass');
		$this->db->insert('article_bclass',array('name'=>$name));
		message($this->lang->line('success'),'news/bclass');
	}
	public function bclassDel(){//删除一级分类
		$id=$this->uri->segment(3);
		$id=$id===false?message($this->lang->line('news_para')):$id;
		$r=$this->db->get_where('article_sclass',array('bid'=>$id));
		if ($r->num_rows()>0) {
			message($this->lang->line('news_subclass'),'news/bclass');
		}
		$this->db->delete('article_bclass',array('id'=>$id));
		message($this->lang->line('success'),'news/bclass');
	}
	public function bclassEdit(){//编辑一级分类
		$id=$this->uri->segment(3);
		$id=$id===false?message($this->lang->line('news_para')):$id;
		$this->load->helper(array('form'));
		$this->load->model('news_model');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$data['form']=form_open('news/bclassEditSave',array('id'=>'form1'));
		$data['class']=$this->news_model->getClass($id);
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('news_bclass_edit');
		$this->load->view('foot');
	}
	public function bclassEditSave(){
		$name=$this->input->post('name');
		$paixun=$this->input->post('paixun');
		$id=$this->input->post('id');
		if (!$name||!$paixun||!$id) {
			message($this->lang->line('news_input'),'news/bclassEdit/'.$id);
		}
		$data=array('name'=>$name,'paixun'=>$paixun);
		$this->db->update('article_bclass',$data,array('id'=>$id));
		message($this->lang->line('success'),'news/bclass');
	}
	public function sclass(){
		$id=$this->uri->segment(3);
		$id=$id===false?message($this->lang->line('news_para')):$id;
		$this->load->helper(array('form'));
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$data['form']=form_open('news/sclassSave',array('id'=>'form1'));
		$data['bid']=$id;
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('news_sclass');
		$this->load->view('foot');
	}
	public function sclassSave(){//保存新增的二级分类
		$name=$this->input->post('name');
		$bid=$this->input->post('bid');
		if (!$name||!$bid) {
			message($this->lang->line('news_name'),'news/bclass');
		}
		$this->db->insert('article_sclass',array('name'=>$name,'bid'=>$bid));
		message($this->lang->line('success'),'news/bclass');
	}
	public function sclassDel(){//删除二级分类
		$id=$this->uri->segment(3);
		$id=$id===false?message($this->lang->line('news_para')):$id;
		$this->db->delete('article_sclass',array('id'=>$id));
		message($this->lang->line('success'),'news/bclass');
	}
	public function sclassEdit(){//编辑二级分类
		$id=$this->uri->segment(3);
		$id=$id===false?message($this->lang->line('news_para')):$id;
		$this->load->helper(array('form'));
		$this->load->model('news_model');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$data['form']=form_open('news/sclassEditSave',array('id'=>'form1'));
		$data['class']=$this->news_model->getClass($id,'small');
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('news_sclass_edit');
		$this->load->view('foot');
	}
	public function sclassEditSave(){
		$name=$this->input->post('name');
		$paixun=$this->input->post('paixun');
		$id=$this->input->post('id');
		if (!$name||!$paixun||!$id) {
			message($this->lang->line('news_input'),'news/sclassEdit/'.$id);
		}
		$data=array('name'=>$name,'paixun'=>$paixun);
		$this->db->update('article_sclass',$data,array('id'=>$id));
		message($this->lang->line('success'),'news/bclass');
	}
	public function moveTo(){
		$id=$this->uri->segment(3);
		$id=$id===false?message($this->lang->line('news_para')):$id;
		$this->load->helper(array('form'));
		$this->load->model('news_model');
		$data=$this->common->setConfig($this->common->configs,array('global.css'));
		$data['form']=form_open('news/moveToSave',array('id'=>'form1'));
		$data['bid']=$this->news_model->getBidBySid($id);
		$data['sid']=$id;
		$data['classic']=$this->news_model->classic();
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('news_class_moveto');
		$this->load->view('foot');
	}
	public function moveToSave(){
		$bid=$this->input->post('bid');
		$sid=$this->input->post('sid');
		if (!$bid||!$sid) {
			message($this->lang->line('news_para'),'news/moveTo/'.$sid);
		}
		$data=array('bid'=>$bid);
		$this->db->update('article_sclass',$data,array('id'=>$sid));
		message($this->lang->line('success'),'news/bclass');
	}
	public function add(){//新增信息
		$this->load->helper(array('form'));
		$this->load->model('news_model');
		$data=$this->common->setConfig($this->common->configs,array('global.css','jyytemp.css'),array($this->common->js,'My97DatePicker/WdatePicker.js','validateMyForm/jquery.validateMyForm.1.0.js','place.js','sport.js'));
		$data['form']=form_open_multipart('news/save',array('id'=>'form1'));
		$data['classic']=$this->news_model->classic();
		$data['date']=date('Y-m-d',time());
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('news_add');
		$this->load->view('foot');
	}
	public function save(){
		$classic=trim($this->input->post('classic'));
		$title=trim($this->input->post('title'));
		$title2=trim($this->input->post('title2'));
		$color=trim($this->input->post('color'));
		$keyword=trim($this->input->post('keyword'));
		$description=trim($this->input->post('description'));
		$fromwho=trim($this->input->post('fromwho'));
		$author=trim($this->input->post('author'));
		$flag=trim($this->input->post('flag'));
		$is_focus=trim($this->input->post('is_focus'));
		$is_top=trim($this->input->post('is_top'));
		$content=trim($this->input->post('content'));
        $abstract=trim($this->input->post('abstract'));
		$date=$this->input->post('stime');
        if(!isset($_POST['ptag'])) {
            $ptags = Array();
        } else {
            $ptags = $_POST['ptag'];
        }
        if(!isset($_POST['stag'])) {
            $stags = Array();
        } else {
            $stags = $_POST['stag'];
        }
		$classic?$classic:message($this->lang->line('news_input_classic'),'news/add');
		$title?$title:message($this->lang->line('news_input_title'),'news/add');
		$content?$content:message($this->lang->line('news_input_content'),'news/add');
		$data=array('classic'=>$classic,'title'=>$title,'title_2'=>$title2,'abstract'=>$abstract,'content'=>$content,'author'=>$author,'keyword'=>$keyword,'description'=>$description,'color'=>$color,'fromwho'=>$fromwho,'is_top'=>$is_top,'is_focus'=>$is_focus,'is_visible'=>$flag,'created'=>$this->common->makeTime('-',$date),'update'=>$this->common->makeTime('-',$date));
		$config=array('upload_path'=>ROOTPATH.$this->config->item('upload_news'),'allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>true);
		$this->load->library('upload',$config);
		if ($this->upload->do_upload()) {
			$img=$this->upload->data();
			$data['img']=$img['file_name'];
		}
		$this->db->insert('article',$data);
        if ($this->db->affected_rows()>0) {
            $this->db->select('LAST_INSERT_ID() AS id');
            $id=$this->db->get();
            $id=$id->row_array(0);
            $id=$id['id'];
            foreach ($ptags as $v) {
                $this->db->set('article_id', $id);
                $this->db->set('tag_id', $v);
                $this->db->set('flag', 1);
                $this->db->insert('article_tag');
            }
            foreach ($stags as $sv) {
                $this->db->set('article_id', $id);
                $this->db->set('tag_id', $sv);
                $this->db->set('flag', 2);
                $this->db->insert('article_tag');
            }
            message($this->lang->line('success'),'news/add');
        }else {
            message($this->lang->line('failure'),'news/add');
        }
	}
	public function manage(){
		$this->load->helper(array('form'));
		$this->load->model('news_model');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'global.js'));
		$data['formsearch']=form_open('news/manage',array('id'=>'form1'));
		$data['forminfo']=form_open('news/op');
		$data['classic']=$this->news_model->classic();
		$urldata=$this->uri->uri_to_assoc(3);
		$key=trim($this->input->post('keyword'));
		if (!$key) {
			if (array_key_exists('keyword',$urldata)) {
				$key=urldecode($urldata['keyword']);
			}
			else {
				$key=null;
			}
		}
		$classic=trim($this->input->post('classic'));
		if (!$classic) {
			if (array_key_exists('classic',$urldata)) {
				$classic=urldecode($urldata['classic']);
			}
			else {
				$classic=null;
			}
		}
		$url='/news/manage';
		if ($key) {
			$this->db->like('title',$key);
			$url.='/keyword/'.$key;
		}
		if ($classic) {
			$this->db->where('classic',$classic);
			$url.='/classic/'.$classic;
		}
		$db=clone $this->db;
		$total=$this->db->count_all_results('article');
		$this->load->library('pagination');
		$url=base_url(index_page().$url.'/page/');
		$currpage=array_search('page',$this->uri->segment_array())+1;
		$config=$this->common->pageConfig($url,$total,15,$currpage);
		$this->pagination->initialize($config);
		$this->db=$db;
		$this->db->select('a.*,b.name');
		$this->db->from('article as a');
		$this->db->join('article_sclass as b','a.classic=b.id');
		$this->db->order_by('a.id','desc');
		$this->db->limit($config['per_page'],$this->uri->segment($config['uri_segment'],0));
		$news=$this->db->get();
		$data['news']=$news->result_array();
		$data['keyword']=$key?$key:'';
		$data['sid']=$classic?$classic:'';
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('news_manage');
		$this->load->view('foot');
	}
	public function edit(){
		$id=$this->uri->segment(3,0);
		$id=$id?$id:message($this->lang->line('news_para'),'news/manage');
		$this->load->helper(array('form'));
		$this->load->model('news_model');
		$data=$this->common->setConfig($this->common->configs,array('global.css','jyytemp.css'),array($this->common->js,'My97DatePicker/WdatePicker.js','validateMyForm/jquery.validateMyForm.1.0.js','place.js','sport.js'));
		$news=$this->news_model->getNews($id);
		$data['form']=form_open_multipart('news/editSave',array('id'=>'form1'));
		$data['classic']=$this->news_model->classic();
		$data['date']=date('Y-m-d',$news['created']);
        $ptag = $this->db->get_where('article_tag',array('article_id'=>$id,'flag'=>1))->result_array();
        foreach($ptag as $k=>$v){
            $tem = $this->db->select('name')->get_where('place',array('pid'=>$v['tag_id']))->row_array();
            $ptag[$k]['name'] = $tem['name'];
        }
        $stag = $this->db->get_where('article_tag',array('article_id'=>$id,'flag'=>2))->result_array();
        foreach($stag as $k=>$v){
            $tem = $this->db->select('name')->get_where('sport',array('spid'=>$v['tag_id']))->row_array();
            $stag[$k]['name'] = $tem['name'];
        }
        $data['ptags']=$ptag;
        $data['stags']=$stag;
		$data['news']=$news;
        $data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('news_edit');
		$this->load->view('foot');
	}
	public function editSave(){
		$id=$this->input->post('id');
		$id=$id?$id:message($this->lang->line('news_para'),'news/manage');
		$classic=trim($this->input->post('classic'));
		$title=trim($this->input->post('title'));
		$title2=trim($this->input->post('title2'));
		$color=trim($this->input->post('color'));
		$keyword=trim($this->input->post('keyword'));
		$description=trim($this->input->post('description'));
		$fromwho=trim($this->input->post('fromwho'));
		$author=trim($this->input->post('author'));
		$flag=trim($this->input->post('flag'));
		$is_focus=trim($this->input->post('is_focus'));
		$is_top=trim($this->input->post('is_top'));
        $abstract=trim($this->input->post('abstract'));
		$content=trim($this->input->post('content'));
        if(!isset($_POST['ptag'])) {
            $ptags = Array();
        } else {
            $ptags = $_POST['ptag'];
        }
        if(!isset($_POST['stag'])) {
            $stags = Array();
        } else {
            $stags = $_POST['stag'];
        }
		$classic?$classic:message($this->lang->line('news_input_classic'),'news/edit');
		$title?$title:message($this->lang->line('news_input_title'),'news/edit');
		$content?$content:message($this->lang->line('news_input_content'),'news/edit');
        if($this->input->post('upt')==1){
            $data=array('classic'=>$classic,'title'=>$title,'title_2'=>$title2,'abstract'=>$abstract,'content'=>$content,'author'=>$author,'keyword'=>$keyword,'description'=>$description,'color'=>$color,'fromwho'=>$fromwho,'is_top'=>$is_top,'is_focus'=>$is_focus,'is_visible'=>$flag,'update'=>time());
        }else{
            $data=array('classic'=>$classic,'title'=>$title,'title_2'=>$title2,'abstract'=>$abstract,'content'=>$content,'author'=>$author,'keyword'=>$keyword,'description'=>$description,'color'=>$color,'fromwho'=>$fromwho,'is_top'=>$is_top,'is_focus'=>$is_focus,'is_visible'=>$flag);
        }
		$config=array('upload_path'=>ROOTPATH.$this->config->item('upload_news'),'allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>true);
		$this->load->library('upload',$config);

		if ($this->upload->do_upload()) {
			$img=$this->upload->data();
			$data['img']=$img['file_name'];
		}
		$this->db->where('id',$id);
		$this->db->update('article',$data);
        $this->db->delete('article_tag',array('article_id'=>$id));
        foreach ($ptags as $v) {
                $this->db->set('article_id', $id);
                $this->db->set('tag_id', $v);
                $this->db->set('flag', 1);
                $this->db->insert('article_tag');
        }
        foreach ($stags as $sv) {
                $this->db->set('article_id', $id);
                $this->db->set('tag_id', $sv);
                $this->db->set('flag', 2);
                $this->db->insert('article_tag');
        }
            message($this->lang->line('success'),'news/manage');
	}
	public function del(){
		$id=$this->uri->segment(3,0);
		$id=$id?$id:message($this->lang->line('news_para'),'news/manage');
		$this->db->delete('article',array('id'=>$id));
		message($this->lang->line('success'),'news/manage');
	}
	/**
	 * 设置信息的状态，其中包括是否为焦点，是否置顶，是否显示三种状态
	 *
	 */
	public function setStatus(){
		$id=$this->uri->segment(4,0);
		$id=$id?$id:message($this->lang->line('news_para'),'news/manage');
		$flag=$this->uri->segment(6,0);
		$flag=$flag?$flag:message($this->lang->line('news_para'),'news/manage');
		$typical=$this->uri->segment(8,0);
		$typical=$typical?$typical:message($this->lang->line('news_para'),'news/manage');
		$url='news/setStatus/id/'.$id;
		if ($flag==1) {
			$url.='/flag/2';
		}
		else {
			$url.='/flag/1';
		}
		$this->db->where('id',$id);
		switch ($typical){
			case 1:
				$this->db->update('article',array('is_focus'=>$flag));//设置是否焦点
				$url.='/typical/1';
				break;
			case 2:
				$this->db->update('article',array('is_top'=>$flag));//设置是否置顶
				$url.='/typical/2';
				break;
			case 3:
				$this->db->update('article',array('is_visible'=>$flag));//设置是否显示
				$url.='/typical/3';
				break;
		}
		$url=site_url($url);
		if ($this->db->affected_rows()) {
			if ($flag==1) {
				echo '<img src="'.base_url().'images/yes.gif" onclick=setType(this,"'.$url.'") title="'.$this->lang->language['click_edit'].'" />';
			}
			else {
				echo '<img src="'.base_url().'images/no_gray.gif" onclick=setType(this,"'.$url.'") title="'.$this->lang->language['click_edit'].'" />';
			}
		}
	}
	public function preview(){
		$id=$this->uri->segment(4,0);
		$id=$id?$id:message($this->lang->line('news_para','news/manage'));
		$data=$this->common->setConfig($this->common->configs,array('global.css'));
		$this->load->model('news_model');
		$data['news']=$this->news_model->getNews($id);
		$this->load->view('head',$data);
		$this->load->view('news_preview');
		$this->load->view('foot');
	}
	//更新信息标题
	public function updateTitle(){
		$id=$this->uri->segment(4,0);
		$id=$id?$id:message($this->lang->line('news_para','news/manage'));
		$name=trim($this->uri->segment(6,0));
		$name=$name?urldecode($name):message($this->lang->line('news_para','news/manage'));
		$sname=trim($this->uri->segment(8,0));
		$sname=$sname?urldecode($sname):message($this->lang->line('news_para','news/manage'));
		$this->db->where('id',$id);
		$this->db->update('article',array('title'=>$name));
		if ($this->db->affected_rows()>0) {
			echo $name;
		}
		else {
			echo $sname;
		}
	}
	/**
	 * 删除缩略图
	 *
	 */
	public function imgDel(){
		$id=trim($this->uri->segment(4,0));
		$id=$id?$id:message($this->lang->line('news_para'),'news/manage');
		$img=trim($this->uri->segment(6,0));
		$img=$img?$img:message($this->lang->line('news_para'),'news/manage');
		$this->db->where('id',$id);
		$this->db->update('article',array('img'=>null));
		unlink(ROOTPATH.$this->config->item('upload_news').'/'.$img);
		message($this->lang->line('success'),'news/manage');
	}
	public function imgAdd(){
		$id=trim($this->uri->segment(4,0));
		$id=$id?$id:message($this->lang->line('news_para'),'news/manage');
		$this->load->helper('form');
		$data=$this->common->setConfig($this->common->configs,array('global.css'));
		$data['form']=form_open_multipart('news/imgSave');
		$data['id']=$id;
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('news_img_add');
		$this->load->view('foot');
	}
	public function imgSave(){
		$id=trim($this->input->post('id'));
		$id=$id?$id:message($this->lang->line('news_para'),'news/manage');
		$config=array('upload_path'=>ROOTPATH.$this->config->item('upload_news'),'allowed_types'=>'jpg|gif|png','overwrite'=>false,'encrypt_name'=>true);
		$this->load->library('upload',$config);
		if ($this->upload->do_upload()) {
			$img=$this->upload->data();
			$imgname=$img['file_name'];
		}
		else {
			message($this->lang->line('failure'),'news/manage');
		}
		$this->db->where('id',$id);
		$this->db->update('article',array('img'=>$imgname));
		if ($this->db->affected_rows()>0) {
			message($this->lang->line('success'),'news/manage');
		}
		else {
			message($this->lang->line('failure'),'news/manage');
		}
	}
	public function op(){
		$submit1=$this->input->post('submit1');
		$submit2=$this->input->post('submit2');
		$ids=array();
		foreach ($this->input->post() as $k=>$v){
			if (is_numeric($k)) {
				$ids[]=$v;
			}
		}
		if (!count($ids)) {
			message($this->lang->line('news_para'),'news/manage');
		}
		if ($submit1==$this->lang->line('del_choose')) {
			$this->db->where('id in('.implode(',',$ids).')');
			$this->db->delete('article');
			message($this->lang->line('success'),'news/manage');
		}
		if ($submit2==$this->lang->line('move_choose')) {
			redirect(base_url(index_page().'/news/movetoNews/ids/'.implode('-',$ids)));
		}
	}
	public function movetoNews(){
		$ids=trim($this->uri->segment(4,0));
		$ids=$ids?$ids:message($this->lang->line('news_para'),'news/manage');
		$this->load->helper('form');
		$data=$this->common->setConfig($this->common->configs,array('global.css'),array($this->common->js,'validateMyForm/jquery.validateMyForm.1.0.js'));
		$data['form']=form_open('news/movetoNewsSave',array('id'=>'form1'));
		$this->load->model('news_model');
		$data['classic']=$this->news_model->classic();
		$data['ids']=$ids;
		$data['lang']=$this->lang->language;
		$this->load->view('head',$data);
		$this->load->view('news_news_moveto');
		$this->load->view('foot');
	}
	public function movetoNewsSave(){
		$sid=trim($this->input->post('classic'));
		$ids=$this->input->post('ids');
		$ids=$ids?$ids:message($this->lang->line('news_para'),'news/manage');
		$ids=str_replace('-',',',$ids);
		$this->db->where('id in('.$ids.')');
		$this->db->update('article',array('classic'=>$sid));
		message($this->lang->line('success'),'news/manage');
	}
	//更新信息的一级分类的排序
	public function updateBSort(){
		$id=$this->uri->segment(4,0);
		$id=isset($id)?$id:message($this->lang->line('news_para','news/manage'));
		$name=trim($this->uri->segment(6,0));
		$name=isset($name)?urldecode($name):message($this->lang->line('news_para','news/manage'));
		$sname=trim($this->uri->segment(8,0));
		$sname=isset($sname)?urldecode($sname):message($this->lang->line('news_para','news/manage'));
		$this->db->where('id',$id);
		$this->db->update('article_bclass',array('paixun'=>$name));
		if ($this->db->affected_rows()>0) {
			echo $name;
		}
		else {
			echo $sname;
		}
	}
	//更新信息的二级分类的排序
	public function updateSSort(){
		$id=$this->uri->segment(4,0);
		$id=isset($id)?$id:message($this->lang->line('news_para','news/manage'));
		$name=trim($this->uri->segment(6,0));
		$name=isset($name)?urldecode($name):message($this->lang->line('news_para','news/manage'));
		$sname=trim($this->uri->segment(8,0));
		$sname=isset($sname)?urldecode($sname):message($this->lang->line('news_para','news/manage'));
		$this->db->where('id',$id);
		$this->db->update('article_sclass',array('paixun'=>$name));
		if ($this->db->affected_rows()>0) {
			echo $name;
		}
		else {
			echo $sname;
		}
	}
}