<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--main-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>4));?>
    <!--背包-->
    <div class="member_bag">
        <div class="member_bag_l l">
            <div class="mbag_tit"><?php if($space && $space=='space'){echo 'Ta';}else{echo '我';}?>的背包</div>
            <?php if($bag_array){?>
                <?php foreach($bag_array as $b):?>
                    <div class="mbag_list_li">
                        <div class="mbag_list_up">
                            <div class="mbag_title">
                                <a href="#"><?=$b['title']?></a>
                                <span>创建时间：<?=date('Y-m-d',$b['created'])?></span>
                                <?php if(!$space && $space!='space'){?>
                                <span style="float:right;">
                                <a class="edit" href="<?=site_url('user/edit_bag/'.$b['id'])?>">编辑</a>
                                <a class="del" href="javascript:;" onclick="my_confirm('<?=site_url('user/del_bag/'.$b['id'])?>')">删除</a>
                                </span>
                                <?php }?>
                            </div>
                            <div class="mbag_des">
                                <?=$b['remark']?>
                            </div>
                        </div>
                        <div class="mbag_list_down">
                            <div class="mbag_list_show">
                                <ul>
                                    <div>
                                        <?php foreach($b['suit'] as $k=>$s):?>
                                            <?php if($k<=11){?>
                                                <li>
                                                    <?php if($s['img']){?>
                                                        <img src="<?='/'.$this->config->item('upload_taxonomy').'/'.$s['img']?>">
                                                    <?php }else{?>
                                                        <img height='42'src="/images/default_suit.png">
                                                    <?php }?>
                                                    <br><?=$s['name']?>
                                                </li>
                                            <?php }?>
                                        <?php endforeach ?>
                                    </div>
                                    <!--循环的li无论是否超出12个都要输出dmore-->
                                    <div class="dmore">
                                        <?php foreach($b['suit'] as $k=>$s):?>
                                            <?php if($k>11){?>
                                                <li><a href="#"><img src="/images/bb.jpg"><br><?=$s['name']?></a></li>
                                            <?php }?>
                                        <?php endforeach ?>
                                    </div>
                                    <div class="clear"></div>
                                </ul>
                            </div>
                            <?php if(count($b['suit'])>12){?>
                                <div class="mbag_dmore"><a class="mbagdmore" href="javascript:volid(0)"></a></div>
                            <?php } ?>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php }else{?>
                <div class="nofino"><img src="<?php echo base_url('images/noinfo.png');?>"><br>这家伙太懒了，什么都没留下！</div>
            <?php }?>

            <div class="page_link"><?=$pagelink?></div>
            <script type="text/javascript">
                $(".mbag_list_li .mbag_dmore").each(function(i){
                    $(this).click(function(){
                        $(".dmore").eq(i).slideToggle();
                    })
                })
            </script>

        </div>
        <div class="member_bag_r r">
            <div class="my_scbag">收藏的背包</div>
            <ul class="my_scbaglist">
                <?php if($f_bag){?>
                    <?php foreach($f_bag as $f):?>
                        <li><a href="javascript:;" onclick="get_suit('<?=site_url('user/get_bag_detail/'.($f['typeid']+1).'/'.$f['bagid'])?>')">
                                <?php if($f['img']){?>
                                    <img src="<?='/'.$this->config->item('upload_taxonomy').'/'.$f['img']?>">
                                <?php }else{?>
                                    <img src="<?php echo base_url()?>images/default_suit.png">
                                <?php }?>
                                <br><?=$f['name']?></a></li>
                    <?php endforeach?>
                <?php }else{ ?>
                    <li>暂无收藏</li>
                <?php } ?>
                <div class="clear"></div>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
    <!--背包-->
    <div class="clear"></div>

</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script>
    //删除背包
    function my_confirm(url){
        if(confirm("您确定要删除?")){
            window.location.href=url;
        }
    }
    //查看收藏装备详情
    var url='';
    function get_suit(url){
        $.layer({
            type: 2,
            shadeClose: true,
            title: false,
            closeBtn: [0, true],
            shade: [0.8, '#000'],
            border: [0],
            offset: ['70px',''],
            area: ['800px', ($(window).height() - 170) +'px'],
            iframe: {src: url}
        });
    }
</script>
</body>
</html>