</head>
<body>

<?php echo $form;?>
<table>
    <tr>
        <th colspan="4">添加场地攻略</th>
    </tr>
    <tr>
        <td class="right" width="80">标题：</td>
        <td class="left" width="100"><input name="title" type="text" id="title" /></td>
        <td class="right" width="80">版本：</td>
        <td class="left"><input name="version" type="text" id="version" /></td>
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
        <td class="left"><input name="pagenum" type="text" id="pagenum" value="1"/></td>
        <td class="right"></td>
        <td class="left"></td>
    </tr>
    <tr>
        <td class="right">描述：</td>
        <td class="left"><textarea name="description"  id="description" cols="32" /></textarea></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="hidden" name="place_id" value="<?php echo $place_id;?>"><input type="submit" value="提交" class="submit" /></td>
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
                guide: "required",
                pagenum: {digits:true,required:true}
            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                title : "请输入标题",
                guide:"请上传攻略文件",
                pagenum: "页数须为整数"
        });
    });

</script>