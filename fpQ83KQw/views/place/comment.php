<?php  $this->load->view('head_other_v1',array('currentTab'=>1));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/place.css">
<!--main-->
<div class="desti_title">
    <div class="wp clear">
        <div class="l des_tit_wd">
            <div class="desti_route">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url()?>">野孩子</a></li>
                    <li><a href="<?=base_url("place")?>">目的地</a></li>
                    <?php foreach($top_parent as $k=>$v){
                        if($k>0){?>
                            <li><a href="<?php echo site_url('place/index/pid/'.$v[0])?>"><?=$v[1]?></a></li>
                        <?php }
                    }?>
                    <li class="active"><a href="<?=site_url('/place/index/pid/'.$place['pid'])?>"><?=$place['name']?></a></li>
                </ol>
            </div>
            <div class="desti_hd desti_en "><a href="<?=site_url('/place/index/pid/'.$place['pid'])?>"><?=$place['name_en']?></a></div>
            <div class="desti_hd desti_ch "><a href="<?=site_url('/place/index/pid/'.$place['pid'])?>"><?=$place['name']?></a></div>
        </div>
        <div class="r des_tit_wd">
            <div class="desti_img">
                <?php  $blnShow = $visit && $visit['planto']==1; ?>
                <span id="plan">
                        <a data-pid="<?=$place['pid']?>" data-type="plan" data-value="1" href="javascript:void(0);" onclick="return false;" style="display:<?php echo $blnShow?'none':'' ?>;">
                            <img src="<?=base_url("images/des_ico1.png")?>">
                        </a>
                        <a data-pid="<?=$place['pid']?>" data-type="plan" data-value="0" href="javascript:void(0);" onclick="return false;" style="display:<?php echo $blnShow?'':'none' ?>;">
                            <img src="<?=base_url("images/des_ico12.png")?>">
                        </a>
                    </span>
                <?php  $blnShow = $visit && $visit['beento']==1; ?>
                <span id="been">
                        <a data-pid="<?=$place['pid']?>" data-type="been" data-value="1" href="javascript:void(0);" onclick="return false;" style="display:<?php echo $blnShow?'none':'' ?>;">
                            <img src="<?=base_url("images/des_ico2.png")?>">
                        </a>
                        <a data-pid="<?=$place['pid']?>" data-type="been" data-value="0" href="javascript:void(0);" onclick="return false;" style="display:<?php echo $blnShow?'':'none' ?>;">
                            <img src="<?=base_url("images/des_ico22.png")?>">
                        </a>
                    </span>
            </div>
            <div class="desti_all"><span><?php echo $sports_total; ?></span>个热门部落&nbsp; &nbsp;
                <span><?php echo $been_total;?></span>人去过这里&nbsp; &nbsp;
                <span><?php echo $comments_total;?></span>条目的地点评
            </div>
        </div>
    </div>
</div>
<div class="desti_menu_wp">
    <?php  if($top=='country'){?>
        <?php  $this->load->view('place/top1',array('currentTab' => 15));?>
    <?php }else{?>
        <?php  $this->load->view('place/top2',array('currentTab' => 15));?>
    <?php }?>
</div>
<div class="bg_f5">
    <div class="wp">
        <div class="l desti_left">
            <?php  $this->load->view('place/left');?>
        </div>
        <div class="r desti_right">
            <div class="desti_right_ban">
                <img src="<?php echo get_img_url($banner['img'],'828x315',2)?>">
            </div>
            <?php $this->load->view('share'); ?>
            <div class="desti_right_title">
                <div class="show_comment">
                    <div class="destin_w_comment"><a name="comment"></a>写点评<span class="score" style="padding:0px 10px;"></span><span id="function-hint" style="font-size: 25px"></span></div>
                    <?php echo $form; ?>
                    <div class="show_comment_text">
                        <textarea class="show_comment_area" onKeyUp="javascript:checkWord(this);"
                                  onMouseDown="javascript:checkWord(this);" name="comment" placeholder="撰写评论请先登录"></textarea>
                    </div>
                    <div class="show_comment_other">
                        <div class="l">还可以输入<span style="font-family: Georgia; font-size: 26px;" id="wordCheck">3000</span>个字符
                        </div>
                        <div class="r">
                            <input type="submit" value="提交" class="show_comment_sub"/>
                            <!--james 评分数值-->
                            <input type="hidden" name="score" value="3">
                            <input type="hidden" name="pid" value="<?= $place['pid'] ?>"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                    </form>
                    <div class="show_commen_ul">
                        <?php if ($comments) {
                            foreach ($comments as $k => $v) {
                                ?>
                                <div class="show_commen_list">
                                    <div class="show_commen_list_img l">
                                        <a href="<?=site_url()?>space/<?=$v['uid']?>" target="_blank"><img src="<?=IMG_domian?>avatar/<?=$v['uid']?>"></a>
                                    </div>
                                    <div class="show_commen_list_main l">
                                        <div class="show_commen_list_nc">
                                            <div class="user_score">
                                                <span><?= $v['username'] ?></span>&nbsp;&nbsp;
                                                <?php if(ereg("^[0-9][.][0-9]$",$v['score'])){?><!--判断评分是否是小数-->
                                                <?php for($i=0;$i<round($v['score']);$i++){?>
                                                    <?php if($i+1==round($v['score'])){?>
                                                        <span class="half_start"></span>

                                                    <?php }else{?>
                                                        <span class="green_start"></span>
                                                    <?php }?>
                                                <?php }?>
                                                <?php for($i=0;$i<5-round($v['score']);$i++){?>
                                                    <span class="gray_start"></span>
                                                <?php }?>
                                                <?php }else{?>
                                                    <?php for($i=0;$i<$v['score'];$i++){?>
                                                        <span class="green_start"></span>
                                                    <?php }?>
                                                    <?php for($i=0;$i<5-$v['score'];$i++){?>
                                                        <span class="gray_start"></span>
                                                    <?php }?>
                                                <?php }?>
                                                &nbsp;&nbsp;<?= date('Y-m-d H:i:s', $v['created']) ?>
                                            </div>
                                        </div>
                                        <div class="show_commen_listtxt">
                                            <?= $v['description'] ?>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            <?php
                            }
                        }?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="page_link"><?= $pagelink ?></div>
        </div>
        <!--介绍-->
    </div>
    <div class="clear"></div>
