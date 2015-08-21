<?php  $this->load->view('head_other',array('currentTab'=>1));?>
<!--destination-->
<div class="desti_wp">
    <div class="wp">
        <div class="l">
            <div class="desti_pos"><a href="<?=base_url()?>">野孩子</a> > <a href="<?=base_url("place")?>">目的地</a> >
                <?php if($s_city && $l_place['deep']==1){?>
                    <a href="<?php echo site_url('place/index/pid/'.$s_city)?>"><?=$l_place['name']?></a> >
                <?php }?>
                <?=$place['name']?>
            </div>
            <div class="desti_en"><?=$place['name_en']?></div>
            <div class="destin_ch"><?=$place['name']?></div>
        </div>
        <div class="r">
            <div class="desti_img">
                    <?php  $blnShow = $visit && $visit['planto']==1; ?>
                    <span id="plan">
                        <a data-pid="<?=$place['pid']?>" data-type="plan" data-value="1" href="javascript:void(0);" onclick="return false;" style="display:<?php echo $blnShow?'none':'' ?>;">
                            <img src="<?=base_url("images/des_ico1.png")?>">
                        </a>
                        <a data-pid="<?=$place['pid']?>" data-type="plan" data-value="0" href="javascript:void(0);" onclick="return false;" style="display:<?php echo $blnShow?'':'none' ?>;">
                            <img src="<?=base_url("images/des_ico12.png")?>">
                        </a>
                    </span>
                    <?php  $blnShow = $visit && $visit['beento']==1; ?>
                    <span id="been">
                        <a data-pid="<?=$place['pid']?>" data-type="been" data-value="1" href="javascript:void(0);" onclick="return false;" style="display:<?php echo $blnShow?'none':'' ?>;">
                            <img src="<?=base_url("images/des_ico2.png")?>">
                        </a>
                        <a data-pid="<?=$place['pid']?>" data-type="been" data-value="0" href="javascript:void(0);" onclick="return false;" style="display:<?php echo $blnShow?'':'none' ?>;">
                            <img src="<?=base_url("images/des_ico22.png")?>">
                        </a>
                    </span>
            </div>
            <div class="desti_all"><?php echo $sports_total; ?>个热门部落&nbsp; &nbsp; <?php echo $been_total;?>人去过这里&nbsp; &nbsp; <?php echo $comments_total; ?>条目的地点评</div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="desti_menu_wp">
    <?php if($place['deep']==1){?>
    <div class="wp">
        <ul>
            <li><a href="<?=site_url('place/city/pid/'.$place['pid'])?>">城市</a></li>
            <li><a href="<?=site_url('place/scenic/pid/'.$place['pid'])?>">景点</a></li>
            <li><a href="<?=site_url('place/sports/pid/'.$place['pid'])?>">户外活动</a></li>
            <?php if($place['gid']){?>
                <li><a href="<?= site_url('guide/detail/gid/' . $place['gid']) ?>">攻略</a></li>
            <?php }?>
            <li><a href="<?=site_url('place/picture/pid/'.$place['pid'])?>">图片</a></li>
            <li><a href="<?=site_url('place/comment/pid/'.$place['pid'])?>">点评</a></li>
            <li><a href="<?=site_url('place/bag/pid/'.$place['pid'])?>">背包</a></li>
            <div class="clear"></div>
        </ul>
    </div>
    <?php } ?>
    <?php if($place['deep']==2){?>
    <div class="wp">
        <ul>
            <li><a href="<?=site_url('place/scenic/pid/'.$place['pid'])?>">目的地</a></li>
            <li><a href="<?=site_url('place/sports/pid/'.$place['pid'])?>">户外活动</a></li>
            <?php if($place['gid']){?>
                <li><a href="<?= site_url('guide/detail/gid/' . $place['gid']) ?>">攻略</a></li>
            <?php }?>
            <li><a href="<?=site_url('place/picture/pid/'.$place['pid'])?>">图片</a></li>
            <li><a href="<?=site_url('place/comment/pid/'.$place['pid'])?>">点评</a></li>
            <li><a href="<?=site_url('place/bag/pid/'.$place['pid'])?>">背包</a></li>
            <div class="clear"></div>
        </ul>
    </div>
    <?php } ?>
