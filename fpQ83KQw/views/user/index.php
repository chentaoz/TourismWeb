<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--main-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>1));?>
    <div class="member_index">
        <div class="member_index_r r">
            <div class="member_indexr">
                <?php if(!$space && $space!='space'){?>
                    <div class="my_do">
                        <ul>
                            <li class="myico1"><a href="<?=BBS_domian?>forum.php?mod=misc&action=nav&category=2">写游记</a></li>
                            <li class="myico2"><a href="<?=site_url('user/bag_add')?>">建背包</a></li>
                            <li class="myico3"><a href="<?=BBS_domian?>forum.php?mod=misc&action=nav&category=3">写技术</a></li>
                            <li class="myico4"><a href="<?=site_url('user/up_photo')?>">传照片</a></li>
                            <div class="clear"></div>
                        </ul>
                    </div>
                <?php }?>
                <div class="member_indexr_ctit">
                    <div class="l"><?php if(!$space && $space!='space'){echo '我';}else{echo 'TA';}?>的关注</div>
                    <?php if(!$space && $space!='space'){?>
                        <div class="r"><a href="<?php echo site_url('user/my_attention')?>">更多</a></div>
                    <?php }else{?>
                        <div class="r"><a href="<?php echo site_url('space_att/'.$header_info['uid'])?>">更多</a></div>
                    <?php }?>
                    <div class="clear"></div>
                </div>
                <div class="member_indexr_cnr">
                    <ul>
                        <?php if($friend_ls){?>
                            <?php foreach($friend_ls as $f):?>
                                <li>
                                    <div class="member_common_pic"><a href="<?=site_url('space/'.$f['friendid'])?>"><img src="<?=IMG_domian;?>avatar/<?php echo $f['friendid']?>"></a></div>
                                    <div class="member_common_picname"><a href="<?=site_url('space/'.$f['friendid'])?>"><?=$f['username']?></a></div>
                                </li>
                            <?php endforeach ?>
                        <?php }?>
                        <div class="clear"></div>
                    </ul>
                </div>
                <div class="member_indexr_ctit">
                    <div class="l"><?php if(!$space && $space!='space'){echo '我';}else{echo 'TA';}?>的粉丝</div>
                    <?php if(!$space && $space!='space'){?>
                    <div class="r"><a href="<?php echo site_url('user/my_fans/'.$header_info['uid'])?>">更多</a></div>
                    <?php }else{?>
                    <div class="r"><a href="<?php echo site_url('space_fans/'.$header_info['uid'])?>">更多</a></div>
                    <?php }?>
                    <div class="clear"></div>
                </div>
                <div class="member_indexr_cnr">
                    <ul>
                        <?php if($fans_list){?>
                            <?php foreach($fans_list as $f):?>
                                <li>
                                    <div class="member_common_pic"><a href="<?=site_url('space/'.$f['uid'])?>"><img src="<?=IMG_domian;?>avatar/<?php echo $f['uid']?>"></a></div>
                                    <div class="member_common_picname"><a href="<?=site_url('space/'.$f['uid'])?>"><?=$f['username']?></a></div>
                                </li>
                            <?php endforeach ?>
                        <?php }?>
                        <div class="clear"></div>
                    </ul>
                </div>
                <div class="member_indexr_ctit">
                    <div class="l"><?php if(!$space && $space!='space'){echo '我';}else{echo 'TA';}?>的技术</div>
                    <div class="r"><a href="<?php echo site_url('forum/guide/'.$header_info['uid'])?>">更多</a></div>
                    <div class="clear"></div>
                </div>
                <div class="member_gllist">
                    <ul>
                        <?php if($my_guid){?>
                            <?php foreach($my_guid as $g):?>
                                <li>
                                    <div class="member_gllist_tit"><a target="_blank" href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$g['tid']?>"><?=$g['subject']?></a></div>
                                    <div class="member_gllist_time l"><?=date('Y-m-d',$g['dateline'])?></div>
                                    <div class="r">
                                        <span class="view"><?=$g['views']?></span>
                                        <span class="view_fx"><?=$g['replies']?></span>
                                    </div>
                                    <div class="clear"></div>
                                </li>
                            <?php endforeach ?>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="member_index_l l">
            <!--map s-->
            <div class="member_map">
                <div class="member_map_ltitle l">
                    <div class="member_map_title"><?php if(!$space && $space!='space'){echo '你';}else{echo 'TA';}?>的足迹世界和旅行梦想</div>
                    <div class="explore_the_world">Explore the world</div>
                </div>
                <div class="member_map_rtitle r">去过<span><?=$country?></span>国家<span><?=$city?></span>城市<span><?php echo $view_num?></span>景点</div>
                <div class="clear"></div>

                <!--google地图部分-->
                <div id="map">
                </div>

            </div>
            <!--map e-->
            <!--玩过 想玩s-->
            <div class="member_common_title">
                <?php if(empty($play) && !$space && $space!='space'){?>
                    <span class="all_play">大家都在玩</span>
                <?php }else{ ?>
                    <span class="member_common_span_on">玩过</span><span>想玩</span>
                <?php }?>
            </div>

            <?php if(empty($play) && !$space && $space!='space'){?><!--随机数据-->
            <div class="all_plays">
                <ul>
                    <?php foreach ($rand_sport as $s):?>
                        <li>
                            <div class="all_plays_img"><a href="<?php echo site_url('sport/detail/spid/'.$s['spid'])?>"><img src="/<?=$this->config->item('upload_sports_icon').'/'.$s['img']?>"><br><?=$s['name']?></a></div>

                            <div class="all_plays_sel">
                                <div ><img src="/images/checkbg.jpg" align="absmiddle" spid="<?=$s['spid'] ?>" type="played" data-value="1"/>玩过</div>
                                <div ><img src="/images/checkbg.jpg" align="absmiddle" spid="<?=$s['spid']?>" type="play"  data-value="1"/>想玩</div>
                            </div>
                        </li>
                    <?php endforeach ?>
                    <div class="clear"></div>
                </ul>
            </div>
            <?php }else{ ?><!--收藏的数据-->
            <div class="member_plays">
                <ul><!--玩过-->
                    <?php if($gone){?>
                        <?php foreach ($gone as $key=>$s):?>
                            <li>
                                <div class="sp_img"><a target="_blank" href="<?=site_url('sport/detail/spid/'.$s['sport_id'])?>"><img src="<?=get_img_url($s['img']['img'],'240x240',2)?>"  /></a></div>
                                <div class="member_plays_name"><a target="_blank" href="<?=site_url('sport/detail/spid/'.$s['sport_id'])?>"><?=$s['name']?></a></div>
                                <div class="plays_info">
                                    <div class="l">
                                        有多少人玩过：<?=$s['played']?>人<br>
                                        相关场点：<?=$s['space']?>个<br>
                                        清单：<?=$s['list']?>件
                                    </div>
                                    <!--	<div class="r want_play"><a href="#">想玩</a></div>-->
                                    <div class="clear"></div>
                                </div>
                            </li>
                        <?php endforeach ?>
                    <?php }elseif(!$space && $space!='space'){ ?>
                        <div class="all_plays">
                            <ol>
                                <?php foreach ($rand_sport as $s):?>
                                    <li>
                                        <div class="all_plays_img"><a href="<?php echo site_url('sport/detail/spid/'.$s['spid'])?>"><img src="/<?=$this->config->item('upload_sports_icon').'/'.$s['img']?>"><br><?=$s['name']?></a></div>

                                        <div class="all_plays_sel">
                                            <div ><img src="<?php echo base_url()?>images/checkbg.jpg" align="absmiddle" spid="<?=$s['spid'] ?>" type="played" data-value="1"/>玩过</div>
                                            <div ><img src="<?php echo base_url()?>images/checkbg.jpg" align="absmiddle" spid="<?=$s['spid']?>" type="play"  data-value="1"/>想玩</div>
                                        </div>
                                    </li>
                                <?php endforeach ?>
                                <div class="clear"></div>
                            </ol>
                        </div>
                    <?php }else{?>
                        <div class="nofino"><img src="<?php echo base_url()?>images/noinfo.png"><br>这家伙太懒了，什么都没留下！</div>
                    <?php }?>
                    <div class="clear"></div>
                </ul>
                <ul style="display:none;"><!--想玩-->
                    <?php if($want){?>
                        <?php foreach ($want as $key=>$s):?>
                            <li <?php if(($key+1)%3==0) echo 'class="no_mr"';?>>
                                <div class="sp_img"><a target="_blank" href="<?=site_url('sport/detail/spid/'.$s['sport_id'])?>"><img  src="<?=get_img_url($s['img']['img'],'240x240',2)?>"/></a></div>
                                <div class="member_plays_name"><a target="_blank" href="<?=site_url('sport/detail/spid/'.$s['sport_id'])?>"><?=$s['name']?></a></div>
                                <div class="plays_info">
                                    <div class="l">
                                        有多少人玩过：<?=$s['played']?>人<br>
                                        相关场点：<?=$s['space']?>个<br>
                                        清单：<?=$s['list']?>件
                                    </div>
                                    <!-- <div class="r want_play"><a href="#">想玩</a></div>-->
                                    <div class="clear"></div>
                                </div>
                            </li>
                        <?php endforeach ?>
                    <?php }elseif(!$space && $space!='space'){?>
                        <div class="all_plays">
                            <ol>
                                <?php foreach ($rand_sport as $s):?>
                                    <li>
                                        <div class="all_plays_img"><a href="<?php echo site_url('sport/detail/spid/'.$s['spid'])?>"><img src="/<?=$this->config->item('upload_sports_icon').'/'.$s['img']?>"><br><?=$s['name']?></a></div>

                                        <div class="all_plays_sel">
                                            <div ><img src="/images/checkbg.jpg" align="absmiddle" spid="<?=$s['spid'] ?>" type="played" data-value="1"/>玩过</div>
                                            <div ><img src="/images/checkbg.jpg" align="absmiddle" spid="<?=$s['spid']?>" type="play"  data-value="1"/>想玩</div>
                                        </div>
                                    </li>
                                <?php endforeach ?>
                                <div class="clear"></div>
                            </ol>
                        </div>
                    <?php }else{?>
                        <div class="nofino"><img src="<?php echo base_url()?>images/noinfo.png"><br>这家伙太懒了，什么都没留下！</div>
                    <?php }?>
                    <div class="clear"></div>
                </ul>
                <div class="clear"></div>
            </div>
            <?php }?>
            <script type="text/javascript">
                $(".member_common_title span").each(function(i){
                    $(this).click(function(){
                        $(".member_common_title span").removeClass("member_common_span_on");
                        $(this).addClass("member_common_span_on");
                        $(".member_plays ul").hide();
                        $(".member_plays ul").eq(i).show();
                    });
                })
            </script>
            <!--玩过 想玩e-->
        </div>
        <div class="clear"></div>
    </div>
</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script>
    $(function(){
        $('.all_plays_sel div').click(function(){
            var t=$(this);
            //获取当前数据 id和类型
            var type= $(this).children('img').attr('type');
            var spid= $(this).children('img').attr('spid');
            var val= $(this).children('img').attr('data-value');
            // alert(type+'--'+spid+'--'+val);
            if(type=='played'){
                var url="<?=site_url('user/played')?>";
            }else if(type=='play'){
                var url="<?=site_url('user/play')?>";

            }
            $.post(url, {'value':val,'id':spid},function(result){
                if (result == 0){
                    layer.msg('收藏失败!',2,3);
                }else if(result == 1){

                    if(val==1){
                        t.children('img').attr('data-value','0');
                        t.children('img').attr('src','/images/option.png');
                    }else if(val==0){
                        t.children('img').attr('data-value','1');
                        t.children('img').attr('src','/images/checkbg.jpg');
                    }
                    layer.msg('成功!',2,1);
                }

            });

        });
    });
</script>
<script src="http://ditu.google.cn/maps?file=api&amp;v=2&amp;key=ABQIAAAAzr2EBOXUKnm_jVnk0OJI7xSosDVG8KKPE1-m51RBrvYughuyMxQ-i1QfUnH94QxWIa6N4U6MouMmBA&hl=zh-CN"
        type="text/javascript"></script>
<script>
    var map;
    var polyline;
    var markers = [];
    var myIconed = new GIcon(G_DEFAULT_ICON,"<?php echo base_url('images/arrival_2x.png'); ?>");//去过的
    var myIcon = new GIcon(G_DEFAULT_ICON,"<?php echo base_url('images/depart_2x.png');?>");//想去的
    var geocoder;

    var play_city=<?=$play_city?>;
    if(play_city){
        var l=play_city.length;
    }
    var type='';
    var name='';
    $(function(){
        myIconed.iconSize=new GSize(32,32);
        myIcon.iconSize=new GSize(32,32);
        if (GBrowserIsCompatible()) {
            var map_canvas = document.getElementById("map");
            map = new GMap2(map_canvas);

            map.setCenter(new GLatLng(43.73935207915473,74.4873046875),1);
            geocoder = new GClientGeocoder();
//标记自己
            add_dottel(type);
        }
    })
    function createMarker(point,code,micon) {
        var marker = new GMarker(point,{ icon: micon, draggable: true, bouncy: true });
        GEvent.addListener(marker, "mouseover", function() {
            marker.openInfoWindowHtml(code);
        });
        return marker;
    }
    //描点
    $('.checkbox').click(function(){
        map.clearOverlays()//去除所有标点
        $("input[type='checkbox']:checked").each(function(){

            type=$(this).val();

            add_dottel(type);
        })

    })
    function add_dottel(type){
        if(type){
            if(type==2){
                type=0;
            }
            if(type==0){//判断0想去1去过
                var icon=myIcon;
            }else if(type==1){
                var icon=myIconed;
            }
            if(l){
                for( var i=0;i<l;i++){
                    if(play_city[i].typeid==type){//判断0想去1去过
                        var latlng = new GLatLng(play_city[i].longitude,play_city[i].latitude);
                        map.addOverlay(createMarker(latlng,play_city[i].name,icon));
                    }

                }
            }
        }else{
//       for( var i=0;i<l;i++){
//           if(play_city[i].planto==1){//判断0想去1去过
//               var icon=myIcon;
//           }
//           else if(play_city[i].beento==1){
//               var icon=myIconed;
//           }
//           var latlng = new GLatLng(play_city[i].longitude,play_city[i].latitude);
//           map.addOverlay(createMarker(latlng,play_city[i].name,icon));
//       }
            //只显示去过的
            for( var i=0;i<l;i++){
                if(play_city[i].beento==1){
                    var icon=myIconed;
                }
                var latlng = new GLatLng(play_city[i].longitude,play_city[i].latitude);
                var id=play_city[i].pid;
                var url='<?php echo site_url('place/index/pid/')?>'+'/'+play_city[i].pid;
                name='<a target="_blank" href='+url+' >'+play_city[i].name+'</a>';

                map.addOverlay(createMarker(latlng,name,myIconed));
            }
        }
    }
</script>
<script>
    //回复
    function replay(uid){
        var myid='<?php echo $user['uid']?>';
        if(!myid){
            window.location.href="<?=PASSPORT_domian.'oauth/login'?>";
            return false;
        }
        layer.prompt({title: '回复留言',type: 3}, function(val){
            //确认的操作
            var url="<?=site_url('user/add_comment')?>";
            $.post(url, {'id':uid,'comment':val},function(result){
                if (result == 1){
                    layer.msg('评论成功',2,1);
                    layer.close();
                    window.location.reload();
                }
                else{
                    layer.msg('评论失败',2,3);
                    layer.close();
                }
            });
        });
    }
    //留言  trim
    <?php if($s_uid){?>
    $('.textarea').focus(function(){
        var v= $('.textarea').val().replace(/\s+/g,"");
        if(v=='我来过，我想说'){
            $('.textarea').val('');
        }
    });
    $('.textarea').blur(function(){
        var v= $('.textarea').val().replace(/\s+/g,"");
        if(v==''){
            $('.textarea').val('我来过，我想说');
        }
    });
    $('.message_sub').click(function(){
        var content=$('.textarea').val().replace(/\s+/g,"");

        var length=getStrLength(content);
        if(content=='我来过，我想说'){
            layer.msg('请填写评论在提交',2,3);
            return false;
        }else if(length<10){
            layer.msg('至少填写10个字符长度',2,3);
            return false;
        }
        //ajax 发表评论
        var url="<?=site_url('space/messages')?>";
        $.post(url, {'c':content,'s_uid':<?=$s_uid?>},function(r){
            switch (r){
                case '1':
                    layer.msg('留言成功！',2,1);
                    $('.textarea').val('我来过，我想说');
                    window.location.reload();
                    break;
                case '2': layer.msg('留言失败！',2,3);
                    break;
                case '3': layer.msg('请先登录在留言！',2,3);
                    window.location.href='<?=PASSPORT_domian?>';
                    break;
                default: layer.msg('发生错误！',2,3);window.location.reload();
                    break;
            }
        });
    })
    <?php }?>
    //字符串长度
    function getStrLength(str) {
        var cArr = str.match(/[^\x00-\xff]/ig);
        return str.length + (cArr == null ? 0 : cArr.length);
    }
</script>
</body>
</html>