<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Question extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model', 'common');
        $this->load->model('sport_model', 'sport');
        $this->load->model('question_model', 'question_model');
        $this->load->model('user_model', 'user_model');
    }

//    public function list($id)
//    {
//        $detail= $this->get_one_data('sport', '*', array('spid' => $id));
//        $this->set_vars('title', $this->title('部落问答'));
//
//        $this->load->view('question/list');
//    }

    public function add($id)
    {
        if($this->uid==0){
            redirect(PASSPORT_domian.'oauth/login?reurl='.urldecode(WWW_domian.'question/add/'.$id));
            exit(0);
        }
        $spid=$id;
        $this->set_vars('spid',$spid);
        $sport= $this->get_one_data('sport', '*', array('spid' => $spid));
        $this->set_vars('sport',$sport);
        $this->set_vars('title', $this->title($sport['name'].' '.$sport['name_en'].' 部落 提问'));
        $this->set_vars('keywords', $this->keywords($sport['name'].' '.$sport['name_en'].' 部落 提问'));
        $this->set_vars('description', $this->description($sport['name'].' '.$sport['name_en'].' 部落提问'.$sport['description']));


        $joined=$this->sport->sport_joined($spid,$this->uid); //判断是否加入
        $this->set_vars('joined',$joined);

        $joined_count=$this->sport->sport_join_count($spid);
        $this->set_vars('joined_count',"$joined_count");

        $where=array('group_id'=>$spid);
        $question_count=$this->question_model->get_questions_count($where);
        $this->set_vars('question_count',"$question_count");

        $sports=$this->sport->get_random_sports_list($spid,5);
        foreach($sports as &$s){
            $spid2=$s['spid'];
            $joined_count2=$this->sport->sport_join_count($spid2);
            $question_count2=$this->question_model->get_questions_count(array('group_id'=>$spid2));
            $s['joined_count']=$joined_count2;
            $s['question_count']=$question_count2;
        }
        $this->set_vars('sports',$sports);

        $this->load->view('question/add');
    }

    public function index($id)
    {
        $spid=$id;
        $this->set_vars('spid',$spid);
        $sport= $this->get_one_data('sport', '*', array('spid' => $spid));
        $this->set_vars('sport',$sport);
        $this->set_vars('title', $this->title($sport['name'].' '.$sport['name_en'].' 部落问答'));
        $this->set_vars('keywords', $this->keywords($sport['name'].' '.$sport['name_en'].' 部落问答'));
        $this->set_vars('description', $this->description($sport['name'].' '.$sport['name_en'].' 部落问答'.$sport['description']));

        $joined=$this->sport->sport_joined($spid,$this->uid); //判断是否加入
        $this->set_vars('joined',$joined);

        $joined_count=$this->sport->sport_join_count($spid); //小组加入人数
        $this->set_vars('joined_count',"$joined_count");

        $where=array('group_id'=>$spid);
        $question_count=$this->question_model->get_questions_count($where); //小组问题数量
        $this->set_vars('question_count',"$question_count");

        $sports=$this->sport->get_random_sports_list($spid,5); //随机获取5个小组
        foreach($sports as &$s){
            $spid2=$s['spid'];
            $joined_count2=$this->sport->sport_join_count($spid2);
            $question_count2=$this->question_model->get_questions_count(array('group_id'=>$spid2));
            $s['joined_count']=$joined_count2;
            $s['question_count']=$question_count2;
        }
        $this->set_vars('sports',$sports);

        $pagesize =10;
        $currentpage = $this->get_uri_segment(4);
        $orderby='id desc';
        $where=array('group_id'=>$spid);

        $total=$this->question_model->get_questions_count($where); //数量

        $pagelink=$this->get_pagination('question/index/'.$spid,4, 2, $total, $pagesize);
        $this->set_vars('pagelink',$pagelink);

        $list=$this->question_model->get_questions_list($currentpage,$pagesize,$where,$orderby); //列表
        $this->set_vars('list',$list);

        $this->load->view('question/index');
    }

    public function plist()
    {
        $this->set_vars('title', $this->title(' 部落问答'));
        $this->set_vars('keywords', $this->keywords(' 部落问答'));
        $this->set_vars('description', $this->description(' 部落问答'));


        //最热门的部落
        $join_maxcount_spid=$this->sport->join_maxcount_spid(5);
        if($join_maxcount_spid){
            $every_play=$this->sport->get_sports_list($join_maxcount_spid);
            foreach($every_play as &$s){
                $spid2=$s['spid'];
                $joined_count2=$this->sport->sport_join_count($spid2);
                $question_count2=$this->question_model->get_questions_count(array('group_id'=>$spid2));
                $s['joined_count']=$joined_count2;
                $s['question_count']=$question_count2;
            }
            $this->set_vars('every_play',$every_play);
        }

        $pagesize =10;
        $currentpage = $this->get_uri_segment(3);
        $orderby='id desc';
        $where=array('deleted'=>0);

        $total=$this->question_model->get_questions_count($where); //数量

        $pagelink=$this->get_pagination('question/plist',3, 2, $total, $pagesize);
        $this->set_vars('pagelink',$pagelink);

        $list=$this->question_model->get_questions_list($currentpage,$pagesize,$where,$orderby); //列表
        $this->set_vars('list',$list);

        $this->load->view('question/plist');
    }

    public function detail($id)
    {
        $this->set_vars('questionid',$id);

        $question= $this->get_one_data('question', '*', array('id' => $id));
        $this->set_vars('question',$question);

        $this->question_model->question_set($id,'hits','hits+1');

        $members=$this->user_model->get_members($question['uid']);
        $member=$members[0];
        $this->set_vars('question_member',$member);

        $spid=$question['group_id'];
        $this->set_vars('spid',$spid);
        $sport= $this->get_one_data('sport', '*', array('spid' => $spid));
        $this->set_vars('sport',$sport);
        $this->set_vars('title', $this->title($question['title'].$sport['name'].' '.$sport['name_en'].' 部落问答'));
        $this->set_vars('keywords', $this->keywords($question['title'].$sport['name'].' '.$sport['name_en'].' 部落问答'));
        $this->set_vars('description', $this->description(messagecutstr($question['body'],500)));

        $joined=$this->sport->sport_joined($spid,$this->uid); //判断是否加入
        $this->set_vars('joined',$joined);

        $joined_count=$this->sport->sport_join_count($spid);
        $this->set_vars('joined_count',"$joined_count");

        $where=array('group_id'=>$spid);
        $question_count=$this->question_model->get_questions_count($where);
        $this->set_vars('question_count',"$question_count");

        $followed=$this->question_model->question_followed($id,$this->uid); //判断是否关注
        $this->set_vars('followed',$followed);

        $sports=$this->sport->get_random_sports_list($spid,5);
        foreach($sports as &$s){
            $spid2=$s['spid'];
            $joined_count2=$this->sport->sport_join_count($spid2);
            $question_count2=$this->question_model->get_questions_count(array('group_id'=>$spid2));
            $s['joined_count']=$joined_count2;
            $s['question_count']=$question_count2;
        }
        $this->set_vars('sports',$sports);

        $pagesize =6;
        $currentpage = $this->get_uri_segment(4);
        $orderby='id desc';
        $where=array('question_id'=>$id);

        $total=$this->question_model->get_answer_count($where); //数量

        $pagelink=$this->get_pagination('question/detail/'.$id,4, 2, $total, $pagesize);
        $this->set_vars('pagelink',$pagelink);

        $list=$this->question_model->get_answer_list($currentpage,$pagesize,$where,$orderby); //回答 列表
        foreach($list as &$item) {
            $where = array('object_id' => $item['id'], 'uid' => $this->uid);
            $liked = $this->question_model->get_answer_liked_count($where);
            $item['user_liked']=$liked;
            /*----------------------------------------------------------------------*/
          $item['answer_reply']=$this->question_model->get_answer_reply_list(array('answer_id'=>$item['id']),$orderby) ;  //回答的回复列表
            $reply_reply_array=array();
         foreach($item['answer_reply'] as $answer_reply){
             $reply_reply_array["{$answer_reply['id']}"]=$this->question_model->get_answer_reply_reply_list(array('reply_id'=>$answer_reply['id']),$orderby);//回答的回复的回复列表
         }
            $item['answer_reply_reply']=$reply_reply_array;



            /*----------------------------------------------------------------------*/
        }
        $this->set_vars('list',$list);

        $question_follow_list=$this->question_model->get_question_follow_list(1,20,array('object_id'=>$id),'created desc'); //列表
        $this->set_vars('question_follow_list',$question_follow_list); //关注的用户

        #$question_follow_count=$this->question_model->get_question_follow_count(array()); //关注人数
        $this->set_vars('user_id',$this->uid); //关注的用户
        $pattern="/<[img|IMG].*?src=['|\"](.*?(?:[.gif|.jpg]))['|\"].*?[\/]?>/";
//        $str=$question['body'];
//        preg_match_all($pattern,$str,$match);
//        $exif=  exif_read_data( $match[1][0]);
//        $ort = $exif['IFD0']['Orientation'];
//        $this->set_vars("match",$ort);
//        echo var_dump($exif) ;return;
        $this->load->view('question/detail');
    }

    public function addajax($id){
        if($this->uid==0){
            echo -1; //未登录
            exit;
        }
        $joined=$this->sport->sport_joined($id,$this->uid); //判断是否加入
        if(!$joined){
            echo -2; //未加入
            exit;
        }
        $title=trim($this->post('title'));
        $content=trim($this->post('content'));
        if(strlen($title)==0||strlen($content)==0){
            echo 0; //信息不完整
            exit;
        }
        $arr=array('group_id'=>$id,'uid'=>$this->uid,'title'=>$title,'body'=>$content,'ip'=>$this->get_ip(),'created'=>time(),'updated'=>time());
        $qid=$this->question_model->question_add($arr);
        echo $qid; //成功
        exit;
    }

    public function addanswerajax($id){
        $spid=intval($this->post('spid'));

        if($this->uid==0){
            echo -1; //未登录
            exit;
        }
        $question= $this->get_one_data('question', '*', array('id' => $id));
        $this->set_vars('question',$question);
        $spid=$question['group_id'];
        $joined=$this->sport->sport_joined($spid,$this->uid); //判断是否加入
        if(!$joined){
            echo -2; //未加入
            exit;
        }

        $content=trim($this->post('content'));
        if($spid==0||strlen($content)==0){
            echo 0; //信息不完整
            exit;
        }
        $arr=array('question_id'=>$id,'uid'=>$this->uid,'body'=>$content,'ip'=>$this->get_ip(),'created'=>time(),'updated'=>time());
        $qid=$this->question_model->answer_add($arr);

        $this->question_model->question_set($id,'comments','comments+1');
        echo $qid; //成功
        exit;
    }

    public function addfollowajax($id){
        if($this->uid==0){
            echo -1; //未登录
            exit;
        }
        $followed=intval($this->post('followed'));

        $question= $this->get_one_data('question', '*', array('id' => $id));
        $this->set_vars('question',$question);
        $spid=$question['group_id'];
        $joined=$this->sport->sport_joined($spid,$this->uid); //判断是否加入
        if(!$joined){
            echo -2; //未加入
            exit;
        }
        if($followed==0) {
            $qid = $this->question_model->question_action($id, $this->uid, 'follow');
        }else if($followed==1){
            $qid = $this->question_model->question_unaction($id, $this->uid, 'follow');
        }
        echo $qid; //成功
        exit;
    }

    public function answer_like_ajax($id){
        if($this->uid==0){
            echo -1; //未登录
            exit;
        }
//        $liked=intval($this->post('liked'));

//        $question= $this->get_one_data('question', '*', array('id' => $id));
//        $this->set_vars('question',$question);
//        $spid=$question['group_id'];
//        $joined=$this->sport->sport_joined($spid,$this->uid); //判断是否加入
//        if(!$joined){
//            echo -2; //未加入
//            exit;
//        }
        $where=array('object_id'=>$id,'uid'=>$this->uid);
        $liked=$this->question_model->get_answer_liked_count($where);
        if($liked==0) {
            $this->question_model->answer_action($id, $this->uid, 'liked');
            $res=1;
        }else if($liked==1){
            $this->question_model->answer_unaction($id, $this->uid, 'liked');
            $res=2;
        }
        echo $res; //成功
        exit;
    }

    /*----------------------------------------------------------------------------------------------------------------*/
