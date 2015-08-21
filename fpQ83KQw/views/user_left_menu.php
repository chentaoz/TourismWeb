<div class="user_left l">
    <ul>
        <li><a href="<?=site_url('user/person_info')?>" class="<?php if($left_currentTab==1){ echo 'user_left_on';}?> u1">个人资料<span></span></a></li>
        <li><a href="<?=site_url('user/my_attention')?>" class="u2 <?php if($left_currentTab==2){ echo 'user_left_on';}?>">我的关注<span></span></a></li>
        <li><a href="<?=site_url('user/my_fans')?>" class="u3 <?php if($left_currentTab==3){ echo 'user_left_on';}?>">我的粉丝<span></span></a></li>
        <li><a href="<?=site_url('user/edit_avatar')?>" class="u4 <?php if($left_currentTab==4){ echo 'user_left_on';}?>">修改头像<span></span></a></li>
        <li><a href="<?=site_url('user/edit_pwd')?>" class="u5 <?php if($left_currentTab==5){ echo 'user_left_on';}?>">修改密码<span></span></a></li>
    </ul>
</div>