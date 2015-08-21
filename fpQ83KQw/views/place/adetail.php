<?php $this->load->view('head_other', array('currentTab' => 1)); ?>
<!--destination-->
<div class="desti_wp">
    <div class="wp">
        <div class="l">
            <div class="desti_pos"><a href="<?= base_url() ?>">野孩子</a> > <a
                    href="<?= base_url("place") ?>">目的地</a>>
                <?php if($s_city && $l_place['deep']==1){?>
                    <a href="<?php echo site_url('place/index/pid/'.$s_city)?>"><?=$l_place['name']?></a> >
                <?php }?>
                <a href="<?php echo site_url('place/index/pid/'.$place['pid'])?>"><?=$place['name']?></a></div>
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
                <div class="wp" style="width: 827px; background-color: #fff">
                    <div class="destin_line_title"><span><?php echo $detail['title']; ?></span></div>
                    <div class="activity_art" style="width: 827px;">
                        <div class="content" style="padding:0 15px 15px 15px"><?php echo $detail['content'] ?></div>
                    </div>
                </div>

                <div class="clear"></div>
            </div>

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