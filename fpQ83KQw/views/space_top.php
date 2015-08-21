<?php echo $s_user?>
<div class="member_info">
		<div class="member_img l">
                <img src="<?=IMG_domian;?>avatar/<?=$s_uid?>">
          </div>
		<div class="member_infos l">
			<div class="member_name"><?=$s_username?></div>
			<div class="member_fans">关注 <b><?= $friends_num ?></b>  |  粉丝 <b><?= $fans_num ?></b></div>
			<div class="member_like_acvitiy">喜欢的运动：
                <?php foreach($like_sport as $s):?>
                     <?=$s?>&nbsp;&nbsp;
                <?php endforeach ?>
            </div>
            <div class="member_like_acvitiy">
                <?php if($data['gz']==0){?>
                     <a href="<?=site_url('space/friend_add/fid/'.$s_uid)?>"><img src="<?=WWW_domian;?>images/ygz.png"></a>
                <?php }else{?>
                    <a href="<?=site_url('space/friend_add/fid/'.$s_uid)?>"><img src="<?=WWW_domian;?>images/gz.png"></a>
                <?php }?>
            </div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="switch_but">
		<div class="member_switch_but <?php if($user_currentTab==1){ echo 'member_switch_on';} ?>"><a href="<?=site_url('space/'.$s_uid)?>">首页</a><span class="em" <?php if($user_currentTab==1){ echo 'style="display:block;"';} ?>></span></div>
		<div class="member_switch_but <?php if($user_currentTab==2){ echo 'member_switch_on';} ?>"><a href="<?=site_url('forum/guide')?>/<?=$s_uid?>">攻略</a><span class="em" <?php if($user_currentTab==2){ echo 'style="display:block;"';} ?>></span></div>
        <div class="member_switch_but <?php if($user_currentTab==3){ echo 'member_switch_on';} ?>"><a href="<?=site_url('forum/guide')?>/<?=$s_uid?>">游记</a><span class="em" <?php if($user_currentTab==2){ echo 'style="display:block;"';} ?>></span></div>
        <div class="member_switch_but <?php if($user_currentTab==7){ echo 'member_switch_on';} ?>"><a href="<?=site_url('forum/guide')?>/<?=$s_uid?>">帖子</a><span class="em" <?php if($user_currentTab==2){ echo 'style="display:block;"';} ?>></span></div>
		<div class="member_switch_but <?php if($user_currentTab==4){ echo 'member_switch_on';} ?>"><a href="<?=site_url('space_bag/'.$s_uid)?>">背包</a><span class="em" <?php if($user_currentTab==4){ echo 'style="display:block;"';} ?>></span></div>
		<div class="member_switch_but <?php if($user_currentTab==5){ echo 'member_switch_on';} ?>"><a href="<?=site_url('space_photo/'.$s_uid)?>">照片</a><span class="em" <?php if($user_currentTab==5){ echo 'style="display:block;"';} ?>></span></div>
		<div class="member_switch_but no_margin_right <?php if($user_currentTab==6){ echo 'member_switch_on';} ?>"><a href="<?php echo site_url('space_spoor/'.$s_uid);?>">足迹</a><span class="em" <?php if($user_currentTab==6){ echo 'style="display:block;"';} ?>></span></div>
		<div class="clear"></div>
	</div>