public function addanswer_replyajax($answerid){
if($this->uid==0){
echo -1; //未登录
exit;
}
$answer= $this->get_one_data('answer', '*', array('id' => $answerid));
    $q_id=$answer['question_id'];
    $question= $this->get_one_data('question', '*', array('id' => $q_id));
    $this->set_vars('question',$question);
    $spid=$question['group_id'];
$joined=$this->sport->sport_joined($spid,$this->uid); //判断是否加入
if(!$joined){
    echo -2; //未加入
    exit;
}
$content=trim($_GET['content']);
if(strlen($content)==0){
    echo 0; //信息不完整
    exit;

}
$arr=array('answer_id'=>$answerid,'uid'=>$this->uid,'body'=>$content,'ip'=>$this->get_ip(),'created_at'=>time(),'updated_at'=>time());
$qid=$this->question_model->answer_reply_add($arr);
$this->question_model->answer_set($answerid,'comments','comments+1');
echo $qid; //成功
exit;
    //$this->load->helper("url");
   // redirect(WWW_domian."question/detail/{$q_id}");




}
//    public function answer_set($id,$field,$field_value){
//        $where=array('id'=>$id);
//        $this->db->set($field,$field_value,FALSE);
//        $this->db->where($where);
//        $this->db->update('answer');
//        return true;
//
//
//    }


    public function answer_reply_like_ajax($id){
        if($this->uid==0){
            echo -1; //未登录
            exit;
        }
//        $liked=intval($this->post('liked'));

//        $question= $this->get_one_data('question', '*', array('id' => $id));
//        $this->set_vars('question',$question);
//        $spid=$question['group_id'];
//        $joined=$this->sport->sport_joined($spid,$this->uid); //判断是否加入
//        if(!$joined){
//            echo -2; //未加入
//            exit;
//        }
        $where=array('object_id'=>$id,'uid'=>$this->uid);
        $liked=$this->question_model->get_answer_reply_liked_count($where);
        if($liked==0) {
            $this->question_model->answer_reply_action($id, $this->uid, 'liked');
            $res=1;
        }else if($liked==1){
            $this->question_model->answer_reply_unaction($id, $this->uid, 'liked');
            $res=2;
        }
        echo $res; //成功
        exit;
    }

    public function addanswer_reply_replyajax($replyid){
        if($this->uid==0){
            echo -1; //未登录
            exit;
        }
        $answer_reply= $this->get_one_data('answer_reply', '*', array('id' => $replyid));
        $a_id=$answer_reply['answer_id'];
        $answer= $this->get_one_data('answer', '*', array('id' => $a_id));
        $q_id=$answer['question_id'];
        $question= $this->get_one_data('question', '*', array('id' => $q_id));
        $this->set_vars('question',$question);
        $spid=$question['group_id'];
        $joined=$this->sport->sport_joined($spid,$this->uid); //判断是否加入
        if(!$joined){
            echo -2; //未加入
            exit;
        }
        $content=trim($_GET['content']);
        if(strlen($content)==0){
            echo 0; //信息不完整
            exit;

        }
        $arr=array('reply_id'=>$replyid,'uid'=>$this->uid,'body'=>$content,'ip'=>$this->get_ip(),'created_at'=>time(),'updated_at'=>time());
        $qid=$this->question_model->answer_reply_reply_add($arr);
        $this->question_model->answer_reply_set($replyid,'comments','comments+1');
        echo $qid; //成功
            exit;
      //  $this->load->helper("url");
       // redirect(WWW_domian."question/detail/{$q_id}");




    }



