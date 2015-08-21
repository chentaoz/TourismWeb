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
    <div class="member_infos l" >
        <div class="member_name" style=" margin-top: 0">
            <?php echo $member['username']?>
            <?php if($member['gender']==1){?>
                <img src="<?php echo base_url('images/man.png')?>">
            <?php }elseif($member['gender']==2){?>
                <img src="<?php echo base_url('images/woman.png')?>">
            <?php }?>
            <span class="member_focus">
                <!--判断是否关注-->
                <?php if($header_info['check_attend']==1){?>
                    <img onclick="add_attention('<?php echo site_url('user/add_att')?>',<?=$header_info['uid']?>)"src="<?php echo base_url('images/gz.png')?>">
                <?php }else{?>
                    <img onclick="cancel_attention('<?php echo site_url('user/cancel_att')?>',<?=$header_info['uid']?>)"src="<?php echo base_url('images/qxgz.png')?>">
                <?php }?>
            </span>
        </div>
        <div class="member_fans"><img src="<?php echo base_url('images/address.png')?>">&nbsp; <?=$member['address']?></div>
        <div class="member_fans">
            <a href="<?=site_url('user/my_attention/'.$member['uid'])?>">关注 <b><?=$member['friends_num']?></a></b>  |
            <a href="<?=site_url('user/my_fans/'.$member['uid'])?>">  粉丝 <b><?=$member['fans_num']?></a></b>
        </div>
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
        <?php }?>
    </div>
    <?php if($isself){ ?>
        <?php if($user_currentTab==5):?>
            <div class="r">
                <ul class="spoor">
                    <li class="p_ico1"><a href="<?=site_url('user/up_photo')?>"><br/>上传照片</a></li>
                    <div class="clear"></div>
                </ul>
            </div>
        <?php endif ?>
        <?php if($user_currentTab==6 ||$user_currentTab==1 ):?>
            <div class="r">
                <ul class="spoor">
                    <li class="p_ico2"><a href="<?=site_url('user/spoor_city_add')?>"><br/>添加足迹</a></li>
                    <div class="clear"></div>
                </ul>
            </div>
        <?php endif ?>
        <?php if($user_currentTab==4):?>
            <div class="r">
                <ul class="bag">
                    <li class="bag-icon"><a href="<?=site_url('user/bag_add')?>"><br/>创建背包</a></li>
                    <div class="clear"></div>
                </ul>
            </div>
        <?php endif ?>
        <?php if($user_currentTab==2):?>
            <div class="info_photo r">
                <a class="p_ico3" href="<?=BBS_domian?>forum.php?mod=misc&action=nav&category=3">
                    <img src="<?php echo base_url('images/guide.png');?>"/><br/>写技术</a>
            </div>
        <?php endif ?>
        <?php if($user_currentTab==3):?>
            <div class="info_photo r">
                <a class="p_ico3" href="<?=BBS_domian?>forum.php?mod=misc&action=nav&category=2">
                    <img src="<?php echo base_url('images/guide.png');?>"/><br/>写游记</a>
            </div>
        <?php endif ?>
        <?php if($user_currentTab==7):?>
            <div class="info_photo r">
                <a class="p_ico3" href="<?=BBS_domian?>forum.php?mod=misc&action=nav">
                    <img src="<?php echo base_url('images/guide.png');?>"/><br/>写新帖</a>
            </div>
        <?php endif ?>
    <?php } ?>
    <div class="clear"></div>
</div>
<div class="member_tab clear" style="overflow:inherit">
    <ul class="nav nav-pills">
                <?php if (!$space && $space != 'space') { ?>
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
			</br></br></br></br>
<!--this file is yield incorrectly,please be aware--><!--this file is yield incorrectly,please be aware--><!--this file is yield incorrectly,please be aware--><!--this file is yield incorrectly,please be aware-->
        <?php }else{?>
            <li role="presentation"><a <?php if($user_currentTab==1){ echo 'class="active"';} ?> href="<?=site_url('user')?>">首页</a></li>
			<li role="presentation"><a id="showup" href="#" role="button" >TA的帖子<span class="caret"></span></a></li>
<!--            <li role="presentation"><a --><?php //if($user_currentTab==2){ echo 'class="active"';} ?><!-- href="--><?//=site_url('forum/guide')?><!--">技术</a></li>-->
<!--            <li role="presentation"><a --><?php //if($user_currentTab==3){ echo 'class="active"';} ?><!-- href="--><?//=site_url('forum/travel')?><!--">游记</a></li>-->
<!--            <li role="presentation"><a --><?php //if($user_currentTab==7){ echo 'class="active"';} ?><!-- href="--><?//=site_url('forum/post')?><!--">帖子</a></li>-->
            <li role="presentation"><a <?php if($user_currentTab==4){ echo 'class="active"';} ?> href="<?=site_url('user/bag')?>">背包</a></li>
            <li role="presentation"><a <?php if($user_currentTab==5){ echo 'class="active"';} ?> href="<?=site_url('user/photo')?>">照片</a></li>
            <li role="presentation" class="mar0"><a <?php if($user_currentTab==6){ echo 'class="active"';} ?> href="<?php echo site_url('user/spoor');?>">足迹</a></li>
			</br></br></br></br>
			<div class="container" id="sublistgroup" style="padding-left:90px">
						<li role="presentation" class="sublist1" ><a <?php if($user_currentTab==2){ echo 'class="active"';} ?> href="<?=site_url('forum/guide')?>">技术</a></li>
						<li role="presentation" class="sublist1" ><a <?php if($user_currentTab==3){ echo 'class="active"';} ?> href="<?=site_url('forum/travel')?>">游记</a></li>
						<li role="presentation" class="sublist1" ><a <?php if($user_currentTab==7){ echo 'class="active"';} ?> href="<?=site_url('forum/post')?>">帖子</a></li>
			</div>
        <?php }?>
    </ul>
</div>
