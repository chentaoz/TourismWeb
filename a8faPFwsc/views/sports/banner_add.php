<?php  $this->load->view('head');?>
<link rel="stylesheet" href="<?=base_url().'css/colorbox.css'?>" type="text/css">
</head>
<form id="form" action="<?=site_url('sports/banner_add')?>" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <th height="30" colspan="2" class="left">户外活动banner添加与修改</th>
        </tr>
        <input type="hidden" name="pid" value="<?=$sp_id?>">
        <tr>
            <td width="10%" class="right">所属运动名称：</td>
            <td>
             <?=$sports['name'].'---'.$sports['name_en']?>
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">banner图片：</td>
            <td>
               <input type="file" name="img" value="">
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">排序：</td>
            <td>
              <input type="text" name="order">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input style="margin-left:150px"name="Submit" type="submit" class="submit" value="提交">
            </td>
        </tr>
    </table>

</form>
<!--运动下的banner列表-->
<table id="t">
    <tr>
        <th width="10%">图片</th>
        <th width="20%">排序</th>
        <th width="50%">操作</th>
    </tr>
    <?php if($sports_banner){?>
        <?php foreach($sports_banner as $v):?>
            <tr>
                <td>
                    <a class="group" href="<?=$url.'/'.$this->config->item('upload_place_sport').'/'.$v['img']?>">
                        <img height='40'src="<?=$url.'/'.$this->config->item('upload_place_sport').'/'.$v['img']?>"></a>
                    点击放大
                </td>
                <td><?=$v['weight']?></td>
                <td>
                    <a href="<?=site_url('sports/banner_edit/'.$v['psiid'])?>">编辑</a>
                    <a href="javascript:;" onclick="my_delete(<?=$v['psiid']?>)">删除</a>
                </td>
            </tr>
        <?php endforeach?>
    <?php }else{?>
        <tr>
            <td colspan="2" class="center ui-page">
                <em>对不起！暂无banner数据请添加</em>
            </td>
        </tr>
    <?php }?>
</table>
<script>
    $(function() {
        $(".group").colorbox({rel:'group', transition:"none", width:"75%", height:"75%"});
        $("#form").validate({
            rules: {
                img: "required",
                order: {digits:true,required:true}

            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                img: "请选择一个图片",
                order: "请填写数字"
            }
        });
    });
   //删除操作
    function my_delete(d_id){
        if(confirm('确实要删除吗?')){
            var url='<?=site_url('sports/delete')?>';
            $.post(url, {'id':d_id},function(result){
                 if(result=1){
                   alert('成功删除');
                 }else{
                     alert('删除失败');
                 }
                window.location.reload();
            });
        }

    }
</script>
<script src="<?=base_url().'js/jquery.colorbox.js'?>"></script>

