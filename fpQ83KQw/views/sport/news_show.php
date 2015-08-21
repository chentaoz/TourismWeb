<?php $this->load->view('head_other_v1', array('currentTab' => 2)); ?>
<style type="text/css">
    #article_content img{max-width: 100%;}
</style>
<!-- main-->
<div class="wp">
    <div class="tab-title">

    </div>
    <div class="activity_art">
        <div class="activity_art_left l">
            <!--            <div class="img"><img src="--><?php //echo get_img_url($detail['img'], '800x297', 10) ?><!--"/></div>-->
            <div class="title"><?php echo $detail['title']; ?></div>
            <p class="time">发表于： <?php echo date('Y-m-d',$detail['update'])?>    点击数：<?php echo $detail['hit']?></p>
            <div class="des"><?php echo $detail['abstract'] ?></div>
            <div class="tab-title"></div>
            <div class="activity_art">
                <div id="article_content" class="content">
                    <?php echo $detail['content'] ?>
                </div>
            </div>
            <div style="padding:20px 0; margin:20px 0; text-align:right;">
                <!-- JiaThis Button BEGIN -->
                <div class="jiathis_style_32x32">
                    <a class="jiathis_button_qzone"></a>
                    <a class="jiathis_button_tsina"></a>
                    <a class="jiathis_button_tqq"></a>
                    <a class="jiathis_button_weixin"></a>
                    <a class="jiathis_button_renren"></a>
                    <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                    <a class="jiathis_counter_style"></a>
                </div>
                <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1359044214954708" charset="utf-8"></script>
                <!-- JiaThis Button END -->
            </div>
        </div>
        <div class="hot_news r">
            <h3 class="least_news"><em>热门文章</em></h3>
            <ul>
                <?php foreach($latest_news as $ln){?>
                    <li class="clear">
                        <div class="hot_img"><a href="<?=site_url('sport/news_show/id/'.$ln['id'])?>">
                                <img src="<?php echo get_img_url($ln['img'], '60x60', 10) ?>" alt="<?=$ln['title']?>">
                            </a>
                        </div>
                        <div class="hot_title"><a href="<?=site_url('sport/news_show/id/'.$ln['id'])?>"><b><?=$ln['title']?></b></a></div>
                    </li>
                <?php }?>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!-- main-->
<?php $this->load->view('foot_v1'); ?>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
</body>
</html>