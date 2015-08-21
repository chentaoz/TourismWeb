!function() {
    var $div = $('<div></div>');
    $.escape = function(s) {
        return $div.text(s).html();
    };
    var cache = {};
    $.tmpl = function(strTmpl, args) {
        var __argNames = [];
        var __argValues = [];
        for (var a in args) {
            __argNames.push(a);
            __argValues.push(args[a]);
        }
        var funcs = cache[strTmpl] || function() {
            var f = [ 'var __out__ = [];' ];
            strTmpl.replace(/<%=([\d\D]*?)%>|<%#([\d\D]*?)%>|<%([\d\D]*?)%>|([\d\D]+?)(?=<\%|$)/g, function($0, $1, $2, $3, $4) {
                if ($4) {
                    f.push('__out__.push(unescape("', escape($4), '"));');
                } else if ($1) {
                    f.push('__out__.push(', $1, ');');
                } else if ($2) {
                    f.push('__out__.push(', $.escape($2), ');');
                } else if ($3) {
                    f.push($3, ';');
                }
            });
            f.push('return __out__.join("")');
            return new Function(__argNames.join(', '), f.join(''));
        }();
        cache[strTmpl] = funcs;
        return funcs.apply(args||{}, __argValues);
    };
}();

//取消关注
function cancel_attention(url,f_id){
    $.post(url, {'fid':f_id},function(result){
        if(result == 0){
            layer.msg('取消失败!',2,3);
            layer.close();
        } else if(result==1){
            layer.msg('取消关注成功!',2,1);
            layer.close();
           window.location.reload();
        }

    });
}
//添加关注
function add_attention(url,f_id){
    $.post(url, {'fid':f_id},function(result){
        if(result == 'f'){
            layer.msg('关注失败!',2,3);
        } else if(result=='s'){
            layer.msg('关注成功!',2,1);
            layer.close();
            window.location.reload();
        }else if(result=='noallow'){
            layer.msg('不用关注自己!',2,3);
        }
    });
}
$(function(){
    $('.delete').click(function(){
        var id= $(this).attr('tid');
        $.layer({
            shade: [0],
            area: ['auto','auto'],
            dialog: {
                msg: '您确定删除吗？',
                btns: 2,
                type: 4,
                btn: ['确定','取消'],
                yes: function(){
                    var url=g_siteUrl+'forum/del_thread';
                    $.post(url, {'tid':id},function(r){
                        console.log(r);
                        if(r==1){
                            layer.msg('删除成功',1,1);
                            window.location.reload();
                        }else{
                            layer.msg('删除失败',1,3);
                        }
                    });
                }, no: function(){
                }
            }
        });
    });
})
//文章点击更多js
$(function(){
    if($("#intro-wrap").height() < 66){
        $("#more-intro").hide();
    }else{
        $("#intro-wrap").css({"height":"66px","overflow":"hidden"});
        //$("#more-intro").css({"background":"linear-gradient(to top, #fff, #fff 40%, rgba(255, 255, 255, 0) 100%)"});
    }
    //简介收展
    var expand = false;
    $("#more-intro-btn").click(function() {
        if (expand) {
            $(this).html("阅读更多");
            $("#intro-wrap").css({"height":"66px","overflow":"hidden"});
            //$("#more-intro").css({"background":"linear-gradient(to top, #fff, #fff 40%, rgba(255, 255, 255, 0) 100%)"});
        } else {
            $(this).html("阅读少量");
            $("#intro-wrap").css({"height":"auto","overflow":"visible"});
            //$("#more-intro").css({"background":"transparent"});
        }
        expand = !expand;
    });
})
//自定义alert()
function my_alert(word){
    layer.msg(word);
}
//搜索提示
function check_key(){
    var key= $('#scform_srchtxt').val();
    if(key=='搜索目的地/用户/宝典'){
        layer.msg('请填写要搜索的关键字',2,3);
        layer.close();
        return false;
    }
}

