<script type="text/javascript">
$(document).ready(function() {
	$('#form1').validateMyForm();
});
</script>
</head>
<body>
<table>
  <tr>
    <th height="30" colspan="2" class="left"><?php echo $lang['news_move']; ?></th>
  </tr>
  <?php echo $form; ?>
  <tr>
    <td width="10%" class="right"><?php echo $lang['news_classic']; ?>：</td>
    <td align="left"><select name="classic" id="classic" class="required">
          <option value=""><?php echo $lang['news_classic']; ?></option>
		  <?php foreach ($classic as $k=>$v){ ?>
          <optgroup label="<?php echo $v['name']; ?>"> <?php foreach($v['sclass'] as $i=>$j){ ?>
          <option value="<?php echo $j['id']; ?>"><?php echo $j['name']; ?></option>
          <?php } ?> </optgroup>
          <?php } ?>
        </select></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input type="hidden" name="ids" value="<?php echo $ids;?>" />
      <input type="submit" name="Submit" value="<?php echo $lang['submit']; ?>" class="submit" /></td>
  </tr>
    </form>
  
</table>
