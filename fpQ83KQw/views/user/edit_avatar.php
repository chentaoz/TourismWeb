<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<style type="text/css">
    #avatar{padding-left: 5px;
        padding-bottom: 20px;
        margin-top: -10px;}
    #avatar img{max-width: 120px;max-height: 120px;}
    .progressBarStatus {height: 120px;display: table-cell;text-align: center;vertical-align: middle;}
    .progressBarStatus img{max-width: 120px;max-height: 120px;}
</style>
<!--member-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>0));?>
    <?php  $this->load->view('user_left_menu',array('left_currentTab'=>4));?>
    <div class="user_right r">
        <div class="user_right_tit">
            <div class="user_right_title l">修改头像</div>
            <div class=" r"></div>
            <div class="clear"></div>
        </div>
        <div>
            <div id="avatar">
                <?php if($avatar){ ?>
                    <img src="<?=get_avatar_src($user['uid'])?>" />
                <?php }?>
            </div>

            <table>
                <tr>
                    <td>
                        <div style="border:1px solid #CEE2F2;width:244px;height:267px;padding:2px;margin: 5px;">
                            <span id="spanButtonPlaceHolder"></span>
                            <input id="btnCancel" type="hidden" value="取消所有上传" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
                            <div>支持 jpg,gif,png,jpeg格式的图片，建议图片尺寸大于128*128.小于1M</div>
                            <div id="divStatus">最多上传1张</div>
                        </div>
                    </td>
                    <td valign="top" style="padding:6px;">
                        <div id="fsUploadProgress" class="clear">
                        </div>
                    </td>
                </tr>
            </table>
           <div style="text-align: left; padding-right: 40px"> <input type="button" id="save" style="margin:10px 20px 50px 0" class="user_file_sub" value="保存" /></div>
        </div>

    </div>

	<div class="clear"></div>

</div>

<!--member-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    var swfu;
    window.onload = function() {
        var settings = {
            flash_url : "<?=base_url().'js/swfupload/swfupload.swf'?>",
            upload_url: "<?=site_url('upload/do_upload')?>",
            post_params: {"PHPSESSID" : "<?php echo session_id(); ?>","uptype":"avatar"},
            file_size_limit : "1MB",
            file_types : "*.jpg;*.gif;*.png;*.jpeg",
            file_types_description : "Image Files",
            file_upload_limit : 1,  //配置上传个数
            file_queue_limit : 0,
            custom_settings : {
                progressTarget : "fsUploadProgress",
                cancelButtonId : "btnCancel"
            },
            debug: false,
            // Button settings
            button_image_url: "<?=base_url().'images/upload.png'?>",
            // button_cursor:'SWFUpload.CURSOR.HAND',
            button_width: "245",
            button_height: "200",
            button_placeholder_id: "spanButtonPlaceHolder",
            button_text: '',
            button_text_style: "",
            button_text_left_padding: 12,
            button_text_top_padding: 3,

            file_queued_handler : fileQueued,
            file_queue_error_handler : fileQueueError,
            file_dialog_complete_handler : fileDialogComplete,
            upload_start_handler : uploadStart,
            upload_progress_handler : uploadProgress,
            upload_error_handler : uploadError,
            upload_success_handler : uploadSuccess,
            upload_complete_handler : uploadComplete,
            queue_complete_handler : queueComplete
        };
        swfu = new SWFUpload(settings);
    };
//    function uploadSuccess(file, serverData){
//        var dataObj=eval("("+serverData+")");//转换为json对象
//        $img='<img src="'+dataObj.src+'" class="user_head_img" filename="'+dataObj.filename+'" />';
//        $('#avatar').html($img);
//    }
//
//    function queueComplete(numFilesUploaded) {
//        var status = document.getElementById("fsUploadProgress");
//        status.innerHTML = "";
//    }
    //调用自定义上传完成事件
    function uploadSuccessCustom(progress,swfUploadInstance,file,serverData){
//        console.log(progress);
//        console.log(serverData);
        var dataObj=eval("("+serverData+")");//转换为json对象
        var img='<img src="'+dataObj.src+'" class="user_head_img" filename="'+dataObj.filename+'" />';
        var id= file.id;
        $('#'+id).find('.progressName').hide(); //隐藏文件名
        progress.setStatus(img); //显示图片
        progress.toggleCancel(true,swfUploadInstance);
    }

    //取消上传自定义事件
    function cancelUploadCustom(swfUploadInstance,fileID){
//        console.log(swfUploadInstance);
//        console.log(fileID);
        $('#'+fileID).remove();
    }

    $('#save').click(function(){
        var name=$('.progressBarStatus').find('img').attr('filename');
        if(name==''||name==undefined){
            alert('请上传头像');
            return;
        }
        //传给php存入数据库
        var url="<?=site_url('user/edit_avatar')?>";
        $.post(url, {'ava_name':name},function(r){
            if (r== 1){
                alert('保存成功');
                window.location.reload();
            }else{
                alert('保存失败');
                window.location.reload();
            }
        });
    });
</script>
</body>
</html>








