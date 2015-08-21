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
     * 置顶信息
     * $classic 二级分类id
     * */
    public function get_top($classic)
    {
        $this->db->select(array('id', 'title', 'abstract', 'img'));
        $this->db->where('classic', $classic);
        $this->db->where('is_top', 1);
        $this->db->order_by('update', 'desc');
        $this->db->limit(1);
        $q = $this->db->get('article');
        if ($q->num_rows() == 0) {
            return false;
        }
        return $q->row_array();
    }

    /*
     * 焦点信息
     * $classic 二级分类id $limit 调用条数
     * */
    public function get_focus($classic, $limit = 1)
    {
        $this->db->select(array('article.id', 'title', 'abstract', 'img', 'name'));
        $this->db->join('article_sclass', 'classic=article_sclass.id');
        $this->db->where('classic', $classic);
        $this->db->where('is_focus', 1);

        $this->db->order_by('update', 'desc');
        $this->db->limit($limit);
        $q = $this->db->get('article');
        if ($q->num_rows() == 0) {
            return false;
        }
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
        //$sql="SELECT * FROM " . $this->db->dbprefix . "sport_play WHERE uid={$uid} and (planto > 0 OR beento > 0)";
        $sql = "SELECT * FROM " . $this->db->dbprefix . "sport as a RIGHT JOIN
(SELECT sport_id,planto,beento FROM " . $this->db->dbprefix . "sport_play WHERE `uid` = {$uid} and (`planto` > 0 OR `beento` > 0)) as b
ON a.spid = b.sport_id
ORDER BY a.weight asc";
        $r = $this->db->query($sql);
        return $r->result_array();
    }

    /*
     * 运动的搜索
     * */
    public function get_placebykey($key)
    {
        $eKey = $this->db->escape_like_str($key);
        $sql = "select * from " . $this->db->dbprefix . "sport where del = 0 and sta=0  AND (name LIKE '%$eKey%' or name_en LIKE '$eKey%' or alias LIKE '%$eKey%')";
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
    public function  place_recomm($spid, $num = 3)
    {
        $this->db->from('place_sport as a');
        $this->db->where('a.sport_id', $spid);
        $this->db->where('a.sta', 0);
        $this->db->join('place as b', 'a.place_id = b.pid');
        $this->db->limit($num);
        $s = $this->db->get();
        if ($s->num_rows() == 0) {
            return false;
        }
        return $s->result_array();
    }

    //目前最热门的兴趣-by jyy
    public function hot_sport($num = 5)
    {
        $sql = "SELECT b.name,b.img,b.spid,a.num FROM
(SELECT * ,COUNT(uid) as num FROM " . $this->db->dbprefix . "sport_play WHERE planto = 1 GROUP BY sport_id ORDER BY num desc) as a
JOIN " . $this->db->dbprefix . "sport as b ON a.sport_id = b.spid limit " . $num;
        $s = $this->db->query($sql);
        if ($s->num_rows() == 0) {
            return false;
        }
        return $s->result_array();
    }

    //留言递归数据部分
    public function my_comment($uid, $pid = 0)
    {

        $res = $this->db->select('id,uid,body,created')->order_by('created', 'desc')->get_where('comments', array('del' => 0, 'sta' => 0, 'parentid' => $pid))->result_array();
        if ($res) {
            foreach ($res as $k => $v) {
                $v['tree'] = $this->my_comment($v['uid'], $v['id']);
                $tree[] = $v;
            }


            return $tree;

        }


    }

    //连表获取数据分页数据
    public function contact_get_pagedata($table, $table2, $filed = '*', $where = array(), $offset, $pagesize, $order = 'weight', $style = 'asc', $condation)
    {

        $this->db->select($filed);
        $this->db->where($where);
        $this->db->join($table2, $condation);
        $this->db->limit($pagesize, $offset);
        $this->db->order_by($order, $style);
        $q = $this->db->get($table);
        return $q->result_array();

    }

    //获取分组查询数据
    public function group_by_data($file = '*', $table, $where, $group_by)
    {
        return $this->db->select($file)->where($where)->group_by($group_by)->get($table)->result_array();


    }

    //获取评分平均值
    public function get_avg($table, $file, $where)
    {

        $this->db->select_avg($file, 'avg');
        $this->db->where($where);
        $q = $this->db->get($table);
        $avg = $q->row_array();
        return $avg['avg'];
    }

    //连表查询用户的信息
    public function get_user_info($uid)
    {
        $this->db->select('members.uid,username,email,gender,birthyear,birthmonth,birthday,constellation,address');
        $this->db->where(array('members.uid' => $uid));
        $this->db->join('members_profile', 'members.uid=members_profile.uid', 'left');
        $r = $this->db->get('members');
        return $r->row_array();
    }

    //更新用户信息
    public function update_user_info($uid, $main_data = array(), $pro_data = array())
    {
        $where = array('uid' => $uid);
        $this->db->trans_start();
        if (!empty($main_data)) {
            $this->db->where($where);
            $this->db->update('members', $main_data);
        }
        $this->db->where($where);
        $this->db->update('members_profile', $pro_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;

        } else {
            $this->db->trans_rollback();
            return false;
        }

    }

    /*james 统计景点的个数
     *  style 1:返回数字 2：返回数组
     * */
    public function get_view_num($uid, $style = 1)
    {

        $views_info = $this->db->where(array('uid' => $uid, 'beento' => 1, 'city >' => 0, 'city !=' => 'placeid'), NULL, FALSE)->get('place_visit')->result_array();//表名和条件
//      foreach($views_info as $key=>$v){
//           //查询下一级别是否存在来判断是否是最后的目的地
//         $exit= $this->db->get_where('place',array('parent'=>$v['placeid'],'del'=>0,'sta'=>0))->num_rows();
//          if($exit){
//            unset($views_info[$key]);
//          }
//
//      }
        if ($style == 1) {
            return count($views_info);
        } elseif ($style == 2) {
            return $views_info;
        }

    }

    /*
    * 去过的国家个数 james
     * $style 1:国家的个数 2.城市的统计
    * */
    public function get_statistics($uid, $style = 1)
    {
        if ($style == 1) {
            $group = 'country';
            $s = $this->db->query("select count(*) as num from (select count(*) from " . $this->db->dbprefix . "place_visit where uid={$uid} and beento=1  GROUP BY $group) as a");

        } elseif ($style == 2) {
            $group = 'city';
            $s = $this->db->query("select count(*) as num from (select count(*) from " . $this->db->dbprefix . "place_visit where uid={$uid} and beento=1 and city>0  GROUP BY $group) as a");

        }
        $num = $s->row_array();
        return $num['num'];
    }


    /*第四次修改 james*/
    /*通过地点的ID判断此用户去过没有
     *$uid 用户id
     * $city_id 城市ID
     * $cid 国家 ID
     * */
    public function place_gone($uid, $city_id, $cid)
    {
        //判断是否还有子节点
        if ($this->exit_four_level($city_id)) { //判断第四个级别
            return 3;//有子集

        } else {
            // return $this->exit_four_level($city_id);
            $this->db->where(array('uid' => $uid, 'country' => $cid, 'city' => $city_id, 'beento' => 1));
            $visit = $this->db->get('place_visit');
            if ($visit->num_rows()) {//去过
                return 1;
            }
        }
    }

    /*是否存在第四级别*/
    public function exit_four_level($city_id)
    {
        $this->db->select('pid');
        $this->db->where(array('parent' => $city_id, 'del' => 0, 'sta' => 0));
        $q = $this->db->get('place');
        $res = $q->result_array();
        if ($res) {//在找每个三级都有第四级别
            $result = '';
            foreach ($res as $l) {
                $this->db->where(array('parent' => $l['pid'], 'del' => 0, 'sta' => 0));
                $r = $this->db->get('place');
                if ($r->num_rows() > 0) {
                    $result = 1;;
                }
            }
            if ($result) {
                return true;
            } else {
                return false;
            }
//        $this->db->where(array('parent'=>$res['pid'],'del'=>0,'sta'=>0,'deep'=>3));
//        $r =$this->db->get('place');
//        if($res=$r->row_array()){
            // return $res['pid'];
//        }else{
//            return false;
//        }
        } else {
            return false;
        }

    }

    public function exit_next_level($city_id)
    {
        $this->db->select('pid');
        $this->db->where(array('parent' => $city_id, 'del' => 0, 'sta' => 0));
        $q = $this->db->get('place');
        if ($q->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /*判断三级景点的存在*/
    public function exit_views($uid, $city, $city_data, $flag)
    {
        if ($flag == 1) {//去过
            $where = array('uid' => $uid, 'placeid' => $city_data, 'beento' => 1);
            if ($city_data) {
                $where = array('uid' => $uid, 'placeid' => $city_data, 'city' => $city, 'beento' => 1);
            }
        } elseif ($flag == 0) {
            $where = array('uid' => $uid, 'placeid' => $city_data, 'planto' => 1);
            if ($city_data) {
                $where = array('uid' => $uid, 'placeid' => $city_data, 'city' => $city, 'planto' => 1);
            }
        }
        $this->db->where($where);
        $visit = $this->db->get('place_visit');
        if ($visit->num_rows()) {//存在
            return 1;
        }
    }

    /*判断是否有这个景点*/
    public function get_this_view($uid, $city, $city_data)
    {
        $where = array('uid' => $uid, 'placeid' => $city_data, 'city' => $city);
        $this->db->where($where);
        $visit = $this->db->get('place_visit');
        if ($visit->num_rows()) {//存在
            return 1;
        }

    }

    /*去过景点的所有数据地图坐标
     * */
    public function get_view_location($uid)
    {
        $where = array('uid' => $uid, 'beento' => 1, 'city >' => 0, 'del' => 0, 'sta' => 0, 'city !=' => 'placeid');
        $played = $this->db->select('pid')->from('place_visit')->join('place', 'placeid=pid')->where($where, NULL, FALSE)->get()->result_array();
        //找到每个地点的城市线面的一级
        foreach ($played as $l) {
            $pid_arr = $this->parentid($l['pid']);
            if (count($pid_arr) > 3) {
                $new_view[] = $pid_arr[3];
            } else {
                $new_view[] = $l['pid'];
            }
        }
        $new_view = array_unique($new_view);
        foreach ($new_view as $vid) {
            $last_view[] = $this->db->select('pid,name,longitude,latitude')->from('place')->where(array('pid' => $vid))->get()->row_array();

        }
        return $last_view;

    }

    /*首页 随机数据 james*/
    public function rand_city($uid)
    {
        //获取所有国家
        $country = $this->db->select("pid,name")->where(array('deep' => 1, 'del' => 0, 'sta' => 0))->order_by('RAND()')->limit(1)->get('place')->result_array();
        $country_id = $country[0]['pid'];
        $city = $this->db->select('pid,name,description')->from('place')->where(array('parent' => $country_id, 'del' => 0, 'sta' => 0, 'virtual' => 0))->order_by('RAND()')->limit(5)->get()->result_array();
        $rand_key = array_rand($city, 1);
        //获取这个用户是否去过这个城市
        $city_id = $city[$rand_key];//城市ID
        if ($uid) {
            $city_id['beento'] = $this->db->get_where('place_visit', array('uid' => $uid, 'placeid' => $city_id['pid'], 'city' => $city_id['pid'], 'beento' => 1))->num_rows();
            $city_id['planto'] = $this->db->get_where('place_visit', array('uid' => $uid, 'placeid' => $city_id['pid'], 'city' => $city_id['pid'], 'planto' => 1))->num_rows();

        } else {
            $city_id['beento'] = '';
            $city_id['planto'] = '';
        }
        $img = $this->db->select('img')->from('place_sport_images')->where(array('place_id' => $city_id['pid']))->get()->row_array();
        $city_id['img'] = $img['img'];
        $city_id['country_name'] = $country[0]['name'];
        return $city_id;
    }

    //大家都在玩
    public function sport_played()
    {

        $q = $this->db->query('select num,name,img,sport_id from (select COUNT(sport_id) as num,sport_id FROM xcenter_sport_play where beento=1 GROUP BY sport_id ORDER BY num DESC limit 5) a LEFT JOIN  xcenter_sport on sport_id=spid
');
        return $q->result_array();

    }

    /*判断添加的足迹是否存在*/
    public function exit_spoor($uid, $city, $city_data, $flag)
    {

        if ($flag == 1) {//去过
            if ($city_data) {//有最后的目的地
                $where = array('uid' => $uid, 'placeid' => $city_data, 'city' => $city, 'beento' => 1);
            } else {
                $where = array('uid' => $uid, 'placeid' => $city, 'city' => $city, 'beento' => 1);
            }

        } elseif ($flag == 0) {
            if ($city_data) {//有最后的目的地
                $where = array('uid' => $uid, 'placeid' => $city_data, 'city' => $city, 'planto' => 1);
            } else {
                $where = array('uid' => $uid, 'placeid' => $city, 'city' => $city, 'planto' => 1);
            }
        }
        $this->db->where($where);
        $visit = $this->db->get('place_visit');
        if ($visit->num_rows()) {//存在
            return 1;
        }
    }

    /*判断是否为虚拟*/
    public function virtual($pid)
    {
        $res = $this->db->select('virtual')->get_where('place', array('pid' => $pid))->row_array();//一维数组
        return $virtual = $res['virtual'];

    }

    /*添加足迹*/

    public function add_spoor($uid, $city, $city_data, $flag, $country)
    {
        //1. 首先判断是否存在 如果存在直接更新
        if ($city_data) {//有最终目的地的判断
            $where = array('uid' => $uid, 'country' => $country, 'placeid' => $city_data, 'city' => $city);
            //跟新数据的数组
            if ($flag == 1) { //判断类型 1.去过
                $dates = array('uid' => $uid, 'country' => $country, 'placeid' => $city_data, 'city' => $city, 'beento' => 1, 'created' => time());
                $up_data = array('beento' => 1);

            } elseif ($flag == 0) { //想去
                $dates = array('uid' => $uid, 'country' => $country, 'placeid' => $city_data, 'city' => $city, 'planto' => 1, 'created' => time());
                $up_data = array('planto' => 1);
            }

        } else {
            $where = array('uid' => $uid, 'country' => $country, 'placeid' => $city, 'city' => $city);
            //没有目的地的时候数据
            if ($flag == 1) { // 1.去过
                $dates = array('uid' => $uid, 'country' => $country, 'placeid' => $city, 'city' => $city, 'beento' => 1, 'created' => time());
                $up_data = array('beento' => 1);
            } elseif ($flag == 0) { //想去
                $dates = array('uid' => $uid, 'country' => $country, 'placeid' => $city, 'city' => $city, 'planto' => 1, 'created' => time());
                $up_data = array('planto' => 1);
            }
        }
        $this->db->where($where);
        $visit = $this->db->get('place_visit');
        $visit->num_rows();
        // return $this->db->last_query();
        if ($visit->num_rows()) {//存在 直接更新
            $res = $this->db->update('place_visit', $up_data, $where);
        } else {//直接添加数据
            $res = $this->db->insert('place_visit', $dates);

        }
        if ($res) {

            return true;

        } else {
            return false;
        }
    }

    /*存在城市*/
    public function exit_city($uid, $city_data, $flag)
    {
        if ($flag == 1) {//去过
            $where = array('uid' => $uid, 'placeid' => $city_data, 'beento' => 1);
        } elseif ($flag == 0) {
            $where = array('uid' => $uid, 'placeid' => $city_data, 'planto' => 1);
        }
        $this->db->where($where);
        $visit = $this->db->get('place_visit');
        $res = $visit->row_array();
        if ($res) {//存在
            return 1;
        }


    }

    /*景点个数*/
    public function  total_view($table, $where)
    {
        return $this->db->where($where, NULL, FALSE)->get($table)->num_rows();
    }

    /*城市的信息坐标
     * */
    public function view_city_location($uid)
    {
        $where = array('uid' => $uid, 'beento' => 1, 'city >' => 0, 'virtual' => 0, 'del' => 0, 'sta' => 0, 'city' => 'placeid');
        $played_city = $this->db->select('pid,placeid,name,name_en,longitude,latitude')->from('place_visit')->join('place', 'placeid=pid')->where($where, NULL, FALSE)->get()->result_array();
        return $played_city;

    }

    /*
        *     获取当前目的地的父级ID，返回一给数组
        */
    public function parentid($pid)
    {
        $arr = array();
        while (true) {
            $tem = $this->db->get_where('place', array('pid' => $pid))->row_array();
            $pid = $tem['parent'];
            if ($pid > 0) {
                array_unshift($arr, $pid);
            } else {
                break;
            }
        }
        return $arr;
    }

    /*
     * 最新文章5ge
     * */
    public function latest_news($num, $classic)
    {
        return $this->db->select('id,title,img,hit')->limit($num)->order_by('hit desc,update desc')->get_where('article', array('is_del' => 1, 'classic' => $classic))->result_array();


    }

    /*获取跟此运动相关的文章
     * $spid 运动id
     *
     * */

    public function sport_contact_news($spid, $num)
    {
        return $this->db->select('id,title,img')
            ->from('article_tag as a')
            ->join('article as b', 'a.article_id=b.id')
            ->where(array('a.tag_id' => $spid, 'a.flag' => 2, 'b.is_del' => 1, 'b.is_visible' => 1))
            ->limit($num)
            ->order_by('created', 'desc')
            ->get()
            ->result_array();
    }

    public function sportGetArticles($spid, $offset, $num)
    {
        return $this->db->select('id,title,img')
            ->from('article_tag as a')
            ->join('article as b', 'a.article_id=b.id')
            ->where(array('a.tag_id' => $spid, 'a.flag' => 2, 'b.is_del' => 1, 'b.is_visible' => 1))
            ->limit($offset, $num)
            ->order_by('created', 'desc')
            ->get()
            ->result_array();
    }

    public function sportGetArticlesTotal($spid) {
        return $this->db->select('id,title,img')
            ->from('article_tag as a')
            ->join('article as b', 'a.article_id=b.id')
            ->where(array('a.tag_id' => $spid, 'a.flag' => 2, 'b.is_del' => 1, 'b.is_visible' => 1))
            ->order_by('created', 'desc')
            ->count_all_results();
    }

    public function classGetArticles($class, $offset, $num) {
        return $this->db->select('id,title,img')
            ->from ('article as a')
            ->where(array('a.classic' => $class, 'a.is_del' => 1, 'a.is_visible' => 1))
            ->limit($offset, $num)
            ->order_by('created', 'desc')
            ->get()
            ->result_array();
    }

    public function classGetArticlesTotal($spid) {
        return $this->db->select('id,title,img')
            ->from ('article as a')
            ->where(array('a.classic' => $spid, 'a.is_del' => 1, 'a.is_visible' => 1))
            ->order_by('created', 'desc')
            ->count_all_results();
    }


    /**
     * 加入/取消讨论组
     * @param $objectid
     * @param $uid
     * @return bool
     */
    public function sport_join($objectid,$uid){

        $sql="select * from ".$this->db->dbprefix."sport_join where sport_id=".$objectid." and uid=".$uid.";";
        $num = $this->db->query($sql)->num_rows();
        if($num>0){
            return true;
        }

        $sql="insert into ".$this->db->dbprefix."sport_join values(".$objectid.",".$uid.",".time().");";
        $this->db->query($sql);

    }

    /**
     * 是否加入讨论组
     * @param $objectid
     * @param $uid
     * @return bool
     */
    public function sport_joined($objectid,$uid){

        $sql="select * from ".$this->db->dbprefix."sport_join where sport_id=".$objectid." and uid=".$uid.";";
        $num = $this->db->query($sql)->num_rows();
        if($num>0){
            return true;
        }
        return false;
    }

    public function sport_unjoin($objectid,$uid){

        $sql="delete from ".$this->db->dbprefix."sport_join where sport_id=".$objectid." and uid=".$uid.";";
        $this->db->query($sql);
        return true;
    }

    public function sport_join_count($id){
        $this->db->where('sport_id',$id);
        $this->db->from('sport_join');
        $num = $this->db->count_all_results();
        return $num;
    }

    public function get_random_sports_list($spid,$num){
        $sql="SELECT * FROM ".$this->db->dbprefix."sport
WHERE sta=0 and spid >= (SELECT FLOOR( MAX(spid) * RAND()) FROM ".$this->db->dbprefix."sport) and spid!=".$spid."
ORDER BY spid LIMIT ".$num.";";
        $query=$this->db->query($sql);
        return $query->result_array();
    }

    /**
     * 加入人数最多的部落
     * @param int $limit
     * @param int $question_id
     * @return mixed
     */
    public function join_maxcount_spid($limit=5){

        $sql="select group_concat(sport_id) sport_id from (select sport_id from ".$this->db->dbprefix."sport_join group by sport_id order by count(sport_id) desc limit ".$limit.") t;";

        $query = $this->db->query($sql);
        $row=$query->row_array();
        return $row['sport_id'];
    }

    public function get_sports_list($spid){
        $sql="SELECT * FROM ".$this->db->dbprefix."sport WHERE sta=0 and spid in(".$spid.");";
        $query=$this->db->query($sql);
        return $query->result_array();
    }

    //最新加入部落的 uid
    public function get_sports_join_recent($spid,$limit){
        $sql="SELECT group_concat(uid) uid FROM ".$this->db->dbprefix."sport_join order by created desc limit ".$limit.";";
        if($spid>0) {
            $sql = "SELECT group_concat(uid) uid FROM " . $this->db->dbprefix . "sport_join WHERE sport_id=" . $spid . " order by created desc limit " . $limit . ";";
        }
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row['uid'];
    }

    // map models
    // added by jason
    public function filterDestinations (array $_arr_filter_sports) {
        $_query = $this->db->select('p.pid, p.name, p.name_en, p.score, p.description, p.del, p.deep, p.hot, p.longitude, p.latitude'
            . ', ps.weight, ps.sport_index, ps.sport_id')
            ->from('place_sport ps')
            ->join('place as p', 'p.pid = ps.place_id', 'left')
            ->join('sport as sp', 'sp.spid = ps.sport_id', 'left')
            ->where('p.longitude is not null', null, false)
            ->where('p.sta', 0)
            ->where('p.del', 0)
            ->where('sp.sta', 0)
            ->where('sp.del', 0)
            ->where('ps.sta', 0);

        if(0 < count($_arr_filter_sports)) {
            $_query->where_in('ps.sport_id', $_arr_filter_sports);
        }

        return $_query->distinct()->get()->result();
    }

    public function filterNationalParks () {
        return $this->db->select("'park' as sport_id, p.pid, p.name, p.name_en, p.score, p.description, p.del, p.deep, p.hot, p.longitude, p.latitude", false)
            ->from('place as p')
            ->where('p.longitude is not null', null, false)
            ->where('p.sta', 0)
            ->where('p.del', 0)
            ->like('p.name', '国家公园')
            ->distinct()->get()->result();
    }
}

