</head>
<body>

<?php echo $form;?>
<table>
    <tr>
        <th colspan="2">场地攻略列表</th>
    </tr>
    <tr>
        <td class="right">标题：</td>
        <td class="left"><input name="title" type="text" id="title" /></td>
    </tr>
    <tr>
      <td class="right" width="100">运动级别：</td>
      <td><select name="term_level_id" id="term_level_id">
          <option value="">请选择运动级别</option>
       <?php if($taxonomy){?>
           <option value="0">通用级别</option>
           <?php foreach($taxonomy as $k=>$v){?>
               <option value="<?php echo $v['ttid']; ?>"><?php echo $v['name']; ?></option>
           <?php } ?>
       <?php }else{?>
           <option value="0">通用级别</option>
       <?php }?>
      </select></td>
    </tr>
    <tr>
        <td class="right">版本：</td>
        <td class="left"><input name="version" type="text" id="version" /></td>
    </tr>
    <tr>
        <td class="right">预览图：</td>
        <td class="left"><input name="img" type="file" id="img" class="file required" /></td>
    </tr>
    <tr>
        <td class="right">封面图：</td>
        <td class="left"><input name="preview" type="file" id="preview" class="file required" /></td>
    </tr>
    <tr>
        <td class="right">排序：</td>
        <td class="left"><input name="weight" type="text" id="weight" value="255"/></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="hidden" name="place_id" value="<?php echo $place_id;?>"><input type="submit" value="提交" class="submit" /></td>
    </tr>
</table>
</form>
<table id="t">
  <tr>
    <th width="31%">标题</th>
    <th width="19%">封面图片</th>
    <th width="6%">排序</th>
    <th width="12%">操作</th>
  </tr>
    <?php if($guide_lis){?>
      <?php foreach($guide_lis as $k=>$v){?>
  <tr>
    <td>&nbsp;<?php echo $v['title']; ?></td>
    <td><a href="<?php echo base_url('../'.$this->common->uploadpath.'place_sport/'.$v['banner']); ?>" target="_blank"><img src="<?php echo base_url().'images/image.png';?>" class="absmiddle" title="查看图片" />点击查看大图</a></td>
    <td>&nbsp;<?php echo $v['paixu']; ?></td>
    <td><a href="<?php echo site_url('place/img_edit/id/'.$v['psiid'].'/placeid/'.$v['place_id']);?>">编辑</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="delAlert('<?php echo site_url('place/img_del/id/'.$v['psiid'].'/placeid/'.$v['place_id']);?>')" class="f2">删除</a></td>
  </tr>
    <?php } ?>
  <tr>
    <td colspan="4" class="center ui-page"><?php echo $this->pagination->create_links();?></td>
  </tr>
    <?php }else{?>
        <tr>
            <td colspan="4" class="center ui-page">
                <em>对不起！暂无数据</em>
            </td>
        </tr>
    <?php }?>
</table>
<script>
    $(function() {
        $("#form1").validate({
            rules: {
                title: "required"
            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                title: "请输入标题"

            }
        });
    });

</script>