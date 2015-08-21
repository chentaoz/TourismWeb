<?php echo $meta; ?><?php echo $css; ?><?php echo $js; ?>

<div class="bag-equipment">
  <ul class="bag-equipment-cata">
    <?php foreach ($sport as $k=>$c):?>
    <li class="<?php if($k==0) echo 'focus';?>"><?=$c['name']?></li>
    <?php endforeach?>


  </ul>
  <?php foreach ($sport as $k=>$c):?>
   <!--遍历装备详情-->
  <div class="bag-equipment-data"<?php if($k!=0) echo 'style="display:none"';?>>
      <?php foreach ($c['sports'] as $k=>$s):?>
       <?php if(in_array($s['ttid'],$bid_arr)){?>
         <div class="bag-equip" data-equip="<?=$s['ttid']?>"><img src="<?='/'.$this->config->item('upload_taxonomy').'/'.$s['img']?>" class="bag-equip-img" ><span><?=$s['name']?></span><div class="bag-equip-choosed" data-choose="1"></div></div>
       <?php }else{?>
              <div class="bag-equip" data-equip="<?=$s['ttid']?>"><img src="<?='/'.$this->config->item('upload_taxonomy').'/'.$s['img']?>" class="bag-equip-img" ><span><?=$s['name']?></span><div class="bag-equip-choose" data-choose="0"></div></div>

          <?php }?>
      <?php endforeach?>
  </div>
  <?php endforeach?>
</div>

<form>
<input type="hidden" id="J-equip-id" value="<?php if($bid_arr){ foreach($bid_arr as $key=>$bid){
   if(count($bid_arr)==$key+1){
       $bids.=$bid;
   }else{
       $bids.=$bid.'-';
   }
}}
echo $bids;
?>">
<input type="hidden" id="J-equip-html" value="
 <?php if($my_bag){
   foreach($my_bag as $key=>$b){
       if(count($my_bag)==1 ||$key==0){
           echo "<div class='bag-equip' data-equip='{$b['ttid']}'><img src='/upload/taxonomy/{$b['img']}' class='bag-equip-img'><span>".$b['name']."</span><div class='bag-equip-del' data-choose='1'></div></div>";
       }else{

       echo "|!yehaiz!|<div class='bag-equip' data-equip='{$b['ttid']}'><img src='/upload/taxonomy/{$b['img']}' class='bag-equip-img'><span>".$b['name']."</span><div class='bag-equip-del' data-choose='1'></div></div>";
   }}

}?>


">
</form>
<script type="text/javascript">
$(document).ready(function(e) {
	$('.bag-equipment-cata li').on('click',function(){
		$(this).siblings().removeClass('focus');
		$(this).addClass('focus');

	});
	$('.bag-equip').on('click',function(){
		$div=$(this).find('div');
		$choose=$div.attr('data-choose');
		$formdata=$('#J-equip-id').val();
		$equiphtml=$('#J-equip-html').val();
		$equipid=$(this).attr('data-equip');
        console.log($choose);
		if($choose==0){
			$div.removeClass().addClass('bag-equip-choosed');
			$div.attr('data-choose',1);
			$dataequip=$(this).attr('data-equip');
			$equipdata='<div class="bag-equip" data-equip="'+$dataequip+'">'+$(this).html().replace('bag-equip-choosed','bag-equip-del')+'</div>';
			if($formdata==''){//用来处理相关的装备数据到表单的隐藏域中
				$('#J-equip-id').val($equipid);
				$('#J-equip-html').val($equipdata);
			}
			else{
				$('#J-equip-id').val($formdata+'-'+$equipid);
				$('#J-equip-html').val($equiphtml+'|!yehaiz!|'+$equipdata);


			}
		}
		else{
			$div.removeClass().addClass('bag-equip-choose');
			$div.attr('data-choose',0);
            console.log($formdata);
			$equipdata=$formdata.split('-');
			$equipindex=$.inArray($equipid,$equipdata);
			$equiphtmldata=$equiphtml.split('|!yehaiz!|');
            console.log($equipindex);
			if($equipindex!=-1){
				$equipdata.splice($equipindex,1);
				$equiphtmldata.splice($equipindex,1);
			}
			$('#J-equip-id').val($equipdata.join('-'));
			$('#J-equip-html').val($equiphtmldata.join('|!yehaiz!|'));
		}
	});
});
</script>
<!--add james -->
<script type="text/javascript">
    $(".bag-equipment-cata li").each(function(i){
        $(this).click(function(){
            $(".bag-equipment-data").hide();
            $(".bag-equipment-data").eq(i).show();
        })
    })
</script>