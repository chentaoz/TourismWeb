<?php $this->load->view('head_other', array('currentTab' => 2)); ?>
<!--top-->
<!--activity-->
<div class="desti_wp activity_top">
    <div class="wp">
        <div class="l">
            <div class="desti_pos"><a href="<?= site_url() ?>">野孩子</a>><a
                    href="<?= site_url('sport') ?>">兴趣部落</a>><?= $detail['name'] ?>(<?= $detail['name_en'] ?>)
            </div>
            <div class="desti_en"><?= $detail['name_en'] ?></div>
            <div class="destin_ch"><?= $detail['name'] ?></div>
        </div>
        <div class="r">
            <div class="desti_img">
                <?php $blnShow = $visit && $visit['planto'] == 1; ?>
                <span id="plan">
                        <a data-pid="<?= $detail['spid'] ?>" data-type="plan" data-value="1" href="javascript:void(0);"
                           onclick="return false;" style="display:<?php echo $blnShow ? 'none' : '' ?>;">
                            <img src="<?= base_url("images/play_want.png") ?>">
                        </a>
                        <a data-pid="<?= $detail['spid'] ?>" data-type="plan" data-value="0" href="javascript:void(0);"
                           onclick="return false;" style="display:<?php echo $blnShow ? '' : 'none' ?>;">
                            <img src="<?= base_url("images/play_want2.png") ?>">
                        </a>
                    </span>
                <?php $blnShow = $visit && $visit['beento'] == 1; ?>
                <span id="been">
                        <a data-pid="<?= $detail['spid'] ?>" data-type="been" data-value="1" href="javascript:void(0);"
                           onclick="return false;" style="display:<?php echo $blnShow ? 'none' : '' ?>;">
                            <img src="<?= base_url("images/play_had.png") ?>">
                        </a>
                        <a data-pid="<?= $detail['spid'] ?>" data-type="been" data-value="0" href="javascript:void(0);"
                           onclick="return false;" style="display:<?php echo $blnShow ? '' : 'none' ?>;">
                            <img src="<?= base_url("images/play_had2.png") ?>">
                        </a>
                    </span>
            </div>
            <div class="desti_all"><?php echo $been_total; ?>人玩过&nbsp; &nbsp; <?php echo $plan_total;?>人想玩</div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="desti_menu_wp activity_menu_wp">
    <div class="wp">
        <ul>
            <li><a href="#desc">目的地</a></li>
            <li><a href="#guide">技术宝典 </a></li>
            <li><a href="#suite">装备清单</a></li>
            <li><a href="#note">相关游记</a></li>
            <div class="clear"></div>
        </ul>
    </div>
</div>
<div class="wp">
    <div class="actil l"><img
            src="<?= base_url() . $this->config->item('upload_place_sport') . '/' . $detail['banner'] ?>"
            width="710" height="390"></div>
    <div class="actir r">
        <div class="acti_all_pj">总体评价<span class="r"><img src="<?= base_url('images/green_s.png') ?>"/><img
                    src="<?= base_url('images/green_s.png') ?>"><img src="<?= base_url('images/green_s.png') ?>"><img
                    src="<?= base_url('images/green_s.png') ?>"></span></div>
        <div class="actir_tips">
            <?=$bag_count?>个野孩子的【<?= $detail['name'] ?>】背包<br>
            <?=$guide_count?>个【<?= $detail['name'] ?>】宝典<br>
            <?=$topic_count?>篇【<?= $detail['name'] ?>】帖子<br>
        </div>
        <div class="actir_tit">野孩子宝典</div>
        <?php if ($guide) { ?>
            <div class="actir_downlist">
                <div class="l"><a href="<?= site_url('guide/down/gid/' . $guide['gid']) ?>"><img
                        src="<?= base_url() . $this->config->item('upload_guide_image') . '/' . $guide['img'] ?>"></a></div>
                <div class="r">
                    <div class="actir_downlist_des">
                        <?= $guide['description'] ?>
                    </div>
                    <div class="act_down"><a
                            href="<?= site_url('guide/down/gid/' . $guide['gid']) ?>"><?= $guide['downs'] ?></a></div>
                </div>
                <div class="clear"></div>
            </div>
        <?php } ?>
    </div>
    <div class="clear"></div>
