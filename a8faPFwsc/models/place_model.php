<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Place_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	/**
	 * 根据目的地id检索该目的地相关信息
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function get($id){
		$r=$this->db->get_where('place',array('pid'=>$id));
		if ($r->num_rows()==0) {
			return false;
		}
		return $r->row_array();
	}
	/**
	 * 根据目的地id逻辑删除该目的地
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function del($id){
		$this->db->update('place',array('del'=>1),array('pid'=>$id));
		if ($this->db->affected_rows()>0) {
			return true;
		}
		return false;
	}
	/**
	 * 保存新增的目的地信息，注意这里的$data数组的键名需跟数据表里面的字段名称相对应
	 *
	 * @param unknown_type $data
	 * @return unknown
	 */
	public function add($data){
		if (!is_array($data)||count($data)==0) {
			return false;
		}
		$this->db->insert('place',$data);
		if ($this->db->affected_rows()>0) {
			return $this->db->insert_id();
		}
		return false;
	}
    /**
 * 保存编辑的目的地信息，注意这里的$data数组的键名需跟数据表里面的字段名称相对应
 *
 * @param unknown_type $data
 * @return unknown
 */
    public function edit($data,$pid){
        if (!is_array($data)||count($data)==0) {
            return false;
        }
        $this->db->update('place', $data, array('pid' => $pid));
        if ($this->db->affected_rows()) {
                return true;
            }
        return false;
    }		 public function findparentid($parentname){        $this->db->select("place.pid");        $this->db->where("name",$parentname);        $r=$this->db->get("place");        $res=$r->result_array();        if(count($res)>0)			return $res;        else            return false;    }
	/**
	 * 检索整个目的地的树形结构，以多维数组的形式返回
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function place_tree($pid=0){
		$this->db->where('parent',$pid);
		$this->db->where('del',0);
		$this->db->order_by('weight','asc');
		$r=$this->db->get('place');
		$result=$r->result_array();
		$tree=array();
		if ($r->num_rows()>0) {
			foreach ($result as $k=>$v){
				$v['child']=$this->place_tree($v['pid']);
				$tree[]=$v;
			}
		}
		return $tree;
	}
    /**
     * 根据图片id检索相应的数据
     *
     * @param unknown_type $id
     */
    public function get_img($id){
        $r=$this->db->get_where('place_sport_images',array('psiid' => $id));
        if ($r->num_rows()==0) {
            return false;
        }
        return $r->row_array();
    }
    /**
     * 检索指定目的的下的图片
     *
     * @param unknown_type $pid
     * @return unknown
     */
    public  function img_list($pid){
        if(!$pid){
            return false;
        }
        $this->db->where('place_id',$pid);
        $this->db->from('place_sport_images');
        $this->db->order_by('weight','asc');
        $r = $this->db->get();
        if ($r->num_rows()==0) {
            return false;
        }
        return $r->result_array();
    }
    /**
     * 统计指定目的的下的图片
     *
     * @param unknown_type $pid
     * @return unknown
     */
    public  function img_total($pid){
        if(!$pid){
            return false;
        }
        $this->db->where('place_id',$pid);
        $this->db->from('place_sport_images as a');
        $this->db->join('sport as b','b.spid = a.sport_id','right');
        $this->db->where('b.del',0);
        $r = $this->db->get();
        return $r->num_rows();
    }
    /**
     * 检索指定目的的下的活动
     *
     * @param unknown_type $pid
     * @return unknown
     */
    public  function sport_list($pid){
        if(!$pid){
            return false;
        }
        $this->db->select('a.weight as paixu,a.sta,a.place_id,a.sport_id,a.sport_id,b.name');
        $this->db->where('place_id',$pid);
        $this->db->from('place_sport as a');
        $this->db->join('sport as b','b.spid = a.sport_id','right');
        $this->db->where('b.del',0);
        $this->db->order_by('a.weight','asc');
        $r = $this->db->get();

        if ($r->num_rows()==0) {
            return false;
        }
        return $r->result_array();
    }
    /**
     * 保存产地运动banner
     *
     * @param unknown_type $data
     * @return unknown
     */
    public function img_add($data){
        if (!is_array($data)||count($data)==0) {
            return false;
        }
        $this->db->insert('place_sport_images',$data);
        if ($this->db->affected_rows()>0) {
            return $this->db->insert_id();
        }
        return false;
    }
    /**
     * 保存编辑产地运动banner
     *
     * @param unknown_type $data
     * @return unknown
     */
    public function img_edit($data,$psiid){
        if (!is_array($data)||count($data)==0) {
            return false;
        }
        $this->db->update('place_sport_images', $data, array('psiid' => $psiid));
        if ($this->db->affected_rows()) {
            return true;
        }
        return false;
    }
    /**
     * 根据目的地id物理删除该目的banner图
     *
     * @param unknown_type $id
     * @return unknown
     */
    public function img_del($id){
        $this->db->delete('place_sport_images',array('psiid' => $id));
        if ($this->db->affected_rows()>0) {
            return true;
        }
        return false;
    }
    /**
     * 所有户外活动项目
     *
     * @return unknown
     */
    public function sports(){
    	$this->db->where('del',0)->where('sta',0);
    	$r=$this->db->get('sport');
    	if ($r->num_rows()==0) {
    		return false;
    	}
    	return $r->result_array();
    }
    /**
     * 根据场地id与活动id检索相应的数据
     *
     * @param unknown_type $pid
     * @param unknown_type $sid
     */
    public function place_sport($pid,$sid){
    	$this->db->where('place_id',$pid);
    	$this->db->where('sport_id',$sid);
    	$r=$this->db->get('place_sport');
    	if ($r->num_rows()==0) {
    		return false;
    	}
    	return $r->row_array();
    }
    /**
     * 场地下某项运动在进行编辑之后的保存
     *
     * @param unknown_type $pid：场地id
     * @param unknown_type $sid：运动id
     * @param unknown_type $data：场地运动表（place_sport）中的相关数据
     * @return unknown
     */
    public function sport_edit_save($pid,$sid,$data){
    	if (!is_array($data)||count($data)==0) {
    		return false;
    	}
    	$this->db->where('place_id',$pid);
    	$this->db->where('sport_id',$sid);
    	$this->db->update('place_sport',$data);
    	return true;
    }
    /**
     * 统计指定场地下的攻略
     *
     * @param unknown_type $pid
     * @return unknown
     */
    public  function guide_total($pid){
        if(!$pid){
            return false;
        }
        $this->db->where('place_id',$pid);
        $this->db->from('guide');
        $this->db->where(array('del'=>0,'sta'=>0,'sport_id'=>0));
        $r = $this->db->get();
        return $r->num_rows();
    }
    /**
     * 检索指定场地下的攻略
     *
     * @param unknown_type $pid
     * @return unknown
     */
    public  function guide_list($pid){
        if(!$pid){
            return false;
        }
        $this->db->from('guide');
        $this->db->where(array('del'=>0,'sta'=>0,'sport_id'=>0));
        $this->db->order_by('weight','asc');
        $r = $this->db->get();
        if ($r->num_rows()==0) {
            return false;
        }
        return $r->result_array();
    }
    /**
     * 保存场地攻略，注意这里的$data数组的键名需跟数据表里面的字段名称相对应
     *
     * @param unknown_type $data
     * @return unknown
     */
    public function guide_save($data){
        if (!is_array($data)||count($data)==0) {
            return false;
        }
        $this->db->insert('guide',$data);
        if ($this->db->affected_rows()>0) {
            return $this->db->insert_id();
        }
        return false;
    }
    /**
     * 根据图片场地id检索相应场地攻略数据
     *
     * @param unknown_type $id
     */
    public function get_guide($placeid){
        $r=$this->db->get_where('guide',array('sport_id'=>0,'place_id'=>$placeid));
        if ($r->num_rows()==0) {
            return false;
        }
        return $r->row_array();
    }

    /**
     * 保存编辑场地攻略
     *
     * @param unknown_type $data
     * @return unknown
     */
    public function guide_edit($data,$gid){
        if (!is_array($data)||count($data)==0) {
            return false;
        }
        $this->db->update('guide', $data, array('gid' => $gid));
        if ($this->db->affected_rows()) {
            return true;
        }
        return false;
    }
    /**
     * 根据目的地id物理删除该场地的攻略
     *
     * @param unknown_type $id
     * @return unknown
     */
    public function guide_del($gid){
        $this->db->update('guide',array('del'=>1),array('gid'=>$gid));
        if ($this->db->affected_rows()>0) {
            return true;
        }
        return false;
    }
	public function get_att_back($pid,$sid=null){
		$this->db->select("sport_attributes.attribute,sport_attr_value_backup.backup_value,sport_attributes.id as said");
				//$this->db->select("*");
		$this->db->from("sport_attr_value_backup");
		if($sid!=null){
			$this->db->where("backup_sport_id",$sid);
		}
		$this->db->where("sport_attr_value_backup.del",0);
		$this->db->where("backup_place_id",$pid);
		$this->db->join("sport_attributes","sport_attributes.id=sport_attr_value_backup.backup_attribute_id");
		$r=$this->db->get();
		  if ($r->num_rows()==0) {
            return false;
        }
		$res=$r->result_array();
		return $res;
	}
		public function use_back($pid,$sid){
		
		$arr=$this->get_att_back($pid);
		if($arr==false)
			return false;
		foreach($arr as $a){
			$this->db->update("sport_attr_value",array("value"=>$a["backup_value"]),array("place_id"=>$pid,"attribute_id"=>$a["said"]));
		}
		
		
		$this->db->update("sport_attr_value_backup",array('del'=>1),array("backup_place_id"=>$pid));
		return true;
		
	}
	
	
}