public function addFirst($id,$qid){
    if($this->uid==0){
        echo -1;
        exit;
    }
    $joined=$this->get('joined');
    if($joined==0){
        $this->sport->sport_join($id,$this->uid);
    }else{
        $this->sport->sport_unjoin($id,$this->uid);
    }
    $this->load->helper("url");

    redirect(WWW_domian."question/detail/{$qid}");
//echo $id;




}




public function answerDelete($id){
   echo $this->question_model->delete("answer",$id);
    exit;

}
    public function replyDelete($id){
        echo $this->question_model->delete("answer_reply",$id);
        exit;

    }
    public function replyRDelete($id){
        echo $this->question_model->delete("answer_reply_reply",$id);
        exit;

    }

public function answerModify($id){
$content=$this->get("content");

    if(strlen($content)==0)
    {
        echo -1;
        exit;

    }


   $this->question_model->modify("answer",$id,$content);
echo 1;
exit;
}

    public function replyModify($id){
        $content=$this->get("content");

        if(strlen($content)==0)
        {
            echo -1;
            exit;

        }


        $this->question_model->modify("answer_reply",$id,$content);
        echo 1;
        exit;
    }

    public function replyRModify($id){
        $content=$this->get("content");

        if(strlen($content)==0)
        {
            echo -1;
            exit;

        }


        $this->question_model->modify("answer_reply_reply",$id,$content);
        echo 1;
        exit;
    }


