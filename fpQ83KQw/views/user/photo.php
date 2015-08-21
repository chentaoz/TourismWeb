<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--main-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>5));?>
    <!--照片-->
    <div class="member_myphoto">
        <div class="myphoto_title">
            <a class="photo_on" href="<?=site_url('user/photo')?>"><?php if($space && $space=='space'){echo 'Ta';}else{echo '我';}?>的照片</a>

        </div>
        <?php if($year){?>
            <?php foreach($year as $y):?>
                <div class="destin_line_title"><span><?=$y['year']?>年</span></div>
                <div class="my_photo">
                    <ul>
                        <?php foreach ($y['mounth'] as $key=>$m){?>
                            <li>
                                <div class="big_photo"><a class='light_box' href="<?=site_url('user/photo_detail/'.$y['year'].'/'.$m['m'].'/'.$header_info['uid'].'?lightbox[iframe]=true&lightbox[width]=1150&lightbox[height]=650')?>">
                                        <img src="<?php echo get_img_url($m['filename'],'234x234',8)?>";>
                                    </a>
                                </div>
                                <div class="photo_month"><?=$m['m'].'月 共'. $m['num'] .'张 '?>  </div>
                            </li>
                        <?php }?>
                        <div class="clear"></div>
                    </ul>
                </div>
            <?php endforeach ?>
        <?php }else{?>
            <div class="nofino"><img src="<?php echo base_url('images/noinfo.png');?>"><br>这家伙太懒了，什么都没留下！</div>
        <?php }?>
    </div>
    <!--照片-->

</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
//    $(function($){
//        $('.light_box').lightbox();
//    });
</script>
</body>
</html>