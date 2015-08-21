<?php  $this->load->view('head');?>
<link rel="stylesheet" href="<?=base_url().'css/colorbox.css'?>" type="text/css">
</head>
<form id="form" action="<?=site_url('sports/banner_edit')?>" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <input type="hidden" >
            <th height="30" colspan="2" class="left">户外活动banner编辑</th>
        </tr>
        <tr>
            <td width="10%" class="right">banner图片：</td>
              
            <td>
                <input type="file" name="img" value="">

            </td>
        </tr>
        <tr>
            <td width="10%" class="right">原始图片：</td>
            <td>
                <a class="group" href="<?=$url.'/'.$this->config->item('upload_place_sport').'/'.$img_info['img']?>">
                    <img height='40'src="<?=$url.'/'.$this->config->item('upload_place_sport').'/'.$img_info['img']?>"></a>
                点击放大
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">排序：</td>
            <td>
                <input type="text" name="order" value="<?=$img_info['weight']?>">
            </td>
        </tr>
        <tr>
            <td><input type="hidden" name="b_id" value="<?=$img_info['psiid']?>">
                <input type="hidden" name="s_id" value="<?=$img_info['sport_id']?>">
            </td>
            <td>
                <input style="margin-left:150px"name="Submit" type="submit" class="submit" value="提交">
            </td>
        </tr>
    </table>

</form>

<script>
    $(function() {
        $(".group").colorbox({rel:'group', transition:"none", width:"75%", height:"75%"});
        $("#form").validate({
            rules: {
                order: {digits:true,required:true}
            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                order: "请填写数字"
            }
        });
    });
</script>
<script src="<?=base_url().'js/jquery.colorbox.js'?>"></script>

