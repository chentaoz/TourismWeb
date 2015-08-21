<?php $this->load->view('head_other_v1', array('currentTab' => 5)); ?>
<style type="text/css">
    .tip_schlay {
        position: relative;
        z-index: 99;
        border: 1px solid #c0c0c0;
        background: #fff;
    }
    .tip_schlay ul {
        width: 100%;
        overflow: hidden;
    }
    .tip_schlay li {
        width: 100%;
        overflow: hidden;
        border-bottom: 1px solid #ececec;
    }
    .highlight {
        background: #e0f1df;
    }
    .tip_schlay li a {
        display: block;
        height: 32px;
        overflow: hidden;
        padding: 0 10px;
        line-height: 32px;
        color: #323232;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>
    <!--main-->
    <div class="guide">
        <div class="wp">
            <div class="strategy_ban">
                <div class="strategy_ser" id="destin_ser_input">
                    <form target="_blank" onsubmit="return false;">
                        <input type="text" id="search-box" class="l form-control strtegy_input " placeholder="搜索野孩子宝典"  />
                        <input type="button" id="search-btn" class="r strtegy_sub" value=""/>
                        <div class="clear"></div>
                    </form>
                    <div id="tipsList" class="tip_indschlay tip_schlay" style="display: none;">
                    </div>
                </div>
            </div>
            <div class="hot_strategy l">
                <div class="hot_strategy_tit">热门宝典</div>
                <ul class="strategy_hotlist">
                    <?php if ($guide_hot) {
                        foreach ($guide_hot as $k => $v) { ?>
                            <li>
                                <div class="author_img l">
                                    <img src="<?= base_url() . $this->config->item('upload_guide_image') . '/' . $v['img'] ?>">
                                </div>
                                <div class="hot_other l">
                                    <div class="tit"><a href="<?=site_url('guide/detail/gid/'.$v['gid'])?>"><?= $v['title'] ?></a></div>
                                    <span class="view">已下载<?= $v['downs'] ?>次</span>
                                </div>
                                <div class="hot_li_des clear"><?= $v['description'] ?></div>
                            </li>
                        <?php
                        }
                    }?>
                    <div class="clear"></div>
                </ul>
            </div>
            <div class="index_ban_right strategy_js  r">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php foreach ($banner as $k=>$b){ ?>
                            <li data-target="#carousel-example-generic" data-slide-to="<?=$k?>" <?php if($k==0){ echo 'class="active"';}?>>
                            </li>
                        <?php } ?>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php foreach ($banner as $k=>$b){ ?>
                            <div class="item<?php if($k==0){ echo ' active';}?>">
                                <img src="<?= base_url() . $this->config->item('upload_ad') . '/' . $b['img'] ?>" alt="">
                                <a href="<?php echo $b['weblink']?$b['weblink']:'javascript:;'; ?>"><div class="carousel-caption">
                                </div></a>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="clear"></div>
            <div class="bj_recommend">
                <div class="green_tit">编辑推荐</div>
                <ul class="bj_recommend_ul">
                    <?php if ($guide_recommend) {
                        foreach ($guide_recommend as $k => $v) {
                            ?>
                            <li>
                                <div class="bj_thumb"><a href="<?=site_url('guide/detail/gid/'.$v['gid'])?>"><img
                                            src="<?php echo get_img_url($v['img'],'140x180',3);?>"/></a>
                                </div>
                                <div class="bj_title"><a href="<?=site_url('guide/detail/gid/'.$v['gid'])?>"><?= $v['title'] ?></a></div>
                                <div class="bj_download"><a href="<?=site_url('guide/down/gid/'.$v['gid'].'/url/1')?>">免费下载</a></div>
                            </li>
                        <?php
                        }
                    } ?>
                    <div class="clear"></div>
                </ul>
            </div>
            <div class="now_strategy l">
                <div class="hot_strategy_tit">刚刚下载的宝典</div>
                <ul class="strategy_hotlist">
                    <?php if($guide_user){
                        foreach($guide_user as $k=>$v){?>
                            <li>
                                <div class="author_img l">
                                    <a target="_blank" href="<?=site_url('space/'.$v['uid'])?>"><img src="<?=IMG_domian?>avatar/<?=$v['uid']?>"></a>
                                </div>
                                <div class="hot_other l">
                                    <div class="tit"><a href="<?=site_url('guide/detail/gid/'.$v['gid'])?>"><?=$v['title']?></a></div>
                                    <span class="view">下载时间：<?= date('Y-m-d H:i:s',$v['created'])?></span>
                                </div>
                                <div class="hot_li_des clear"><?=$v['description']?></div>
                            </li>
                        <?php }
                    }?>
                    <div class="clear"></div>
                </ul>
            </div>
            <div class="strategy_all r">
                <div class="green_tit">全部宝典</div>
                <ul class="bj_recommend_ul">
                    <?php if ($guides) {
                        foreach ($guides as $k => $v) {
                            ?>
                            <li>
                                <div class="bj_thumb"><a href="<?=site_url('guide/detail/gid/'.$v['gid'])?>"><img
                                            src="<?php echo get_img_url($v['img'],'140x180',3);?>"/></a>
                                </div>
                                <div class="bj_title"><a href="<?=site_url('guide/detail/gid/'.$v['gid'])?>"><?= $v['title'] ?></a></div>
                                <div class="bj_download"><a href="<?=site_url('guide/down/gid/'.$v['gid'].'/url/1')?>">免费下载</a></div>
                            </li>
                        <?php
                        }
                    }?>
                    <div class="clear"></div>
                </ul>
            </div>
        </div>
    </div>
    <!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('#search-btn').click(function(){
            var $link=$('#tipsList ul li a');
            if($link.length>0){window.location.href="<?=site_url('')?>"+$link.attr('href');}
        });
//        $(".carousel .item img").width()/$(".carousel .item img").height();
//        $(".carousel .item img,.carousel .item,.carousel").height($(".carousel .item img").width()/1.82);
    });
</script>
</body>
</html>