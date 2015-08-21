<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sports_model extends CI_Model {
	//添加运动数据 $tid 级别的tid $p_id:人员ID $l_id 清单ID $tag:标签数组
function add($table,$data,$tid,$p_id,$l_id,$tag){
     $exit=$this->db->where('name =',$data['name'])->or_where('name_en =',$data['name_en'])->or_where('img =',$data['img'])->get($table)->row_array();//表名和条件
     if($exit){
         return false;
     }else{
         $this->db->trans_start();
         $this->db->insert($table,$data);//添加统一数据
         $l_sid=$this->db->insert_id();//运动插入的最后的ID
         $t_data=array();
         $t_data['sport_id']=$l_sid;
         $t_data['term_id']=$tid;
         $t_data['taxonomy_id']=1;//等级

       $this->db->insert('sport_taxonomy',$t_data);//添加关系数据--级别
       $this->db->insert('sport_taxonomy',array('sport_id'=>$l_sid,'term_id'=>$p_id,'taxonomy_id'=>3));//添加关系数据--人员
       $this->db->insert('sport_taxonomy',array('sport_id'=>$l_sid,'term_id'=>$l_id,'taxonomy_id'=>2));//添加关系数据--清单
       //标签添加数据库
       if(is_array($tag)){
           $tag_arr=array();
         foreach($tag as $v){
             $tag_arr[]=array('sport_id'=>$l_sid,'term_id'=>$v,'taxonomy_id'=>4);
         }
           $this->db->insert_batch('sport_taxonomy',$tag_arr);
       }

         if ($this->db->trans_status()===true) {
             $this->db->trans_commit();
             return true;
         }
         else {
             $this->db->trans_rollback();
             return false;
         }

  }
 }
  //运动项目的总数
public function key_rows($table,$keyword,$l='c'){
    $this->db->from("$table");
    if($l=='c'){
        $this->db->like('name',"$keyword");
    }elseif($l=='e'){
        $this->db->like('name_en',"$keyword");
    }
        $this->db->where(array('del'=>0));//taxonomy_id
    $this->db->where(array('sport_taxonomy.taxonomy_id'=>1));
    $this->db->join('sport_taxonomy','sport_taxonomy.sport_id='.$table.'.spid','left');
    return  $this->db->count_all_results();

}
    //运动管理所有数据查询
public function sports_list($l='c',$keyword=null,$per_page,$offset){
        $this->db->select('*');
        $this->db->from('sport');
        if($l=='c'){
            $this->db->like('name',"$keyword");
        }else{
            $this->db->like('name_en',"$keyword");
        }
        $this->db->where(array('del'=>0));
    $this->db->where(array('sport_taxonomy.taxonomy_id'=>1));
        $this->db->join('sport_taxonomy','sport_taxonomy.sport_id=sport.spid','left');
        $this->db->order_by('weight', 'asc');
        $q =$this->db-> limit($per_page,$offset,0)->get();
        return $q->result_array();
    }
// 查询单条数据
public function get_one($table,$filed='*',$where=array()){
    $this->db->select($filed);
    $this->db->where($where);
    $q =$this->db->get($table);
    return $q->row_array();

}
 //更新保存数据 $filed 条件对应的字段
public function my_update($table,$filed,$id,$data){
   return $this->db->update($table, $data, array($filed=>$id));
}
//添加banner
    function banner_add($table,$data){
        $exit=$this->db->where('img =',$data['img'])->get($table)->row_array();//表名和条件
        if($exit){
            return false;
        }else{
            $res= $this->db->insert($table, $data);
            if($res){
                return true;
            }else{
                return false;
            }

        }
    }
/*简单删除
 * $Condition 删除的条件数组
 * */
    public function true_delete($table,$Condition=array()){
       return $this->db->delete($table, $Condition);
    }
 /*删除的更新状态
  ***/
 public function up_delete($table,$data,$Condition=array()){
   return  $this->db->update($table, $data, $Condition);

 }
    /*
    * 查询运动数据
    * */
  public function get_sports_info($id){
      $this->db->select('name,name_en,alias,img,description,weight,term_id,spid,taxonomy_id');
      $this->db->where('spid',$id);
      $this->db->order_by('taxonomy_id');
      $this->db->join('sport_taxonomy','sport_taxonomy.sport_id=spid','left');
      $r=$this->db->get('sport');
     return  $r->result_array();
  }
 /*更新运动
  *
  * */
 public function up_sports($id,$data,$tid,$lid,$pid,$tag,$attrs=null,$attrs_order=null,$attr_id=null){
     $this->db->trans_start();
     $this->db->update('sport', $data, array('spid'=>$id));
     $this->db->delete('sport_taxonomy', array('sport_id'=>$id));
     $this->db->insert('sport_taxonomy',array('sport_id'=>$id,'term_id'=>$tid,'taxonomy_id'=>1));//添加关系数据--级别
     $this->db->insert('sport_taxonomy',array('sport_id'=>$id,'term_id'=>$pid,'taxonomy_id'=>3));//添加关系数据--人员
     $this->db->insert('sport_taxonomy',array('sport_id'=>$id,'term_id'=>$lid,'taxonomy_id'=>2));//添加关系数据--清单
     //标签添加数据库
     if(is_array($tag)){
         $tag_arr=array();
         foreach($tag as $v){
             $tag_arr[]=array('sport_id'=>$id,'term_id'=>$v,'taxonomy_id'=>4);
         }
         $this->db->insert_batch('sport_taxonomy',$tag_arr);
     }
     //添加属性到数据库
     if($attrs!=null){
         $this->db->delete('sport_attributes', array('sport_id'=>$id));
         $count=0;
         foreach($attrs as $attr){
             if($attr_id[$count]==-1)
                $this->db->insert('sport_attributes',array("sport_id"=>$id,"attribute"=>$attr,"order"=>$attrs_order[$count++]));
             else{
                 $this->db->insert('sport_attributes',array("sport_id"=>$id,"attribute"=>$attr,"order"=>$attrs_order[$count],"id"=>$attr_id[$count]));
                 $count++;
             }
         }
     }
     if ($this->db->trans_status()===true) {
         $this->db->trans_commit();
         return true;
     }
     else {
         $this->db->trans_rollback();
         return false;
     }
 }

 /*********-----------------------------分类相关model----------------------------*************/
/*
 * 获取分类的树级数据
 * */
 public function get_tree(){
     $f_level=$this->db->get_where('taxonomy',array('del'=>0,'sta'=>0))->result_array();//一级分类的所有数据
     foreach($f_level as $key=>$f){
         $f_level[$key]['deep']=1;
         $f_level[$key]['tree']=$this->get_two_level($f['tid'],$t=1);
     }
    return $f_level;
 }
 public function get_two_level($tid,$t=1){
     if($t==1){
         $this->db->where('tid',$tid);
         $this->db->where('parent',0);
     }elseif($t==2){
         $this->db->where('taxonomy_term_hierarchy.parent',$tid);
         $this->db->where('parent !=',0);
         $this->db->where('typeid',0);
     }
    $this->db->where('del',0);
    $this->db->where('sta',0);
    $this->db->order_by('weight', 'asc');
    $this->db->join('taxonomy_term_hierarchy','taxonomy_term.ttid=taxonomy_term_hierarchy.ttid','left');
    $r=$this->db->get('taxonomy_term');
    $result=$r->result_array();
    $tree=array();
    if ($r->num_rows()>0) {
        foreach ($result as $k=>$v){
            $v['tree']=$this->get_two_level($v['ttid'],$t=2);
            $tree[]=$v;
        }
    }
    return $tree;
}
 /*
  * 子集添加操作
  * $term_data 第二子类
  * $term_hierarchy 关联数据
  * */
  public function add_level($term_data,$level,$pid){
      $this->db->trans_start();
      $this->db->insert('taxonomy_term', $term_data);
      $l_id=$this->db->insert_id();
      $data['ttid']=$l_id;
      if($level==1){
        $data['parent']=0;
      }else{
          $data['parent']=$pid;
      }
      $this->db->insert('taxonomy_term_hierarchy',$data);
      if ($this->db->trans_status()===true) {
          $this->db->trans_commit();
          return true;
      }
      else {
          $this->db->trans_rollback();
          return false;
      }

  }

 /*
  * 获取父级的名称
  * */
 public function get_parent_name($table,$id){
    return $this->db->select('name')->get_where($table,array('id'=>$id));//表名和条件

  }

/****************************攻略*****************************************/
/*
 * 通过运动id获取此运动等级的分类
 * */
public function get_category($sp_id){
    $this->db->select('taxonomy_term.ttid,taxonomy_term.name');
    $this->db->where('sport_id',$sp_id);
    $this->db->where('taxonomy_id',1);
    $this->db->join('taxonomy_term','taxonomy_term.tid=sport_taxonomy.term_id','left');
    $r=$this->db->get('sport_taxonomy');
   return $result=$r->result_array();
}

    /****************************人员清单*****************************************/
/*连表查询相应运动下的人员 和 清单的id
 * */
public  function get_sports_c($sp_id){
    $this->db->select('term_id,taxonomy_id');
    $this->db->where(array('del'=>0,'spid'=>$sp_id));
    $id = array('2', '3');
    $this->db->where_in('taxonomy_id', $id);
    $this->db->join('sport_taxonomy','sport_taxonomy.sport_id=sport.spid','left');
    $this->db->order_by('weight', 'desc');
    $q =$this->db->get('sport');
    return $q->result_array();

 }
/*
 * 人员清单批量添加
 * $sport_id 运动ID
 * **/
public  function insert_batch($table,$data,$sport_id){
     $res= $this->db->delete($table,array('sport_id'=>$sport_id));
    if($res){
        return $this->db->insert_batch($table, $data);
    }

}
 /*
  *根据运动id获取人员清单
  * */
public function  get_detail($sp_id){



 }
    /*
     * 两个连表查询 二维数组
     * */
public function connect_table($filed='*',$where=array(),$order='weight',$table,$join_table,$join_condition)
{
    if ($order!='none') {
        $this->db->select($filed);
        $this->db->where($where);
        $this->db->order_by($order, 'asc');
        $this->db->join($join_table, $join_condition, 'left');
        // $this->db->join('taxonomy_term','taxonomy_term_hierarchy.ttid=taxonomy_term.ttid','left');
        $r = $this->db->get($table);
        $res = $r->result_array();
        $new_arr = array();
        foreach ($res as $key => $v) {

            $new_arr[] = $this->get_one($table, $filed = 'ttid,name', $where = array('ttid' => $v['ttid']));


        }
        return $new_arr;
    }
    else{
            $this->db->select($filed);
            $this->db->where($where);
            $r = $this->db->get($table);
            $res=  $r->result_array();
            return $res;

    }
}

    public function getAttrsForSport($sport_id){
        $this->db->select("attribute,id");
        $this->db->where(array("sport_id"=>$sport_id));
        $r = $this->db->get("sport_attributes");
        $res=$r->result_array();
        return $res;
    }

    public function getAttrsValueForSport($pid,$sid){
        $this->db->select("attribute_id,id,value");
        $this->db->where(array("place_id"=>$pid));
        //$this->db->where(array("sport_id"=>$sid));
        $r = $this->db->get("sport_attr_value");
        $res_te=$r->result_array();
        $res=array();
        foreach( $res_te as $item){
            $res[$item["attribute_id"]]=$item["value"];
        }
        return $res;
    }

    public function sportAttrValueAdd($place_id,$arr){

        foreach($arr as $attr_id => $attr_value){
            $this->db->delete("sport_attr_value",array("place_id"=>$place_id,"attribute_id"=>$attr_id));
            $this->db->insert("sport_attr_value",array("place_id"=>$place_id,"value"=>$attr_value,"attribute_id"=>$attr_id));
        }
    }

}
