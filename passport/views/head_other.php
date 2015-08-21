<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $meta; ?>
    <?php echo $title; ?>
    <?php echo $keywords; ?>
    <?php echo $description; ?>
    <?php echo $css; ?>
    <?php echo $js; ?>
    <script>var g_siteUrl = "<?=site_url('')?>";</script>
</head>
<body>
<!--login reg top-->
<div class="common_topbg">
    <div class="wp">
        <div class="common_logo l"><a href="<?=site_url()?>"><img src="<?=base_url().'images/latest.png'?>"></a></div>
        <div class="common_menu l">
            <ul>
                <li><a <?php if($currentTab==1){ echo "class='common_menuon'";} ?>  href="<?=site_url('place')?>">目的地</a></li>
                <li><a <?php if($currentTab==2){ echo "class='common_menuon'";} ?> href="<?=site_url('sport')?>">运动</a></li>
                <li><a <?php if($currentTab==3){ echo "class='common_menuon'";} ?> href="<?=site_url('bag')?>">背包</a></li>
                <li><a <?php if($currentTab==5){ echo "class='common_menuon'";} ?> href="<?=site_url('guide')?>">攻略</a></li>
                <li><a href="<?=BBS_domian?>" target="_blank">社区</a></li>
                <div class="clear"></div>
            </ul>
        </div>
        <div class="common_in r">
            <?php if(!$user){?>
            <a href="<?=PASSPORT_domian?>oauth/login">登录</a> | <a href="<?=PASSPORT_domian?>oauth/register">注册</a>
           <?php }else{?>
             <a href="<?=site_url('user')?>"> <?php echo $user['username']?></a>   <a href="<?=PASSPORT_domian?>oauth/logout" class="loggout">退出</a>
            <?php }?>
            <img src="<?=base_url('images/xiaolian.png')?>"/>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!--top-->