</head>
<body>

<?php echo $form;?>
<table>
    <tr>
        <th colspan="4">编辑场地攻略列表</th>
    </tr>
    <tr>
        <td class="right" width="80">标题：</td>
        <td class="left" width="100"><input name="title" type="text" id="title" value="<?php echo $guide['title'];?>"  /></td>
        <td class="right" width="80">版本：</td>
        <td class="left"><input name="version" type="text" id="version"  value="<?php echo $guide['version'];?>"  /></td>
    </tr>
    <tr>
        <td class="right">预览图：</td>
        <td class="left"><input name="banner1" type="file" id="img" /></td>

        <td class="right">封面图：</td>
        <td class="left"><input name="preview" type="file" id="preview"/></td>
    </tr>
    <tr>
        <td class="right">攻略文件：</td>
        <td class="left"><input name="guide" type="file" id="guide" /></td>
    </tr>
    <tr>
        <td class="right">页数：</td>
        <td class="left"><input name="pagenum" type="text" id="pagenum"  value="<?php echo $guide['pagenum'];?>"   /></td>
        <td class="right"></td>
        <td class="left"></td>
    </tr>
    <tr>
        <td class="right">描述：</td>
        <td class="left"><textarea name="description"  id="description" cols="32" /><?php echo $guide['description'];?></textarea></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="hidden" name="gid" value="<?php echo $guide['gid'];?>"><input type="hidden" name="place_id" value="<?php echo $guide['place_id'];?>"><input type="submit" value="提交" class="submit" /></td>
      <td></td>
      <td></td>
    </tr>
</table>
</form>
<script>
    $(function() {
        $("#form1").validate({
            rules: {
                title: "required",
                pagenum: {digits:true,required:true}
            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                title : "请输入标题",
                pagenum: "页数须为整数"
            }
        });
    });

</script>