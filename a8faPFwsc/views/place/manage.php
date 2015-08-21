
</head>
<body>
<div id="menu">
    <h3>目的地列表</h3>
    <input type="text" id="sear" rows="1" placeholder="搜索相关目的地"/>
		<div id="head_tipsList" class="tip_indschlay1 tip_schlay1" style="display: none; position:absolute">
                    </div>
    <br/>
    <button id="se" class="submit">点击搜索</button>
    <?php
    function showchildname($array,$parent_arr=array()) {
        if (is_null($array)) return;
        if (!count($array)) return;

        echo '<ul>';
        foreach($array as $k=>$v){
            echo '<li>';
            $parent_array=$parent_arr;
            $parent_array[]=preg_replace('/\s+/', '', $v['name']);
            if ($v['child'] && count($v['child'])) {
                echo '<em id="'.preg_replace('/\s+/', '', trim($v['name'])).'"attrv="'.trim(implode(" ",$parent_array)).'"></em>';
            }
			else{
				echo '<a  id="'.preg_replace('/\s+/', '', trim($v['name'])).'"attrv="'.trim(implode(" ",$parent_array)).'" ></a>';
			}
            echo '<div class="J-li"><a href="javascript:void(0);">'.$v['name'].'</a>&nbsp;<span class="J-op">&nbsp;<a href="edit/id/'.$v['pid'].'" class="item">编辑</a>&nbsp;<a href="child_add/id/'.$v['pid'].'" class="item">新增子级</a>';
            if($v['deep']>0){
                echo '&nbsp;<a href="img_add/id/'.$v['pid'].'" class="item">图片管理</a>';
            }
            if($v['deep']>1){
                echo '&nbsp;<a href="place_guide/id/'.$v['pid'].'" class="item">目的地攻略</a>';
            }
            if (!$v['child'] || !count($v['child'])) {
				echo '&nbsp;<a href="sport_add/id/'.$v['pid'].'" class="item">运动管理</a>&nbsp;<a href="javascript:void(0)" onclick="delAlert(\''.site_url('place/del/id/'.$v['pid']).'\');" class="item">删除</a>';
			}
			echo '</span></div>';
            showchildname($v['child'],$parent_array);
            echo '</li>';
        }
        echo '</ul>';
    }

    showchildname($parent);
    ?>
</div>
<script type="text/javascript" src="<?=WWW_domian?>js/common.js"></script>
 



<script type="text/javascript" src="<?=WWW_domian?>js/jquery/jquery.placeholder.min.js"></script>

<script type="text/javascript">
var g_siteUrl = "<?=WWW_domian?>";
    (function(e){
        for(var _obj=document.getElementById(e.id).getElementsByTagName(e.tag),i=-1,em;em=_obj[++i];){
            em.onclick = function(){ //onmouseover
                var ul = this.parentNode.getElementsByTagName('ul');
                if(!ul){return false;}
                ul = ul[0]; if(!ul){return false;}
                for(var _li=this.parentNode.parentNode.childNodes,n=-1,li;li=_li[++n];){
                    if(li.tagName=="LI"){
                        for(var _ul=li.childNodes,t=-1,$ul;$ul=_ul[++t];){
                            switch($ul.tagName){
                                case "UL":
                                    $ul.className = $ul!=ul?"" : ul.className?"":"off";
                                    break;
                                case "EM":
                                    $ul.className = $ul!=this?"" : this.className?"":"off";
                                    break;
                            }
                        }
                    }
                }
            }
        }
    })({id:'menu',tag:'em'});
	
	$(document).ready(function() {
        $('.J-li').hover(function(){
				$(this).css('backgroundColor','#dedede');
			},function(){
				$(this).css('backgroundColor','#fff');
				});
    });
    $("#se").click(function(){
        var str=$("#"+document.getElementById("sear").value.trim().replace(/ /g,'')).attr("attrv");
        str=str.trim();
        if(str==null){
            alert("未找到结果，可以输入其上一级目的地试试看");
            return;
        }
        var arr=str.split(" ");
        for(var i=0;i<arr.length;i++){
            if(!$("#"+arr[i].replace(/ /g,'')).hasClass("off"))
            $("#"+arr[i].replace(/ /g,'')).click();
        }
        var p = $("#"+document.getElementById("sear").value.trim().replace(/ /g,'')).position();
        $(window).scrollTop(p.top);
        //$("#"+document.getElementById("sear").value).click();
        //alert("#"+document.getElementById("sear").value);
    });
	/////////////////////////////////////////////////////////////////////////////
	
	
	
	$(function() {
    var input = $('#sear');
    var list = $('#head_tipsList');
    var lastValue, delayTimeout;
    var listTmpl =  '\
<% if (list.length) { %>\
    <ul>\
    <% for (var i=0; i<list.length; i++) { var item=list[i]; if(typeof item.name!=="undefined")var _itname=item.name.replace(/ /g,"");else var _itname="undefined"; %>\
        <li class="<%=(i==0?"highlight":"")%>"><a toat="<%=jQuery.escape(item.name)%>" class="find" onclick="findth(<%=jQuery.escape(_itname)%>,<%=_itname%>,this)" target="_blank"><%=jQuery.escape(item.name)%> - <%=jQuery.escape(item.name_en)%></a></li>\
    <% } %>\
    </ul>\
<% } else { %>\
    <span>没有结果</span>\
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
                list.html($.tmpl(listTmpl, {list:res})).show();
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
            var current = $('#head_tipsList li.highlight').removeClass('highlight');
            current.prev().addClass('highlight');
            if (!$('#head_tipsList li.highlight').length) {
                $('#head_tipsList li:last').addClass('highlight');
            }
            event.preventDefault();
        } else if (key == 40) {
            var current = $('#head_tipsList li.highlight').removeClass('highlight');
            current.next().addClass('highlight');
            if (!$('#head_tipsList li.highlight').length) {
                $('#head_tipsList li:first').addClass('highlight');
            }
            event.preventDefault();
        }
    }
    function onEnterInput(event) {
        if (list.css('display') == 'none') return;
        if (event.keyCode == 13) {
            var href = $('#head_tipsList li.highlight a').prop('href');
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
        $('#head_tipsList li.highlight').removeClass('highlight');
        $(this).addClass('highlight');
    });
    $(document.body).on('click', function(event){
        if (!$(event.target).parents('#input-group-search').length) {
            list.hide();
            clearTimeout(delayTimeout);
            lastValue = '';
        }
    });
});
	
	 function findth(place,place1,the_one){
		 document.getElementById("sear").value=the_one.getAttribute("toat");
	console.log(place);
	console.log(place1);
	if(typeof place === 'string' || place instanceof String)
	{
		var pl=place.trim().replace(/ /g,'');
		var str=$("#"+pl).attr("attrv");
	}
	else{
			var pl=place.getAttribute('id').replace(/ /g,'');
	//var str=place.trim();
	var str=place.getAttribute('attrv');
	}

	if(str==null){
            alert("未找到结果");
            return;
        }
        var arr=str.split(" ");
        for(var i=0;i<arr.length;i++){
            if(!$("#"+arr[i].replace(/ /g,'')).hasClass("off"))
            $("#"+arr[i].replace(/ /g,'')).click();
        }
        var p = $("#"+pl).position();
        $(window).scrollTop(p.top);
	}
	
	
	
</script> 