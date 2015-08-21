<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--member-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>0));?>
    <?php if(!$space && $space!='space'){?>
    <?php  $this->load->view('user_left_menu',array('left_currentTab'=>3));?>
    <?php }?>
    <div class="user_right r"  <?php if($space && $space=='space'){echo "style='width:100%;padding-right: 0px'";}?> >
        <div class="user_right_tit">
            <div class="user_right_title l"><?php if(!$space && $space!='space'){echo '我';}else{echo 'TA';}?>的粉丝</div>
            <div class="fans_r r">共<?=$fans_num?>个</div>
            <div class="clear"></div>
        </div>
        <div class="fans" <?php if($space && $space=='space'){echo "style='width:90%'";}?>>
         <?php if($fans){?>
            <?php foreach($fans as $f):?>
            <div class="fans_list">
                <div class="fans_img l"><a href="<?php echo site_url('space/'.$f['uid'])?>"><img src="<?=IMG_domian;?>avatar/<?php echo $f['uid']?>"></a></div>
                <div class="fans_name l"><a href=""><?=$f['username']?></a></div>
<!--                <div class="fans_position l"><a href="">新进弟子</a></div>-->
<!--                <div class="fans_number l">粉丝：<span>365</span></div>-->

                 <?php if(!$space && $space!='space'){?>
               <?php if($f['direction']!=3){?>
                  <div class="fans_attention r"><a class='fans_bg' href="javascript:;" onclick="add_attention('<?=site_url('user/add_att')?>',<?=$f['uid']?>)"></a></div>
               <?php }else{ ?>
                   <div class="fans_attention r"><a  class='gzed' style="color:#317b3c;"href="javascript:;"></a></div>
               <?php }?>
                <?php }?>

                <div class="clear"></div>
            </div>
           <?php endforeach?>
            <?php }else{?>
             <em>还没有人关注您</em>
         <?php }?>
          <div class="page_link">  <?=$link?></div>
        </div>
    </div>
	<div class="clear"></div>
</div>
<!--member-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
</body>
</html>