</div>
</div>
<!--main-->
<?php  $this->load->view('foot_v1');?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    function onSpClick(event) {
        var url, link = $(this);
        var pid = link.attr('data-pid');
        var type = link.attr('data-type');
        var value = link.attr('data-value');
        if (type=='plan') {
            url = g_siteUrl + 'place/ajax_plan?pid=' + pid + '&plan=' + value;
        }
        if (type=='been') {
            url = g_siteUrl + 'place/ajax_been?pid=' + pid + '&been=' + value;
        }

        $.ajax({
            url: url,
            dataType: 'json',
            success: function(res) {
                if (res.code == -1) {
                    location = res.url;
                } else {
                    link.parent().find('a').show();
                    link.parent().find('a[data-value="'+res+'"]').hide();
                }
            },
            error: function() {
                return false;
            }
        });
    }
    $(document).delegate('#plan a,#been a', 'click', onSpClick);
</script>
<script>
    $(function () {
        $("#form1").validate({
            rules: {
                comment: "required"

            },
            success: function (em) {
                em.text("").addClass("success");
            },
            messages: {
                comment: "请输入评论内容"

            }
        });
    });
</script>
<script>

    var maxstrlen = 3000;

    function Q(s) {
        return document.getElementById(s);
    }

    function checkWord(c) {

        len = maxstrlen;

        var str = c.value;

        myLen = getStrleng(str);

        var wck = Q("wordCheck");

        if (myLen > len * 2) {

            c.value = str.substring(0, i + 1);

        }

        else {

            wck.innerHTML = Math.floor((len * 2 - myLen) / 2);

        }

    }

    function getStrleng(str) {

        myLen = 0;

        i = 0;

        for (; (i < str.length) && (myLen <= maxstrlen * 2); i++) {

            if (str.charCodeAt(i) > 0 && str.charCodeAt(i) < 128)

                myLen++;

            else

                myLen += 2;

        }

        return myLen;

    }
    //评分js jamse add

    //平均分的js
    $(function() {
        $.fn.raty.defaults.path = '<?=base_url().'images'?>';
        $('.avg_score').raty({
            number: 5,//多少个星星设置
            score: <?=$avg?>,//初始值是设置
            half:true,
            targetType: 'number',//类型选择，number是数字值，hint，是设置的数组值
            cancelOff : 'cancel-off-big.png',
            cancelOn  : 'cancel-on-big.png',
            size      : 24,
            starHalf  : 'pink_harf.png',
            starOff   : 'blue_s.png',
            starOn    : 'red_s.png',
            target    : '#function-hint',
            cancel    : false,
            targetKeep: true,
            readOnly  : true,
            hints     : ['非常差', '差', '一般', '好', '非常好'],
            precision : false//是否包含小数
        });
    });
    $(function() {
        $.fn.raty.defaults.path = '<?=base_url().'images'?>';
        $('.score').raty({
            number: 5,//多少个星星设置
            score: 3,//初始值是设置
            half:true,
            targetType: 'number',//类型选择，number是数字值，hint，是设置的数组值
            cancelOff : 'cancel-off-big.png',
            cancelOn  : 'cancel-on-big.png',
            size      : 24,
            starHalf  : 'green_harf.png',
            starOff   : 'blue_s2.png',
            starOn    : 'green_s.png',
            target    : '#function-hint',
            cancel    : false,
            targetKeep: true,
            hints     : ['非常差', '差', '一般', '好', '非常好'],
            precision : false,//是否包含小数
            click: function(score, evt) {
                $("input[name='score']").val(score);
                // alert('ID: ' + $(this).attr('class') + "\nscore: " + score + "\nevent: " + evt.type);
            }
        });
    });
</script>
</body>
</html>