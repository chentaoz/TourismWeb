<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $meta; ?>
    <?php echo $title; ?>
    <?php echo $keywords; ?>
    <?php echo $description; ?>
    <?php echo $css; ?>
    <?php echo $js; ?>
</head>
<body>
<!--login reg top-->
<div class="lr_topbg">
    <div class="wp">
        <div class="lr_logo l"><a href="<?=base_url()?>"><img src="<?php echo base_url('images/latest.png');?>"></a></div>
        <div class="lr_menu l">
            <ul>
                <li><a href="<?=site_url('place')?>">目的地</a></li>
                <li><a href="<?=site_url('sport')?>">运动</a></li>
                <li><a href="#">背包</a></li>
                <li><a href="#">小贴士</a></li>
                <li><a href="#">攻略</a></li>
                <li><a href="#">社区</a></li>
                <div class="clear"></div>
            </ul>
        </div>
        <div class="lr_in r"><a href="<?php echo site_url('home/login');?>">登录</a> / <a href="<?php echo site_url('home/register');?>">注册</a></div>
        <div class="clear"></div>
    </div>
</div>
<!--top-->