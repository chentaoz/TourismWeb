<?php  $this->load->view('head');?>
<script type="text/javascript" src="<?php echo base_url()?>js/layer-v1.8.5/layer/layer.min.js"></script>
<script>
    var planed_img='<?php echo base_url()?>'+'images/des_ico12.png';
    var plan_img='<?php echo base_url()?>'+'images/newico1.png';
    var gone_img='<?php echo base_url()?>'+'images/des_ico22.png';
    var go_img='<?php echo base_url()?>'+'images/des_ico2.png';
    var type ='';
    var value='';
    $(function(){
        $('.show_menu').mouseover(function(){
            $('.u_m').show();
        });
        $('.common_in').mouseleave(function(){
            $('.u_m').hide();
        });
        //加载 首页随机城市数据
        rand_city();
        //点击事件
        $('.play').click(function(){
            var url, ob=$(this);
            var pid = ob.attr('data-pid');
            type = ob.attr('data-type');
            value = ob.attr('data-value');
            if (type == 'plan') {
                url = g_siteUrl + 'place/ajax_plan?pid=' + pid + '&plan=' + value;
            }
            if (type == 'gone') {
                url = g_siteUrl + 'place/ajax_been?pid=' + pid + '&been=' + value;
            }
            $.ajax({
                url: url,
                dataType: 'json',
                success: function (res) {

                    if (res.code == -1) {
                        location = res.url;
                    }else{
                        if(type=='plan'){
                            if(value==1){
                                ob.find('img').attr('src',planed_img);
                                ob.attr('data-value','0')

                            }else{
                                ob.find('img').attr('src',plan_img);
                                ob.attr('data-value','1')
                            }
                        }else{
                            if(value==1){
                                ob.find('img').attr('src',gone_img);
                                ob.attr('data-value','0')
                            }else{
                                ob.find('img').attr('src',go_img);
                                ob.attr('data-value','1')
                            }
                        }
                    }
                },
                error: function () {
                    return false;
                }
            });
        })
    })
    function rand_city(){
        var url='<?php echo site_url('home/rant_city')?>';
        $.post(url, {},function(result){
            var r=JSON.parse(result);
            $('.locatin_add a').html(r.country_name+','+ r.name);
            var desc=r.description;
            if(desc.length>200){
                desc=desc.substring(0,200)+'...';
            }
            $('.new_main_des').html(desc);
            var src_url;
            if(r.img){
                src_url='<?php echo base_url()?>'+'upload/place_sport/'+r.img;
            }else{
                src_url='<?php echo base_url()?>images/nban.jpg';
            }
            $('.new_ban img').attr('src',src_url);//更改大图片
            var link='<?=site_url('place/index/pid')?>'+'/'+r.pid;
            $('.new_ban a').attr('href',link);//更改链接
            $('.locatin_add a').attr('href',link);
            $('.play').attr('data-pid',r.pid);//赋值pID
            var p_img=$('.newico1 a img');
            var g_img=$('.newico2 a img');
            var plan=$('.newico1 a');
            var gone=$('.newico2 a');
            //更改去过想去图片和数据
            if(r.planto>0){//想去完成
                p_img.attr('src',planed_img);
                plan.attr('data-value','0');
            }else{//没有想去
                p_img.attr('src',plan_img);
                plan.attr('data-value','1');
            }
            if(r.beento>0){//去过完成
                g_img.attr('src',gone_img);
                gone.attr('data-value','0');
            }else{//没有去过
                g_img.attr('src',go_img);
                gone.attr('data-value','1');
            }

        });

    }
    //自动点击轮换
    function go_next(){
        $("#next").click();
    }
    setInterval("go_next()", 5000);
