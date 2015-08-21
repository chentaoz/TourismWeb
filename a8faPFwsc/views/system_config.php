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
    <th colspan="2"><?php echo $lang['sys_config']; ?></th>
  </tr>
  <tr>
    <td width="10%" class="right"><?php echo $lang['sys_title']; ?>：</td>
    <td><input type="text" name="title" id="title" value="<?php echo $configs['title']; ?>" class="ex300" /></td>
  </tr>
  <tr>
    <td class="right"><?php echo $lang['sys_keyword']; ?>：</td>
    <td><input type="text" name="keyword" id="keyword" value="<?php echo $configs['keyword']; ?>" class="ex500" /></td>
  </tr>
  <tr>
    <td class="right"><?php echo $lang['sys_description']; ?>：</td>
    <td><input type="text" name="description" id="description" value="<?php echo $configs['description']; ?>" class="ex500" /></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input name="Submit" type="submit" class="submit" value="<?php echo $lang['submit']; ?>" /></td>
  </tr>
</table>
</form>
