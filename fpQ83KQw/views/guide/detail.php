<?php $this->load->view('head_other_v1', array('currentTab' => 5)); ?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/guide.css">
<link rel="stylesheet" href="<?= WWW_domian ?>css/place.css">
<!--main-->
<div class="bg_f5">
    <div class="wp">
        <div class="strategy_place">
            <div class="place_name l">
                <div class="place_name_zh"><a href="<?=site_url('/place/index/pid/'.$guide['pid'])?>"><?= $guide['name_en'] ?></a></div>
                <div class="place_name_en"><a href="<?=site_url('/place/index/pid/'.$guide['pid'])?>"><?= $guide['name'] ?></a></div>
            </div>
            <div class="strategy_placer r">
                <div class="desti_right_share">
                    <a class="addthis_button_facebook"><img src="<?=base_url("images/facebook.png")?>"></a>
                    <a class="addthis_button_twitter"><img src="<?=base_url("images/tweet.png")?>"></a>
                    <a class="addthis_button_google_plusone_share"><img src="<?=base_url("images/google.png")?>"></a>
                    <a href="javascript:;" class="jiathis_button_tsina"><img src="http://www.gowildkid.com/images/sina.png"></a>
                    <a href="javascript:;"class="jiathis_button_weixin"><img src="http://www.gowildkid.com/images/weixin.png"></a>         </div>
                <div class="desti_right_sharelbot">全方位分享包括滑雪、钓鱼、潜水、登山、漂流、国家公园等专业户外运动的宝典</div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="strshowl l">
            <div class="strshowl_tit"><?= $guide['title'] ?></div>
            <div class="strshowl_des">
                更新时间：<span><?= date('Y-m-d', $guide['updated']) ?></span><br>
                文件大小：<span><?= $guide['size'] ?>/<?= $guide['pagenum'] ?>页</span><br>
                版本：<span><?= $guide['version'] ?></span><br>
                下载次数：<span><?= $guide['downs'] ?></span>
            </div>
            <div class="srtshowl_down"><a href="<?= site_url('guide/down/gid/' . $guide['gid'].'/url/2') ?>">免费下载</a>
            </div>
        </div>
        <div class="strshowr r">
            <div class="strshowr_ban">
                <div class="slider-wrapper theme-default">
                    <img src="<?= base_url() . $this->config->item('upload_guide_image') . '/' . $guide['img'] ?>"  />
                </div>
            </div>
            <div class="strshowr_intro">
                <div class="strshowr_intro_tit"><?= $guide['title'] ?>简介</div>
                <div class="strshowr_intro_des">
                    <?= $guide['description'] ?></div>
            </div>
            <div class="show_comment">
                <div class="show_comment_tit">评论</div>
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
                            <input type="hidden" name="gid" value="<?= $guide['gid'] ?>"/>
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
                                    <a href="<?=site_url('space/'.$v['uid'])?>" target="_blank"><img src="<?=IMG_domian?>avatar/<?=$v['uid']?>"></a>
                                </div>
                                <div class="show_commen_list_main l">
                                    <div class="show_commen_list_nc">
                                        <span style="padding-right: 10px"><a href="<?=site_url('space/'.$v['uid'])?>" target="_blank"><?= $v['username'] ?></a></span><?= date('Y-m-d H:i:s', $v['created']) ?></div>
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
                <div class="page_link"><?= $pagelink ?></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=WWW_domian?>js/jquery/jquery.validate.min.js"></script>
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
        }else {
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
</script>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-542389cc3d57e828"></script>
<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1" charset="utf-8"></script>
</body>
</html>
