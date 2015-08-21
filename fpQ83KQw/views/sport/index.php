<?php $this->load->view('head_other_v1', array('currentTab' => 2)); ?>
<link href="<?=base_url()?>css/diaporama/style.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>css/picscroll.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= WWW_domian ?>css/sport.css">
<style type="text/css">
    .activity_left_l {
        padding-left: 20px;
        padding-right: 20px;
    }
    .tip_schlay {
        position: relative;
        z-index: 99;
        border: 1px solid #c0c0c0;
        background: #fff;
    }
    .tip_schlay ul {
        width: 100%;
        overflow: hidden;
    }
    .tip_schlay li {
        width: 100%;
        overflow: hidden;
        border-bottom: 1px solid #ececec;
    }
    .highlight {
        background: #e0f1df;
    }
    .tip_schlay li a {
        display: block;
        height: 32px;
        overflow: hidden;
        padding: 0 10px;
        line-height: 32px;
        color: #323232;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>
<!--main-->
<div class="sport">
    <div class="destination_bg">
        <div class="destin_ser">
            <div class="destin_ser_ad">唤醒心中的野孩子！</div>
            <div class="destin_form">
                <div class="destin_ser_input" id="destin_ser_input">
                    <form target="_blank" onsubmit="return false;">
                        <input type="text" id="search-box" placeholder="搜索部落" class="destin_input l"
                               autocomplete="off"/>
                        <input type="button" id="search-btn" value="" class="desti_sersub l"/>
                        <div class="clear"></div>
                    </form>
                    <div id="tipsList" class="tip_indschlay tip_schlay" style="display: none;">
                    </div>
                </div>
                <div class="destin_ser_hot">热门部落：
                    <?php foreach($hot_sport as $h){?>
                        <a target="_blank" href="<?=site_url('sport/detail/spid/'.$h['spid'])?>"><?php echo $h['name']?></a>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <div class="wp wp-pdd">
        <div class="top-ico-navs">
            <?php foreach($sport_cate as $s){?>
                <div class="top_ico_nav l">
                    <a href="<?=site_url('sport/detail/spid/'.$s['spid'])?>">
                        <img src="<?=base_url().$this->config->item('upload_sports_icon').'/'.$s['img']?>" width="45" height="44">
                        <br><?=$s['name']?>
                    </a>
                </div>
            <?php } ?>
            <?php if(count($sport_cate)>11){?>
                <div class="top_ico_nav l"><a href="javascript:;"><img src="<?=base_url().'images/tmore.png'?>"></a></div>
            <?php }?>
           <div class="clear"></div>
        </div>
    </div>
    <!--ban-->
    <div class="index_ban" style="margin-bottom: 0;">
        <div class="wp">
            <div class="index_ban_left l">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php foreach ($banner as $k=>$b){ ?>
                            <li data-target="#carousel-example-generic" data-slide-to="<?=$k?>" <?php if($k==0){ echo 'class="active"';}?>>
                            </li>
                        <?php } ?>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php foreach ($banner as $k=>$b){ ?>
                            <div class="item<?php if($k==0){ echo ' active';}?>">
                                <img src="<?= base_url() . $this->config->item('upload_ad') . '/' . $b['img'] ?>" alt="">
                                <a href="<?php echo $b['weblink']?$b['weblink']:'javascript:;'; ?>"><div class="carousel-caption">
                                    </div></a>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="index_ban_right r">
                <div class="ban_right mtop_15 activities"><?php echo $forum_num['sport'];?> 种户外活动</div>
                <div class="ban_right  bag"><?php echo $forum_num['total_des'];?> 个目的地</div>
                <div class="ban_right bag"><?php echo $forum_num['bag'];?> 个背包</div>
                <div class="ban_right tieshi"><?=$forum_num['guide_num'];?> 篇技术宝典</div>
                <div class="ban_right raiders"><?=$forum_num['travel_num'];?> 篇旅行游记</div>
                <div class="ban_right post"><?=$forum_num['post_num'];?> 篇帖子</div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <!--ban-->
    <div class="wp">
        <div class="activity_left_l l">

            <div class="activity_left_tit" >
                <a style="color: #fff;" href="<?=base_url()?>question/plist" class="pull-right btn btn-success">
                    <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> 查看更多有意思的问题</a>
                部落问答&nbsp; </div>
            <div class="activity_right_title">
                <div class="module cl">
                    <ul>
                        <?php if($question_list){ foreach($question_list as $item){ ?>
                            <li style="padding:10px 0; border-bottom:1px solid #f1f1f1">
                        <span class="pull-right text-muted">
                                <?=date('Y-m-d h:i',$item['created'])?></span>
                        <span style="font-size:14px; margin:5px 20px 5px 0">
                                <a href="<?=site_url() ?>question/detail/<?=$item['id']?>"><?=$item['title']?></a>

                        </span>
                                <span class="author_img_s">[ <a href="<?=site_url('space')?>/<?=$item['uid']?>"><?=$item['username']?></a> ]</span> &nbsp;
                                <!--                        <img src="http://www.gowildkid.com/images/yjgl1.jpg">-->
                                <span class="glyphicon glyphicon-eye-open text-muted" aria-hidden="true"></span> <?=$item['hits']?> &nbsp;
                                <!--                        <img src="http://www.gowildkid.com/images/yjgl2.jpg">-->
                                <span class="glyphicon glyphicon-comment text-muted" aria-hidden="true"></span> <?=$item['comments']?>
                            </li>
                        <?php }}else{ ?>
                            <li>
                                <p>还没有人提问哦~
                                    <a style="color: #fff;" href="<?=base_url()?>question/add/<?=$spid?>" class="btn btn-success btn-xs">
                                        发布新提问</a>
                                </p>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <div class="activity_right_r r">
            <div class="activity_common_r">
                <div class="activity_common_tit">部落专家</div>
                <ul class="activity_com_ul">
                    <?php if ($top_threads_users) {
                        foreach ($top_threads_users as $k => $v) {
                            ?>
                            <li><a href="<?=site_url('space/'.$v['uid'])?>">
                                    <img src="<?=IMG_domian;?>avatar/<?=$v['uid']?>">
                                    <br><?= $v['username'] ?></a></li>
                        <?php
                        }
                    }?>
                    <div class="clear"></div>
                </ul>
            </div>
            <div class="activity_common_r">
                <div class="activity_common_tit">最热门的部落</div>
                <div class="hot_playing">
                    <?php if($every_play){?>
                    <?php foreach ($every_play as $s){ ?>
                    <p><span><a target="_blank" href="<?=site_url('sport/detail/spid/'.$s['spid'])?>">
                                <img src="<?php echo base_url().'upload/sports_icon/'.$s['img']?>"></span>
                        <span class="b"><?php echo $s['name']?></span></a><span>(<em class="green"><?php echo $s['joined_count']?>个野孩子加入</em>)</span>
                    </p>
                    <?php }}?>
                </div>
            </div>
            <div class="activity_common_r">
                <div class="activity_common_tit">最新加入部落的野孩子</div>
                <ul class="activity_com_ul">
                    <?php if ($recent_join_users) {
                    foreach ($recent_join_users as $k => $v) {
                    ?>
                    <li><a href="<?=site_url('space/'.$v['uid'])?>">
                            <img src="<?=IMG_domian;?>avatar/<?=$v['uid']?>">
                            <br><?= $v['username'] ?></a></li>
                    <?php
                    }
                    }?>
                    <div class="clear"></div>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="wp pdd-b12">
    <div class="tab-title"><span><a href="/sport/c/4">热门户外运动</a></span></div>
    <div class="activity_art">
        <div class="picScroll-left" id="picScroll-left">
            <div class="bd">
                <ul class="picList">
                    <?php if($sport_focus){
                        foreach($sport_focus as $k=>$v){?>
                            <li class="pd10">
                                <div class="pic"><a href="<?php echo site_url('sport/news_show/id/'.$v['id']);?>" target="_blank"><img src="<?php echo get_img_url($v['img'],'331x179',10)?>"/></a></div>
                                <div class="title"><a href="<?php echo site_url('sport/news_show/id/'.$v['id']);?>" target="_blank"><?php echo $v['title'];?></a></div>
                                <div class="des"><?php echo $v['abstract'];?></div>
                            </li>
                        <?php }
                    }?>
                </ul>
            </div>
            <div class="hd">
                <a class="prev"></a>
                <ul></ul>
                <a class="next"></a>
            </div>
        </div>
    </div>

    <div class="tab-title"><span>
            <a href="/sport/c/5">身边的野孩子</a>
        </span></div>
    <div class="activity_art">
        <div class="picScroll-left" id="picScroll-left2">
            <div class="bd">
                <ul class="picList">
                    <?php if($interview_focus){
                        foreach($interview_focus as $k=>$v){?>
                            <li  class="pd10">
                                <div class="pic"><a href="<?php echo site_url('sport/news_show/id/'.$v['id']);?>" target="_blank"><img src="<?php echo get_img_url($v['img'],'331x179',10)?>"/></a></div>
                                <div class="title"><a href="<?php echo site_url('sport/news_show/id/'.$v['id']);?>" target="_blank"><?php echo $v['title'];?></a></div>
                                <div class="des"><?php echo $v['abstract'];?></a></div>
                            </li>
                        <?php }
                    }?>
                </ul>
            </div>
            <div class="hd">
                <a class="prev"></a>
                <ul></ul>
                <a class="next"></a>
            </div>
        </div>
    </div>

    <div class="tab-title"><span><a href="/sport/c/6">技术小帖士</a></span></div>
    <div class="activity_art">
        <div class="picScroll-left" id="picScroll-left3">
            <div class="bd">
                <ul class="picList">
                    <?php if($tips_focus){
                        foreach($tips_focus as $k=>$v){?>
                            <li class="pd10" >
                                <div class="pic"><a href="<?php echo site_url('sport/news_show/id/'.$v['id']);?>" target="_blank"><img src="<?php echo get_img_url($v['img'],'331x179',10)?>"/></a></div>
                                <div class="title"><a href="<?php echo site_url('sport/news_show/id/'.$v['id']);?>" target="_blank"><?php echo $v['title'];?></a></div>
                                <div class="des"><?php echo $v['abstract'];?></div>
                            </li>
                        <?php }
                    }?>
                </ul>
            </div>
            <div class="hd">
                <a class="prev"></a>
                <ul></ul>
                <a class="next"></a>
            </div>
        </div>
    </div>
</div>
    <!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('#search-btn').click(function(){
            var $link=$('#tipsList ul li a');
            if($link.length>0){window.location.href="<?=site_url('')?>"+$link.attr('href');}
        });
    });
</script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/diaporama/jquery.jDiaporama.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".diaporama1").jDiaporama({
                animationSpeed: "slow",
                delay:4
            });
        });
    </script>
    <script id="jsID" type="text/javascript">
        if(!$(".picScroll-left .hd").is(":hidden")){
            var ary = location.href.split("&");
            jQuery("#picScroll-left").slide({titCell: ".hd ul", mainCell: ".bd ul", autoPage: true, effect: "left", scroll: 3, vis: 3});
        }

    </script>
    <script id="jsID2" type="text/javascript">
        if(!$(".picScroll-left .hd").is(":hidden")){
            var ary = location.href.split("&");
            jQuery("#picScroll-left2").slide({titCell: ".hd ul", mainCell: ".bd ul", autoPage: true, effect: "left", scroll: 3, vis: 3});
        }
    </script>
    <script id="jsID3" type="text/javascript">
        if(!$(".picScroll-left .hd").is(":hidden")){
            var ary = location.href.split("&");
            jQuery("#picScroll-left3").slide({titCell: ".hd ul", mainCell: ".bd ul", autoPage: true, effect: "left", scroll: 3, vis: 3});
        }
    </script>
</body>
</html>
