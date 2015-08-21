<!--foot-->
<div id="footer" class="footer">
    <div class="container wp">
        <div class="row wp-row">
            <div class="col-md-2 wp-link">
                <div class="foot_nav_tit font_sont">关于我们</div>
                <div class="font_nav_list font_sont"><a href="#">野孩子简介</a></div>
                <div class="font_nav_list font_sont"><a href="#">联系我们</a></div>
                <div class="font_nav_list font_sont"><a href="#">合作伙伴</a></div>
            </div>
            <div class="col-md-2 wp-link">
                <div class="foot_nav_tit font_sont">加入野孩子</div>
                <div class="font_nav_list font_sont"><a href="#">招聘职位</a></div>
            </div>
            <div class="col-md-2 wp-link">
                <div class="foot_nav_tit font_sont">网站条款</div>
                <div class="font_nav_list font_sont"><a href="#">会员条款</a></div>
                <div class="font_nav_list font_sont"><a href="#">社区指南</a></div>
                <div class="font_nav_list font_sont"><a href="#">版权声明</a></div>
                <div class="font_nav_list font_sont"><a href="#">免责声明</a></div>
            </div>
            <div class="col-md-2 wp-link">
                <div class="foot_nav_tit font_sont">帮助中心</div>
                <div class="font_nav_list font_sont"><a href="#">新手上路</a></div>
                <div class="font_nav_list font_sont"><a href="#">使用帮助</a></div>
                <div class="font_nav_list font_sont"><a href="#">网站地图</a></div>
            </div>
            <div class="col-md-2 wp-link wp-link-share">
                <div class="foot_nav_tit font_sont">关注我们</div>
                <div class="fico">
                    <a href="#"><img src="<?=WWW_domian?>images/f1.png"></a><a href="#"><img src="<?=WWW_domian?>images/f2.png"></a><a href="#"><img src="<?=WWW_domian?>images/f3.png"></a><br>
                    <a href="#"><img src="<?=WWW_domian?>images/f4.png"></a><a href="#"><img src="<?=WWW_domian?>images/f5.png"></a><a href="#"><img src="<?=WWW_domian?>images/f6.png"></a>
                </div>
            </div>

            <div class="col-md-2 wp-link-app r">
                <div class="r"><a href="#"><img src="<?=WWW_domian?>images/app.png"></a></div>
            </div>
        </div>
        <div class="row wildkid-copy wp-row">
            <div class="col-md-12">
                <div class="foot_logo l">
                    <a href="<?=WWW_domian?>"><img src="<?=WWW_domian?>images/flogo.png"></a>
                </div>
                <div class="foot_copy font_sont l">
                    2004-2014@野孩子网yehaiz.com All rights reserved.京ICP备12003524号 京公网安备11010502023470<br>
                    野孩子网为旅行者提供实用的出境游旅行指南和旅游攻略、旅行社区和问答交流平台，并提供签证、保险、机票、酒店预订、租车等服务。<br>
                    欢迎来到野孩子网旅行目的地！野孩子的目的地汇聚精心编撰的旅行目的地概况、签证与出入境、穷游旅游景点、购物攻略、特色美食、交通指南、穷游旅行地图、游记攻略特价酒店、娱乐活动等穷游旅行指南。
                </div>
            </div>
        </div>
    </div>
</div>
<div class="up-img">
    <a href="javascript:;"></a>
</div>
<script type="text/javascript">
    $(function(){
        $(".lg_img").height($(document).height()-$(".common_topbg").height());
        $(".up-img a").click(function(){
            $("body,html").animate({scrollTop:0})
        });
        $(window).scroll(function(){
            if($(window).scrollTop()>50){
                $(".up-img").show();
            }else{
                $(".up-img").hide();
            }
        });
    });
</script>
<!--foot-->