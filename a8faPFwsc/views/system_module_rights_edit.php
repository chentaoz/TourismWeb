<script type="text/javascript">
$(document).ready(function() {
	$('#form1').validateMyForm();
});
</script>
</head>
<body>
<?php echo $form; ?>
<table>
  <tr>
    <th colspan="2">编辑权限</th>
  </tr>
  <tr>
    <td width="10%" class="right">名称：</td>
    <td><input name="name" type="text" id="name" class="required" value="<?php echo $rights->right_name; ?>" /></td>
  </tr>
  <tr>
    <td width="10%" class="right">权限码：</td>
    <td><input name="rights" type="text" id="rights" class="required" value="<?php echo $rights->rights; ?>" /></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input type="hidden" name="modid" value="<?php echo $rights->modid;?>" /><input type="hidden" name="id" value="<?php echo $rights->id;?>" /><input name="Submit" type="submit" class="submit" value="提交" /></td>
  </tr>
</table>
</form>
