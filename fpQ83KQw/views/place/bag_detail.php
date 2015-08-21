<link rel="stylesheet" href="<?=base_url()?>css/other.css" type="text/css">
<link rel="stylesheet" href="<?=base_url()?>css/base.css" type="text/css">
<!--弹出层的内容-->
<div id="idBox" class="lightbox">
    <div class="lightbox_title">
        <div class="l"><?=$describe['title']?>清单：</div>
        <div class="r"></div>
        <div class="clear"></div>
    </div>
    <div class="lightbox_bag_list">
        <ul class="bab_actlist">
            <?php foreach($bag_detail as $d):?>
            <li>
               <?php if($d['img']){?>
                <img src="<?='/'.$this->config->item('upload_taxonomy').'/'.$d['img']?>">
               <?php }else{?>
                   <img src="<?php echo base_url()?>images/default_suit.png">
                <?php }?>
                <br><?=$d['name']?></li>
        <?php endforeach ?>
            <div class="clear"></div>
        </ul>
        <div class="lightbox_bag_des">
            <div class="lightbox_bag_desl l">背包描述：</div>
            <div class="lightbox_bag_desr l"><?=$describe['remark']?></div>
            <div class="clear"></div>
        </div>
    </div>
</div>