<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--member-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>5));?>
	<div class="member_myphoto">
		<div class="myphoto_title"><a  href="<?=site_url('user/photo')?>">我的照片</a><a class="photo_on"href="<?=site_url('user/album')?>">我的相册</a></div>
        <div class="destin_line_title"><span>2014年</span></div>
        <div class="myphotos">
            <ul>
                <li>
                    <div class="big_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                    <div class="small_phtot">
                        <div class="l s_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="l s_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="l s_photo no_mr"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="clear"></div>
                    </div>
                    <div class="photo_month">美国</div>
                </li>
                <li>
                    <div class="big_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                    <div class="small_phtot">
                        <div class="l s_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="l s_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="l s_photo no_mr"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="clear"></div>
                    </div>
                    <div class="photo_month">加拿大</div>
                </li>
                <li>
                    <div class="big_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                    <div class="small_phtot">
                        <div class="l s_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="l s_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="l s_photo no_mr"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="clear"></div>
                    </div>
                    <div class="photo_month">加拿大</div>
                </li>
                <li class="no_mr">
                    <div class="big_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                    <div class="small_phtot">
                        <div class="l s_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="l s_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="l s_photo no_mr"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="clear"></div>
                    </div>
                    <div class="photo_month">加拿大</div>
                </li>
                <li>
                    <div class="big_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                    <div class="small_phtot">
                        <div class="l s_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="l s_photo"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="l s_photo no_mr"><a href="#"><img src="/images/index_ban.jpg"></a></div>
                        <div class="clear"></div>
                    </div>
                    <div class="photo_month">加拿大</div>
                </li>
                <li>
                    <div id="creat_album"><a id="idBoxOpen" href="javascript:void(0)">创建相册</a></div>
                </li>
                <div class="clear"></div>
            </ul>
        </div>
	</div>
</div>
<!--member-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
</body>
</html>