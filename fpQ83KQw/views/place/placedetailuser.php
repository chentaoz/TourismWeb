<!DOCTYPE html>
<!-- release v4.2.6, copyright 2014 - 2015 Kartik Visweswaran -->
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title>目的地详细</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?=WWW_domian?>js/master-imageinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="<?=WWW_domian?>js/master-imageinput/js/fileinput.js" type="text/javascript"></script>
      
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container kv-main">
           
   
            <form enctype="multipart/form-data" id="this_form">
                <label>上传目的地图片</label>
                <div class="form-group">
					<input id="input-700" name="placeimg" type="file" multiple class="file-loading">
                </div>
				<label class="col-sm-2 control-label">目的地名字:</label>
				<div class="col-sm-10"><input type="text" class="form-control" id="p_name" name="p_name" style="width:100%" placeholder="必填" value="<?=isset($place["name"])?$place["name"]:null?>" /></div>
				<label class="col-sm-2 control-label">目的地名字(英文):</label>
				<div class="col-sm-10"><input type="text" class="form-control" id="p_name_eng"  name="p_name_eng" style="width:100%" placeholder="选填" value="<?=isset($place["name_en"])?$place["name_en"]:null?>"/></div>
				<label class="col-sm-2 control-label">目的地描述:</label>
				<div class="col-sm-10"><textarea class="form-control" id="p_desc" name="p_desc" style="width:100%" rows=5 placeholder="选填" value="<?=isset($place["description"])?$place["description"]:null?>"></textarea></div>
                <br/>
				<label class="col-sm-2 control-label">目的地的级别:</label>
				<div class="col-sm-10">
				<div class="dropdown">
						<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><strong id="setfontl">选择该目的地的级别</strong>
						<span class="caret"></span></button>
						<ul class="dropdown-menu">					
							  <li><a class="deep" favalue="3">小型公园/一般景点</a></li>
							    <li><a class="deep" favalue="2">大型公园/国家公园</a></li>
						</ul>
					</div>
				</div>
				 <br/>
				<label class="col-sm-2 control-label"></label>
			   <div class="col-sm-10" id="na_div" hidden>
					<div class="dropdown">
						<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><strong id="setfontn">所属国家</strong>
						<span class="caret"></span></button>
						<ul class="dropdown-menu">	
							<?php foreach($place_all as $p):
									if($p["deep"]==1):?>
							
							  <li>  <a class="nation" falval='<?=$p["pid"]?>'><?php if(in_array($p["name"],array("美国","中国","加拿大","墨西哥","巴拿马"))):?>
							  * <?php endif?><?=$p["name"]?> - <?=$p["name_en"]?></a>
							
							  </li>
							 <?php endif;
							 endforeach;?>
						</ul>
					</div>
				</div>
				 <br/>
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-10" id="di_div" hidden>
					<div class="dropdown">
						<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><strong id="setfontd">所属城市或地区</strong>
						<span class="caret"></span></button>
						<ul class="dropdown-menu">	
							<li>
							<?php foreach($place_all as $p):
									if($p["deep"]==2):?>
							
							  <li class="district_li" nation="<?=$p["parent"]?>"><a class="district" nation="<?=$p["parent"]?>" falval="<?=$p["pid"]?>"><?=$p["name"]?> - <?=$p["name_en"]?> 以及其周边</a></li>
							 <?php endif;
							 endforeach;?>
						</ul>
					</div>
				</div>
				<input type="hidden" id="dist" name="dist" />
				<input type="hidden" id="nati" name="nati" />
				<input type="hidden" id="level" name="level" />
				
            </form>
            
			
			<a class="btn btn-success pull-right" id="confirmthisform">确定</a>
            
        </div>
    </body>
	<script>

	$("#input-700").fileinput({
		uploadUrl: "<?=WWW_domian?>place/savePlaceImage/"+"placeimg"+"/<?=$place["pid"]?>", // server upload action
		uploadAsync: true,
		maxFileCount: 5
});
 
	$(".nation").click(function(){
		document.getElementById("setfontn").innerHTML=$(this).html();
		document.getElementById("nati").value=$(this).attr("falval");
			document.getElementById("dist").value="";
			document.getElementById("setfontd").innerHTML="所属城市或地区";
		//$("setfontn").html($(this).html());
		var nation=$(this).attr("falval");
		$(".district_li").each(function(){
			$(this).show();
		});
		$(".district_li").each(function(){
			if($(this).attr("nation")!=nation){
				//console.log($(this).attr("nation"));
				$(this).hide();
			}
		});
	});
	$(".deep").click(function(){
		document.getElementById("setfontl").innerHTML=$(this).html();
		document.getElementById("level").value=$(this).attr("favalue");
		
		if($(this).attr("favalue")==3){
			$("#di_div").hide();
			$("#na_div").hide();
			$("#di_div").show();
			$("#na_div").show();
		}
		else if($(this).attr("favalue")==2){
				$("#di_div").hide();
			$("#na_div").hide();
			
			$("#na_div").show();
		}
	});
	
	$(".district").click(function(){
		document.getElementById("dist").value=$(this).attr("falval");
		document.getElementById("setfontd").innerHTML=$(this).html();
	});
	
	$("#confirmthisform").click(function(){
		var data=$("#this_form").serialize()+"&p_desc="+document.getElementById("p_desc").value;
		var url="<?=WWW_domian?>upload/usersubmitdetail/<?=$place["pid"]?>";
		$.ajax({data:data,
		url:url,
		type:"post",
		success:function(res){
			console.log(res);
			window.parent.location.href="<?=WWW_domian?>place/index/pid/<?=$place["pid"]?>";
		}
		})
	});
	</script>
</html>