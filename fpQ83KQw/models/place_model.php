<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Place_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
    * 获取目的地分类
    * */
    public function get_data($table, $filed = '*', $where = array())
    {
        $this->db->select($filed);
        $this->db->where($where);
        $this->db->order_by('weight', 'asc');
        $q = $this->db->get($table);
        return $q->result_array();
    }

    /*
    * 获取广告地分类
    * */
    public function get_ad()
    {
        $id_data = array('249', '250', '251', '252', '253', '254');
        $this->db->where_in('id', $id_data);
        $this->db->where('bid', 13);
        $q = $this->db->get('ads_sclass');
        return $q->result_array();
    }

    /*
    * 获取指定位置广告
    * */
    public function get_advis($classid)
    {
        $this->db->where(array('flag' => 1, 'classid' => $classid));
        $this->db->order_by('sort_number', 'asc');
        $q = $this->db->get('ads');
        return $q->result_array();
    }

    /**
     * 检索整个目的地的树形结构，以多维数组的形式返回
     *
     * @param unknown_type $id
     * @return unknown
     */
    public function place_tree($pid = 0)
    {
        $this->db->where('parent', $pid);
        $this->db->where('del', 0);
        $this->db->order_by('weight', 'asc');
        $r = $this->db->get('place');
        $result = $r->result_array();
        $tree = array();
        if ($r->num_rows() > 0) {
            foreach ($result as $k => $v) {
                $res = $this->place_tree($v['pid']);
                if (!empty($res)) {
                    $v['child'] = $res;
                }
                $tree[] = $v;
            }
        }
        return $tree;
    }

    /*
    * 获取分页数据
    * */
    public function get_pagedata($table, $filed = '*', $where = array(), $offset, $pagesize)
    {
        $this->db->select($filed);
        $this->db->where($where);
        $this->db->limit($pagesize, $offset);
        $this->db->order_by('weight', 'asc');
        $q = $this->db->get($table);
        return $q->result_array();
    }

    /**
     * 检索指定关键词的目的地
     *
     * @param unknown_type $key
     * @return unknown
     */
    public function get_placebykey($key)
    {
        $eKey = $this->db->escape_like_str($key);
        $sql = "select * from (" . $this->db->dbprefix . "place) where del = 0 and sta=0 and deep > 0 AND (name LIKE '%$eKey%' or name_en LIKE '$eKey%')";
        $r = $this->db->query($sql);
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /**
     * 检索指定目的地下面的运动的相关信息，以数组的形式返回
     *
     * @param unknown_type $pid :目的地id
     * @return unknown
     */
    public function get_sports($pid)
    {
        $this->db->select('a.*,c.img as sportimg');
        $this->db->select('b.*,b.sta as status');
        $this->db->from('place_sport as a');
        $this->db->join('sport as b', 'a.sport_id=b.spid');
        $this->db->where('a.place_id', $pid);
        $this->db->where('a.sta', 0);
        $this->db->where('b.del', 0);
        $this->db->where('b.sta', 0);
        $this->db->join('place_sport_images as c', 'c.sport_id=b.spid', 'left');
        $this->db->order_by('b.weight', 'asc');
        $r = $this->db->get();
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /**
     * 检索指定目的地下面的用户背包的相关信息，以数组的形式返回
     *
     * @param unknown_type $pid :目的地id
     * @return unknown
     */
    public function get_bags($pid)
    {
        $this->db->select('b.*,c.username,c.uid as cuid');
        $this->db->from('bag_place as a');
        $this->db->join('bag as b', 'a.bagid=b.id');
        $this->db->where('a.placeid', $pid);
        $this->db->where('b.del', 0);
        $this->db->where('b.sta', 0);
        $this->db->join('members as c', 'c.uid=b.uid', 'left');
        $this->db->order_by('b.created', 'desc');
        $r = $this->db->get();
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /*
     * 统计指定背包收藏人数
     */
    public function bag_favorites_num($bid)
    {
        $this->db->from('bag_favorites');;
        $this->db->where('bagid', $bid);
        $r = $this->db->get();
        return $r->num_rows();
    }

    /**
     * 检索指定目背包下的装备清单，以数组的形式返回
     *
     * @param unknown_type $bagid :背包
     * @return unknown
     */
    public function get_bags_list($bagid)
    {
        $this->db->select('b.*');
        $this->db->from('bag_list as a');
        $this->db->join('taxonomy_term as b', 'a.term_list_id=b.ttid');
        $this->db->where('a.bagid', $bagid);
        $this->db->where('b.del', 0);
        $this->db->where('b.sta', 0);
        $this->db->order_by('b.weight', 'asc');
        $r = $this->db->get();
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /**
     * 检索指定目的地下面的图片的相关信息，以数组的形式返回
     *
     * @param unknown_type $pid :目的地id
     * @return unknown
     */
    public function get_imgs($pid)
    {
        $this->db->where('place_id', $pid);
        $this->db->where('sport_id', 0);
        $this->db->order_by('weight', 'asc');
        $r = $this->db->get('place_sport_images');
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /**
     * 检索指定目的地下面的某项运动的指定数目的banner图
     *
     * @param unknown_type $pid
     * @param unknown_type $sport_id
     * @param unknown_type $num
     * @return unknown
     */
    public function get_sports_img($pid, $sport_id, $num = 1)
    {
        $this->db->where('place_id', $pid);
        $this->db->where('sport_id', $sport_id);
        $this->db->order_by('weight', 'asc');
        $this->db->limit($num);
        $r = $this->db->get('place_sport_images');
        if ($r->num_rows() == 0) {
            return false;
        }
        if ($r->num_rows() == 1) {
            return $r->row_array();
        }
        return $r->result_array();
    }

    /**
     * 检索指定目的地下面的banner图
     *
     * @param unknown_type $pid
     */
    public function get_place_img($pid, $num = 1)
    {
        $this->db->where('place_id', $pid);
        $this->db->order_by('weight', 'asc');
        $this->db->limit($num);
        $r = $this->db->get('place_sport_images');
        if ($r->num_rows() == 0) {
            return false;
        }
        if ($r->num_rows() == 1) {
            return $r->row_array();
        }
        return $r->result_array();
    }

    /**
     * 检索指定目的地的下级目目的地
     * 不可不去
     * @param unknown_type $pid
     */
    public function get_place_must($pid, $num = 1)
    {
        $this->db->from('place as a');
        $this->db->where('a.parent', $pid);
        $this->db->where('a.del', 0);
        $this->db->where('a.sta', 0);
        $this->db->join('place_sport_images as b', 'a.pid=b.place_id', 'left');
        $this->db->group_by('a.pid');
        $this->db->order_by('a.weight', 'asc');
        $this->db->limit($num);
        $r = $this->db->get();
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /**
     * 检索指定目的地的运动
     * 不可不玩
     * @param unknown_type $pid
     */
    public function get_sport_must($pid, $num = 1)
    {
        $this->db->from('place_sport as a');
        $this->db->where('a.place_id', $pid);
        $this->db->where('a.sta', 0);
        $this->db->join('place_sport_images as b', 'a.sport_id=b.sport_id', 'left');
        $this->db->group_by('a.sport_id');
        $this->db->order_by('a.weight', 'asc');
        $this->db->limit($num);
        $r = $this->db->get();
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /**
     * 检索指定目的地下想去会员
     * @param unknown_type $planto ,0-想去  1-已想去
     * @param unknown_type $pid
     */
    public function  get_place_planto($pid, $planto, $num = 1)
    {
        $this->db->from('place_visit as a');
        $this->db->where('a.placeid', $pid);
        $this->db->where('a.planto', $planto);
        $this->db->join('members as b', 'a.uid=b.uid', 'right');
        $this->db->where('b.status', 0);
        $this->db->group_by('a.uid');
        $this->db->limit($num);
        $r = $this->db->get();
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /**
     * 检索指定目的地下去过会员
     * @param unknown_type $beento ,0-去过  1-已去过
     * @param unknown_type $pid
     */
    public function  get_place_beento($pid, $beento, $num = 1)
    {
        $this->db->from('place_visit as a');
        $this->db->where('a.placeid', $pid);
        $this->db->where('a.beento', $beento);
        $this->db->join('members as b', 'a.uid=b.uid', 'right');
        $this->db->where('b.status', 0);
        $this->db->group_by('a.uid');
        $this->db->limit($num);
        $r = $this->db->get();
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    //想去去过未有记录
    public function place_want($data = array())
    {
        return $this->db->insert('place_visit', $data);
    }

    //想去去过已有记录更新
    public function place_want_update($where = array(), $data = array())
    {
        $this->db->where($where);
        return $this->db->update('place_visit', $data);

    }

    /**
     * 通过目的地id检索出该目的地的所有后代目的地的pid，以一维数组的形式返回
     *
     * @param unknown_type $pid
     * @return unknown
     */
    public function get_offspring_place($pid)
    {
        $this->db->where('parent', $pid);
        $this->db->where('del', 0);
        $this->db->order_by('weight', 'asc');
        $r = $this->db->get('place');
        $result = $r->result_array();
        $list = array($pid);
        if ($r->num_rows() > 0) {
            foreach ($result as $k => $v) {
                $list = array_merge($list, $this->get_offspring_place($v['pid']));
            }
        }
        return $list;
    }

    /**
     * 通过目的地id检索出该目的地的所有后代目的地deep=3的pid，以一维数组的形式返回
     *
     * @param unknown_type $pid
     * @return unknown
     */

    public function get_child($tree, $arr, $offset = 0, $pagesize = '')
    {
        foreach ($tree as $k => $v) {
            if (count($v["child"])) {
                $arr = $this->get_child($v["child"], $arr);
            } else {
                $arr [] = $v;
            }
        }
        if ($pagesize) {
            return array_slice($arr, $offset, $pagesize);
        } else {

            return $arr;
        }
    }

    /**
     * 检索某个目的地以及该目的地所有后代节点的所有运动数据
     *
     * @param unknown_type $pid
     * @param unknown_type int $offset:偏移量
     * * @param unknown_type int $pagesize:显示数目
     * @return unknown
     */
    public function get_all_sports($pid, $offset = 0, $pagesize = '')
    {
        $place = $this->get_offspring_place($pid);
        if (!count($place)) {
            return false;
        }
        $sports = array();
        foreach ($place as $k => $v) {
            $sport = $this->get_sports($v);
            if ($sport != false) {
                foreach ($sport as $j => $k) {
                    $sports[$k['sport_id']] = $k;
                }
            }
        }
        if ($pagesize) {
            return array_slice($sports, $offset, $pagesize);
        } else {

            return $sports;
        }
    }

    /**
     * 检索指定目的地的评论，并按照指定的条件进行排序
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
        $r = $this->db->get('place_comments');
        if ($r->num_rows() == 0) {
            return false;
        }
        return $r->result_array();
    }

    /**
     * 检索某个目的地以及该目的地所有后代节点的所有图片数据
     *
     * @param unknown_type $pid
     * @param unknown_type int $offset:偏移量
     * * @param unknown_type int $pagesize:显示数目
     * @return unknown
     */
    public function get_all_picture($pid, $offset = 0, $pagesize)
    {
        $place = $this->get_offspring_place($pid);
        if (!count($place)) {
            return false;
        }
        $pictures = array();
        foreach ($place as $k => $v) {
            $picture = $this->get_imgs($v);
            if ($picture != false) {
                foreach ($picture as $j => $k) {
                    $pictures[$k['psiid']] = $k;
                }
            }
        }
        if ($pagesize) {
            return array_slice($pictures, $offset, $pagesize);
        } else {
            return $pictures;
        }
    }

    /**
     * 检索某个目的地以及该目的地所有后代节点的所有背包数据
     *
     * @param unknown_type $pid
     * @param unknown_type int $offset:偏移量
     * * @param unknown_type int $pagesize:显示数目
     * @return unknown
     */
    public function get_all_bag($pid, $offset = 0, $pagesize)
    {
        $place = $this->get_offspring_place($pid);
        if (!count($place)) {
            return false;
        }
        $bags = array();
        foreach ($place as $k => $v) {
            $bag = $this->get_bags($v);
            if ($bag != false) {
                foreach ($bag as $j => $k) {
                    $bags[$k['id']] = $k;
                }
            }
        }
        if ($pagesize) {
            return array_slice($bags, $offset, $pagesize);
        } else {
            return $bags;
        }
    }

    /**
     * 统计某个目的地下有多少部落
     *
     * @param unknown_type $pid
     * @return unknown
     */
    public function sports_total($pid)
    {
        $sports = $this->get_all_sports($pid);
        if ($sports == false) {
            return 0;
        }
        return count($sports);
    }

    /**
     * 统计指定目的地有多少人去过跟想去，
     *
     * @param unknown_type $pid
     * @param unknown_type $deep ：1-国家，2-城市，3-目的地
     * @param unknown_type $flag ：1-想去，2-去过
     * @return unknown
     */
    public function been__want_total($pid, $flag = 1)
    {
        $this->db->select('placeid');
        $this->db->where('placeid', $pid);

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
        $this->db->from('place_visit');
        $total = $this->db->count_all_results();
        return $total;
    }

    /**
     * 统计某个目的地下的评论数
     *
     * @param unknown_type $pid
     * @return unknown
     */
    public function comments_total($pid)
    {
        $this->db->select('cid');
        $this->db->where('pid', $pid);
        $this->db->where('del', 0);
        $this->db->where('sta', 0);
        $this->db->from('place_comments');
        $total = $this->db->count_all_results();
        return $total;
    }

    /*
  * 检索指定目的地的信息
  *
  * @param unknown_type $pid
  * @return unknown
  */
    public function get_place($pid)
    {
        $s = $this->db->get_where('place', array('pid' => $pid));
        if ($s->num_rows() == 0) {
            return false;
        }
        return $s->row_array();
    }

    /*
     * 检索指定目的地的父级
     *
	 * @param unknown_type $pid
	 * @return unknown
     */
    public function place_parent($pid)
    {
        $s = $this->db->get_where('place', array('pid' => $pid, 'parent >' => 0, 'deep >' => 0));
        if ($s->num_rows() == 0) {
            return false;
        }
        $r = $s->row_array();
        if ($r['deep'] == 1) {
            $r['country'] = $r['pid'];
            $r['city'] = 0;
            $r['placeid'] = 0;
        }
        if ($r['deep'] == 2) {
            $r['country'] = $r['parent'];
            $r['city'] = $r['pid'];
            $r['placeid'] = 0;
        }
        if ($r['deep'] == 3) {
            $r['city'] = $r['parent'];
            $temp = $this->get_place($r['parent']);
            $r['country'] = $temp['parent'];
            $r['placeid'] = $r['pid'];
        }
        return $r;
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
     * 子级数据
     *
     */
    public function get_childrens($pid)
    {
        $a =  $this->db->get_where('place',array('parent'=>$pid,'sta'=>0,'del'=>0));
        return $a->result_array();
    }

    /*
     * 城市页面数据
     *
     */
    public function get_citylist($pid,$offset = 0, $pagesize)
    {
        $list = $this->get_childrens($pid);

        $new = array();
        foreach($list as $item) {
            if ($item['virtual']==0) {
                $new []= $item;
            } else {
                $new = array_merge($new,$this->get_citylist($item['pid']));
            }
        }
        if ($pagesize) {
            return array_slice($new, $offset, $pagesize);
        } else {
            return $new;
        }
    }





    /*
     *       景点面面数据
     */
    public function get_sceniclist($pid,$offset = 0, $pagesize)
    {
        $list = $this->get_childrens($pid);
        $new = array();
        foreach($list as $item) {
            $new = array_merge($new, $this->get_childrens($item['pid']));
        }
        if ($pagesize) {
            return array_slice($new, $offset, $pagesize);
        } else {
            return $new;
        }
    }


    public function getSportsAttr($pid){
        $this->db->select("sa.attribute,sport.name,sport.name_en,sport.alias,sport.img,s.value,sport.spid,sa.order,s.id as savid,sport.spid as spid,sa.id as attributeid");
		 //$this->db->select("*");
        $this->db->from('sport_attr_value as s');
        $this->db->where('s.place_id', $pid);
        $this->db->join('sport_attributes as sa', 'sa.id=s.attribute_id');
        $this->db->join("sport","sport.spid=sa.sport_id");
        $this->db->where('sport.sta', 0);
        //$this->db->group_by('sport.spid');
        $r=$this->db->get();
        $res=$r->result_array();
		if($res==null ||count(res)==0){
			$this->db->select("sa.attribute,sport.name,sport.name_en,sport.alias,sport.img,sport.spid,sa.order");
			$this->db->from('place_sport');
			$this->db->where("place_sport.place_id",$pid);
			$this->db->join('sport_attributes as sa', 'sa.sport_id=place_sport.sport_id');
			$this->db->join("sport","sport.spid=sa.sport_id");
			 $this->db->where('sport.sta', 0);
			 $r=$this->db->get();
			$res=$r->result_array();
		}
        return $res;


    }
	
	public function getSportAtrrByName($name){
		$this->db->select("attribute,sport_attributes.id");
		$this->db->from('sport_attributes');
		$this->db->join('sport',"sport.spid=sport_attributes.sport_id");
		$this->db->where("sport.name",$name);
		$r=$this->db->get();
		$res=$r->result_array();
		return $res;
	}
	public function setBackupForAtt($pid,$attributeid){
		$this->db->select("*");
		$this->db->from('sport_attr_value_backup');
		$this->db->where("backup_place_id",$pid);
		$this->db->where("del",0);
			$r=$this->db->get();
		$res=$r->result_array();
		if($res==null ||count(res)==0){
			$ress=$this->getSportsAttr($pid);
			if($ress==null || count($ress)==0)
			{return false;}
		else
			foreach($ress as $r){
				$this->db->insert("sport_attr_value_backup",array("sport_attr_value_id"=>$r["savid"],"backup_value"=>$r["value"],"backup_place_id"=>$pid,"backup_sport_id"=>$r["spid"],
				"backup_attribute_id"=>$r["attributeid"]));
			}
			return true;
		}
		else{
			return true;
		}
	}
	
	public function setForAtt($value,$attributeid,$pid){
		$this->db->delete("sport_attr_value",array("place_id"=>$pid,"attribute_id"=>$attributeid));
		$this->db->insert("sport_attr_value",array("place_id"=>$pid,"attribute_id"=>$attributeid,"value"=>$value));
	}
	
	public function getAllSports(){
		$this->db->select("*");
		$this->db->from("sport");
		$r=$this->db->get();
		$res=$r->result_array();
		return $res;
	}

}