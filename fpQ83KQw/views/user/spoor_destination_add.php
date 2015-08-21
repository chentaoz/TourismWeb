<?php echo $meta; ?>
<?php echo $css; ?>
<?php echo $js; ?>

<div class="spoor-destination">
  <?php if($places){?>
  <?php foreach($places as $p):?>
  <div class="spoor-dest" data-choose="<?php if(in_array($p['pid'],$party)){echo 1;}else{ echo 0;}?>">
       <?php if($p['img']['img']){?>
           <img width="132" height="132" src="/<?=$this->config->item('upload_place_sport').'/'.$p['img']['img']?>" class="spoor-dest-img" pid="<?=$p['pid']?>"/>
       <?php }else{?>
           <img width="132" height="132" src="/images/default_place.png" class="spoor-dest-img" pid="<?=$p['pid']?>"/>
     <?php }?>
      <span><?=$p['name']?></span>
      <?php if(in_array($p['pid'],$party)){?>
          <div class="spoor-dest-choosed"></div>
      <?php }?>
  </div>
 <?php endforeach?>
    <?php }else{?>
      <div class="nofino"><img src="<?php echo base_url('images/noinfo.png');?>"><br>这家伙太懒了，什么都没留下！</div>
    <?php }?>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	$('.spoor-dest').hover(function(){
			$choose=$(this).attr('data-choose');
			if($choose==0){
				$(this).append('<div class="spoor-dest-choose"></div>');
			}
		},function(){
			$choose=$(this).attr('data-choose');
			if($choose==0){
				$('.spoor-dest-choose').remove();
			}
			}).on('click',function(){
					$choose=$(this).attr('data-choose');
					if($choose==0){
						$(this).find('.spoor-dest-choose').remove();
						$(this).append('<div class="spoor-dest-choosed"></div>');
						$(this).attr('data-choose',1);
					}
					else{
						$(this).find('.spoor-dest-choosed').remove();
						$(this).append('<div class="spoor-dest-choose"></div>');
						$(this).attr('data-choose',0);
					}
				});
});
</script>