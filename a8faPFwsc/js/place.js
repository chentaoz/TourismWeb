$(function() {

    //删除目的地标签
    $(document).delegate('#place a.j-del', 'click', function() {
        var label = this.parentNode;
        label.parentNode.removeChild(label);
    });



    var input = $('#search-box');
    var list = $('#tipsList');
    var lastValue, delayTimeout;
    var listTmpl =  '\
<% if (list.length) { %>\
    <ul>\
    <% for (var i=0; i<list.length; i++) { var item=list[i]; %>\
        <li class="<%=(i==0?"highlight":"")%>"><a href="javascript:void(0);" onclick="return false;" data-pid="<%=jQuery.escape(item.pid)%>" data-name="<%=jQuery.escape(item.name)%>"><%=jQuery.escape(item.name)%> - <%=jQuery.escape(item.name_en)%></a></li>\
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
            url:g_siteUrl+'place/auto_search?key=' + encodeURIComponent(value),
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
            var current = $('#tipsList li.highlight').removeClass('highlight');
            current.prev().addClass('highlight');
            if (!$('#tipsList li.highlight').length) {
                $('#tipsList li:last').addClass('highlight');
            }
            event.preventDefault();
        } else if (key == 40) {
            var current = $('#tipsList li.highlight').removeClass('highlight');
            current.next().addClass('highlight');
            if (!$('#tipsList li.highlight').length) {
                $('#tipsList li:first').addClass('highlight');
            }
            event.preventDefault();
        }
    }
    function onEnterInput(event) {
        if (list.css('display') == 'none') return;
        if (event.keyCode == 13) {
            var a = $('#tipsList li.highlight a')[0];
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
    $(document.body).delegate('#tipsList li', 'mouseenter', function() {
        $('#tipsList li.highlight').removeClass('highlight');
        $(this).addClass('highlight');
    });
    $(document.body).delegate('#tipsList li a', 'click', function() {
        var pid = this.getAttribute("data-pid");
        var name = this.getAttribute("data-name");
        var label = document.createElement('label');
        label.innerHTML = $.escape(name) +'<input type="hidden" name="ptag[]" value="'+pid+'" />&nbsp;<a class="j-del" href="javascript;void(0);" onclick="return false;" style="color: red">X</a>&nbsp;&nbsp;';
        var destin_ser_input = $('#destin_ser_input')[0];
        destin_ser_input.parentNode.insertBefore(label, destin_ser_input);
        input.val("");
        list.hide();
    });
    $(document.body).on('click', function(event){
        if (!$(event.target).parents('#destin_ser_input').length) {
            list.hide();
            clearTimeout(delayTimeout);
            lastValue = '';
        }
    });
});