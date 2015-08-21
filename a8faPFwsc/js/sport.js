$(function() {

    //删除目的地标签
    $(document).delegate('#sport a.j-del', 'click', function() {
        var label = this.parentNode;
        label.parentNode.removeChild(label);
    });



    var input = $('#search-box2');
    var list = $('#tipsList2');
    var lastValue, delayTimeout;
    var listTmpl =  '\
<% if (list.length) { %>\
    <ul>\
    <% for (var i=0; i<list.length; i++) { var item=list[i]; %>\
        <li class="<%=(i==0?"highlight":"")%>"><a href="javascript:void(0);" onclick="return false;" data-spid="<%=jQuery.escape(item.spid)%>" data-sname="<%=jQuery.escape(item.name)%>"><%=jQuery.escape(item.name)%> - <%=jQuery.escape(item.name_en)%></a></li>\
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
            url:g_siteUrl+'sport/auto_search?key=' + encodeURIComponent(value),
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
            var current = $('#tipsList2 li.highlight').removeClass('highlight');
            current.prev().addClass('highlight');
            if (!$('#tipsList2 li.highlight').length) {
                $('#tipsList2 li:last').addClass('highlight');
            }
            event.preventDefault();
        } else if (key == 40) {
            var current = $('#tipsList2 li.highlight').removeClass('highlight');
            current.next().addClass('highlight');
            if (!$('#tipsList2 li.highlight').length) {
                $('#tipsList2 li:first').addClass('highlight');
            }
            event.preventDefault();
        }
    }
    function onEnterInput(event) {
        if (list.css('display') == 'none') return;
        if (event.keyCode == 13) {
            var a = $('#tipsList2 li.highlight a')[0];
            if (a) {
                a.click();
            }
        }
    }
    input.on('keydown', onArrowInput);
    input.on('keydown', onEnterInput);
    input.on('input', onInput);
    input.on('keyup', onInput);
    input.on('focus', onInput);
    $(document.body).delegate('#tipsList2 li', 'mouseenter', function() {
        $('#tipsList2 li.highlight').removeClass('highlight');
        $(this).addClass('highlight');
    });
    $(document.body).delegate('#tipsList2 li a', 'click', function() {
        var spid = this.getAttribute("data-spid");
        var sname = this.getAttribute("data-sname");
        var label = document.createElement('label');
        label.innerHTML = $.escape(sname) +'<input type="hidden" name="stag[]" value="'+spid+'" />&nbsp;<a class="j-del" href="javascript;void(0);" onclick="return false;" style="color: red">X</a>&nbsp;&nbsp;';
        var destin_ser_input2 = $('#destin_ser_input2')[0];
        destin_ser_input2.parentNode.insertBefore(label, destin_ser_input2);
        input.val("");
        list.hide();
    });
    $(document.body).on('click', function(event){
        if (!$(event.target).parents('#destin_ser_input2').length) {
            list.hide();
            clearTimeout(delayTimeout);
            lastValue = '';
        }
    });
});