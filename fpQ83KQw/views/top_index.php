<!--top-->
<div class="wp top_member font_14">

</div>
<div class="top_menu_wp">
    <div class="wp pos_relative">
        <div class="top_logo"><a href="<?=base_url()?>"><img src="<?=base_url().'images/index_logo.png'?>"></a></div>
        <div class="l top_menu">
            <ul>
                <li><a <?php if($currentTab==1){ echo "class='common_menuon'";} ?>  href="<?=site_url('place')?>">目的地</a></li>
                <li><a <?php if($currentTab==2){ echo "class='common_menuon'";} ?> href="<?=site_url('sport')?>">部落</a></li>
                <li><a <?php if($currentTab==3){ echo "class='common_menuon'";} ?> href="<?=site_url('bag')?>">背包</a></li>
                <li><a <?php if($currentTab==5){ echo "class='common_menuon'";} ?> href="<?=site_url('guide')?>">攻略</a></li>
                <li><a href="<?=BBS_domian?>" target="_blank">社区</a></li>
                <div class="clear"></div>
            </ul>
        </div>
        <div class="login">
      <form class="searchform" method="post" autocomplete="off" action="<?=BBS_domian?>search.php?mod=forum" target="_blank" onsubmit="return check_key()">
        <input type="text" id="scform_srchtxt" name="srchtxt" value="搜索目的地/用户/攻略" onfocus="if(this.value == '搜索目的地/用户/攻略') this.value = ''" onblur="if(this.value =='') this.value = '搜索目的地/用户/攻略'"  />
          <input type="hidden" name="searchsubmit" value="yes">
            <input type="submit" id="scform_submit" value="" id="search" class="submit" align="absmiddle"  />
       </form>

        </div>
        <div class="common_in r" >
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
<div class="wp"><div class="top_tips font_14 l">唤醒心中的野孩子，让旅行更好玩！</div></div>
<div class="clear"></div>
<div class="wp top_ico_navs">
    <?php foreach($sport_cate as $s):?>
    <div class="top_ico_nav l"><a href="<?=site_url('sport/detail/spid/'.$s['spid'])?>"><img src="<?=base_url().$this->config->item('upload_sports_icon').'/'.$s['img']?>" width="45" height="44"><br><?=$s['name']?></a></div>
   <?php endforeach ?>
    <?php if(count($sport_cate)>11):?>
    <div class="r top_more"><a href="#"><img src="<?=base_url().'images/tmore.png'?>"></a></div>
    <?php endif?>
    <div class="clear"></div>
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



