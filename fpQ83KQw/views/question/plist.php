<?php $this->load->view('head_other_v1', array('currentTab' => 2)); ?>
<link href="<?=base_url()?>css/question.css" rel="stylesheet" type="text/css" />
<!--main-->
<div class="container detailscont">
    <div class="row">
        <div class="col-md-8">
            <div>
                <ol class="breadcrumb" style="background: #fff">
                    <li><a href="<?=base_url()?>">野孩子</a></li>
                    <li><a href="<?=site_url('sport') ?>">兴趣部落</a></li>
                    <li class="active">全部问题列表</li>
                </ol>
            </div>

            <div class="mod card">
                <ol class="comments" id="comments">
                    <?php if($list){ foreach($list as $item){ ?>
                    <li>
                        <h4 style="font-size: 16px">
                            <img alt="" class="img-circle" src="<?=IMG_domian;?>avatar/<?=$item['uid']?>">
                            <a href="<?=site_url() ?>question/detail/<?=$item['id']?>"><?=$item['title']?></a>
                        </h4>
                        <div class="comment-body">
                            <?=messagecutstr($item['body'],200)?> ...
                        </div>
                        <p class="comment-meta">
                            <span class="time"><a href="<?=site_url('space')?>/<?=$item['uid']?>" target="_blank"><?=$item['username']?></a>
                                 发布于 <?=date('Y-m-d h:i:s',$item['created'])?></span>
                            <span class="pull-right">
                              <a href="<?=site_url('question/detail')?>/<?=$item['id']?>#comments" class="at">回答</a>
                            </span>
                        </p>
                    </li>
                    <?php }}else{ ?>
                    <li>
                        <p>还没有提问哦~</p>
                    </li>
                    <?php } ?>
                </ol>
                <div class="page_link">
                    <?=$pagelink?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="">
                <div class="modside card mod">
                    <div class="modside-header">
                        <h3>热门部落</h3>
                    </div>
                    <div class="group-list-wraper">
                        <?php if($every_play){ foreach($every_play as $s){ ?>
                            <div class="groups-list-item clearfix">
                                <div class="groups-list-avatar">
                                    <img alt="<?=$s['name']?>" class="img-rounded avatar" src="<?php echo base_url().'upload/sports_icon/'.$s['img']?>"></div>
                                <div class="groups-list-info">
                                    <h2>
                                        <a href="<?=base_url()?>sport/detail/spid/<?=$s['spid']?>" title="<?=$s['name']?>"><?=$s['name']?></a>
                                    </h2>
                                    <ul class="group-stats">
                                        <li class="stat-shots">
                                      <span>
                                        <?=$s['joined_count']?>
                                          <em class="meta">成员</em>
                                      </span>
                                        </li>
                                        <li class="stat-followers">
                                      <span>
                                        <?=$s['question_count']?>
                                          <em class="meta">话题</em>
                                      </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php }} ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
</body>
</html>