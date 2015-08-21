<?php $this->load->view('head_other_v1', array('currentTab' => 2)); ?>
<link href="<?=base_url()?>css/question.css" rel="stylesheet" type="text/css" />
<!--<link href="--><?//=base_url()?><!--css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
<link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
<!--main-->
<style>
    .editor img{max-width:70%;max-height:70%;}
</style>
<div class="container detailscont">
    <div class="row">
        <div class="col-md-8">
            <div>
                <ol class="breadcrumb" style="background: #fff">
                    <li><a href="<?=base_url()?>">野孩子</a></li>
                    <li><a href="<?=site_url('sport') ?>">兴趣部落</a></li>
                    <li><a href="<?=site_url() ?>question/index/<?=$spid ?>"><?= $sport['name'] ?>(<?= $sport['name_en'] ?>)</a></li>
                    <li class="active">发布新问题</li>
                </ol>
            </div>
            <?php if(!$joined){ ?>
            <div class="mod card" style="padding-top:10px;">
                <p class="jointak">
                    <button id="btnJoin2" class="btn btn-success btn-xs" joined="0">加入部落</button>
                    才能发言哦。
                </p>
            </div>
            <?php }else{ ?>
            <div class="mod card" style="padding-top:10px;">
                <form id="form1" method="post" action="">
                <div class="form-group">
                    <input id="title" name="title" type="text" class="form-control" placeholder="标题" aria-describedby="basic-addon1">
                </div>
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

                <div id="editor" class="editor">
                </div>
                <div class="form-group">
                    <p><input id="btnSave" class="btn btn btn-success pull-left" type="button" value="提交">
                        <img id="loading" src="<?php echo base_url() ?>js/loading.gif" width="30" height="30" style="display: none;">
                    </p>
                </div>
                    <input type="hidden" name="content" id="content" />
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
                            <button id="btnJoin" class="btn btn-warning btn-s" joined="1">
                                已是部落成员
                            </button>
                        <?php }else{ ?>
                            <button id="btnJoin" class="btn btn-success btn-s" joined="0">
                                加入部落
                            </button>
                        <?php } ?>
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
<div id="filediv">
    <input type="file" name="Filedata" id="Filedata" style="display: none">
</div>
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script src="<?=WWW_domian?>js/jquery.hotkeys.js"></script>
<script src="<?=WWW_domian?>js/wysiwyg/bootstrap-wysiwyg.js"></script>
<script src="<?=WWW_domian?>js/ajaxfileupload.js"></script>
<script type="text/javascript">
    $(function(){
        $("#btnJoin,#btnJoin2").click(function(){
            var joined=$(this).attr('joined');
            var url=g_siteUrl+'sport/join/<?=$spid?>';
            $.ajax({
                url: url,
                data:'joined='+joined,
                dataType: 'json',
                success: function (res) {
                    if(joined=='0'){
                        $("#btnJoin").attr('joined','1').removeClass('btn-success').addClass('btn-warning').empty().html('已是部落成员');
                    }else{
                        $("#btnJoin").attr('joined','0').removeClass('btn-warning').addClass('btn-success').empty().html('加入部落');
                    }
                    location.reload();
                },
                error: function () {
                }
            });
        });

        $("#btnSave").click(function(){
            var title= $.trim($('#title').val());
            var content= $.trim($('#editor').html());
            if(title.length<1){alert('标题不能为空!');return;}
            if(content.length<1){alert('内容不能为空!');return;}
//            $('#content').val(content);
//            $('#form1').submit();
//            return;
            var url=g_siteUrl+'question/addajax/<?=$spid?>';
            $.ajax({
                url: url,
                data:'title='+encodeURIComponent(title)+'&content='+encodeURIComponent(content),
                type:'post',
                success: function (res) {
                    if(res>0){
                        alert('提交成功');
                        location.href=g_siteUrl+'question/detail/'+res;
                    }else if(res==0){
                        alert('信息不完整');
                    }else if(res==-1){
                        window.location.href="<?=PASSPORT_domian?>oauth/login?reurl="+encodeURIComponent(location.href);
                    }else if(res==-2){
                        alert('请先加入部落');
                    }
                },
                error: function () {
                }
            });
        });
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

                        //todo remove
                        console.log(data);
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

            //todo remove
            console.log(_img);
            document.execCommand('InsertImage', false, _img);
        }
    });
</script>
<!--<script src="http://www.nihilogic.dk/labs/exif/exif.js"-->
<!--        type="text/javascript"></script>-->
<!--<script src="http://www.nihilogic.dk/labs/binaryajax/binaryajax.js"-->
<!--        type="text/javascript"></script>-->
<!--<script src="/js/load-image.all.min.js"></script>-->
</body>
</html>