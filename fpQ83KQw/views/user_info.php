<div class="member_info">
		<div class="member_img l">
            <?php if($isself){ ?>
            <a title="编辑用户信息" href="<?=site_url('user/person_info')?>">
                <img src="<?=IMG_domian;?>avatar/<?php echo $member['uid']?>">
            </a>
            <?php }else{ ?>
                <img src="<?=IMG_domian;?>avatar/<?php echo $member['uid']?>">
            <?php } ?>
        </div>
    <div class="member_infos l" style="height: 138px; padding-top: 0; margin-top: 0">
        <div class="member_name" style=" margin-top: 0"><?php echo $member['username']?>
                <?php if($member['gender']==1){?>
                    <img src="<?php echo base_url('images/man.png')?>">
                <?php }elseif($member['gender']==2){?>
                    <img src="<?php echo base_url('images/woman.png')?>">
                <?php }?>
            </div>
            <div class="member_fans"> <img src="<?php echo base_url('images/address.png')?>">&nbsp; <?=$member['address']?></div>
			<div class="member_fans"><a href="<?=site_url('user/my_attention/'.$member['uid'])?>">关注 <b><?=$member['friends_num']?></a></b>  |
                <a href="<?=site_url('user/my_fans/'.$member['uid'])?>">  粉丝 <b><?=$member['fans_num']?></a></b></div>
			<div class="member_like_acvitiy">玩过的部落：
                <?php foreach($member['like_sports'] as $s){
                          if ($s['beento'] == 1) {
                ?>
                <?= $s['name'] ?>&nbsp;&nbsp;
                <?php }
                }?>

            </div>
            <?php if($isself){ ?>
            <div class="member_set">
                <a href="<?=site_url('user/person_info')?>">个人设置</a>
            </div>
            <?php }else{ ?>
                <a href="<?= site_url('profile/'. $member['uid']) ?>">
                    <div class="member_set">详细资料</div>
                </a>
                <div style="margin-top:5px;cursor: pointer" >
                    <!--判断是否关注-->
                    <?php if($header_info['check_attend']==1){?>
                        <img onclick="add_attention('<?php echo site_url('user/add_att')?>',<?=$header_info['uid']?>)"src="<?php echo base_url('images/gz.png')?>">
                    <?php }else{?>
                        <img onclick="cancel_attention('<?php echo site_url('user/cancel_att')?>',<?=$header_info['uid']?>)"src="<?php echo base_url('images/qxgz.png')?>">
                    <?php }?>
                </div>
            <?php }?>
		</div>
    <?php if($isself){ ?>
    <?php if($user_currentTab==5):?>
        <div class="r">
            <ul class="info_photo">
                <li class="p_ico1"><a href="#">创建相册</a></li>
                <a href="<?=site_url('user/up_photo')?>"> <li class="p_ico2">上传照片</li></a>
                <div class="clear"></div>
            </ul>
        </div>
    <?php endif ?>
    <?php if($user_currentTab==6 ||$user_currentTab==1 ):?>
        <div class="r">
            <ul class="spoor">
                <li class="p_ico2"><a href="<?php echo site_url('user/spoor_city_add'); ?>"><img src="<?php echo base_url('images/spoor.png'); ?>"/>添加足迹</a></li>
                <div class="clear"></div>
            </ul>
        </div>
    <?php endif ?>
    <?php if($user_currentTab==4):?>
        <div class="r">
            <ul class="bag">
                <li class="bag-icon"><a href="<?=site_url('user/bag_add')?>"> 创建背包</a></li>
                <div class="clear"></div>
            </ul>
        </div>
    <?php endif ?>
    <?php if($user_currentTab==2):?>
        <div class="r">
            <ul class="info_photo">
                <li class="p_ico3"><a href="<?=BBS_domian?>forum.php?mod=misc&action=nav&category=3"><img src="<?php echo base_url('images/guide.png');?>" />写技术</a></li>
                <div class="clear"></div>
            </ul>
        </div>
    <?php endif ?>
    <?php if($user_currentTab==3):?>
        <div class="r">
            <ul class="info_photo">
                <li class="p_ico3"><a href="<?=BBS_domian?>forum.php?mod=misc&action=nav&category=2"><img src="<?php echo base_url('images/guide.png');?>" />写游记</a></li>
                <div class="clear"></div>
            </ul>
        </div>
    <?php endif ?>
    <?php if($user_currentTab==7):?>
        <div class="r">
            <ul class="info_photo">
                <li class="p_ico3"><a href="<?=BBS_domian?>forum.php?mod=misc&action=nav"><img src="<?php echo base_url('images/guide.png');?>" />写新帖</a></li>
                <div class="clear"></div>
            </ul>
        </div>
    <?php endif ?>
    <?php } ?>
		<div class="clear"></div>
	</div>
	<div class="switch_but">
        <?php if($isself){ ?>
		<div class="member_switch_but <?php if($user_currentTab==1){ echo 'member_switch_on';} ?>"><a href="<?=site_url('user')?>">首页</a><span class="em" <?php if($user_currentTab==1){ echo 'style="display:block;"';} ?>></span></div>
		<div class="member_switch_but <?php if($user_currentTab==2){ echo 'member_switch_on';} ?>"><a href="<?=site_url('forum/guide')?>">技术</a><span class="em" <?php if($user_currentTab==2){ echo 'style="display:block;"';} ?>></span></div>
        <div class="member_switch_but <?php if($user_currentTab==3){ echo 'member_switch_on';} ?>"><a href="<?=site_url('forum/travel')?>">游记</a><span class="em" <?php if($user_currentTab==3){ echo 'style="display:block;"';} ?>></span></div>
        <div class="member_switch_but <?php if($user_currentTab==7){ echo 'member_switch_on';} ?>"><a href="<?=site_url('forum/post')?>">帖子</a><span class="em" <?php if($user_currentTab==7){ echo 'style="display:block;"';} ?>></span></div>
		<div class="member_switch_but <?php if($user_currentTab==4){ echo 'member_switch_on';} ?>"><a href="<?=site_url('user/bag')?>">背包</a><span class="em" <?php if($user_currentTab==4){ echo 'style="display:block;"';} ?>></span></div>
		<div class="member_switch_but <?php if($user_currentTab==5){ echo 'member_switch_on';} ?>"><a href="<?=site_url('user/photo')?>">照片</a><span class="em" <?php if($user_currentTab==5){ echo 'style="display:block;"';} ?>></span></div>
		<div class="member_switch_but no_margin_right <?php if($user_currentTab==6){ echo 'member_switch_on';} ?>"><a href="<?php echo site_url('user/spoor');?>">足迹</a><span class="em" <?php if($user_currentTab==6){ echo 'style="display:block;"';} ?>></span></div>
		<div class="clear"></div>
        <?php }else{?>
        <div class="member_switch_but <?php if($user_currentTab==1){ echo 'member_switch_on';} ?>"><a href="<?=site_url('space')?>/<?=$member['uid']?>">首页</a><span class="em" <?php if($user_currentTab==1){ echo 'style="display:block;"';} ?>></span></div>
        <div class="member_switch_but <?php if($user_currentTab==2){ echo 'member_switch_on';} ?>"><a href="<?=site_url('forum/guide')?>/<?=$member['uid']?>">技术</a><span class="em" <?php if($user_currentTab==2){ echo 'style="display:block;"';} ?>></span></div>
        <div class="member_switch_but <?php if($user_currentTab==3){ echo 'member_switch_on';} ?>"><a href="<?=site_url('forum/travel')?>/<?=$member['uid']?>">游记</a><span class="em" <?php if($user_currentTab==3){ echo 'style="display:block;"';} ?>></span></div>
        <div class="member_switch_but <?php if($user_currentTab==7){ echo 'member_switch_on';} ?>"><a href="<?=site_url('forum/post')?>/<?=$member['uid']?>">帖子</a><span class="em" <?php if($user_currentTab==7){ echo 'style="display:block;"';} ?>></span></div>
        <div class="member_switch_but <?php if($user_currentTab==4){ echo 'member_switch_on';} ?>"><a href="<?=site_url('space_bag')?>/<?=$member['uid']?>">背包</a><span class="em" <?php if($user_currentTab==4){ echo 'style="display:block;"';} ?>></span></div>
        <div class="member_switch_but <?php if($user_currentTab==5){ echo 'member_switch_on';} ?>"><a href="<?=site_url('space_photo')?>/<?=$member['uid']?>">照片</a><span class="em" <?php if($user_currentTab==5){ echo 'style="display:block;"';} ?>></span></div>
        <div class="member_switch_but no_margin_right <?php if($user_currentTab==6){ echo 'member_switch_on';} ?>"><a href="<?php echo site_url('space_spoor');?>/<?=$member['uid']?>">足迹</a><span class="em" <?php if($user_currentTab==6){ echo 'style="display:block;"';} ?>></span></div>
        <div class="clear"></div>
        <?php }?>
	</div>