<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
    /*
    * 当前目的地或运动相关文章
    * @param unknown_type $pid $top $num $flag
    */
    public function get_article($pid,$top=2,$num=1,$flag=1){
        $this->db->select('b.title,b.id,b.img');
        $this->db->from('article_tag as a');
        $this->db->where('a.tag_id',$pid);
        $this->db->where('a.flag',$flag);
        $this->db->join('article as b','a.article_id = b.id','left');
        $this->db->where('b.is_top',$top);
        $this->db->limit($num);
        $s=$this->db->get();
        if ($s->num_rows() == 0) {
            return false;
        }
        return $s->result_array();
    }
    /**
     * 检索某个目的地或运动相关文章所有数据
     *
     * @param unknown_type $pid
     * @param unknown_type int $offset:偏移量
     * * @param unknown_type int $pagesize:显示数目
     * @return unknown
     */
    public function get_all_article($pid,$flag=1,$offset=0,$pagesize=''){
        $this->db->select('b.title,b.id,b.author,b.created,b.abstract,b.hit,b.img');
        $this->db->from('article_tag as a');
        $this->db->where('a.tag_id',$pid);
        $this->db->where('a.flag',$flag);
        $this->db->join('article as b','a.article_id = b.id','left');
        $this->db->limit($pagesize,$offset,0);
        $s=$this->db->get();
        if ($s->num_rows() == 0) {
            return false;
        }
        return $s->result_array();
    }
    /**
     * 统计某个目的地或运动相关文章所有数据
     *
     */
    public function total_all_article($pid,$flag=1){
        $this->db->select('b.title,b.id,b.img');
        $this->db->from('article_tag as a');
        $this->db->where('a.tag_id',$pid);
        $this->db->where('a.flag',$flag);
        $this->db->join('article as b','a.article_id = b.id','left');
        $s=$this->db->get();
        return $s->num_rows();
    }
}