<?php  $this->load->view('head');?>
<?php  $this->load->view('top_index');?>
<link href="<?=base_url()?>css/diaporama/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=base_url()?>js/diaporama/jquery.jDiaporama.js"></script>
<!--ban-->
<div class="index_ban">
    <div class="wp">
        <div class="index_ban_left l">
            <!--ban js css-->
            <ul class="diaporama1">
                <?php foreach ($banner as $b): ?>
                    <li><a href="<?php echo $b['weblink']?$b['weblink']:'javascript:;'; ?>"><img src="<?= base_url() . $this->config->item('upload_ad') . '/' . $b['img'] ?>" alt="" title="" /></a></li>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="index_ban_right r">
            <div class="ban_right mtop_15 bag"><?php echo $forum_num['bag'];?> 个背包</div>
            <div class="ban_right tieshi"><?=$forum_num['guide_num'];?> 篇技术攻略</div>
            <div class="ban_right raiders"><?=$forum_num['travel_num'];?> 篇旅行游记</div>
            <div class="ban_right post"><?=$forum_num['post_num'];?> 篇帖子</div>
            <div class="ban_right activities"><?php echo $forum_num['sport'];?> 个活动</div>
            <div class="index_mobile">
                <div class="index_mobile_tit">野孩子移动应用</div>
                <div class="index_mobile_img">
                    <ul>
                        <li><img src="images/IPHONE.png"><br />iPhone</li>
                        <li><img src="images/android.png"><br />Android</li>
                        <li><img src="images/ipad.png"><br />iPad</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!--ban-->

<!--main-->
<div class="wp">
    <div class="index_main_left mtop_30 l">

        <div class="common_title  mtop_30">最新游记&nbsp; <span class="color_yel">&gt;&gt;</span><a href="<?=BBS_domian?>">更多</a></div>
        <div class="yjgl_ul">
            <ul>
                <?php foreach($list_travel as $lv){ ?>
                <li>
                    <div class="yjgl_li_img l">
                        <a href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$lv['tid']?>"><img src="<?=BBS_domian.'data/attachment/forum/'.$lv['attachment']?>"></a>
                    </div>
                    <div class="yjgl_li_txt l">
                        <div class="author_img l"><a href="<?=base_url()?>space/<?=$lv['authorid']?>" target="_blank"><img src="<?=IMG_domian;?>avatar/<?=$lv['authorid']?>"></a></div>
                        <div class="yjgl_li_title l">
                            <div class="yjgl_li_tit"><a href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$lv['tid']?>"><?=$lv['subject']?></a></div>
                            <div class="yjgl_li_tit_other">
                                <span class="yjgl_li_tit_aut">作者：<font><a href="<?=base_url()?>space/<?=$lv['authorid']?>" target="_blank"><?=$lv['author']?></a></font></span>
                                <span class="color_grey"><?=date('Y-m-d',$lv['dateline'])?></span>
								<span class="yjglico">
									&nbsp;&nbsp;<img style="vertical-align:middle;" src="images/yjgl1.jpg" align="absmiddle" />&nbsp;<?=$lv['views']?>&nbsp;&nbsp;
									<img style="vertical-align:middle;" src="images/yjgl2.jpg" align="absmiddle" />&nbsp;<?=$lv['replies']?>&nbsp;&nbsp;
									<img style="vertical-align:middle;" src="images/yjgl3.jpg" align="absmiddle" />&nbsp;<?=$lv['favtimes']?>&nbsp;
								</span>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="yjgl_li_des"><?=messagecutstr($lv['message'],260)?></div>
                        <div class="yjgl_li_com">来自：<font><a href="<?=BBS_domian?>forum.php?mod=forumdisplay&fid=<?=$lv['fid']?>"><?=$lv['name']?></a></font> 版</div>
                    </div>
                    <div class="clear"></div>
                </li>
                <?php }?>
            </ul>
        </div>
    </div>
    <div class="index_main_right mtop_30 r">
        <div class="common_title">每日光荣榜</div>
        <div class="day_honnor mtop_25">
            <div class="l">最佳写作者</div>
            <div class="r">游记被回复最多</div>
            <div class="clear"></div>
        </div>
        <?php foreach($top_threads_users as $lv){ ?>
        <div class="author_img l">
            <a href="<?=IMG_domian;?>space/<?=$lv['uid']?>">
                <img src="<?=IMG_domian;?>avatar/<?=$lv['uid']?>" alt="<?=$lv['username']?>">
            </a>
        </div>
        <?php }?>
        <div class="clear"></div>
        <div class="day_honnor mtop_15">
            <div class="l">最乐于助人</div>
            <div class="r">回帖最多</div>
            <div class="clear"></div>
        </div>
        <?php foreach($top_posts_users as $lv){ ?>
            <div class="author_img l">
                <a href="<?=IMG_domian;?>space/<?=$lv['uid']?>">
                    <img src="<?=IMG_domian;?>avatar/<?=$lv['uid']?>" alt="<?=$lv['username']?>">
                </a>
            </div>
        <?php }?>
        <div class="clear"></div>
        <div class="mtop_30 weixin"><img src="images/wx.jpg"></div>
    </div>
    <div class="clear"></div>
</div>
<!--main-->
<?php  $this->load->view('foot');?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".diaporama1").jDiaporama({
            animationSpeed: "slow",
            delay:4
        });
    });
</script>