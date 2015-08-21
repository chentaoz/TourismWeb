<?php  $this->load->view('head');?>
</head>
<?php echo $form;?>
<table>
    <tr>
        <th colspan="4">添加运动攻略</th>
    </tr>
    <tr>
        <td class="right" width="80">标题：</td>
        <td class="" width="30%"><input name="title" type="text" id="title" /></td>
        <td class="right" width="80">版本：</td>
        <td class=""><input name="version" type="text"  /></td>
    </tr>
    <tr>
        <td class="right">预览图：</td>
        <td class=""><input name="banner1" type="file" />jpg|gif|png</td>

        <td class="right">封面图：</td>
        <td class=""><input name="preview" type="file" />jpg|gif|png</td>
    </tr>
    <tr>
        <td class="right">攻略文件：</td>
        <td class=""><input name="guide" type="file"  />pdf</td>
    </tr>
    <tr>
        <td class="right">页数：</td>
        <td class="left"><input name="pagenum" type="text"  value="1"/></td>
        <td class="right">排序：</td>
        <td class="left"><input name="weight" type="text"  value="255"/></td>
    </tr>
    <tr>
        <td class="right">描述：</td>
        <td class="left"><textarea name="description"  cols="32" /></textarea></td>
        <td class="right">选择等级：</td>
        <td class="">
            <select name="level">
              <?php foreach ($level as $v):?>
                  <?php if(!empty($v)):?>
                <option value="<?=$v['ttid']?>"> <?=$v['name']?> </option>
                      <?php endif ?>
              <?php endforeach?>
            </select>
        </td>
    </tr>
    <tr>
      <td><input type="hidden" name="sp_id" value="<?=$sp_id?>"></td>
      <td><input type="hidden" name="place_id" value=""><input type="submit" value="提交" class="submit" /></td>
      <td><td><input type="hidden" name="p_level" value="<?=$p_level?>"></td></td>
      <td></td>
    </tr>
</table>
</form>
<table id="t">
  <tr>
    <th width="31%">标题</th>
    <th width="19%">封面图片</th>
    <th width="6%">排序</th>
     <th width="19%">状态</th>
    <th width="12%">操作</th>
  </tr>
    <?php if($guide){?>
        <?php foreach($guide as $k=>$v){?>
            <tr class="<?=$v['gid']?>">
                <td>&nbsp;<?php echo $v['title']; ?></td>
                <td><a class="group" href="<?php echo '/'.$this->config->item('upload_guide_image').'/'.$v['img']; ?>" target="_blank"><img src="<?php echo base_url().'images/image.png';?>" class="absmiddle" title="查看图片" />点击查看大图</a></td>
                <td>&nbsp;<?php echo $v['weight']; ?></td>
                <td>&nbsp;<?php if($v['sta']==0){echo "激活";}else{echo "未激活";} ?></td>
                <td><a href="<?php echo site_url('sports/guide_edit/'.$v['gid'].'/'.$v['sport_id'].'/'.$p_level);?>">编辑</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="delete_guide(<?=$v['gid']?>)" class="f2">删除</a></td>
            </tr>
        <?php } ?>
    <?php }else{?>
        <tr>
            <td colspan="4" class="center ui-page">
                <em>对不起！暂无数据</em>
            </td>
        </tr>
    <?php }?>
</table>
<link rel="stylesheet" href="<?=base_url().'css/colorbox.css'?>" type="text/css">
<script src="<?=base_url().'js/jquery.colorbox.js'?>"></script>
<script>
    $(function() {
        $(".group").colorbox({rel:'group', transition:"none", width:"75%", height:"75%"});
        $("#form").validate({
            rules: {
                version:"required",
                title: "required",
                description:"required",
                guide: "required",
                preview:"required",
                pagenum: {digits:true,required:true},
                weight: {digits:true,required:true}
            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                version:"请输入",
                title : "请输入标题",
                guide:"请上传攻略文件",
                pagenum: "页数须为整数",
                description:"请填写描述",
                preview:"请上传图片",
                weight:"排序须为整数"

            }
        });
    });
    //删除操作
    function delete_guide(id){
        if(isNaN(id)){
            alert('操作可能有误');
            return false;
        }
        if(confirm('确实要删除吗?')){
            var url='<?=site_url('sports/guide_delete')?>';
            $.post(url, {'gid':id},function(r){
                if(r=1){
                    $('.'+id).remove();
                    alert('成功删除');
                }else{
                    alert('删除失败');
                }

            });
        }


    }
</script>