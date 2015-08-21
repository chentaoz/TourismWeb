<link rel="stylesheet" href="<?=base_url()?>css/base.css" type="text/css">
<link rel="stylesheet" href="<?=base_url()?>css/member.css" type="text/css">
<div style="height:25px;padding-top: 10px;padding-left: 15px;font-size: 16px;">背包详情</div>
<div class="bag-equipment-data" style="margin-top:20px;width: 94%;">
  <?php foreach($suit_list as $s):?>
    <div class="bag-equip">
        <?php if($s['img']){?>
        <img src="<?php echo base_url()?>upload/taxonomy/<?=$s['img']?>" class="bag-equip-img">
        <?php }else{?>
            <img src="<?php echo base_url()?>images/default_suit.png" class="bag-equip-img">
        <?php }?>
        <span><?=$s['name']?></span></div>
  <?php endforeach?>

</div>