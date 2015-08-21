<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--member-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>0));?>
    <?php if(!$space && $space!='space'){?>
        <?php  $this->load->view('user_left_menu',array('left_currentTab'=>2));?>
    <?php }?>
    <div class="user_right r" style="padding-right: 0px;<?php if($space && $space=='space'){echo "width:100%";}?>" >
        <div class="user_right_tit">
            <div class="user_right_title l" ><?php if(!$space && $space!='space'){echo '我';}else{echo 'TA';}?>的关注</div>
            <div class="fans_r r" style="padding-right: 20px">共<?=$friends_num?>个</div>
            <div class="clear"></div>
        </div>
        <div class="fans" <?php if($space && $space=='space'){echo "style='width:90%'";}?>>
      <?php if($friends){?>
            <?php foreach($friends as $f):?>
            <div class="fans_list">
                <div class="fans_img l"><a href="<?php echo site_url('space/'.$f['friendid'])?>"><img src="<?=IMG_domian;?>avatar/<?php echo $f['friendid']?>"></a></div>
                <div class="fans_name l"><a href=""><?=$f['username']?></a></div>
         <!--<div class="fans_position l"><a href="">新进弟子</a></div>
          <div class="fans_number l">粉丝：<span>365</span></div>-->
              <?php if(!$space && $space!='space'){?>
                <div class="fans_attention r"><a class='att_bg' href="javascript:;" onclick="cancel_attention('<?=site_url('user/cancel_att')?>',<?=$f['friendid']?>)"></a></div>
              <?php }?>
                <div class="clear"></div>
            </div>
           <?php endforeach ?>
         <div class="page_link" >  <?=$link?></div>
      <?php }else{?>
            <em>您还没有关注好友</em>
      <?php }?>

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
