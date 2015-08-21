<div class="wp">
    <ul class="nav nav-pills">
        <li role="presentation" <?php if($currentTab==11){ echo "class='active'";} ?>><a href="<?=site_url('place/city/pid/'.$place['pid'])?>">目的地</a></li>
        <li role="presentation" <?php if($currentTab==12){ echo "class='active'";} ?>><a href="<?=site_url('place/scenic/pid/'.$place['pid'])?>">景点</a></li>
        <li role="presentation" <?php if($currentTab==13){ echo "class='active'";} ?>><a href="<?=site_url('place/sports/pid/'.$place['pid'])?>">户外活动</a></li>
        <li role="presentation">
            <a href="<?php if($place['gid']){echo site_url('guide/detail/gid/' . $place['gid']);}else{ echo "javascript:;my_alert('对不起！暂无攻略')";}  ?>">
            攻略</a>
        </li>
        <li role="presentation" <?php if($currentTab==14){ echo "class='active'";} ?>><a href="<?=site_url('place/picture/pid/'.$place['pid'])?>">图片</a></li>
        <li role="presentation" <?php if($currentTab==15){ echo "class='active'";} ?>><a href="<?=site_url('place/comment/pid/'.$place['pid'])?>">点评</a></li>
        <li role="presentation" <?php if($currentTab==16){ echo "class='active'";} ?>><a href="<?=site_url('place/bag/pid/'.$place['pid'])?>">背包</a></li>
    </ul>
</div>