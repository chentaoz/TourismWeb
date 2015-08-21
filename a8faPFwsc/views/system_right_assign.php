<script type="text/javascript">
$(document).ready(function() {
	$('#checkall').bind('click',function(){
		if($(this).attr('checked')){
			$(':checkbox').attr('checked','checked');
		}
		else{
			$(':checkbox').removeAttr('checked');
		}
	});
	$('.mod').bind('click',function(){
		if($(this).attr('checked')){
			$(this).parent().next().find(':checkbox').attr('checked','checked');
		}
		else{
			$(this).parent().next().find(':checkbox').removeAttr('checked');
		}
	});
});
</script>
</head><body>
<table>
  <tr>
    <th height="30" colspan="2" class="left">权限分派</th>
  </tr>
  <?php echo $form; ?>
  <?php foreach ($mod as $k=>$v){?>
  <tr>
    <td width="15%" class="b"><input type="checkbox" name="mod<?php echo $v['id']; ?>" class="radio mod" />&nbsp;&nbsp;<?php echo $v['name']; ?>：</td>
    <td>
      <?php foreach($v['rights'] as $i=>$j){?>
      <div class="table">
        <input type="checkbox" name="right<?php echo $j['rights']; ?>" value="<?php echo $j['rights'];?>" class="radio" <?php if(in_array($j['rights'],$rights)){echo 'checked=true';}?> />
        <?php echo $j['right_name'];?></div>
      <?php }?></td>
  </tr>
  <?php }?>
  <tr>
    <td class="right">全选：</td>
    <td class="left">
      <input type="checkbox" class="radio" id="checkall" name="checkall" />
    </td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input type="hidden" name="id" value="<?php echo $role; ?>" /><input type="submit" name="Submit" value="提交" class="submit" /></td>
  </tr>
    </form>
</table>
