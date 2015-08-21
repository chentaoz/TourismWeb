<div class="desti_left_count">共有<?=$total_deep3?>个目的地</div>
<div class="desti_activi">
    <div class="desti_activi_tit">小编推荐</div>
    <div class="desti_activis2">
        <ul>
        <?php if($top_article){
            foreach($top_article as $k =>$v){
            ?>
            <li class="desti_a6"><a href="<?php echo site_url('place/adetail/id/'.$v['id'].'/pid/'.$place['pid'])?>" target="_blank" title="<?=$v['title']?>"><?=$v['title']?></a></li>
            <?php
            }
        }?>
        </ul><div class="clear"></div>
     </div>
</div>
<div class="clear"></div>
<div class="desti_activi">
    <div class="desti_activi_tit">按兴趣发现目的地</div>
    <div class="desti_activis">
        <?php if($sport){
            foreach($sport as $key=>$t){?>
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                        aria-expanded="true"><?=$t['name']?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <?php if($t['child']){
                        foreach($t['child'] as $s){
                            if(in_array($s['spid'],$sports)){?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?=site_url('map/'.$s['spid'].'/'.$this_pid)?>">
                                        <img src="<?=base_url().$this->config->item('upload_sports_icon').'/'.$s['img']?>" width="45" height="44"><br><?=$s['name']?></a>
                                </li>
                            <?php }
                        }
                    }?>
                </ul>
            </div>
            <?php }
        }?>
    </div>
</div>
<div class="destin_plays">
    <div class="destin_plays_title">去过</div>
    <ul class="desti_ul">
        <?php if($visit_had){
            foreach($visit_had as $k=>$v){?>
                <li>
                    <div class="member_common_pic"><a target="_blank" href="<?=site_url('space_spoor/'.$v['uid'])?>"><img
                                src="<?=IMG_domian?>avatar/<?=$v['uid']?>"></a></div>
                    <div class="member_common_picname"><a target="_blank" href="<?=site_url('space_spoor/'.$v['uid'])?>"><?=$v['username']?></a></div>
                </li>
            <?php
            }
        }?>
        <div class="clear"></div>
    </ul>
    <div class="destin_plays_title">想去</div>
    <ul class="desti_ul">
        <?php if($visit_to){
            foreach($visit_to as $k=>$v){?>
                <li>
                    <div class="member_common_pic"><a target="_blank" href="<?=site_url('space_spoor/'.$v['uid'])?>"><img
                                src="<?=IMG_domian?>avatar/<?=$v['uid']?>"></a></div>
                    <div class="member_common_picname"><a target="_blank" href="<?=site_url('space_spoor/'.$v['uid'])?>"><?=$v['username']?></a></div>
                </li>
            <?php
            }
        }?>
        <div class="clear"></div>
    </ul>
</div>