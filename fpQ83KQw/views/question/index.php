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
                    <li><a href="<?=site_url() ?>sport/detail/spid/<?=$spid ?>"><?= $sport['name'] ?>(<?= $sport['name_en'] ?>)</a></li>
                    <li class="active">问题列表</li>
                </ol>
            </div>
            <div class="mod card" style="padding-top:10px;">
                <p>
                    <a href="<?=base_url()?>question/add/<?=$spid?>" class="btn btn-success pull-right">发布新提问</a>
                </p>
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
                <div class="group-info-sider card mod">
                    <a href="<?=base_url()?>sport/detail/spid/<?=$sport['spid']?>">
                        <img alt="<?=$sport['name']?>" class="img-rounded" src="<?php echo base_url().'upload/sports_icon/'.$sport['img']?>">
                    </a>
                    <h1>
                        <a href="<?=base_url()?>sport/detail/spid/<?=$sport['spid']?>"><?=$sport['name']?><br><?=$sport['name_en']?></a>
                    </h1>
                    <ul class="group-stats">
                        <li>
                                  <span>
                                    <?=$joined_count?>
                                      <em class="meta">成员</em>
                                  </span>
                        </li>
                        <li>
                                  <span>
                                    <?=$question_count?>
                                      <em class="meta">话题</em>
                                  </span>
                        </li>
                    </ul>
                    <div class="group-join">
                        <?php if($joined){ ?>
                            <button id="btnJoin" class="btn btn-warning" joined="1">
                                我是部落的成员
                            </button>
                        <?php }else{ ?>
                            <button id="btnJoin" class="btn btn-success" joined="0">
                                加入部落
                            </button>
                        <?php } ?>
                    </div>
                </div>
                <div class="modside card mod">
                    <div class="modside-header">
                        <h3>部落介绍</h3>
                    </div>
                    <div class="group-list-wraper">
                        <p><?=$sport['description']?></p>
                    </div>
                </div>
                <div class="modside card mod">
                    <div class="modside-header">
                        <h3>其他部落</h3>
                    </div>
                    <div class="group-list-wraper">
                        <?php if($sports){ foreach($sports as $s){ ?>
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
<script type="text/javascript">
    $(function(){
        $("#btnJoin").click(function(){
            var joined=$(this).attr('joined');
            var url=g_siteUrl+'sport/join/<?=$spid?>';
            $.ajax({
                url: url,
                data:'joined='+joined,
                dataType: 'json',
                success: function (res) {
                    if(res>0){
                        if(joined=='0'){
                            $("#btnJoin").attr('joined','1').removeClass('btn-success').addClass('btn-warning').empty().html('已是部落成员');
                        }else{
                            $("#btnJoin").attr('joined','0').removeClass('btn-warning').addClass('btn-success').empty().html('加入部落');
                        }
                    }else if(res==0){
                        alert('信息不完整');
                    }else if(res==-1){
                        alert('请先登录');
                        window.location.href="<?=PASSPORT_domian?>oauth/login?reurl="+encodeURIComponent(location.href);
                    }
                },
                error: function () {
                }
            });
        });
    });
</script>
</body>
</html>
