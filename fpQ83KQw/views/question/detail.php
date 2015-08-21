<?php $this->load->view('head_other_v1', array('currentTab' => 2)); ?>
<link href="<?=base_url()?>css/question.css" rel="stylesheet" type="text/css" />
<link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
<style type="text/css">
    /*#btnFollow{ margin-left:20px; margin-top: 10px; margin-right: 10px;}*/
    #btnLike{  margin-top: 10px;}
    .thumbnail{border: none;}
    .thumbnail .caption{ text-align: center}
    .chentaozhang img{max-width:100%; max-height:100%;width:auto; height:auto;image-orientation: flip;}
    .chentaozhang {width: calc(100% - 40px);}
</style>
<style>
    .editor img{max-width:70%;max-height:70%;}
</style>
<!--main-->
<div class="container detailscont">
    <div class="row">
        <div class="col-md-8">
            <div>
                <ol class="breadcrumb" style="background: #fff">
                    <li><a href="<?=base_url()?>">野孩子</a></li>
                    <li><a href="<?=site_url('sport') ?>">兴趣部落</a></li>
                    <li><a href="<?=site_url() ?>question/index/<?=$spid ?>"><?= $sport['name'] ?>(<?= $sport['name_en'] ?>)</a></li>
                    <li class="active"><?=$question['title']?></li>
                </ol>
            </div>
            <div class="group-topic-detail card clearfix">
                <div class="group-topic-detail-bd">
                    <h3>
                        <?php if($followed){ ?>
                            <button id="btnFollow" class="btn btn-warning btn-sm pull-right" follow="1">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 取消关注
                            </button>
                        <?php }else{ ?>
                            <button id="btnFollow" class="btn btn-success btn-sm pull-right" follow="0">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 关注
                            </button>
                        <?php } ?>
                        <?=$question['title']?>
                    </h3>
                    <div class="chentaozhang">
                        <?=$question['body']?>
                    </div>
                </div>
                <div class="group-topic-detail-ft clearfix">
                    <div class="quick-replay">
                        <a href="<?=site_url('space')?>/<?=$question_member['uid']?>" target="_blank">
                            <strong><?=$question_member['username']?></strong>
                        </a>
                        <time>发布于 <?=date('Y-m-d',$question['created'])?></time>
                    </div>
                </div>
                <div class="group-topic-detail-ft clearfix" style="margin-top: 6px;">
                    <!-- JiaThis Button BEGIN -->
                    <div id="ckepop">
                        <span class="jiathis_txt">分享到：</span>
                        <a class="jiathis_button_weixin">微信</a>
                        <a class="jiathis_button_tsina">新浪微博</a>
                        <a class="jiathis_button_fb">Facebook</a>
                        <a href="http://www.jiathis.com/share"  class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">更多</a>
                        <a class="jiathis_counter_style"></a>
                        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1" charset="utf-8"></script>
                        <?php if($user_id==$question['uid']){?>
                            <br/>
                            <br/>
                            <button class="btn btn btn-success pull-right" id="shanchu" onclick="shanchu()">删除问题</button>
                            <button class="btn btn btn-success pull-right" id="xiugai" onclick="xiugai()">修改问题</button>
                        <?php }?>

                    </div> <!-- JiaThis Button END -->
                </div>
            </div>
            <div class="mod card">
                <ol class="comments" id="comments">
                    <?php if($list){ foreach($list as $item){ ?>
                    <li id="li_1_<?=$item['id']?>">
                        <h4>

                            <img alt="" class="img-circle" src="<?=IMG_domian;?>avatar/<?=$item['uid']?>">
                            <a href="<?=site_url('space')?>/<?=$item['uid']?>" target="_blank"><?=$item['username']?></a>
                        </h4>
                        <div class="comment-body" id="body_1_<?=$item['id']?>">
                            <?=$item['body']?>

                        </div>




                        <form>
                            <input type="hidden" id="value_set1_<?=$item["id"]?>" value="0">

                        </form>
                        <p class="comment-meta">
                            <span class="time">发布于 <?=date('Y-m-d',$item['created'])?></span> &nbsp;&nbsp;
<!--                            <a href="#" id="btnComments--><?//=$item['uid']?><!--" class="at btn-comment">-->
<!--                                <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 23 条评论-->
<!--                            </a> &nbsp;&nbsp;-->
                            <a href="javascript:;" id="btnLike<?=$item['uid']?>" answer="<?=$item['id']?>" liked="<?=$item['liked']?>" class="at btn-like">
                                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                                <?php if($item['user_liked']){ ?>
                                <span class="span-like">已赞(<?=$item['liked']?>人)</span>
                                <?php }else{ ?>
                                <span class="span-like">赞(<?=$item['liked']?>人)</span>
                                <?php } ?>
                            </a> &nbsp;&nbsp;
                            <!--                      ////////////////////////////////////////////////////////////////////////////////////////////////////////-->





                            <a id="a_<?=$item["id"] ?>"  >查看所有回复（<?=$item['comments']  ?>条）</a>&nbsp;&nbsp;
                            <a id="to_<?=$item["id"] ?>" >我想回复</a>
                            <?php if($item['uid']==$user_id){?>
                                &nbsp;&nbsp;<a id="zxc" onclick="myFunction2(<?=$item["id"] ?>)">修改</a>&nbsp;&nbsp;<a  class="delete1" onclick="myFunction3(<?=$item["id"] ?>)">删除</a>
                            <?php }?>
                            <!--                      ////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--                            <a href="#" id="btnShare" class="at btn-share" shared="1">-->
<!--                                <span class="glyphicon glyphicon-share" aria-hidden="true"></span> 分享-->
<!--                            </a>-->
<!--                                <span class="pull-right">-->
<!--                                  <a href="#create_reply" class="at">回应</a>-->
<!--                                </span>-->
                        </p>
                        <div role="form" id="modify_form_1_<?=$item["id"] ?>" hidden="true">

                            <input  type="text" class="form-control" id="modify_1_<?=$item['id']?>"  placeholder="此处进行修改">
                            <button   class="btn btn btn-success pull-left" onclick="modifySubmit(<?=$item['id']?>)">修改提交</button>
                            <br/><br/><br/>

                        </div>
<!--                      ////////////////////////////////////////////////////////////////////////////////////////////////////////-->



                        <?php if(isset($_COOKIE["join"]) and $_COOKIE["join"]=="rpys_".$item["id"]){ ?>
                        <div id="rpys_<?=$item["id"]?>"  style="padding-left:60px" >
                            <a hidden="true" id="click_0_0" href="#li_1_<?=$item['id']?>"></a>
                            <script>
                                window.onload = function() {

                                    document.getElementById("click_0_0").click();
                                };







                            </script>





                            <?php

                            }else{?>
                            <div id="rpys_<?=$item["id"]?>" hidden="true" style="padding-left:60px">

                                <?php }?>
                    <?php if(!$joined){?>
                        <div class="mod card" style="padding-top:10px;" id="rrww<?=$item["id"]?>">
                            <p class="jointak">
                                <a  id="click1<?=$item["id"]?>" onclick="myFunction('rpys_<?=$item["id"]?>')">加入小组</a>
                                才能查看哦。
                            </p>
                        </div>


                        <?php }else{?>



                        <?php foreach($item['answer_reply'] as $reply){?>

                               <div id="li_2_<?=$reply["id"]?>">
                            <script>

                                $(document).ready(function(){
                                    $("#r_<?=$reply["id"] ?>").click(function(){
                                        $("#rpys_rpys_<?=$reply["id"] ?>").toggle();
                                    });
                                });

                                $(document).ready(function(){
                                    $("#<?="to_to_".$reply["id"] ?>").click(function(){
                                        $("#to_to_rpys_<?=$reply["id"] ?>").toggle();
                                        $("#modify_form_2_<?=$reply["id"] ?>").hide();
                                    });
                                });






                            </script>




                            <h4>

                                <img alt="" class="img-circle" src="<?=IMG_domian;?>avatar/<?=$reply['uid']?>">
                                <a href="<?=site_url('space')?>/<?=$reply['uid']?>" target="_blank"><?=$reply['username']?></a>
                            </h4>
                            <div class="comment-body" id="body_2_<?=$reply['id']?>">
                                <?=$reply['body']?>
                            </div>
                        <p class="comment-meta" style="A:hover {;font-weight:bold; FONT-SIZE: 11px; BACKGROUND: #FFFFFF;}">
                            <span class="time">回复于 <?=date('Y-m-d',$reply['created_at'])?></span> &nbsp;&nbsp;
                            <STYLE></STYLE>
                            <a href="javascript:;" id="btnLike<?=$reply['uid']?>" answer="<?=$reply['id']?>" liked="<?=$reply['liked']?>" class="at btn-like0">
                                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                                <?php if($reply['liked']){ ?>
                                    <span class="span-like">已赞(<?=$reply['liked']?>人)</span>
                                <?php }else{ ?>
                                    <span class="span-like">赞(<?=$reply['liked']?>人)</span>
                                <?php } ?>
                            </a> &nbsp;&nbsp;
                            <a id="r_<?=$reply["id"] ?>" >查看所有回复（<?=$reply['comments']  ?>条）</a>&nbsp;&nbsp;
                            <a id="to_to_<?=$reply["id"] ?>" >我来回复他/她</a>
                            <?php if($reply['uid']==$user_id){?>
                                &nbsp;&nbsp;<a id="zxc1" onclick="myFunction22(<?=$reply["id"] ?>)">修改</a>&nbsp;&nbsp;<a  class="delete2" onclick="myFunction33(<?=$reply["id"] ?>,<?=$item["comments"]?>,<?=$item["id"]?>)">删除</a>
                            <?php }?>
                        </p>
                            <div role="form" id="modify_form_2_<?=$reply["id"] ?>" hidden="true">

                                <input  type="text" class="form-control" id="modify_2_<?=$reply['id']?>"  placeholder="此处进行修改">
                                <button   class="btn btn btn-success pull-left" onclick="modifySubmit1(<?=$reply['id']?>)">修改提交</button>
                                <br/><br/><br/>

                            </div>

                          <div id="rpys_rpys_<?=$reply["id"]?>" hidden="true" style="padding-left:60px">
                          <?php foreach($item['answer_reply_reply']["{$reply["id"]}"] as $reply_reply) {?>
                              <div id="li_3_<?=$reply_reply["id"]?>">
                            <h4>

                                <img alt="" class="img-circle" src="<?=IMG_domian;?>avatar/<?=$reply_reply['uid']?>">
                                <a href="<?=site_url('space')?>/<?=$reply_reply['uid']?>" target="_blank"><?=$reply_reply['username']?></a>
                            </h4>

                            <div class="comment-body" id="body_3_<?=$reply_reply['id']?>">
                                <?=$reply_reply['body']?>
                            </div>
                              <p class="comment-meta" style="A:hover {;font-weight:bold; FONT-SIZE: 11px; BACKGROUND: #FFFFFF;}">
                                  <span class="time">回复 <?=$reply["username"]?> <?=date('Y-m-d',$reply_reply['created_at'])?></span> &nbsp;&nbsp;
                                  <STYLE></STYLE>
                                  <?php if($reply_reply['uid']==$user_id){?>
                                      &nbsp;&nbsp;<a id="zxc11" onclick="myFunction222(<?=$reply_reply["id"] ?>)">修改</a>&nbsp;&nbsp;<a  class="delete2" onclick="myFunction333(<?=$reply_reply["id"] ?>,<?=$reply["comments"]?>,<?=$reply["id"]?>)">删除</a>
                                  <?php }?>
                                  </p>
                              <div role="form" id="modify_form_3_<?=$reply_reply["id"] ?>" hidden="true">

                                  <input  type="text" class="form-control" id="modify_3_<?=$reply_reply['id']?>"  placeholder="此处进行修改">
                                  <button   class="btn btn btn-success pull-left" onclick="modifySubmit2(<?=$reply_reply['id']?>)">修改提交</button>
                                  <br/><br/><br/>
                                </div>
                              </div>

                            <?php }?>
                            </div>
                            <form>
                                <input type="hidden" id="value_set0_<?=$reply["id"]?>" value="0">

                            </form>

                            <div id="to_to_rpys_<?=$reply["id"]?>" hidden="true">
                                <?php if(!$joined){ ?>
                                    <div class="mod card" style="padding-top:10px;" id="rr<?=$reply["id"]?>">
                                        <p class="jointak">
                                            <a  id="click0<?=$reply["id"]?>" onclick="myFunction('to_to_rpys_<?=$reply["id"]?>')">加入小组</a>
                                            才能回复哦。
                                        </p>
                                    </div>
                                <?php } else{?>
                            <form role="form" action="<?=WWW_domian?>question/addanswer_reply_replyajax/<?= $reply['id']?>"  method="post">
                            <div class="form-group"> <input type="text" class="form-control" id="email0_<?=$reply['id']?>" name="content" placeholder="此处回复对回答的评论"></div>
<!--                                000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000-->






<!--                                <div class="btn-toolbar0" data-role="editor-toolbar" data-target="#editor0">-->
<!--                                    <div class="btn-group"0>-->
<!--                                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>-->
<!--                                        <ul class="dropdown-menu">-->
<!--                                        </ul>-->
<!--                                    </div>-->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!--                                    <div class="btn-group">-->
<!--                                        <a class="btn0" title="插入图片" id="pictureBtn"><i class="icon-picture"></i></a>-->
<!--                                    </div>-->
<!---->
<!--                                    <input type="text" data-edit="inserttext" id="voiceBtn0" x-webkit-speech="">-->
<!--                                </div>-->

































































<!--                                00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000-->
<!--                            <button  class="btn btn btn-success pull-left" onclick="reply_sumbit()">回复</button>-->
                            </form>        <button  class="btn btn btn-success pull-left" onclick="myFunction1('email0_',<?=$reply['id']?>,<?=$reply['comments']?>)">回复</button><br/><br/>
                                <?php }?>
                        </div>
                               </div>
                       <?php }?>
                       <?php }?>
                        </div>
                        <br/>
<!--                        <form   action=WWW_domain."question/addanswer_replyajax/--><?//= $item['id']?><!--"  method="post">-->
<!--                            <input type="text" class="form-control" id="content" name="content" >-->
<!--                            <button type="submit" class="btn btn btn-success pull-left">回复</button>-->
<!--                        </form>-->
                        <?php if(isset($_COOKIE["join"]) and $_COOKIE["join"]=="to_rpys_".$item["id"]){ ?>
                        <div id="to_rpys_<?=$item["id"]?>" >
                            <a hidden="true" id="click0_0" href="#li_1_<?=$item['id']?>"></a>
                            <script>
                                window.onload = function() {
                                    document.getElementById("email1_<?=$item['id']?>").focus();
                                    document.getElementById("click0_0").click();
                                };







                            </script>
                            <?php


                            }else{?>
                            <div id="to_rpys_<?=$item["id"]?>" hidden="true">

                            <?php }?>
                        <?php if(!$joined){ ?>
                            <div class="mod card" style="padding-top:10px;">
                                <p class="jointak">
                                    <a onclick="myFunction('to_rpys_<?=$item["id"]?>')" id="click1">加入小组</a>
                                    才能回复哦。
                                </p>
                            </div>
                        <?php } else{?>

                        <form role="form" action="<?=WWW_domian?>question/addanswer_replyajax/<?= $item['id']?>"  method="post">
                            <div class="form-group"> <input type="text" class="form-control" id="email1_<?=$item['id']?>" name="content" placeholder="此处回复对问题的回答"></div>

                        </form><button  class="btn btn btn-success pull-left" onclick="myFunction1('email1_',<?=$item['id']?>,<?=$item['comments']?>)">回复</button>

                    <?php }?>
                       </div>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////-->
                        <script>
                            $(document).ready(function(){
                                $("#a_<?=$item["id"] ?>").click(function(){
                                    $("#rpys_<?=$item["id"] ?>").toggle();
                                });
                            });

                            $(document).ready(function(){
                                $("#<?="to_".$item["id"] ?>").click(function(){
                                    $("#to_rpys_<?=$item["id"] ?>").toggle();

                                        $("#modify_form_1_<?=$item["id"] ?>").hide() ;
                                });
                            });







                        </script>












<!--       /////////////////////////////////////////////////////////////////////////////////////////////////////////                -->
                    </li>
                    <?php }}else{ ?>
                        <li>
                            <p>还没有答案哦~</p>
                        </li>
                    <?php } ?>
                </ol>
                <div class="page_link">
                    <?=$pagelink?>
                </div>
            </div>
            <?php if(!$joined){ ?>
            <div class="mod card" style="padding-top:10px;">
                <p class="jointak">
                    <a  onclick="myFunction('editor')" id="click2">加入小组</a>
                    才能发言哦。
                </p>
            </div>
            <?php }else{ ?>
            <div class="mod card" style="padding-top:10px;">
                <form id="form1" method="post" action="">
                    <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                            </ul>
                        </div>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                                <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                                <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
                            <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
                            <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
                            <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
                        </div>
                        <div class="btn-group">
                            <!--                        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>-->
                            <!--                        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>-->
                            <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
                            <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
                            <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
                            <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
                            <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="链接"><i class="icon-link"></i></a>
                            <div class="dropdown-menu input-append">
                                <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
                                <button class="btn" type="button">确定</button>
                            </div>
                            <a class="btn" data-edit="unlink" title="移除链接"><i class="icon-cut"></i></a>

                        </div>

                        <div class="btn-group">
                            <a class="btn" title="插入图片" id="pictureBtn"><i class="icon-picture"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="undo" title="撤销 (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                            <a class="btn" data-edit="redo" title="恢复 (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
                        </div>
                        <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
                    </div>
                    <?php if(isset($_COOKIE["join"]) and $_COOKIE["join"]=="editor" ){?>
                        <a hidden="true" id="editor_click0_0" href="#form1"></a>
                    <script>




                        window.onload = function() {
                            document.getElementById("editor").focus();
                            document.getElementById("editor_click0_0").click();
                        };







                    </script>
                    <?php }?>
                    <div id="editor" class="editor">
                    </div>
                    <div class="form-group">
                        <p><input id="btnSave" class="btn btn btn-success pull-left" type="button" value="回答" >
                            <img id="loading" src="<?php echo base_url() ?>js/loading.gif" width="30" height="30" style="display: none;">
                        </p>
                    </div>
<!--                    <input type="hidden" name="spid" id="spid" />-->
                </form>
            </div>
            <?php } ?>
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
                        <h3><span class="text-primary"><?= $question['follow'] ?></span> 人关注了该问题</h3>
                    </div>
                    <div class="group-list-wraper">
                        <div class="row">
                            <?php if ($question_follow_list) {
                            foreach ($question_follow_list as $k => $v) {
                            ?>
                            <div class="col-sm-4 col-md-3">
                                <div class="thumbnail">
                                    <img alt="" src="<?=IMG_domian;?>avatar/<?=$v['uid']?>" style="display: block;">
                                    <div class="caption">
                                        <a href="<?=site_url('space/'.$v['uid'])?>"><?= $v['username'] ?></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            }?>
                        </div>
                    </div>
                </div>

                <div class="modside card mod">
                    <div class="modside-header">
                        <h3>其他小组</h3>
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

<script>

    function shanchu(){
        if(confirm("确定要删除此条问题吗? 如果删除，所有回复将被删除哦！")){
            window.location.replace("<?=base_url()?>question/shanchu/<?=$questionid?>/<?=$spid?>");

        }
        else return false;

    }
    function xiugai(title,body){


      window.location.replace("<?=base_url()?>question/xiugai/<?=$questionid?>/<?=$spid?>");

    }
</script>
<div id="filediv">
<input type="file" name="Filedata" id="Filedata" style="display: none">
</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>

    function myFunction1(input,id,comments){


        var content= document.getElementById(input+id).value;

        var currentTime=new Date();
        var partialPath="";
        if(input=="email0_")
            partialPath="addanswer_reply_replyajax/";
        else partialPath="addanswer_replyajax/";
        var url=g_siteUrl+'question/'+partialPath+id+'?spid=<?=$spid?>&content='+content;

        $.ajax({
            url: url,

            type:'get',
            success: function (res) {

                if(res>0){
                    alert('提交成功');
                    if (partialPath=="addanswer_reply_replyajax/"){


                        var r_s="r_"+id;
                        comments++;
                        if (document.getElementById("value_set0_"+id).value!="0"){


                            comments=parseInt(document.getElementById("value_set0_"+id).value)+1;
                            document.getElementById("value_set0_"+id).value=comments.toString();
                        }

                        document.getElementById("value_set0_"+id).value=parseInt(comments);
                        document.getElementById(r_s).textContent="查看所有回复（"+comments+"条）";



                        var newObject='<h4><img alt="" class="img-circle" src="<?=IMG_domian;?>avatar/<?=$user_id?>"><a  target="_blank">我</a></h4><div class="comment-body">'+
                            content+'</div>'+ '<p class="comment-meta"><span class="time">回复于'+'&nbsp;'+'</span>'+currentTime.getFullYear()+'-'+(currentTime.getMonth()+1)+'-'+currentTime.getDate() + '&nbsp;&nbsp;</p>';
                        $("#rpys_rpys_"+id).append(newObject);
                        document.getElementById(input+id).value="";
                        $("#to_to_rpys_"+id).toggle();
                    }

                    else{


                        var r_s="a_"+id;
                        comments++;
                        if (document.getElementById("value_set1_"+id).value!="0"){
                            comments=parseInt(document.getElementById("value_set1_"+id).value)+1;
                            document.getElementById("value_set1_"+id).value=comments.toString();
                        }

                        document.getElementById("value_set1_"+id).value=parseInt(comments);
                        document.getElementById(r_s).textContent="查看所有回复（"+comments+"条）";
                        var newObject='<h4><img alt="" class="img-circle" src="<?=IMG_domian;?>avatar/<?=$user_id?>"><a href="" target="_blank">我</a></h4><div class="comment-body">'+
                            content+'</div>'+ '<p class="comment-meta"><span class="time">回复于'+'&nbsp;'+'</span>'+currentTime.getFullYear()+'-'+(currentTime.getMonth()+1)+'-'+currentTime.getDate() + '&nbsp;&nbsp;</p>';
                        $("#rpys_"+id).append(newObject);
                        document.getElementById(input+id).value="";
                        $("#to_rpys_"+id).toggle();

                    }

                }else if(res==0){
                    alert('信息不完整');
                }else if(res==-1){
                    alert('请先登录');
                }else if(res==-2){
                    alert('请先加入部落');
                }
            },
            error: function (x,e ){
                if(x.status==0){
                    alert('You are offline!!\n Please Check Your Network.');
                }else if(x.status==404){
                    alert('Requested URL not found.');
                }else if(x.status==500){
                    alert('Internel Server Error.');
                }else if(e=='parsererror'){
                    alert('Error.\nParsing JSON Request failed.');
                }else if(e=='timeout'){
                    alert('Request Time out.');
                }else {
                    alert('Unknow Error.\n'+x.responseText);
                }
            }
        });
    }


    function  myFunction(eid){

        var id="<?=$user_id?>";

        if(id!="0"&& id!=""&&id!=null) {
            alert("加入部落成功！");
            window.location.replace("<?=base_url()?>question/addFirst/<?=$spid?>/<?=$questionid?>?eid="+eid);
        }
        else{
            alert("请先登录");
            var currentUrl="<?=current_url()?>";
      window.location.replace("<?=base_url()?>question/transferToLogin?currentUrl="+currentUrl);
    }}
   function modifySubmit(id){
       if(confirm("确定修改此条评论吗?")){
       var content=document.getElementById("modify_1_" + id).value;
       var url="<?=site_url('')?>"+"question/answerModify/"+id+"?content="+content;
       $.ajax({
           url: url,

           type:'get',
           success: function (res) {
               if(res==-1) alert("修改不能为空");
               else {
                   var x = document.getElementById("modify_1_" + id).value;
                   alert("修改成功");
                   document.getElementById("body_1_" + id).innerHTML = x;
                   document.getElementById("modify_1_" + id).value="";
                   $("#modify_form_1_"+id).toggle();
               }


   }});}
    else return false;}
    function modifySubmit1(id){
        if(confirm("确定修改此条评论吗?")){
        var content=document.getElementById("modify_2_" + id).value;
        var url="<?=site_url('')?>"+"question/replyModify/"+id+"?content="+content;
        $.ajax({
            url: url,

            type:'get',
            success: function (res) {
                if(res==-1) alert("修改不能为空");
                else {
                    var x = document.getElementById("modify_2_"+id).value;
                    alert("修改成功");

                    document.getElementById("body_2_"+id).innerHTML = x;

                    document.getElementById("modify_2_" + id).value="";
                    $("#modify_form_2_"+id).toggle();
                }


            }});}
    else return false;}
    function modifySubmit2(id){
        if(confirm("确定修改此条评论吗?")){
            var content=document.getElementById("modify_3_" + id).value;
            var url="<?=site_url('')?>"+"question/replyRModify/"+id+"?content="+content;
            $.ajax({
                url: url,

                type:'get',
                success: function (res) {
                    if(res==-1) alert("修改不能为空");
                    else {
                        var x = document.getElementById("modify_3_"+id).value;
                        alert("修改成功");

                        document.getElementById("body_3_"+id).innerHTML = x;

                        document.getElementById("modify_3_" + id).value="";
                        $("#modify_form_3_"+id).toggle();
                    }


                }});}
        else return false;}
    function myFunction2(id){
        $("#modify_form_1_"+id).toggle();
        //if(document.getElementById("modify_form_1_"+id).style.visibility=="hidden")
        $("#to_rpys_"+id).hide();
        //document.getElementById().style.visibility="hidden";
    }
    function myFunction22(id){
        $("#modify_form_2_"+id).toggle();
        $("#to_to_rpys_"+id).hide();
    }
    function myFunction222(id){
        $("#modify_form_3_"+id).toggle();

    }

     function myFunction3(id){
         if(confirm("确定删除此条评论吗?")){

            var url="<?=site_url('')?>"+"question/answerDelete/"+id;

         $.ajax({
             url: url,

             type:'get',
             success: function (res) {

         document.getElementById("li_1_"+id).style.display = "none";},
             error: function (x,e ){
                 if(x.status==0){
                     alert('You are offline!!\n Please Check Your Network.');
                 }else if(x.status==404){
                     alert('Requested URL not found.');
                 }else if(x.status==500){
                     alert('Internel Server Error.');
                 }else if(e=='parsererror'){
                     alert('Error.\nParsing JSON Request failed.');
                 }else if(e=='timeout'){
                     alert('Request Time out.');
                 }else {
                     alert('Unknow Error.\n'+x.responseText);
                 }
             }});}
         else return false;



        }
    function myFunction33(id,comments,a_id){
        if(confirm("确定删除此条评论吗?")){

            var url="<?=site_url('')?>"+"question/replyDelete/"+id;

            $.ajax({
                url: url,

                type:'get',
                success: function (res) {

                    document.getElementById("li_2_"+id).style.display = "none";
                    comments--;
                    if (document.getElementById("value_set1_"+a_id).value!="0"){


                        comments=parseInt(document.getElementById("value_set1_"+a_id).value)-1;
                        document.getElementById("value_set1_"+a_id).value=comments.toString();
                    }

                    document.getElementById("value_set1_"+a_id).value=comments.toString();
                    document.getElementById("a_"+a_id).textContent="查看所有回复（"+comments+"条）";},
                error: function (x,e ){
                    if(x.status==0){
                        alert('You are offline!!\n Please Check Your Network.');
                    }else if(x.status==404){
                        alert('Requested URL not found.');
                    }else if(x.status==500){
                        alert('Internel Server Error.');
                    }else if(e=='parsererror'){
                        alert('Error.\nParsing JSON Request failed.');
                    }else if(e=='timeout'){
                        alert('Request Time out.');
                    }else {
                        alert('Unknow Error.\n'+x.responseText);
                    }
                }});}
        else return false;



    }
    function myFunction333(id,comments,a_id){
        if(confirm("确定删除此条评论吗?")){

            var url="<?=site_url('')?>"+"question/replyRDelete/"+id;

            $.ajax({
                url: url,

                type:'get',
                success: function (res) {

                    document.getElementById("li_3_"+id).style.display = "none";
                    comments--;
                    if (document.getElementById("value_set0_"+a_id).value!="0"){


                        comments=parseInt(document.getElementById("value_set0_"+a_id).value)-1;
                        document.getElementById("value_set0_"+a_id).value=comments.toString();
                    }

                    document.getElementById("value_set0_"+a_id).value=comments.toString();
                    document.getElementById("r_"+a_id).textContent="查看所有回复（"+comments+"条）";},
                error: function (x,e ){
                    if(x.status==0){
                        alert('You are offline!!\n Please Check Your Network.');
                    }else if(x.status==404){
                        alert('Requested URL not found.');
                    }else if(x.status==500){
                        alert('Internel Server Error.');
                    }else if(e=='parsererror'){
                        alert('Error.\nParsing JSON Request failed.');
                    }else if(e=='timeout'){
                        alert('Request Time out.');
                    }else {
                        alert('Unknow Error.\n'+x.responseText);
                    }
                }});}
        else return false;



    }






</script>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script src="<?=WWW_domian?>js/jquery.hotkeys.js"></script>
<script src="<?=WWW_domian?>js/wysiwyg/bootstrap-wysiwyg.js"></script>
<script src="<?=WWW_domian?>js/ajaxfileupload.js"></script>

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
                            $("#btnJoin").attr('joined','1').removeClass('btn-success').addClass('btn-warning').empty().html('退出小组');
                        }else{
                            $("#btnJoin").attr('joined','0').removeClass('btn-warning').addClass('btn-success').empty().html('加入小组');
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
        $("#btnSave").click(function(){
            var content= $.trim($('#editor').html());
            if(content.length<1){alert('内容不能为空!');return;}
            var url=g_siteUrl+'question/addanswerajax/<?=$questionid?>';
            $.ajax({
                url: url,
                data:'spid=<?=$spid?>&content='+encodeURIComponent(content),
                type:'post',
                success: function (res) {
                    if(res>0){
                        alert('提交成功');
                        window.location.reload();
                    }else if(res==0){
                        alert('信息不完整');
                    }else if(res==-1){
                        alert('请先登录');
                    }else if(res==-2){
                        alert('请先加入部落');
                    }
                },
                error: function () {
                }
            });
        });
        $("#btnFollow").click(function(){
            var follow=$(this).attr('follow');
            var url=g_siteUrl+'question/addfollowajax/<?=$questionid?>';
            $.ajax({
                url: url,
                data:'followed=<?=$followed?>',
                type:'post',
                success: function (res) {
                    if(res>0){
                        if(follow=='0'){
                            $("#btnFollow").attr('follow','1').removeClass('btn-success').addClass('btn-warning').empty().html('取消关注');
                        }else{
                            $("#btnFollow").attr('follow','0').removeClass('btn-warning').addClass('btn-success').empty().html('关注');
                        }
                        alert('提交成功');
                        window.location.reload();
                    }else if(res==0){
                        alert('信息不完整');
                    }else if(res==-1){
                        alert('请先登录');
                    }else if(res==-2){
                        alert('请先加入部落');
                    }
                },
                error: function () {
                }
            });
        });
        $(".btn-like").click(function(){
            var $btnLiked=$(this);
            var liked=parseInt($btnLiked.attr('liked'));
            var answer_id=$btnLiked.attr('answer');
            var url=g_siteUrl+'question/answer_like_ajax/'+answer_id;
            $.ajax({
                url: url,
//                data:'liked='+liked,
                dataType: 'json',
                success: function (res) {
                    if(res>0){
                        if(res=='1'){
                            liked++;
                            $btnLiked.attr('liked',liked.toString());
                            $btnLiked.find('span.span-like').text('已赞('+liked.toString()+')人');
                        }else{
                            liked--;
                            $btnLiked.attr('liked',liked.toString());
                            $btnLiked.find('span.span-like').text('赞('+liked.toString()+')人');
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

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



        $(".btn-like0").click(function(){
            var $btnLiked=$(this);
            var liked=parseInt($btnLiked.attr('liked'));
            var answer_reply_id=$btnLiked.attr('answer');
            var url=g_siteUrl+'question/answer_reply_like_ajax/'+answer_reply_id;
            $.ajax({
                url: url,
//                data:'liked='+liked,
                dataType: 'json',
                success: function (res) {
                    if(res>0){
                        if(res=='1'){
                            liked++;
                            $btnLiked.attr('liked',liked.toString());
                            $btnLiked.find('span.span-like').text('已赞('+liked.toString()+')人');
                        }else{
                            liked--;
                            $btnLiked.attr('liked',liked.toString());
                            $btnLiked.find('span.span-like').text('赞('+liked.toString()+')人');
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















        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////












        function initToolbarBootstrapBindings() {
            var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                    'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                    'Times New Roman', 'Verdana'],
                fontTarget = $('[title=Font]').siblings('.dropdown-menu');
            $.each(fonts, function (idx, fontName) {
                fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
            });
            $('a[title]').tooltip({container:'body'});
            $('.dropdown-menu input').click(function() {return false;})
                .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
                .keydown('esc', function () {this.value='';$(this).change();});

            $('[data-role=magic-overlay]').each(function () {
                var overlay = $(this), target = $(overlay.data('target'));
                overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
            });
            $('#voiceBtn').hide();
            // if ("onwebkitspeechchange"  in document.createElement("input")) {
            //   var editorOffset = $('#editor').offset();
            //   $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
            // } else {
            //   $('#voiceBtn').hide();
            // }
        };
        initToolbarBootstrapBindings();
        $('#editor').wysiwyg();

        $('#pictureBtn').click(function() {
            $('#Filedata').click();
        });

        $('#Filedata').change(function() {
            uploadFile();
        });

        function uploadFile(){
            $.ajaxFileUpload
            (
                {
                    url: g_siteUrl+'upload/do_upload',
                    secureuri:false,
                    fileElementId:'Filedata',
                    dataType: 'json',
                    data:{spid:<?=$spid?>,uptype:'question'},
                    success: function (data, status)
                    {
//                        console.log(data);
                        var img_url=g_siteUrl+data.src;
                        insertImg(img_url);
                        $('#Filedata').change(function() {
                            uploadFile();
                        });
                    },
                    error: function (data, status, e)
                    {
                        alert(e);
                    }
                }
            )
        }

        $("#loading").ajaxStart(function(){
            $(this).show();
        }).ajaxComplete(function(){
            $(this).hide();
        });

        var editor = document.getElementById("editor");
        var range, bookmark;
        var saveFocus = function(){//保存焦点状态
            if (document.selection) { //只有坑爹的IE才执行下面的代码
                range = document.selection.createRange();
                bookmark=range.getBookmark();
            }
            editor.focus();
        }
        editor.onclick = saveFocus;//在鼠标点击编辑区时保存焦点
        editor.onkeydown = saveFocus;//在输入内容时也保存焦点

        function insertImg(_img) {
            if (range) { //同样，坑爹IE专用代码
                range.moveToBookmark(bookmark);
                range.select();
            }
            editor.focus();
            document.execCommand('InsertImage', false, _img);
        }
    });

</script>

</body>
</html>