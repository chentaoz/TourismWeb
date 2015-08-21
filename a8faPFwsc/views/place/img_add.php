</head>
<body>
<?php echo $imgform;?>
<table>
    <tr>
        <th colspan="2">图片列表</th>
    </tr>

    <tr>
        <td class="right">请选图片文件：</td>
        <td class="left"><input name="banner1" type="file" id="banner1" class="file required" /></td>
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
    <th width="19%">图片</th>
    <th width="6%">排序</th>
    <th width="12%">操作</th>
  </tr>
    <?php if($img){?>
      <?php foreach($img as $k=>$v){?>
  <tr>
    <td><a href="<?php echo base_url('../'.$this->common->uploadpath.'place_sport/'.$v['img']); ?>" target="_blank"><img src="<?php echo base_url().'images/image.png';?>" class="absmiddle" title="查看图片" />点击查看大图</a></td>
    <td>&nbsp;<?php echo $v['weight']; ?></td>
    <td><a href="<?php echo site_url('place/img_edit/id/'.$v['psiid'].'/placeid/'.$v['place_id']);?>">编辑</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="delAlert('<?php echo site_url('place/img_del/id/'.$v['psiid'].'/placeid/'.$v['place_id']);?>')" class="f2">删除</a></td>
  </tr>
    <?php } ?>
  <tr>
    <td colspan="3" class="center ui-page"><?php echo $this->pagination->create_links();?></td>
  </tr>
    <?php }else{?>
        <tr>
            <td colspan="3" class="center ui-page">
                <em>对不起！暂无数据</em>
            </td>
        </tr>
    <?php }?>
</table>
<script>
    $(function() {
        $("#form1").validate({
            rules: {
                banner1: "required"
            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                banner1: "请选择文件"

            }
        });
    });

</script>