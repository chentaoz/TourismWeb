<?php  $this->load->view('head');?>
</head>
<body>
<form id='form' action="<?= site_url('sports')?>" method="post">
    <table>
        <tr>
            <th height="30" colspan="2" class="left">户外活动管理</th>
        </tr>
        <tr>
            <td width="20%" class="right">
                <input type="radio" name="language" value="c" checked>中文
                <input type="radio" name="language" value="e" <?php if($l=='e')echo 'checked';?>>英文
                名称：</td>
            <td><input name="key_name" type="text"  value="<?=$keyword?>" /></td>
        </tr>
        <tr>
            <td colspan="2" class="center"><input name="Submit" type="submit" class="submit" value="提交" /></td>
        </tr>
    </table>
</form>
<table id="t">
    <tr>
        <th width="10%">中文名称</th>
        <th width="15%">英文名称</th>
        <th width="10%">排序</th>
        <th width="30%">状态</th>
        <th width="50%">操作</th>
    </tr>
    <?php if($sports_list){?>
           <?php foreach($sports_list as $v):?>
                <tr>
                    <td><?=$v['name']?></td>
                    <td><?=$v['name_en']?></td>
                    <td><?=$v['weight']?></td>
                    <td>
                        <?php if($v['sta']==0){?>
                            <a title="点击修改" class="change_sta" href="#" sta="<?=$v['sta']?>" id="<?=$v['spid']?>">  激活</a>
                           <?php }elseif($v['sta']==1){?>
                            <a title="点击修改" class="change_sta red" href="#" sta="<?=$v['sta']?>" id="<?=$v['spid']?>">非激活</a>

                        <?php }?>
                    </td>
                    <td><a href="<?=site_url('sports/sports_edit/'.$v['spid'])?>">编辑</a>&nbsp;&nbsp;
                        <!--
                        <a href="javascript:;" onclick="my_delete(<?=$v['spid']?>)">删除</a>&nbsp;&nbsp;
                        -->
                        <a href="<?=site_url('sports/banner_add/'.$v['spid'])?>">Banner</a>&nbsp;&nbsp;
                        <a href="<?=site_url('sports/guide_add/'.$v['spid'].'/'.$v['term_id'])?>">技术攻略</a>&nbsp;&nbsp;
                        <a href="<?=site_url('sports/details/'.$v['spid'])?>">设置人员清单</a>
                    </td>
                </tr>
            <?php endforeach?>
    <?php }else{?>
        <tr>
            <td colspan="6" class="center ui-page">
               <em>对不起！暂无数据</em>
            </td>
        </tr>
    <?php }?>
    <tr>
        <td colspan="6" class="center ui-page">
            <?php echo $this->pagination->create_links(); ?>
        </td>
    </tr>
</table>
<script>
    //表单验证
    $(function() {
        $("#form").validate({
            rules: {
                key_name: "required"

            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                key_name: "请输入关键字"
            }
        });
    });
    //更改状态
    $(function(){
        $('.change_sta').click(function(){
            var sport_status=$(this).attr('sta');//运动状态
            var s_id= $(this).attr('id');//ID
            var url='<?=site_url('sports/change_statues')?>';
            var s=$(this);
            $.post(url, {'id':s_id,'status':sport_status},function(v){
                if(v){
                    //激活的时候改成暂停
                    if(sport_status==0){
                        s.attr('sta','1');
                        s.html('非激活');
                        s.addClass('red');
                    }else if(sport_status==1){//暂停的时候改成激活
                        s.attr('sta','0');
                        s.html('激活');
                        s.removeClass('red');
                    }
                }else{
                    alert('Sorry something wrong');
                }

            });
        })

    })
   //删除操作
    function my_delete(d_id){
        alert
        if(confirm('确实要删除吗?')){
            var url='<?=site_url('sports/up_delete')?>';
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