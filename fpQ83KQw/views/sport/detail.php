<?php $this->load->view('head_other_v1', array('currentTab' => 2)); ?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/place.css">
<link rel="stylesheet" href="<?= WWW_domian ?>css/sport.css">
    <style>
        .activity_left_l {
            padding-left: 20px;
            padding-right: 20px;
        }
    </style>
    <!--main-->
    <div class="desti_title">
        <div class="wp clear">
            <div class="l des_tit_wd">
                <div class="desti_route">
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>">野孩子</a></li>
                        <li><a href="<?=site_url('sport') ?>">兴趣部落</a></li>
                        <li class="active"><?= $detail['name'] ?>(<?= $detail['name_en'] ?>)</li>
                    </ol>
                </div>
                <div class="desti_hd desti_en "><?= $detail['name_en'] ?>

                </div>
                <div class="desti_hd desti_ch "><?= $detail['name'] ?></div>
            </div>
            <!--注释掉 先玩，玩过的按钮 -->
            <div class="r des_tit_wd">
                <div class="desti_img">
                    <?php if($joined){ ?>

                        <button id="btnJoin" class="btn btn-warning btn-s" joined="1">
                            已是部落成员
                        </button>
                    <?php }else{ ?>
                        <button id="btnJoin" class="btn btn-success btn-s" joined="0">
                            加入部落
                        </button>
                    <?php } ?>

                    <a style="color: #fff;" href="<?=base_url()?>question/add/<?=$spid?>" class="btn btn-success btn-s">
                        提问</a>
                </div>
                <!-- <div class="desti_all"><?php// echo $been_total; ?>人玩过&nbsp; &nbsp; <?php //echo $plan_total;?>人想玩</div> -->
            </div>


            <!--注释结束 -->
        </div>
    </div>
    <div class="desti_menu_wp">
        <div class="wp">
            <ul class="nav nav-pills">
                <li role="presentation"><a href="#desc">目的地</a></li>
                <li role="presentation"><a href="#guide">技术宝典</a></li>
                <li role="presentation"><a href="#suite">装备清单</a></li>
                <li role="presentation"><a href="#note">相关游记</a></li>
            </ul>
        </div>
    </div>

    <div class="wp">

        <div class="actil l">
            <img src="<?= base_url() . $this->config->item('upload_place_sport') . '/' . $detail['banner'] ?>" >
        </div>
        <div class="actir r">
            <div class="acti_all_pj">
                <span>总体评价</span>
                <span class="r">
                    <img src="http://www.gowildkid.com/images/green_s.png"/>
                    <img src="http://www.gowildkid.com/images/green_s.png">
                    <img src="http://www.gowildkid.com/images/green_s.png">
                    <img src="http://www.gowildkid.com/images/green_s.png">
                </span>
            </div>
            <div class="actir_tips">
                <?=$bag_count?>个野孩子的【<?= $detail['name'] ?>】背包<br>
                <?=$guide_count?>个【<?= $detail['name'] ?>】宝典<br>
                <?=$topic_count?>篇【<?= $detail['name'] ?>】帖子<br>
            </div>

            <div class="actir_tit">野孩子互动</div>

            <div class="actir_downlist">
                <div>
                    <img src="http://www.gowildkid.com/images/qrcode.png">
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

