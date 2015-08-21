<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--照片详情-->
<link href="<?=base_url().'js/super_slide/default.css'?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?=base_url().'js/super_slide/jQuery.blockUI.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/super_slide/jquery.SuperSlide.js'?>"></script>
<div id="demoContent" style="width: auto">
    <div class="effect">
        <div id="focusAd" class="tv-slideBox">
            <a class="prev"></a><a class="next"></a>
            <div class="bd">
                <ul>
                    <?php foreach($photo as $key=>$p):?>
                        <li class="li<?=$key?>">
                            <div class="pic"><img src="<?='/'.$this->config->item('upload_photo').'/'.$p['filename']?>"></div>
                        </li>
                    <?php endforeach?>

                </ul>
            </div>
            <div class="hd">

            </div>
        </div>

        <script language="javascript"> jQuery("#focusAd").slide({ mainCell:".bd ul",effect: "leftLoop",autoPlay:true});</script>
    </div>
</div>
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
</body>
</html>