public function shanchu($id,$spid){


    $this->question_model->delete("question",$id);

    $this->load->helper("url");


    redirect(WWW_domian."sport/detail/spid/".$spid);
}

public function xiugai($id,$spid){
    $question= $this->get_one_data('question', '*', array('id' => $id));
    $sport= $this->get_one_data('sport', '*', array('spid' => $spid));
if($this->uid==$question["uid"]){
    $this->set_vars("sport",$sport);
    $this->set_vars("spid",$spid);
    $this->set_vars("title",$question['title']);

    $this->set_vars("body",$question['body']);
    $this->set_vars('question_id',$id);
$this->load->view("question/modify");
}
    else echo "您没有权限哦！"
;


}
    public function modifyajax($id,$question_id){
        if($this->uid==0){
            echo -1; //未登录
            exit;
        }
        $joined=$this->sport->sport_joined($id,$this->uid); //判断是否加入
        if(!$joined){
            echo -2; //未加入
            exit;
        }
        $title=trim($this->post('title'));
        $content=trim($this->post('content'));
        if(strlen($title)==0||strlen($content)==0){
            echo 0; //信息不完整
            exit;
        }

        $qid=$this->question_model->questionModify($question_id,$title,$content);
        echo $qid; //成功
       // echo $question_id;
        exit;
    }
//    public function fixOrientation($img_url) {
//
//        $exif = exif_read_data($img_url);
//        $orientation = $exif['Orientation'];
//        switch($orientation) {
//
//            case 6: // rotate 90 degrees CW
//                $this->image->rotateimage("#FFF", 90);
//                break;
//
//            case 8: // rotate 90 degrees CCW
//                $this->image->rotateimage("#FFF", -90);
//                break;
//
//        }
//
//    }















/*----------------------------------------------------------------------------------------------------------------*/















}