<div class="l">
    <div class="desti_pos"><a href="<?= base_url() ?>">野孩子</a> > <a
            href="<?= base_url("place") ?>">目的地</a>>
        <?php if($place['deep']!=1){?>
            <?php foreach($top_parent as $k=>$v){
                if($k>0){?>
                    <a href="<?php echo site_url('place/index/pid/'.$v[0])?>"><?=$v[1]?></a> >
                <?php }
            }?>
        <?php }?>
        <a href="<?=site_url('/place/index/pid/'.$place['pid'])?>"><?=$place['name']?></a></div>
    <div class="desti_en"><a href="<?=site_url('/place/index/pid/'.$place['pid'])?>"><?= $place['name_en'] ?></a></div>
    <div class="destin_ch"><a href="<?=site_url('/place/index/pid/'.$place['pid'])?>"><?= $place['name'] ?></a></div>
</div>