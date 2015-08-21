<script type="text/javascript">
$(document).ready(function() {
	$('#form1').validateMyForm();
});
</script>
</head>
<body>
<table>
  <tr>
    <th height="30" colspan="2" class="left"><?php echo $lang['news_class_edit_sub_page_title']; ?></th>
  </tr>
  <?php echo $form; ?>
  <tr>
    <td width="10%" class="right"><?php echo $lang['name']; ?>：</td>
    <td align="left"><input name="name" type="text" id="name" class="required" value="<?php echo $class['name']; ?>" /></td>
  </tr>
  <tr>
    <td width="10%" class="right"><?php echo $lang['sort']; ?>：</td>
    <td align="left"><input name="paixun" type="text" id="paixun" class="required" value="<?php echo $class['paixun']; ?>" /></td>
  </tr>
  <tr>
    <td class="center" colspan="2"><input type="hidden" name="id" value="<?php echo $class['id']; ?>" /><input type="submit" name="Submit" value="<?php echo $lang['submit']; ?>" class="submit" /></td>
  </tr>
    </form>
  
</table>