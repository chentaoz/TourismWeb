<?php  $this->load->view('head');?>
</head>
<body>
<form id="form" action="<?=site_url('taxonomy/edit_child')?>" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <th colspan="2">编辑子类</th>
        </tr>
        <tr>
            <td class="left" width="60px">子类名称：</td>
            <td class="left"><input name="name" type="text" id="name" class="ex100"  class="required" value="<?=$info['name']?>"/></td>
        </tr>
        <tr>
            <td class="left" width="60px">图片：</td>
            <td class="left"><input name="imgs" type="file" /><em>jpg|png|jpeg 不需要可以空白</em></td>

        </tr>
        <?php if($info['img']){?>
        <tr>
            <td class="left" width="60px">原图片：</td>
            <td class="left">
                <a class="group" href="<?=$url.'/'.$this->config->item('upload_taxonomy').'/'.$info['img']?>">
                 <img height="40" src="<?=$url.'/'.$this->config->item('upload_taxonomy').'/'.$info['img']?>">
                </a>点击放大
            </td>

        </tr>
        <?php }?>
        <tr>
            <td class="left" width="60px">描述：</td>
            <td class="left"><input name="description" type="text"  class="ex300" value="<?=$info['description']?>"/></td>
        </tr>
        <tr>
            <td class="left" width="60px">排序：</td>
            <td class="left"><input name="weight" type="text" class="ex100"  value="<?=$info['weight']?>"/></td>
        </tr>
        <tr>
            <td colspan="2" class="left">
                <input type="hidden" name="tid" value="<?=$info['ttid']?>">
                <input type="submit" name="Submit" value="提交" class="submit" />
                <div id='tip' style="color:red;font-weight: bold"></div>
            </td>
        </tr>
    </table>

</form>
<link rel="stylesheet" href="<?=base_url().'css/colorbox.css'?>" type="text/css">
<script src="<?=base_url().'js/jquery.colorbox.js'?>"></script>
<script>
    $(function() {
        $(".group").colorbox({rel:'group', transition:"none", width:"75%", height:"75%"});
        $("#form").validate({
            rules: {
                name: "required",
                description: "required",
                weight:{digits:true,required:true}
            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                name: "请输入子类名称",
                description: "请填写描述",
                weight:"请输入整数"
            }
        });
    });
    //判断数据库中是否已经存在装备。
    var parents='';
    var tid='';
    $(function(){
        $('#name').blur(function(){
            var f_name= $('#name').val().replace(/\s+/g,"");
            parents= $('#parent').val();
            var url="<?=site_url('taxonomy/equip')?>";
            $.post(url, {'name':f_name},function(result){
                tid=result.ttid;
                if(tid){
                    $('.submit').hide();
                    $('#tip').html('不能修改！此装备名已经存在！请更改其他装备名称');
                }else{
                    $('.submit').show();
                    $('#tip').html('');
                }
            },'json');
        });

    })








</script>