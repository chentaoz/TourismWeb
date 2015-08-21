<?php $this->load->view('head_other_v1', array('currentTab' => 3)); ?>
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
<div class="bag">
    <div class="destination_bg" style="background-image: url(<?= base_url() . $this->config->item('upload_ad') . '/' . $back['img'] ?>)">
        <div class="destin_ser">
            <div class="destin_ser_ad">你好，背包！</div>
            <div class="destin_form">
                <div class="destin_ser_input" id="destin_ser_input">
                    <form target="_blank" onsubmit="return false;">
                        <input type="text" id="search-box" placeholder="搜索部落" class="destin_input l"
                               autocomplete="off"/>
                        <input type="button" id="search-btn" value="" class="desti_sersub l"/>
                        <div class="clear"></div>
                    </form>
                    <div id="tipsList" class="tip_indschlay tip_schlay" style="display: none;">
                    </div>
                </div>
                <div class="destin_ser_hot">热门背包：<a href="#">滑雪背包</a><a href="#">登山背包</a></div>
            </div>
        </div>
    </div>
    <div class="wp">
        <div class="tab-title"><span>全部部落</span></div>
        <div class="activity_wp">
            <div class="activity_left l">
                <?php foreach ($sport as $key => $t){ ?>
                    <div class="acitvity_switch_but <?php if ($key == 0) {
                        echo 'acitvity_switch_on';
                    } ?>">
                        <?= $t['name'] ?>
                    </div>
                <?php } ?>
                <div class="clear"></div>
            </div>
            <div class="activity_right r" id="activity-list">
                <?php foreach ($sport as $key => $t){ ?>
                    <div class="activity_switch_con" <?php if ($key == 0) {
                        echo 'style="display:block"';
                    } ?>>
                        <ul>
                            <?php foreach ($t['child'] as $s): ?>
                                <li data-spid="<?= $s['spid'] ?>"><a href="javascript:void(0);" onclick="return false;"><img
                                            src="<?php echo base_url($this->config->item('upload_sports_icon').'/'.$s['img']); ?>"><br>
                                        <?= $s['name'] ?>
                                    </a></li>
                            <?php endforeach ?>
                            <div class="clear"></div>
                        </ul>
                    </div>
                <?php } ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="tab-title"><span>装备列表</span></div>
        <div class="switch_cont margin_bottom70" id="bblist">

        </div>
    </div>
</div>
<!--main-->
<textarea style="display:none;" id="tmplBbList">
    <ul class="bblist">
        <%
        for (var i = 0; i < list.length; i++) {
        var item = list[i]; %>
        <li><img src="<?php echo IMG_domian . $this->config->item('upload_taxonomy') . '/'; ?><%#item.img%>"><br><%#item.name%></li>
        <% } %>
        <%
        for (var i = 0; i < 1; i++) {
        var item = list[i]; %>
        <div class="bb_soucang r"><a href="<?=site_url('bag/bag_favorites/bagid')?>/<%#item.bag_termid%>">收藏背包</a></div>
        <% } %>
        <div class="clear"></div>
    </ul>
</textarea>
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('#search-btn').click(function(){
            var $link=$('#tipsList ul li a');
            $link.click();
        });
    });
</script>
<script type="text/javascript">
    $(".activity_left .acitvity_switch_but").each(function (i) {
        $(this).click(function () {
            $(".acitvity_switch_but").removeClass("acitvity_switch_on");
            $(this).addClass("acitvity_switch_on");
            $(".activity_right .activity_switch_con").hide();
            $(".activity_right .activity_switch_con").eq(i).show();
        })
    });
    function onSpClick(event) {
        var spid = $(this).attr('data-spid');
        location = '#bblist';
        $.ajax({
            url: g_siteUrl + 'bag/ajax_bag?spid=' + spid,
            dataType: 'json',
            success: function (res) {
                var str = $.tmpl($('#tmplBbList').val(), {
                    list: res
                });
                $('#bblist').html(str);
            },
            error: function () {
                $('#bblist').html('');
            }
        });
    }
    $(document).delegate('#activity-list li', 'click', onSpClick);
    $(document).delegate('#tipsList li', 'click', onSpClick);
</script>
</body>
</html>