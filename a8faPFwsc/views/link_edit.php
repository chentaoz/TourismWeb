<script type="text/javascript">
$(document).ready(function() {
	$('#form1').validateMyForm();
});
</script>
</head>
<body>
<table class="double">
    <?php echo $form; ?>
    <tr>
    <th colspan="2">编辑友情链接</th>
    </tr>
        <tr>
          <td width="10%" class="right">网站名称：</td>
            <td width="90%" class="left"><input name="name" type="text" id="name" class="required ex300" value="<?php echo $link['name']; ?>" /></td>
        </tr>
        <tr>
          <td class="right">链接网址：</td>
            <td class="left"><input name="web" type="text" id="web" class="required ex300" value="<?php echo $link['web']; ?>" /></td>
        </tr>
        <tr>
            <td class="right">网站logo：</td>
            <td class="left"><input name="userfile" type="file" class="file" id="logo" />
                <span class="fontcolorA">文字链接此项可以不填</span></td>
        </tr>
        <tr>
            <td colspan="2" class="center"><input type="hidden" name="id" value="<?php echo $link['id']; ?>" /><input name="Submit" type="submit" class="submit" value="提交" /></td>
        </tr>
    </form>
</table>