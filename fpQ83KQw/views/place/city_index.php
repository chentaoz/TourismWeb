<?php  $this->load->view('head_other_v1',array('currentTab'=>1));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/place.css">
<!--main-->
<div class="desti_title">
    <div class="wp clear">
        <div class="l des_tit_wd">
            <div class="desti_route">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url()?>">野孩子</a></li>
                    <li><a href="<?=base_url("place")?>">目的地</a></li>
                    <?php foreach($top_parent as $k=>$v){
                        if($k>0){?>
                    <li><a href="<?php echo site_url('place/index/pid/'.$v[0])?>"><?=$v[1]?></a></li>
                        <?php }
                    }?>
                    <li class="active"><a href="<?=site_url('/place/index/pid/'.$place['pid'])?>"><?=$place['name']?></a></li>
                </ol>
            </div>
            <div class="desti_hd desti_en "><a href="<?=site_url('/place/index/pid/'.$place['pid'])?>"><?=$place['name_en']?></a></div>
            <div class="desti_hd desti_ch "><a href="<?=site_url('/place/index/pid/'.$place['pid'])?>"><?=$place['name']?></a></div>
        </div>
        <div class="r des_tit_wd">
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
            <div class="desti_all"><span><?php echo $sports_total; ?></span>个热门部落&nbsp; &nbsp;
                <span><?php echo $been_total;?></span>人去过这里&nbsp; &nbsp;
                <span><?php echo $comments_total;?></span>条目的地点评
            </div>
        </div>
    </div>
</div>
<div class="desti_menu_wp">
    <?php  $this->load->view('place/top2');?>
</div>
<div class="bg_f5">
    <div class="wp">

        <div class="l desti_left">
            <?php  $this->load->view('place/left');?>
        </div>

        <div class="r desti_right">
            <div class="desti_right_ban">
                <img src="<?php echo get_img_url($banner['img'],'828x315',2)?>">
            </div>
            <?php $this->load->view('share'); ?>
            <div class="desti_right_title">
                <div class="clear">
                    <div class="l">不可不去</div>
                    <div class="r more_text"><a href="<?=site_url('place/scenic/pid/'.$place['pid'])?>">查看更多</a></div>
                </div>
                <?php if($place_must){
                    foreach($place_must as $k =>$v){ ?>
                        <div class="desti_right_imgbox <?php if($k%3==2){echo "mar12";}?> l">
                            <div class="desti_right_imgbox_img"><a href="<?=base_url('place/index/pid/'.$v['pid'])?>"><img src="<?php echo get_img_url($v['img'],'268x182',2)?>"></a></div>
                            <div class="desti_right_imgbox_txt less_tit"><a href="<?=base_url('place/index/pid/'.$v['pid'])?>"><?=$v['name']?></a></div>
                        </div>
                    <?php
                    }
                }?>
                <div class="clear"></div>
            </div>

            <div class="desti_right_title">
                <div class="more_title clear">
                    <div class="l">相关文章</div>
                    <div class="r more_text"><a href="<?=site_url('place/article/pid/'.$place['pid'])?>">查看更多</a></div>
                </div>
                <?php if($rele_article){
                    foreach($rele_article as $k =>$v){ ?>
                        <div class="desti_right_imgbox <?php if($k%3==2){echo "mar12";}?> l">
                            <div class="desti_right_imgbox_img"><a href="<?php echo site_url('place/adetail/id/'.$v['id'].'/pid/'.$place['pid'])?>" target="_blank"><img src="<?php echo get_img_url($v['img'],'268x182',10)?>"></a></div>
                            <div class="desti_right_imgbox_txt"><a href="<?php echo site_url('place/adetail/id/'.$v['id'].'/pid/'.$place['pid'])?>" target="_blank"><?=$v['title']?></a></div>
                        </div>
                    <?php
                    }
                }?>
                <div class="clear"></div>
            </div>

            <div class="desti_right_title">
                <div class="clear">
                    <div class="l">热门帖子</div>
                    <div class="r"></div>
                </div>
                <div class="hot_art clear">
                    <ul>
                        <?php foreach($list_travel as $lv){ ?>
                            <li class="clear">
                                <div class="art_img l">
                                    <a href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$lv['tid']?>" target="_blank">
                                        <img src="<?=BBS_domian.'data/attachment/forum/'.$lv['attachment']?>">
                                    </a>
                                </div>
                                <div class="art_text l">
                                    <div class="art_tit clear">
                                        <div class="art_tit_img l"><img src="<?=IMG_domian?>avatar/<?=$lv['authorid']?>"></div>
                                        <div class="art_tit_title r">
                                            <div class="art_tit_title_h1">
                                                <a href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$lv['tid']?>" target="_blank"><?=$lv['subject']?></a>
                                            </div>
                                            <div class="art_tit_title_author">
                                                <span class="tit_aut">作者：</span>
                                                <span class="tit_name"><a href="<?=base_url()?>space/<?=$lv['authorid']?>" target="_blank"><?=$lv['author']?></a></span>
                                                <span class="tit_ico r">
                                                     &nbsp;&nbsp;
                                                    <img style="vertical-align:middle;" src="http://www.gowildkid.com/images/view.jpg" align="absmiddle" />&nbsp;<?=$lv['views']?>&nbsp;&nbsp;
                                                    <img style="vertical-align:middle;" src="http://www.gowildkid.com/images/yjgl2.jpg" align="absmiddle" />&nbsp;<?=$lv['replies']?>&nbsp;
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="art_content"><p><?=messagecutstr($lv['message'],200)?></p></div>
                                </div>
                                <div class="art_ico r">
                                    <span><?=$lv['favtimes']?></span>
                                </div>
                            </li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
        <!--介绍-->
    </div>
    <div class="clear"></div>
</div>
</div>
<!--main-->
<?php  $this->load->view('foot_v1');?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
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
</body>
</html>

