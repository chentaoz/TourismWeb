<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Guide_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 检索指定数目的攻略，并按照指定的条件进行排序
     *
     * @param unknown_type $sort ：排序条件
     * @return unknown：成功则返回相关数组，失败则返回false
     */
    public function get_guides($where = array(), $sort = array('weight', 'asc'), $offset = 0, $pagesize)
    {

        $this->db->where($where);
        if (!is_array($sort)) {
            $sort = array('weight', 'asc');
        }
        $this->db->order_by($sort[0], $sort[1]);
        $this->db->limit($pagesize, $offset);
        $r = $this->db->get('guide');
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }
    /**
     * 检索指定攻略的评论，并按照指定的条件进行排序
     *
     * @param unknown_type $sort ：排序条件
     * @return unknown：成功则返回相关数组，失败则返回false
     */
    public function get_comments($where = array(), $sort = array('created', 'desc'), $offset = 0, $pagesize)
    {

        $this->db->where($where);
        if (!is_array($sort)) {
            $sort = array('created', 'desc');
        }
        $this->db->order_by($sort[0], $sort[1]);
        $this->db->limit($pagesize, $offset);
        $r = $this->db->get('guide_comments');
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /**
     * 检索指定数目的的目的地攻略，并按照指定的条件进行排序
     *
     * @param unknown_type $pid ：目的地id
     * @param unknown_type $num ：数目
     * @param unknown_type $sort ：排序条件
     * @return unknown：成功则返回相关数组，失败则返回false
     */
    public function get_place_guides($pid, $num = 10, $sort = array('weight', 'asc'))
    {
        $this->db->where('place_id', $pid);
        $this->db->where('typeid', 0);
        $this->db->where('del', 0);
        $this->db->where('sta', 0);
        if (!is_array($sort)) {
            $sort = array('weight', 'asc');
        }
        $this->db->order_by($sort[0], $sort[1]);
        $this->db->limit($num);
        $r = $this->db->get('guide');
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /**
     * 检索指定数目的的运动攻略，并按照指定的条件进行排序
     *
     * @param unknown_type $sport_id ：运动id
     * @param unknown_type $num ：数目
     * @param unknown_type $level ：攻略级别
     * @param unknown_type $sort ：排序条件
     * @return unknown：成功则返回相关数组，失败则返回false
     */
    public function get_sport_guides($sport_id, $num = 10, $level = 0, $sort = array('weight', 'asc'))
    {
        $this->db->where('sport_id', $sport_id);
        $this->db->where('typeid', 1);
        $this->db->where('term_level_id', $level);
        $this->db->where('del', 0);
        $this->db->where('sta', 0);
        if (!is_array($sort)) {
            $sort = array('weight', 'asc');
        }
        $this->db->order_by($sort[0], $sort[1]);
        $this->db->limit($num);
        $r = $this->db->get('guide');
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /**
     * 检索指定数目的的目的地运动攻略，并按照指定的条件进行排序
     *
     * @param unknown_type $pid ：目的地id
     * @param unknown_type $sport_id ：运动id
     * @param unknown_type $num ：数目
     * @param unknown_type $level ：攻略级别
     * @param unknown_type $sort ：排序条件
     * @return unknown：成功则返回相关数组，失败则返回false
     */
    public function get_place_sport_guides($pid, $sport_id, $num = 10, $level = 0, $sort = array('weight', 'asc'))
    {
        $this->db->where('place_id', $pid);
        $this->db->where('sport_id', $sport_id);
        $this->db->where('typeid', 1);
        $this->db->where('term_level_id', $level);
        $this->db->where('del', 0);
        $this->db->where('sta', 0);
        if (!is_array($sort)) {
            $sort = array('weight', 'asc');
        }
        $this->db->order_by($sort[0], $sort[1]);
        $this->db->limit($num);
        $r = $this->db->get('guide');
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }
    /**
     * 检索指定数目的用户下载攻略，并按下载时间倒序
     *
     * @param unknown_type $num ：数目
     * @return unknown：成功则返回相关数组，失败则返回false
     */
    public function get_user_guides( $num = 10)
    {
        $this->db->from('guide_download as a');
        $this->db->join('members as b','a.uid = b.uid','left');
        $this->db->where('b.status',0);
        $this->db->join('guide as c','a.gid = c.gid','left');
        $this->db->group_by("a.gid");
        $this->db->order_by('a.created','desc');
        $this->db->limit($num);
        $r = $this->db->get();
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }
    /**
     * 检索指定关键词的攻略
     *
     * @param unknown_type $key
     * @return unknown
     */
    public function get_guidebykey($key){
        $eKey = $this->db->escape_like_str($key);
        $sql = "select gid,title from (".$this->db->dbprefix."guide) where del = 0 and sta=0 and title LIKE '%$eKey%'";
        $r=$this->db->query($sql);
        if ($r->num_rows()==0) {
            return false;
        }
        return $r->result_array();
    }
}