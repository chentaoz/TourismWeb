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
                    2015@野孩子 All rights reserved.<br>
                    野孩子，让你的旅行“野”起来！<br />
                    一起唤醒心中的野孩子，让生活更好玩！
                </div>
            </div>
        </div>
    </div>
</div>
<div class="up-img">
    <a href="javascript:;"></a>
</div>
<script type="text/javascript">
    var tempRes="";
    function goSearch(){
        $('#input-group-search form').each(function(){
            $(this).submit();
        });
    }
    $(function(){
        $('#search-btn').click(function(){
            var $link=$('#tipsList ul li a');
            if($link.length>0){window.location.href="<?=site_url('')?>"+$link.attr('href');}
        });
    });

    $(function() {
        var input = $('#scform_srchtxt');
        var list = $('#head_tipsList');
        var lastValue, delayTimeout;
        var listTmpl =  '\
<% if (list.length) { %>\
     筛选： <a class="select1" id="select1" onmouseover="select(1)"><b>目的地</b></a>  <a class="select2" id="select2" onmouseover="select(2)" ><b>部落</b></a>  <a class="select3" id="select3" onmouseover="select(3)"><b>问题</b></a>  |<a class="select0" id="select0" onmouseover="select(0)"><b>全部</b></a> |<a onclick="goSearch()"><b>去论坛搜搜看...</b></a> \
    <ul>\
    <% var flag=true; var flag1=true; for (var i=0; i<list.length; i++) { var item=list[i]; if(item==1 || item=="1"){flag=false; flag1=true; continue;} if(item==2 || item=="2"){flag1=false; flag=false; continue;}if(flag && flag1){%>\
        <li class="<%=(i==0?"highlight1":"")%>"><a href="place/index/pid/<%=jQuery.escape(item.pid)%>" target="_blank"><%=jQuery.escape(item.name)%> - <%=jQuery.escape(item.name_en)%></a></li>\
    <% } else if(!flag1&& !flag){%>\<li class="<%=(i==0?"highlight1":"")%>"><a href="question/detail/<%=jQuery.escape(item.id)%>" target="_blank">相关问题：<%=jQuery.escape(item.title.substring(1,10)+"...")%> </a></li>\<%} else if(flag1&& !flag){%>\
	<li class="<%=(i==0?"highlight1":"")%>"><a href="sport/detail/spid/<%=jQuery.escape(item.spid)%>" target="_blank"><%=jQuery.escape(item.name)%> - <%=jQuery.escape(item.name_en)%></a></li>\<%}%>\
    </ul>\
<% }} else { %>\
    <span>未找到相关目的地，部落以及相关问题......<br/><a onclick="goSearch()">点击搜索到<b>论坛</b></a>查找相关话题</span>\
<% } %>';

        function onInput() {
            var value =  this.value;
            if (!value) {
                clearTimeout(delayTimeout);
                lastValue = '';
                return list.html('').hide();
            }
            if (value == lastValue) return;
            lastValue = value;

            clearTimeout(delayTimeout);
            delayTimeout = setTimeout(function() {
                ajaxSend(value);
            }, 200);
        }

        function ajaxSend(value) {
            $.ajax({
                url:g_siteUrl+'place/auto_searchforboth?key=' + encodeURIComponent(value),
                dataType:'json',
                success: function(res) {
                    if (lastValue != value) return;
                    tempRes=res;
                    list.html($.tmpl(listTmpl, {list:res})).show();
                    var elements=document.getElementsByClassName("select0");
                    for(var i=0; i<elements.length;i++){
                        elements[i].style.color="blue";

                    }

                },
                error: function() {
                    list.html($.tmpl(listTmpl, {list:[]})).show();
                }
            });
        }
        function onArrowInput(event) {
            if (list.css('display') == 'none') return;
            var key = event.keyCode;
            if (key == 38) {
                var current = $('#head_tipsList li.highlight1').removeClass('highlight1');
                current.prev().addClass('highlight1');
                if (!$('#head_tipsList li.highlight1').length) {
                    $('#head_tipsList li:last').addClass('highlight1');
                }
                event.preventDefault();
            } else if (key == 40) {
                var current = $('#head_tipsList li.highlight1').removeClass('highlight1');
                current.next().addClass('highlight1');
                if (!$('#head_tipsList li.highlight1').length) {
                    $('#head_tipsList li:first').addClass('highlight1');
                }
                event.preventDefault();
            }
        }
        function onEnterInput(event) {
            if (list.css('display') == 'none') return;
            if (event.keyCode == 13) {
                var href = $('#head_tipsList li.highlight1 a').prop('href');
                if (href) {
                    window.open(href, '_blank');
                    event.preventDefault();
                }
            }
        }
        input.on('keydown', onArrowInput);
        input.on('keydown', onEnterInput);
        input.on('input', onInput);
        input.on('keyup', onInput);
        input.on('focus', onInput);
        $(document.body).delegate('#head_tipsList li', 'mouseenter', function() {
            $('#head_tipsList li.highlight1').removeClass('highlight1');
            $(this).addClass('highlight1');
        });
        $(document.body).on('click', function(event){
            if (!$(event.target).parents('#input-group-search').length) {
                list.hide();
                clearTimeout(delayTimeout);
                lastValue = '';
            }
        });
    });
    function select(type){



        if(type==1){   //目的地
            var list = $('#head_tipsList');
            var listTmpl = '\
<% if (list.length) { %>\
     筛选： <a class="select1" onmouseover="select(1)"><b>目的地</b></a>  <a class="select2" onmouseover="select(2)" ><b>部落</b></a>  <a class="select3" onmouseover="select(3)"><b>问题</b></a>  |<a class="select0" onmouseover="select(0)"><b>全部</b></a> |<a onclick="goSearch()"><b>去论坛搜搜看...</b></a> \
    <ul>\
    <% var flag=true; var flag1=true; for (var i=0; i<list.length; i++) { var item=list[i]; if(item==1 || item=="1"){flag=false; flag1=true; break;} if(item==2 || item=="2"){flag1=false; flag=false; continue;}if(flag && flag1){%>\
        <li class="<%=(i==0?"highlight1":"")%>"><a href="place/index/pid/<%=jQuery.escape(item.pid)%>" target="_blank"><%=jQuery.escape(item.name)%> - <%=jQuery.escape(item.name_en)%></a></li>\
    <% } else if(!flag1&& !flag){%>\<li class="<%=(i==0?"highlight1":"")%>"><a href="question/detail/<%=jQuery.escape(item.id)%>" target="_blank">相关问题：<%=jQuery.escape(item.title.substring(1,10)+"...")%> </a></li>\<%} else if(flag1&& !flag){%>\
	<li class="<%=(i==0?"highlight1":"")%>"><a href="sport/detail/spid/<%=jQuery.escape(item.spid)%>" target="_blank"><%=jQuery.escape(item.name)%> - <%=jQuery.escape(item.name_en)%></a></li>\<%}%>\
    </ul>\
<% }} else { %>\
    <span>未找到相关目的地，部落以及相关问题......<br/><a onclick="goSearch()">点击搜索到<b>论坛</b></a>查找相关话题</span>\
<% } %>';

            list.html($.tmpl(listTmpl, {list:tempRes})).show();
            var elements=document.getElementsByClassName("select"+type);
            for(var i=0; i<elements.length;i++){
                elements[i].style.color="blue";

            }

        }
        else if(type==2){   //部落
            var list = $('#head_tipsList');
            var listTmpl = '\
<% if (list.length) { %>\
     筛选： <a class="select1" onmouseover="select(1)"><b>目的地</b></a>  <a class="select2" onmouseover="select(2)" ><b>部落</b></a>  <a class="select3" onmouseover="select(3)"><b>问题</b></a>  |<a class="select0" onmouseover="select(0)"><b>全部</b></a> |<a onclick="goSearch()"><b>去论坛搜搜看...</b></a> \
    <ul>\
    <% var flag=true; var flag1=true; for (var i=0; i<list.length; i++) { var item=list[i]; if(item==1 || item=="1"){flag=false; flag1=true; continue;} if(item==2 || item=="2"){flag1=false; flag=false; continue;}if(flag1&& !flag){%>\
	<li class="<%=(i==0?"highlight1":"")%>"><a href="sport/detail/spid/<%=jQuery.escape(item.spid)%>" target="_blank"><%=jQuery.escape(item.name)%> - <%=jQuery.escape(item.name_en)%></a></li>\<%}%>\
    </ul>\
<% }} else { %>\
    <span>未找到相关目的地，部落以及相关问题......<br/><a onclick="goSearch()">点击搜索到<b>论坛</b></a>查找相关话题</span>\
<% } %>';

            list.html($.tmpl(listTmpl, {list:tempRes})).show();
            var elements=document.getElementsByClassName("select"+type);
            for(var i=0; i<elements.length;i++){
                elements[i].style.color="blue";

            }

        }
        else if(type==3){   //问题
            var list = $('#head_tipsList');
            var listTmpl = '\
<% if (list.length) { %>\
     筛选： <a class="select1" onmouseover="select(1)"><b>目的地</b></a>  <a class="select2" onmouseover="select(2)" ><b>部落</b></a>  <a class="select3" onmouseover="select(3)"><b>问题</b></a>  |<a class="select0" onmouseover="select(0)"><b>全部</b></a> |<a onclick="goSearch()"><b>去论坛搜搜看...</b></a> \
    <ul>\
    <% var flag=true; var flag1=true; for (var i=0; i<list.length; i++) { var item=list[i]; if(item==1 || item=="1"){flag=false; flag1=true; continue;} if(item==2 || item=="2"){flag1=false; flag=false; continue;} if(!flag1&& !flag){%>\
<li class="<%=(i==0?"highlight1":"")%>"><a href="question/detail/<%=jQuery.escape(item.id)%>" target="_blank">相关问题：<%=jQuery.escape(item.title.substring(1,10)+"...")%> </a></li>\<%}%>\
    </ul>\
<% }} else { %>\
    <span>未找到相关目的地，部落以及相关问题......<br/><a onclick="goSearch()">点击搜索到<b>论坛</b></a>查找相关话题</span>\
<% } %>';

            list.html($.tmpl(listTmpl, {list:tempRes})).show();
            var elements=document.getElementsByClassName("select"+type);
            for(var i=0; i<elements.length;i++){
                elements[i].style.color="blue";

            }

        }
        else if(type==0){//全部
            var list = $('#head_tipsList');
            var listTmpl = '\
<% if (list.length) { %>\
     筛选： <a class="select1" onmouseover="select(1)"><b>目的地</b></a>  <a class="select2" onmouseover="select(2)" ><b>部落</b></a>  <a class="select3" onmouseover="select(3)"><b>问题</b></a>  |<a class="select0" onmouseover="select(0)"><b>全部</b></a> |<a onclick="goSearch()"><b>去论坛搜搜看...</b></a> \
    <ul>\
    <% var flag=true; var flag1=true; for (var i=0; i<list.length; i++) { var item=list[i]; if(item==1 || item=="1"){flag=false; flag1=true; continue;} if(item==2 || item=="2"){flag1=false; flag=false; continue;}if(flag && flag1){%>\
        <li class="<%=(i==0?"highlight1":"")%>"><a href="place/index/pid/<%=jQuery.escape(item.pid)%>" target="_blank"><%=jQuery.escape(item.name)%> - <%=jQuery.escape(item.name_en)%></a></li>\
    <% } else if(!flag1&& !flag){%>\<li class="<%=(i==0?"highlight1":"")%>"><a href="question/detail/<%=jQuery.escape(item.id)%>" target="_blank">相关问题：<%=jQuery.escape(item.title.substring(1,10)+"...")%> </a></li>\<%} else if(flag1&& !flag){%>\
	<li class="<%=(i==0?"highlight1":"")%>"><a href="sport/detail/spid/<%=jQuery.escape(item.spid)%>" target="_blank"><%=jQuery.escape(item.name)%> - <%=jQuery.escape(item.name_en)%></a></li>\<%}%>\
    </ul>\
<% }} else { %>\
    <span>未找到相关目的地，部落以及相关问题......<br/><a onclick="goSearch()">点击搜索到<b>论坛</b></a>查找相关话题</span>\
<% } %>';

            list.html($.tmpl(listTmpl, {list:tempRes})).show();
            var elements=document.getElementsByClassName("select0");
            for(var i=0; i<elements.length;i++){
                elements[i].style.color="blue";

            }


        }

    }
</script>
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
<script async="" src="<?=base_url()?>js/analytics.js"></script>
<!--foot-->
<script type="text/javascript" src="<?=WWW_domian?>js/jquery/jquery.placeholder.min.js"></script>
<script type="text/javascript">
    $(function() {
        if(!"placeholder" in document.createElement("input")){
            $("#scform_srchtxt").placeholder();
        }
    });
</script>
<script type="text/javascript" src="<?=base_url()?>js/layer-v1.8.5/layer/layer.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/layer-v1.8.5/layer/extend/layer.ext.js"></script>

