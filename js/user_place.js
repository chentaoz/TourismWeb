$(function() {
    var input = $('#search-box');
    var list = $('#tipsList');
    var lastValue, delayTimeout;
    var listTmpl =  '\
<% if (list.length) { %>\
    <ul>\
    <% for (var i=0; i<list.length; i++) { var item=list[i]; %>\
        <li class="<%=(i==0?"highlight":"")%>"><a href="javascript:;" did="<%=jQuery.escape(item.pid)%>"><%=jQuery.escape(item.name)%> - <%=jQuery.escape(item.name_en)%></a></li>\
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
        }, 10);
    }
    function ajaxSend(value) {
        $.ajax({
            url:g_siteUrl+'place/auto_search?key=' + encodeURIComponent(value),
            dataType:'json',
            success: function(res) {
                if (lastValue != value) return;
                list.html($.tmpl(listTmpl, {list:res})).show();
                //james add
                $('.tip_indschlay ul li a').click(function(){
                    var did=$(this).attr('did');
                    var name=$(this).html();
                    $('#did').val(did);
                    $('#search-box').val(name)
                })

            },
            error: function() {
                list.html($.tmpl(listTmpl, {list:[]})).show();
            }
        });
    }
    function onArrowInput(event) {
        $('#did').val('');
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
            var href = $('#tipsList li.highlight a').prop('href');
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
    $(document.body).delegate('#tipsList li', 'mouseenter', function() {
        $('#tipsList li.highlight').removeClass('highlight');
        $(this).addClass('highlight');
    });
    $(document.body).on('click', function(event){
        if (!$(event.target).parents('#destin_ser_input').length) {
            list.hide();
            clearTimeout(delayTimeout);
            lastValue = '';
        }
    });






});