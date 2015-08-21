<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Map extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('place_model', 'place');
    }

    /*
    *显示地图页面*/
    public function index()
    {

        $this->load->vars('css', $this->css(array('other.css')));
        $this_sport_style =intval($this->uri->segment(2));
        $this_pid=intval($this->uri->segment(3));
        if($this_sport_style==0){
            message('参数错误','place');
        }
        //查询这个运动的名字
        $data['sport_name']=$sp_name=$this->get_one_data('sport','name,name_en',array('spid'=>$this_sport_style,'sta'=>0,'del'=>0));
        $this->load->vars('title', $this->title($sp_name['name'].' 部落分布图'));
        $tree = $this->place->place_tree($this_pid);//所有地点
        $arr = $this->place->get_child($tree, array());
        $array2=array();

//        foreach($arr as $key=>$v){
//             //循环查询这个运动场点的类型数组
//            $res=$this->place->get_data('place_sport','sport_id',array('place_id'=>$v['pid'],'sta'=>0));
//            if(!$res){//没有添加过运动的删除
//              unset($arr[$key]);
//            }
//            else{//判断添加运动数组中存在获取的运动类型，不存在 在此去除
//
//                 foreach($res as $k=>$place){
//                    $sport_style[]=$place['sport_id'];
//                 }//一维数组
//                $sp_style=array_unique($sport_style);
//                if(in_array($this_sport_style,$sp_style)){
//
//                    array_push($array2,$arr[$key]);//$arr[$key]);
//                }
//            }
//        }

        $place_sportid = $this->place->get_data('place_sport','place_id',array('sport_id'=>$this_sport_style,'sta'=>0));
        foreach($place_sportid as $pv){
            $pid_arr[]=$pv['place_id'];
        }
        if(!$this_pid){
        foreach($pid_arr as $pid){
           $new_arr[]= $this->get_one_data('place','pid,name,name_en,longitude,latitude',array('pid'=>$pid,'del'=>0,'sta'=>0));
          $p_data=$new_arr;
        }
        }else{
            foreach($arr as $key=>$pid){
                $res=$this->place->get_data('place_sport','sport_id',array('place_id'=>$pid['pid'],'sport_id'=>$this_sport_style,'sta'=>0));
                    if(!$res){//没有添加过运动的删除
                      unset($arr[$key]);
                    }
                //$p_data=$arr; //$this->get_one_data('place','name,name_en,longitude,latitude',array('pid'=>$pid['pid'],'del'=>0,'sta'=>0));
            }
            foreach($arr as $v){
                   $new_arr[]=$v;
                }//一维数组
            $p_data=$new_arr;
        }
        header("Content-type: text/html; charset=utf-8");
 //最后的数据赋值
       if(count($p_data)>0){//有数据的时候
               $data['location_array']=json_encode($p_data);
                //找到这个国家的信息和经纬度
                if($this_pid){
                    $country_data=$this->place->parentid($this_pid);
                    if(count($country_data)==1){//判断传过来的是否为国家
                        $country_id=$this_pid;
                    }else{
                        $country_id=$country_data[1];
                    }
                    //通过国家的id获取一条信息
                    $data['country_info']=$this->get_one_data('place','name,name_en,longitude,latitude',array('pid'=>$country_id,'del'=>0,'sta'=>0));

                }
                     $this->load->view('map/index',$data);
       }else{
           message('对不起可能没有相关数据！','sport');
       }


    }

}