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
            <div style="margin-top:5px;cursor: pointer">
                <!--判断是否关注-->
                <?php if ($header_info['check_attend'] == 1) { ?>
                    <img onclick="add_attention('<?php echo site_url('user/add_att') ?>',<?= $header_info['uid'] ?>)"
                         src="<?php echo base_url('images/gz.png') ?>">
                <?php } else { ?>
                    <img
                        onclick="cancel_attention('<?php echo site_url('user/cancel_att') ?>',<?= $header_info['uid'] ?>)"
                        src="<?php echo base_url('images/qxgz.png') ?>">
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <?php if (!$space && $space != 'space') { ?>
        <?php if ($user_currentTab == 5): ?>
            <div class="r">
                <ul class="info_photo">
                    <!--<li class="p_ico1"><a href="#">创建相册</a></li>-->
                    <li class="p_ico2"><a href="<?= site_url('user/up_photo') ?>"> <img
                                src="<?php echo base_url('images/photo.png'); ?>"/>上传照片</a></li>
                    <div class="clear"></div>
                </ul>
            </div>
        <?php endif ?>
        <?php if ($user_currentTab == 6 || $user_currentTab ==1): ?>
            <div class="r">
                <ul class="info_photo">
                    <li class="p_ico2"><a href="<?php echo site_url('user/spoor_city_add'); ?>"><img src="<?php echo base_url('images/spoor.png'); ?>"/>添加足迹</a></li>
                    <div class="clear"></div>
                </ul>
            </div>
        <?php endif ?>
        <?php if ($user_currentTab == 4): ?>
            <div class="r">
                <ul class="bag">
                    <li class="bag-icon"><a href="<?= site_url('user/bag_add') ?>"> <img
                                src="<?php echo base_url('images/bag.png'); ?>"/>创建背包</a></li>
                    <div class="clear"></div>
                </ul>
            </div>
        <?php endif ?>
    <?php } ?>
    <div class="clear"></div>
</div>
<div class="switch_but">
    <?php if (!$space && $space != 'space') { ?>
        <div class="member_switch_but <?php if ($user_currentTab == 1) {
            echo 'member_switch_on';
        } ?>"><a href="<?= site_url('user') ?>">首页</a><span class="em" <?php if ($user_currentTab == 1) {
                echo 'style="display:block;"';
            } ?>></span></div>
        <div class="member_switch_but <?php if ($user_currentTab == 2) {
            echo 'member_switch_on';
        } ?>"><a href="<?= site_url('forum/guide') ?>">技术</a><span class="em" <?php if ($user_currentTab == 2) {
                echo 'style="display:block;"';
            } ?>></span></div>
        <div class="member_switch_but <?php if ($user_currentTab == 3) {
            echo 'member_switch_on';
        } ?>"><a href="<?= site_url('forum/travel') ?>">游记</a><span class="em" <?php if ($user_currentTab == 3) {
                echo 'style="display:block;"';
            } ?>></span></div>
        <div class="member_switch_but <?php if ($user_currentTab == 7) {
            echo 'member_switch_on';
        } ?>"><a href="<?= site_url('forum/post') ?>">贴子</a><span class="em" <?php if ($user_currentTab == 7) {
                echo 'style="display:block;"';
            } ?>></span></div>
        <div class="member_switch_but <?php if ($user_currentTab == 4) {
            echo 'member_switch_on';
        } ?>"><a href="<?= site_url('user/bag') ?>">背包</a><span class="em" <?php if ($user_currentTab == 4) {
                echo 'style="display:block;"';
            } ?>></span></div>
        <div class="member_switch_but <?php if ($user_currentTab == 5) {
            echo 'member_switch_on';
        } ?>"><a href="<?= site_url('user/photo') ?>">照片</a><span class="em" <?php if ($user_currentTab == 5) {
                echo 'style="display:block;"';
            } ?>></span></div>
        <div class="member_switch_but no_margin_right <?php if ($user_currentTab == 6) {
            echo 'member_switch_on';
        } ?>" style="width: 139px"><a href="<?php echo site_url('user/spoor'); ?>">足迹</a><span class="em" <?php if ($user_currentTab == 6) {
                echo 'style="display:block;"';
            } ?>></span></div>
    <?php } else { ?>

        <div class="member_switch_but <?php if ($user_currentTab == 1) {
            echo 'member_switch_on';
        } ?>"><a href="<?= site_url('space/' . $header_info['uid']) ?>">首页</a><span
                class="em" <?php if ($user_currentTab == 1) {
                echo 'style="display:block;"';
            } ?>></span></div>
        <div class="member_switch_but <?php if ($user_currentTab == 2) {
            echo 'member_switch_on';
        } ?>"><a href="<?= site_url('forum/guide') ?>/<?= $header_info['uid'] ?>">技术</a><span
                class="em" <?php if ($user_currentTab == 2) {
                echo 'style="display:block;"';
            } ?>></span></div>
        <div class="member_switch_but <?php if ($user_currentTab == 3) {
            echo 'member_switch_on';
        } ?>"><a href="<?= site_url('forum/travel') ?>/<?= $header_info['uid'] ?>">游记</a><span
                class="em" <?php if ($user_currentTab == 2) {
                echo 'style="display:block;"';
            } ?>></span></div>
        <div class="member_switch_but <?php if ($user_currentTab == 7) {
            echo 'member_switch_on';
        } ?>"><a href="<?= site_url('forum/post') ?>/<?= $header_info['uid'] ?>">帖子</a><span
                class="em" <?php if ($user_currentTab == 2) {
                echo 'style="display:block;"';
            } ?>></span></div>
        <div class="member_switch_but <?php if ($user_currentTab == 4) {
            echo 'member_switch_on';
        } ?>"><a href="<?= site_url('space_bag/' . $header_info['uid']) ?>">背包</a><span
                class="em" <?php if ($user_currentTab == 4) {
                echo 'style="display:block;"';
            } ?>></span></div>
        <div class="member_switch_but <?php if ($user_currentTab == 5) {
            echo 'member_switch_on';
        } ?>"><a href="<?= site_url('space_photo/' . $header_info['uid']) ?>">照片</a><span
                class="em" <?php if ($user_currentTab == 5) {
                echo 'style="display:block;"';
            } ?>></span></div>
        <div class="member_switch_but no_margin_right <?php if ($user_currentTab == 6) {
            echo 'member_switch_on';
        } ?>" style="width: 139px"><a href="<?php echo site_url('space_spoor/' . $header_info['uid']); ?>">足迹</a><span
                class="em" <?php if ($user_currentTab == 6) {
                echo 'style="display:block;"';
            } ?>></span></div>
    <?php } ?>


    <div class="clear"></div>

</div>


