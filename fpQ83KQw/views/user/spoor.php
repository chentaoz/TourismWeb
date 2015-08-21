<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--main-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>6));?>
    <!-- spoor -->
    <div class="spoor member_index">
        <div class="spoor-total"><?php if($space && $space=='space'){echo 'Ta';}else{echo '我';}?>去过的：国家&nbsp;<?=$country?>&nbsp;&nbsp;城市&nbsp;<?=$city?></div>
        <?php if($countrys){?>
            <?php foreach($countrys as $c):?>
                <div class="fn-left clear">
                    <div class="spoor-country">
                        <div class="spoor-country-cn"><?=$c['name']?></div>
                        <div class="spoor-country-en"><?=$c['name_en']?></div>
                    </div>
                    <?php if(!empty($c['city'])){?>
                        <?php foreach($c['city'] as $key=>$city):?>
                            <div class="spoor-addr-lg" <?php if(($key+1)%4==0){echo 'style="margin-right:0;"';}?>>
                                <div style="height:230px;width:230px;overflow: hidden">
                                    <?php if(!$space && $space!='space'){?>
                                    <a href="<?php echo site_url('user/spoor_city/'.$city['pid'].'/'.$header_info['uid']);?>">
                                        <?php }else{?>
                                        <a href="<?php echo site_url('space_spoor_detail/'.$city['pid'].'/'.$header_info['uid']);?>">
                                            <?php }?>
                                            <img src="<?php echo get_img_url($city['img'],'230x230',2)?>" /></a>
                                </div>
                                <span class="spoor-addr-name"><?=$city['name']?></span><span class="spoor-addr-total">去过景点：<?=$city['view']?></span>
                            </div>
                        <?php endforeach?>
                    <?php }?>

                </div>
            <?php endforeach?>
        <?php }else{?>
            <?php if(!$space && $space!='space'){ ?>
                <div class="spoor-addr-lg" style="margin-right:0;"><a href="<?php echo site_url('user/spoor_city_add'); ?>"><img src="/images/spoor_add.png" /></a></div>
            <?php }else{?>
                <div class="nofino"><img src="<?php echo base_url('images/noinfo.png');?>"><br>这家伙太懒了，什么都没留下！</div>
            <?php }?>
        <?php }?>
    </div>
    <!-- spoor -->
</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script>
    $('.spoor-add a').on('click',function(){
        var s_name=$(this).parents('.spoor-addr-lg').find('.spoor-addr-name').html(); //地点的名字
        var city_id=$(this).attr('city_id');
        var country_id=$(this).attr('country');
        var src_url='<?php echo site_url('user/spoor_destination_add') ?>'+'/'+city_id+'/'+country_id;
        $.layer({
            type: 2,
            shadeClose: true,
            title: '在'+s_name+'你去过哪些地方',
            closeBtn: [0, true],
            shade: [0.8, '#000'],
            border: [3,0.5,'#ddd'],
            offset: ['100px',''],
            area: ['800px', ($(window).height() - 250) +'px'],
            btns:2,
            iframe: {src: src_url},
            yes:function(index){
                /*这里是点击确定按钮之后的相关操作*/
                //获取选择的具体
                var choose=$(window.frames["xubox_iframe1"].document).find(".spoor-dest");//元素个数
                var lg=choose.length;
                var place = [];
                for(var i=0;i<lg;i++){
                    var options= $(choose[i]).attr('data-choose');
                    if(options==1){//选择的放在数组里面
                        place.push($(choose[i]).find('img').attr('pid'));
                    }
                }
                //存放数组中完毕判断数组是否为空
                if(place.length==0){
                    layer.msg('请选择你的足迹',2,3);
                    return false;
                }
                //ajax 给后台数据
                var url="<?=site_url('user/spoor_destination_add')?>";
                $.post(url, {'country':country_id,'sport':place,'city':city_id},function(r){
                    // console.log(r);
                    if (r ==1){
                        layer.msg('添加成功',2,1);
                        layer.close(index);
                        window.location.reload();
                    }
                    else{
                        layer.msg('添加失败',2,3);
                    }
                });

            }
        });
    });
</script>
</body>
</html>