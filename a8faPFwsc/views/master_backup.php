<script type="text/javascript">
$(document).ready(function() {
	$('#checkall').bind('click',function(){
		if($(this).attr('checked')){
			$('.check').attr('checked','checked');
		}
		else{
			$('.check').removeAttr('checked');
		}
	});
});
</script>
</head><body>
<table>
  <tr>
    <th height="30" colspan="2" class="left">数据备份</th>
  </tr>
  <?php echo $form; ?>
  <tr>
    <td width="15%" class="right">请选择要备份的数据表：</td>
    <td><?php foreach ($tables as $k=>$v){?>
      <div class="table">
        <input type="checkbox" name="<?php echo $k; ?>" value="<?php echo $v;?>" class="radio check" />
        <?php echo $v;?></div>
      <?php }?></td>
  </tr>
  <tr>
    <td class="right">全选：</td>
    <td class="left">
      <input type="checkbox" class="radio" id="checkall" name="checkall" />&nbsp;<span class="fontcolorA">备份后的压缩包数据存放在后台目录下面的data文件夹下</span>
    </td>
  </tr>
  <tr>
    <td class="right">是否下载到本地：</td>
    <td class="left">
      <input type="checkbox" class="radio" id="local" name="local" value="1" />
    </td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input type="submit" name="Submit" value="提交" class="submit" /></td>
  </tr>
    </form>
  
</table>
