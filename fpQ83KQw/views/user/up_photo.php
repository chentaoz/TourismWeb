<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--main-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>5));?>
    <!--上传照片-->
    <div class="member_photo_up clear">
        <div class="photo_name">上传照片到：我的照片</div>
        <div id="fsUploadProgress" class="fsUploadProgress clear">
            <div class="photo_info progressWrapper">
                <span id="spanButtonPlaceHolder"></span>
                <input id="btnCancel" class="btnCancel" type="button" value="取消所有上传" onclick="swfu.cancelQueue();" disabled="disabled"/>

                <div id="divStatus" class="divStatus" >0 个文件已上传 一次最多上传10张</div>
            </div>
        </div>
    </div>
    <div class="up_photo_subs"><a href="javascript:;">提交</a></div>
    <!--上传照片-->
</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    var swfu;
    window.onload = function () {
        var settings = {
            flash_url: "<?=base_url().'js/swfupload/swfupload.swf'?>",
            upload_url: "<?=site_url('upload/do_upload')?>",
            post_params: {"PHPSESSID": "<?php echo session_id(); ?>"},
            file_size_limit: "100 MB",
            file_types: "*.jpg;*.gif;*.png;*.jpeg",
            file_types_description: "Image Files",
            file_upload_limit: 10,  //配置上传个数
            file_queue_limit: 0,
            custom_settings: {
                progressTarget: "fsUploadProgress",
                cancelButtonId: "btnCancel"
            },
            debug: false,
            // Button settings
            button_image_url: "<?=base_url().'images/upload.png'?>",
            // button_cursor:'SWFUpload.CURSOR.HAND',
            button_width: "100%",
            button_height: "200",
            button_placeholder_id: "spanButtonPlaceHolder",
            button_text: '',
            button_text_style: "",
            button_text_left_padding: 12,
            button_text_top_padding: 3,

            file_queued_handler: fileQueued,
            file_queue_error_handler: fileQueueError,
            file_dialog_complete_handler: fileDialogComplete,
            upload_start_handler: uploadStart,
            upload_progress_handler: uploadProgress,
            upload_error_handler: uploadError,
            upload_success_handler: uploadSuccess,
            upload_complete_handler: uploadComplete,
            queue_complete_handler: queueComplete
        };
        swfu = new SWFUpload(settings);
    };

    //调用自定义上传完成事件
    function uploadSuccessCustom(progress,swfUploadInstance,file,serverData){
//        console.log(progress);
//        console.log(serverData);
        var dataObj=eval("("+serverData+")");//转换为json对象
        var img='<img src="'+dataObj.src+'" filename="'+dataObj.filename+'" />';
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

    $('.up_photo_subs a').click(function () {
        var images = [];
        var name = $('.progressBarStatus').find('img');
        var l = name.length;
        if (l == 0) {
            alert('请上传图片');
            return false;
        } else {
            $('.up_photo_subs a').html('提交中...');
            for (var i = 0; i < l; i++) {
                images.push($(name[i]).attr('filename'));
            }
            //传给php存入数据库
            var url = "<?=site_url('user/up_photo')?>";
            $.post(url, {'photo_name': images}, function (r) {
                if (r == 1) {
                    layer.msg('保存成功',2,1);
                    layer.close();
                    window.location.reload();
                } else {
                    layer.msg('保存失败',2,3);
                    layer.close();
                    window.location.reload();
                }
            });
        }
    });
</script>
</body>
</html>