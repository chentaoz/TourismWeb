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
        <td class="left"><input name="weight" type="text" id="weight" value="<?php echo $img['weight'];?>"/></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="hidden" name="psiid" value="<?php echo $img['psiid'];?>"><input type="hidden" name="place_id" value="<?php echo $img['place_id'];?>"><input type="submit" value="提交" class="submit" /></td>
    </tr>
</table>

</form>