</div>
<div class="wp">
    <div class="activity_left_l l">
    
    <div class="activity_left_tit" ><a name="desc"></a>部落动态&nbsp; </div>
        <div class="activity_right_title">
            <script type="text/javascript" src="http://bbs.wildkid.co/api.php?mod=js&bid=3"></script>
        </div>
        <div class="clear"></div>
    
    
        <div class="activity_left_tit" ><a name="desc"></a><?= $detail['name'] ?><?= $detail['name_en'] ?>目的地推荐&nbsp; <a href="<?=site_url('map/'.$detail['spid'])?>">进入地图搜索</a></div>
        <div class="activity_right_title">
            <ul>
                <?php if ($place_rec) {
                    foreach ($place_rec as $k => $v) {
                        ?>
                        <li class="activity_right_imgbox <?php if($k%4==3){echo 'mar0';}?> l">
                            <div class="activity_right_imgbox_img" >
                                <a href="<?=base_url('place/index/pid/'.$v['pid'])?>">
                                    <img src="<?php echo get_img_url($v['img'],'230x230',2)?>"></a>
                            </div>
                            <div class="jstx_li_tit">
                                <a href="<?=base_url('place/index/pid/'.$v['pid'])?>"><?= $v['name'] ?></a>
                            </div>
                        </li>
                    <?php
                    }
                }?>
                <div class="clear"></div>
            </ul>
        </div>
        <div class="clear"></div>
        <div class="activity_left_tit"><a name=""></a><?= $detail['name'] ?><?= $detail['name_en'] ?>文摘</div>
        <div class="jstx_ul">
            <ul>
                <?php if($sport_news){?>
                 <?php foreach($sport_news as $key=>$sn):?>
                    <li>
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
        <div class="activity_left_tit" ><a name="suite"></a><?= $detail['name'] ?><?= $detail['name_en'] ?>背包清单
            <span class="bag_sc r" style="padding-top: 0">
                <?php if ($bag_termid) { ?>
                    <?php if($favorites_had){?>
                       <a href="javascript:void(0);">已收藏</a>
                    <?php }else{?>
                         <a href="<?=site_url('sport/bag_favorites/bagid/'.$bag_termid['term_id'].'/spid/'.$detail['spid'])?>">收藏背包</a>
                <?php }
                }?>
            </span>
        </div>
        <div class="acitvity_js">
            <div class="activity_js_left activity_js_tabbut2 l" style="display: none">
                <div class="activity_js_tab_on">所有</div>
                <div class="activity_js_tab">单身</div>
                <div class="activity_js_tab">小两口</div>
                <div class="activity_js_tab">带小孩</div>
                <div class="activity_js_tab">带老人</div>
                <div class="activity_js_tab">和朋友</div>
            </div>
            <div class="activity_js_right l" style="width: 684px">
                <div class="activity_js_con2" style="display:block;">
                    <ul class="bab_actlist">
                        <?php if ($bag) {
                            foreach ($bag as $k => $v) {
                                ?>
                                <li><img
                                        src="<?= base_url() . $this->config->item('upload_taxonomy') . '/' . $v['img'] ?>"><br><?= $v['name'] ?>
                                </li>
                            <?php
                            }
                        }?>
                        <div class="clear"></div>
                    </ul>
                    <div class="clear"></div>
                </div>


            </div>
            <div class="clear"></div>
        </div>
        <div class="activity_left_tit">
               <div class="sport_tab clear">
                <a name="note" href="javascript:;" class="thison"><?= $detail['name'] ?><?= $detail['name_en'] ?>游记 </a>
                <a name="guide" href="javascript:;"><?= $detail['name'] ?><?= $detail['name_en'] ?>技术</a>
               </div>
        </div>
        <div class="clear"></div>
        <div class="tab activity_right_title">
            <ul>
                <?php if($travel_notes){?>
                    <?php foreach($travel_notes as $key=>$g):?>
                        <li class="activity_right_imgbox <?php if($key%4==3){echo 'mar0';}?> l">
                            <div class="activity_right_imgbox_img" ><a target="_blank" href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$g['tid']?>">
                                    <img  style="max-height: 230px;" src="<?=BBS_domian?>data/attachment/forum/<?=$g['attachment']?>">
                                </a></div>
                            <div class="jstx_li_tit"><a target="_blank" href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$g['tid']?>"><?=$g['subject']?></a></div>
                        </li>
                    <?php endforeach?>
                <?php }else{?>
                    <li>暂无相关游记</li>
                <?php } ?>
                <div class="clear"></div>
            </ul>
        </div>
        <div class="tab activity_right_title" style="display:none">
            <ul>
                <?php if($guide_list){?>
                    <?php foreach($guide_list as $key=>$g):?>
                        <li class="activity_right_imgbox <?php if($key%4==3){echo 'mar0';}?> l">
                            <div class="activity_right_imgbox_img" ><a target="_blank" href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$g['tid']?>">
                                    <img  style="max-height: 230px;" src="<?=BBS_domian?>data/attachment/forum/<?=$g['attachment']?>">
                                </a></div>
                            <div class="jstx_li_tit"><a target="_blank" href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$g['tid']?>"><?=$g['subject']?></a></div>
                        </li>
                    <?php endforeach?>
                <?php }else{?>
                    <li>暂无相关技术贴士</li>
                <?php } ?>
                <div class="clear"></div>
            </ul>
        </div>
    </div>
    <div class="activity_right_r r">
        <div class="dr_tj">
            <div class="dr_tj_tit"><?= $detail['name'] ?>达人推荐</div>
            <?php foreach($top_threads_users as $lv){ ?>
            <div class="dr_tj_list">
                <div class="dr_tj_img l"><a href="<?=site_url('space/'.$lv['uid'])?>"><img src="<?=IMG_domian;?>avatar/<?=$lv['uid']?>"></a></div>
                <div class="dr_tj_oth l">
                    <div class="dr_tj_oth_name"><a href="<?=IMG_domian;?>avatar/<?=$lv['uid']?>"><?=$lv['username']?></a></div>
                </div>
                <div class="dr_tj_but r"><?php if($lv['gz']==0){?><a href="javascript:void(0);">已关注</a> <?php }else{?><a href="<?=site_url('sport/friend_add/fid/'.$lv['uid'].'/spid/'.$detail['spid'])?>">关注</a><?php }?></div>
                <div class="clear"></div>
            </div>
            <?php }?>

        </div>
        <div class="activity_common_r">
            <div class="activity_common_tit">目前最热门的兴趣</div>
            <div class="hot_playing">
                <?php if($every_play){?>
                    <?php foreach ($every_play as $s){ ?>
                        <p><span><a target="_blank" href="<?=site_url('sport/detail/spid/'.$s['sport_id'])?>"><img src="<?php echo base_url().'upload/sports_icon/'.$s['img']?>"></span><span class="b"><?php echo $s['name']?></span></a><span>(<em class="green"><?php echo $s['num']?>个野孩子玩过</em>)</span></p>
                    <?php }}?>
            </div>
        </div>
        <div class="activity_common_r">
            <div class="activity_common_tit">最新想<?= $detail['name'] ?>的野孩子</div>
            <ul class="activity_com_ul">
                <?php if ($plan_to) {
                    foreach ($plan_to as $k => $v) {
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
<!--activity-->
<?php $this->load->view('foot'); ?>
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
    })


</script>