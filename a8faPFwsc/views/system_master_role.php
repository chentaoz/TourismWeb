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
    <th colspan="2">分派角色</th>
  </tr>
  <tr>
    <td width="10%" class="right">角色：</td>
    <td><select name="role" id="role">
    <option value="">请选择</option>
    <?php 
	foreach($role as $k=>$v){
		echo '<option value="'.$v['id'].'">'.$v['name'].'</option>';
	}
	?>
    </select></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input type="hidden" name="id" value="<?php echo $id; ?>" /><input name="Submit" type="submit" class="submit" value="提交" /></td>
  </tr>
</table>
</form>