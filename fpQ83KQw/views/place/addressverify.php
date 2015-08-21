<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <!-- Bootstrap stuff -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
       <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
    <script src="<?=WWW_domian?>js/jquery-address-pick/dist/locationpicker.jquery.min.js"></script>
    <title>地址验证</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="form-horizontal" style="width: 100%;height:780px">
<div class="box">
    <div class="form-group ">
        <label class="col-sm-2 control-label">位置:</label>

        <div class="col-sm-10"><input type="text" class="form-control" id="us3-address" style="width:100%"/><a class='btn btn-success' id="verify">验证此地址是否已经添加</a></div>
    </div>
	<div class="m-t-small">
        <label class="p-r-small col-sm-3 control-label">Lat.:</label>

        <div class="col-sm-3"><input type="text" class="form-control" style="width: 110px" id="us3-lat"/></div>
        <label class="p-r-small col-sm-1 control-label">Long.:</label>

        <div class="col-sm-3"><input type="text" class="form-control" style="width: 110px" id="us3-lon"/></div>
    </div>
   
    <div id="us3" style="width: 550px; height: 400px;" hidden></div>
    <div class="clearfix">&nbsp;</div>  
 </div>
 <div class="box" id="secondstep">
	<form method="post" action="<?=WWW_domian?>place/useraddplace" id="thisform">
		<label class="col-sm-2 control-label">运动类型:</label>
			<div class="col-sm-10">
			<div class="dropdown">
				<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><strong id="setfont">选择改目的相关运动（必选）</strong>
				<span class="caret"></span></button>
				<ul class="dropdown-menu">
				<?php foreach($all_sps as $s_sp):?>
				 <li><a class="add_cs_link" favalue="<?=$s_sp["spid"]?>" faname="<?=$s_sp["name"]?>"><?=$s_sp["name"]?></a></li>
				<?php endforeach;?>
				</ul>
			</div>
		</div>
        <label class="col-sm-2 control-label">目的地名字:</label>
        <div class="col-sm-10"><input type="text" class="form-control" id="p_name" name="p_name" style="width:100%" placeholder="必填"/></div>
		  <label class="col-sm-2 control-label">目的地名字(英文):</label>
        <div class="col-sm-10"><input type="text" class="form-control" id="p_name_eng"  name="p_name_eng" style="width:100%" placeholder="选填"/></div>
		  <label class="col-sm-2 control-label">目的地描述:</label>
        <div class="col-sm-10"><input type="text" class="form-control" id="p_desc" name="p_desc" style="width:100%" placeholder="选填"/></div>
		<input type="hidden" id="sport_id" name="sport_id">
		<input type="hidden" id="lon_in" name="lon_in">
		<input type="hidden" id="lat_in" name="lat_in">
		<br/>
		<center><input type="button" class="btn btn-success" value="提交"  id="formsubmit"/></center>
	</form>
 </div> 
 
    <script>
	$("#secondstep").hide();
	$('#us3').locationpicker({
        radius: 0,
        inputBinding: {
            latitudeInput: $('#us3-lat'),
            longitudeInput: $('#us3-lon'),
            radiusInput: $('#us3-radius'),
            locationNameInput: $('#us3-address')
        },
        enableAutocomplete: true,
        onchanged: function (currentLocation, radius, isMarkerDropped) {
            // Uncomment line below to show alert on each Location Changed event
            //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
        }
    });
	
	$("#verify").click(function(){
		var data="lat="+$("#us3-lat").val()+"&lon="+$("#us3-lon").val();
		$.ajax({
			url:"<?=WWW_domian?>place/verifyAddr",
			type:"post",
			data:data,
			 dataType: 'json',
			success:function(response){
				console.log(response);
				if(response==0){
					alert("此地点已添加，您无需添加");
					return;
				}
				else if(response==1){
					$("#verify").html("验证成功，可以添加");
					document.getElementById("verify").disabled=true;
					document.getElementById("us3-lat").disabled=true;
					document.getElementById("us3-lon").disabled=true;
					document.getElementById("us3-address").disabled=true;
					$("#secondstep").show();
					document.getElementById("lon_in").value=document.getElementById("us3-lon").value;
					document.getElementById("lat_in").value=document.getElementById("us3-lat").value;
				}
				else if(response==-1){
					alert("验证失败");
					return;
				}
			}
		});
		
	});
	$(".add_cs_link").click(function(){
		$("#setfont").html($(this).attr("faname"));
		document.getElementById("sport_id").value=$(this).attr("favalue");
	});
	
	$("#formsubmit").click(function(){
		var data=$("#thisform").serialize();
		var url="<?=WWW_domian?>place/useraddplace";
		$.ajax({
			url:url,
			data:data,
			type:"post",
			success:function(res){
				console.log(res);
				if(res>=0){
					alert("添加成功");
					if(confirm("您是否愿意为该目的地添加图片？")){
						window.location.href="<?=WWW_domian?>place/addmoredetailforplace/"+res;
					}
					else{
						window.parent.location.href="<?=WWW_domian?>place/index/pid/"+res;
					}
				}
				else if(res==-1){
					alert("信息不完整，您没有填写完成必填项")
				}
			}
		});
	});
	
	</script>
</div>
</body>
</html>