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
    <?php  if($top=='country'){?>
        <?php  $this->load->view('place/top1',array('currentTab' => 16));?>
    <?php }else{?>
        <?php  $this->load->view('place/top2',array('currentTab' => 16));?>
    <?php }?>
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
            <div class="desti_bag_list">
                <ul>
                    <?php if ($place_bag) {
                        foreach ($place_bag as $k => $v) {
                            ?>
                            <li>
                                <div class="desti_bag_list_img l"><a href="<?=site_url()?>space/<?=$v['cuid']?>" target="_blank"><img
                                            src="<?= IMG_domian ?>avatar/<?= $v['cuid'] ?>"><br><?= $v['username'] ?></a>
                                </div>
                                <div class="desti_bag_list_txt l">
                                    <div class="desti_bag_list_text">
                                        背包名称：<?= $v['title'] ?><br>
                                        创建时间：<?= date('Y-m-d', $v['created']) ?><br>
                                        收藏人数：<?= $v['favorites_num'] ?>
                                    </div>
                                    <div class="desti_bag_list_but">
                                        <?php if ($v['had'] == 1) { ?>
                                            <a href="javascript:void(0);">已收藏</a>
                                        <?php } else { ?>
                                            <a href="<?= site_url('place/bag_favorites/bagid/' . $v['id'] . '/pid/' . $place['pid']) ?>">收藏</a>
                                        <?php } ?>
                                        <a id="idBoxOpen" href="javascript:void(0)" onclick="bag_detail('<?=site_url('place/ajax_bag/'.$v['id'])?>')">详情</a>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </li>
                        <?php
                        }
                    }?>

                    <div class="clear"></div>
                </ul>
            </div>
            <div class="page_link"><?= $pagelink ?></div>

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
<script>
    function bag_detail(url){
        $.layer({
            type: 2,
            shadeClose: true,
            title: false,
            closeBtn: [0, true],
            shade: [0.8, '#000'],
            border: [0],
            offset: ['190px',''],
            area: ['800px', ($(window).height() - 370) +'px'],
            iframe: {src: url}
        })
    }
</script>
</body>
</html>