</script>
<!--top-->
<div class="top">
    <div class="topw wp">
        <div class="logo"><a href="<?=base_url()?>"><img src="<?php echo base_url()?>images/nlogo.png"></a></div>
        <div class="l new_menu">
            <ul>
                <li><a <?php if($currentTab==1){ echo "class='common_menuon'";} ?>  href="<?=site_url('place')?>">目的地</a></li>
                <li><a <?php if($currentTab==2){ echo "class='common_menuon'";} ?> href="<?=site_url('sport')?>">部落</a></li>
                <li><a <?php if($currentTab==3){ echo "class='common_menuon'";} ?> href="<?=site_url('bag')?>">背包</a></li>
                <li><a <?php if($currentTab==5){ echo "class='common_menuon'";} ?> href="<?=site_url('guide')?>">攻略</a></li>
                <li><a href="<?=BBS_domian?>" target="_blank">社区</a></li>
                <div class="clear"></div>
            </ul>
        </div>
        <div class="common_in r" style="border-color: #548f1e;line-height: 20px;">
            <?php if(!$user){?>
                <a href="<?=PASSPORT_domian?>oauth/login">登录</a> | <a href="<?=PASSPORT_domian?>oauth/register">注册</a>
            <?php }else{?>
                <a class="show_menu" href="<?=site_url('user')?>"> <?php echo $user['username']?></a>
                <a href="javascript:;" class="triangle"></a>
            <?php }?>
            <img src="<?=base_url('images/xiaolian.png')?>"/>
            <?php $this->load->view('user_nev'); ?>
        </div>
        <div class="login">
            <form class="searchform" method="post" autocomplete="off" action="<?=BBS_domian?>search.php?mod=forum" target="_blank" onsubmit="return check_key()">
                <input type="text" style="border:1px solid #CECECE;border-right:none"id="scform_srchtxt" name="srchtxt" value="搜索目的地/用户/宝典" onfocus="if(this.value == '搜索目的地/用户/宝典') this.value = ''" onblur="if(this.value =='') this.value = '搜索目的地/用户/宝典'"  />
                <input type="hidden" name="searchsubmit" value="yes">
                <input type="submit" id="scform_submit" value="" id="search" class="submit" align="absmiddle"  />
            </form>

        </div>
        <div class="clear"></div>
    </div>
</div>
<!--top-->
<!--banner-->
<div class="header">
    <?php foreach($banner as $ke=>$b){?>

        <div class="main-banner sliders" <?php if($ke!=0){echo 'style="display:none"';}?>>
        <div class="banner-image" style="background-image:url(<?=base_url().'upload/advertisement/'.$b['img']?>)"></div>
        <div class="banner-bottom">
            <div class="container">
                <div class="banner-story-content" style="text-align:center;">
                    <a href="<?=$b['weblink']?>">
                        <h1 class="banner-story-title btn"><?=$b['title']?></h1>
                        <p style="text-align:center;"><?=$b['intro']?></p>
                    </a>
                </div>
            </div>
        </div>
        <a href="javascript:;" class="arrow left" >
            <img alt="Left arrow" src="<?php echo base_url()?>images/left_nav.png">
        </a>
        <a href="javascript:;" class="arrow right" id="next">
            <img alt="Right arrow" src="<?php echo base_url()?>images/right_nav.png">
        </a>
    </div>

    <?php }?>

    <div class="slide-switcher hidden-xs">
        <?php for($i=0;$i<count($banner);$i++){?>
           <?php if($i==0){?>
                <span class="switcher active"></span>
            <?php }else{?>
                <span class="switcher"></span>
        <?php } }?>
    </div>
</div>
<!--banner-->
<!--main-->
<div class="wp newindex_wp">
    <div class="new_mtit">我们在世界上探索<?=$total_des?>个（持续增加中）绝对难忘的体验，我猜，你会喜欢这个？</div>
    <div class="new_ban"><a href=""><img src="<?php echo base_url()?>images/nban.jpg"></a></div>
    <div class="locatin_add"><a target="_blank" href=""></a></div>
    <div class="new_main">
        <div class="l new_mainl">
            <div class="new_main_des"></div>
        </div>
        <div class="r new_mainr">
            <div class="l newico1"><a href="javascript:;" class="play" data-type="plan" data-pid="" data-value="1"><img src="<?php echo base_url()?>images/newico1.png"></a></div>
            <div class="r newico2"><a href="javascript:;" class="play" data-type="gone" data-pid="" data-value="1"><img src="<?php echo base_url()?>images/des_ico2.png"></a></div>
            <div class="l newico3"><a href="javascript:;" onclick="rand_city()"><img src="<?php echo base_url()?>images/newico3.png"></a></div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!--main-->
<!--foot-->
<?php  $this->load->view('foot');?>
<!--foot-->
<div class="contact-widget hidden-xs">
    <div class="widget-item">
        <img alt="Widget telicon" src="<?php echo base_url()?>images/new_tel.png">
        <div class="widget-tel"><img alt="Widget tel" src="<?php echo base_url()?>images/tels.png"></div>
    </div>
    <a class="widget-item" href="http://wpa.qq.com/msgrd?v=3&uin=806440210&site=qq&menu=yes"><img alt="Widget qqicon" src="./images/new_qq.png"></a>
    <div class="widget-item">
        <img alt="Widget qricon" src="<?php echo base_url()?>images/new_wx.png">
        <div class="widget-qrcode"><img alt="Widget qrcode" src="<?php echo base_url()?>images/wx.jpg"></div>
    </div>
</div>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script async="" src="<?=base_url()?>js/analytics.js"></script>
<script src="<?=base_url()?>js/newindex.js"></script>

</body>
</html>