</div>
<div class="bg_f5">
    <div class="wp">
        <div class="l desti_left">
            <div class="desti_left_count">共有<?=$total_deep3?>个目的地</div>
            <div class="desti_activi">
                <div class="desti_activi_tit">户外活动类型</div>
                <div class="desti_activis">
                    <ul>
                        <li class="desti_a1">
                            全部<span></span>
                            <div class="alert_box">
                                <?php if($sports){
                                    foreach($sports as $k=>$v){?>
                                        <div class="alert_box_list"><a href="<?=site_url('sport/detail/spid/'.$v['spid'])?>"><img src="<?=base_url().$this->config->item('upload_sports_icon').'/'.$v['img']?>" ><br><?=$v['name']?></a></div>
                                    <?php }
                                }?>
                                <div class="clear"></div>

                            </div>
                        </li>
                        <?php if($sport){
                            foreach($sport as $key=>$t){?>
                                <li class="desti_a1">
                                    <?=$t['name']?><span></span>
                                    <div class="alert_box">
                                        <?php if($t['child']){
                                            foreach($t['child'] as $s){?>
                                                <div class="alert_box_list"><a href="<?=site_url('sport/detail/spid/'.$s['spid'])?>"><img src="<?=base_url().$this->config->item('upload_sports_icon').'/'.$s['img']?>" ><br><?=$s['name']?></a></div>
                                            <?php }
                                        }?>
                                        <div class="clear"></div>
                                    </div>
                                </li>
                            <?php }
                        }?>
                        <div class="clear"></div>
                    </ul>
                </div>
                <script type="text/javascript">
                    $(".desti_activis li").each(function(i){
                        $(this).hover(function(){
                            $(this).children(".alert_box").show();
                            $(".alert_box").removeClass("desti_active_but");
                            $(this).addClass("desti_active_but");

                        },function(){
                            $(this).children(".alert_box").hide();
                            $(this).removeClass("desti_active_but");
                        })
                    })
                </script>
            </div>
            <div class="destin_plays">
                <div class="destin_plays_title">去过</div>
                <ul class="desti_ul">
                    <?php if($visit_had){
                        foreach($visit_had as $k=>$v){?>
                            <li>
                                <div class="member_common_pic"><a target="_blank" href="<?=site_url('space_spoor/'.$v['uid'])?>"><img
                                            src="<?=IMG_domian?>avatar/<?=$v['uid']?>"></a></div>
                                <div class="member_common_picname"><a target="_blank" href="<?=site_url('space_spoor/'.$v['uid'])?>"><?=$v['username']?></a></div>
                            </li>
                        <?php
                        }
                    }?>
                    <div class="clear"></div>
                </ul>
                <div class="destin_plays_title">想去</div>
                <ul class="desti_ul">
                    <?php if($visit_to){
                        foreach($visit_to as $k=>$v){?>
                            <li>
                                <div class="member_common_pic"><a target="_blank" href="<?=site_url('space_spoor/'.$v['uid'])?>"><img
                                            src="<?=IMG_domian?>avatar/<?=$v['uid']?>"></a></div>
                                <div class="member_common_picname"><a target="_blank" href="<?=site_url('space_spoor/'.$v['uid'])?>"><?=$v['username']?></a></div>
                            </li>
                        <?php
                        }
                    }?>

                    <div class="clear"></div>
                </ul>
            </div>
        </div>
        <div class="r desti_right">
            <div class="desti_right_ban"><img src="<?php echo get_img_url($banner['img'],'828x315',2)?>"></div>
            <?php $this->load->view('share'); ?>
            <div class="desti_right_title">
                <div class="l">不可不去</div>
                <div class="r"><?php if($place['deep']==2){?><a href="<?=site_url('place/scenic/pid/'.$place['pid'])?>"><?php }else{?><a href="<?=site_url('place/city/pid/'.$place['pid'])?>"><?php }?>查看更多</a></div>
                <div class="clear"></div>
                <?php if($place_must){
                    foreach($place_must as $k =>$v){
                        ?>
                        <div class="desti_right_imgbox <?php if($k==2){echo "mar12";}?> l">
                            <div class="desti_right_imgbox_img"><a href="<?=base_url('place/index/pid/'.$v['pid'])?>">
                                        <img src="<?php echo get_img_url($v['img'],'268x182',2)?>"></a></div>
                            <div class="desti_right_imgbox_txt"><a href=""><?=$v['name']?></a></div>
                        </div>
                    <?php
                    }
                }?>

                <div class="clear"></div>
            </div>
            <div class="desti_right_title">
                <div class="l">不可不玩</div>
                <div class="r"><a href="<?=site_url('place/sports/pid/'.$place['pid'])?>">查看更多</a></div>
                <div class="clear"></div>
                <?php if($sport_must){
                    foreach($sport_must as $k =>$v){
                        ?>
                        <div class="desti_right_imgbox <?php if($k==2){echo "mar12";}?> l">
                            <div class="desti_right_imgbox_img"><a href="<?php echo site_url('sport/detail/spid/'.$v['sport_id'])?>"><img src="<?php echo get_img_url($v['sportimg'],'268x182',2)?>"></a></div>
                            <div class="desti_right_imgbox_txt"><a href="<?php echo site_url('sport/detail/spid/'.$v['sport_id'])?>"><?=$v['name']?></a></div>
                        </div>
                    <?php
                    }
                }?>
                <div class="clear"></div>
            </div>
            <div class="desti_right_title">
                <div class="l">热门帖子</div>
                <div class="r"></div>
                <div class="clear"></div>
                <div class="yjgl_ul">
                    <ul>
                        <?php foreach($list_travel as $lv){ ?>
                            <li>
                                <div class="yjgl_li_img l"> <a href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$lv['tid']?>" target="_blank"><img src="<?=BBS_domian.'data/attachment/forum/'.$lv['attachment']?>"></a></div>
                                <div class="yjgl_li_txt l">
                                    <div class="author_img l"><img src="<?=IMG_domian?>avatar/<?=$lv['authorid']?>"></div>
                                    <div class="yjgl_li_title l">
                                        <div class="yjgl_li_tit"><a href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$lv['tid']?>" target="_blank"><?=$lv['subject']?></a></div>
                                        <div class="yjgl_li_tit_other">
                                            <span class="yjgl_li_tit_aut">作者：<a href="<?=base_url()?>space/<?=$lv['authorid']?>" target="_blank"><?=$lv['author']?></a></span>
                                            <span class="color_grey"<?=date('Y-m-d',$lv['dateline'])?></span>
									<span class="yjglico r">
										&nbsp;&nbsp;
										<img style="vertical-align:middle;" src="<?=base_url("images/view.jpg")?>" align="absmiddle" />&nbsp;<?=$lv['views']?>&nbsp;&nbsp;
										<img style="vertical-align:middle;" src="<?=base_url("images/yjgl2.jpg")?>" align="absmiddle" />&nbsp;<?=$lv['replies']?>&nbsp;
									</span>
                                        </div>
                                    </div>
                                    <div class="r star"><?=$lv['favtimes']?></div>
                                    <div class="clear"></div>
                                    <div class="yjgl_li_des"><?=messagecutstr($lv['message'],200)?></div>
                                </div>
                                <div class="clear"></div>
                            </li>
                        <?php }?>
                    </ul>
                </div>
            </div>

        </div>
        <div class="clear"></div>
    </div>
</div>
<!--destination-->
<?php  $this->load->view('foot');?>
<script type="text/javascript">
    function onSpClick(event) {
        var url, link = $(this);
        var pid = link.attr('data-pid');
        var type = link.attr('data-type');
        var value = link.attr('data-value');
        if (type=='plan') {
            url = g_siteUrl + 'place/ajax_plan?pid=' + pid + '&plan=' + value;
        }
        if (type=='been') {
            url = g_siteUrl + 'place/ajax_been?pid=' + pid + '&been=' + value;
        }

        $.ajax({
            url: url,
            dataType: 'json',
            success: function(res) {
                if (res.code == -1) {
                    location = res.url;
                } else {
                    link.parent().find('a').show();
                    link.parent().find('a[data-value="'+res+'"]').hide();
                }
            },
            error: function() {
                return false;
            }
        });
    }
    $(document).delegate('#plan a,#been a', 'click', onSpClick);
</script>

