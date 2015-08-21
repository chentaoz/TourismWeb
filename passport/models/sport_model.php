<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sport_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 获取运动分类
     * */
    public function get_data($table, $filed = '*', $where = array(), $limit = '')
    {
        $this->db->select($filed);
        $this->db->where($where);
        $this->db->order_by('weight', 'asc');
        if ($limit) {
            $this->db->limit($limit);
        }
        $q = $this->db->get($table);
        return $q->result_array();
    }

    /*
     * 两个连表查询 二维数组
     * */
    public function connect_table($filed = '*', $where = array(), $order = 'weight', $table, $join_table, $join_condition)
    {
        $this->db->select($filed);
        $this->db->where($where);
        $this->db->order_by($order, 'asc');
        $this->db->join($join_table, $join_condition, 'left');
        $r = $this->db->get($table);
        return $r->result_array();
    }

    /*
     * 获取收藏的运动
     * */
    public function get_save_sport($uid)
    {
        $this->db->select('name,name_en,sport_id,planto,beento');
        $this->db->where(array('uid'=>$uid));
        $this->db->order_by('weight', 'asc');
        $this->db->join('sport', 'sport_id=spid', 'left');
        $r = $this->db->get('sport_play');
        return $r->result_array();
    }

    /*
     * 运动的搜索
     * */
    public function get_placebykey($key)
    {
        $eKey = $this->db->escape_like_str($key);
        $sql = "select * from (xcenter_sport) where del = 0 and sta=0  AND (name LIKE '%$eKey%' or name_en LIKE '$eKey%')";
        $r = $this->db->query($sql);
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    //随机数据
    public function rand_data($table, $file, $where, $order, $limit)
    {
        return $this->db->select("$file")->where($where)->order_by($order)->limit($limit)->get($table)->result_array();

    }

    //获取个数
    public function count_data($table, $where)
    {
        $this->db->where($where);
        $this->db->from($table);
        return $this->db->count_all_results();


    }

    //连表获取数量
    public function c_table_count_data($table1, $table2, $condition, $where)
    {
        $this->db->where($where);
        $this->db->from($table1);
        $this->db->join($table2, $condition, 'left');
        return $this->db->count_all_results();


    }

    //批量添加数据

    public function batch($table, $data)
    {
        $res = $this->db->insert_batch($table, $data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //sql执行
    public function sql_query($sql)
    {
        $q = $this->db->query($sql);
        return $q->result_array();
    }

//更新数据

    public function my_update($table, $data, $where = array())
    {
        return $this->db->update($table, $data, $where);
    }

    /*足迹城市下面场点分页数据
     * */
    public function get_pagedata($table, $filed = '*', $where = array(), $offset, $pagesize, $order = 'weight', $style = 'asc')
    {
        $this->db->select($filed);
        $this->db->where($where);
        $this->db->limit($pagesize, $offset);
        $this->db->order_by($order, $style);
        $q = $this->db->get($table);
        return $q->result_array();
    }

    /*
     * 删除操作
     * */
    public function my_delete($table, $where = array())
    {
        return $this->db->delete($table, $where);
    }

    /*
 * james 新运动的搜索
 * */
    public function get_sport()
    {
        $sql = "select concat(name,'-',name_en)as title,spid as result from (xcenter_sport) where del = 0 and sta=0";
        $r = $this->db->query($sql);
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /*
     * 添加创建背包数据
     * */
    public function create_bag($main_data, $uid, $place_id, $sport_id, $system_suit, $user_define, $style = 'insert')
    {
        $this->db->trans_start();
        //添加主表数据
        if ($style == 'insert') {
            $this->db->insert('bag', $main_data);
            $bid = $this->db->insert_id();
        } elseif ($style == 'update') {
            $update_arr = array('title' => $main_data['title'], 'remark' => $main_data['remark']);
            $this->db->update('bag', $update_arr, array('uid' => $uid, 'id' => $main_data['id']));
            $bid = $main_data['id'];
        }


        //添加背包场点
        $place_data = array('bagid' => $bid, 'uid' => $uid, 'placeid' => $place_id);
        $this->db->insert('bag_place', $place_data);
        //添加背包运动
        $place_data = array('bagid' => $bid, 'uid' => $uid, 'sportid' => $sport_id);
        $this->db->insert('bag_sport', $place_data);
        //添加系统装备
        foreach ($system_suit as $v) {
            //查询有没有添加过
            $this->db->where(array('bagid' => $bid, 'term_list_id' => $v));
            $this->db->from('bag_list');
            $exit = $this->db->count_all_results();
            if ($exit == 0) {
                $place_data = array('bagid' => $bid, 'term_list_id' => $v);
                $this->db->insert('bag_list', $place_data);
            }

        }
        //添加用户自定义装备 1.查询有无重复
        if (!empty($user_define)) {
            foreach ($user_define as $v) {
                if (!empty($v)) {
                    //1.查询是否有这样的装备
                    $res = $this->db->select('ttid')->get_where('taxonomy_term', array('name' => trim($v), 'tid' => 2, 'category !=' => 1))->row_array(); //一维数组
                    if ($res) {
                        $ttid = $res['ttid'];
                    } else { //没有添加返回最后ID
                        $data = array('tid' => 2, 'name' => $v, 'typeid' => 1);
                        $this->db->insert('taxonomy_term', $data);
                        $ttid = $this->db->insert_id(); //返回插入的ID

                    }
                    $place_data = array('bagid' => $bid, 'term_list_id' => $ttid);
                    $this->db->insert('bag_list', $place_data);
                }
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;

        } else {
            $this->db->trans_rollback();
            return false;
        }


    }

    /*
 * 背包两个连表查询 一维数组
 * */
    public function connect_row($filed = '*', $where = array(), $table, $join_table, $join_condition)
    {
        $this->db->select($filed);
        $this->db->where($where);
        $this->db->join($join_table, $join_condition, 'left');
        $r = $this->db->get($table);
        return $r->row_array();
    }
    /**
     * 统计指定运动有多少人去过跟想去-by jyy，
     *
     * @param unknown_type $spid
     * @param unknown_type $flag ：1-想去，2-去过
     * @return unknown
     */
    public function been__want_total($spid, $flag = 1)
    {
        $this->db->select('placeid');
        $this->db->where('sport_id', $spid);
        switch ($flag) {
            case 1: //想去
                $this->db->where('planto', 1);
                break;
            case 2: //去过
                $this->db->where('beento', 1);
                break;
            default: //默认为想去
                $this->db->where('planto', 1);
                break;
        }
        $this->db->from('sport_play');
        $total = $this->db->count_all_results();
        return $total;
    }

    /**
     * 检索指定运动下想去会员-by jyy
     * @param unknown_type $planto ,0-想去  1-已想去
     * @param unknown_type $spid
     */
    public function  get_sport_planto($spid, $planto, $num = 1)
    {
        $this->db->from('sport_play as a');
        $this->db->where('a.sport_id', $spid);
        $this->db->where('a.planto', $planto);
        $this->db->join('members as b', 'a.uid=b.uid', 'right');
        $this->db->where('b.status', 0);
        $this->db->limit($num);
        $r = $this->db->get();
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /**
     * 检索指定运动下去过会员-by jyy
     * @param unknown_type $beento ,0-去过  1-已去过
     * @param unknown_type $spid
     */
    public function  get_sport_beento($spid, $beento, $num = 1)
    {
        $this->db->from('sport_play as a');
        $this->db->where('a.sport_id', $spid);
        $this->db->where('a.beento', $beento);
        $this->db->join('members as b', 'a.uid=b.uid', 'right');
        $this->db->where('b.status', 0);
        $this->db->limit($num);
        $r = $this->db->get();
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    //想去未有记录-by jyy
    public function sport_want($uid, $spid, $plan)
    {
        if (intval($uid) && intval($spid)) {
            $data = array('uid' => $uid, 'sport_id' => $spid, 'planto' => $plan, 'created' => time());
            return $this->db->insert('sport_play', $data);
        } else {
            return false;
        }
    }

    //想去已有记录更新-by jyy
    public function sport_want_update($uid, $spid, $plan)
    {
        if (intval($uid) && intval($spid)) {
            $this->db->where(array('sport_id' => $spid, 'uid' => $uid));
            return $this->db->update('sport_play', array('planto' => $plan));
        } else {
            return false;
        }
    }

    //去过未有记录-by jyy
    public function sport_been($uid, $spid, $been)
    {
        if (intval($uid) && intval($spid)) {
            $data = array('uid' => $uid, 'sport_id' => $spid, 'beento' => $been, 'created' => time());
            return $this->db->insert('sport_play', $data);
        } else {
            return false;
        }
    }

    //去过已有记录更新-by jyy
    public function sport_been_update($uid, $spid, $been)
    {
        if (intval($uid) && intval($spid)) {
            $this->db->where(array('sport_id' => $spid, 'uid' => $uid));
            return $this->db->update('sport_play', array('beento' => $been));
        } else {
            return false;
        }
    }

    //检索有该运动的目的地-by jyy
    public function  place_recomm($spid, $num = 5)
    {
        $this->db->from('place_sport as a');
        $this->db->where('a.sport_id', $spid);
        $this->db->join('place as b', 'a.place_id = b.pid');
        $this->db->limit($num);
        $s = $this->db->get();
        if ($s->num_rows() == 0) {
            return false;
        }
        return $s->result_array();
    }

    //目前最热门的兴趣-by jyy
    public function hot_sport($num=5)
    {
        $sql = 'SELECT b.name,b.img,b.spid,a.num FROM
(SELECT * ,COUNT(uid) as num FROM xcenter_sport_play WHERE planto = 1 GROUP BY sport_id ORDER BY num desc) as a
JOIN xcenter_sport as b ON a.sport_id = b.spid limit '.$num;
        $s=$this->db->query($sql);
        if ($s->num_rows() == 0) {
            return false;
        }
        return $s->result_array();
    }

    //留言递归数据部分
    public function my_comment($uid,$pid=0){

      $res=$this->db->select('id,uid,body,created')->order_by('created', 'desc')->get_where('comments', array('del'=>0,'sta'=>0,'parentid'=>$pid))->result_array();
      if($res){
          foreach ($res as $k=>$v){
              $v['tree']=$this->my_comment($v['uid'],$v['id']);
              $tree[]=$v;
          }


      return $tree;

      }



   }
   //连表获取数据分页数据
    public function contact_get_pagedata($table,$table2,$filed = '*', $where = array(), $offset, $pagesize, $order = 'weight', $style = 'asc',$condation){

        $this->db->select($filed);
        $this->db->where($where);
        $this->db->join($table2, $condation);
        $this->db->limit($pagesize, $offset);
        $this->db->order_by($order, $style);
        $q = $this->db->get($table);
        return $q->result_array();

    }
   //获取分组查询数据
    public function group_by_data($file='*',$table,$where,$group_by){
       return $this->db->select($file)->where($where)->group_by($group_by)->get($table)->result_array();


    }

}