<div class="member_info">
    <div class="member_img l">
        <img src="<?= IMG_domian; ?>avatar/<?php echo $header_info['uid'] ?>">
    </div>
    <div class="member_infos l" style="height: 138px; padding-top: 0; margin-top: 0">
        <div class="member_name" style=" margin-top: 0"><?php echo $header_info['username'] ?>
            <?php if ($header_info['gender'] == 1) { ?>
                <img src="<?php echo base_url('images/man.png') ?>">
            <?php } elseif ($header_info['gender'] == 2) { ?>
                <img src="<?php echo base_url('images/woman.png') ?>">
            <?php } ?>
            <span class="member_focus">
                <!--判断是否关注-->
                <?php if($header_info['check_attend']==1){?>
                    <img onclick="add_attention('<?php echo site_url('user/add_att')?>',<?=$header_info['uid']?>)"src="<?php echo base_url('images/gz.png')?>">
                <?php }else{?>
                    <img onclick="cancel_attention('<?php echo site_url('user/cancel_att')?>',<?=$header_info['uid']?>)"src="<?php echo base_url('images/qxgz.png')?>">
                <?php }?>
            </span>
        </div>
        <div class="member_fans"><img
                src="<?php echo base_url('images/address.png') ?>">&nbsp; <?= $header_info['address'] ?></div>
        <div class="member_fans">
            <?php if (!$space && $space != 'space') { ?>
                <a href="<?php echo site_url('user/my_attention')?>">关注 <b><?= $header_info['friends_num'] ?></a></b>
            <?php }else{?>
                <a href="<?php echo site_url('space_att/'.$header_info['uid'])?>">关注 <b><?= $header_info['friends_num'] ?></a></b>
            <?php }?>  |
            <?php if(!$space && $space!='space'){?>
                <a href="<?php echo site_url('user/my_fans/'.$header_info['uid'])?>">粉丝 <b><?= $header_info['fans_num'] ?></b></a>
            <?php }else{?>
                <a href="<?= site_url('space_fans/' . $header_info['uid']) ?>">粉丝 <b><?= $header_info['fans_num'] ?></b></a>
            <?php }?>
        </div>
        <div class="member_like_acvitiy">玩过的部落：
            <?php foreach ($header_info['like_sports'] as $s) {
                if ($s['beento'] == 1) {
                    ?>
                    <?= $s['name'] ?>&nbsp;&nbsp;
                <?php
                }
            }?>

        </div>
        <?php if (!$space && $space != 'space') { ?>
            <a href="<?= site_url('user/person_info') ?>">
                <div class="member_set">个人设置</div>
            </a>
        <?php } else { ?>
            <a href="<?= site_url('profile/'. $header_info['uid']) ?>">
                <div class="member_set">详细资料</div>
            </a>
        <?php } ?>
    </div>

    <?php if (!$space && $space != 'space') { ?>
        <?php if ($user_currentTab == 5): ?>
            <div class="info_photo r">
                <a class="p_ico2" href="<?= site_url('user/up_photo') ?>">
                    <img src="<?php echo base_url('images/photo.png'); ?>"/><br/>上传照片</a>
            </div>
        <?php endif ?>
        <?php if ($user_currentTab == 6 || $user_currentTab ==1): ?>
            <div class="info_photo r">
                <a class="p_ico2" href="<?php echo site_url('user/spoor_city_add'); ?>">
                    <img src="<?php echo base_url('images/spoor.png'); ?>"/><br/>添加足迹</a>
            </div>
        <?php endif ?>
        <?php if ($user_currentTab == 4): ?>
            <div class="info_photo r">
                <a class="bag-icon" href="<?= site_url('user/bag_add') ?>">
                    <img src="<?php echo base_url('images/bag.png'); ?>" /><br/>创建背包</a>
            </div>
        <?php endif ?>
    <?php } ?>
    <div class="clear"></div>
</div>

<div class="member_tab clear" style="overflow:inherit">
    <ul class="nav nav-pills">
        <?php if (!$space && $space != 'space') { ?>
            <li role="presentation"><a <?php if($user_currentTab==1){ echo 'class="active"';} ?> href="<?=site_url('user')?>">首页</a></li>
			
			  <li role="presentation" class="dropdown">
				<a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				  我的帖子
				  <span class="caret"></span>
				</a>
				<ul id="menu1" class="dropdown-menu" aria-labelledby="drop4" style=" padding-top:20px">
						<li role="presentation" style="border:0px; " ><a <?php if($user_currentTab==2){ echo 'class="active"';} ?> href="<?=site_url('forum/guide')?>" style="width: 160px;">技术</a></li>
						<li role="presentation" style="border:0px; " ><a <?php if($user_currentTab==3){ echo 'class="active"';} ?> href="<?=site_url('forum/travel')?>" style="width: 160px;">游记</a></li>
						<li role="presentation" style="border:0px; " ><a <?php if($user_currentTab==7){ echo 'class="active"';} ?> href="<?=site_url('forum/post')?>" style="width: 160px;">帖子</a></li>
				</ul>
			  </li>
            <li role="presentation"><a <?php if($user_currentTab==4){ echo 'class="active"';} ?> href="<?=site_url('user/bag')?>">背包</a></li>
            <li role="presentation"><a <?php if($user_currentTab==5){ echo 'class="active"';} ?> href="<?=site_url('user/photo')?>">照片</a></li>
            <li role="presentation" class="mar0"><a <?php if($user_currentTab==6){ echo 'class="active"';} ?> href="<?php echo site_url('user/spoor');?>">足迹</a></li>
			</br></br></br></br>

        <?php }else{?>
            <li role="presentation"><a <?php if($user_currentTab==1){ echo 'class="active"';} ?> href="<?=site_url('space')?>/<?=$header_info['uid']?>">首页</a></li>
						  <li role="presentation" class="dropdown">
				<a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				  TA的帖子
				  <span class="caret"></span>
				</a>
				<ul id="menu1" class="dropdown-menu" aria-labelledby="drop4" style=" padding-top:20px">
            <li role="presentation" style="border:0px; "><a <?php if($user_currentTab==2){ echo 'class="active"';} ?> href="<?=site_url('forum/guide')?>/<?=$header_info['uid']?>" style="width: 160px;">技术</a></li>
            <li role="presentation" style="border:0px; "><a <?php if($user_currentTab==3){ echo 'class="active"';} ?> href="<?=site_url('forum/travel')?>/<?=$header_info['uid']?>" style="width: 160px;">游记</a></li>
            <li role="presentation" style="border:0px; "><a <?php if($user_currentTab==7){ echo 'class="active"';} ?> href="<?=site_url('forum/post')?>/<?=$header_info['uid']?>" style="width: 160px;">帖子</a></li>
				</ul>
			  </li>
            <li role="presentation"><a <?php if($user_currentTab==4){ echo 'class="active"';} ?> href="<?=site_url('space_bag')?>/<?=$header_info['uid']?>">背包</a></li>
            <li role="presentation"><a <?php if($user_currentTab==5){ echo 'class="active"';} ?> href="<?=site_url('space_photo')?>/<?=$header_info['uid']?>">照片</a></li>
            <li role="presentation" class="mar0"><a <?php if($user_currentTab==6){ echo 'class="active"';} ?> href="<?php echo site_url('space_spoor');?>/<?=$header_info['uid']?>">足迹</a></li>
        <?php }?>
    </ul>
</div>


