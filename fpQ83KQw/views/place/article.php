<?php $this->load->view('head_other', array('currentTab' => 1)); ?>
<!--destination-->
<div class="desti_wp">
    <div class="wp">
        <div class="l">
            <div class="desti_pos"><a href="<?= base_url() ?>">野孩子</a> > <a
                    href="<?= base_url("place") ?>">目的地</a>>
                <?php if($place['deep']!=1){?>
                    <?php foreach($top_parent as $k=>$v){
                        if($k>0){?>
                            <a href="<?php echo site_url('place/index/pid/'.$v[0])?>"><?=$v[1]?></a> >
                        <?php }
                    }?>
                <?php }?>
                <?=$place['name']?></div>
            <div class="desti_en"><?= $place['name_en'] ?></div>
            <div class="destin_ch"><?= $place['name'] ?></div>
        </div>
        <div class="r">
            <div class="desti_img">
                <?php $blnShow = $visit && $visit['planto'] == 1; ?>
                <span id="plan">
                        <a data-pid="<?= $place['pid'] ?>" data-type="plan" data-value="1" href="javascript:void(0);"
                           onclick="return false;" style="display:<?php echo $blnShow ? 'none' : '' ?>;">
                            <img src="<?= base_url("images/des_ico1.png") ?>">
                        </a>
                        <a data-pid="<?= $place['pid'] ?>" data-type="plan" data-value="0" href="javascript:void(0);"
                           onclick="return false;" style="display:<?php echo $blnShow ? '' : 'none' ?>;">
                            <img src="<?= base_url("images/des_ico12.png") ?>">
                        </a>
                    </span>
                <?php $blnShow = $visit && $visit['beento'] == 1; ?>
                <span id="been">
                        <a data-pid="<?= $place['pid'] ?>" data-type="been" data-value="1" href="javascript:void(0);"
                           onclick="return false;" style="display:<?php echo $blnShow ? 'none' : '' ?>;">
                            <img src="<?= base_url("images/des_ico2.png") ?>">
                        </a>
                        <a data-pid="<?= $place['pid'] ?>" data-type="been" data-value="0" href="javascript:void(0);"
                           onclick="return false;" style="display:<?php echo $blnShow ? '' : 'none' ?>;">
                            <img src="<?= base_url("images/des_ico22.png") ?>">
                        </a>
                    </span>
            </div>
            <div class="desti_all"><?php echo $sports_total; ?>个热门部落&nbsp; &nbsp; <?php echo $been_total;?>人去过这里&nbsp; &nbsp; <?php echo $comments_total; ?>条目的地点评</div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="desti_menu_wp">
    <?php  if($top=='country'){?>
        <?php  $this->load->view('place/top1',array('currentTab' => 13));?>
    <?php }else{?>
        <?php  $this->load->view('place/top2',array('currentTab' => 13));;?>
    <?php }?>
</div>
<div class="bg_f5">
    <div class="wp">
        <div class="l desti_left">
            <?php  $this->load->view('place/left');?>
        </div>
        <div class="r desti_right">
            <div class="desti_right_ban"><img src="<?php echo get_img_url($banner['img'],'828x315',2)?>"></div>
            <?php $this->load->view('share'); ?>
            <div class="desti_right_title">
                <div class="yjgl_ul">
                    <ul>
                        <?php if ($place_article) {
                        foreach ($place_article as $k => $v) {
                            ?>
                            <li>
                                <div class="yjgl_li_img l">
                                    <a href="<?php echo base_url('place/adetail/id/' . $v['id'].'/pid/'.$place['pid']) ?>" target="_blank"><img src="<?php echo get_img_url($v['img'],'194x130',10)?>"></a>
                                </div>
                                <div class="yjgl_li_txt l">
                                    <div class="yjgl_li_title l" style="margin-left: 0">
                                        <div class="yjgl_li_tit"><a href="<?= base_url('place/adetail/id/' . $v['id'].'/pid/'.$place['pid']) ?>" target="_blank"><?=$v['title']?></a></div>
                                        <div class="yjgl_li_tit_other">
                                            <span class="yjgl_li_tit_aut">作者：<font><?=$v['author']?></font></span>
                                            <span class="color_grey"><?=date('Y-m-d',$v['created'])?></span>
								<span class="yjglico">
									&nbsp;&nbsp;<img style="vertical-align:middle;" src="<?php echo base_url('images/yjgl1.jpg');?>" align="absmiddle" />&nbsp;<?=$v['hit']?>&nbsp;&nbsp;
								</span>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="yjgl_li_des"><?=messagecutstr($v['abstract'],260)?></div>
                                    <div class="yjgl_li_com">来自：<font><?=$v['fromwho']?></font> </div>
                                </div>
                                <div class="clear"></div>
                            </li>
                        <?php
                        }
                        }?>
                    </ul>
                </div>

                <div class="clear"></div>
            </div>
            <div class="page_link"><?= $pagelink ?></div>

        </div>
        <div class="clear"></div>
    </div>
</div>
<!--destination-->
<?php $this->load->view('foot'); ?>
<script type="text/javascript">
    function onSpClick(event) {
        var url, link = $(this);
        var pid = link.attr('data-pid');
        var type = link.attr('data-type');
        var value = link.attr('data-value');
        if (type == 'plan') {
            url = g_siteUrl + 'place/ajax_plan?pid=' + pid + '&plan=' + value;
        }
        if (type == 'been') {
            url = g_siteUrl + 'place/ajax_been?pid=' + pid + '&been=' + value;
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
</script>