<div class="wp">
    <div class="activity_left_l l">

        <div class="activity_left_tit" >
            <a style="color: #fff;" href="<?=base_url()?>question/index/<?=$spid?>" class="pull-right btn btn-success">
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

        <!--暂时注释掉目的地
        <div class="activity_left_tit" ><a name="desc"></a><? //= $detail['name'] ?><? //= $detail['name_en'] ?>目的地推荐&nbsp;
            <a class="act_map" href="<? //=site_url('map/'.$detail['spid'])?>">进入地图搜索</a></div>
        <div class="activity_right_title">
            <ul>
                <?php // if ($place_rec) {
        //foreach ($place_rec as $k => $v) {
        ?>
                        <li class="activity_right_imgbox <?php// if($k%3==2){echo 'mar0';}?> l">
                            <div class="activity_right_imgbox_img" >
                                <a href="<? //=base_url('place/index/pid/'.$v['pid'])?>">
                                    <img src="<?php //echo get_img_url($v['img'],'230x230',2)?>"></a>
                            </div>
                            <div class="jstx_li_tit">
                                <a href="<? //=base_url('place/index/pid/'.$v['pid'])?>"><? //= $v['name'] ?></a>
                            </div>
                        </li>
                    <?php
        // }
        //}?>
                <div class="clear"></div>
            </ul>
        </div>
        -->


        <div class="clear"></div>
        <div class="activity_left_tit"><a name=""></a><?= $detail['name'] ?><?= $detail['name_en'] ?>
            文摘
            <a target="_blank" href="<?=site_url('sport/cate/'.$spid.'/'.$detail['name_en'].'/'.$detail['name'])?>" class="pull-right" style="font-size: 0.6em;">/阅读更多.../</a>
        </div>

        <div class="jstx_ul">
            <ul>
                <?php if($sport_news){?>
                    <?php foreach($sport_news as $k=>$sn):?>
                <li class="activity_right_imgbox <?php if($k%3==2){echo 'mar0';}?> l">
                    <div class="activity_right_imgbox_img" >
                        <a target="_blank" href="<?php echo site_url('sport/news_show/id/'.$sn['id']);?>">
                            <img src="<?php echo get_img_url($sn['img'],'230x230',10)?>">
                        </a></div>
                    <div class="jstx_li_tit"><a target="_blank" href="<?php echo site_url('sport/news_show/id/'.$sn['id']);?>"><?=$sn['title']?></a></div>
                </li>
                <?php endforeach?>
                <?php }else{?>
                    <li>暂无相关数据</li>
                <?php } ?>
                <div class="clear"></div>
            </ul>
        </div>
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
            <div class="activity_common_tit">最新加入<?= $detail['name'] ?>部落的野孩子</div>
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
    <!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    function onSpClick(event) {
        var url, link = $(this);
        var pid = link.attr('data-pid');
        var type = link.attr('data-type');
        var value = link.attr('data-value');
        if (type == 'plan') {
            url = g_siteUrl + 'sport/ajax_plan?spid=' + pid + '&plan=' + value;
        }
        if (type == 'been') {
            url = g_siteUrl + 'sport/ajax_been?spid=' + pid + '&been=' + value;
        }

        $.ajax({
            url: url,
            dataType: 'json',
            success: function (res) {
                if (res.code == -1) {
                    location = res.url;
                } else {
                    link.parent().find('a').show();
                    link.parent().find('a[data-value="' + res + '"]').hide();
                }
            },
            error: function () {
                return false;
            }
        });
    }
    $(document).delegate('#plan a,#been a', 'click', onSpClick);
    //切换样式
    $(".sport_tab a").each(function(i){
        $(this).mouseover(function(){
            $(".sport_tab a").removeClass("thison");
            $(this).addClass("thison");
            $(".tab").hide();
            $(".tab").eq(i).show();
        })
    });
    $(function(){
        $("#btnJoin").click(function(){
            var joined=$(this).attr('joined');
            var url=g_siteUrl+'sport/join/<?=$spid?>';
            $.ajax({
                url: url,
                data:'joined='+joined,
                dataType: 'json',
                success: function (res) {
                    if(res>0){
                        if(joined=='0'){
                            $("#btnJoin").attr('joined','1').removeClass('btn-success').addClass('btn-warning').empty().html('已是部落成员');
                        }else{
                            $("#btnJoin").attr('joined','0').removeClass('btn-warning').addClass('btn-success').empty().html('加入部落');
                        }
                    }else if(res==0){
                        alert('信息不完整');
                    }else if(res==-1){
                        window.location.href="<?=PASSPORT_domian?>oauth/login?reurl="+encodeURIComponent(location.href);
                    }
                },
                error: function () {
                }
            });
        });
    });
</script>
