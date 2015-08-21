//删除前的提示(通用函数)
function delAlert(url){
	msg='删除后将无法恢复，请慎重！';
	if(arguments[1]){
		msg=arguments[1];
	}
	if(confirm(msg)){
		window.location.href=url;
	}
}
//对特定表格的指定范围内的行，进行鼠标悬停的格式化
function tableHover(tableid,start,end){
	if(!start||start==''){
		start=0;
	}
	if(!end||end==''){
		end=$('#'+tableid+' tr').length;
	}
	else if(end<0){
		end=$('#'+tableid+' tr').length+1-Math.abs(end);
	}
	classname='tdbg';
	if(arguments[3]){
		classname=arguments[3];
	}
	$('#'+tableid+' tr:lt('+end+'):gt('+start+')').hover(function(){$(this).addClass(classname);},function(){$(this).removeClass(classname);});
}

//ajax调用
function setType(e,url){
	$(e).parent().load(encodeURI(url));
}
//点击文字直接进行编辑
function editable(e,id,url,width){
	var v=$(e).text();//保存具体文字
	var span=$('<span id="c"></span>');//新建包含表单项的容器，并设置其id
	var itext=$('<input type=text name=name style="width:'+width+'px;" id="show" />');//新建一个text类型的表单项，用来编辑
	itext.attr('value',v);
	span.append(itext);
	itext.bind('blur',function(){
		$(e).show();
		itext_value=$('#show').attr('value');
		url=url+'/id/'+id+'/name/'+itext_value+'/s_name/'+v;
		$.get(encodeURI(url));
		$(e).text(itext_value);
		$('#c').remove();
	});
	var ihide=$('<input type=hidden name=id value='+id+' id=hide />');
	span.append(ihide);
	span.insertAfter(e);
	$(e).hide();
	itext.focus();
}
//鼠标悬停
function over(e){
	$(e).addClass('edit');
}
function out(e){
	$(e).removeClass('edit');
}