<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--top-->
<div class="wp">
    <?php $this->load->view('user_info_v1',array('user_currentTab'=>7));?>
    <div class="member_gl">
        <div class="member_gl_l l">
            <div class="tab">
                <?php if($isself){ ?>
                    <a class='my_class' href="<?php echo site_url('forum/post')?>">发表的帖子</a>
                    <a class='my_class acitvity_on' href="<?php echo site_url('forum/post_favorite')?>">收藏的帖子</a>
                <?php }else{?>
                    <a class='my_class' href="<?php echo site_url('forum/post/'.$member['uid'])?>">发表的帖子</a>
                    <a class='my_class acitvity_on' href="<?php echo site_url('forum/post_favorite/'.$member['uid'])?>">收藏的帖子</a>
                <?php }?>
                <div class="clear"></div>
            </div>
            <?php if($list){
                foreach($list as $item){ ?>
                    <div class="gl_list">
                        <div class="gl_list_tit"><span></span>
                            <a href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$item['tid']?>"><?=$item['subject']?></a>
                            <?php if($isself){ ?>
                                <a class='delete r' href='javascript:;' tid="<?=$item['tid']?>">删除</a>
                            <?php }?>
                        </div>
                        <div class="gllist_other">
                            <div class="gllist_other_l l">
                                <a href="<?=WWW_domian?>space/<?=$item['authorid']?>"><?=$item['author']?></a>&nbsp; |&nbsp; <?=date('Y-m-d',$item['dateline'])?>
                            </div>
                            <div class="gllist_other_r r">
                                <span class="view"><?=$item['views']?></span>
                                <span class="view_fx"><?=$item['replies']?></span>&nbsp; &nbsp;
                                <span class="last_time">|&nbsp; &nbsp; 最后回复：<?=date('Y-m-d H:i',$item['lastpost'])?></span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                <?php }
            }else{ ?>
                <div class="nofino gl_list" style="border:none"><img src="<?php echo base_url('images/noinfo.png');?>"><br>这家伙太懒了，什么都没留下！</div>
            <?php } ?>
            <div class="page_link">
                <?=$pagelink?>
            </div>
        </div>

        <div class="member_gl_r r">
            <?php $this->load->view('forum/forumnum');?>

            <div class="member_indexr_ctit">
                <div class="l">热门帖子</div>
                <div class="r"></div>
                <div class="clear"></div>
            </div>
            <ul class="glr_hotlist">
                <?php foreach($list_hot as $item){ ?>
                    <li>
                        <div class="yjgl_li_txt">
                            <div class="author_img l"><a href="<?php echo site_url('space/'.$item['authorid'])?>"><img src="<?=WWW_domian?>avatar/<?=$item['authorid']?>"></a></div>
                            <div class="yjgl_li_title l">
                                <div class="yjgl_li_tit"><a href="<?=BBS_domian?>forum.php?mod=viewthread&tid=<?=$item['tid']?>"><?=$item['subject']?></a></div>
                                <div class="yjgl_li_tit_other">
								<span class="yjglico">
									<span class="view"><?=$item['views']?></span><span class="view_fx"><?=$item['replies']?></span>
								</span>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="yjgl_li_des"><?=messagecutstr($item['message'],130)?></div>
                        </div>
                    </li>
                <?php }?>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
</body>
</html>