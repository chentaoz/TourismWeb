<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php echo $meta; ?><?php echo $title; ?><?php echo $keywords; ?><?php echo $description; ?><?php echo $css; ?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
    <?php echo $js; ?>
    <script type="text/javascript" src="<?php echo base_url()?>js/layer-v1.8.5/layer/layer.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/layer-v1.8.5/layer/extend/layer.ext.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
<!--login reg top-->
<div class="common_topbg">
  <div class="wp">
    <div class="common_logo l"><a href="<?=site_url()?>"><img src="<?=base_url().'images/latest.png'?>"></a></div>
    <div class="common_menu l">
      <ul>
        <li><a <?php if($currentTab==1){ echo "class='common_menuon'";} ?>  href="<?=site_url('place')?>">目的地</a></li>
        <li><a <?php if($currentTab==2){ echo "class='common_menuon'";} ?> href="<?=site_url('sport')?>">部落</a></li>
        <!--
        <li><a <?php //if($currentTab==3){ echo "class='common_menuon'";} ?> href="<?//=site_url('bag')?>">背包</a></li>
        <li><a <?php //if($currentTab==5){ echo "class='common_menuon'";} ?> href="<?//=site_url('guide')?>">攻略</a></li>
        -->
        <li><a href="<?=BBS_domian?>" target="_blank">社区</a></li>
        <div class="clear"></div>
      </ul>
    </div>
    <div class="login">
      <form class="searchform" method="post" autocomplete="off" action="<?=BBS_domian?>search.php?mod=forum" target="_blank" onsubmit="return check_key()">
        <input type="text" id="scform_srchtxt" name="srchtxt" class="" value="搜索目的地/用户/宝典" onfocus="if(this.value == '搜索目的地/用户/宝典') this.value = ''" onblur="if(this.value =='') this.value = '搜索目的地/用户/宝典'"  />
        <input type="hidden" name="searchsubmit" value="yes">
        <input type="submit" id="scform_submit" value="" id="search" class="submit"  />
      </form>
    </div>
    <div class="common_in r">
      <?php if(!$user){?>
      <a href="<?=PASSPORT_domian?>oauth/login">登录</a> | <a href="<?=PASSPORT_domian?>oauth/register">注册</a>
      <?php }else{?>
      <a class="show_menu" href="<?=site_url('user')?>"> <?php echo $user['username']?></a>
          <a href="javascript:;" class="triangle"></a>
      <?php }?>
      <img src="<?=base_url('images/xiaolian.png')?>"/>
        <?php $this->load->view('user_nev'); ?>
    </div>
    <div class="clear"></div>

  </div>
</div>
<!--top-->

<script>
    $(function(){
         $('.show_menu').mouseover(function(){
           $('.u_m').show();
         });
        $('.common_in').mouseleave(function(){
            $('.u_m').hide();
        });

    })
</script>
