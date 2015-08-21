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
    <th colspan="2"><?php echo $lang['sys_edit_psw']; ?></th>
  </tr>
  <tr>
    <td width="10%" class="right"><?php echo $lang['sys_old_psw']; ?>：</td>
    <td><input name="old_psw" type="password" id="old_psw" class="required" /></td>
  </tr>
  <tr>
    <td class="right" ><?php echo $lang['sys_new_psw']; ?>：</td>
    <td><input name="new_psw" type="password" id="new_psw" class="required" /></td>
  </tr>
  <tr>
    <td class="right"><?php echo $lang['sys_confir_psw']; ?>：</td>
    <td><input name="new_psw2" type="password" id="new_psw2" class="required" /></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input name="Submit" type="submit" class="submit" value="<?php echo $lang['submit']; ?>" /></td>
  </tr>
</table>
</form>
