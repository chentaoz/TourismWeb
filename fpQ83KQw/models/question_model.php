<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function question_add($arr){
		if (!is_array($arr)) {
			return false;
		}
		$r=$this->db->insert('question',$arr);
		if ($this->db->affected_rows()>0) {
			return $this->db->insert_id();
		}
		return false;
	}

    public function question_edit($id,$arr){
        $where=array('id'=>$id);
        if(!empty($arr)){
            $this->db->where($where);
            $this->db->update('question', $arr);
        }
        return true;
    }

    public function question_set($id,$field,$field_value){
        $where=array('id'=>$id);
        $this->db->set($field,$field_value,FALSE);
        $this->db->where($where);
        $this->db->update('question');
        return true;
    }

    /**
     * @param $objectid
     * @param $uid
     * @param $table  liked | favorites | follow | recommend
     * @return bool
     */
    public function question_action($objectid,$uid,$action){
        $actions=array('liked','favorites','follow','recommend');
        if(!in_array($action,$actions)){
            return true;
        }
        $sql="select * from ".$this->db->dbprefix."question_".$action." where object_id=".$objectid." and uid=".$uid.";";
        $num = $this->db->query($sql)->num_rows();
        if($num>0){
            return true;
        }

        $sql="insert into ".$this->db->dbprefix."question_".$action." values(".$objectid.",".$uid.",".time().");";
        $this->db->query($sql);

        $sql="update ".$this->db->dbprefix."question set ".$action."=".$action."+1 where id=".$objectid.";";
        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    /**
     * @param $objectid
     * @param $uid
     * @param $table  liked | favorites | follow | recommend
     * @return bool
     */
    public function question_unaction($objectid,$uid,$action){
        $actions=array('liked','favorites','follow','recommend');
        if(!in_array($action,$actions)){
            return true;
        }

        $sql="delete from ".$this->db->dbprefix."question_".$action." where object_id=".$objectid." and uid=".$uid.";";
        $this->db->query($sql);

        $sql="update ".$this->db->dbprefix."question set ".$action."=".$action."-1 where id=".$objectid.";";
        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    public function get_questions_count($where){
        if($where){
            $this->db->where($where);
        }
        $this->db->from('question');
        return $this->db->count_all_results();
    }

	public function get_questions_list($currentpage,$pagesize,$where,$orderby=''){
		$this->db->select("q.*,m.username");
        if($where){
            $this->db->where($where);
        }
        if($orderby!=''){
            $this->db->order_by($orderby);
        }
        $this->db->from('question as q');
        $this->db->join('members as m', 'm.uid=q.uid','left');
        $this->db->limit($pagesize,($currentpage-1)*$pagesize);
        $query = $this->db->get();
		$rs=$query->result_array();
		return $rs;
	}

    public function get_question_follow_count($where){
        if($where){
            $this->db->where($where);
        }
        $this->db->from('question_follow');
        return $this->db->count_all_results();
    }

    public function get_question_follow_list($currentpage,$pagesize,$where,$orderby=''){
        $this->db->select("q.object_id,q.created,q.uid,m.username");
        if($where){
            $this->db->where($where);
        }
        if($orderby!=''){
            $this->db->order_by($orderby);
        }
        $this->db->from('question_follow as q');
        $this->db->join('members as m', 'm.uid=q.uid','left');
        $this->db->limit($pagesize,($currentpage-1)*$pagesize);
        $query = $this->db->get();
        $rs=$query->result_array();
        return $rs;
    }

    public function question_followed($objectid,$uid){
        $sql="select * from ".$this->db->dbprefix."question_follow where object_id=".$objectid." and uid=".$uid.";";
        $num = $this->db->query($sql)->num_rows();
        if($num>0){
            return true;
        }
        return false;
    }


    /************************************************************/
    public function answer_add($arr){
        if (!is_array($arr)) {
            return false;
        }
        $r=$this->db->insert('answer',$arr);
        if ($this->db->affected_rows()>0) {
            return $this->db->insert_id();
        }
        return false;
    }
    public function get_answer_count($where){
        if($where){
            $this->db->where($where);
        }
        $this->db->from('answer');
        return $this->db->count_all_results();
    }

    public function get_answer_list($currentpage,$pagesize,$where,$orderby=''){
        $query=$this->db->select("a.*,m.username");
        if($where){
            $this->db->where($where);
        }
        if($orderby!=''){
            $this->db->order_by($orderby);
        }
        $this->db->from('answer as a');
        $this->db->join('members as m', 'm.uid=a.uid','left');
        $this->db->limit($pagesize,($currentpage-1)*$pagesize);
        $query = $this->db->get();
        $rs=$query->result_array();
        return $rs;
    }

    public function answer_maxcount($limit=5,$question_id=0){

        $sql="select group_concat(uid) uid from (select uid from ".$this->db->dbprefix."answer group by uid order by count(id) desc limit ".$limit.") t;";
        if($question_id>0){
            $sql="select group_concat(uid) uid from (select uid from ".$this->db->dbprefix."answer where question_id=".$question_id." group by uid order by count(id) desc limit ".$limit.") t;";
        }
        $query = $this->db->query($sql);
        $row=$query->row_array();;
        return $row['uid'];
    }

    /**
     * @param $objectid
     * @param $uid
     * @param $table  liked | favorites | follow | recommend
     * @return bool
     */
    public function answer_action($objectid,$uid,$action){
        $actions=array('liked','favorites','follow','recommend');
        if(!in_array($action,$actions)){
            return true;
        }
        $sql="select * from ".$this->db->dbprefix."answer_".$action." where object_id=".$objectid." and uid=".$uid.";";
        $num = $this->db->query($sql)->num_rows();
        if($num>0){
            return true;
        }

        $sql="insert into ".$this->db->dbprefix."answer_".$action." values(".$objectid.",".$uid.",".time().");";
        $this->db->query($sql);

        $sql="update ".$this->db->dbprefix."answer set ".$action."=".$action."+1 where id=".$objectid.";";
        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    /**
     * @param $objectid
     * @param $uid
     * @param $table  liked | favorites | follow | recommend
     * @return bool
     */
    public function answer_unaction($objectid,$uid,$action){
        $actions=array('liked','favorites','follow','recommend');
        if(!in_array($action,$actions)){
            return true;
        }

        $sql="delete from ".$this->db->dbprefix."answer_".$action." where object_id=".$objectid." and uid=".$uid.";";
        $this->db->query($sql);

        $sql="update ".$this->db->dbprefix."answer set ".$action."=".$action."-1 where id=".$objectid.";";
        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    public function get_answer_liked_count($where){
        if($where){
            $this->db->where($where);
        }
        $this->db->from('answer_liked');
        return $this->db->count_all_results();
    }


    /*------------------------------------------------------------------------------------------------------------*/
    public function answer_reply_add($arr)
    {
        if (!is_array($arr)) {

            return false;


        }
        $r = $this->db->insert('answer_reply', $arr);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }




public function get_answer_reply_list($where,$orderby=''){
        $query = $this->db->select("answer_reply.*,m.username");
if ($where) {
    $this->db->where($where);
}
if ($orderby != '') {
    $this->db->order_by($orderby);
}
$this->db->from('xcenter_answer_reply');
$this->db->join('members as m', 'm.uid=answer_reply.uid', 'left');
$query = $this->db->get();
$rs = $query->result_array();
return $rs;




}
    public function answer_set($id,$field,$field_value){
        $where=array('id'=>$id);
        $this->db->set($field,$field_value,FALSE);
        $this->db->where($where);
        $this->db->update('answer');
        return true;


    }

    public function get_answer_reply_liked_count($where){
        if($where){
            $this->db->where($where);
        }
        $this->db->from('answer_reply_liked');
        return $this->db->count_all_results();
    }

    public function answer_reply_action($objectid,$uid,$action){
        $actions=array('liked','favorites','follow','recommend');
        if(!in_array($action,$actions)){
            return true;
        }
        $sql="select * from ".$this->db->dbprefix."answer_reply_".$action." where object_id=".$objectid." and uid=".$uid.";";
        $num = $this->db->query($sql)->num_rows();
        if($num>0){
            return true;
        }

        $sql="insert into ".$this->db->dbprefix."answer_reply_".$action." values(".$objectid.",".$uid.",".time().");";
        $this->db->query($sql);

        $sql="update ".$this->db->dbprefix."answer_reply set ".$action."=".$action."+1 where id=".$objectid.";";
        $this->db->query($sql);

        return $this->db->affected_rows();
    }
    public function answer_reply_unaction($objectid,$uid,$action){
        $actions=array('liked','favorites','follow','recommend');
        if(!in_array($action,$actions)){
            return true;
        }

        $sql="delete from ".$this->db->dbprefix."answer_reply_".$action." where object_id=".$objectid." and uid=".$uid.";";
        $this->db->query($sql);

        $sql="update ".$this->db->dbprefix."answer_reply set ".$action."=".$action."-1 where id=".$objectid.";";
        $this->db->query($sql);

        return $this->db->affected_rows();
    }





    public function answer_reply_reply_add($arr)
    {
        if (!is_array($arr)) {

            return false;


        }
        $r = $this->db->insert('answer_reply_reply', $arr);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }
    public function answer_reply_set($id,$field,$field_value){
        $where=array('id'=>$id);
        $this->db->set($field,$field_value,FALSE);
        $this->db->where($where);
        $this->db->update('answer_reply');
        return true;


    }



    public function get_answer_reply_reply_list($where,$orderby=''){
        $query = $this->db->select("answer_reply_reply.*,m.username");
        if ($where) {
            $this->db->where($where);
        }
        if ($orderby != '') {
            $this->db->order_by($orderby);
        }
        $this->db->from('xcenter_answer_reply_reply');
        $this->db->join('members as m', 'm.uid=answer_reply_reply.uid', 'left');
        $query = $this->db->get();
        $rs = $query->result_array();
        return $rs;




    }
    public function delete($table,$id){

        if($table=="answer"){
            $query = $this->db->query("SELECT question_id FROM xcenter_answer where id=$id LIMIT 1");
            $row=$query->row();
            $this->db->set("comments","comments-1",FALSE);
            $this->db->where("id","$row->question_id");
            $this->db->update('question');


        }
        if($table=="answer_reply"){
            $query = $this->db->query("SELECT answer_id FROM xcenter_answer_reply where id=$id LIMIT 1");
         $row=$query->row();

            $this->db->set("comments","comments-1",FALSE);

            $this->db->where("id","$row->answer_id");
            $this->db->update('answer');


        }
        if($table=="answer_reply_reply"){
            $query = $this->db->query("SELECT reply_id FROM xcenter_answer_reply_reply where id=$id LIMIT 1");
            $row=$query->row();

            $this->db->set("comments","comments-1",FALSE);

            $this->db->where("id","$row->reply_id");
            $this->db->update('answer_reply');


        }
		if($table=="question"){
			$this->db->set("deleted",1,false);
			$this->db->set("deleted_at","NOW()",false);
			$this->db->where("id",$id);
			$this->db->update($table);
		}
		else{
			$this->db->where("id",$id);
			$this->db->delete($table);
		}
		
        return true;


    }
    /*----------------------------------------------------------------------------------------------------*/

public function modify($table,$id,$content){



    $this->db->set("body",$content,TRUE);

    $this->db->where("id",$id);
    $this->db->update($table);
    if($table=="answer"){
    $this->db->set("updated",time(),TRUE);}
    else $this->db->set("updated_at",time(),TRUE);
    $this->db->where("id",$id);
    $this->db->update($table);



}
public function questionModify($id,$title,$content){
    $this->db->set("body",$content);
    $this->db->where("id",$id);
    $this->db->update("question");

    $this->db->set("title",$title,TRUE);

   $this->db->where("id",$id);
   $this->db->update("question");
    $this->db->set("updated",time(),TRUE);
    $this->db->where("id",$id);
    $this->db->update("question");
    return $id;


}
 public function get_questionbykey($key)
    {
        $eKey = $this->db->escape_like_str($key);
        $sql = "select * from " . $this->db->dbprefix . "question where deleted = 0  AND (title LIKE '%$eKey%' or body LIKE '$eKey%')";
        $r = $this->db->query($sql);
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }









}



