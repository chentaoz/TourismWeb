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
	$('.menus').bind('click',function(){
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
    <th height="30" colspan="2" class="left">菜单分派</th>
  </tr>
  <?php echo $form; ?>
  <?php foreach ($menus as $k=>$v){?>
  <tr>
    <td width="15%" class="b"><input type="checkbox" name="<?php echo $v['id']; ?>" class="radio menus" />&nbsp;&nbsp;<?php echo $v['name']; ?>：</td>
    <td>
      <?php foreach($v['menu'] as $i=>$j){?>
      <div class="table">
        <input type="checkbox" name="menu<?php echo $j['id']; ?>" value="<?php echo $j['id'];?>" class="radio" <?php if(in_array($j['id'],$menu)){echo 'checked=true';}?> />
        <?php echo $j['name'];?></div>
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
